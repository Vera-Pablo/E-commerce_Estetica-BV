<?= $this->extend('Layouts/base') ?>

<?= $this->section('content') ?>
    <!-- Navbar Component -->
    <?= $this->include('Layouts/navbar') ?>

    <!-- Hero Carousel Component (Dinámico desde banners.json) -->
    <?php if (!empty($banners)): ?>
        <div id="introCarousel" class="carousel slide carousel-fade shadow-2-strong" data-bs-ride="carousel" data-bs-interval="5000">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php foreach ($banners as $index => $b): ?>
                    <button type="button" 
                            data-bs-target="#introCarousel" 
                            data-bs-slide-to="<?= $index ?>" 
                            class="<?= $index === 0 ? 'active' : '' ?>" 
                            aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                            aria-label="Slide <?= $index + 1 ?>">
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Inner Slides -->
            <div class="carousel-inner">
                <?php foreach ($banners as $index => $banner): ?>
                    <?php
                        $imgPath = $banner['imagen'] ?? '';
                        if (!empty($imgPath) && (str_starts_with($imgPath, 'http://') || str_starts_with($imgPath, 'https://') || str_starts_with($imgPath, '//'))) {
                            $bgUrl = $imgPath;
                        } elseif (!empty($imgPath) && file_exists(FCPATH . 'assets/images/' . $imgPath)) {
                            $bgUrl = base_url('assets/images/' . $imgPath);
                        } elseif (!empty($imgPath) && file_exists(FCPATH . $imgPath)) {
                            $bgUrl = base_url($imgPath);
                        } else {
                            $bgUrl = base_url('assets/images/banners/no_image.webp');
                        }
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" 
                         style="background-image: url('<?= esc($bgUrl) ?>'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
                        <div class="mask h-100" style="background-color: rgba(0, 0, 0, 0.6);">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="text-white text-center px-4" style="max-width: 800px;">
                                    <?php if (!empty($banner['titulo'])): ?>
                                        <h1 class="mb-3 display-3 fw-bold text-uppercase" style="letter-spacing: 2px;">
                                            <?= esc($banner['titulo']) ?>
                                        </h1>
                                    <?php endif; ?>

                                    <?php if (!empty($banner['subtitulo'])): ?>
                                        <h5 class="mb-4 lead fs-3 fw-light">
                                            <?= esc($banner['subtitulo']) ?>
                                        </h5>
                                    <?php endif; ?>

                                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                                        <?php if (!empty($banner['btn_primario_texto'])): ?>
                                            <a class="btn btn-custom-nav btn-lg px-4 py-2" 
                                               href="<?= base_url(esc($banner['btn_primario_url'] ?? '')) ?>" 
                                               role="button">
                                                <?= esc($banner['btn_primario_texto']) ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (!empty($banner['btn_secundario_texto'])): ?>
                                            <a class="btn btn-custom-back btn-lg px-4 py-2" 
                                               href="<?= base_url(esc($banner['btn_secundario_url'] ?? '')) ?>" 
                                               role="button">
                                                <?= esc($banner['btn_secundario_texto']) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#introCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#introCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Carrusel de Productos Destacados -->
    <?php if (!empty($productos_destacados)): ?>
        <section class="py-5 bg-light-subtle">
            <div class="container">
                <h2 class="text-center fw-bold font-spartan mb-4">Productos Destacados</h2>
                
                <div id="productosCarousel" class="carousel slide carousel-productos" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner px-2 py-3">
                        <?php foreach (array_chunk($productos_destacados, 4) as $chunkIndex => $chunk): ?>
                            <div class="carousel-item <?= $chunkIndex === 0 ? 'active' : '' ?>">
                                <div class="row g-4 justify-content-center">
                                    <?php foreach ($chunk as $prod): ?>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <a href="<?= base_url('producto/' . esc($prod['id_producto'])) ?>" class="text-decoration-none text-dark">
                                                <div class="card h-100 border-0 rounded-4 card-hover" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                                                    <img src="<?= esc(cloudinary_thumb($prod['imagen'] ?? null)) ?>" 
                                                         class="card-img-top product-img bg-light" 
                                                         alt="Imagen de <?= esc($prod['nombre_producto']) ?>" 
                                                         loading="lazy" decoding="async" width="100%" height="250">
                                                    <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                                                        <h5 class="card-title font-spartan fw-bold mb-3 text-truncate"><?= esc($prod['nombre_producto']) ?></h5>
                                                        <p class="card-text text-primary fw-bold fs-5 mb-0">$ <?= number_format((float)$prod['precio'], 2, ',', '.') ?></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($productos_destacados) > 4): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productosCarousel" data-bs-slide="prev" style="width: 5%;">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productosCarousel" data-bs-slide="next" style="width: 5%;">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Card Destacada al pie -->
    <section class="py-5">
        <div class="container">
            <div class="card border-0 rounded-4 overflow-hidden" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                <div class="row g-0 align-items-center">
                    <!-- Texto a la izquierda -->
                    <div class="col-md-8">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="font-spartan fw-bold text-dark mb-3">Descubre la Experiencia BV</h2>
                            <p class="lead text-muted mb-4">
                                En Estética BV nos apasiona resaltar tu belleza natural y cuidar tu bienestar integral. Ofrecemos tratamientos faciales y corporales personalizados con tecnología de vanguardia y cosmética de la más alta calidad.
                            </p>
                            <a href="<?= base_url('quienes-somos') ?>" class="btn btn-custom-nav btn-lg rounded-3 font-spartan fw-bold">
                                Conócenos Más <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Imagen a la derecha -->
                    <div class="col-md-4 h-100">
                        <img src="<?= base_url('assets/images/banners/lavado-cabello.webp') ?>" 
                             class="img-fluid w-100 h-100 object-fit-cover" 
                             alt="Estética BV" 
                             loading="lazy" 
                             style="min-height: 250px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
    <div class="container">
        <div class="card border-0 rounded-4 overflow-hidden" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
            <div class="row g-0 align-items-center">
                <!-- Imagen a la derecha -->
                <div class="col-md-4 h-100">
                    <img src="<?= base_url('assets/images/banners/productos-estetica.webp') ?>" 
                        class="img-fluid w-100 h-100 object-fit-cover" 
                        alt="Estética BV" 
                        loading="lazy" 
                        style="min-height: 250px; object-fit: cover;">
                </div>
                <!-- Texto a la izquierda -->
                <div class="col-md-8">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="font-spartan fw-bold text-dark mb-3">Productos BV: Belleza y Bienestar en tus manos</h2>
                        <p class="lead text-muted mb-4">
                            En Estética BV creemos que el cuidado de tu cuero cabelludo y cabello comienza también en casa. Por eso contamos con una línea exclusiva de productos que complementan nuestros tratamientos profesionales y potencian sus resultados.
                        </p>
                        <a href="<?= base_url('catalogo') ?>" class="btn btn-custom-nav btn-lg rounded-3 font-spartan fw-bold">
                            Conócenos Más <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

<?= $this->endSection() ?>
