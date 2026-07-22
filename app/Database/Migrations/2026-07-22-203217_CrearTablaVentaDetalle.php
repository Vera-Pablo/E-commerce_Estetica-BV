<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaVentaDetalle extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_venta_detalle' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cantidad' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'precio_unitario' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'id_producto' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_venta' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_venta_detalle', true);
        $this->forge->addForeignKey('id_producto', 'producto', 'id_producto', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_venta', 'venta', 'id_venta', 'CASCADE', 'CASCADE');
        $this->forge->createTable('venta_detalle');
    }

    public function down()
    {
        $this->forge->dropTable('venta_detalle');
    }
}
