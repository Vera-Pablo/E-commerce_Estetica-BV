<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivationTokenToUsers extends Migration{
    public function up(){
        $this->forge->addColumn('users', [
            'activation_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'is_active' // Para mantener el orden visual
            ],
        ]);
    }

    public function down(){
        $this->forge->dropColumn('users', 'activation_token');
    }
}
