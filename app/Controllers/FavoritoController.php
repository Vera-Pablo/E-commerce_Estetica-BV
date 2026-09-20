<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FavoritoModel;
use App\Models\ProductoModel;

class FavoritoController extends BaseController{

    protected FavoritoModel $favoritoModel;
    protected ProductoModel $productoModel;

    public function __construct(){
        $this->favoritoModel = new FavoritoModel();
        $this->productoModel = new ProductoModel();
    }
    
    //Muestra la vista de "Mis Favoritos" con los productos que el usuario ha marcado como favoritos.
    public function index(){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('warning', 'Debes iniciar sesión para ver tus favoritos.');
        }

        $userId = session()->get('id_usuario');
        
        // Obtener productos favoritos del usuario con JOIN a la tabla producto y categoria
        $db = \Config\Database::connect();
        $builder = $db->table('favorito f');
        $builder->select('p.*, c.nombre_categoria');
        $builder->join('producto p', 'p.id_producto = f.id_producto');
        $builder->join('categoria c', 'c.id_categoria = p.id_categoria', 'left');
        $builder->where('f.id_usuario', $userId);
        $builder->where('p.estado_producto', 1);
        $favoritos = $builder->get()->getResultArray();

        // Extraer los IDs para el JS/UI
        $favoritosIds = array_column($favoritos, 'id_producto');

        return view('public/mis_favoritos', [
            'title'        => 'Mis Favoritos - Estética BV',
            'productos'    => $favoritos,
            'favoritosIds' => $favoritosIds
        ]);
    }

    //Endpoint AJAX para agregar o quitar un producto de favoritos
    public function toggle(){
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No autorizado'])->setStatusCode(401);
        }

        $idProducto = $this->request->getPost('id_producto');
        $userId = session()->get('id_usuario');

        if (!$idProducto) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID inválido'])->setStatusCode(400);
        }

        // Buscar si ya existe el favorito
        $existe = $this->favoritoModel->where('id_usuario', $userId)
                                      ->where('id_producto', $idProducto)
                                      ->first();

        if ($existe) {
            // Si existe, lo borra (remove)
            $this->favoritoModel->where('id_usuario', $userId)
                          ->where('id_producto', $idProducto)
                          ->delete();
            return $this->response->setJSON(['status' => 'removed']);
        } else {
            // Si no existe, lo agrega (add)
            $this->favoritoModel->insert([
                'id_usuario'  => $userId,
                'id_producto' => $idProducto
            ]);
            return $this->response->setJSON(['status' => 'added']);
        }
    }
}
