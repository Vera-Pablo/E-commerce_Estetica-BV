<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Producto extends BaseController{

    protected ProductoModel $productoModel;
    protected CategoriaModel $categoriaModel;

    public function __construct(){
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    // Muestra la lista de productos con opciones de búsqueda y filtrado.
    public function index(){
        $search      = $this->request->getGet('search');
        $stockFilter = $this->request->getGet('stock_filter');

        $this->productoModel->select('producto.*, categoria.nombre_categoria');
        $this->productoModel->join('categoria', 'categoria.id_categoria = producto.id_categoria', 'left');

        if (!empty($search)) {
            $this->productoModel->like('producto.nombre_producto', $search);
        }

        if ($stockFilter !== null && $stockFilter !== '') {
            if ($stockFilter === 'low') {
                $this->productoModel->where('producto.stock <=', 5);
                $this->productoModel->where('producto.stock >', 0);
            } elseif ($stockFilter === 'out') {
                $this->productoModel->where('producto.stock', 0);
            }
        }

        $productos = $this->productoModel->findAll();

        $cache = \Config\Services::cache();
        $categorias = $cache->get('categorias_activas_admin');
        if ($categorias === null) {
            $categorias = $this->categoriaModel->where('estado_categoria', 1)->findAll();
            $cache->save('categorias_activas_admin', $categorias, 3600);
        }

        return view('admin/productos', [
            'title'        => 'Administrar Productos - Panel Admin',
            'productos'    => $productos,
            'categorias'   => $categorias,
            'search'       => $search,
            'stock_filter' => $stockFilter,
            'errors'       => session()->getFlashdata('errors') ?? [],
        ]);
    }

    // Guarda un nuevo producto en la base de datos.
    public function guardar(){
        $data = [
            'codigo_producto'      => strtoupper(trim((string)$this->request->getPost('codigo_producto'))),
            'nombre_producto'      => $this->request->getPost('nombre_producto'),
            'descripcion_producto' => $this->request->getPost('descripcion_producto'),
            'precio'               => $this->request->getPost('precio'),
            'stock'                => $this->request->getPost('stock'),
            'imagen'               => $this->request->getPost('imagen'),
            'estado_producto'      => $this->request->getPost('estado_producto') !== null
                                        ? (int)$this->request->getPost('estado_producto') : 1,
            'id_categoria'         => $this->request->getPost('id_categoria'),
        ];

        if ($this->productoModel->insert($data)) {
            return redirect()->to('admin/productos')->with('success', 'Producto creado con éxito.');
        }

        return redirect()->to('admin/productos')
                         ->withInput()
                         ->with('errors', $this->productoModel->errors())
                         ->with('modal_open', 'crear');
    }

    // Edita un producto existente.
    public function editar(int $id_producto){
        $data = [
            'id_producto'          => (int)$id_producto,
            'codigo_producto'      => strtoupper(trim((string)$this->request->getPost('codigo_producto'))),
            'nombre_producto'      => $this->request->getPost('nombre_producto'),
            'descripcion_producto' => $this->request->getPost('descripcion_producto'),
            'precio'               => $this->request->getPost('precio'),
            'stock'                => $this->request->getPost('stock'),
            'imagen'               => $this->request->getPost('imagen'),
            'estado_producto'      => $this->request->getPost('estado_producto') !== null
                                        ? (int)$this->request->getPost('estado_producto') : 1,
            'id_categoria'         => $this->request->getPost('id_categoria'),
        ];

        if ($this->productoModel->update($id_producto, $data)) {
            return redirect()->to('admin/productos')->with('success', 'Producto actualizado con éxito.');
        }

        return redirect()->to('admin/productos')
                         ->withInput()
                         ->with('errors', $this->productoModel->errors())
                         ->with('modal_open', 'editar_' . $id_producto);
    }
}
