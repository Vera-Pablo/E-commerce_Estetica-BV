<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritoModel extends Model
{
    protected $table            = 'favorito';
    protected $primaryKey       = 'id_favorito';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_usuario', 'id_producto'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'id_usuario'  => 'required|integer',
        'id_producto' => 'required|integer',
    ];
}
