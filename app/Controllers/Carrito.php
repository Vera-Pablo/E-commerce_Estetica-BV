<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\MetodoPagoModel;
use App\Models\VentaModel;
use App\Models\VentaDetalleModel;

/**
 * Carrito — Gestión del carrito de compras en sesión.
 *
 * Estructura de sesión:
 * $_SESSION['carrito'] = [
 *     'timestamp' => <unix>,
 *     'items'     => [ id_producto => ['id_producto' => X, 'cantidad' => N], ... ]
 * ]
 */
class Carrito extends BaseController
{
    /** TTL del carrito: 7 días en segundos */
    private const TTL = 604800;

    // ----------------------------------------------------------------
    // HELPERS INTERNOS
    // ----------------------------------------------------------------

    /**
     * Lee el carrito de la sesión. Devuelve la estructura normalizada.
     */
    private function leerCarrito(): array
    {
        $carrito = session()->get('carrito');

        if (!is_array($carrito) || !isset($carrito['timestamp'], $carrito['items'])) {
            return ['timestamp' => time(), 'items' => []];
        }

        return $carrito;
    }

    /**
     * Persiste el carrito en la sesión.
     */
    private function guardarCarrito(array $carrito): void
    {
        session()->set('carrito', $carrito);
    }

    /**
     * Verifica el TTL. Si expiró, limpia el carrito y avisa.
     * Devuelve true si fue limpiado.
     */
    private function verificarTTL(array &$carrito): bool
    {
        if ((time() - $carrito['timestamp']) > self::TTL) {
            $carrito = ['timestamp' => time(), 'items' => []];
            $this->guardarCarrito($carrito);
            session()->setFlashdata('warning', 'Tu carrito expiró después de 7 días y fue vaciado.');
            return true;
        }
        return false;
    }

    /**
     * Sanea el carrito contra la DB:
     * - Elimina productos desactivados o de categoría inactiva.
     * - Ajusta cantidades si el stock bajó.
     * Acumula mensajes de advertencia en $warnings.
     */
    private function sanearCarrito(array &$carrito): array
    {
        if (empty($carrito['items'])) {
            return [];
        }

        $warnings   = [];
        $ids        = array_keys($carrito['items']);

        $productoModel = new ProductoModel();

        $dbItems = $productoModel
            ->select('producto.id_producto, producto.nombre_producto, producto.stock, producto.estado_producto, categoria.estado_categoria')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->whereIn('producto.id_producto', $ids)
            ->findAll();

        // Indexar por id para acceso O(1)
        $dbMap = [];
        foreach ($dbItems as $row) {
            $dbMap[(int)$row['id_producto']] = $row;
        }

        foreach ($ids as $id) {
            $id = (int)$id;

            // Producto no encontrado, desactivado o categoría inactiva
            if (!isset($dbMap[$id]) || (int)$dbMap[$id]['estado_producto'] !== 1 || (int)$dbMap[$id]['estado_categoria'] !== 1) {
                $nombre = $dbMap[$id]['nombre_producto'] ?? "ID #{$id}";
                $warnings[] = "«{$nombre}» fue eliminado del carrito porque ya no está disponible.";
                unset($carrito['items'][$id]);
                continue;
            }

            $stock    = (int)$dbMap[$id]['stock'];
            $cantidad = (int)$carrito['items'][$id]['cantidad'];

            if ($stock === 0) {
                $warnings[] = "«{$dbMap[$id]['nombre_producto']}» fue eliminado del carrito: sin stock.";
                unset($carrito['items'][$id]);
            } elseif ($cantidad > $stock) {
                $warnings[] = "La cantidad de «{$dbMap[$id]['nombre_producto']}» fue ajustada a {$stock} (stock máximo disponible).";
                $carrito['items'][$id]['cantidad'] = $stock;
            }
        }

        if (!empty($warnings)) {
            $this->guardarCarrito($carrito);
        }

        return $warnings;
    }

    // ----------------------------------------------------------------
    // ENDPOINTS PÚBLICOS
    // ----------------------------------------------------------------

    /**
     * GET /carrito — Vista del carrito con saneamiento.
     */
    public function index()
    {
        $carrito = $this->leerCarrito();

        // TTL
        if ($this->verificarTTL($carrito)) {
            return view('public/carrito', [
                'title'      => 'Mi Carrito - Estética BV',
                'items'      => [],
                'total'      => 0,
                'totalItems' => 0,
            ]);
        }

        // Saneamiento
        $warnings = $this->sanearCarrito($carrito);

        // Mostrar advertencias acumuladas (concatenadas en un único flash)
        if (!empty($warnings)) {
            session()->setFlashdata('warning', implode(' | ', $warnings));
        }

        // Enriquecer ítems con datos actuales de la DB
        $itemsEnriquecidos = [];
        $total             = 0.0;
        $totalItems        = 0;

        if (!empty($carrito['items'])) {
            $ids = array_keys($carrito['items']);

            $productoModel = new ProductoModel();
            $dbItems = $productoModel
                ->select('producto.id_producto, producto.nombre_producto, producto.precio, producto.imagen, producto.stock')
                ->whereIn('producto.id_producto', $ids)
                ->findAll();

            $dbMap = [];
            foreach ($dbItems as $row) {
                $dbMap[(int)$row['id_producto']] = $row;
            }

            // LIFO: invertir para mostrar últimos agregados primero
            $itemsCarrito = array_reverse($carrito['items'], true);

            foreach ($itemsCarrito as $id => $item) {
                $id = (int)$id;
                if (!isset($dbMap[$id])) {
                    continue;
                }
                $db        = $dbMap[$id];
                $cantidad  = (int)$item['cantidad'];
                $precio    = (float)$db['precio'];
                $subtotal  = $cantidad * $precio;
                $total    += $subtotal;
                $totalItems += $cantidad;

                $itemsEnriquecidos[] = [
                    'id_producto'    => $id,
                    'nombre_producto'=> $db['nombre_producto'],
                    'precio'         => $precio,
                    'imagen'         => $db['imagen'],
                    'stock'          => (int)$db['stock'],
                    'cantidad'       => $cantidad,
                    'subtotal'       => $subtotal,
                ];
            }
        }

        return view('public/carrito', [
            'title'      => 'Mi Carrito - Estética BV',
            'items'      => $itemsEnriquecidos,
            'total'      => $total,
            'totalItems' => $totalItems,
        ]);
    }

    /**
     * POST /carrito/agregar — Agrega un producto al carrito.
     */
    public function agregar()
    {
        $idProducto = (int)$this->request->getPost('id_producto');
        $cantidad   = (int)$this->request->getPost('cantidad');

        if ($idProducto <= 0 || $cantidad <= 0) {
            return redirect()->back()->with('error', 'Datos inválidos.');
        }

        // Verificar producto en DB
        $productoModel = new ProductoModel();
        $producto = $productoModel
            ->select('producto.id_producto, producto.nombre_producto, producto.stock, producto.estado_producto, categoria.estado_categoria')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->where('producto.id_producto', $idProducto)
            ->first();

        if (!$producto || (int)$producto['estado_producto'] !== 1 || (int)$producto['estado_categoria'] !== 1) {
            return redirect()->back()->with('error', 'El producto no está disponible.');
        }

        $stock = (int)$producto['stock'];

        if ($stock === 0) {
            return redirect()->back()->with('error', "«{$producto['nombre_producto']}» no tiene stock disponible.");
        }

        $carrito = $this->leerCarrito();
        $this->verificarTTL($carrito);

        // Inicializar timestamp si es el primer ítem
        if (empty($carrito['items'])) {
            $carrito['timestamp'] = time();
        }

        $cantidadActual = (int)($carrito['items'][$idProducto]['cantidad'] ?? 0);
        $nuevaCantidad  = $cantidadActual + $cantidad;

        $warning = null;
        if ($nuevaCantidad > $stock) {
            $nuevaCantidad = $stock;
            $warning = "La cantidad fue ajustada al máximo disponible ({$stock} unidades).";
        }

        $carrito['items'][$idProducto] = [
            'id_producto' => $idProducto,
            'cantidad'    => $nuevaCantidad,
        ];

        $this->guardarCarrito($carrito);

        if ($warning) {
            session()->setFlashdata('warning', $warning);
        } else {
            session()->setFlashdata('success', "«{$producto['nombre_producto']}» agregado al carrito.");
        }

        return redirect()->back();
    }

    /**
     * POST /carrito/actualizar — AJAX: actualiza la cantidad de un producto.
     * Devuelve JSON con subtotal, total general y totalItems.
     */
    public function actualizar()
    {
        $idProducto   = (int)$this->request->getPost('id_producto');
        $nuevaCantidad = (int)$this->request->getPost('nueva_cantidad');

        if ($idProducto <= 0) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Producto inválido.']);
        }

        // Si la cantidad es < 1, eliminar el producto
        if ($nuevaCantidad < 1) {
            $carrito = $this->leerCarrito();
            unset($carrito['items'][$idProducto]);
            $this->guardarCarrito($carrito);
            return $this->response->setJSON(array_merge(['ok' => true, 'eliminado' => true], $this->calcularTotales($carrito)));
        }

        // Verificar stock en tiempo real
        $productoModel = new ProductoModel();
        $producto = $productoModel
            ->select('id_producto, stock')
            ->where('id_producto', $idProducto)
            ->where('estado_producto', 1)
            ->first();

        if (!$producto) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Producto no disponible.']);
        }

        $stock         = (int)$producto['stock'];
        $stockExcedido = false;

        if ($nuevaCantidad > $stock) {
            $nuevaCantidad = $stock;
            $stockExcedido = true;
        }

        $carrito = $this->leerCarrito();

        if (!isset($carrito['items'][$idProducto])) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Producto no encontrado en el carrito.']);
        }

        $carrito['items'][$idProducto]['cantidad'] = $nuevaCantidad;
        $this->guardarCarrito($carrito);

        // Obtener precio para calcular subtotal
        $dbPrecio = $productoModel->select('precio')->where('id_producto', $idProducto)->first();
        $precio   = (float)($dbPrecio['precio'] ?? 0);
        $subtotal = $nuevaCantidad * $precio;

        $totales = $this->calcularTotales($carrito);

        return $this->response->setJSON(array_merge([
            'ok'            => true,
            'nueva_cantidad'=> $nuevaCantidad,
            'subtotal'      => $subtotal,
            'max_stock'     => $stock,
            'stock_excedido'=> $stockExcedido,
        ], $totales));
    }

    /**
     * POST /carrito/eliminar — AJAX: elimina un producto del carrito.
     * Devuelve JSON con totales actualizados.
     */
    public function eliminar()
    {
        $idProducto = (int)$this->request->getPost('id_producto');

        if ($idProducto <= 0) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Producto inválido.']);
        }

        $carrito = $this->leerCarrito();
        unset($carrito['items'][$idProducto]);
        $this->guardarCarrito($carrito);

        return $this->response->setJSON(array_merge(['ok' => true], $this->calcularTotales($carrito)));
    }

    /**
     * GET /carrito/checkout — Vista de checkout.
     */
    public function checkout()
    {
        $carrito = $this->leerCarrito();

        if ($this->verificarTTL($carrito)) {
            return redirect()->to('carrito');
        }

        $warnings = $this->sanearCarrito($carrito);
        if (!empty($warnings)) {
            session()->setFlashdata('warning', implode(' | ', $warnings));
        }

        if (empty($carrito['items'])) {
            return redirect()->to('carrito')->with('warning', 'Tu carrito está vacío.');
        }

        $itemsEnriquecidos = [];
        $total             = 0.0;
        $totalItems        = 0;

        $ids = array_keys($carrito['items']);
        $productoModel = new ProductoModel();
        $dbItems = $productoModel
            ->select('id_producto, nombre_producto, precio, imagen, stock')
            ->whereIn('id_producto', $ids)
            ->findAll();

        $dbMap = [];
        foreach ($dbItems as $row) {
            $dbMap[(int)$row['id_producto']] = $row;
        }

        $itemsCarrito = array_reverse($carrito['items'], true); // LIFO

        foreach ($itemsCarrito as $id => $item) {
            $id = (int)$id;
            if (!isset($dbMap[$id])) continue;
            
            $db        = $dbMap[$id];
            $cantidad  = (int)$item['cantidad'];
            $precio    = (float)$db['precio'];
            $subtotal  = $cantidad * $precio;
            
            $total    += $subtotal;
            $totalItems += $cantidad;

            $itemsEnriquecidos[] = [
                'id_producto'    => $id,
                'nombre_producto'=> $db['nombre_producto'],
                'precio'         => $precio,
                'imagen'         => $db['imagen'],
                'cantidad'       => $cantidad,
                'subtotal'       => $subtotal,
            ];
        }

        $metodosPago = (new MetodoPagoModel())->findAll();

        return view('public/checkout', [
            'title'       => 'Checkout - Estética BV',
            'items'       => $itemsEnriquecidos,
            'total'       => $total,
            'totalItems'  => $totalItems,
            'metodosPago' => $metodosPago
        ]);
    }

    /**
     * POST /carrito/checkout/procesar — Procesa la compra atómicamente.
     */
    public function procesar()
    {
        $idMetodoPago = $this->request->getPost('id_metodo_pago');
        $tipoEntrega  = $this->request->getPost('tipo_entrega');

        if (!$idMetodoPago || !in_array($tipoEntrega, ['Envío a domicilio', 'Retiro en local'])) {
            return redirect()->back()->with('error', 'Debe seleccionar forma de entrega y método de pago válidos.');
        }

        $carrito = $this->leerCarrito();
        $this->sanearCarrito($carrito); 

        if (empty($carrito['items'])) {
            return redirect()->to('carrito')->with('warning', 'Tu carrito quedó vacío o los productos ya no están disponibles.');
        }

        $ids = array_keys($carrito['items']);
        $productoModel = new ProductoModel();
        $productosDb = $productoModel->whereIn('id_producto', $ids)->findAll();
        
        $dbMap = [];
        foreach ($productosDb as $p) {
            $dbMap[(int)$p['id_producto']] = $p;
        }

        $totalCalculado    = 0.0;
        $detallesAInsertar = [];
        $updatesStock      = [];

        foreach ($carrito['items'] as $id => $item) {
            $id = (int)$id;
            if (!isset($dbMap[$id])) {
                return redirect()->to('carrito')->with('error', 'Inconsistencia en el carrito.');
            }
            
            $cantidad    = (int)$item['cantidad'];
            $stockActual = (int)$dbMap[$id]['stock'];

            if ($cantidad > $stockActual) {
                return redirect()->to('carrito')->with('warning', 'El stock de un producto cambió durante la compra.');
            }

            $precio   = (float)$dbMap[$id]['precio'];
            $subtotal = $precio * $cantidad;
            $totalCalculado += $subtotal;

            $detallesAInsertar[] = [
                'id_producto'     => $id,
                'cantidad'        => $cantidad,
                'precio_unitario' => $precio,
                'subtotal'        => $subtotal
            ];

            $updatesStock[] = [
                'id_producto' => $id,
                'cantidad'    => $cantidad
            ];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $ventaModel = new VentaModel();
        $idVenta = $ventaModel->insert([
            'total'           => $totalCalculado,
            'fecha_venta'     => date('Y-m-d'),
            'tipo_entrega'    => $tipoEntrega,
            'id_estado_venta' => 1, // 1 = Pendiente
            'id_metodo_pago'  => (int)$idMetodoPago,
            'id_usuario'      => (int)session()->get('id_usuario'),
        ], true); 

        $ventaDetalleModel = new VentaDetalleModel();
        foreach ($detallesAInsertar as &$det) {
            $det['id_venta'] = $idVenta;
        }
        $ventaDetalleModel->insertBatch($detallesAInsertar);

        foreach ($updatesStock as $upd) {
            $db->table('producto')
               ->where('id_producto', $upd['id_producto'])
               ->set('stock', "stock - {$upd['cantidad']}", false)
               ->update();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('carrito/checkout')->with('error', 'Ocurrió un error al procesar la compra. Inténtalo de nuevo.');
        }

        $this->guardarCarrito(['timestamp' => time(), 'items' => []]);

        return redirect()->to("carrito/checkout/confirmacion/{$idVenta}")
                         ->with('success', '¡Compra finalizada con éxito!');
    }

    /**
     * GET /carrito/checkout/confirmacion/(:num) — Vista de confirmación de compra.
     */
    public function confirmacion($id_venta)
    {
        $ventaModel = new VentaModel();
        $venta = $ventaModel->select('venta.*, metodo_pago.nombre_metodo_pago')
            ->join('metodo_pago', 'metodo_pago.id_metodo_pago = venta.id_metodo_pago')
            ->where('id_venta', $id_venta)
            ->where('id_usuario', session()->get('id_usuario'))
            ->first();

        if (!$venta) {
            return redirect()->to('/')->with('error', 'Venta no encontrada.');
        }

        $db = \Config\Database::connect();
        $detalles = $db->table('venta_detalle vd')
            ->select('vd.*, p.nombre_producto')
            ->join('producto p', 'p.id_producto = vd.id_producto')
            ->where('vd.id_venta', $id_venta)
            ->get()->getResultArray();

        return view('public/checkout_confirmacion', [
            'title'    => 'Confirmación de Compra - Estética BV',
            'venta'    => $venta,
            'detalles' => $detalles
        ]);
    }

    // ----------------------------------------------------------------
    // HELPER PRIVADO: TOTALES
    // ----------------------------------------------------------------

    /**
     * Calcula total general y cantidad total de ítems.
     * Necesita consultar precios de la DB para calcular correctamente.
     */
    private function calcularTotales(array $carrito): array
    {
        $total      = 0.0;
        $totalItems = 0;

        if (!empty($carrito['items'])) {
            $ids = array_keys($carrito['items']);
            $productoModel = new ProductoModel();
            $rows = $productoModel->select('id_producto, precio')->whereIn('id_producto', $ids)->findAll();

            $precios = [];
            foreach ($rows as $row) {
                $precios[(int)$row['id_producto']] = (float)$row['precio'];
            }

            foreach ($carrito['items'] as $id => $item) {
                $precio  = $precios[(int)$id] ?? 0;
                $cant    = (int)$item['cantidad'];
                $total  += $precio * $cant;
                $totalItems += $cant;
            }
        }

        return [
            'total'       => $total,
            'totalItems'  => $totalItems,
            'carritoVacio'=> empty($carrito['items']),
        ];
    }
}
