<?php

namespace App\Libraries;

class Cart{
    protected $session;
    protected $cartKey = 'shopping_cart'; 

    public function __construct(){
        $this->session = session();
    }

    // Añadir un ítem al carrito
    public function add($item){
        $cart = $this->session->get($this->cartKey) ?? [];

        if (isset($cart[$item['id']])){
            $cart[$item['id']]['qty'] += $item['qty'];
        } else {
            $cart[$item['id']] = $item;
        }

        $this->session->set($this->cartKey, $cart);
    }

    // Obtener el contenido del carrito
    public function getContent(){
        return $this->session->get($this->cartKey) ?? [];
    }

    // Calcular el total del carrito
    public function total(){
        $cart = $this->getContent();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }
    
    // Contar la cantidad total de ítems en el carrito
    public function count(){
        $cart = $this->getContent();
        $qty = 0;
        foreach ($cart as $item) {
            $qty += $item['qty'];
        }
        return $qty;
    }
    
    // Vaciar el carrito
    public function destroy(){
        $this->session->remove($this->cartKey);
    }

    // Eliminar un ítem del carrito
    public function remove($id){
        $cart = $this->getContent();
        
        if(isset($cart[$id])){
            unset($cart[$id]); 
            $this->session->set($this->cartKey, $cart); 
        }
    }
}