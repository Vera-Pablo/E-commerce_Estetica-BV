<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstadoVentaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_estado_venta' => 1,
                'nombre_estado'   => 'Pendiente',
            ],
            [
                'id_estado_venta' => 2,
                'nombre_estado'   => 'En Preparación',
            ],
            [
                'id_estado_venta' => 3,
                'nombre_estado'   => 'Listo para retirar/enviar',
            ],
        ];

        $this->db->table('estado_venta')->insertBatch($data);
    }
}
