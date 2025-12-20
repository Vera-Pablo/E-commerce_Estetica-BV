<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_appointments' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'appointment_date' => [
                'type' => 'DATE',
            ],
            'appointment_time' => [
                'type' => 'TIME',
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
            'id_stylist' => [
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

        $this->forge->addKey('id_appointments', true);
        $this->forge->addForeignKey('dni', 'users', 'dni', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_status', 'status', 'id_status', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('id_stylist', 'stylists', 'id_stylist', 'RESTRICT', 'CASCADE');
        $this->forge->addUniqueKey(['id_stylist', 'appointment_date', 'appointment_time']); // Evita doble reserva
        $this->forge->createTable('appointments');
    }

    public function down()
    {
        $this->forge->dropTable('appointments');
    }
}