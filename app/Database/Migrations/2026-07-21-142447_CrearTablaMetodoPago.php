<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaMetodoPago extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_metodo_pago' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre_metodo_pago' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id_metodo_pago', true);
        $this->forge->addUniqueKey('nombre_metodo_pago');
        $this->forge->createTable('metodo_pago');
    }

    public function down()
    {
        $this->forge->dropTable('metodo_pago');
    }
}
