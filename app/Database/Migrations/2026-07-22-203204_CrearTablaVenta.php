<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaVenta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_venta' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'fecha_venta' => [
                'type' => 'DATE',
            ],
            'id_estado_venta' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_metodo_pago' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_venta', true);
        $this->forge->addForeignKey('id_estado_venta', 'estado_venta', 'id_estado_venta', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_metodo_pago', 'metodo_pago', 'id_metodo_pago', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_usuario', 'usuario', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('venta');
    }

    public function down()
    {
        $this->forge->dropTable('venta');
    }
}
