<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Catálogo<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7 text-white">
                <h1 class="display-4 fw-bold mb-4">
                    Catálogo
                </h1>
                <p class="lead mb-4">
                    ¡Descubre nuestros productos profesionales!
                </p>
            </div>
            
            <div class="col-sm text-white">
                <form action="<?= base_url('catalog') ?>" method="get" class="d-flex gap-2 mt-5" style="height: 40px;">
                    <?php if($currentCategory): ?>
                        <input type="hidden" name="categoria" value="<?= esc($currentCategory) ?>">
                    <?php endif; ?>

                    <input type="text" name="buscar" class="form-control" 
                        placeholder="Buscar productos..." 
                        value="<?= esc($currentSearch) ?>">

                    <button type="submit" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                        
                    <?php if($currentCategory || $currentSearch): ?>
                        <a href="<?= base_url('catalog') ?>" class="btn btn-primary d-flex align-items-center">
                            Limpiar
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="mt-5">
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="list-group list-group-flush">
                        <a href="<?= base_url('catalog') ?>" class="list-group-item list-group-item-action">
                            Todos los productos
                        </a>
                        <?php foreach ($categories as $category): ?>
                            <?php 
                                $isActive = ($currentCategory == $category->id_categorie) ? 'active' : ''; 
                            ?>
                            <a href="<?= base_url('catalog?categoria=' . $category->id_categorie) ?>" 
                            class="list-group-item list-group-item-action<?= $isActive ?>">
                                <?= esc($category->name) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <?php if (empty($products)): ?>
                    <div class="alert alert-info text-center">
                        No hay productos disponibles en este momento.
                    </div>
                <?php else: ?>
                    
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm border-0 product-card">
                                    
                                    <div class="position-relative overflow-hidden" style="height: 250px;">
                                        <img src="<?= $product->image_url ?>" 
                                            class="card-img-top w-100 h-100 object-fit-cover" 
                                            alt="<?= esc($product->name) ?>">
                                            
                                        <?php if($product->stock < 5): ?>
                                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">¡Últimas unidades!</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?= esc($product->name) ?></h5>
                                    
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-3 py-4">
                                        <span class="h5 mb-0 text-primary fw-bold">
                                            <?= $product->formatted_price ?>
                                        </span>
                                        <a href="<?= base_url('product_detail/' . $product->id_product) ?>" class="btn btn-outline-dark btn-sm">
                                            Ver Detalle
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section> 

<?= $this->endSection() ?>