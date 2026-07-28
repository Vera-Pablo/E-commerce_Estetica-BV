<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión para acceder al panel de administración.');
        }

        if ((int) session()->get('id_rol') !== 1) {
            return redirect()->to('/')->with('error', 'Acceso no autorizado al área administrativa.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
