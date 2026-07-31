<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return $this->renderPage('Estética BV - Inicio', 'Estética Integral y Cuidado Personal');
    }

    public function quienesSomos()
    {
        return view('public/quienes_somos', ['title' => 'Quiénes Somos - Estética BV']);
    }

    public function comercializacion()
    {
        return view('public/comercializacion', ['title' => 'Comercialización - Estética BV']);
    }

    public function contacto()
    {
        return view('public/contacto', ['title' => 'Contacto - Estética BV']);
    }

    public function terminosDeUso()
    {
        return $this->renderPage('Términos de Uso', 'Términos y Condiciones de uso');
    }

    private function renderPage(string $title, string $subtitle)
    {
        return view('home', [
            'title'    => $title,
            'subtitle' => $subtitle,
        ]);
    }
}
