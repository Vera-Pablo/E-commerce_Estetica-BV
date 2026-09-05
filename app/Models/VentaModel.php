<?php

namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table            = 'venta';
    protected $primaryKey       = 'id_venta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['total', 'fecha_venta', 'tipo_entrega', 'id_estado_venta', 'id_metodo_pago', 'id_usuario'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'total'           => 'required|decimal',
        'fecha_venta'     => 'required|valid_date',
        'tipo_entrega'    => 'required|in_list[Envío a domicilio,Retiro en local]',
        'id_estado_venta' => 'required|integer',
        'id_metodo_pago'  => 'required|integer',
        'id_usuario'      => 'required|integer',
    ];
}
