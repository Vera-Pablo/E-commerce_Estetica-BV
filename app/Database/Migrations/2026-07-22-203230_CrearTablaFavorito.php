<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaFavorito extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_favorito' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_producto' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_favorito', true);
        $this->forge->addForeignKey('id_usuario', 'usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_producto', 'producto', 'id_producto', 'CASCADE', 'CASCADE');
        $this->forge->createTable('favorito');
    }

    public function down()
    {
        $this->forge->dropTable('favorito');
    }
}
