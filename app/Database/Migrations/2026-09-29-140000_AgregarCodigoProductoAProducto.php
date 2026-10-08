<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgregarCodigoProductoAProducto extends Migration
{
    public function up()
    {
        // 1. Agregar columna como nullable primero
        $this->forge->addColumn('producto', [
            'codigo_producto' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'id_producto',
            ],
        ]);

        // 2. Poblar registros preexistentes con código automático
        $db = \Config\Database::connect();
        $productos = $db->table('producto')->select('id_producto')->get()->getResultArray();
        foreach ($productos as $p) {
            $codigo = 'PROD-' . str_pad((string)$p['id_producto'], 4, '0', STR_PAD_LEFT);
            $db->table('producto')
               ->where('id_producto', $p['id_producto'])
               ->update(['codigo_producto' => $codigo]);
        }

        // 3. Hacer NOT NULL y agregar UNIQUE
        $db->query('ALTER TABLE producto MODIFY codigo_producto VARCHAR(50) NOT NULL');
        $db->query('ALTER TABLE producto ADD UNIQUE KEY uq_codigo_producto (codigo_producto)');
    }

    public function down()
    {
        $this->forge->dropColumn('producto', 'codigo_producto');
    }
}
