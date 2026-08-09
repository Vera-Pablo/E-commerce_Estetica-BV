<?= $this->extend('Layouts/admin/base_admin') ?>
<?= $this->section('styles') ?>
    <style>
        .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0px 12px 10px rgba(0, 0, 0, 0.35) !important; }
        .client-avatar-container { 
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); 
            display: flex; 
            align-items: center; 
            justify-content: center;
            border-top-left-radius: var(--bs-border-radius-xl); 
            border-bottom-left-radius: var(--bs-border-radius-xl); 
            height: 100%; 
            min-height: 180px; 
            color: white; 
        }
        @media (max-width: 767.98px) {
            .client-avatar-container { border-bottom-left-radius: 0; border-top-right-radius: var(--bs-border-radius-xl); min-height: 120px; }
        }
    </style>
<?= $this->endSection() ?>

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
                    <div class="input-group" style="max-width: 500px;">
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
                <div class="col-xl-6">
                    <div class="card border-0 rounded-4 h-100 card-hover mb-3" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); cursor: pointer;" onclick='abrirModalCliente(<?= json_encode($cliente, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                        <div class="row g-0 h-100">
                            <div class="col-md-3 col-sm-4">
                                <div class="client-avatar-container">
                                    <i class="fas fa-user-circle fa-4x opacity-75"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-8">
                                <div class="card-body d-flex flex-column h-100 p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h4 class="card-title font-spartan fw-bold text-truncate m-0" style="max-width: 80%;">
                                            <?= esc($cliente['apellido_nombre']) ?>
                                        </h4>
                                    </div>
                                    
                                    <p class="text-muted small mb-1"><i class="fas fa-envelope me-2"></i><?= esc($cliente['email']) ?></p>
                                    <p class="text-muted small mb-3"><i class="fas fa-id-card me-2"></i>DNI: <?= esc($cliente['dni']) ?></p>
                                    
                                    <div class="d-flex gap-2 flex-wrap mt-auto">
                                        <?php if($cliente['estado_usuario'] == 1): ?>
                                            <span class="badge bg-success px-3 py-2"><i class="fas fa-user-check me-1"></i> Cuenta Activa</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-3 py-2"><i class="fas fa-user-slash me-1"></i> Cuenta Inactiva</span>
                                        <?php endif; ?>
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
                <i class="fas fa-users-slash fa-4x text-muted mb-3 opacity-50"></i>
                <h4 class="font-spartan text-muted">No se encontraron clientes</h4>
                <p class="text-muted">No hay resultados para mostrar en el sistema.</p>
            </div>
        <?php endif; ?>
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
                modalEstado.innerHTML = '<span class="badge bg-success">Activo</span>';
                
                inputEstadoUsuario.value = '0';
                btnCambiarEstado.className = 'btn btn-danger rounded-3 px-4 fw-bold';
                btnCambiarEstado.innerHTML = '<i class="fas fa-ban me-2"></i> Desactivar Cuenta';
            } else {
                // Cliente Inactivo -> Opción de activar
                modalEstado.innerHTML = '<span class="badge bg-danger">Inactivo</span>';
                
                inputEstadoUsuario.value = '1';
                btnCambiarEstado.className = 'btn btn-success rounded-3 px-4 fw-bold';
                btnCambiarEstado.innerHTML = '<i class="fas fa-check-circle me-2"></i> Activar Cuenta';
            }
            
            clienteModal.show();
        }
    </script>
<?= $this->endSection() ?>
