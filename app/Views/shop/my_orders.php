<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Mis pedidos<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7 text-white">
                <h1 class="display-4 fw-bold mb-4">
                    Mis Pedidos
                </h1>
                <p class="lead mb-4">
                    Historial de todas tus compras realizadas en nuestra tienda.
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

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Número de Orden</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders) && is_array($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= esc($order->order_number) ?></td>
                                <td><?= esc(date('d/m/Y', strtotime($order->created_at))) ?></td>
                                <td>$<?= number_format($order->total, 2) ?></td>
                               
                                <td><?= esc($order->status_name ?? 'Desconocido') ?></td>
                                <td><a href="<?= base_url('order/' . esc($order->id_order)) ?>" class="btn btn-sm btn-primary">Ver Detalles</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No has realizado ningún pedido aún.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>