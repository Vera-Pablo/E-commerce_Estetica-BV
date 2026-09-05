<?= $this->extend('Layouts/admin/base_admin') ?>
<?= $this->section('styles') ?>
    <style>
        /* ——— Cards ——— */
        .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,.18) !important; }
        .venta-card { cursor: pointer; }

        /* ——— Canva-shadow stripe coloring ——— */
        .venta-card .card-accent {
            width: 6px;
            border-radius: 12px 0 0 12px;
            flex-shrink: 0;
        }
        .accent-completado { background: linear-gradient(180deg, #198754, #20c997); }
        .accent-pendiente  { background: linear-gradient(180deg, #ffc107, #fd7e14); }
        .accent-cancelado  { background: linear-gradient(180deg, #dc3545, #c0392b); }
        .accent-default    { background: linear-gradient(180deg, #6c757d, #495057); }

        /* ——— Recibo (solo print) ——— */
        #recibo-print { display: none; }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?><!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="font-spartan fw-bold text-dark m-0">
                <i class="fas fa-receipt me-2"></i> Gestión de Ventas
            </h1>
        </div>

        <!-- Toasts flash -->
        <?php if(session()->getFlashdata('success')): ?>
            <input type="hidden" id="flash-success" value="<?= esc(session()->getFlashdata('success')) ?>">
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <input type="hidden" id="flash-error" value="<?= esc(session()->getFlashdata('error')) ?>">
        <?php endif; ?>

        <!-- ——— Panel de búsqueda y filtros ——— -->
        <div class="card mb-4 border-0 rounded-4" style="box-shadow: 0px 10px 7px rgba(0,0,0,.26);">
            <div class="card-body">
                <form action="<?= base_url('admin/ventas') ?>" method="GET">
                    <div class="row g-3 align-items-end">

                        <!-- Buscar por ID -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="search_id" class="form-label fw-bold small mb-1">Buscar por N° de Venta</label>
                            <div class="input-group">
                                <input id="search_id" name="search_id" type="number" min="1"
                                       class="form-control rounded-start-3 border-secondary"
                                       placeholder="Ej. 42"
                                       value="<?= esc($search_id ?? '') ?>">
                                <button type="submit" class="btn btn-custom-nav rounded-end-3 px-3" title="Buscar">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Filtro estado -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="filtro_estado" class="form-label fw-bold small mb-1">Estado de Venta</label>
                            <select name="estado" id="filtro_estado" class="form-select border-secondary rounded-3">
                                <option value="">Todos los estados</option>
                                <?php foreach($estados as $ev): ?>
                                    <option value="<?= esc($ev['id_estado_venta']) ?>"
                                        <?= (isset($estado) && $estado == $ev['id_estado_venta']) ? 'selected' : '' ?>>
                                        <?= esc($ev['nombre_estado']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filtro método de pago -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="filtro_pago" class="form-label fw-bold small mb-1">Método de Pago</label>
                            <select name="metodo_pago" id="filtro_pago" class="form-select border-secondary rounded-3">
                                <option value="">Todos los métodos</option>
                                <?php foreach($metodosPago as $mp): ?>
                                    <option value="<?= esc($mp['id_metodo_pago']) ?>"
                                        <?= (isset($metodo_pago) && $metodo_pago == $mp['id_metodo_pago']) ? 'selected' : '' ?>>
                                        <?= esc($mp['nombre_metodo_pago']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Ordenamiento -->
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label for="filtro_orden" class="form-label fw-bold small mb-1">Ordenar por Fecha</label>
                            <select name="orden" id="filtro_orden" class="form-select border-secondary rounded-3">
                                <option value="desc" <?= (($orden ?? 'desc') === 'desc') ? 'selected' : '' ?>>Más recientes</option>
                                <option value="asc"  <?= (($orden ?? 'desc') === 'asc')  ? 'selected' : '' ?>>Más antiguas</option>
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="col-12 col-lg-1 d-flex gap-2">
                            <button type="submit" class="btn btn-custom-nav rounded-3 w-100">
                                <i class="fas fa-filter"></i>
                            </button>
                            <?php if(!empty($search_id) || !empty($estado) || !empty($metodo_pago)): ?>
                                <a href="<?= base_url('admin/ventas') ?>" class="btn btn-custom-back rounded-3" title="Limpiar">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- ——— Totales rápidos ——— -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 rounded-4 text-center py-3" style="box-shadow:0 6px 14px rgba(0,0,0,.12);">
                    <div class="fw-bold font-spartan fs-4"><?= count($ventas) ?></div>
                    <small class="text-muted">Resultados</small>
                </div>
            </div>
            <?php
                $totalGeneral = array_sum(array_column($ventas, 'total'));
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 rounded-4 text-center py-3" style="box-shadow:0 6px 14px rgba(0,0,0,.12);">
                    <div class="fw-bold font-spartan fs-5">$<?= number_format($totalGeneral, 2, ',', '.') ?></div>
                    <small class="text-muted">Total Filtrado</small>
                </div>
            </div>
        </div>

        <!-- ——— Grid de Tarjetas ——— -->
        <?php if(!empty($ventas)): ?>
            <div class="row g-3">
                <?php foreach($ventas as $v): ?>
                <?php
                    // Determinar color del acento lateral por estado
                    $nombreEstado = strtolower($v['nombre_estado'] ?? '');
                    if (str_contains($nombreEstado, 'complet') || str_contains($nombreEstado, 'entregad')) {
                        $accent = 'accent-completado';
                    } elseif (str_contains($nombreEstado, 'pendient') || str_contains($nombreEstado, 'proces')) {
                        $accent = 'accent-pendiente';
                    } elseif (str_contains($nombreEstado, 'cancel')) {
                        $accent = 'accent-cancelado';
                    } else {
                        $accent = 'accent-default';
                    }
                ?>
                <div class="col-12 col-xl-6">
                    <div class="card border-0 rounded-4 card-hover venta-card d-flex flex-row overflow-hidden"
                         style="box-shadow: 0 8px 18px rgba(0,0,0,.14);"
                         onclick="abrirRecibo(<?= (int)$v['id_venta'] ?>)">

                        <!-- Acento lateral tipo Canva -->
                        <div class="card-accent <?= $accent ?>"></div>

                        <div class="card-body d-flex flex-wrap align-items-center gap-3 py-3 px-4">

                            <!-- ID venta -->
                            <div class="text-center" style="min-width:60px;">
                                <div class="fw-bold font-spartan fs-5 lh-1">#<?= esc($v['id_venta']) ?></div>
                                <small class="text-muted">ID</small>
                            </div>

                            <div class="vr d-none d-sm-block"></div>

                            <!-- Cliente -->
                            <div class="flex-grow-1" style="min-width:140px;">
                                <div class="fw-bold text-truncate" style="max-width:200px;"><?= esc($v['apellido_nombre'] ?? 'N/A') ?></div>
                                <small class="text-muted">DNI: <?= esc($v['dni'] ?? '—') ?></small>
                            </div>

                            <div class="vr d-none d-sm-block"></div>

                            <!-- Método pago & Entrega -->
                            <div class="text-center" style="min-width:110px;">
                                <div><i class="fas fa-credit-card text-secondary me-1"></i><span class="small fw-bold"><?= esc($v['nombre_metodo_pago'] ?? '—') ?></span></div>
                                <div class="mt-1"><i class="fas fa-truck text-secondary me-1"></i><span class="small text-muted"><?= esc($v['tipo_entrega'] ?? 'Retiro en local') ?></span></div>
                                <small class="text-muted d-block mt-1"><?= esc($v['fecha_venta']) ?></small>
                            </div>

                            <div class="vr d-none d-sm-block"></div>

                            <!-- Total -->
                            <div class="text-end" style="min-width:80px;">
                                <div class="fw-bold font-spartan fs-5 text-success">$<?= number_format($v['total'], 2, ',', '.') ?></div>
                                <span class="badge rounded-pill
                                    <?= str_contains($nombreEstado,'complet')||str_contains($nombreEstado,'entregad') ? 'bg-success' :
                                       (str_contains($nombreEstado,'pendient')||str_contains($nombreEstado,'proces') ? 'bg-warning text-dark' :
                                       (str_contains($nombreEstado,'cancel') ? 'bg-danger' : 'bg-secondary')) ?>">
                                    <?= esc($v['nombre_estado'] ?? '—') ?>
                                </span>
                            </div>

                            <!-- Ícono Ver -->
                            <div class="ms-auto d-none d-md-block text-primary">
                                <i class="fas fa-eye"></i>
                            </div>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-4x text-muted mb-3 opacity-50"></i>
                <h4 class="font-spartan text-muted">No se encontraron ventas</h4>
                <p class="text-muted">Ajusta los filtros o realiza una búsqueda diferente.</p>
            </div>
        <?php endif; ?>

        <!-- Modal Recibo -->
        <div class="modal fade" id="reciboModal" tabindex="-1" aria-labelledby="reciboModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body p-4 pt-2" id="recibo-contenido">
                        <!-- Cabecera Recibo -->
                        <div class="text-center mb-4">
                            <h2 class="font-spartan fw-bold text-dark mb-1">Estética BV</h2>
                            <p class="text-muted small mb-0">Comprobante de Venta</p>
                        </div>
                        
                        <div class="row mb-4 g-3">
                            <div class="col-sm-6">
                                <h6 class="text-muted mb-1 small">Detalles del Cliente</h6>
                                <div class="fw-bold text-dark" id="r-nombre"></div>
                                <div class="small text-muted">DNI: <span id="r-dni"></span></div>
                                <div class="small text-muted">Email: <span id="r-email"></span></div>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h6 class="text-muted mb-1 small">Detalles de Venta</h6>
                                <div class="fw-bold text-dark" id="r-id"></div>
                                <div class="small text-muted">Fecha: <span id="r-fecha"></span></div>
                                <div class="small text-muted">Estado: <span id="r-estado" class="badge bg-secondary ms-1"></span></div>
                            </div>
                        </div>

                        <div class="row mb-4 g-3 bg-light rounded-3 p-3 mx-0">
                            <div class="col-sm-6">
                                <h6 class="text-muted mb-1 small"><i class="fas fa-credit-card me-1"></i> Método de Pago</h6>
                                <div class="fw-bold text-dark" id="r-pago"></div>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h6 class="text-muted mb-1 small"><i class="fas fa-truck me-1"></i> Tipo de Entrega</h6>
                                <div class="fw-bold text-dark" id="r-entrega"></div>
                            </div>
                        </div>

                        <!-- Tabla de Ítems -->
                        <div class="table-responsive mb-4">
                            <table class="table table-borderless table-sm">
                                <thead class="border-bottom">
                                    <tr>
                                        <th class="text-muted small fw-bold">Producto</th>
                                        <th class="text-muted small fw-bold text-center">Cant.</th>
                                        <th class="text-muted small fw-bold text-end">Precio U.</th>
                                        <th class="text-muted small fw-bold text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="r-items">
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold pt-3 fs-5">Total</td>
                                        <td class="text-end fw-bold text-success pt-3 fs-5" id="r-total"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- Mensaje pie de recibo -->
                        <div class="text-center mt-4">
                            <p class="small text-muted fst-italic">Gracias por su compra.</p>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-custom-nav" onclick="imprimirRecibo()">
                            <i class="fas fa-print me-2"></i>Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="recibo-print"></div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        const reciboModal = new bootstrap.Modal(document.getElementById('reciboModal'));
        const baseUrl = '<?= base_url('admin/ventas/detalle/') ?>';

        // Formateador de moneda
        const fmt = n => '$' + parseFloat(n).toLocaleString('es-AR', {minimumFractionDigits:2, maximumFractionDigits:2});

        /**
         * Abre el modal del recibo cargando los datos desde el endpoint JSON.
         * @param {number} idVenta
         */
        async function abrirRecibo(idVenta) {
            try {
                const res = await fetch(baseUrl + idVenta);
                if (!res.ok) throw new Error('No encontrada');
                const data = await res.json();

                const v = data.venta;
                const items = data.detalles;

                // Rellenar cabecera
                document.getElementById('r-id').textContent     = `Recibo #${v.id_venta}`;
                document.getElementById('r-fecha').textContent  = v.fecha_venta;
                document.getElementById('r-nombre').textContent = v.apellido_nombre ?? '—';
                document.getElementById('r-dni').textContent    = v.dni ?? '—';
                document.getElementById('r-email').textContent  = v.email ?? '—';
                document.getElementById('r-estado').textContent = v.nombre_estado ?? '—';
                document.getElementById('r-pago').textContent   = v.nombre_metodo_pago ?? '—';
                document.getElementById('r-entrega').textContent= v.tipo_entrega ?? 'Retiro en local';
                document.getElementById('r-total').textContent  = fmt(v.total);

                // Rellenar filas de detalle
                const tbody = document.getElementById('r-items');
                tbody.innerHTML = '';
                if (items.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Sin ítems registrados.</td></tr>';
                } else {
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
                }

                reciboModal.show();
            } catch (e) {
                ToastHelper.show('error', 'No se pudo cargar el detalle de la venta.');
            }
        }

        /**
         * Copia el contenido del recibo al div de impresión y llama a window.print().
         * Las reglas @media print en base.css se encargan de mostrar solo ese div.
         */
        function imprimirRecibo() {
            const printDiv = document.getElementById('recibo-print');
            printDiv.innerHTML = document.getElementById('recibo-contenido').innerHTML;
            window.print();
        }
    </script>
<?= $this->endSection() ?>
