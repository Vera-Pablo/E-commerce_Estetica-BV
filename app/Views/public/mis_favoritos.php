<?= $this->extend('Layouts/base') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Mis Favoritos') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Navbar Component -->
    <?= $this->include('Layouts/navbar') ?>

<main class="py-5" style="background-color: #fff6e9; min-height: 80vh;">
    <div class="container px-lg-4">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('perfil') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Mi Cuenta</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Mis Favoritos</li>
            </ol>
        </nav>

        <div class="mb-4">
            <h1 class="font-spartan fw-bold mb-1 d-flex align-items-center">
                 Mis Favoritos
            </h1>
            <p class="text-muted mb-0">Productos que guardaste (<?= count($productos) ?>)</p>
        </div>

        <?php if (empty($productos)): ?>
            <!-- Estado Vacío -->
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border-0 mt-4">
                <i class="far fa-heart fa-4x text-muted mb-3 opacity-50"></i>
                <h3 class="font-spartan fw-bold">No tienes ningún favorito guardado.</h3>
                <p class="text-muted mb-4">Explora nuestro catálogo y guarda los productos que más te gusten.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-custom-nav px-4 py-2 rounded-5 fw-bold">Ir al catálogo</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($productos as $prod): ?>
                    <?php $isFavorito = in_array($prod['id_producto'], $favoritosIds); ?>
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3" id="fav-card-<?= $prod['id_producto'] ?>">
                        <div class="card h-100 border-0 rounded-4 card-hover position-relative" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                            
                            <!-- Botón Favorito Absoluto -->
                            <button type="button" 
                                    class="btn p-2 border-0 bg-transparent position-absolute top-0 end-0 m-2" 
                                    style="z-index: 10;"
                                    title="Quitar de favoritos"
                                    onclick="removerDesdeFavoritos(<?= $prod['id_producto'] ?>, this)">
                                <i class="fas fa-heart fs-4 text-danger"></i>
                            </button>

                            <a href="<?= base_url('producto/' . esc($prod['id_producto'])) ?>" class="text-decoration-none text-dark">
                                <img src="<?= esc(cloudinary_thumb($prod['imagen'] ?? null)) ?>" 
                                     class="card-img-top product-img bg-light rounded-top-4" 
                                     alt="Imagen de <?= esc($prod['nombre_producto']) ?>" 
                                     loading="lazy" decoding="async" style="height: 250px; object-fit: cover;">
                            </a>
                            <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                                <a href="<?= base_url('producto/' . esc($prod['id_producto'])) ?>" class="text-decoration-none text-dark">
                                    <h5 class="card-title fw-bold font-spartan text-truncate mb-1" title="<?= esc($prod['nombre_producto']) ?>">
                                        <?= esc($prod['nombre_producto']) ?>
                                    </h5>
                                    <p class="text-muted small mb-2 fst-italic"><?= esc($prod['nombre_categoria']) ?></p>
                                    <p class="card-text fw-bold fs-5 mb-3" style="color: #000;">
                                        $<?= number_format((float)($prod['precio'] ?? 0), 2, ',', '.') ?>
                                    </p>
                                </a>
                                <div class="mt-auto">
                                    <!-- Formulario para agregar al carrito -->
                                    <form action="<?= base_url('carrito/agregar') ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_producto" value="<?= esc($prod['id_producto']) ?>">
                                        <input type="hidden" name="cantidad" value="1">
                                        <button type="submit" class="btn btn-custom-nav px-4 py-2 w-100 fw-bold" <?= (int)($prod['stock'] ?? 0) === 0 ? 'disabled' : '' ?>>
                                            <i class="fas fa-cart-shopping me-2"></i>Al Carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
async function removerDesdeFavoritos(idProducto, btn) {
    try {
        const res = await fetch('<?= base_url('favorito/toggle') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ 'id_producto': idProducto })
        });
        if (res.ok) {
            const data = await res.json();
            if (data.status === 'removed') {
                // Ocultar card de la grilla
                const card = document.getElementById('fav-card-' + idProducto);
                if(card) card.remove();
                if (typeof ToastHelper !== 'undefined') ToastHelper.show('success', 'Removido de favoritos');
                
                // Si ya no quedan cards, recargar para mostrar el "estado vacío"
                if(document.querySelectorAll('[id^="fav-card-"]').length === 0) {
                    window.location.reload();
                }
            }
        }
    } catch (e) {
        console.error(e);
        if (typeof ToastHelper !== 'undefined') ToastHelper.show('error', 'Error de conexión');
    }
}
</script>
<?= $this->endSection() ?>
