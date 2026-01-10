<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Entities\User;

class UserModel extends Model{
    protected $table            = 'users';
    protected $primaryKey       = 'dni';  
    protected $useAutoIncrement = false;  
    protected $returnType       = User::class;
    protected $useSoftDeletes   = false;      
    protected $allowedFields    = [
        'first_name', 'last_name', 'email', 
        'password', 'phone', 'id_role', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $validationRules = [
        'dni'        => 'required|min_length[6]|is_unique[users.dni]',
        'first_name' => 'required|min_length[3]',
        'last_name'  => 'required|min_length[3]',
        'email'      => 'required|valid_email|is_unique[users.email]',
        'password'   => 'required|min_length[6]',
        'id_role'    => 'required|integer'
    ];
    protected $validationMessages = [
        'dni' => [
            'is_unique' => 'Este DNI ya está registrado.'
        ],
        'email' => [
            'is_unique' => 'Este correo electrónico ya está registrado.'
        ]
    ];
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Hash password before saving
    protected function hashPassword(array $data){
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}