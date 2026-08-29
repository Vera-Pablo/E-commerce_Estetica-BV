<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Categoria extends BaseController{
    //Muestra la lista de categorías. Soporta búsqueda por nombre
    public function index(){
        $categoriaModel = new CategoriaModel();
        
        $search = $this->request->getGet('search');
        $estado = $this->request->getGet('estado');
        
        if (!empty($search)) {
            $categoriaModel->like('nombre_categoria', $search);
        }
        
        if ($estado !== null && $estado !== '') {
            $categoriaModel->where('estado_categoria', $estado);
        }
        
        $categorias = $categoriaModel->findAll();
        
        return view('admin/categorias', [
            'title'      => 'Administrar Categorías - Panel Admin',
            'categorias' => $categorias,
            'search'     => $search,
            'estado'     => $estado
        ]);
    }

    //Guarda una nueva categoría en la base de datos.
    public function guardar(){
        $categoriaModel = new CategoriaModel();
        
        $data = [
            'nombre_categoria'      => $this->request->getPost('nombre_categoria'),
            'descripcion_categoria' => $this->request->getPost('descripcion_categoria'),
            'estado_categoria'      => $this->request->getPost('estado_categoria') !== null ? (int)$this->request->getPost('estado_categoria') : 1
        ];

        if ($categoriaModel->insert($data)) {
            \Config\Services::cache()->delete('categorias_activas_admin');
            return redirect()->to('admin/categorias')->with('success', 'Categoría creada con éxito.');
        } else {
            // Unir errores en un string para mostrarlos en el toast (o pasar el array si la vista lo soporta)
            $errors = implode('<br>', $categoriaModel->errors());
            return redirect()->to('admin/categorias')->with('error', $errors);
        }
    }

    //Edita una categoría existente.
    public function editar($id_categoria){
        $categoriaModel = new CategoriaModel();
        
        $data = [
            'id_categoria'          => (int)$id_categoria,
            'nombre_categoria'      => $this->request->getPost('nombre_categoria'),
            'descripcion_categoria' => $this->request->getPost('descripcion_categoria'),
            'estado_categoria'      => $this->request->getPost('estado_categoria') !== null ? (int)$this->request->getPost('estado_categoria') : 1
        ];

        if ($categoriaModel->update($id_categoria, $data)) {
            \Config\Services::cache()->delete('categorias_activas_admin');
            return redirect()->to('admin/categorias')->with('success', 'Categoría actualizada con éxito.');
        } else {
            $errors = implode('<br>', $categoriaModel->errors());
            return redirect()->to('admin/categorias')->with('error', $errors);
        }
    }
}
