<?= $this->extend('Layouts/admin/base_admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0 px-lg-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
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
                    <div class="input-group" style="max-width: 600px;">
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
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach($productos as $prod): ?>
                <div class="col">
                    <div class="card border-0 rounded-4 h-100 card-hover" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); cursor: pointer;" onclick='abrirModalEditar(<?= json_encode($prod, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                        <img src="<?= esc(cloudinary_thumb($prod['imagen'] ?? null)) ?>" class="card-img-top bg-light rounded-top-4" alt="Imagen Producto" style="height: 180px; object-fit: cover;" loading="lazy" decoding="async">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="card-title font-spartan fw-bold text-truncate m-0" style="max-width: 65%;">
                                    <?= esc($prod['nombre_producto']) ?>
                                </h4>
                                <span class="badge bg-dark rounded-pill px-3 py-2 fs-6">
                                    $<?= number_format($prod['precio'], 2, ',', '.') ?>
                                </span>
                            </div>
                            
                            <p class="text-muted small mb-2">
                                <i class="fas fa-barcode me-1"></i> <?= esc($prod['codigo_producto'] ?? 'N/A') ?> &nbsp;|&nbsp; 
                                <i class="fas fa-tag me-1"></i> <?= esc($prod['nombre_categoria'] ?? 'Sin Categoría') ?>
                            </p>

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
                                <small class="text-dark fw-bold"><i class="fas fa-edit"></i> Editar</small>
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

        <!-- Modal Crear/Editar Producto -->
        <div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 border-0">
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-spartan fw-bold" id="productoModalLabel"><i class="fas fa-plus-circle text-dark me-2"></i>Nuevo Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="productoForm" method="post" action="" novalidate>
                        <?php $errorsForm = session()->getFlashdata('errors') ?? []; ?>
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="codigo_producto" class="form-label fw-bold">Código</label>
                                    <input type="text" class="form-control rounded-3 border-secondary" id="codigo_producto" name="codigo_producto" value="<?= esc(old('codigo_producto', '')) ?>" maxlength="50" required>
                                    <?php if (isset($errorsForm['codigo_producto'])): ?>
                                        <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['codigo_producto']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="nombre_producto" class="form-label fw-bold">Nombre</label>
                                    <input type="text" class="form-control rounded-3 border-secondary" id="nombre_producto" name="nombre_producto" value="<?= esc(old('nombre_producto', '')) ?>" maxlength="255" required>
                                    <?php if (isset($errorsForm['nombre_producto'])): ?>
                                        <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['nombre_producto']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="id_categoria" class="form-label fw-bold">Categoría</label>
                                <select class="form-select rounded-3 border-secondary" id="id_categoria" name="id_categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach($categorias as $c): ?>
                                        <option value="<?= esc($c['id_categoria']) ?>" <?= old('id_categoria', '') == $c['id_categoria'] ? 'selected' : '' ?>><?= esc($c['nombre_categoria']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errorsForm['id_categoria'])): ?>
                                    <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['id_categoria']) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_producto" class="form-label fw-bold">Descripción</label>
                                <textarea class="form-control rounded-3 border-secondary" id="descripcion_producto" name="descripcion_producto" rows="3" maxlength="500" required><?= esc(old('descripcion_producto', '')) ?></textarea>
                                <?php if (isset($errorsForm['descripcion_producto'])): ?>
                                    <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['descripcion_producto']) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="precio" class="form-label fw-bold">Precio</label>
                                    <input type="number" step="0.01" min="0" class="form-control rounded-3 border-secondary" id="precio" name="precio" value="<?= esc(old('precio', '')) ?>" required>
                                    <?php if (isset($errorsForm['precio'])): ?>
                                        <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['precio']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="stock" class="form-label fw-bold">Stock</label>
                                    <input type="number" min="0" class="form-control rounded-3 border-secondary" id="stock" name="stock" value="<?= esc(old('stock', '')) ?>" required>
                                    <?php if (isset($errorsForm['stock'])): ?>
                                        <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['stock']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado_producto" class="form-label fw-bold">Estado</label>
                                    <select class="form-select rounded-3 border-secondary" id="estado_producto" name="estado_producto">
                                        <option value="1" <?= old('estado_producto', '') === '1' ? 'selected' : '' ?>>Activo</option>
                                        <option value="0" <?= old('estado_producto', '') === '0' ? 'selected' : '' ?>>Inactivo</option>
                                    </select>
                                    <?php if (isset($errorsForm['estado_producto'])): ?>
                                        <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['estado_producto']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label fw-bold">Imagen (URL Cloudinary)</label>
                                <input type="url" class="form-control rounded-3 border-secondary" id="imagen" name="imagen" value="<?= esc(old('imagen', '')) ?>" maxlength="500" required>
                                <?php if (isset($errorsForm['imagen'])): ?>
                                    <div class="text-danger small text-start mt-1">*<?= esc($errorsForm['imagen']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-custom-nav rounded-3 fw-bold">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Lógica del Modal -->
    <script>
        const productoModal = new bootstrap.Modal(document.getElementById('productoModal'));
        const form = document.getElementById('productoForm');
        const modalTitle = document.getElementById('productoModalLabel');
        
        const inputCodigo = document.getElementById('codigo_producto');
        const inputNombre = document.getElementById('nombre_producto');
        const inputCategoria = document.getElementById('id_categoria');
        const inputDesc = document.getElementById('descripcion_producto');
        const inputPrecio = document.getElementById('precio');
        const inputStock = document.getElementById('stock');
        const selectEstado = document.getElementById('estado_producto');
        const inputImagen = document.getElementById('imagen');

        const urlGuardar = '<?= base_url('admin/producto/guardar') ?>';
        const urlEditarBase = '<?= base_url('admin/producto/editar/') ?>';

        function limpiarErroresModal() {
            const errores = form.querySelectorAll('.text-danger');
            errores.forEach(el => el.remove());
        }

        function abrirModalCrear() {
            limpiarErroresModal();
            // Resetear el formulario para el modo creación
            form.action = urlGuardar;
            modalTitle.innerHTML = '<i class="fas fa-plus-circle text-dark me-2"></i>Nuevo Producto';
            
            inputCodigo.value = '';
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
            limpiarErroresModal();
            // Configurar el formulario para el modo edición
            form.action = urlEditarBase + prod.id_producto;
            modalTitle.innerHTML = '<i class="fas fa-edit text-dark me-2"></i>Editar Producto';
            
            inputCodigo.value = prod.codigo_producto || '';
            inputNombre.value = prod.nombre_producto || '';
            inputCategoria.value = prod.id_categoria || '';
            inputDesc.value = prod.descripcion_producto || '';
            inputPrecio.value = prod.precio || '';
            inputStock.value = prod.stock || 0;
            selectEstado.value = prod.estado_producto;
            inputImagen.value = prod.imagen || '';
            
            productoModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('modal_open')): ?>
                <?php $modalOpen = session()->getFlashdata('modal_open'); ?>
                <?php if ($modalOpen === 'crear'): ?>
                    form.action = urlGuardar;
                    modalTitle.innerHTML = '<i class="fas fa-plus-circle text-dark me-2"></i>Nuevo Producto';
                    productoModal.show();
                <?php elseif (strpos($modalOpen, 'editar_') === 0): ?>
                    <?php $idProdError = explode('_', $modalOpen)[1]; ?>
                    form.action = urlEditarBase + '<?= $idProdError ?>';
                    modalTitle.innerHTML = '<i class="fas fa-edit text-dark me-2"></i>Editar Producto';
                    productoModal.show();
                <?php endif; ?>
            <?php endif; ?>
        });
    </script>
<?= $this->endSection() ?>
