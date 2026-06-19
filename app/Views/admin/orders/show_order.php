<?= $this->extend('layouts/admin_panel.php') ?>
<?= $this->section('title') ?> Detalle de Venta <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container mt-4">
        <h2 class="mb-4">Detalle de la Venta #<?= $order->id_order ?></h2>

        <div class="card mb-4">
            <div class="card-header">
                Información del Cliente
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> <?= esc($order->first_name . ' ' . $order->last_name) ?></p>
                <p><strong>Email:</strong> <?= esc($order->email) ?></p>
                <p><strong>DNI:</strong> <?= esc($order->dni) ?></p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                Detalles de la Venta
            </div>
            <div class="card-body">
                <p><strong>Fecha de la Venta:</strong> <?= esc($order->created_at) ?></p>
                <p><strong>Estado:</strong> <?= esc($order->status_name) ?></p>
                <p><strong>Total:</strong> $<?= number_format($order->total, 2) ?></p>
            </div>
        </div>

        <!-- detalles de la venta, como los productos comprados -->
        <div class="card mb-4">
            <div class="card-header">
                Productos Comprados
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $detail): ?>
                            <tr>
                                <td><?= esc($detail->name) ?></td>
                                <td><?= esc($detail->quantity) ?></td>
                                <td>$<?= number_format($detail->subtotal, 2) ?></td>
                                <td>$<?= number_format($detail->quantity * $detail->subtotal, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary">Volver a la Lista de Ventas</a>

<?= $this->endSection() ?>