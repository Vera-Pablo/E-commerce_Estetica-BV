<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return $this->renderPage('Inicio', 'Página Principal');
    }

    public function quienesSomos()
    {
        return $this->renderPage('Quiénes Somos', 'Información sobre Estética BV');
    }

    public function comercializacion()
    {
        return $this->renderPage('Comercialización', 'Información sobre ventas y envíos');
    }

    public function contacto()
    {
        return $this->renderPage('Contacto', 'Contacto de la estética');
    }

    public function terminosDeUso()
    {
        return $this->renderPage('Términos de Uso', 'Términos y Condiciones de uso');
    }

    private function renderPage(string $title, string $subtitle)
    {
        return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>{$title}</title></head><body><h1>{$title}</h1><p>{$subtitle}</p></body></html>";
    }
}
