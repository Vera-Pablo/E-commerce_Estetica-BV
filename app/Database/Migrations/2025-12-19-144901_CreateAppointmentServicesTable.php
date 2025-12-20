<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentServicesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_appointments_services' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'comment'    => 'Precio en el momento de la reserva',
            ],
            'id_appointments' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_service' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id_appointments_services', true);
        $this->forge->addForeignKey('id_appointments', 'appointments', 'id_appointments', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_service', 'services', 'id_service', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('appointment_services');
    }

    public function down()
    {
        $this->forge->dropTable('appointment_services');
    }
}
