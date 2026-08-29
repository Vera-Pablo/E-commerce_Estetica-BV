<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Producto extends BaseController{
    public function index(){
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
        
        $search = $this->request->getGet('search');
        $stockFilter = $this->request->getGet('stock_filter');
        
        // Cargar modelo con join si es necesario o podemos buscar solo en producto y hacer el join después, 
        // pero dado que ProductoModel es simple, podemos usar el query builder aquí
        $productoModel->select('producto.*, categoria.nombre_categoria');
        $productoModel->join('categoria', 'categoria.id_categoria = producto.id_categoria', 'left');
        
        if (!empty($search)) {
            $productoModel->like('producto.nombre_producto', $search);
        }
        
        if ($stockFilter !== null && $stockFilter !== '') {
            if ($stockFilter === 'low') {
                $productoModel->where('producto.stock <=', 5);
                $productoModel->where('producto.stock >', 0);
            } elseif ($stockFilter === 'out') {
                $productoModel->where('producto.stock', 0);
            }
        }
        
        $productos = $productoModel->findAll();
        
        // Caché de categorías activas para evitar consultas repetidas a MySQL
        $cache = \Config\Services::cache();
        $categorias = $cache->get('categorias_activas_admin');
        if ($categorias === null) {
            $categorias = $categoriaModel->where('estado_categoria', 1)->findAll();
            // Guardar en caché por 1 hora (3600 segundos)
            $cache->save('categorias_activas_admin', $categorias, 3600);
        }

        return view('admin/productos', [
            'title'        => 'Administrar Productos - Panel Admin',
            'productos'    => $productos,
            'categorias'   => $categorias,
            'search'       => $search,
            'stock_filter' => $stockFilter
        ]);
    }

    public function guardar(){
        $productoModel = new ProductoModel();
        
        $data = [
            'nombre_producto'      => $this->request->getPost('nombre_producto'),
            'descripcion_producto' => $this->request->getPost('descripcion_producto'),
            'precio'               => $this->request->getPost('precio'),
            'stock'                => $this->request->getPost('stock'),
            'imagen'               => $this->request->getPost('imagen'), // Cloudinary URL
            'estado_producto'      => $this->request->getPost('estado_producto') !== null ? (int)$this->request->getPost('estado_producto') : 1,
            'id_categoria'         => $this->request->getPost('id_categoria')
        ];

        if ($productoModel->insert($data)) {
            return redirect()->to('admin/productos')->with('success', 'Producto creado con éxito.');
        } else {
            $errors = implode('<br>', $productoModel->errors());
            return redirect()->to('admin/productos')->with('error', $errors);
        }
    }

    /**
     * Edita un producto existente.
     * Ruta: POST /admin/producto/editar/(:num)
     * 
     * @param int $id_producto
     */
    public function editar($id_producto){
        $productoModel = new ProductoModel();
        
        $data = [
            'id_producto'          => (int)$id_producto,
            'nombre_producto'      => $this->request->getPost('nombre_producto'),
            'descripcion_producto' => $this->request->getPost('descripcion_producto'),
            'precio'               => $this->request->getPost('precio'),
            'stock'                => $this->request->getPost('stock'),
            'imagen'               => $this->request->getPost('imagen'), // Cloudinary URL
            'estado_producto'      => $this->request->getPost('estado_producto') !== null ? (int)$this->request->getPost('estado_producto') : 1,
            'id_categoria'         => $this->request->getPost('id_categoria')
        ];

        if ($productoModel->update($id_producto, $data)) {
            return redirect()->to('admin/productos')->with('success', 'Producto actualizado con éxito.');
        } else {
            $errors = implode('<br>', $productoModel->errors());
            return redirect()->to('admin/productos')->with('error', $errors);
        }
    }
}
