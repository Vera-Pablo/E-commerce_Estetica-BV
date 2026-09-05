<?php
/**
 * @var array $venta
 * @var array $detalles
 */
?>
<?= $this->extend('Layouts/base') ?>

<?= $this->section('content') ?>
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                
                <div class="card border-0 rounded-4 overflow-hidden mb-4" style="box-shadow: 0px 8px 24px rgba(0,0,0,0.12);">
                    <!-- Cabecera Destacada -->
                    <div class="bg-success text-white text-center py-5">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h2 class="font-spartan fw-bold">¡Compra Exitosa!</h2>
                        <p class="mb-0 fs-5">Tu pedido ha sido registrado correctamente.</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        
                        <!-- Detalles de la Venta -->
                        <div class="row mb-5 g-4 bg-light rounded-3 p-3 mx-0">
                            <div class="col-sm-6 col-md-3 text-center text-sm-start">
                                <span class="text-muted small d-block mb-1">N° de Orden</span>
                                <span class="fw-bold fs-5">#<?= esc($venta['id_venta']) ?></span>
                            </div>
                            <div class="col-sm-6 col-md-3 text-center text-sm-start">
                                <span class="text-muted small d-block mb-1">Fecha</span>
                                <span class="fw-bold fs-5"><?= date('d/m/Y', strtotime($venta['fecha_venta'])) ?></span>
                            </div>
                            <div class="col-sm-6 col-md-3 text-center text-sm-start">
                                <span class="text-muted small d-block mb-1">Forma de Entrega</span>
                                <span class="fw-bold fs-6"><i class="fas <?= $venta['tipo_entrega'] === 'Retiro en local' ? 'fa-store' : 'fa-truck' ?> text-secondary me-1"></i><?= esc($venta['tipo_entrega']) ?></span>
                            </div>
                            <div class="col-sm-6 col-md-3 text-center text-sm-start">
                                <span class="text-muted small d-block mb-1">Método de Pago</span>
                                <span class="fw-bold fs-6"><i class="fas text-success me-1"></i><?= esc($venta['nombre_metodo_pago']) ?></span>
                            </div>
                        </div>

                        <h5 class="font-spartan fw-bold mb-3">Detalle de Artículos</h5>
                        
                        <!-- Tabla Resumen -->
                        <div class="table-responsive mb-4">
                            <table class="table table-borderless align-middle">
                                <thead class="border-bottom">
                                    <tr>
                                        <th class="text-muted small fw-bold">Producto</th>
                                        <th class="text-muted small fw-bold text-center">Cant.</th>
                                        <th class="text-muted small fw-bold text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($detalles as $det): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><?= esc($det['nombre_producto']) ?></span><br>
                                            <small class="text-muted">$ <?= number_format($det['precio_unitario'], 2, ',', '.') ?> c/u</small>
                                        </td>
                                        <td class="text-center"><?= esc($det['cantidad']) ?></td>
                                        <td class="text-end fw-bold">$ <?= number_format($det['subtotal'], 2, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold pt-3 fs-5">TOTAL</td>
                                        <td class="text-end fw-bold text-dark pt-3 fs-4">$ <?= number_format($venta['total'], 2, ',', '.') ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Botón Volver -->
                        <div class="text-center mt-5">
                            <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-dark rounded-pill px-5 py-2">
                                <i class="fas fa-store me-2"></i>Volver al Catálogo
                            </a>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    <?= $this->include('Layouts/footer') ?>
<?= $this->endSection() ?>
