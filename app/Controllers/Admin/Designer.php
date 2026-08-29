<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Designer extends BaseController
{
    private string $jsonPath;
    private const MAX_SLIDES = 8;

    public function __construct()
    {
        $this->jsonPath = WRITEPATH . 'banners.json';
    }

    /** GET /admin/designer */
    public function index(): string
    {
        return view('admin/designer', [
            'title'   => 'Designer — Panel Admin',
            'banners' => $this->leerBanners(),
        ]);
    }

    /** POST /admin/designer/guardar */
    public function guardar()
    {
        $titulos    = $this->request->getPost('titulo') ?? [];
        $subtitulos = $this->request->getPost('subtitulo') ?? [];
        $imagenes   = $this->request->getPost('imagen') ?? [];
        $btn1Texto  = $this->request->getPost('btn1_texto') ?? [];
        $btn1Url    = $this->request->getPost('btn1_url') ?? [];
        $btn2Texto  = $this->request->getPost('btn2_texto') ?? [];
        $btn2Url    = $this->request->getPost('btn2_url') ?? [];

        $newBanners = [];

        for ($i = 0; $i < count($titulos); $i++) {
            $titulo = trim($titulos[$i] ?? '');

            // Validar que el título sea obligatorio
            if (empty($titulo)) {
                return redirect()->to('admin/designer')->with('error', 'El título de cada slide es obligatorio.');
            }

            // Validar URL de imagen (si se provee y es una URL válida)
            $imagenRaw = trim($imagenes[$i] ?? '');
            $imagen    = null;
            if (!empty($imagenRaw)) {
                if (filter_var($imagenRaw, FILTER_VALIDATE_URL)) {
                    $imagen = $imagenRaw;
                }
            }

            $newBanners[] = [
                'imagen'               => $imagen,
                'titulo'               => $titulo,
                'subtitulo'            => !empty($subtitulos[$i]) ? trim($subtitulos[$i]) : null,
                'btn_primario_texto'   => !empty($btn1Texto[$i]) ? trim($btn1Texto[$i]) : null,
                'btn_primario_url'     => !empty($btn1Url[$i]) ? trim($btn1Url[$i]) : null,
                'btn_secundario_texto' => !empty($btn2Texto[$i]) ? trim($btn2Texto[$i]) : null,
                'btn_secundario_url'   => !empty($btn2Url[$i]) ? trim($btn2Url[$i]) : null,
            ];
        }

        // Validación de cantidad de slides (Mínimo 1, Máximo MAX_SLIDES)
        $count = count($newBanners);
        if ($count < 1) {
            return redirect()->to('admin/designer')->with('error', 'Debe haber al menos 1 slide.');
        }

        if ($count > self::MAX_SLIDES) {
            return redirect()->to('admin/designer')->with('error', 'Se permite un máximo de ' . self::MAX_SLIDES . ' slides.');
        }

        // Escribir en banners.json
        $encoded = json_encode($newBanners, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (file_put_contents($this->jsonPath, $encoded) !== false) {
            return redirect()->to('admin/designer')->with('success', 'Banners actualizados con éxito.');
        }

        return redirect()->to('admin/designer')->with('error', 'Ocurrió un error al guardar el archivo de banners.');
    }

    private function leerBanners(): array
    {
        if (file_exists($this->jsonPath)) {
            $data = json_decode(file_get_contents($this->jsonPath), true);
            return is_array($data) && !empty($data) ? $data : $this->bannersDefault();
        }

        return $this->bannersDefault();
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
}
