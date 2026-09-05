<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Perfil extends BaseController
{
    protected UsuarioModel $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder a tu perfil.');
        }

        $idUsuario = (int) session()->get('id_usuario');
        $usuario   = $this->usuarioModel->find($idUsuario);

        if (!$usuario) {
            return redirect()->to('/login')->with('error', 'Usuario no encontrado.');
        }

        return view('public/perfil', [
            'usuario' => $usuario,
        ]);
    }

    public function actualizar()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder a tu perfil.');
        }

        $idUsuario = (int) session()->get('id_usuario');

        $rules = [
            'apellido_nombre' => 'required|min_length[3]|max_length[255]',
            'email'           => "required|valid_email|max_length[255]|is_unique[usuario.email,id_usuario,{$idUsuario}]",
            'telefono'        => "permit_empty|max_length[20]|is_unique[usuario.telefono,id_usuario,{$idUsuario}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('error', 'Por favor corrige los errores en el formulario.');
        }

        $apellidoNombre = trim((string) $this->request->getPost('apellido_nombre'));
        $email          = trim((string) $this->request->getPost('email'));
        $telefono       = trim((string) $this->request->getPost('telefono'));

        $this->usuarioModel->skipValidation(true)->update($idUsuario, [
            'apellido_nombre' => $apellidoNombre,
            'email'           => $email,
            'telefono'        => $telefono !== '' ? $telefono : null,
        ]);

        session()->set([
            'apellido_nombre' => $apellidoNombre,
            'email'           => $email,
        ]);

        return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function cambiarPassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder a tu perfil.');
        }

        $idUsuario = (int) session()->get('id_usuario');

        $rules = [
            'password_actual'  => 'required',
            'password_nuevo'   => 'required|min_length[8]|max_length[255]',
            'confirm_password' => 'required|matches[password_nuevo]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('error', 'Por favor corrige los errores en el formulario.');
        }

        $usuario        = $this->usuarioModel->find($idUsuario);
        $passwordActual = (string) $this->request->getPost('password_actual');

        if (!$usuario || !password_verify($passwordActual, $usuario['password'])) {
            return redirect()->back()->withInput()->with('error', 'La contraseña actual no es correcta.');
        }

        $passwordNuevo = (string) $this->request->getPost('password_nuevo');
        $newHash       = password_hash($passwordNuevo, PASSWORD_DEFAULT);

        $this->usuarioModel->skipValidation(true)->update($idUsuario, [
            'password' => $newHash,
        ]);

        return redirect()->to('/perfil')->with('success', 'Contraseña actualizada correctamente.');
    }
}
