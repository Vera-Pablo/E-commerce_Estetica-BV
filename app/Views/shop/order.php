<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Mi pedido<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7 text-white">
                <h1 class="display-4 fw-bold mb-4">
                    Pedido #<?= esc($order->order_number) ?>
                </h1>
                <p class="lead mb-4">
                    Detalles de tu pedido realizado el <?= esc(date('d/m/Y', strtotime($order->created_at))) ?>.
                </p>
            </div>
    </div>
</section>

<section>
    <div class="container my-5">
        <?php if (session()->getFlashdata('msg')): ?>
            <?php $msg = session()->getFlashdata('msg'); ?>
            <div class="alert alert-<?= esc($msg['type']) ?> alert-dismissible fade show" role="alert">
                <?= esc($msg['body']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Detalles del Pedido</h2>
        <p><strong>Número de Orden:</strong> <?= esc($order->order_number) ?></p>
        <p><strong>Fecha:</strong> <?= esc(date('d/m/Y', strtotime($order->created_at))) ?></p>
        <p><strong>Total:</strong> $<?= number_format($order->total, 2) ?></p>
        <p><strong>Estado:</strong> <?= esc($order->status_name ?? 'Desconocido') ?></p>

        <h3 class="mt-5 mb-4">Productos</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?= esc($item->product_name) ?></td>
                            <td><?= esc($item->quantity) ?></td>
                            <td>$<?= number_format($item->subtotal / $item->quantity, 2) ?></td>
                            <td>$<?= number_format($item->subtotal, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>