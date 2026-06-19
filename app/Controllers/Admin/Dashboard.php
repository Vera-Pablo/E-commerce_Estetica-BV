<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController{
    public function index(){
        // Aquí podrías cargar estadísticas (Total ventas, usuarios nuevos, etc)
        // Por ahora, solo mostramos la vista vacía
        
        $data = ['title' => 'Dashboard'];
        return view('admin/dashboard', $data);
    }
}