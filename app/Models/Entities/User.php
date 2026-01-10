<?php

namespace App\Models\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    // Encriptar contraseña automáticamente al guardar
    public function setPassword(string $pass){
        $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
        return $this;
    }

    //Verificar contraseña (Login)
    public function verifyPassword(string $pass){
        return password_verify($pass, $this->attributes['password']);
    }

    // Helper para obtener nombre completo 
    public function getFullName(){
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }
}