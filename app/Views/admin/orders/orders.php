<?= $this->extend('layouts/admin_panel.php') ?>
<?= $this->section('title') ?> Ventas <?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
function getOrderStatus($id_status) {
    $estados = [
        1 => ['texto' => 'Pendiente', 'clase' => 'bg-warning text-dark'],
        2 => ['texto' => 'Confirmado', 'clase' => 'bg-primary'],
        3 => ['texto' => 'En preparación', 'clase' => 'bg-secondary text-white'],
        4 => ['texto' => 'Enviado', 'clase' => 'bg-info'],
        5 => ['texto' => 'completado', 'clase' => 'bg-success'],
        6 => ['texto' => 'Cancelado', 'clase' => 'bg-danger']
    ];
    
    return $estados[$id_status] ?? ['texto' => 'Desconocido', 'clase' => 'bg-secondary'];
}
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Historial de Ventas</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="table-dark">
                    <tr>
                        <th>Nº Orden</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= esc($order->order_number)?></td>
                                
                                <td>
                                    <?= esc($order->first_name) ?> <?= esc($order->last_name) ?>
                                    <br>
                                    <small class="text-muted"><?= esc($order->email) ?></small>
                                </td>

                                <td><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></td>

                                <td class="fw-bold text-success">
                                    $<?= number_format($order->total, 2) ?>
                                </td>

                                <?php $estado = getOrderStatus($order->id_status); ?>
                                <td>
                                    <span class="badge <?= $estado['clase'] ?>"><?= $estado['texto'] ?></span>
                                </td>

                                <td>
                                    <a href="<?= base_url('admin/orders/show_order/' . $order->id_order) ?>" class="btn btn-info btn-sm" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Botón para editar estado de la orden metodo post-->
                                    <button type="button" class="btn btn-warning btn-sm btn-edit-status" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#statusModal"
                                        data-id="<?= $order->id_order ?>"
                                        data-status="<?= $order->id_status ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay ventas registradas aún.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Actualizar Estado de Orden</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form action="<?= base_url('admin/orders/update_status') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="modal-body">
                                <input type="hidden" name="id_order" id="modalOrderId">

                                <div class="mb-3">
                                    <label class="form-label">Seleccionar Estado:</label>
                                    <select name="id_status" id="modalOrderStatus" class="form-select">
                                        <option value="1">Pendiente</option>
                                        <option value="2">Confirmado</option>
                                        <option value="3">En Proceso</option>
                                        <option value="4">Enviado</option>
                                        <option value="5">Completado</option>
                                        <option value="6">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Esperar a que cargue el documento
    document.addEventListener('DOMContentLoaded', function () {
        var statusModal = document.getElementById('statusModal');
        
        statusModal.addEventListener('show.bs.modal', function (event) {
            // Botón que activó el modal
            var button = event.relatedTarget;
            
            // Extraer info de los atributos data-*
            var idOrder = button.getAttribute('data-id');
            var currentStatus = button.getAttribute('data-status');
            
            // Actualizar el contenido del modal
            var modalInputId = statusModal.querySelector('#modalOrderId');
            var modalSelect = statusModal.querySelector('#modalOrderStatus');
            
            modalInputId.value = idOrder;
            modalSelect.value = currentStatus;
        });
    });
</script>
<?= $this->endSection() ?>