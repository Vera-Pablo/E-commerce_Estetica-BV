<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Products extends BaseController{
    protected $productModel;
    protected $categoryModel;

    public function __construct(){
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function getProducts(){
        $products = $this->productModel->findAll();
        $categories = $this->categoryModel->findAll();
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        return view('admin/products/products', $data);
    }

    // function addProduct with validation (name-slug-description)
    public function addProduct(){
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'url_image' => $this->request->getPost('url_image'),
            'id_categories' => $this->request->getPost('category_id'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $existingProduct = $this->productModel->where('name', $data['name'])->first();
        if($existingProduct){
            return redirect()->back()->with('error', 'El nombre del producto ya existe. Por favor, elija otro nombre.');
        }

        if(empty($data['slug']) || empty($data['description'])){
            $data['slug'] = url_title(strtolower($data['name']), '-', true);
            $data['description'] = 'Sin descripción';

            // insertar el producto con los datos generados
            $this->productModel->insert($data);
            return redirect()->back()->with('success', 'Producto agregado correctamente.');
        }else{
            return redirect()->back()->with('error', 'Ocurrió un error al agregar el producto. Por favor, inténtelo de nuevo.');
        }

    
    }

    // function deleteProduct
    public function deleteProduct(){
        $id = $this->request->getPost('id_product');

        if(!empty($id)){
            $this->productModel->delete($id);
            return redirect()->back()->with('success', 'Producto eliminado correctamente.');
        }else{
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el producto. Por favor, inténtelo de nuevo.');
        }   
    }

    
}