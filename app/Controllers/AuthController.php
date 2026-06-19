<?php

namespace App\Controllers;

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
        // if ($this->session->get('is_logged_in')){
        //     $user = $this->userModel->where('email', $this->session->get('email'))->first();
        //     if ($user['is_active'] == 0) {
        //         return redirect()->back()->with('msg', [
        //             'type' => 'warning', 
        //             'body' => 'Tu cuenta aún no ha sido activada. Por favor revisa tu correo.'
        //         ]);
        //     }
        // }

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

            // Redirigir según el rol
            if ($user->id_role == 1){
                return redirect()->to('/admin/dashboard')->with('msg', ['type' => 'success', 'body' => '¡Bienvenido Administrador!']);
            }else{
                return redirect()->to('/catalog')->with('msg', ['type' => 'success', 'body' => '¡Bienvenido!']);
            }
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

        //$token = bin2hex(random_bytes(50));

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

        // Insertamos directo
        if ($this->userModel->insert($data)) {
            return redirect()->to('/login')->with('msg', [
                'type' => 'success', 
                'body' => '¡Registro exitoso! Ya puedes iniciar sesión.'
            ]);
        } else {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        if($this->userModel->where('dni', $data['dni'])->first() || $this->userModel->where('email', $data['email'])->first()){
            return redirect()->back()->withInput()->with('msg', ['type' => 'warning', 'body' => 'Ya tienes una cuenta con ese DNI o correo electrónico registrado.']);
        }

        // Guardar usuario
        // if ($this->userModel->insert($data)) {
            
        //     // 2. Enviar el Email
        //     $email = \Config\Services::email();

        //     $email->setTo($data['email']);
        //     $email->setSubject('Activa tu cuenta - Estética JV');
            
        //     // El Link mágico
        //     $link = base_url("activate-account/$token");

        //     $mensaje = "
        //         <h2>Hola {$data['first_name']}!</h2>
        //         <p>Gracias por registrarte en Estética JV.</p>
        //         <p>Para poder iniciar sesión, por favor confirma tu correo electrónico haciendo clic en el siguiente enlace:</p>
        //         <p><a href='$link'>Activar mi cuenta</a></p>
        //         <br>
        //         <p>Si no te registraste, ignora este mensaje.</p>
        //     ";

        //     $email->setMessage($mensaje);

        //     if ($email->send()) {
        //         return redirect()->to('/login')->with('msg', [
        //             'type' => 'success', 
        //             'body' => 'Registro exitoso. Revisa tu correo (y la carpeta Spam) para activar tu cuenta.'
        //         ]);
        //     } else {
        //         // Si falla el envío del mail (útil para debuggear)
        //         return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Error al enviar el correo: ' . $email->printDebugger(['headers'])]);
        //     }

        // } else {
        //     return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        // }
    }

    // Handle Account Activation
    public function activateAccount($token)    {
        $userModel = new \App\Models\UserModel();

        // Buscamos al usuario que tenga ese token
        $user = $userModel->where('activation_token', $token)->first();

        if ($user) {
            // Encontramos al usuario, lo activamos
            $userModel->update($user['dni'], [ // Ojo: uso 'dni' porque es tu Primary Key
                'is_active' => 1,
                'activation_token' => null // Borramos el token para que no se use dos veces
            ]);

            return redirect()->to('/login')->with('msg', [
                'type' => 'success', 
                'body' => '¡Cuenta activada! Ya puedes iniciar sesión.'
            ]);
        } else {
            return redirect()->to('/login')->with('msg', [
                'type' => 'danger', 
                'body' => 'El enlace de activación es inválido o ya fue usado.'
            ]);
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

    // Handle Profile Update
    public function updateProfile(){
        if(!$this->session->get('is_logged_in')){
            return redirect()->to('/login');
        }

        $dni = $this->session->get('dni');

        $data = [
            'first_name' => $this->request->getPost('name'),
            'last_name'  => $this->request->getPost('last_name'),
            'phone'      => $this->request->getPost('phone'),
            'email'      => $this->request->getPost('email')
        ];

        $existingUser = $this->userModel->where('email', $data['email'])->first();
        if ($existingUser && $existingUser->dni != $dni) {
            return redirect()->back()->with('msg', ['type' => 'warning', 'body' => 'El correo electrónico ya está en uso por otro usuario.']);
        }

        if ($this->userModel->update($dni, $data)) {
            // Actualizar datos en la sesión
            $this->session->set('name', $data['first_name']);
            $this->session->set('last_name', $data['last_name']);
            $this->session->set('phone', $data['phone']);
            $this->session->set('email', $data['email']);

            return redirect()->to('/profile')->with('msg', ['type' => 'success', 'body' => 'Perfil actualizado con éxito.']);
        } else {
            return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Error al actualizar el perfil.']);
        }
    }
}