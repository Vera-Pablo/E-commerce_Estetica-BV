<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgregarTipoEntregaAVenta extends Migration
{
    public function up()
    {
        $this->forge->addColumn('venta', [
            'tipo_entrega' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Retiro en local',
                'after'      => 'fecha_venta',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('venta', 'tipo_entrega');
    }
}
