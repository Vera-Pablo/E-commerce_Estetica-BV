<?= $this->extend('layouts/admin_panel.php') ?>
<?= $this->section('title') ?> Categorias <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Productos</h6>
            <button type="button" class="btn btn-success btn-sm btn-add-product" 
                data-bs-toggle="modal" 
                data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Agregar Producto
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
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>#<?= esc($product->id_product) ?></td>
                                    <td>
                                        <?= esc($product->name) ?>
                                        <br>
                                        <small class="text-muted"><?= esc($product->slug) ?></small>
                                    </td>
                                    <td><?= strlen($product->description) > 20 ? esc(substr($product->description, 0, 20)) . "..." : esc($product->description) ?></td>
                                    <td><?= esc($product->price) ?></td>
                                    <td><?= esc($product->stock) ?></td>
                                    <td>
                                        <?php if ($product->is_active): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                        <!-- buttom with modal to action -->
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm btn-add-product" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#addModal"
                                            data-id="<?= $product->id_product ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button type="button" class="btn btn-primary btn-sm btn-edit-product" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editeModal"
                                            data-id="<?= $product->id_product ?>"
                                            data-status="<?= $product->is_active ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                            
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-product" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-id="<?= $product->id_product ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        
                                        <button type="button" class="btn btn-sm btn-warning btn-status-product" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#statusModal"
                                            data-id="<?= $product->id_product ?>">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay productos registrados</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- include modals -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Agregar Nuevo Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addProductForm" method="post" action="<?= base_url('admin/products/add') ?>">
                                    <div class="mb-3">
                                        <label for="productName" class="form-label">Nombre del Producto</label>
                                        <input type="text" class="form-control" id="productName" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productSlug" class="form-label">slug</label>
                                        <input type="text" class="form-control" id="productSlug" name="slug">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productDescription" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="productDescription" name="description">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label">Precio</label>
                                        <input type="number" step="0.01" class="form-control" id="productPrice" name="price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productStock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" id="productStock" name="stock" required>
                                    </div>
                                    <!-- url_image -->
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">URL de la Imagen</label>
                                        <input type="text" class="form-control" id="productImage" name="url_image">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productCategory" class="form-label">Categoría</label>
                                        <select class="form-select" id="productCategory" name="category_id" required>
                                            <option value="">Seleccionar Categoría</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category->id_categorie ?>"><?= $category->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Agregar Producto</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- delete modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de que deseas eliminar este producto?</p>
                            </div>
                            <div class="modal-footer">
                                <form id="deleteProductForm" method="post" action="<?= base_url('admin/products/delete') ?>">
                                    <input type="hidden" id="deleteProductId" name="id_product" value="">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- edit modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editProductForm" method="post" action="<?= base_url('admin/products/edit') ?>">
                                    <input type="hidden" id="editProductId" name="id_product" value="">
                                    <div class="mb-3">
                                        <label for="editProductName" class="form-label">Nombre del Producto</label>
                                        <input type="text" class="form-control" id="editProductName" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductSlug" class="form-label">slug</label>
                                        <input type="text" class="form-control" id="editProductSlug" name="slug">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductDescription" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="editProductDescription" name="description">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductPrice" class="form-label">Precio</label>
                                        <input type="number" class="form-control" id="editProductPrice" name="price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductStock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" id="editProductStock" name="stock" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductStatus" class="form-label">Estado</label>
                                        <select class="form-select" id="editProductStatus" name="is_active">
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
    <!-- scripts modal products -->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const deleteModal = document.querySelectorAll('.btn-delete-product');
            deleteModal.forEach(button => {
                button.addEventListener('click', function(){
                    const productId = this.getAttribute('data-id');
                    document.getElementById('deleteProductId').value = productId;
                });
            });


        
        });
    </script>
<?= $this->endSection() ?>