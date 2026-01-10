<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <h2 class="mb-4">Resumen de Compra</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4 shadow-sm border-0">
                <h4 class="mb-3">Datos del Cliente</h4>
                <p><strong>Usuario:</strong> <?= esc($user) ?></p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Por el momento, el pago se coordina en el local o contra entrega.
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 bg-light border-0">
                <h4 class="mb-3">Total a Pagar</h4>
                <h1 class="text-primary fw-bold">$<?= number_format($total, 2) ?></h1>
                
                <form action="<?= base_url('checkout/process') ?>" method="post">
                    <button type="submit" class="btn btn-success btn-lg w-100 mt-3">
                        <i class="bi bi-check-circle"></i> Confirmar Pedido
                    </button>
                </form>
                
                <a href="<?= base_url('cart') ?>" class="btn btn-link w-100 mt-2">Volver al carrito</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>