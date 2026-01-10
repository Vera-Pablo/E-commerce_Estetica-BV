<?php

namespace App\Controllers\Shop;

use App\Controllers\BaseController;
use App\Libraries\Cart;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\ProductModel;

class Checkout extends BaseController{

    protected $productModel;
    protected $orderModel;
    protected $orderDetailModel;
    protected $cart;
    protected $db;

    public function __construct(){
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->cart = new Cart();
        $this->db = \Config\Database::connect();
    }

    // Mostrar página de checkout
    public function index(){
        if (!session()->get('is_logged_in')){
            return redirect()->to('/login')->with('msg', ['type' => 'warning', 'body' => 'Debes iniciar sesión para finalizar la compra.']);
        }

        $cart = new Cart();
        if ($cart->count() == 0) {
            return redirect()->to('/catalog')->with('msg', ['type' => 'info', 'body' => 'Tu carrito está vacío. Agrega productos antes de finalizar la compra.']);
        }

        $data = [
            'title' => 'Confirmar Compra',
            'cart'  => $cart->getContent(),
            'total' => $cart->total(),
            'user'  => session()->get('name')
        ];

        return view('shop/checkout', $data);
    }

    // Procesar el checkout
    public function process(){
        // 1. OBTENCIÓN DE DATOS
        $items = $this->cart->getContent();
        $total = $this->cart->total();
        $userId = session()->get('dni');
        $codigoOrden = $this->orderModel->generateOrderNumber();

        // Iniciamos Transacción
        $this->db->transStart();

        try {
            // --- PASO A: Guardar Orden ---
            $orderData = [
                'order_number' => $codigoOrden,
                'total' => $total,
                'dni' => $userId,
                'id_status' => 1, // Estado: Pendiente
                'id_payment_method' => 1 // Método: Por Defecto
            ];

            $this->orderModel->insert($orderData);
            $orderId = $this->orderModel->getInsertID();


            // --- PASO B: Guardar Detalles ---
            foreach ($items as $item) {
                $this->orderDetailModel->insert([
                    'id_order'   => $orderId,
                    'id_product' => $item['id'],
                    'quantity'   => $item['qty'],
                    'subtotal'   => $item['price'] * $item['qty']
                ]);

                //actualizar stock del producto
                $this->productModel->where('id_product', $item['id'])
                                   ->set('stock', 'stock - ' . (int)$item['qty'], false)
                                   ->update();
            }
            
            
            // Confirmamos transacción
            $this->db->transComplete();

            //--- RESULTADOS ---
            //CASO 1: ERROR EN BD
            if ($this->db->transStatus() === false) {
                // para saber que error dio
                
                return redirect()->back()->with('msg', [
                    'type' => 'danger', 
                    'body' => 'Error al procesar el pedido. Intente nuevamente.'
                ]);
            }

            // DEBUG: Mostrar errores de BD (Descomentar para usar)
            // if ($this->db->transStatus() === false) {
            //     // 1. Obtenemos el error específico de la base de datos
            //     $error = $this->db->error(); 
                
            //     // 2. Obtenemos la última consulta que intentó hacer (muy útil)
            //     $ultimaQuery = $this->db->getLastQuery();

            //     // 3. DETENEMOS TODO Y MOSTRAMOS EL ERROR EN PANTALLA
            //     echo "<h1>Error de Base de Datos Encontrado</h1>";
                
            //     echo "<strong>Código de error:</strong> " . $error['code'] . "<br>";
            //     echo "<strong>Mensaje:</strong> " . $error['message'] . "<br><br>";
                
            //     echo "<strong>Consulta que falló (o la anterior):</strong><br>";
            //     echo "<pre>" . $ultimaQuery . "</pre>";
                
            //     die(); // Matamos el proceso aquí para que puedas leerlo
                
            //     /* // Mantenemos tu código original comentado para cuando arreglemos el error
            //     return redirect()->back()->with('msg', [
            //         'type' => 'danger', 
            //         'body' => 'Error al procesar el pedido. Intente nuevamente.'
            //     ]); 
            //     */
            // }

            // CASO 2: ÉXITO TOTAL (Aquí está tu cambio)
            $this->cart->destroy(); // Vaciamos carrito
            // Redirigimos al catálogo con el mensaje de éxito (Toast Verde)
            return redirect()->to('/my_orders')->with('msg', [
                'type' => 'success',
                'body' => '¡Felicidades! Su pedido #' . $orderId . ' se registró correctamente.'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('msg', [
                'type' => 'danger', 
                'body' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }

    // Mostrar los pedidos del usuario
    public function myOrders(){
        $userId = session()->get('dni');
        $orders = $this->orderModel
            ->select('orders.*, status.name as status_name')
            ->join('status', 'orders.id_status = status.id_status', 'left')
            ->where('orders.dni', $userId)
            ->findAll();


        $data = [
            'title' => 'Mis Pedidos',
            'orders' => $orders
        ];

        return view('shop/my_orders', $data);
    }

    // Mostrar detalles de un pedido específico
    public function orderDetails($orderId){
        $userId = session()->get('dni');

        // Verificar que el pedido pertenece al usuario autenticado
        $order = $this->orderModel
            ->select('orders.*, status.name as status_name')
            ->join('status', 'orders.id_status = status.id_status', 'left')
            ->where('orders.id_order', $orderId)
            ->where('orders.dni', $userId)
            ->first();

        if (!$order) {
            return redirect()->to('/my_orders')->with('msg', [
                'type' => 'danger',
                'body' => 'Pedido no encontrado o no autorizado.'
            ]);
        }

        // Obtener los detalles del pedido
        $orderItems = $this->orderDetailModel
            ->select('order_details.*, products.name as product_name')
            ->join('products', 'order_details.id_product = products.id_product', 'left')
            ->where('order_details.id_order', $orderId)
            ->findAll();

        $data = [
            'title' => 'Detalles del Pedido #' . $order->order_number,
            'order' => $order,
            'order_items' => $orderItems
        ];

        return view('shop/order', $data);
    }
}