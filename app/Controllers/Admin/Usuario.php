<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuario extends BaseController{
    public function clientes(){
        $usuarioModel = new UsuarioModel();
        
        $search = $this->request->getGet('search');
        
        // Filtrar solo los usuarios con id_rol = 2 (Clientes)
        $usuarioModel->where('id_rol', 2);
        
        if (!empty($search)) {
            $usuarioModel->like('apellido_nombre', $search);
        }
        
        $clientes = $usuarioModel->findAll();
        
        return view('admin/clientes', [
            'title'    => 'Administrar Clientes - Panel Admin',
            'clientes' => $clientes,
            'search'   => $search
        ]);
    }

    public function cambiarEstado(){
        $usuarioModel = new UsuarioModel();
        
        $id_usuario = $this->request->getPost('id_usuario');
        $nuevo_estado = $this->request->getPost('estado_usuario'); // 1 o 0
        
        if (!$id_usuario || $nuevo_estado === null) {
            return redirect()->to('admin/clientes')->with('error', 'Datos incompletos para actualizar el estado.');
        }

        if ($usuarioModel->update($id_usuario, ['estado_usuario' => (int)$nuevo_estado])) {
            $mensaje = ((int)$nuevo_estado === 1) ? 'Cliente activado con éxito.' : 'Cliente desactivado con éxito.';
            return redirect()->to('admin/clientes')->with('success', $mensaje);
        } else {
            return redirect()->to('admin/clientes')->with('error', 'Ocurrió un error al intentar cambiar el estado del cliente.');
        }
    }
}
