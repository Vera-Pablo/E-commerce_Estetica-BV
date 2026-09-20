<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\MetodoPagoModel;
use App\Models\VentaModel;
use App\Models\VentaDetalleModel;
class Carrito extends BaseController{
    private const TTL = 604800;

    protected ProductoModel $productoModel;
    protected MetodoPagoModel $metodoPagoModel;
    protected VentaModel $ventaModel;
    protected VentaDetalleModel $ventaDetalleModel;

    public function __construct(){
        $this->productoModel = new ProductoModel();
        $this->metodoPagoModel = new MetodoPagoModel();
        $this->ventaModel = new VentaModel();
        $this->ventaDetalleModel = new VentaDetalleModel();
    }
    
    // Lee el carrito desde la sesión o desde la cookie de respaldo si el usuario está autenticado.
    private function leerCarrito(): array{
        $carrito = session()->get('carrito');

        // Si no está en sesión y el usuario está autenticado, intentar recuperar de la cookie
        if (!is_array($carrito) && session()->get('isLoggedIn')) {
            $cookieCarrito = $this->request->getCookie('carrito_backup');
            if ($cookieCarrito) {
                $decodificado = json_decode(rawurldecode($cookieCarrito), true);
                if (is_array($decodificado)) {
                    $carrito = $decodificado;
                    session()->set('carrito', $carrito);
                }
            }
        }

        if (!is_array($carrito) || !isset($carrito['timestamp'], $carrito['items'])) {
            return ['timestamp' => time(), 'items' => []];
        }

        return $carrito;
    }

    // Guarda el carrito en la sesión y en la cookie de respaldo.
    private function guardarCarrito(array $carrito): void{
        session()->set('carrito', $carrito);

        // Usamos setrawcookie() nativo (independiente del Response de CI4) para que funcione tanto en respuestas HTML como JSON.
        setrawcookie(
            'carrito_backup',
            rawurlencode(json_encode($carrito)),
            time() + self::TTL,
            '/'
        );
    }

    // Verifica si el carrito ha expirado según el TTL. Si ha expirado, lo vacía y devuelve true; de lo contrario, devuelve false.
    private function verificarTTL(array &$carrito): bool{
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
     *
     * Retorna un array con:
     *   'warnings' => string[]  — Mensajes de advertencia acumulados.
     *   'dbMap'    => array     — Mapa id_producto => registro completo (precio, imagen, stock, nombre).
     *                            Solo contiene productos válidos tras el saneamiento.
     */
    private function sanearCarrito(array &$carrito): array
    {
        if (empty($carrito['items'])) {
            return ['warnings' => [], 'dbMap' => []];
        }

        $warnings = [];
        $ids      = array_keys($carrito['items']);

        $productoModel = new ProductoModel();

        // B1: Incluir precio e imagen en este SELECT para evitar consulta duplicada en index() y checkout()
        $dbItems = $productoModel
            ->select('producto.id_producto, producto.nombre_producto, producto.stock,
                      producto.estado_producto, producto.precio, producto.imagen,
                      categoria.estado_categoria')
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
                unset($dbMap[$id]); // Remover del mapa también
                continue;
            }

            $stock    = (int)$dbMap[$id]['stock'];
            $cantidad = (int)$carrito['items'][$id]['cantidad'];

            if ($stock === 0) {
                $warnings[] = "«{$dbMap[$id]['nombre_producto']}» fue eliminado del carrito: sin stock.";
                unset($carrito['items'][$id]);
                unset($dbMap[$id]);
            } elseif ($cantidad > $stock) {
                $warnings[] = "La cantidad de «{$dbMap[$id]['nombre_producto']}» fue ajustada a {$stock} (stock máximo disponible).";
                $carrito['items'][$id]['cantidad'] = $stock;
            }
        }

        if (!empty($warnings)) {
            $this->guardarCarrito($carrito);
        }

        return ['warnings' => $warnings, 'dbMap' => $dbMap];
    }

    // ENDPOINTS PÚBLICOS

    // GET /carrito — Muestra la vista del carrito.
    public function index(){
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

        // Saneamiento — B1: reutilizar el dbMap retornado (evita segunda consulta)
        $resultado = $this->sanearCarrito($carrito);
        $warnings  = $resultado['warnings'];
        $dbMap     = $resultado['dbMap'];

        // Mostrar advertencias acumuladas
        if (!empty($warnings)) {
            session()->setFlashdata('warning', implode(' | ', $warnings));
        }

        // Enriquecer ítems con datos ya cargados (sin nueva consulta a DB)
        $itemsEnriquecidos = [];
        $total             = 0.0;
        $totalItems        = 0;

        if (!empty($carrito['items'])) {
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
                    'id_producto'     => $id,
                    'nombre_producto' => $db['nombre_producto'],
                    'precio'          => $precio,
                    'imagen'          => $db['imagen'],
                    'stock'           => (int)$db['stock'],
                    'cantidad'        => $cantidad,
                    'subtotal'        => $subtotal,
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

    // POST /carrito/agregar — Agrega un producto al carrito.
    public function agregar(){
        $idProducto = (int)$this->request->getPost('id_producto');
        $cantidad   = (int)$this->request->getPost('cantidad');

        if ($idProducto <= 0 || $cantidad <= 0) {
            return redirect()->back()->with('error', 'Datos inválidos.');
        }

        // Verificar producto en DB
        $producto = $this->productoModel
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

    // POST /carrito/actualizar — AJAX: actualiza la cantidad de un producto | Devuelve JSON con subtotal, total general y totalItems.
    public function actualizar(){
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
        $producto = $this->productoModel
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
        $dbPrecio = $this->productoModel->select('precio')->where('id_producto', $idProducto)->first();
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

    // POST /carrito/eliminar — AJAX: elimina un producto del carrito | Devuelve JSON con total general y totalItems.
    public function eliminar(){
        $idProducto = (int)$this->request->getPost('id_producto');

        if ($idProducto <= 0) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Producto inválido.']);
        }

        $carrito = $this->leerCarrito();
        unset($carrito['items'][$idProducto]);
        $this->guardarCarrito($carrito);

        return $this->response->setJSON(array_merge(['ok' => true], $this->calcularTotales($carrito)));
    }

    // GET /carrito/checkout — Vista de checkout con saneamiento y verificación de TTL.
    public function checkout(){
        $carrito = $this->leerCarrito();

        if ($this->verificarTTL($carrito)) {
            return redirect()->to('carrito');
        }

        // B1: reutilizar dbMap del saneamiento — evita segunda consulta a DB
        $resultado = $this->sanearCarrito($carrito);
        if (!empty($resultado['warnings'])) {
            session()->setFlashdata('warning', implode(' | ', $resultado['warnings']));
        }

        if (empty($carrito['items'])) {
            return redirect()->to('carrito')->with('warning', 'Tu carrito está vacío.');
        }

        $dbMap             = $resultado['dbMap'];
        $itemsEnriquecidos = [];
        $total             = 0.0;
        $totalItems        = 0;

        $itemsCarrito = array_reverse($carrito['items'], true); // LIFO

        foreach ($itemsCarrito as $id => $item) {
            $id = (int)$id;
            if (!isset($dbMap[$id])) continue;

            $db        = $dbMap[$id];
            $cantidad  = (int)$item['cantidad'];
            $precio    = (float)$db['precio'];
            $subtotal  = $cantidad * $precio;

            $total      += $subtotal;
            $totalItems += $cantidad;

            $itemsEnriquecidos[] = [
                'id_producto'     => $id,
                'nombre_producto' => $db['nombre_producto'],
                'precio'          => $precio,
                'imagen'          => $db['imagen'],
                'cantidad'        => $cantidad,
                'subtotal'        => $subtotal,
            ];
        }

        $metodosPago = $this->metodoPagoModel->findAll();

        return view('public/checkout', [
            'title'       => 'Checkout - Estética BV',
            'items'       => $itemsEnriquecidos,
            'total'       => $total,
            'totalItems'  => $totalItems,
            'metodosPago' => $metodosPago
        ]);
    }

    // POST /carrito/procesar — Procesa la compra, inserta en DB y vacía el carrito.
    public function procesar(){
        $idMetodoPago = $this->request->getPost('id_metodo_pago');
        $tipoEntrega  = $this->request->getPost('tipo_entrega');

        if (!$idMetodoPago || !in_array($tipoEntrega, ['Envío a domicilio', 'Retiro en local'])) {
            return redirect()->back()->with('error', 'Debe seleccionar forma de entrega y método de pago válidos.');
        }

        $carrito = $this->leerCarrito();

        // B1: reutilizar dbMap del saneamiento — evita segunda consulta findAll() duplicada
        $resultado = $this->sanearCarrito($carrito);

        if (empty($carrito['items'])) {
            return redirect()->to('carrito')->with('warning', 'Tu carrito quedó vacío o los productos ya no están disponibles.');
        }

        $dbMap = $resultado['dbMap'];

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
        
        $idVenta = $this->ventaModel->insert([
            'total'           => $totalCalculado,
            'fecha_venta'     => date('Y-m-d'),
            'tipo_entrega'    => $tipoEntrega,
            'id_estado_venta' => 1, // 1 = Pendiente
            'id_metodo_pago'  => (int)$idMetodoPago,
            'id_usuario'      => (int)session()->get('id_usuario'),
        ], true); 

        foreach ($detallesAInsertar as &$det) {
            $det['id_venta'] = $idVenta;
        }
        $this->ventaDetalleModel->insertBatch($detallesAInsertar);

        foreach ($updatesStock as $upd) {
            $db->table('producto')
               ->where('id_producto', (int)$upd['id_producto'])
               ->set('stock', 'stock - ' . (int)$upd['cantidad'], false)
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

    // GET /carrito/checkout/confirmacion/{id_venta} — Muestra la confirmación de compra.
    public function confirmacion(int $id_venta){
        $venta = $this->ventaModel->select('venta.*, metodo_pago.nombre_metodo_pago')
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

    // HELPER PRIVADO: TOTALES

    // Calcula el total general y total de ítems del carrito. Devuelve un array con 'total', 'totalItems' y 'carritoVacio'.
    private function calcularTotales(array $carrito): array{
        $total      = 0.0;
        $totalItems = 0;

        if (!empty($carrito['items'])) {
            $ids = array_keys($carrito['items']);
            $rows = $this->productoModel->select('id_producto, precio')->whereIn('id_producto', $ids)->findAll();

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
