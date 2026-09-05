<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VentaModel;
use App\Models\VentaDetalleModel;
use App\Models\EstadoVentaModel;
use App\Models\MetodoPagoModel;

class Venta extends BaseController
{
    /**
     * Muestra el listado de ventas con datos relacionales.
     * Soporta búsqueda por ID exacto, filtro por estado, método de pago y ordenamiento.
     * Ruta: GET /admin/ventas
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // Parámetros de búsqueda y filtro desde GET
        $searchId    = $this->request->getGet('search_id');
        $filtroEstado = $this->request->getGet('estado');
        $filtroPago   = $this->request->getGet('metodo_pago');
        $orden        = $this->request->getGet('orden') ?? 'desc';

        // Consulta relacional: venta + usuario + estado + método de pago
        $builder = $db->table('venta v')
            ->select('v.id_venta, v.total, v.fecha_venta, v.tipo_entrega, v.id_estado_venta, v.id_metodo_pago, v.id_usuario,
                      u.apellido_nombre, u.dni,
                      ev.nombre_estado,
                      mp.nombre_metodo_pago')
            ->join('usuario u', 'u.id_usuario = v.id_usuario', 'left')
            ->join('estado_venta ev', 'ev.id_estado_venta = v.id_estado_venta', 'left')
            ->join('metodo_pago mp', 'mp.id_metodo_pago = v.id_metodo_pago', 'left');

        // Búsqueda por ID exacto de venta
        if (!empty($searchId) && is_numeric($searchId)) {
            $builder->where('v.id_venta', (int)$searchId);
        }

        // Filtro por estado de venta
        if (!empty($filtroEstado)) {
            $builder->where('v.id_estado_venta', $filtroEstado);
        }

        // Filtro por método de pago
        if (!empty($filtroPago)) {
            $builder->where('v.id_metodo_pago', $filtroPago);
        }

        // Ordenamiento por fecha (asc / desc)
        $ordenDir = ($orden === 'asc') ? 'ASC' : 'DESC';
        $builder->orderBy('v.fecha_venta', $ordenDir);

        $ventas = $builder->get()->getResultArray();

        // Cargar listas para los filtros del formulario
        $estadoVentaModel = new EstadoVentaModel();
        $metodoPagoModel  = new MetodoPagoModel();

        $estados     = $estadoVentaModel->findAll();
        $metodosPago = $metodoPagoModel->findAll();

        return view('admin/ventas', [
            'title'       => 'Administrar Ventas - Panel Admin',
            'ventas'      => $ventas,
            'estados'     => $estados,
            'metodosPago' => $metodosPago,
            'search_id'   => $searchId,
            'estado'      => $filtroEstado,
            'metodo_pago' => $filtroPago,
            'orden'       => $orden,
        ]);
    }

    /**
     * Devuelve el detalle completo de una venta en JSON (para el modal del recibo).
     * Incluye los items del detalle con nombre del producto, cantidad, precio unitario y subtotal.
     * Ruta: GET /admin/ventas/detalle/(:num)
     *
     * @param int $id_venta
     */
    public function detalle($id_venta)
    {
        $db = \Config\Database::connect();

        // Traer la venta con datos relacionales
        $venta = $db->table('venta v')
            ->select('v.id_venta, v.total, v.fecha_venta, v.tipo_entrega,
                      u.apellido_nombre, u.dni, u.email,
                      ev.nombre_estado,
                      mp.nombre_metodo_pago')
            ->join('usuario u', 'u.id_usuario = v.id_usuario', 'left')
            ->join('estado_venta ev', 'ev.id_estado_venta = v.id_estado_venta', 'left')
            ->join('metodo_pago mp', 'mp.id_metodo_pago = v.id_metodo_pago', 'left')
            ->where('v.id_venta', $id_venta)
            ->get()->getRowArray();

        if (!$venta) {
            return $this->response->setJSON(['error' => 'Venta no encontrada.'])->setStatusCode(404);
        }

        // Traer los items del detalle con nombre del producto
        $detalles = $db->table('venta_detalle vd')
            ->select('vd.cantidad, vd.precio_unitario, vd.subtotal, p.nombre_producto')
            ->join('producto p', 'p.id_producto = vd.id_producto', 'left')
            ->where('vd.id_venta', $id_venta)
            ->get()->getResultArray();

        return $this->response->setJSON([
            'venta'    => $venta,
            'detalles' => $detalles,
        ]);
    }
}
