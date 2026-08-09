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
        $this->cachePage(60);
        return view('public/quienes_somos', ['title' => 'Quiénes Somos - Estética BV']);
    }

    public function comercializacion()
    {
        $this->cachePage(60);
        return view('public/comercializacion', ['title' => 'Comercialización - Estética BV']);
    }

    public function contacto()
    {
        $this->cachePage(60);
        return view('public/contacto', ['title' => 'Contacto - Estética BV']);
    }

    public function terminosDeUso()
    {
        $this->cachePage(60);
        return view('public/terminos_uso', ['title' => 'Términos de Uso - Estética BV']);
    }

    private function renderPage(string $title, string $subtitle)
    {
        return view('home', [
            'title'    => $title,
            'subtitle' => $subtitle,
        ]);
    }
}
