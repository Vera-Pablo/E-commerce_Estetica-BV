<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Home extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();

        // Banners desde JSON o fallback
        $bannersPath = WRITEPATH . 'banners.json';
        $banners     = file_exists($bannersPath)
            ? json_decode(file_get_contents($bannersPath), true) ?? $this->bannersDefault()
            : $this->bannersDefault();

        return view('home', [
            'title'                => 'Estética BV - Inicio',
            'banners'              => $banners,
            'productos_destacados' => $productoModel->getProductosAleatorios(12),
        ]);
    }

    private function bannersDefault(): array
    {
        return [
            [
                'imagen'               => null,
                'titulo'               => 'Estética BV',
                'subtitulo'            => 'Estética Integral, Cuidado Personal y Productos Exclusivos',
                'btn_primario_texto'   => 'Explorar Catálogo',
                'btn_primario_url'     => 'catalogo',
                'btn_secundario_texto' => 'Hacer Consulta',
                'btn_secundario_url'   => 'consultas',
            ],
            [
                'imagen'               => null,
                'titulo'               => 'Envíos a Domicilio',
                'subtitulo'            => 'Recibe tus tratamientos y productos favoritos en la comodidad de tu hogar',
                'btn_primario_texto'   => 'Información de Envíos',
                'btn_primario_url'     => 'comercializacion',
                'btn_secundario_texto' => null,
                'btn_secundario_url'   => null,
            ],
            [
                'imagen'               => null,
                'titulo'               => 'Formas de Pago',
                'subtitulo'            => 'Aceptamos Efectivo, Tarjetas de Crédito/Débito y Transferencia Bancaria',
                'btn_primario_texto'   => 'Contacto y Medios de Pago',
                'btn_primario_url'     => 'contacto',
                'btn_secundario_texto' => null,
                'btn_secundario_url'   => null,
            ],
        ];
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
}
