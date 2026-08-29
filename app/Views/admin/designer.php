<?= $this->extend('Layouts/admin/base_admin') ?>

<?= $this->section('content') ?>
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="font-spartan fw-bold text-dark m-0">
                <i class="fas fa-paint-brush text-primary me-2"></i> Designer — Hero Carousel
            </h1>
            <p class="text-muted small m-0 mt-1">Gestiona los slides visuales de la página principal en tiempo real.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span id="slideCountBadge" class="badge bg-dark rounded-pill px-3 py-2 fs-6">
                <?= count($banners) ?> / 8 slides
            </span>
            <button type="button" 
                    id="btnAddSlide" 
                    class="btn btn-custom-nav rounded-3 font-spartan fw-bold" 
                    onclick="agregarSlide()" 
                    <?= count($banners) >= 8 ? 'disabled' : '' ?>>
                <i class="fas fa-plus me-2"></i> Agregar Slide
            </button>
        </div>
    </div>

    <!-- Elementos ocultos para ToastHelper -->
    <?php if (session()->getFlashdata('success')): ?>
        <input type="hidden" id="flash-success" value="<?= esc(session()->getFlashdata('success')) ?>">
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <input type="hidden" id="flash-error" value="<?= esc(session()->getFlashdata('error')) ?>">
    <?php endif; ?>

    <!-- Formulario Principal -->
    <form id="designerForm" method="post" action="<?= base_url('admin/designer/guardar') ?>">
        <?= csrf_field() ?>

        <div id="slidesContainer" class="d-flex flex-column gap-4 mb-4">
            <?php foreach ($banners as $index => $b): ?>
                <div class="card border-0 rounded-4 shadow-sm slide-card" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.15) !important;">
                    <div class="card-header bg-white border-0 py-3 px-4 rounded-top-4 d-flex justify-content-between align-items-center">
                        <h5 class="font-spartan fw-bold text-dark m-0">
                            <i class="fas fa-sliders-h me-2 text-secondary"></i> Slide #<span class="slide-num"><?= $index + 1 ?></span>
                        </h5>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="eliminarSlide(this)">
                            <i class="fas fa-trash-alt me-1"></i> Eliminar
                        </button>
                    </div>

                    <div class="card-body p-4">
                        <!-- Vista Previa + URL de Imagen -->
                        <div class="row align-items-center mb-3 g-3">
                            <div class="col-auto">
                                <img class="img-preview rounded-3 border bg-light shadow-sm" 
                                     src="<?= esc(!empty($b['imagen']) ? $b['imagen'] : base_url('assets/images/banners/no_image.webp')) ?>" 
                                     alt="Vista Previa Slide" 
                                     style="width: 160px; height: 100px; object-fit: cover;" 
                                     onerror="this.src='<?= base_url('assets/images/banners/no_image.webp') ?>'">
                            </div>
                            <div class="col">
                                <label class="form-label fw-bold">Imagen (URL Cloudinary)</label>
                                <input type="url" 
                                       name="imagen[]" 
                                       class="form-control rounded-3 border-secondary" 
                                       placeholder="https://res.cloudinary.com/..." 
                                       value="<?= esc($b['imagen'] ?? '') ?>" 
                                       oninput="actualizarPreview(this)">
                                <div class="form-text">Si se deja vacío o la URL no carga, se usará <code>banners/no_image.webp</code>.</div>
                            </div>
                        </div>

                        <!-- Título y Subtítulo -->
                        <div class="row mb-3 g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Título <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="titulo[]" 
                                       class="form-control rounded-3 border-secondary" 
                                       placeholder="Ej. Estética BV" 
                                       value="<?= esc($b['titulo'] ?? '') ?>" 
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Subtítulo</label>
                                <input type="text" 
                                       name="subtitulo[]" 
                                       class="form-control rounded-3 border-secondary" 
                                       placeholder="Ej. Estética Integral y Cuidado Personal" 
                                       value="<?= esc($b['subtitulo'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Botón Primario y Botón Secundario -->
                        <div class="row g-3">
                            <!-- Botón 1 -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold font-spartan text-secondary mb-2"><i class="fas fa-link me-1"></i> Botón Primario</h6>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Texto</label>
                                        <input type="text" 
                                               name="btn1_texto[]" 
                                               class="form-control form-control-sm rounded-3 border-secondary" 
                                               placeholder="Ej. Explorar Catálogo" 
                                               value="<?= esc($b['btn_primario_texto'] ?? '') ?>">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">URL / Ruta</label>
                                        <input type="text" 
                                               name="btn1_url[]" 
                                               class="form-control form-control-sm rounded-3 border-secondary" 
                                               placeholder="Ej. catalogo" 
                                               value="<?= esc($b['btn_primario_url'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Botón 2 -->
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold font-spartan text-secondary mb-2"><i class="fas fa-link me-1"></i> Botón Secundario</h6>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Texto</label>
                                        <input type="text" 
                                               name="btn2_texto[]" 
                                               class="form-control form-control-sm rounded-3 border-secondary" 
                                               placeholder="Ej. Hacer Consulta" 
                                               value="<?= esc($b['btn_secundario_texto'] ?? '') ?>">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">URL / Ruta</label>
                                        <input type="text" 
                                               name="btn2_url[]" 
                                               class="form-control form-control-sm rounded-3 border-secondary" 
                                               placeholder="Ej. consultas" 
                                               value="<?= esc($b['btn_secundario_url'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Botón Guardar Todos -->
        <div class="d-flex justify-content-end mb-5">
            <button type="submit" class="btn btn-custom-nav btn-lg rounded-3 font-spartan fw-bold px-5">
                <i class="fas fa-save me-2"></i> Guardar Todos los Cambios
            </button>
        </div>
    </form>

    <!-- Plantilla oculta para agregar nuevos slides vía JS -->
    <template id="slideTemplate">
        <div class="card border-0 rounded-4 shadow-sm slide-card" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.15) !important;">
            <div class="card-header bg-white border-0 py-3 px-4 rounded-top-4 d-flex justify-content-between align-items-center">
                <h5 class="font-spartan fw-bold text-dark m-0">
                    <i class="fas fa-sliders-h me-2 text-secondary"></i> Slide #<span class="slide-num">1</span>
                </h5>
                <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="eliminarSlide(this)">
                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                </button>
            </div>

            <div class="card-body p-4">
                <!-- Vista Previa + URL de Imagen -->
                <div class="row align-items-center mb-3 g-3">
                    <div class="col-auto">
                        <img class="img-preview rounded-3 border bg-light shadow-sm" 
                             src="<?= base_url('assets/images/banners/no_image.webp') ?>" 
                             alt="Vista Previa Slide" 
                             style="width: 160px; height: 100px; object-fit: cover;" 
                             onerror="this.src='<?= base_url('assets/images/banners/no_image.webp') ?>'">
                    </div>
                    <div class="col">
                        <label class="form-label fw-bold">Imagen (URL Cloudinary)</label>
                        <input type="url" 
                               name="imagen[]" 
                               class="form-control rounded-3 border-secondary" 
                               placeholder="https://res.cloudinary.com/..." 
                               oninput="actualizarPreview(this)">
                        <div class="form-text">Si se deja vacío o la URL no carga, se usará <code>banners/no_image.webp</code>.</div>
                    </div>
                </div>

                <!-- Título y Subtítulo -->
                <div class="row mb-3 g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Título <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="titulo[]" 
                               class="form-control rounded-3 border-secondary" 
                               placeholder="Ej. Nuevo Título" 
                               required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subtítulo</label>
                        <input type="text" 
                               name="subtitulo[]" 
                               class="form-control rounded-3 border-secondary" 
                               placeholder="Ej. Descripción del nuevo slide">
                    </div>
                </div>

                <!-- Botón Primario y Botón Secundario -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold font-spartan text-secondary mb-2"><i class="fas fa-link me-1"></i> Botón Primario</h6>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Texto</label>
                                <input type="text" 
                                       name="btn1_texto[]" 
                                       class="form-control form-control-sm rounded-3 border-secondary" 
                                       placeholder="Ej. Explorar Catálogo">
                            </div>
                            <div>
                                <label class="form-label small fw-bold">URL / Ruta</label>
                                <input type="text" 
                                       name="btn1_url[]" 
                                       class="form-control form-control-sm rounded-3 border-secondary" 
                                       placeholder="Ej. catalogo">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold font-spartan text-secondary mb-2"><i class="fas fa-link me-1"></i> Botón Secundario</h6>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Texto</label>
                                <input type="text" 
                                       name="btn2_texto[]" 
                                       class="form-control form-control-sm rounded-3 border-secondary" 
                                       placeholder="Ej. Hacer Consulta">
                            </div>
                            <div>
                                <label class="form-label small fw-bold">URL / Ruta</label>
                                <input type="text" 
                                       name="btn2_url[]" 
                                       class="form-control form-control-sm rounded-3 border-secondary" 
                                       placeholder="Ej. consultas">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </template>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        const noImageUrl = '<?= base_url('assets/images/banners/no_image.webp') ?>';
        const maxSlides = 8;

        function actualizarPreview(input) {
            const card = input.closest('.slide-card');
            const img = card.querySelector('.img-preview');
            const val = input.value.trim();
            img.src = val ? val : noImageUrl;
        }

        function actualizarNumeracion() {
            const cards = document.querySelectorAll('#slidesContainer .slide-card');
            cards.forEach((card, idx) => {
                const numSpan = card.querySelector('.slide-num');
                if (numSpan) numSpan.textContent = idx + 1;
            });

            const badge = document.getElementById('slideCountBadge');
            const btnAdd = document.getElementById('btnAddSlide');

            if (badge) badge.textContent = `${cards.length} / ${maxSlides} slides`;
            if (btnAdd) btnAdd.disabled = cards.length >= maxSlides;
        }

        function eliminarSlide(btn) {
            const cards = document.querySelectorAll('#slidesContainer .slide-card');
            if (cards.length <= 1) {
                alert('Debe haber al menos 1 slide.');
                return;
            }

            if (confirm('¿Está seguro de eliminar este slide?')) {
                const card = btn.closest('.slide-card');
                card.remove();
                actualizarNumeracion();
            }
        }

        function agregarSlide() {
            const cards = document.querySelectorAll('#slidesContainer .slide-card');
            if (cards.length >= maxSlides) return;

            const template = document.getElementById('slideTemplate');
            const clone = template.content.cloneNode(true);
            document.getElementById('slidesContainer').appendChild(clone);
            actualizarNumeracion();
        }
    </script>
<?= $this->endSection() ?>
