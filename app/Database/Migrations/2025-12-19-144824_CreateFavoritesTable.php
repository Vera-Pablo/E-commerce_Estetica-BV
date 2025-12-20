<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_favorite' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'dni' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'id_product' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_favorite', true);
        $this->forge->addForeignKey('dni', 'users', 'dni', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['dni', 'id_product']); // Evita duplicados
        $this->forge->createTable('favorites');
    }

    public function down()
    {
        $this->forge->dropTable('favorites');
    }
}