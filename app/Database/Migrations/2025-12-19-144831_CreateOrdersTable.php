<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_order' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'dni' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'id_status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_payment_method' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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

        $this->forge->addKey('id_order', true);
        $this->forge->addForeignKey('dni', 'users', 'dni', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_status', 'status', 'id_status', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_payment_method', 'payment_method', 'id_payment_method', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}