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

    //función para listar las órdenes
    public function getOrders(){
        return $this->select('orders.*, users.first_name, users.last_name, users.email, status.name as status_name')
                    ->join('users', 'users.dni = orders.dni')
                    ->join('status', 'status.id_status = orders.id_status')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    //función para obtener los detalles de una orden específica
    public function getOrderDetails($id){
        return $this->select('orders.*, users.first_name, users.last_name, users.email, status.name as status_name')
                    ->join('users', 'users.dni = orders.dni')
                    ->join('status', 'status.id_status = orders.id_status')
                    ->where('orders.id_order', $id)
                    ->first();
    }

    //fuction para obtener el estado de una orden
    public function getOrderStatus($id_status){
        $status = $this->db->table('status')->where('id_status', $id_status)->get()->getRow();
        return $status ? $status->name : null;
    }
}

