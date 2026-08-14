<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Catalogo extends BaseController
{
    /**
     * Muestra la vista principal del catálogo con los productos y categorías disponibles.
     */
    public function index()
    {
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        // Obtener solo categorías activas para el select del filtro
        $categorias = $categoriaModel->where('estado_categoria', 1)->findAll();

        // Obtener productos activos de categorías activas
        $productos = $productoModel->select('producto.*, categoria.nombre_categoria')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->where('producto.estado_producto', 1)
            ->where('categoria.estado_categoria', 1)
            ->findAll();

        return view('public/catalogo', [
            'title'      => 'Catálogo de Productos - Estética BV',
            'productos'  => $productos,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Endpoint AJAX para filtrar los productos por búsqueda y categoría.
     * Responde con formato JSON.
     */
    public function filtrar()
    {
        $search = $this->request->getGet('search');
        $id_categoria = $this->request->getGet('categoria');

        $productoModel = new ProductoModel();

        // Query base: productos activos de categorías activas
        // Se devuelven solo los campos necesarios para renderizar las cards del catálogo
        $builder = $productoModel->select('producto.id_producto, producto.nombre_producto, producto.precio, producto.imagen')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->where('producto.estado_producto', 1)
            ->where('categoria.estado_categoria', 1);

        // Aplicar filtros si existen
        if (!empty($search)) {
            $builder->like('producto.nombre_producto', $search);
        }

        if (!empty($id_categoria)) {
            $builder->where('producto.id_categoria', $id_categoria);
        }

        $resultados = $builder->findAll();

        return $this->response->setJSON($resultados);
    }
}
