<?= $this->extend('Layouts/admin/base_admin') ?>

<?= $this->section('content') ?>
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="font-spartan fw-bold text-dark m-0">
            <i class="fas fa-question-circle me-2"></i> Gestión de Consultas
        </h1>
    </div>

    <!-- Elementos ocultos para ToastHelper -->
    <?php if(session()->getFlashdata('success')): ?>
        <input type="hidden" id="flash-success" value="<?= esc(session()->getFlashdata('success')) ?>">
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <input type="hidden" id="flash-error" value="<?= esc(session()->getFlashdata('error')) ?>">
    <?php endif; ?>
    <?php if(session()->getFlashdata('warning')): ?>
        <input type="hidden" id="flash-warning" value="<?= esc(session()->getFlashdata('warning')) ?>">
    <?php endif; ?>

    <!-- Filter Bar -->
    <div class="card mb-4 border-0 rounded-4" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
        <div class="card-body">
            <form action="<?= base_url('admin/consultas') ?>" method="GET" class="d-flex flex-wrap align-items-end gap-3">
                <div>
                    <label for="filter-fecha" class="form-label font-spartan fw-bold small text-muted mb-1">Filtrar por Fecha</label>
                    <input id="filter-fecha" name="fecha" type="date" class="form-control rounded-3 border-secondary" value="<?= esc($fecha ?? '') ?>" />
                </div>

                <div>
                    <label for="filter-orden" class="form-label font-spartan fw-bold small text-muted mb-1">Orden</label>
                    <select id="filter-orden" name="orden" class="form-select rounded-3 border-secondary" style="min-width: 170px;">
                        <option value="desc" <?= (isset($orden) && $orden === 'desc') ? 'selected' : '' ?>>Más recientes primero</option>
                        <option value="asc" <?= (isset($orden) && $orden === 'asc') ? 'selected' : '' ?>>Más antiguas primero</option>
                    </select>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-custom-nav rounded-3 px-4 fw-bold font-spartan" title="Filtrar">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                    <?php if(!empty($fecha) || (isset($orden) && $orden !== 'desc')): ?>
                        <a href="<?= base_url('admin/consultas') ?>" class="btn btn-link text-muted text-decoration-none">
                            <i class="fas fa-times-circle me-1"></i> Limpiar filtros
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado de Consultas -->
    <?php if(!empty($consultas)): ?>
        <div class="row g-3">
            <?php foreach($consultas as $cons): ?>
            <div class="col-12">
                <div class="card border-0 rounded-4 card-hover p-3" 
                     style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); cursor: pointer;"
                     onclick='abrirModalConsulta(<?= json_encode($cons, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                    <div class="card-body p-2">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge btn-custom-nav rounded-pill px-3 py-2">
                                    <i class="fas fa-hashtag me-1"></i> Consulta #<?= esc($cons['id_consulta']) ?>
                                </span>
                                <h5 class="font-spartan fw-bold text-dark m-0">
                                    <?= esc($cons['apellido_nombre'] ?? 'Cliente Registrado #' . $cons['id_usuario']) ?>
                                </h5>
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-calendar-alt me-1" style="color: #444444;"></i>
                                <?= esc(date('d/m/Y', strtotime($cons['fecha_consulta']))) ?>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
                            <?php if(!empty($cons['email'])): ?>
                                <span><i class="fas fa-envelope me-1" style="color: #444444;"></i> <?= esc($cons['email']) ?></span>
                            <?php endif; ?>
                            <?php if(!empty($cons['telefono'])): ?>
                                <span><i class="fas fa-phone me-1" style="color: #444444;"></i> <?= esc($cons['telefono']) ?></span>
                            <?php endif; ?>
                            <?php if(!empty($cons['dni'])): ?>
                                <span><i class="fas fa-id-card me-1" style="color: #444444;"></i> DNI: <?= esc($cons['dni']) ?></span>
                            <?php endif; ?>
                        </div>

                        <p class="card-text text-secondary m-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= esc($cons['mensaje']) ?>
                        </p>

                        <div class="d-flex justify-content-end align-items-center mt-2 pt-2 border-top">
                            <small class="fw-bold font-spartan" style="color: #444444;">
                                <i class="fas fa-eye me-1"></i> Ver Detalle Completo
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3 opacity-50"></i>
            <h4 class="font-spartan text-muted">No se encontraron consultas</h4>
            <p class="text-muted">No hay consultas registradas con los filtros seleccionados.</p>
        </div>
    <?php endif; ?>

    <!-- Modal Detalle de Consulta -->
    <div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-spartan fw-bold text-dark" id="consultaModalLabel">
                        <i class="fas fa-envelope-open-text me-2" style="color: #444444;"></i>Detalle de Consulta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="p-3 bg-light rounded-3 mb-3 border">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <span class="text-muted small d-block">Cliente:</span>
                                <span class="fw-bold font-spartan fs-5 text-dark" id="modal-nombre"></span>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="text-muted small d-block">Fecha de Consulta:</span>
                                <span class="fw-bold font-spartan text-dark" id="modal-fecha"></span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted small d-block">Email:</span>
                                <span class="fw-bold text-dark" id="modal-email"></span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted small d-block">Teléfono:</span>
                                <span class="fw-bold text-dark" id="modal-telefono"></span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted small d-block">DNI:</span>
                                <span class="fw-bold text-dark" id="modal-dni"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label font-spartan fw-bold text-dark">Mensaje Completo:</label>
                        <div class="p-3 rounded-3 bg-white border" style="white-space: pre-wrap; line-height: 1.6;" id="modal-mensaje"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        const consultaModal = new bootstrap.Modal(document.getElementById('consultaModal'));
        const modalNombre   = document.getElementById('modal-nombre');
        const modalFecha    = document.getElementById('modal-fecha');
        const modalEmail    = document.getElementById('modal-email');
        const modalTelefono = document.getElementById('modal-telefono');
        const modalDni      = document.getElementById('modal-dni');
        const modalMensaje  = document.getElementById('modal-mensaje');

        function abrirModalConsulta(cons) {
            modalNombre.textContent   = cons.apellido_nombre || ('Cliente #' + cons.id_usuario);
            modalEmail.textContent    = cons.email || 'No disponible';
            modalTelefono.textContent = cons.telefono || 'Sin teléfono';
            modalDni.textContent      = cons.dni || 'Sin DNI';
            
            // Formatear fecha
            if (cons.fecha_consulta) {
                const parts = cons.fecha_consulta.split('-');
                if (parts.length === 3) {
                    modalFecha.textContent = parts[2] + '/' + parts[1] + '/' + parts[0];
                } else {
                    modalFecha.textContent = cons.fecha_consulta;
                }
            } else {
                modalFecha.textContent = 'N/A';
            }

            modalMensaje.textContent  = cons.mensaje || '';

            consultaModal.show();
        }
    </script>
<?= $this->endSection() ?>
