<?php

namespace App\Controllers\Shop;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Catalog extends BaseController{

    protected $productModel;
    protected $categoryModel;

    public function __construct(){
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // Display the product catalog with optional filtering
    public function index(){
        $categoryId = $this->request->getGet('categoria');
        $search = $this->request->getGet('buscar');

        $products = $this->productModel->getActiveProducts($categoryId, $search);
        $categories = $this->categoryModel->findAll();
        
        $data = [
            'title'      => 'Catálogo | Peluquería Femenina',
            'products'   => $products,   
            'categories' => $categories,
            'currentCategory' => $categoryId,
            'currentSearch' => $search 
        ];

        return view('shop/catalog', $data);
    }

    // Display detailed view of a single product
    public function detail($id = null){
        $product = $this->productModel->find($id);

        if(!$product){
           return redirect()->to('shop/catalog')->with('msg', [
            'type' => 'danger',
            'body' => 'El producto que buscas no existe'
           ]);
        }

        $data = [
            'title' => $product->name . ' | Peluqueria Femenina',
            'product' => $product,
        ];
        
        return view('shop/product_detail',$data);
    }
}

