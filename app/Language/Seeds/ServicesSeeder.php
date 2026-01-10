<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Corte de Pelo',
                'description' => 'Corte y lavado incluido. Asesoramiento personalizado según tipo de rostro.',
                'duration'    => 30,
                'price'       => 500.00,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Coloración Completa',
                'description' => 'Aplicación de tinte en todo el cabello. Incluye lavado y secado.',
                'duration'    => 120,
                'price'       => 2500.00,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Mechas o Reflejos',
                'description' => 'Técnica de decoloración parcial para iluminar el cabello.',
                'duration'    => 150,
                'price'       => 3200.00,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Tratamiento de Keratina',
                'description' => 'Alisado brasileño con keratina. Reduce el frizz y alisa el cabello.',
                'duration'    => 180,
                'price'       => 4500.00,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Peinado para Evento',
                'description' => 'Peinado profesional para eventos especiales (bodas, fiestas, etc.)',
                'duration'    => 60,
                'price'       => 1200.00,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Tratamiento Capilar Intensivo',
                'description' => 'Hidratación profunda con nutrientes y vitaminas. Incluye masaje capilar.',
                'duration'    => 45,
                'price'       => 800.00,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Brushing (Secado y Cepillado)',
                'description' => 'Lavado, secado y cepillado profesional con brushing.',
                'duration'    => 30,
                'price'       => 400.00,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('services')->insertBatch($data);
    }
}
