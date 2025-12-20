<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'dni'         => '42995260',
                'first_name'  => 'Admin',
                'last_name'   => 'Sistema',
                'email'       => 'admesteticajv@gmail.com',
                'phone'       => '3795054254',
                'is_active'   => 1,
                'id_role'     => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            
            [
                'dni'         => '11111111',
                'first_name'  => 'Belen',
                'last_name'   => 'Vera',
                'email'       => 'belenjv123@gmail.com',
                'phone'       => '3794617433',
                'is_active'   => 1,
                'id_role'     => 3, 
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            
            [
                'dni'         => '22222222',
                'first_name'  => 'Laura',
                'last_name'   => 'Martínez',
                'email'       => 'laura@example.com',
                'phone'       => '1187654321',
                'is_active'   => 1,
                'id_role'     => 2,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}