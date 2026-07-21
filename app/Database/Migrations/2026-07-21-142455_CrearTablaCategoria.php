<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaCategoria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_categoria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre_categoria' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'descripcion_categoria' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'estado_categoria' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ]);
        $this->forge->addKey('id_categoria', true);
        $this->forge->addUniqueKey('nombre_categoria');
        $this->forge->createTable('categoria');
    }

    public function down()
    {
        $this->forge->dropTable('categoria');
    }
}
