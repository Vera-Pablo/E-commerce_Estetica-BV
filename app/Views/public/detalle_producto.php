<?= $this->extend('Layouts/base') ?>

<?= $this->section('content') ?>
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('catalogo') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Catálogo</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($producto['nombre_producto'] ?? '') ?></li>
            </ol>
        </nav>

        <!-- ============================
             Fila 1: Información Principal
             ============================ -->
        <div class="row g-5 mb-5">

            <!-- Columna Imagen -->
            <div class="col-12 col-md-6">
                <img src="<?= esc(cloudinary_thumb($producto['imagen'] ?? null, 600)) ?>"
                     alt="Imagen de <?= esc($producto['nombre_producto'] ?? '') ?>"
                     class="img-fluid rounded-4 w-100"
                     style="object-fit: cover; max-height: 500px;"
                     loading="lazy" decoding="async">
            </div>

            <!-- Columna Información -->
            <div class="col-12 col-md-6 d-flex flex-column justify-content-center">

                <!-- Sub-fila 1.1: Nombre + Favorito -->
                <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                    <h1 class="font-spartan fw-bold mb-0" style="font-size: 2rem; line-height: 1.2;">
                        <?= esc($producto['nombre_producto'] ?? '') ?>
                    </h1>
                    <button type="button"
                            class="btn p-0 border-0 bg-transparent flex-shrink-0"
                            title="Agregar a favoritos (próximamente)"
                            style="cursor: default;"
                            tabindex="-1">
                        <i class="far fa-heart fs-3 text-danger"></i>
                    </button>
                </div>

                <!-- Categoría -->
                <p class="text-muted mb-3">
                    <i class="fas fa-tag me-1"></i>
                    <span class="fst-italic"><?= esc($producto['nombre_categoria'] ?? '') ?></span>
                </p>

                <!-- Sub-fila 1.2: Precio -->
                <p class="text-black fw-bold fs-2 mb-4">
                    $ <?= number_format((float)($producto['precio'] ?? 0), 2, ',', '.') ?>
                </p>

                <!-- Sub-fila 1.3: Cantidad + Botón -->
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <label for="cantidad" class="form-label fw-bold mb-1">Cantidad</label>
                        <input type="number"
                               id="cantidad"
                               class="form-control"
                               style="width: 90px;"
                               min="1"
                               max="<?= esc($producto['stock'] ?? 0) ?>"
                               value="1">
                    </div>
                    <div class="align-self-end">
                        <button type="button" class="btn btn-custom-nav px-4 py-2">
                            <i class="fas fa-cart-shopping me-2"></i>Agregar al Carrito
                        </button>
                    </div>
                </div>

                <!-- Stock disponible -->
                <p class="text-muted mt-3 mb-0 small">
                    <?php if ((int)($producto['stock'] ?? 0) > 0): ?>
                        <i class="fas fa-circle-check text-success me-1"></i>
                        <?= esc($producto['stock'] ?? 0) ?> unidades disponibles
                    <?php else: ?>
                        <i class="fas fa-circle-xmark text-danger me-1"></i>
                        Sin stock disponible
                    <?php endif; ?>
                </p>

            </div>
        </div>

        <!-- ============================
             Fila 2: Descripción
             ============================ -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 rounded-4" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.1);">
                    <div class="card-body p-4">
                        <h4 class="font-spartan fw-bold mb-3">
                            <i class="fas fa-align-left me-2 text-muted"></i>Descripción del Producto
                        </h4>
                        <p class="mb-0" style="white-space: pre-line; line-height: 1.8;">
                            <?php if (!empty($producto['descripcion_producto'])): ?>
                                <?= nl2br(esc($producto['descripcion_producto'])) ?>
                            <?php else: ?>
                                <span class="text-muted fst-italic">Sin descripción disponible.</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================
             Fila 3: Productos Similares
             ============================ -->
        <?php if (!empty($productos_similares)): ?>
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="font-spartan fw-bold mb-4">Productos Similares</h3>

                <?php $chunks = array_chunk($productos_similares, 4); ?>

                <div id="productosSimilaresCarousel"
                     class="carousel slide carousel-productos"
                     data-bs-ride="carousel"
                     data-bs-interval="3000">

                    <!-- Indicadores -->
                    <?php if (count($chunks) > 1): ?>
                    <div class="carousel-indicators">
                        <?php foreach ($chunks as $i => $chunk): ?>
                            <button type="button"
                                    data-bs-target="#productosSimilaresCarousel"
                                    data-bs-slide-to="<?= $i ?>"
                                    class="<?= $i === 0 ? 'active' : '' ?>"
                                    aria-label="Slide <?= $i + 1 ?>"
                                    <?= $i === 0 ? 'aria-current="true"' : '' ?>></button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="carousel-inner">
                        <?php foreach ($chunks as $i => $chunk): ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                <div class="row g-4 px-2 pb-4">
                                    <?php foreach ($chunk as $sim): ?>
                                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                                            <a href="<?= base_url('producto/' . esc($sim['id_producto'])) ?>"
                                               class="text-decoration-none text-dark">
                                                <div class="card h-100 border-0 rounded-4 card-hover"
                                                     style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                                                    <img src="<?= esc(cloudinary_thumb($sim['imagen'] ?? null)) ?>"
                                                         class="card-img-top product-img bg-light"
                                                         alt="Imagen de <?= esc($sim['nombre_producto']) ?>"
                                                         loading="lazy" decoding="async"
                                                         width="100%" height="250">
                                                    <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                                                        <h5 class="card-title font-spartan fw-bold mb-3">
                                                            <?= esc($sim['nombre_producto']) ?>
                                                        </h5>
                                                        <p class="card-text text-primary fw-bold fs-5 mb-0">
                                                            $ <?= number_format((float)$sim['precio'], 2, ',', '.') ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controles de navegación -->
                    <?php if (count($chunks) > 1): ?>
                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#productosSimilaresCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                            data-bs-target="#productosSimilaresCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php endif; ?>

    </main>

    <?= $this->include('Layouts/footer') ?>
<?= $this->endSection() ?>
