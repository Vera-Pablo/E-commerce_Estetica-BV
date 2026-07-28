<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaConsulta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_consulta' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'mensaje' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            'fecha_consulta' => [
                'type' => 'DATE',
            ],
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_consulta', true);
        $this->forge->addForeignKey('id_usuario', 'usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('consulta');
    }

    public function down()
    {
        $this->forge->dropTable('consulta');
    }
}
