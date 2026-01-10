<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Entities\User;

class OrderModel extends Model{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'order_number',
        'total',
        'notes',
        'dni',
        'id_status',
        'id_payment_method'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Generar un número de orden único antes de insertar
    // Generar un número de orden único
    public function generateOrderNumber(){
        // Generar número único: ORD + timestamp + aleatorio
        return 'ORD' . date('YmdHis') . rand(1000, 9999);
    }
}

