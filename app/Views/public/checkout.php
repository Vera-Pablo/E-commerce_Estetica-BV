<?php
/**
 * @var array $items
 * @var float $total
 * @var int $totalItems
 * @var array $metodosPago
 */
$total = $total ?? 0;
?>
<?= $this->extend('Layouts/base') ?>

<?= $this->section('content') ?>
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="font-spartan fw-bold">
                    <i class="fas fa-credit-card me-2"></i>Checkout
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('catalogo') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Catálogo</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('carrito') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Carrito</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Formulario unificado -->
        <form action="<?= base_url('carrito/checkout/procesar') ?>" method="POST" id="form-checkout">
            <?= csrf_field() ?>
            <div class="row g-4">
                
                <!-- Columna 1: Detalle de Componentes -->
                <div class="col-12 col-lg-8">
                    
                    <!-- Fila 1: Productos (Solo lectura) -->
                    <div class="mb-4">
                        <h5 class="font-spartan fw-bold mb-3"><i class="fas fa-box-open me-2"></i>Tus Productos</h5>
                        <?php foreach ($items as $item): ?>
                        <div class="card border-0 rounded-4 mb-3" style="box-shadow: 0px 4px 10px rgba(0,0,0,0.05);">
                            <div class="card-body p-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 col-md-2">
                                        <img src="<?= esc(cloudinary_thumb($item['imagen'] ?? null)) ?>"
                                             alt="<?= esc($item['nombre_producto']) ?>"
                                             class="img-fluid rounded-3"
                                             style="object-fit: cover; height: 80px; width: 100%;"
                                             loading="lazy">
                                    </div>
                                    <div class="col-9 col-md-10">
                                        <h6 class="font-spartan fw-bold mb-1"><?= esc($item['nombre_producto']) ?></h6>
                                        <p class="text-muted small mb-0">Cantidad: <?= esc($item['cantidad']) ?> unidades</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Fila 2: Forma de Entrega -->
                    <div class="card border-0 rounded-4 mb-4" style="box-shadow: 0px 4px 10px rgba(0,0,0,0.05);">
                        <div class="card-body p-4">
                            <h5 class="font-spartan fw-bold mb-3">Forma de Entrega</h5>
                            
                            <div class="form-check d-flex align-items-center mb-3 p-3 border rounded-3 text-dark bg-light">
                                <input class="form-check-input m-0" type="radio" name="tipo_entrega" id="entrega1" value="Retiro en local" required checked style="cursor: pointer; transform: scale(1.2);">
                                <label class="form-check-label fw-bold ms-3 flex-grow-1" style="cursor: pointer;" for="entrega1">
                                    <i class="fas fa-store me-2 text-dark"></i>Retiro en local
                                </label>
                            </div>
                            
                            <div class="form-check d-flex align-items-center p-3 border rounded-3 text-dark bg-light">
                                <input class="form-check-input m-0" type="radio" name="tipo_entrega" id="entrega2" value="Envío a domicilio" required style="cursor: pointer; transform: scale(1.2);">
                                <label class="form-check-label fw-bold ms-3 flex-grow-1" style="cursor: pointer;" for="entrega2">
                                    <i class="fas fa-truck me-2 text-dark"></i>Envío a domicilio
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Fila 3: Método de Pago -->
                    <div class="card border-0 rounded-4 mb-4" style="box-shadow: 0px 4px 10px rgba(0,0,0,0.05);">
                        <div class="card-body p-4">
                            <h5 class="font-spartan fw-bold mb-3">Método de Pago</h5>
                            <div class="row g-3">
                                <?php foreach ($metodosPago as $index => $mp): ?>
                                <div class="col-12 col-md-6">
                                    <div class="form-check d-flex align-items-center p-3 border rounded-3 text-dark bg-light">
                                        <input class="form-check-input m-0" type="radio" name="id_metodo_pago" id="pago<?= $mp['id_metodo_pago'] ?>" value="<?= $mp['id_metodo_pago'] ?>" required <?= $index === 0 ? 'checked' : '' ?> style="cursor: pointer; transform: scale(1.2);">
                                        <label class="form-check-label fw-bold ms-3 flex-grow-1" style="cursor: pointer;" for="pago<?= $mp['id_metodo_pago'] ?>">
                                            <i class="fas me-2 text-dark"></i><?= esc($mp['nombre_metodo_pago']) ?>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Columna 2: Resumen -->
                <div class="col-12 col-lg-4">
                    <div class="card border-0 rounded-4" style="box-shadow: 0px 6px 14px rgba(0,0,0,0.1); position: sticky; top: 100px;">
                        <div class="card-body p-4">
                            <h5 class="font-spartan fw-bold mb-4">Resumen Final</h5>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Productos (<?= ($totalItems) ?>)</span>
                                <span class="fw-bold">$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold font-spartan fs-5">Total a Pagar</span>
                                <span class="fw-bold text-dark fs-5">$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>

                            <button type="submit" class="btn btn-custom-nav btn-lg w-100" id="btn-submit-checkout">
                                <i class="fas fa-check-circle me-2"></i>Pagar y Finalizar
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </main>

    <?= $this->include('Layouts/footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formCheckout = document.getElementById('form-checkout');
    const btnSubmit = document.getElementById('btn-submit-checkout');

    formCheckout.addEventListener('submit', function (e) {
        // Prevenir el doble clic
        if (btnSubmit.disabled) {
            e.preventDefault();
            return;
        }
        
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Procesando...';
    });
});
</script>
<?= $this->endSection() ?>
