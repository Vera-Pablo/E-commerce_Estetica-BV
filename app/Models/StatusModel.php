<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model{
    protected $table = 'status';
    protected $primaryKey = 'id_status';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
