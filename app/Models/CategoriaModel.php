<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'categoria';
    protected $primaryKey       = 'id_categoria';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_categoria', 'descripcion_categoria', 'estado_categoria'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre_categoria'      => 'required|min_length[3]|max_length[255]|is_unique[categoria.nombre_categoria,id_categoria,{id_categoria}]',
        'descripcion_categoria' => 'permit_empty|max_length[500]',
        'estado_categoria'      => 'permit_empty|integer|in_list[0,1]',
    ];
}
