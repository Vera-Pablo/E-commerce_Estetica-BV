<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConsultaModel;

class Consulta extends BaseController
{
    /**
     * Listado de consultas registradas con soporte de filtro por fecha y orden cronológico.
     * Ruta: GET /admin/consultas
     */
    public function index()
    {
        $consultaModel = new ConsultaModel();

        $fecha = $this->request->getGet('fecha');
        $orden = $this->request->getGet('orden') ?? 'desc';

        $builder = $consultaModel->select('consulta.*, usuario.apellido_nombre, usuario.email, usuario.telefono, usuario.dni')
                                 ->join('usuario', 'usuario.id_usuario = consulta.id_usuario', 'left');

        if (!empty($fecha)) {
            $builder->where('consulta.fecha_consulta', $fecha);
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
            'title'     => 'Consultas - Panel Admin',
            'consultas' => $consultas,
            'fecha'     => $fecha,
            'orden'     => $orden,
        ]);
    }
}
