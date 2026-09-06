<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Nombres de los meses en español para los labels
        $mesesEspanol = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        
        $mesActualIndex = (int)date('n') - 1;
        $mesPasadoIndex = $mesActualIndex === 0 ? 11 : $mesActualIndex - 1;

        $mesActualNombre = $mesesEspanol[$mesActualIndex];
        $mesPasadoNombre = $mesesEspanol[$mesPasadoIndex];

        // 1. Gráfico Torta - Ventas mes actual vs mes pasado
        // Mes Actual
        $queryMesActual = $db->query("
            SELECT COUNT(*) AS cantidad, SUM(total) AS monto
            FROM venta
            WHERE MONTH(fecha_venta) = MONTH(CURDATE())
              AND YEAR(fecha_venta) = YEAR(CURDATE())
        ")->getRowArray();
        
        // Mes Pasado
        $queryMesPasado = $db->query("
            SELECT COUNT(*) AS cantidad, SUM(total) AS monto
            FROM venta
            WHERE MONTH(fecha_venta) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
              AND YEAR(fecha_venta) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
        ")->getRowArray();

        $graficoMeses = [
            [
                'label' => "Mes Actual ($mesActualNombre)",
                'valor' => (int)$queryMesActual['cantidad'],
                'monto' => (float)$queryMesActual['monto']
            ],
            [
                'label' => "Mes Pasado ($mesPasadoNombre)",
                'valor' => (int)$queryMesPasado['cantidad'],
                'monto' => (float)$queryMesPasado['monto']
            ]
        ];

        // 2. Gráfico Barras - Métodos de pago
        $metodosPago = $db->query("
            SELECT mp.nombre_metodo_pago AS label, COUNT(*) AS valor
            FROM venta v
            JOIN metodo_pago mp ON mp.id_metodo_pago = v.id_metodo_pago
            GROUP BY mp.id_metodo_pago, mp.nombre_metodo_pago
            ORDER BY valor DESC
        ")->getResultArray();

        // Parsear enteros para chart.js
        foreach ($metodosPago as &$mp) {
            $mp['valor'] = (int)$mp['valor'];
        }

        // 3. Gráfico Torta - Tipo de entrega
        $tiposEntrega = $db->query("
            SELECT tipo_entrega AS label, COUNT(*) AS valor
            FROM venta
            GROUP BY tipo_entrega
        ")->getResultArray();

        foreach ($tiposEntrega as &$te) {
            $te['valor'] = (int)$te['valor'];
        }

        // 4. Cards KPI - Bajo Stock
        $umbralStock = 5;
        $bajoStock = $db->query("
            SELECT COUNT(*) AS cantidad
            FROM producto
            WHERE stock <= ? AND estado_producto = 1
        ", [$umbralStock])->getRowArray();

        // 5. Cards KPI - Usuarios activos
        $usuariosActivos = $db->query("
            SELECT COUNT(*) AS cantidad
            FROM usuario
            WHERE estado_usuario = 1 AND id_rol = 2
        ")->getRowArray();

        // 6. Ranking Top 10 Clientes
        $topClientes = $db->query("
            SELECT u.apellido_nombre, u.email,
                   COUNT(v.id_venta) AS total_pedidos,
                   SUM(v.total) AS total_gastado
            FROM venta v
            JOIN usuario u ON u.id_usuario = v.id_usuario
            GROUP BY v.id_usuario, u.apellido_nombre, u.email
            ORDER BY total_gastado DESC
            LIMIT 10
        ")->getResultArray();

        return view('admin/dashboard', [
            'title'            => 'Dashboard - Panel Admin',
            'grafico_meses'    => json_encode($graficoMeses),
            'grafico_metodos'  => json_encode($metodosPago),
            'grafico_entregas' => json_encode($tiposEntrega),
            'bajo_stock'       => (int)$bajoStock['cantidad'],
            'umbral_stock'     => $umbralStock,
            'usuarios_activos' => (int)$usuariosActivos['cantidad'],
            'top_clientes'     => $topClientes,
        ]);
    }
}

