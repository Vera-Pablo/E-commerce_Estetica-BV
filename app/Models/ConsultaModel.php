<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table            = 'consulta';
    protected $primaryKey       = 'id_consulta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mensaje', 'fecha_consulta', 'id_usuario'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'mensaje'        => 'required|min_length[5]|max_length[500]',
        'fecha_consulta' => 'required|valid_date',
        'id_usuario'     => 'required|integer',
    ];
}
