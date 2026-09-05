<?= $this->extend('Layouts/base') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Mis Compras') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="py-5" style="background-color: #fff6e9; min-height: 80vh;">
    <div class="container px-lg-4">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('perfil') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Mi Cuenta</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Mis Compras</li>
            </ol>
        </nav>

        <div class="mb-4">
            <h1 class="font-spartan fw-bold mb-1 d-flex align-items-center">
                 Mis Compras
            </h1>
            <p class="text-muted mb-0">Historial de pedidos (<?= count($ventas) ?>)</p>
        </div>

        <?php if (empty($ventas)): ?>
            <!-- Estado Vacío -->
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border-0 mt-4">
                <i class="fas fa-shopping-bag fa-4x text-muted mb-3 opacity-50"></i>
                <h3 class="font-spartan fw-bold">Todavía no realizaste ninguna compra.</h3>
                <p class="text-muted mb-4">Explora nuestro catálogo y encuentra los mejores productos para ti.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-custom-nav px-4 py-2">Ir al Catálogo</a>
            </div>
        <?php else: ?>
            <!-- Lista de Ventas -->
            <div class="row g-4">
                <?php foreach ($ventas as $v): ?>
                    <?php
                        $nombreEst = strtolower($v['nombre_estado'] ?? '');
                        $badgeClass = 'bg-secondary';
                        $borderClass = 'border-secondary';

                        if (str_contains($nombreEst, 'complet') || str_contains($nombreEst, 'entregad') || str_contains($nombreEst, 'listo')) {
                            $badgeClass = 'bg-success';
                            $borderClass = 'border-success';
                        } elseif (str_contains($nombreEst, 'pendient')) {
                            $badgeClass = 'bg-warning text-dark';
                            $borderClass = 'border-warning';
                        } elseif (str_contains($nombreEst, 'proces') || str_contains($nombreEst, 'preparaci')) {
                            $badgeClass = 'bg-info text-dark';
                            $borderClass = 'border-dark';
                        } elseif (str_contains($nombreEst, 'cancel')) {
                            $badgeClass = 'bg-danger';
                            $borderClass = 'border-danger';
                        }
                    ?>
                    <div class="col-12">
                        <div class="card border-0 rounded-4 shadow-sm card-hover compra-card" data-id-venta="<?= $v['id_venta'] ?>" style="border-left: 5px solid var(--bs-<?= explode('-', $borderClass)[1] ?? 'secondary' ?>) !important; cursor: pointer;">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-3 mb-3 mb-md-0">
                                        <h5 class="fw-bold mb-1">Pedido #<?= $v['id_venta'] ?></h5>
                                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?= $v['fecha_venta'] ?></small>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="small text-muted mb-1"><i class="fas fa-credit-card me-1"></i>Pago</div>
                                        <div class="fw-bold text-dark"><?= esc($v['nombre_metodo_pago'] ?? '—') ?></div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="small text-muted mb-1"><i class="fas fa-truck me-1"></i>Entrega</div>
                                        <div class="fw-bold text-dark"><?= esc($v['tipo_entrega'] ?? 'Retiro en local') ?></div>
                                    </div>
                                    <div class="col-12 col-md-3 mt-3 mt-md-0 text-md-end d-flex flex-column align-items-md-end">
                                        <span class="badge <?= $badgeClass ?> mb-2 align-self-start align-self-md-end" style="font-size: 0.85rem; padding: 0.4em 0.8em;"><?= esc($v['nombre_estado'] ?? 'Indefinido') ?></span>
                                        <div class="fw-bold fs-5">$<?= number_format($v['total'], 2, ',', '.') ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute top-50 end-0 translate-middle-y pe-3 d-none d-lg-block">
                                <i class="fas fa-chevron-right text-muted opacity-50"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<!-- Modal de Detalle de Venta -->
<div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <div class="text-center mb-4">
                    <h2 class="font-spartan fw-bold text-dark mb-1">Estética BV</h2>
                    <p class="text-muted small mb-0" id="mdl-comprobante">Comprobante</p>
                </div>

                <div class="row mb-4 g-3 bg-light rounded-3 p-3 mx-0">
                    <div class="col-6">
                        <div class="small text-muted mb-1"><i class="far fa-calendar-alt me-1"></i> Fecha</div>
                        <div class="fw-bold text-dark" id="mdl-fecha"></div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="small text-muted mb-1">Estado</div>
                        <span id="mdl-estado" class="badge bg-secondary"></span>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="small text-muted mb-1"><i class="fas fa-credit-card me-1"></i> Pago</div>
                        <div class="fw-bold text-dark" id="mdl-pago"></div>
                    </div>
                    <div class="col-6 mt-3 text-end">
                        <div class="small text-muted mb-1"><i class="fas fa-truck me-1"></i> Entrega</div>
                        <div class="fw-bold text-dark" id="mdl-entrega"></div>
                    </div>
                </div>

                <div class="table-responsive mb-0">
                    <table class="table table-borderless table-sm mb-0">
                        <thead class="border-bottom">
                            <tr>
                                <th class="text-muted small fw-bold">Producto</th>
                                <th class="text-muted small fw-bold text-center">Cant.</th>
                                <th class="text-muted small fw-bold text-end">Precio U.</th>
                                <th class="text-muted small fw-bold text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="mdl-items">
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <td colspan="3" class="text-end fw-bold pt-3 fs-5">Total</td>
                                <td class="text-end fw-bold text-dark pt-3 fs-5" id="mdl-total"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const baseUrlDetalle = '<?= base_url("mis-compras/detalle/") ?>';
    const fmt = n => '$' + parseFloat(n).toLocaleString('es-AR', {minimumFractionDigits:2});

    async function abrirDetalle(idVenta) {
        try {
            const res = await fetch(baseUrlDetalle + idVenta);
            if (!res.ok) throw new Error('Error al obtener el detalle');
            const data = await res.json();
            
            const v = data.venta;
            const items = data.detalles;

            // Llenar datos de la cabecera
            document.getElementById('mdl-comprobante').textContent = `Comprobante #${v.id_venta}`;
            document.getElementById('mdl-fecha').textContent = v.fecha_venta;
            document.getElementById('mdl-pago').textContent = v.nombre_metodo_pago ?? '—';
            document.getElementById('mdl-entrega').textContent = v.tipo_entrega ?? 'Retiro en local';

            // Configurar badge de estado
            const badgeEstado = document.getElementById('mdl-estado');
            badgeEstado.textContent = v.nombre_estado ?? 'Indefinido';
            badgeEstado.className = 'badge ';
            const nombreEst = (v.nombre_estado || '').toLowerCase();
            if (nombreEst.includes('complet') || nombreEst.includes('entregad') || nombreEst.includes('listo')) {
                badgeEstado.classList.add('bg-success');
            } else if (nombreEst.includes('pendient')) {
                badgeEstado.classList.add('bg-warning', 'text-dark');
            } else if (nombreEst.includes('proces') || nombreEst.includes('preparaci')) {
                badgeEstado.classList.add('bg-info', 'text-dark');
            } else if (nombreEst.includes('cancel')) {
                badgeEstado.classList.add('bg-danger');
            } else {
                badgeEstado.classList.add('bg-secondary');
            }

            // Llenar tabla
            const tbody = document.getElementById('mdl-items');
            tbody.innerHTML = '';
            items.forEach(it => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${it.nombre_producto ?? '—'}</td>
                    <td class="text-center">${it.cantidad}</td>
                    <td class="text-end">${fmt(it.precio_unitario)}</td>
                    <td class="text-end">${fmt(it.subtotal)}</td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('mdl-total').textContent = fmt(v.total);

            // Mostrar modal
            const detalleModal = new bootstrap.Modal(document.getElementById('detalleModal'));
            detalleModal.show();
            
        } catch (e) {
            if(typeof ToastHelper !== 'undefined') {
                ToastHelper.show('error', 'No se pudo cargar el detalle del pedido.');
            } else {
                alert('No se pudo cargar el detalle del pedido.');
            }
        }
    }

    document.querySelectorAll('.compra-card').forEach(card => {
        card.addEventListener('click', () => abrirDetalle(card.dataset.idVenta));
    });
</script>
<?= $this->endSection() ?>

