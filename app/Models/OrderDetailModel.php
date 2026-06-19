<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Entities\User;

class OrderDetailModel extends Model{
    protected $table = 'order_details';
    protected $primaryKey = 'id_order_details';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_order',
        'id_product',
        'quantity',
        'subtotal'
    ];

    //función para obtener los detalles de una orden por su ID
    public function getDetailsByOrderId($orderId){
        return $this->select('order_details.*, products.name, products.image') // Traemos nombre y foto
                    ->join('products', 'products.id_product = order_details.id_product')
                    ->where('id_order', $orderId)
                    ->findAll();
    }
}