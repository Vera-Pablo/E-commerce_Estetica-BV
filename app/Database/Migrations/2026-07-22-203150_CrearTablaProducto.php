<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaProducto extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_producto' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre_producto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'descripcion_producto' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'precio' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'imagen' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'estado_producto' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'id_categoria' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_producto', true);
        $this->forge->addUniqueKey('nombre_producto');
        $this->forge->addForeignKey('id_categoria', 'categoria', 'id_categoria', 'CASCADE', 'CASCADE');
        $this->forge->createTable('producto');
    }

    public function down()
    {
        $this->forge->dropTable('producto');
    }
}
