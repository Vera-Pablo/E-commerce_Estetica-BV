<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;

class Orders extends BaseController{
    protected $orderModel;
    protected $orderDetailModel;

    public function __construct(){
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
    }

    // Mostrar la lista de órdenes
    public function index(){
        $orders = $this->orderModel->getOrders();

        $data = [
            'title'  => 'Gestión de Ventas',
            'orders' => $orders
        ];

        return view('admin/orders/orders', $data);
    }

    // Mostrar detalles de una orden específica
    public function view($id){
        $order = $this->orderModel->getOrderDetails($id);

        if(!$order){
            return redirect()->to(base_url('admin/orders'))->with('msg', ['type' => 'danger', 'body' => 'Orden no encontrada.']);
        }


        $details = $this->orderDetailModel->getDetailsByOrderId($id);
        
        $data = [
            'title'   => 'Detalle de Orden #' . $order->order_number,
            'order'   => $order,
            'details' => $details
        ];

        return view('admin/orders/show_order', $data);
    }

    // Actualizar el estado de una orden
    public function updateStatus() {
        $idOrder = $this->request->getPost('id_order'); 
        $idStatus = $this->request->getPost('id_status'); 

        $this->orderModel->update($idOrder, ['id_status' => $idStatus]);
        
        return redirect()->back()->with('msg', ['type'=>'success', 'body'=>'Estado actualizado']);
    }
} 