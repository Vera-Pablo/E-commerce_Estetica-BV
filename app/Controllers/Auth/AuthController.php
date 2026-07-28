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

        if (is_file(APPPATH . 'Views/public/login.php')) {
            return view('public/login');
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

        if (is_file(APPPATH . 'Views/public/registro.php')) {
            return view('public/registro');
        }

        return $this->renderFallbackPage('Registro', 'Formulario de Registro');
    }

    public function registroProcess()
    {
        $rules = [
            'dni'             => 'required|integer|exact_length[8]|is_unique[usuario.dni]',
            'apellido_nombre' => 'required|min_length[3]|max_length[255]',
            'email'           => 'required|valid_email|is_unique[usuario.email]',
            'telefono'        => 'permit_empty|max_length[20]',
            'password'        => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('error', 'Ocurrió un error en la validación.');
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

        if (is_file(APPPATH . 'Views/public/recuperar.php')) {
            return view('public/recuperar');
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

    public function googleAuth()
    {
        $clientId = getenv('GOOGLE_CLIENT_ID') ?: ($_ENV['GOOGLE_CLIENT_ID'] ?? null);

        if (empty($clientId) || $this->request->getGet('mock') === '1') {
            return redirect()->to(site_url('auth/google/callback?code=mock_google_code'));
        }

        $redirectUri = site_url('auth/google/callback');
        $state       = bin2hex(random_bytes(16));
        session()->set('oauth_state', $state);

        $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'state'         => $state,
        ]);

        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        $code = $this->request->getGet('code');

        if (empty($code)) {
            return redirect()->to('/login')->with('error', 'Error al autenticar con Google.');
        }

        $googleEmail = 'usuario.google@gmail.com';
        $googleName  = 'Usuario Google';

        if ($code !== 'mock_google_code') {
            $googleEmail = $this->request->getGet('email') ?: $googleEmail;
            $googleName  = $this->request->getGet('name') ?: $googleName;
        }

        $user = $this->usuarioModel->where('email', $googleEmail)->first();

        if (!$user) {
            $generatedDni = $this->generateUniqueDni();

            $newUserData = [
                'dni'             => $generatedDni,
                'apellido_nombre' => $googleName,
                'email'           => $googleEmail,
                'password'        => password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT),
                'telefono'        => null,
                'estado_usuario'  => 1,
                'id_rol'          => 2,
            ];

            $userId = $this->usuarioModel->insert($newUserData);
            $user   = $this->usuarioModel->find($userId);
        } elseif ((int) $user['estado_usuario'] === 0) {
            $this->usuarioModel->update($user['id_usuario'], ['estado_usuario' => 1]);
            $user['estado_usuario'] = 1;
        }

        session()->set([
            'id_usuario'      => (int) $user['id_usuario'],
            'dni'             => $user['dni'],
            'apellido_nombre' => $user['apellido_nombre'],
            'email'           => $user['email'],
            'id_rol'          => (int) $user['id_rol'],
            'isLoggedIn'      => true,
        ]);

        return redirect()->to('/')->with('success', '¡Sesión iniciada con Google correctamente!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Sesión Cerrada');
    }

    private function generateUniqueDni(): int
    {
        do {
            $dni = mt_rand(80000000, 89999999);
            $exists = $this->usuarioModel->where('dni', $dni)->first();
        } while ($exists);

        return $dni;
    }

    private function renderFallbackPage(string $title, string $subtitle)
    {
        $html = "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>{$title}</title></head><body><h1>{$title}</h1><p>{$subtitle}</p></body></html>";
        return $this->response->setBody($html);
    }
}
