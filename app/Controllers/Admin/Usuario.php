<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuario extends BaseController{

    protected UsuarioModel $usuarioModel;

    public function __construct(){
        $this->usuarioModel = new UsuarioModel();
    }

    // Muestra la lista de clientes con opciones de búsqueda.
    public function clientes(){
        $search = $this->request->getGet('search');
        
        // Seleccionar columnas explícitas (excluye password para no exponerlo en el DOM)
        $query = $this->usuarioModel
            ->select('id_usuario, dni, apellido_nombre, email, telefono, estado_usuario, id_rol')
            ->where('id_rol', 2);
        
        if (!empty($search)) {
            $query->like('apellido_nombre', $search);
        }
        
        $clientes = $query->findAll();
        
        return view('admin/clientes', [
            'title'    => 'Administrar Clientes - Panel Admin',
            'clientes' => $clientes,
            'search'   => $search
        ]);
    }

    // Cambia el estado de un cliente (activo/inactivo).
    public function cambiarEstado(){
        
        $id_usuario   = (int)$this->request->getPost('id_usuario');
        $nuevo_estado = $this->request->getPost('estado_usuario'); // 1 o 0
        
        if (!$id_usuario || $nuevo_estado === null) {
            return redirect()->to('admin/clientes')->with('error', 'Datos incompletos para actualizar el estado.');
        }

        // M2: Verificar que el objetivo sea un cliente (id_rol = 2) para prevenir escalación de privilegios
        $usuario = $this->usuarioModel->find($id_usuario);
        if (!$usuario || (int)$usuario['id_rol'] !== 2) {
            return redirect()->to('admin/clientes')->with('error', 'Solo se puede cambiar el estado de clientes.');
        }

        if ($this->usuarioModel->update($id_usuario, ['estado_usuario' => (int)$nuevo_estado])) {
            $mensaje = ((int)$nuevo_estado === 1) ? 'Cliente activado con éxito.' : 'Cliente desactivado con éxito.';
            return redirect()->to('admin/clientes')->with('success', $mensaje);
        } else {
            return redirect()->to('admin/clientes')->with('error', 'Ocurrió un error al intentar cambiar el estado del cliente.');
        }
    }
}
