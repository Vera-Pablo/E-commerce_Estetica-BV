<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaRol extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rol' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre_rol' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id_rol', true);
        $this->forge->addUniqueKey('nombre_rol');
        $this->forge->createTable('rol');
    }

    public function down()
    {
        $this->forge->dropTable('rol');
    }
}
