<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStylistsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_stylist' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'dni' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'is_available' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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

        $this->forge->addKey('id_stylist', true);
        $this->forge->addForeignKey('dni', 'users', 'dni', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stylists');
    }

    public function down()
    {
        $this->forge->dropTable('stylists');
    }
}