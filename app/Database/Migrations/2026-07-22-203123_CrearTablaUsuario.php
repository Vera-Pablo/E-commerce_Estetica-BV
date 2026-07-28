<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaUsuario extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_usuario' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'dni' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'apellido_nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'telefono' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'estado_usuario' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'id_rol' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_usuario', true);
        $this->forge->addUniqueKey('dni');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('telefono');
        $this->forge->addForeignKey('id_rol', 'rol', 'id_rol', 'CASCADE', 'CASCADE');
        $this->forge->createTable('usuario');
    }

    public function down()
    {
        $this->forge->dropTable('usuario');
    }
}
