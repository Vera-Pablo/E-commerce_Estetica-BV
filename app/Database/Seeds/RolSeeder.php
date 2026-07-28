<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_rol'     => 1,
                'nombre_rol' => 'Administrador',
            ],
            [
                'id_rol'     => 2,
                'nombre_rol' => 'Cliente',
            ],
        ];

        $this->db->table('rol')->insertBatch($data);
    }
}
