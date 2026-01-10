<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="card shadow-md border-3">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="text-center p-3 border rounded bg-light">
                        <img src="<?= $product->image_url ?>" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 400px; object-fit: contain;"
                             alt="<?= esc($product->name) ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <h1 class="fw-bold"><?= esc($product->name) ?></h1>
                    
                    <div class="mb-3">
                        <span class="h2 text-primary fw-bold"><?= $product->formatted_price ?></span>                        
                        <?php if($product->stock > 0): ?>
                            <span class="badge bg-success ms-2">En Stock (<?= $product->stock ?>)</span>
                        <?php else: ?>
                            <span class="badge bg-danger ms-2">Agotado</span>
                        <?php endif; ?>
                    </div>

                    <p class="lead text-muted">
                        <?= nl2br(esc((string)$product->description)) ?>
                    </p>

                    <hr>

                    <form action="<?= base_url('cart/add') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $product->id_product ?>">
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-auto">
                                <label for="quantity" class="col-form-label fw-bold">Cantidad:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" name="qty" id="quantity" class="form-control text-center" 
                                    value="1" min="1" max="<?= $product->stock ?>" style="width: 80px;">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg"<?= ($product->stock <= 0) ? 'disabled' : '' ?>>
                                <i class="bi bi-cart-plus"></i> Agregar al Carrito
                            </button>
                            
                            <a href="https://wa.me/5491112345678?text=Hola, quiero consultar por el producto: <?= esc($product->name) ?>" 
                            class="btn btn-outline-success" target="_blank">
                                <i class="bi bi-whatsapp"></i> Consultar por WhatsApp
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>