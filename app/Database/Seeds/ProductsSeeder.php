<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Shampoos
            [
                'name'          => 'Shampoo Hidratante Profesional',
                'slug'          => 'shampoo-hidratante-profesional',
                'description'   => 'Shampoo de hidratación profunda con aceite de argán. Ideal para cabello seco y maltratado.',
                'price'         => 450.00,
                'stock'         => 25,
                'image'         => 'shampoo-hidratante.jpg',
                'is_active'     => 1,
                'id_categories' => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Shampoo Anti-Frizz',
                'slug'          => 'shampoo-anti-frizz',
                'description'   => 'Control de frizz y suavidad extrema. Con keratina y proteínas.',
                'price'         => 520.00,
                'stock'         => 18,
                'image'         => 'shampoo-anti-frizz.jpg',
                'is_active'     => 1,
                'id_categories' => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            // Acondicionadores
            [
                'name'          => 'Acondicionador Reparador Intensivo',
                'slug'          => 'acondicionador-reparador-intensivo',
                'description'   => 'Repara el cabello dañado desde la raíz hasta las puntas. Con colágeno y vitaminas.',
                'price'         => 380.00,
                'stock'         => 30,
                'image'         => 'acondicionador-reparador.jpg',
                'is_active'     => 1,
                'id_categories' => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            // Tintes
            [
                'name'          => 'Tinte Profesional Castaño Claro',
                'slug'          => 'tinte-profesional-castano-claro',
                'description'   => 'Coloración permanente profesional. Cobertura 100% de canas. Tono: 6.0',
                'price'         => 1200.00,
                'stock'         => 15,
                'image'         => 'tinte-castano.jpg',
                'is_active'     => 1,
                'id_categories' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Tinte Profesional Rubio Ceniza',
                'slug'          => 'tinte-profesional-rubio-ceniza',
                'description'   => 'Coloración permanente profesional. Tono: 8.1 Rubio Ceniza',
                'price'         => 1200.00,
                'stock'         => 12,
                'image'         => 'tinte-rubio-ceniza.jpg',
                'is_active'     => 1,
                'id_categories' => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            // Tratamientos
            [
                'name'          => 'Tratamiento de Keratina Brasileña',
                'slug'          => 'tratamiento-keratina-brasilena',
                'description'   => 'Sistema de alisado brasileño con keratina. Reduce el frizz hasta por 3 meses.',
                'price'         => 3500.00,
                'stock'         => 8,
                'image'         => 'keratina-brasilena.jpg',
                'is_active'     => 1,
                'id_categories' => 4,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Ampolla de Reparación Profunda',
                'slug'          => 'ampolla-reparacion-profunda',
                'description'   => 'Tratamiento intensivo de choque. Caja con 6 ampollas.',
                'price'         => 850.00,
                'stock'         => 20,
                'image'         => 'ampolla-reparacion.jpg',
                'is_active'     => 1,
                'id_categories' => 4,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            // Styling
            [
                'name'          => 'Spray Fijador Extra Fuerte',
                'slug'          => 'spray-fijador-extra-fuerte',
                'description'   => 'Fijación extrema y duradera. No deja residuos. 400ml',
                'price'         => 320.00,
                'stock'         => 35,
                'image'         => 'spray-fijador.jpg',
                'is_active'     => 1,
                'id_categories' => 5,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Cera Modeladora Profesional',
                'slug'          => 'cera-modeladora-profesional',
                'description'   => 'Define y modela todo tipo de peinados. Acabado mate. 100g',
                'price'         => 280.00,
                'stock'         => 22,
                'image'         => 'cera-modeladora.jpg',
                'is_active'     => 1,
                'id_categories' => 5,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}