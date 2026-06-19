<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class AdminFilter implements FilterInterface{
    public function before(RequestInterface $request, $arguments= null){
        // Check if user is logged in and is an admin
        $session = session();
        if(!$session->get('isLoggedIn') || $session->get('id_role') != 1){
            // If not logged in or not an admin, redirect to login page
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments= null){
        // No action needed after the request
    }
}