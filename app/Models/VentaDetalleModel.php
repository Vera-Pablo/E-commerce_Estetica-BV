<?php

namespace App\Models;

use CodeIgniter\Model;

class VentaDetalleModel extends Model
{
    protected $table            = 'venta_detalle';
    protected $primaryKey       = 'id_venta_detalle';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['cantidad', 'precio_unitario', 'subtotal', 'id_producto', 'id_venta'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'cantidad'        => 'required|integer|greater_than[0]',
        'precio_unitario' => 'required|decimal',
        'subtotal'        => 'required|decimal',
        'id_producto'     => 'required|integer',
        'id_venta'        => 'required|integer',
    ];
}
