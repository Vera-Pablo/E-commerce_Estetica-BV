<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolTable extends Migration
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
                'unique'     => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_rol', true);
        $this->forge->createTable('rol');
    }

    public function down()
    {
        $this->forge->dropTable('rol');
    }
}
