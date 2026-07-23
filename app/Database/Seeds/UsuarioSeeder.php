<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'dni'             => 10000000,
                'apellido_nombre' => 'Vera, Belén',
                'email'           => 'admin@esteticabv.com',
                'password'        => password_hash('admin123', PASSWORD_BCRYPT),
                'telefono'        => '1122334455',
                'estado_usuario'  => 1,
                'id_rol'          => 1, // Administrador
            ],
            [
                'dni'             => 99999999,
                'apellido_nombre' => 'Pérez, Juan',
                'email'           => 'juan.perez@example.com',
                'password'        => password_hash('cliente123', PASSWORD_BCRYPT),
                'telefono'        => '1199887766',
                'estado_usuario'  => 1,
                'id_rol'          => 2, // Cliente
            ],
        ];

        $this->db->table('usuario')->insertBatch($data);
    }
}
