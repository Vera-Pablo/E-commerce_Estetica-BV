<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table            = 'producto';
    protected $primaryKey       = 'id_producto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_producto', 'descripcion_producto', 'precio', 'stock', 'imagen', 'estado_producto', 'id_categoria'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre_producto'      => 'required|min_length[3]|max_length[255]|is_unique[producto.nombre_producto,id_producto,{id_producto}]',
        'descripcion_producto' => 'permit_empty|max_length[500]',
        'precio'               => 'required|decimal',
        'stock'                => 'required|integer|greater_than_equal_to[0]',
        'imagen'               => 'permit_empty|max_length[500]',
        'estado_producto'      => 'permit_empty|integer|in_list[0,1]',
        'id_categoria'         => 'required|integer',
    ];

    public function getProductosAleatorios(int $limit = 12): array
    {
        return $this->where('estado_producto', 1)
                    ->orderBy('RAND()')
                    ->limit($limit)
                    ->findAll();
    }
}
