<?php

namespace App\Controllers\Shop;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Libraries\Cart; // Importamos nuestra librería

class Carts extends BaseController{
    protected $productModel;
    protected $cart;
    public function __construct(){
        $this->productModel = new ProductModel();
        $this->cart = new Cart();
    }

    // add item to cart
    public function add(){
        $productId = $this->request->getPost('id');
        $quantity  = (int)$this->request->getPost('qty');
        
        if (!$productId || $quantity <= 0){
            return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Datos inválidos.']);
        }

        $product = $this->productModel->find($productId);

        if (!$product){
            return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Producto no encontrado.']);
        }

        $item = [
            'id'      => $product->id_product, 
            'name'    => $product->name,
            'price'   => $product->price,
            'img'     => $product->getImageUrl(),
            'qty'     => $quantity
        ];

        $this->cart->add($item);

        return redirect()->back()->with('msg', ['type' => 'success', 'body' => '¡Producto agregado al carrito!']);
    }

    // view cart
    public function index(){        
        $data = [
            'title' => 'Tu Carrito de Compras',
            'items' => $this->cart->getContent(),
            'total' => $this->cart->total()
        ];
        
        return view('shop/cart', $data);
    }

    // remove item from cart
    public function remove($id){
        $this->cart->remove($id);
        
        return redirect()->back()->with('msg', ['type' => 'warning', 'body' => 'Producto eliminado del carrito.']);
    }

    // clear cart
    public function clear(){
        $this->cart->destroy();
        
        return redirect()->back()->with('msg', ['type' => 'warning', 'body' => 'El carrito se ha vaciado.']);
    }
}