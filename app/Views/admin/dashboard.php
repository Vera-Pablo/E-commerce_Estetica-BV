<?= $this->extend('Layouts/admin/base_admin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Dashboard - Panel Admin') ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Fallbacks para evitar falsos positivos de variables indefinidas en el IDE
$bajo_stock = $bajo_stock ?? 0;
$umbral_stock = $umbral_stock ?? 5;
$usuarios_activos = $usuarios_activos ?? 0;
$top_clientes = $top_clientes ?? [];
$grafico_meses = $grafico_meses ?? '[]';
$grafico_metodos = $grafico_metodos ?? '[]';
$grafico_entregas = $grafico_entregas ?? '[]';
?>
<div class="container-fluid px-lg-4">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4 mt-3 mt-lg-0">
        <h1 class="font-spartan fw-bold text-dark m-0">
            <i class="fas fa-chart-pie text-dark me-2"></i>Dashboard
        </h1>
    </div>

    <!-- Fila 1 - Gráficos -->
    <div class="row g-4 mb-4">
        <!-- Gráfico 1: Ventas Mes vs Mes -->
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark font-spartan mb-3">Ventas Mensuales</h5>
                    <div style="position: relative; height:250px; width:100%">
                        <canvas id="chartMeses"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico 2: Métodos de Pago -->
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark font-spartan mb-3">Métodos de Pago</h5>
                    <div style="position: relative; height:250px; width:100%">
                        <canvas id="chartMetodos"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico 3: Tipo de Entrega -->
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark font-spartan mb-3">Tipos de Entrega</h5>
                    <div style="position: relative; height:250px; width:100%">
                        <canvas id="chartEntregas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 2 - KPIs y Top Clientes -->
    <div class="row g-4">
        <!-- Columna Izquierda: KPIs -->
        <div class="col-12 col-md-4">
            <div class="row g-4">
                <!-- Card Bajo Stock -->
                <div class="col-12">
                    <div class="card border-0 rounded-4 shadow-sm h-100 card-hover text-decoration-none">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background-color: rgba(231, 111, 81, 0.1);">
                                <i class="fas fa-exclamation-triangle fa-2x <?= $bajo_stock > 0 ? 'text-danger' : 'text-success' ?>"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0 <?= $bajo_stock > 0 ? 'text-danger' : 'text-success' ?>"><?= esc($bajo_stock) ?></h3>
                                <div class="small text-muted">Productos con ≤ <?= esc($umbral_stock) ?> unidades</div>
                                <a href="<?= base_url('admin/productos') ?>" class="text-decoration-none small text-primary mt-1 d-inline-block">Ver inventario <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Usuarios Activos -->
                <div class="col-12">
                    <div class="card border-0 rounded-4 shadow-sm h-100 card-hover text-decoration-none">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background-color: rgba(42, 157, 143, 0.1);">
                                <i class="fas fa-users fa-2x text-success"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0 text-success"><?= esc($usuarios_activos) ?></h3>
                                <div class="small text-muted">Clientes activos registrados</div>
                                <a href="<?= base_url('admin/clientes') ?>" class="text-decoration-none small text-primary mt-1 d-inline-block">Ver clientes <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Ranking Top 10 Clientes -->
        <div class="col-12 col-md-8">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark font-spartan mb-3">🏆 Top 10 Mejores Clientes</h5>
                    <?php if (empty($top_clientes)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-trophy fa-3x mb-2 opacity-25"></i>
                            <p class="mb-0">Aún no hay clientes con compras finalizadas.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless align-middle mb-0">
                                <thead class="border-bottom">
                                    <tr>
                                        <th class="text-muted small fw-bold">Pos</th>
                                        <th class="text-muted small fw-bold">Cliente</th>
                                        <th class="text-muted small fw-bold text-center">Pedidos</th>
                                        <th class="text-muted small fw-bold text-end">Gastado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($top_clientes as $i => $cliente): ?>
                                    <?php 
                                        $posicion = $i + 1; 
                                        $iconoPos = '';
                                        if ($posicion === 1) $iconoPos = '🥇';
                                        elseif ($posicion === 2) $iconoPos = '🥈';
                                        elseif ($posicion === 3) $iconoPos = '🥉';
                                        else $iconoPos = "#$posicion";
                                    ?>
                                    <tr>
                                        <td class="fw-bold"><?= $iconoPos ?></td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= esc($cliente['apellido_nombre']) ?></div>
                                            <div class="small text-muted"><?= esc($cliente['email']) ?></div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border"><?= esc($cliente['total_pedidos']) ?></span>
                                        </td>
                                        <td class="text-end fw-bold text-success">
                                            $<?= number_format($cliente['total_gastado'], 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Datos cargados desde PHP
    const datosMeses = <?= $grafico_meses ?>;
    const datosMetodos = <?= $grafico_metodos ?>;
    const datosEntregas = <?= $grafico_entregas ?>;

    // Paleta de colores
    const colores = ['#f4a261', '#264653', '#2a9d8f', '#e76f51', '#e9c46a'];

    // 2. Gráfico Meses (Torta/Doughnut)
    const ctxMeses = document.getElementById('chartMeses').getContext('2d');
    if (datosMeses.every(d => d.valor === 0)) {
        new Chart(ctxMeses, {
            type: 'doughnut',
            data: { labels: ['Sin datos'], datasets: [{ data: [1], backgroundColor: ['#e0e0e0'] }] },
            options: { plugins: { tooltip: { enabled: false } }, responsive: true, maintainAspectRatio: false }
        });
    } else {
        new Chart(ctxMeses, {
            type: 'doughnut',
            data: {
                labels: datosMeses.map(d => d.label),
                datasets: [{
                    data: datosMeses.map(d => d.valor),
                    backgroundColor: ['#e76f51', '#264653'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                const dataObj = datosMeses[idx];
                                const fmtMonto = new Intl.NumberFormat('es-AR', {style: 'currency', currency: 'ARS'}).format(dataObj.monto);
                                return ` ${dataObj.valor} venta(s) (${fmtMonto})`;
                            }
                        }
                    }
                }
            }
        });
    }

    // 3. Gráfico Métodos (Barra Horizontal)
    const ctxMetodos = document.getElementById('chartMetodos').getContext('2d');
    if (datosMetodos.length === 0) {
        new Chart(ctxMetodos, {
            type: 'bar',
            data: { labels: ['Sin datos'], datasets: [{ data: [0] }] },
            options: { indexAxis: 'y', plugins: { legend: { display: false } }, responsive: true, maintainAspectRatio: false, scales: { x: { display: false }, y: { display: false } } }
        });
    } else {
        new Chart(ctxMetodos, {
            type: 'bar',
            data: {
                labels: datosMetodos.map(d => d.label),
                datasets: [{
                    label: 'Ventas',
                    data: datosMetodos.map(d => d.valor),
                    backgroundColor: colores,
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { precision: 0 } }
                }
            }
        });
    }

    // 4. Gráfico Entregas (Torta/Doughnut)
    const ctxEntregas = document.getElementById('chartEntregas').getContext('2d');
    if (datosEntregas.length === 0) {
        new Chart(ctxEntregas, {
            type: 'doughnut',
            data: { labels: ['Sin datos'], datasets: [{ data: [1], backgroundColor: ['#e0e0e0'] }] },
            options: { plugins: { tooltip: { enabled: false } }, responsive: true, maintainAspectRatio: false }
        });
    } else {
        new Chart(ctxEntregas, {
            type: 'doughnut',
            data: {
                labels: datosEntregas.map(d => d.label),
                datasets: [{
                    data: datosEntregas.map(d => d.valor),
                    backgroundColor: ['#2a9d8f', '#f4a261'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
