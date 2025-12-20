<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StylistsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'dni'          => '22222222', // María González
                'is_available' => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('stylists')->insertBatch($data);
        
    }
}