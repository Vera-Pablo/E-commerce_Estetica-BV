<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Administrar Ventas') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Base Custom CSS -->
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">

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
</head>
<body class="d-flex" style="background-color: #f8f9fa;">

    <!-- Sidebar -->
    <?= $this->include('Layouts/admin/sidebar') ?>

    <!-- Contenido Principal -->
    <main class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">

        <!-- Header -->
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

                            <!-- Método pago -->
                            <div class="text-center" style="min-width:90px;">
                                <div><i class="fas fa-credit-card text-secondary me-1"></i><span class="small fw-bold"><?= esc($v['nombre_metodo_pago'] ?? '—') ?></span></div>
                                <small class="text-muted"><?= esc($v['fecha_venta']) ?></small>
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

    </main><!-- /main -->

    <!-- ===== MODAL RECIBO ===== -->
    <div class="modal fade" id="reciboModal" tabindex="-1" aria-labelledby="reciboModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4" style="box-shadow: 0 15px 40px rgba(0,0,0,.35);">

                <div class="modal-header border-bottom-0 pb-0">
                    <h4 class="modal-title font-spartan fw-bold" id="reciboModalLabel">
                        <i class="fas fa-file-invoice me-2 text-primary"></i> Recibo de Venta
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 pb-0" id="recibo-contenido">

                    <!-- Cabecera del recibo -->
                    <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-3">
                        <div>
                            <h5 class="font-spartan fw-bold mb-0">Estética BV</h5>
                            <small class="text-muted">Productos de Belleza y Cosmética</small>
                        </div>
                        <div class="text-end">
                            <div id="r-id" class="fw-bold fs-5 font-spartan"></div>
                            <small id="r-fecha" class="text-muted"></small>
                        </div>
                    </div>

                    <!-- Datos del cliente -->
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <p class="mb-1 small"><span class="fw-bold">Cliente:</span> <span id="r-nombre"></span></p>
                            <p class="mb-1 small"><span class="fw-bold">DNI:</span> <span id="r-dni"></span></p>
                            <p class="mb-0 small"><span class="fw-bold">Email:</span> <span id="r-email"></span></p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <p class="mb-1 small"><span class="fw-bold">Estado:</span> <span id="r-estado" class="badge bg-secondary"></span></p>
                            <p class="mb-0 small"><span class="fw-bold">Método de pago:</span> <span id="r-pago"></span></p>
                        </div>
                    </div>

                    <!-- Tabla de detalle -->
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0" id="r-tabla-detalle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">P. Unit.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="r-items">
                                <!-- Inyectado por JS -->
                            </tbody>
                            <tfoot>
                                <tr class="table-light fw-bold">
                                    <td colspan="3" class="text-end">TOTAL</td>
                                    <td class="text-end" id="r-total"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <p class="text-center text-muted small mt-3 mb-0">
                        <i class="fas fa-heart text-danger me-1"></i> Gracias por tu compra en Estética BV
                    </p>

                </div><!-- /recibo-contenido -->

                <div class="modal-footer border-top-0 pt-3">
                    <button type="button" class="btn btn-custom-back rounded-3 px-4" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-custom-nav rounded-3 px-4" onclick="imprimirRecibo()">
                        <i class="fas fa-print me-2"></i> Imprimir Recibo
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Contenedor de impresión (fuera del modal, se muestra solo en @media print) -->
    <div id="recibo-print"></div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast Helper -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>

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

</body>
</html>
