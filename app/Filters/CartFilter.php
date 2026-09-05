<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * CartFilter — Permite acceso al carrito solo a clientes autenticados (id_rol = 2).
 * Los administradores y visitantes anónimos son redirigidos.
 */
class CartFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->with('error', 'Debe iniciar sesión para acceder al carrito.');
        }

        if ((int) session()->get('id_rol') !== 2) {
            return redirect()->to('/')
                ->with('error', 'El administrador no puede acceder al carrito de compras.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
