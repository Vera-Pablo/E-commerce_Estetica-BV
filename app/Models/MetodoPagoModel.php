<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodoPagoModel extends Model
{
    protected $table            = 'metodo_pago';
    protected $primaryKey       = 'id_metodo_pago';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_metodo_pago'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre_metodo_pago' => 'required|min_length[3]|max_length[100]|is_unique[metodo_pago.nombre_metodo_pago,id_metodo_pago,{id_metodo_pago}]',
    ];
}
