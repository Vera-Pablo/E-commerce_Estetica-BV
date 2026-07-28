<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MetodoPagoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_metodo_pago'     => 1,
                'nombre_metodo_pago' => 'Efectivo',
            ],
            [
                'id_metodo_pago'     => 2,
                'nombre_metodo_pago' => 'Tarjeta de Crédito',
            ],
            [
                'id_metodo_pago'     => 3,
                'nombre_metodo_pago' => 'Tarjeta de Débito',
            ],
            [
                'id_metodo_pago'     => 4,
                'nombre_metodo_pago' => 'Transferencia',
            ],
        ];

        $this->db->table('metodo_pago')->insertBatch($data);
    }
}
