<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Libraries\EmailService;
use App\Libraries\TokenService;
use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    protected UsuarioModel $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return session()->get('id_rol') == 1
                ? redirect()->to('/admin/dashboard')
                : redirect()->to('/');
        }

        if (is_file(APPPATH . 'Views/public/auth/login.php')) {
            return view('public/auth/login');
        }

        return $this->renderFallbackPage('Iniciar Sesión', 'Formulario de Login');
    }

    public function loginProcess()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Por favor ingresa un correo y contraseña válidos.');
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->usuarioModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales inválidas.');
        }

        if ((int) $user['estado_usuario'] !== 1) {
            return redirect()->back()->withInput()->with('error', 'Su cuenta está pendiente de activación. Por favor revise su correo.');
        }

        session()->set([
            'id_usuario'      => (int) $user['id_usuario'],
            'dni'             => $user['dni'],
            'apellido_nombre' => $user['apellido_nombre'],
            'email'           => $user['email'],
            'id_rol'          => (int) $user['id_rol'],
            'isLoggedIn'      => true,
        ]);

        if ((int) $user['id_rol'] === 1) {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/')->with('success', 'Sesión iniciada correctamente');
    }

    public function registro()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if (is_file(APPPATH . 'Views/public/auth/registro.php')) {
            return view('public/auth/registro');
        }

        return $this->renderFallbackPage('Registro', 'Formulario de Registro');
    }

    public function registroProcess()
    {
        $rules = [
            'dni' => [
                'rules'  => 'required|numeric|exact_length[8]|is_unique[usuario.dni]',
                'errors' => [
                    'required'     => 'El DNI es obligatorio.',
                    'numeric'      => 'El DNI debe contener únicamente números.',
                    'exact_length' => 'El DNI debe tener exactamente 8 dígitos.',
                    'is_unique'    => 'El DNI ya se encuentra registrado.',
                ],
            ],
            'apellido_nombre' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'El Apellido y Nombre es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[usuario.email]',
                'errors' => [
                    'required'    => 'El correo electrónico es obligatorio.',
                    'valid_email' => 'Debes ingresar un correo electrónico válido.',
                    'is_unique'   => 'El correo electrónico ya se encuentra registrado.',
                ],
            ],
            'telefono' => [
                'rules'  => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'El teléfono no puede superar los 20 caracteres.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required'   => 'La contraseña es obligatoria.',
                    'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
                ],
            ],
            'passconf' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Debes confirmar la contraseña.',
                    'matches'  => 'Las contraseñas no coinciden.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('error', 'Por favor corrige los errores en el formulario.');
        }

        $dni            = $this->request->getPost('dni');
        $apellidoNombre = $this->request->getPost('apellido_nombre');
        $email          = $this->request->getPost('email');
        $telefono       = $this->request->getPost('telefono');
        $password       = $this->request->getPost('password');

        $userData = [
            'dni'             => $dni,
            'apellido_nombre' => $apellidoNombre,
            'email'           => $email,
            'password'        => password_hash($password, PASSWORD_BCRYPT),
            'telefono'        => !empty($telefono) ? $telefono : null,
            'estado_usuario'  => 0,
            'id_rol'          => 2,
        ];

        $userId = $this->usuarioModel->insert($userData);

        if (!$userId) {
            return redirect()->back()->withInput()->with('error', 'Error al registrar el usuario.');
        }

        $token = TokenService::createToken([
            'id_usuario' => $userId,
            'action'     => 'activate',
        ], 86400);

        $activationLink = site_url('registro/validar/' . $token);
        EmailService::sendActivationEmail($email, $apellidoNombre, $activationLink);

        return redirect()->to('/login')->with('success', 'Registro exitoso. Se ha enviado un enlace de activación a tu correo electrónico.');
    }

    public function validarEmail($token = null)
    {
        if (empty($token)) {
            return redirect()->to('/login')->with('error', 'Token no proporcionado.');
        }

        $payload = TokenService::verifyToken($token);

        if (!$payload || ($payload['action'] ?? '') !== 'activate' || empty($payload['id_usuario'])) {
            return redirect()->to('/login')->with('error', 'El enlace de activación es inválido o ha expirado.');
        }

        $user = $this->usuarioModel->find($payload['id_usuario']);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Usuario no encontrado.');
        }

        $this->usuarioModel->update($user['id_usuario'], ['estado_usuario' => 1]);

        return redirect()->to('/login')->with('success', '¡Cuenta activada con éxito!');
    }

    public function recuperar()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if (is_file(APPPATH . 'Views/public/auth/recuperar.php')) {
            return view('public/auth/recuperar');
        }

        return $this->renderFallbackPage('Recuperar Clave', 'Formulario de Recuperación');
    }

    public function recuperarProcess()
    {
        $rules = [
            'email'            => 'required|valid_email',
            'password'         => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('error', 'Las contraseñas no coinciden o no cumplen con los requisitos.');
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->usuarioModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'No existe ninguna cuenta registrada con ese correo electrónico.');
        }

        $newPasswordHash = password_hash($password, PASSWORD_BCRYPT);

        $token = TokenService::createToken([
            'id_usuario'   => $user['id_usuario'],
            'new_password' => $newPasswordHash,
            'action'       => 'reset_password',
        ], 3600);

        $confirmLink = site_url('recuperar/confirmar/' . $token);
        EmailService::sendPasswordResetEmail($user['email'], $user['apellido_nombre'], $confirmLink);

        return redirect()->to('/login')->with('success', 'Se ha enviado un correo de confirmación. Por favor haz clic en el enlace para aplicar el cambio de contraseña.');
    }

    public function confirmarRecuperacion($token = null)
    {
        if (empty($token)) {
            return redirect()->to('/login')->with('error', 'Token no proporcionado.');
        }

        $payload = TokenService::verifyToken($token);

        if (!$payload || ($payload['action'] ?? '') !== 'reset_password' || empty($payload['id_usuario']) || empty($payload['new_password'])) {
            return redirect()->to('/login')->with('error', 'El enlace de recuperación es inválido o ha expirado.');
        }

        $user = $this->usuarioModel->find($payload['id_usuario']);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Usuario no encontrado.');
        }

        $this->usuarioModel->update($user['id_usuario'], [
            'password' => $payload['new_password'],
        ]);

        return redirect()->to('/login')->with('success', 'Contraseña actualizada correctamente');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Sesión Cerrada');
    }

    private function renderFallbackPage(string $title, string $subtitle)
    {
        $html = "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>{$title}</title></head><body><h1>{$title}</h1><p>{$subtitle}</p></body></html>";
        return $this->response->setBody($html);
    }
}
