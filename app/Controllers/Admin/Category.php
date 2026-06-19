<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class Category extends BaseController{
    protected $categoryModel;
    protected $productModel;

    public function __construct(){
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

     //funcion para listar todas las categorias
    public function getCategories(){
        $categories = $this->categoryModel->findAll();

        $data = [
            'title'      => 'Gestión de Categorías',
            'categories' => $categories
        ];

        return view('admin/categories/categories', $data);
    }

    //funcion para agregar nueva categoria
    public function addCategory(){
        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ];

        $existingCategory = $this->categoryModel->where('name', $data['name'])->first();
        $existingSlug = $this->categoryModel->where('slug', $data['slug'])->first();

        if ($existingCategory || $existingSlug) {
            return redirect()->to(base_url('admin/categories'))->with('msg', ['type' => 'danger', 'body' => 'Ya existe una categoría con ese nombre o slug.']);
        }else{
             // Generar slug y descripción si están vacíos
            if (empty($data['slug']) || empty($data['description'])) {
                $data['slug'] = url_title(strtolower($data['name']), '-', true);
                $data['description'] = 'Sin descripción';
            }

            $this->categoryModel->insert($data);
            return redirect()->to(base_url('admin/categories'))->with('msg', ['type' => 'success', 'body' => 'Categoría agregada con éxito.']);
        }
    }

    //funcion para editar caregoria
    public function updateCategory(){
        $id = $this->request->getPost('id_categorie');
        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ];

        $this->categoryModel->update($id, $data);

        return redirect()->to(base_url('admin/categories'))->with('msg', ['type' => 'success', 'body' => 'Categoría actualizada con éxito.']);
    }

    // funcion para eliminar categoria que no elimina
    public function deleteCategory(){
        $id = $this->request->getPost('id_categorie');

        //validor si la categoria tiene productos asociados
        $products = $this->productModel->where('id_categories', $id)->findAll();
        if(count($products) > 0){
            return redirect()->to(base_url('admin/categories'))->with('msg', ['type' => 'danger', 'body' => 'No se puede eliminar la categoría porque tiene productos asociados.']);
        }else{
            $this->categoryModel->delete($id);
            return redirect()->to(base_url('admin/categories'))->with('msg', ['type' => 'success', 'body' => 'Categoría eliminada con éxito.']);
        }

    }

    // function para cambiar estado de categoria
    public function updateStatusCategory(){
        $id = $this->request->getPost('id_categorie');
        $isActive = $this->request->getPost('is_active');

        $data = [
            'is_active' => $isActive
        ];

        $this->categoryModel->update($id, $data);

        return redirect()->to(base_url('admin/categories'))->with('msg', ['type' => 'success', 'body' => 'Estado de la categoría actualizado con éxito.']);
    }

    // function para obtener datos de categoria en JSON (para cargar en modal de edicion)
    public function getCategoryData($id){
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return $this->response->setJSON(['success' => false, 'message' => 'Categoría no encontrada']);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'id_categorie' => $category->id_categorie,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'is_active' => $category->is_active
            ]
        ]);
    }
}