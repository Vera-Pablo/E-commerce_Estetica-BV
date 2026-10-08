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
    protected $allowedFields    = [
        'codigo_producto',
        'nombre_producto',
        'descripcion_producto',
        'precio',
        'stock',
        'imagen',
        'estado_producto',
        'id_categoria',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'id_producto'          => 'permit_empty|is_natural_no_zero',
        'codigo_producto'      => [
            'rules'  => 'required|min_length[3]|max_length[50]|regex_match[/^[A-Za-z0-9\-_]+$/]|is_unique[producto.codigo_producto,id_producto,{id_producto}]',
            'errors' => [
                'required'    => 'El código de producto es obligatorio.',
                'min_length'  => 'El código debe tener al menos 3 caracteres.',
                'max_length'  => 'El código no puede superar los 50 caracteres.',
                'regex_match' => 'El código solo puede contener letras, números, guiones y guiones bajos.',
                'is_unique'   => 'Ya existe un producto registrado con este código.',
            ],
        ],
        'nombre_producto'      => [
            'rules'  => 'required|min_length[3]|max_length[255]|is_unique[producto.nombre_producto,id_producto,{id_producto}]',
            'errors' => [
                'required'   => 'El nombre del producto es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 255 caracteres.',
                'is_unique'  => 'Ya existe un producto con ese nombre.',
            ],
        ],
        'descripcion_producto'  => [
            'rules'  => 'required|min_length[10]|max_length[500]',
            'errors' => [
                'required'   => 'La descripción del producto es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 10 caracteres.',
                'max_length' => 'La descripción no puede superar los 500 caracteres.',
            ],
        ],
        'precio'               => [
            'rules'  => 'required|numeric|greater_than[0]',
            'errors' => [
                'required'     => 'El precio es obligatorio.',
                'numeric'      => 'El precio debe ser un número válido.',
                'greater_than' => 'El precio debe ser mayor a 0.',
            ],
        ],
        'stock'                => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'   => 'El stock es obligatorio.',
                'is_natural' => 'El stock debe ser un número entero mayor o igual a 0.',
            ],
        ],
        'imagen'               => [
            'rules'  => 'permit_empty|valid_url|max_length[500]',
            'errors' => [
                'valid_url'  => 'La imagen debe ser una URL válida.',
                'max_length' => 'La URL de imagen no puede superar los 500 caracteres.',
            ],
        ],
        'estado_producto'      => 'permit_empty|integer|in_list[0,1]',
        'id_categoria'         => [
            'rules'  => 'required|is_natural_no_zero',
            'errors' => [
                'required'          => 'Debe seleccionar una categoría.',
                'is_natural_no_zero'=> 'Debe seleccionar una categoría válida.',
            ],
        ],
    ];

    public function getProductosAleatorios(int $limit = 12): array
    {
        return $this->where('estado_producto', 1)
                    ->orderBy('RAND()')
                    ->limit($limit)
                    ->findAll();
    }

    public function getProductosSimilares(int $id_categoria, int $id_producto_actual, int $limit = 12): array
    {
        return $this->where('id_categoria', $id_categoria)
                    ->where('id_producto !=', $id_producto_actual)
                    ->where('estado_producto', 1)
                    ->orderBy('RAND()')
                    ->limit($limit)
                    ->findAll();
    }
}
