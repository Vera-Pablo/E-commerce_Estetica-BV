<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table            = 'rol';
    protected $primaryKey       = 'id_rol';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_rol'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre_rol' => 'required|min_length[3]|max_length[50]|is_unique[rol.nombre_rol,id_rol,{id_rol}]',
    ];
}
