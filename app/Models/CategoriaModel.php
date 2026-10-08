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
        'id_categoria'          => 'permit_empty|is_natural_no_zero',
        'nombre_categoria'      => [
            'rules'  => 'required|min_length[3]|max_length[100]|is_unique[categoria.nombre_categoria,id_categoria,{id_categoria}]',
            'errors' => [
                'required'   => 'El nombre de la categoría es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 100 caracteres.',
                'is_unique'  => 'Ya existe una categoría con ese nombre.',
            ],
        ],
        'descripcion_categoria' => [
            'rules'  => 'permit_empty|min_length[5]|max_length[255]',
            'errors' => [
                'min_length' => 'La descripción debe tener al menos 5 caracteres.',
                'max_length' => 'La descripción no puede superar los 255 caracteres.',
            ],
        ],
        'estado_categoria'      => 'permit_empty|integer|in_list[0,1]',
    ];
}
