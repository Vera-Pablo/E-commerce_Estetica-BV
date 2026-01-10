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
}