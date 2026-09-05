<?php

namespace App\Controllers;

class MisCompras extends BaseController
{
    /**
     * GET /mis-compras — Lista las ventas del usuario logueado.
     */
    public function index()
    {
        $idUsuario = (int)session()->get('id_usuario');
        $db = \Config\Database::connect();

        $ventas = $db->table('venta v')
            ->select('v.id_venta, v.total, v.fecha_venta, v.tipo_entrega, v.id_estado_venta,
                      ev.nombre_estado,
                      mp.nombre_metodo_pago')
            ->join('estado_venta ev', 'ev.id_estado_venta = v.id_estado_venta', 'left')
            ->join('metodo_pago mp', 'mp.id_metodo_pago = v.id_metodo_pago', 'left')
            ->where('v.id_usuario', $idUsuario)
            ->orderBy('v.fecha_venta', 'DESC')
            ->get()->getResultArray();

        return view('public/mis_compras', [
            'title'  => 'Mis Compras - Estética BV',
            'ventas' => $ventas,
        ]);
    }

    /**
     * GET /mis-compras/detalle/(:num) — Endpoint JSON del detalle de una venta.
     */
    public function detalle($idVenta)
    {
        $idVenta   = (int)$idVenta;
        $idUsuario = (int)session()->get('id_usuario');
        $db = \Config\Database::connect();

        // Seguridad: verificar que la venta pertenezca al usuario autenticado
        $venta = $db->table('venta v')
            ->select('v.id_venta, v.total, v.fecha_venta, v.tipo_entrega, v.id_estado_venta,
                      ev.nombre_estado,
                      mp.nombre_metodo_pago')
            ->join('estado_venta ev', 'ev.id_estado_venta = v.id_estado_venta', 'left')
            ->join('metodo_pago mp', 'mp.id_metodo_pago = v.id_metodo_pago', 'left')
            ->where('v.id_venta', $idVenta)
            ->where('v.id_usuario', $idUsuario) // <-- clave de seguridad
            ->get()->getRowArray();

        if (!$venta) {
            return $this->response->setJSON(['error' => 'Pedido no encontrado.'])->setStatusCode(404);
        }

        $detalles = $db->table('venta_detalle vd')
            ->select('vd.cantidad, vd.precio_unitario, vd.subtotal, p.nombre_producto')
            ->join('producto p', 'p.id_producto = vd.id_producto', 'left')
            ->where('vd.id_venta', $idVenta)
            ->get()->getResultArray();

        return $this->response->setJSON([
            'venta'    => $venta,
            'detalles' => $detalles,
        ]);
    }
}
