<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\UsuarioModel;
use App\Models\ConsultaModel;
use App\Models\FavoritoModel;
use App\Libraries\EmailService;

class Home extends BaseController{

    protected ProductoModel $productoModel;
    protected UsuarioModel $usuarioModel;
    protected ConsultaModel $consultaModel;
    protected FavoritoModel $favoritoModel;

    public function __construct(){
        $this->productoModel = new ProductoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->consultaModel = new ConsultaModel();
        $this->favoritoModel = new FavoritoModel();
    }

    // Muestra la vista principal del sitio web con banners y productos destacados.
    public function index(){
        // Banners desde JSON o fallback
        $bannersPath = WRITEPATH . 'banners.json';
        $banners     = file_exists($bannersPath)
            ? json_decode(file_get_contents($bannersPath), true) ?? $this->bannersDefault()
            : $this->bannersDefault();

        $favoritosIds = [];
        if (session()->get('isLoggedIn')) {
            $favs = $this->favoritoModel->where('id_usuario', session()->get('id_usuario'))->findAll();
            $favoritosIds = array_column($favs, 'id_producto');
        }

        return view('home', [
            'title'                => 'Estética BV - Inicio',
            'banners'              => $banners,
            'productos_destacados' => $this->productoModel->getProductosAleatorios(12),
            'favoritosIds'         => $favoritosIds,
        ]);
    }

    // Devuelve un arreglo de banners por defecto en caso de que no exista el archivo JSON.
    private function bannersDefault(): array{
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

    // Muestra la vista de consultas.
    public function consultas(){
        $session = session();
        $usuario = null;

        if ($session->get('isLoggedIn')) {
            $usuario = $this->usuarioModel->find($session->get('id_usuario'));
        }

        return view('public/consultas', [
            'title'   => 'Consultas - Estética BV',
            'usuario' => $usuario,
        ]);
    }

    // Endpoint para procesar el envío de consultas desde el formulario de contacto.
    public function enviarConsulta(){
        $session = session();

        $rules = [
            'apellido_nombre' => 'required|min_length[3]|max_length[255]',
            'email'           => 'required|valid_email',
            'asunto'          => 'required|in_list[pagina web,producto,pago,envio]',
            'consulta'        => 'required|min_length[10]|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            $errors = implode('<br>', $this->validator->getErrors());
            return redirect()->back()->withInput()->with('error', $errors);
        }

        $data = [
            'apellido_nombre' => $this->request->getPost('apellido_nombre'),
            'email'           => $this->request->getPost('email'),
            'asunto'          => $this->request->getPost('asunto'),
            'consulta'        => $this->request->getPost('consulta'),
        ];

        // Restringir el envío a administradores
        $emailPost = trim($data['email'] ?? '');
        $esAdminEmail = $this->usuarioModel->where('email', $emailPost)->where('id_rol', 1)->first();

        if ($esAdminEmail || ($session->get('isLoggedIn') && (int)$session->get('id_rol') === 1)) {
            return redirect()->back()->withInput()->with('warning', 'Acción solo para clientes');
        }

        $admin = $this->usuarioModel->where('id_rol', 1)->first();
        $adminEmail = $admin['email'] ?? 'admin@esteticabv.com';

        $sent = EmailService::sendConsultaEmail(
            $data['email'],
            $data['apellido_nombre'],
            $data['asunto'],
            $data['consulta'],
            $adminEmail
        );

        if (!$sent) {
            return redirect()->back()->withInput()->with('error', 'No se pudo enviar el correo. Intente nuevamente.');
        }

        if ($session->get('isLoggedIn')) {
            $this->consultaModel->insert([
                'mensaje'        => $data['consulta'],
                'fecha_consulta' => date('Y-m-d'),
                'id_usuario'     => $session->get('id_usuario'),
            ]);
        }

        return redirect()->to('/')->with('success', 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.');
    }

    public function quienesSomos(){
        $this->cachePage(60);
        return view('public/quienes_somos', ['title' => 'Quiénes Somos - Estética BV']);
    }

    public function comercializacion(){
        $this->cachePage(60);
        return view('public/comercializacion', ['title' => 'Comercialización - Estética BV']);
    }

    public function contacto(){
        $this->cachePage(60);
        return view('public/contacto', ['title' => 'Contacto - Estética BV']);
    }

    public function terminosDeUso(){
        $this->cachePage(60);
        return view('public/terminos_uso', ['title' => 'Términos de Uso - Estética BV']);
    }
}
