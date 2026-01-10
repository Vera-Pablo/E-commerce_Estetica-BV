<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <h1 class="mb-4 fw-bold">Carrito de Compras</h1>

    <?php if (empty($items)): ?>
        <div class="text-center py-5 bg-light rounded">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <h3 class="mt-3">Tu carrito está vacío</h3>
            <p class="text-muted">Parece que aún no has elegido tus tratamientos.</p>
            <a href="<?= base_url('catalog') ?>" class="btn btn-primary mt-3">
                Ir al Catálogo
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Producto</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Cantidad</th>
                                        <th scope="col" class="text-center">Subtotal</th>
                                        <th scope="col" class="text-end pe-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= $item['img'] ?>" alt="" 
                                                         class="rounded me-3" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                    
                                                    <div>
                                                        <h6 class="mb-0 text-truncate" style="max-width: 200px;">
                                                            <?= esc($item['name']) ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">$<?= number_format($item['price'], 2) ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">
                                                    <?= $item['qty'] ?>
                                                </span>
                                            </td>
                                            <td class="text-center fw-bold text-primary">
                                                $<?= number_format($item['price'] * $item['qty'], 2) ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('cart/delete/' . $item['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('¿Estás seguro de quitar este producto?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="<?= base_url('cart/clear') ?>" class="text-danger small text-decoration-none"
                       onclick="return confirm('¿Vaciar todo el carrito?')">
                        <i class="bi bi-trash"></i> Vaciar carrito
                    </a>
                </div>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Resumen del Pedido</h5>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">$<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Envío</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Total</span>
                            <span class="h4 fw-bold text-primary">$<?= number_format($total, 2) ?></span>
                        </div>

                        <div class="d-grid">
                            <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-lg py-3">
                                Proceder al Pago <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <a href="<?= base_url('catalog') ?>" class="text-muted text-decoration-none small">
                                <i class="bi bi-arrow-left"></i> Seguir comprando
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>