<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Administrar Categorías') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Base Custom CSS -->
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">
    
    <style>
        .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0px 12px 10px rgba(0, 0, 0, 0.35) !important; }
    </style>
</head>
<body class="d-flex" style="background-color: #f8f9fa;">
    
    <!-- Sidebar Component -->
    <?= $this->include('Layouts/admin/sidebar') ?>

    <!-- Contenido Principal -->
    <main class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="font-spartan fw-bold text-dark m-0">
                <i class="fas fa-tags me-2"></i> Gestión de Categorías
            </h1>
            <button type="button" class="btn btn-custom-nav btn-lg rounded-3 font-spartan fw-bold" onclick="abrirModalCrear()">
                <i class="fas fa-plus me-2"></i> Nueva Categoría
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
                <form action="<?= base_url('admin/categorias') ?>" method="GET" class="d-flex flex-wrap align-items-center gap-3">
                    <div class="input-group" style="max-width: 600px;">
                        <input id="search-input" name="search" type="search" class="form-control rounded-start-3 border-secondary" placeholder="Buscar categoría por nombre..." value="<?= esc($search ?? '') ?>" />
                        
                        <select name="estado" class="form-select border-secondary" style="max-width: 150px;">
                            <option value="">Todos los Estados</option>
                            <option value="1" <?= (isset($estado) && $estado === '1') ? 'selected' : '' ?>>Activas</option>
                            <option value="0" <?= (isset($estado) && $estado === '0') ? 'selected' : '' ?>>Inactivas</option>
                        </select>

                        <button id="search-button" type="submit" class="btn btn-custom-nav rounded-end-3 px-4" title="Buscar y Filtrar">
                            <i class="fas fa-filter me-1 d-none d-sm-inline"></i> <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <?php if(!empty($search) || (isset($estado) && $estado !== '')): ?>
                        <a href="<?= base_url('admin/categorias') ?>" class="btn btn-link text-muted text-decoration-none">
                            <i class="fas fa-times-circle me-1"></i> Limpiar filtros
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Listado de Tarjetas -->
        <?php if(!empty($categorias)): ?>
            <div class="row g-4">
                <?php foreach($categorias as $cat): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 rounded-4 h-100 card-hover" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); cursor: pointer;" onclick='abrirModalEditar(<?= json_encode($cat, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="card-title font-spartan fw-bold text-truncate m-0" style="max-width: 75%;">
                                    <?= esc($cat['nombre_categoria']) ?>
                                </h4>
                                <?php if($cat['estado_categoria'] == 1): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="fas fa-check me-1"></i> Activa</span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2"><i class="fas fa-ban me-1"></i> Inactiva</span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="card-text text-muted mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3em;">
                                <?= esc($cat['descripcion_categoria'] ?: 'Sin descripción asignada.') ?>
                            </p>
                            
                            <hr class="text-muted opacity-25">
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="badge bg-light text-dark border">ID: <?= esc($cat['id_categoria']) ?></span>
                                <small class="text-primary fw-bold"><i class="fas fa-edit"></i> Editar</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3 opacity-50"></i>
                <h4 class="font-spartan text-muted">No se encontraron categorías</h4>
                <p class="text-muted">No hay resultados para mostrar. Intenta crear una nueva.</p>
            </div>
        <?php endif; ?>
    </main>

    <!-- Modal Bootstrap para Crear / Editar -->
    <div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4" style="box-shadow: 0px 15px 15px rgba(0,0,0,0.4);">
                <form id="categoriaForm" action="<?= base_url('admin/categoria/guardar') ?>" method="POST">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h4 class="modal-title font-spartan fw-bold" id="categoriaModalLabel">Nueva Categoría</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <div class="mb-4">
                            <label for="nombre_categoria" class="form-label fw-bold">Nombre de la Categoría <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="nombre_categoria" name="nombre_categoria" placeholder="Ej. Cremas Faciales" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="descripcion_categoria" class="form-label fw-bold">Descripción</label>
                            <textarea class="form-control rounded-3" id="descripcion_categoria" name="descripcion_categoria" rows="3" placeholder="Opcional. Breve descripción de los productos..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="estado_categoria" class="form-label fw-bold">Estado del Registro</label>
                            <select class="form-select rounded-3" id="estado_categoria" name="estado_categoria" required>
                                <option value="1">Activa (Visible)</option>
                                <option value="0">Inactiva (Oculta / Borrado Lógico)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-custom-back rounded-3 px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom-nav rounded-3 px-4"><i class="fas fa-save me-2"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast Helper -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
    
    <!-- Lógica del Modal -->
    <script>
        const categoriaModal = new bootstrap.Modal(document.getElementById('categoriaModal'));
        const form = document.getElementById('categoriaForm');
        const modalTitle = document.getElementById('categoriaModalLabel');
        
        const inputNombre = document.getElementById('nombre_categoria');
        const inputDesc = document.getElementById('descripcion_categoria');
        const selectEstado = document.getElementById('estado_categoria');

        const urlGuardar = '<?= base_url('admin/categoria/guardar') ?>';
        const urlEditarBase = '<?= base_url('admin/categoria/editar/') ?>';

        function abrirModalCrear() {
            // Resetear el formulario para el modo creación
            form.action = urlGuardar;
            modalTitle.innerHTML = '<i class="fas fa-plus-circle text-primary me-2"></i>Nueva Categoría';
            
            inputNombre.value = '';
            inputDesc.value = '';
            selectEstado.value = '1';
            
            categoriaModal.show();
        }

        function abrirModalEditar(cat) {
            // Configurar el formulario para el modo edición
            form.action = urlEditarBase + cat.id_categoria;
            modalTitle.innerHTML = '<i class="fas fa-edit text-warning me-2"></i>Editar Categoría';
            
            inputNombre.value = cat.nombre_categoria || '';
            inputDesc.value = cat.descripcion_categoria || '';
            selectEstado.value = cat.estado_categoria;
            
            categoriaModal.show();
        }
    </script>
</body>
</html>
