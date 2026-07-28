<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadoVentaModel extends Model
{
    protected $table            = 'estado_venta';
    protected $primaryKey       = 'id_estado_venta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_estado'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre_estado' => 'required|min_length[3]|max_length[100]|is_unique[estado_venta.nombre_estado,id_estado_venta,{id_estado_venta}]',
    ];
}
