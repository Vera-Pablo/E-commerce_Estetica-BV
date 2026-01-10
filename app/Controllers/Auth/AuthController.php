<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController{
    protected $userModel;
    protected $session;

    public function __construct(){
        $this->userModel = new UserModel();
        $this->session = session();
    }

    // Login View
    public function login(){
        if ($this->session->get('is_logged_in')){
            return redirect()->to('/catalog');
        }

        return view('auth/login', ['title' => 'Iniciar Sesión']);
    }

    // Handle Login
    public function processLogin(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if ($user && $user->verifyPassword($password)) {
            
            if ($user->is_active == 0) {
                return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Tu cuenta está desactivada. Contacta al admin.']);
            }

            $sessionData = [
                'dni'   => $user->dni, 
                'name'      => $user->first_name,
                'last_name' => $user->last_name,
                'email'     => $user->email,
                'phone'    => $user->phone,
                'created_at' => $user->created_at,
                'role'      => $user->id_role,
                'is_logged_in' => true
            ];
            
            $this->session->set($sessionData);

            return redirect()->to('/catalog')->with('msg', ['type' => 'success', 'body' => '¡Bienvenido!']);
        }

        return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Credenciales incorrectas.']);
    }

    // Register View
    public function register(){
        if ($this->session->get('is_logged_in')){
            return redirect()->to('/catalog');
        }
        return view('auth/register', ['title' => 'Crear Cuenta']);
    }

    // Handle Registration
    public function processRegister(){
        $data = [
            'dni'        => $this->request->getPost('dni'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'password'   => $this->request->getPost('password'),
            'id_role'    => 2,
            'is_active'  => 1
        ];

        if($this->userModel->where('dni', $data['dni'])->first() || $this->userModel->where('email', $data['email'])->first()){
            return redirect()->back()->withInput()->with('msg', ['type' => 'warning', 'body' => 'Ya tienes una cuenta con ese DNI o correo electrónico registrado.']);
        }

        if ($this->userModel->save($data)) {
            return redirect()->to('/login')->with('msg', ['type' => 'success', 'body' => 'Cuenta creada con éxito. Ahora inicia sesión.']);
        } else {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }
    }

    // Handle Logout
    public function logout(){
        $this->session->destroy();
        return redirect()->to('/login')->with('msg', ['type' => 'info', 'body' => 'Has cerrado sesión.']);
    }

    // verifica que rol es y lo dirije a su vista de perfil sino esta log a inicio de sesion
    public function profile(){
        $id_role = $this->session->get('id_role');
    
        if(!$this->session->get('is_logged_in')){
            return redirect()->to('/login');
        }

        $viewName = match($id_role){
            1 => 'pages/adminProfile',
            2 => 'pages/userProfile',
            3 => 'pages/staffProfile',
            default => 'pages/userProfile',
        };

        return view($viewName, ['title' => 'Mi Perfil']);
    }

}