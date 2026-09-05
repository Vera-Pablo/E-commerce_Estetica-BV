<?php
/**
 * @var float $total
 * @var int $totalItems
 * @var array $items
 */
$total = $total ?? 0;
?>
<?= $this->extend('Layouts/base') ?>

<?= $this->section('content') ?>
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">

        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="font-spartan fw-bold">
                    <i class="fas fa-shopping-cart me-2"></i>Mi Carrito
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('catalogo') ?>" class="text-decoration-none" style="color: #000; font-weight: bold;">Catálogo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Carrito</li>
                    </ol>
                </nav>
            </div>
        </div>

        <?php if (empty($items)): ?>
        <!-- ============ ESTADO VACÍO ============ -->
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 text-center py-5">
                <i class="fas fa-cart-shopping fa-4x text-muted mb-4"></i>
                <h4 class="font-spartan text-muted mb-3">Tu carrito está vacío</h4>
                <p class="text-muted mb-4">Explorá nuestro catálogo y encontrá los mejores productos.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-custom-nav px-4 py-2">
                    <i class="fas fa-store me-2"></i>Ir al Catálogo
                </a>
            </div>
        </div>

        <?php else: ?>
        <!-- ============ CARRITO CON ÍTEMS ============ -->
        <div class="row g-4" id="carrito-wrapper">

            <!-- Columna 1: Lista de productos -->
            <div class="col-12 col-lg-8" id="lista-productos">

                <?php foreach ($items as $item): ?>
                <div class="card border-0 rounded-4 mb-3 item-carrito"
                     id="item-<?= esc($item['id_producto']) ?>"
                     data-id="<?= esc($item['id_producto']) ?>"
                     style="box-shadow: 0px 6px 14px rgba(0,0,0,0.1);">
                    <div class="card-body p-3 p-md-4">

                        <!-- Fila 1: Botón eliminar -->
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger border-0 btn-eliminar"
                                    data-id="<?= esc($item['id_producto']) ?>"
                                    title="Eliminar producto">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <!-- Fila 2: Imagen + Info -->
                        <div class="row g-3 align-items-center">
                            <!-- Imagen -->
                            <div class="col-4 col-sm-3">
                                <img src="<?= esc(cloudinary_thumb($item['imagen'] ?? null)) ?>"
                                     alt="<?= esc($item['nombre_producto']) ?>"
                                     class="img-fluid rounded-3"
                                     style="object-fit: cover; height: 120px; width: 100%;"
                                     loading="lazy" decoding="async">
                            </div>

                            <!-- Nombre, cantidad, subtotal -->
                            <div class="col-8 col-sm-9">
                                <h5 class="font-spartan fw-bold mb-1">
                                    <a href="<?= base_url('producto/' . esc($item['id_producto'])) ?>"
                                       class="text-decoration-none text-dark">
                                        <?= esc($item['nombre_producto']) ?>
                                    </a>
                                </h5>
                                <p class="text-muted small mb-2">
                                    Precio unitario: $ <?= number_format($item['precio'], 2, ',', '.') ?>
                                </p>

                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <!-- Input cantidad -->
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 small">Cant:</label>
                                        <input type="number"
                                               class="form-control form-control-sm input-cantidad"
                                               style="width: 75px;"
                                               min="1"
                                               max="<?= esc($item['stock']) ?>"
                                               value="<?= esc($item['cantidad']) ?>"
                                               data-id="<?= esc($item['id_producto']) ?>">
                                    </div>
                                    <!-- Subtotal -->
                                    <p class="text-dark fw-bold fs-5 mb-0 subtotal-item"
                                       data-id="<?= esc($item['id_producto']) ?>">
                                        $ <?= number_format($item['subtotal'], 2, ',', '.') ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php endforeach; ?>

            </div><!-- /col lista -->

            <!-- Columna 2: Resumen de compra -->
            <div class="col-12 col-lg-4">
                <div class="card border-0 rounded-4"
                     style="box-shadow: 0px 6px 14px rgba(0,0,0,0.1); position: sticky; top: 100px;">
                    <div class="card-body p-4">

                        <!-- Título -->
                        <h5 class="font-spartan fw-bold mb-4">Resumen de Compra</h5>

                        <!-- Productos y total -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Productos
                                (<span id="resumen-total-items"><?= count($items) ?></span>)
                            </span>
                            <span class="fw-bold" id="resumen-total">
                                $ <?= number_format($total ?? 0, 2, ',', '.') ?>
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold font-spartan fs-5">Total</span>
                            <span class="fw-bold text-dark fs-5" id="resumen-total-grande">
                                $ <?= number_format($total ?? 0, 2, ',', '.') ?>
                            </span>
                        </div>

                        <!-- Botón Continuar -->
                        <button type="button"
                                class="btn btn-custom-nav btn-lg w-100"
                                id="btn-continuar">
                            <i class="fas fa-arrow-right me-2"></i>Continuar
                        </button>

                    </div>
                </div>
            </div><!-- /col resumen -->

        </div><!-- /row carrito -->
        <?php endif; ?>

    </main>

    <?= $this->include('Layouts/footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    'use strict';

    const urlActualizar = '<?= base_url('carrito/actualizar') ?>';
    const urlEliminar   = '<?= base_url('carrito/eliminar') ?>';
    const csrfName      = '<?= csrf_token() ?>';
    const csrfHash      = '<?= csrf_hash() ?>';

    // Formato moneda argentina
    const formatMoney = (val) =>
        new Intl.NumberFormat('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(val);

    // Actualizar la UI de totales
    function actualizarResumen(total, totalItems) {
        const fmt = `$ ${formatMoney(total)}`;
        document.getElementById('resumen-total').textContent        = fmt;
        document.getElementById('resumen-total-grande').textContent = fmt;
        document.getElementById('resumen-total-items').textContent  = totalItems;
        // Badge del navbar
        const badge = document.getElementById('badge-carrito');
        if (badge) {
            if (totalItems > 0) {
                badge.textContent = totalItems > 99 ? '99+' : totalItems;
                badge.classList.remove('d-none');
            } else {
                badge.classList.add('d-none');
            }
        }
    }

    // Mostrar estado vacío
    function mostrarVacio() {
        const wrapper = document.getElementById('carrito-wrapper');
        if (wrapper) {
            wrapper.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-cart-shopping fa-4x text-muted mb-4"></i>
                    <h4 class="font-spartan text-muted mb-3">Tu carrito está vacío</h4>
                    <p class="text-muted mb-4">Explorá nuestro catálogo y encontrá los mejores productos.</p>
                    <a href="<?= base_url('catalogo') ?>" class="btn btn-custom-nav px-4 py-2">
                        <i class="fas fa-store me-2"></i>Ir al Catálogo
                    </a>
                </div>`;
        }
    }

    // POST genérico con CSRF
    async function postJSON(url, data) {
        const formData = new FormData();
        formData.append(csrfName, csrfHash);
        for (const [k, v] of Object.entries(data)) {
            formData.append(k, v);
        }
        const resp = await fetch(url, { method: 'POST', body: formData });
        if (!resp.ok) throw new Error('Error de red: ' + resp.status);
        return resp.json();
    }

    // ---- ACTUALIZAR CANTIDAD ----
    document.querySelectorAll('.input-cantidad').forEach(input => {
        let timer;
        input.addEventListener('change', function () {
            clearTimeout(timer);
            const idProducto   = this.dataset.id;
            const nuevaCantidad = parseInt(this.value, 10);

            timer = setTimeout(async () => {
                try {
                    const data = await postJSON(urlActualizar, {
                        id_producto:   idProducto,
                        nueva_cantidad: nuevaCantidad,
                    });

                    if (!data.ok) {
                        ToastHelper.show('error', data.message || 'Error al actualizar.');
                        return;
                    }

                    if (data.eliminado) {
                        const card = document.getElementById(`item-${idProducto}`);
                        if (card) eliminarCardConAnimacion(card);
                        if (data.carritoVacio) mostrarVacio();
                    } else {
                        // Actualizar subtotal del ítem
                        const subtotalEl = document.querySelector(`.subtotal-item[data-id="${idProducto}"]`);
                        if (subtotalEl) subtotalEl.textContent = `$ ${formatMoney(data.subtotal)}`;

                        // Ajustar input si hubo clampeo
                        if (data.stock_excedido) {
                            this.value = data.nueva_cantidad;
                            ToastHelper.show('warning', `Cantidad ajustada al stock máximo (${data.max_stock} unidades).`);
                        }
                    }

                    actualizarResumen(data.total, data.totalItems);
                } catch (e) {
                    ToastHelper.show('error', 'Error al actualizar la cantidad.');
                    console.error(e);
                }
            }, 400);
        });
    });

    // ---- ELIMINAR PRODUCTO ----
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', async function () {
            const idProducto = this.dataset.id;
            try {
                const data = await postJSON(urlEliminar, { id_producto: idProducto });

                if (!data.ok) {
                    ToastHelper.show('error', data.message || 'Error al eliminar.');
                    return;
                }

                const card = document.getElementById(`item-${idProducto}`);
                if (card) eliminarCardConAnimacion(card);

                actualizarResumen(data.total, data.totalItems);

                if (data.carritoVacio) {
                    setTimeout(mostrarVacio, 350); // Esperar la animación
                }
            } catch (e) {
                ToastHelper.show('error', 'Error al eliminar el producto.');
                console.error(e);
            }
        });
    });

    // ---- BOTÓN CONTINUAR ----
    const btnContinuar = document.getElementById('btn-continuar');
    if (btnContinuar) {
        btnContinuar.addEventListener('click', () => {
            ToastHelper.show('warning', 'Pasarela de pago próximamente.');
        });
    }

    // ---- ANIMACIÓN AL ELIMINAR ----
    function eliminarCardConAnimacion(card) {
        card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        card.style.opacity    = '0';
        card.style.transform  = 'translateX(30px)';
        setTimeout(() => card.remove(), 320);
    }
})();
</script>
<?= $this->endSection() ?>
