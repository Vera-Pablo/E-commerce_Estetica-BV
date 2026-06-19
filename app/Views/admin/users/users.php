<?= $this->extend('layouts/admin_panel.php') ?>
<?= $this->section('title') ?> Usuarios <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Usuarios</h6>    
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <!-- muestra a todos los usuarios con sus id, nombre,email,rol y estado como objetos registrados en la base de datos -->
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>#<?= esc($user->id_user) ?></td>
                                    <td>
                                        <?= esc($user->name) ?>
                                        <br>
                                        <small class="text-muted"><?= esc($user->email) ?></small>
                                    </td>
                                    <td><?= strlen($user->role) > 20 ? esc(substr($user->role, 0, 20)) . "..." : esc($user->role) ?></td>
                                    <td><?= esc($user->status) ?></td>
                                    <td>
                                        <?php if ($user->is_active): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                        <!-- buttom with modal to action -->
                                    <td>                            
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-user" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-id="<?= $user->id_user ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        
                                        <button type="button" class="btn btn-sm btn-warning btn-status-user" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#statusModal"
                                            data-id="<?= $user->id_user ?>">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay usuarios registrados</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- include modal -->
                <!-- delete modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="deleteUserForm" method="post" action="<?= base_url('admin/users/delete') ?>">
                                    <input type="hidden" id="deleteUserId" name="id_user" value="">
                                    <p>¿Está seguro de que desea eliminar este usuario?</p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- status modal -->
                <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statusModalLabel">Cambiar Estado del Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="statusUserForm" method="post" action="<?= base_url('admin/users/status') ?>">
                                    <input type="hidden" id="statusUserId" name="id_user" value="">
                                    <p>¿Está seguro de que desea cambiar el estado de este usuario?</p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-warning">Cambiar Estado</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>  
<?= $this->section('scripts') ?>
<script>
    // Manejador para cargar datos al abrir modal de edición
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete-user');
        const statusButtons = document.querySelectorAll('.btn-status-user');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                document.getElementById('deleteUserId').value = userId;
            });
        });

        statusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const isActive = this.getAttribute('data-status');
                document.getElementById('statusUserId').value = userId;
                document.getElementById('userStatus').value = isActive == '1' || isActive == 1 ? '1' : '0';
            });
        });
    });
</script>
<?= $this->endSection() ?>