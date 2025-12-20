<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderDetailsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_order_details' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'id_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_product' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id_order_details', true);
        $this->forge->addForeignKey('id_order', 'orders', 'id_order', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('order_details');
    }

    public function down()
    {
        $this->forge->dropTable('order_details');
    }
}