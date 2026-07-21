<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaEstadoVenta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_estado_venta' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre_estado' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id_estado_venta', true);
        $this->forge->addUniqueKey('nombre_estado');
        $this->forge->createTable('estado_venta');
    }

    public function down()
    {
        $this->forge->dropTable('estado_venta');
    }
}
