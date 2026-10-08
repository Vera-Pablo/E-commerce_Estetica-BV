<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConsultaModel;

class Consulta extends BaseController{

    protected ConsultaModel $consultaModel;

    public function __construct() {
        $this->consultaModel = new ConsultaModel();
    }

    // Muestra la lista de consultas. Soporta bsqueda por rango de fechas y ordenamiento.
    public function index(){

        $fechaDesde = $this->request->getGet('fecha_desde');
        $fechaHasta = $this->request->getGet('fecha_hasta');
        $orden      = $this->request->getGet('orden') ?? 'desc';

        $builder = $this->consultaModel->select('consulta.*, usuario.apellido_nombre, usuario.email, usuario.telefono, usuario.dni')
                                 ->join('usuario', 'usuario.id_usuario = consulta.id_usuario', 'left');

        if (!empty($fechaDesde)) {
            $builder->where('consulta.fecha_consulta >=', $fechaDesde);
        }
        if (!empty($fechaHasta)) {
            $builder->where('consulta.fecha_consulta <=', $fechaHasta);
        }

        if (in_array(strtolower($orden), ['asc', 'desc'], true)) {
            $builder->orderBy('consulta.fecha_consulta', $orden)
                    ->orderBy('consulta.id_consulta', $orden);
        } else {
            $builder->orderBy('consulta.fecha_consulta', 'desc')
                    ->orderBy('consulta.id_consulta', 'desc');
        }

        $consultas = $builder->findAll();

        return view('admin/consultas', [
            'title'       => 'Consultas - Panel Admin',
            'consultas'   => $consultas,
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'orden'       => $orden,
        ]);
    }
}
