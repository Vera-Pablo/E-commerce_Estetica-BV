<?php

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerFilter implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null){
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('rol') != 2) {
            return redirect()->to('/login')->with('msg', ['type' => 'warning', 'body' => 'Debes iniciar sesión como cliente para acceder a esta página.']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
       
    }
}