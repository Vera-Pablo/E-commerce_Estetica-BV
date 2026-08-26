<?= $this->extend('Layouts/admin/base_admin') ?>
<?= $this->section('styles') ?>
    <style>
        .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0px 12px 10px rgba(0, 0, 0, 0.35) !important; }
        .product-img { object-fit: cover; height: 100%; min-height: 200px; width: 100%; border-top-left-radius: var(--bs-border-radius-xl); border-bottom-left-radius: var(--bs-border-radius-xl); }
        @media (max-width: 767.98px) {
            .product-img { border-bottom-left-radius: 0; border-top-right-radius: var(--bs-border-radius-xl); }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="font-spartan fw-bold text-dark m-0">
                <i class="fas fa-box-open me-2"></i> Gestión de Productos
            </h1>
            <button type="button" class="btn btn-custom-nav btn-lg rounded-3 font-spartan fw-bold" onclick="abrirModalCrear()">
                <i class="fas fa-plus me-2"></i> Nuevo Producto
            </button>
        </div>

        <!-- Elementos ocultos para ToastHelper -->
        <?php if(session()->getFlashdata('success')): ?>
            <input type="hidden" id="flash-success" value="<?= esc(session()->getFlashdata('success')) ?>">
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <input type="hidden" id="flash-error" value="<?= esc(session()->getFlashdata('error')) ?>">
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="card mb-4 border-0 rounded-4" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
            <div class="card-body">
                <form action="<?= base_url('admin/productos') ?>" method="GET" class="d-flex flex-wrap align-items-center gap-3">
                    <div class="input-group" style="max-width: 700px;">
                        <input id="search-input" name="search" type="search" class="form-control rounded-start-3 border-secondary" placeholder="Buscar producto por nombre..." value="<?= esc($search ?? '') ?>" />
                        
                        <select name="stock_filter" class="form-select border-secondary" style="max-width: 180px;">
                            <option value="">Todos los Stocks</option>
                            <option value="low" <?= (isset($stock_filter) && $stock_filter === 'low') ? 'selected' : '' ?>>Bajo Stock (≤ 5)</option>
                            <option value="out" <?= (isset($stock_filter) && $stock_filter === 'out') ? 'selected' : '' ?>>Sin Stock (0)</option>
                        </select>

                        <button id="search-button" type="submit" class="btn btn-custom-nav rounded-end-3 px-4" title="Buscar y Filtrar">
                            <i class="fas fa-filter me-1 d-none d-sm-inline"></i> <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <?php if(!empty($search) || (isset($stock_filter) && $stock_filter !== '')): ?>
                        <a href="<?= base_url('admin/productos') ?>" class="btn btn-link text-muted text-decoration-none">
                            <i class="fas fa-times-circle me-1"></i> Limpiar filtros
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Listado de Tarjetas de Productos -->
        <?php if(!empty($productos)): ?>
            <div class="row g-4">
                <?php foreach($productos as $prod): ?>
                <div class="col-xl-6">
                    <div class="card border-0 rounded-4 h-100 card-hover mb-3" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); cursor: pointer;" onclick='abrirModalEditar(<?= json_encode($prod, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="<?= esc(cloudinary_thumb($prod['imagen'] ?? null)) ?>" class="img-fluid rounded-start product-img bg-light" alt="Imagen Producto" loading="lazy" decoding="async">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100 p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h4 class="card-title font-spartan fw-bold text-truncate m-0" style="max-width: 70%;">
                                            <?= esc($prod['nombre_producto']) ?>
                                        </h4>
                                        <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                                            $<?= number_format($prod['precio'], 2, ',', '.') ?>
                                        </span>
                                    </div>
                                    
                                    <p class="text-muted small mb-2"><i class="fas fa-tag me-1"></i> <?= esc($prod['nombre_categoria'] ?? 'Sin Categoría') ?></p>

                                    <p class="card-text text-muted mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3em;">
                                        <?= esc($prod['descripcion_producto'] ?: 'Sin descripción asignada.') ?>
                                    </p>
                                    
                                    <div class="d-flex gap-2 flex-wrap mb-3 mt-auto">
                                        <?php if($prod['estado_producto'] == 1): ?>
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="fas fa-ban me-1"></i> Inactivo</span>
                                        <?php endif; ?>
                                        
                                        <?php if($prod['stock'] > 5): ?>
                                            <span class="badge bg-info text-dark"><i class="fas fa-cubes me-1"></i> Stock: <?= esc($prod['stock']) ?></span>
                                        <?php elseif($prod['stock'] > 0): ?>
                                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i> Bajo Stock: <?= esc($prod['stock']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Sin Stock</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center mt-auto border-top pt-3">
                                        <small class="text-primary fw-bold"><i class="fas fa-edit"></i> Editar</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3 opacity-50"></i>
                <h4 class="font-spartan text-muted">No se encontraron productos</h4>
                <p class="text-muted">No hay resultados para mostrar. Intenta crear uno nuevo.</p>
            </div>
        <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Lógica del Modal -->
    <script>
        const productoModal = new bootstrap.Modal(document.getElementById('productoModal'));
        const form = document.getElementById('productoForm');
        const modalTitle = document.getElementById('productoModalLabel');
        
        const inputNombre = document.getElementById('nombre_producto');
        const inputCategoria = document.getElementById('id_categoria');
        const inputDesc = document.getElementById('descripcion_producto');
        const inputPrecio = document.getElementById('precio');
        const inputStock = document.getElementById('stock');
        const selectEstado = document.getElementById('estado_producto');
        const inputImagen = document.getElementById('imagen');

        const urlGuardar = '<?= base_url('admin/producto/guardar') ?>';
        const urlEditarBase = '<?= base_url('admin/producto/editar/') ?>';

        function abrirModalCrear() {
            // Resetear el formulario para el modo creación
            form.action = urlGuardar;
            modalTitle.innerHTML = '<i class="fas fa-plus-circle text-primary me-2"></i>Nuevo Producto';
            
            inputNombre.value = '';
            inputCategoria.value = '';
            inputDesc.value = '';
            inputPrecio.value = '';
            inputStock.value = '';
            selectEstado.value = '1';
            inputImagen.value = '';
            
            productoModal.show();
        }

        function abrirModalEditar(prod) {
            // Configurar el formulario para el modo edición
            form.action = urlEditarBase + prod.id_producto;
            modalTitle.innerHTML = '<i class="fas fa-edit text-warning me-2"></i>Editar Producto';
            
            inputNombre.value = prod.nombre_producto || '';
            inputCategoria.value = prod.id_categoria || '';
            inputDesc.value = prod.descripcion_producto || '';
            inputPrecio.value = prod.precio || '';
            inputStock.value = prod.stock || 0;
            selectEstado.value = prod.estado_producto;
            inputImagen.value = prod.imagen || '';
            
            productoModal.show();
        }
    </script>
<?= $this->endSection() ?>
