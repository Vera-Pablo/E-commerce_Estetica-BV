<?= $this->extend('layouts/admin_panel.php') ?>
<?= $this->section('title') ?> Categorias <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Categorías</h6>
            <!-- modal para agregar una categoria nueva-->
            <button type="button" class="btn btn-success btn-sm btn-add-category" 
                data-bs-toggle="modal" 
                data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Agregar Categoría
            </button>
            </button>                            
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td>#<?= esc($category->id_categorie) ?></td>
                                    
                                    <td>
                                        <?= esc($category->name) ?>
                                        <br>
                                        <small class="text-muted"><?= esc($category->slug) ?></small>
                                    </td>
                                    <td><?= esc($category->description) ?></td>
                                    <td>
                                        <?php if ($category->is_active): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        
                                        <button type="button" class="btn btn-primary btn-sm btn-edit-category" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editeModal"
                                            data-id="<?= $category->id_categorie ?>"
                                            data-status="<?= $category->is_active ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                            
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-category" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-id="<?= $category->id_categorie ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        
                                        <button type="button" class="btn btn-sm btn-warning btn-status-category" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#statusModal"
                                            data-id="<?= $category->id_categorie ?>">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay categorias registradas</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- modal para agregar categoria sin que el campo de slug y descripcion sea obligatorio -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Agregar Nueva Categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addCategoryForm" method="post" action="<?= base_url('admin/categories/add') ?>">
                                    <div class="mb-3">
                                        <label for="categoryName" class="form-label">Nombre de la Categoría</label>
                                        <input type="text" class="form-control" id="categoryName" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categorySlug" class="form-label">slug</label>
                                        <input type="text" class="form-control" id="categorySlug" name="slug">
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoryDescription" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="categoryDescription" name="description">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Agregar Categoría</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal para editar categoria -->
                <div class="modal fade" id="editeModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Editar Categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editCategoryForm" method="post" action="<?= base_url('admin/categories/update') ?>">
                                    <input type="hidden" name="id_categorie" id="editCategoryId">
                                    <div class="mb-3">
                                        <label for="editCategoryName" class="form-label">Nombre de la Categoría</label>
                                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editCategorySlug" class="form-label">slug</label>
                                        <input type="text" class="form-control" id="editCategorySlug" name="slug" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editCategoryDescription" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="editCategoryDescription" name="description" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal para eliminar categoria -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="deleteCategoryForm" method="post" action="<?= base_url('admin/categories/delete') ?>">
                                    <input type="hidden" name="id_categorie" id="deleteCategoryId">
                                    <p>¿Estás seguro de que deseas eliminar esta categoría?</p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal para cambiar estado de la categoria -->
                <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statusModalLabel">Cambiar Estado de la Categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="statusCategoryForm" method="post" action="<?= base_url('admin/categories/update_status') ?>">
                                    <input type="hidden" name="id_categorie" id="statusCategoryId">
                                    <div class="mb-3">
                                        <label for="categoryStatus" class="form-label">Estado</label>
                                        <select class="form-select" id="categoryStatus" name="is_active" required>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
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
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Manejador para cargar datos al abrir modal de edición
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editeModal');
        const editButtons = document.querySelectorAll('.btn-edit-category');
        const deleteButtons = document.querySelectorAll('.btn-delete-category');
        const statusButtons = document.querySelectorAll('.btn-status-category');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                loadCategoryData(categoryId);
            });
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                document.getElementById('deleteCategoryId').value = categoryId;
            });
        });

        statusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                const isActive = this.getAttribute('data-status');
                document.getElementById('statusCategoryId').value = categoryId;
                document.getElementById('categoryStatus').value = isActive == '1' || isActive == 1 ? '1' : '0';
            });
        });

        // Cargar datos de la categoría vía AJAX
        function loadCategoryData(categoryId) {
            const url = `<?= base_url('admin/categories/get_data') ?>/${categoryId}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Llenar los campos del formulario de edición
                        document.getElementById('editCategoryId').value = data.data.id_categorie;
                        document.getElementById('editCategoryName').value = data.data.name;
                        document.getElementById('editCategorySlug').value = data.data.slug;
                        document.getElementById('editCategoryDescription').value = data.data.description;
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los datos:', error);
                    alert('Hubo un error al cargar los datos de la categoría');
                });
        }
    });
</script>
<?= $this->endSection() ?>