<?= $this->extend('Layouts/admin/base_admin') ?>

<?= $this->section('content') ?>
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="font-spartan fw-bold text-dark m-0">
                <i class="fas fa-users me-2"></i> Gestión de Clientes
            </h1>
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
                <form action="<?= base_url('admin/clientes') ?>" method="GET" class="d-flex flex-wrap align-items-center gap-3">
                    <div class="input-group" style="max-width: 600px;">
                        <input id="search-input" name="search" type="search" class="form-control rounded-start-3 border-secondary" placeholder="Buscar cliente por nombre o apellido..." value="<?= esc($search ?? '') ?>" />
                        
                        <button id="search-button" type="submit" class="btn btn-custom-nav rounded-end-3 px-4" title="Buscar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <?php if(!empty($search)): ?>
                        <a href="<?= base_url('admin/clientes') ?>" class="btn btn-link text-muted text-decoration-none">
                            <i class="fas fa-times-circle me-1"></i> Limpiar búsqueda
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Listado de Tarjetas de Clientes -->
        <?php if(!empty($clientes)): ?>
            <div class="row g-4">
                <?php foreach($clientes as $cliente): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 rounded-4 h-100 card-hover" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); cursor: pointer;" onclick='abrirModalCliente(<?= json_encode($cliente, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="card-title font-spartan fw-bold text-truncate m-0" style="max-width: 75%;">
                                    <?= esc($cliente['apellido_nombre']) ?>
                                </h4>
                                <?php if($cliente['estado_usuario'] == 1): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="fas fa-user-check me-1"></i> Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2"><i class="fas fa-user-slash me-1"></i> Inactivo</span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="text-muted mb-1 small"><i class="fas fa-envelope me-2 text-primary"></i> <?= esc($cliente['email']) ?></p>
                            <p class="text-muted mb-1 small"><i class="fas fa-id-card me-2 text-primary"></i> DNI: <?= esc($cliente['dni']) ?></p>
                            <p class="text-muted mb-3 small"><i class="fas fa-phone me-2 text-primary"></i> <?= esc($cliente['telefono'] ?: 'Sin teléfono') ?></p>
                            
                            <hr class="text-muted opacity-25 mt-auto">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark border">ID: <?= esc($cliente['id_usuario']) ?></span>
                                <small class="text-primary fw-bold"><i class="fas fa-cog me-1"></i> Gestionar Estado</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users-slash fa-4x text-muted mb-3 opacity-50"></i>
                <h4 class="font-spartan text-muted">No se encontraron clientes</h4>
                <p class="text-muted">No hay resultados para mostrar en el sistema.</p>
            </div>
        <?php endif; ?>

        <!-- Modal Gestionar Estado de Cliente -->
        <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0">
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-spartan fw-bold" id="clienteModalLabel">
                            <i class="fas fa-user-cog text-primary me-2"></i>Gestionar Cliente
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="clienteForm" method="post" action="<?= base_url('admin/usuario/cambiar-estado') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_usuario" id="input_id_usuario">
                        <input type="hidden" name="estado_usuario" id="input_estado_usuario">

                        <div class="modal-body">
                            <div class="p-3 bg-light rounded-3 mb-3 border">
                                <div class="mb-2">
                                    <span class="text-muted small">Nombre y Apellido:</span>
                                    <h5 class="fw-bold font-spartan text-dark m-0" id="modal-nombre"></h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <span class="text-muted small">DNI:</span>
                                        <p class="fw-bold m-0" id="modal-dni"></p>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <span class="text-muted small">Teléfono:</span>
                                        <p class="fw-bold m-0" id="modal-telefono"></p>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <span class="text-muted small">Email:</span>
                                    <p class="fw-bold m-0" id="modal-email"></p>
                                </div>
                                <div>
                                    <span class="text-muted small">Estado actual:</span>
                                    <div id="modal-estado" class="mt-1"></div>
                                </div>
                            </div>
                            <p class="text-muted small text-center mb-0">
                                Puedes activar o desactivar el acceso de este cliente a la plataforma.
                            </p>
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" id="btn-cambiar-estado" class="btn btn-danger rounded-3 px-4 fw-bold">
                                <i class="fas fa-ban me-2"></i> Desactivar Cuenta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Lógica del Modal -->
    <script>
        const clienteModal = new bootstrap.Modal(document.getElementById('clienteModal'));
        
        const modalDni = document.getElementById('modal-dni');
        const modalNombre = document.getElementById('modal-nombre');
        const modalEmail = document.getElementById('modal-email');
        const modalTelefono = document.getElementById('modal-telefono');
        const modalEstado = document.getElementById('modal-estado');
        
        const inputIdUsuario = document.getElementById('input_id_usuario');
        const inputEstadoUsuario = document.getElementById('input_estado_usuario');
        const btnCambiarEstado = document.getElementById('btn-cambiar-estado');

        function abrirModalCliente(cliente) {
            // Llenar datos de lectura
            modalDni.textContent = cliente.dni || 'N/A';
            modalNombre.textContent = cliente.apellido_nombre || 'N/A';
            modalEmail.textContent = cliente.email || 'N/A';
            modalTelefono.textContent = cliente.telefono || 'Sin teléfono';
            
            // Configurar el formulario y badge visual de estado
            inputIdUsuario.value = cliente.id_usuario;
            
            if (cliente.estado_usuario == 1) {
                // Cliente Activo -> Opción de desactivar
                modalEstado.innerHTML = '<span class="badge bg-success rounded-pill px-3 py-1"><i class="fas fa-check me-1"></i> Activo</span>';
                
                inputEstadoUsuario.value = '0';
                btnCambiarEstado.className = 'btn btn-danger rounded-3 px-4 fw-bold';
                btnCambiarEstado.innerHTML = '<i class="fas fa-ban me-2"></i> Desactivar Cuenta';
            } else {
                // Cliente Inactivo -> Opción de activar
                modalEstado.innerHTML = '<span class="badge bg-danger rounded-pill px-3 py-1"><i class="fas fa-ban me-1"></i> Inactivo</span>';
                
                inputEstadoUsuario.value = '1';
                btnCambiarEstado.className = 'btn btn-success rounded-3 px-4 fw-bold';
                btnCambiarEstado.innerHTML = '<i class="fas fa-check-circle me-2"></i> Activar Cuenta';
            }
            
            clienteModal.show();
        }
    </script>
<?= $this->endSection() ?>
