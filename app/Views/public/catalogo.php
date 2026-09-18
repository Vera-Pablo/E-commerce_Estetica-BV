<?= $this->extend('Layouts/base') ?>

<?= $this->section('content') ?>
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <div class="row mb-4 text-center">
            <div class="col-12">
                <h1 class="fw-bold mb-3 font-spartan">Catálogo de Productos</h1>
                <p class="lead text-muted">Encuentra los mejores productos para el cuidado de tu piel y cuerpo.</p>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="row mb-5 justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card border-0 rounded-4" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.1);">
                    <div class="card-body p-4">
                        <form id="filtro-form" class="row g-3 align-items-end" onsubmit="event.preventDefault();">
                            <div class="col-md-5">
                                <label for="search" class="form-label fw-bold">Buscar por nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" class="form-control" id="search" placeholder="Ej. Crema hidratante...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="categoria" class="form-label fw-bold">Categoría</label>
                                <select class="form-select" id="categoria">
                                    <option value="">Todas las categorías</option>
                                    <?php if (!empty($categorias)): ?>
                                        <?php foreach ($categorias as $cat): ?>
                                            <option value="<?= esc($cat['id_categoria']) ?>"><?= esc($cat['nombre_categoria']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3 text-md-end text-center mt-3 mt-md-0">
                                <button type="button" class="btn btn-outline-secondary w-100" id="btn-limpiar">
                                    <i class="fas fa-times me-1"></i> Limpiar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grilla de Productos -->
        <div class="row g-4" id="productos-grid">
            <?php if (empty($productos)): ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted font-spartan">No se encontraron productos</h4>
                </div>
            <?php else: ?>
                <?php foreach ($productos as $prod): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                        <div class="card h-100 border-0 rounded-4 card-hover position-relative" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                            
                            <!-- Botón Favorito -->
                            <?php $isFavorito = isset($favoritosIds) && in_array($prod['id_producto'], $favoritosIds); ?>
                            <button type="button" 
                                    class="btn p-2 border-0 bg-transparent position-absolute top-0 end-0 m-2" 
                                    style="z-index: 10;"
                                    title="<?= $isFavorito ? 'Quitar de favoritos' : 'Agregar a favoritos' ?>"
                                    onclick="toggleFavorito(<?= $prod['id_producto'] ?>, this)">
                                <i class="<?= $isFavorito ? 'fas' : 'far' ?> fa-heart fs-4 text-danger"></i>
                            </button>

                            <a href="<?= base_url('producto/' . esc($prod['id_producto'])) ?>" class="text-decoration-none text-dark">
                                <img src="<?= esc(cloudinary_thumb($prod['imagen'] ?? null)) ?>" 
                                     class="card-img-top product-img bg-light rounded-top-4" 
                                     alt="Imagen de <?= esc($prod['nombre_producto']) ?>" 
                                     loading="lazy" decoding="async" width="100%" height="250" style="object-fit: cover;">
                                <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                                    <h5 class="card-title font-spartan fw-bold mb-3"><?= esc($prod['nombre_producto']) ?></h5>
                                    <p class="card-text text-dark fw-bold fs-5 mb-0">$ <?= number_format((float)$prod['precio'], 2, ',', '.') ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

    <?= $this->include('Layouts/footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const categoriaSelect = document.getElementById('categoria');
    const btnLimpiar = document.getElementById('btn-limpiar');
    const grid = document.getElementById('productos-grid');
    const urlFiltrar = '<?= base_url('catalogo/filtrar') ?>';
    const urlProductoBase = '<?= base_url('producto') ?>';
    const favoritosIds = <?= json_encode($favoritosIds ?? []) ?>;
    
    // Función para escapar HTML básico y prevenir XSS
    const escapeHtml = (unsafe) => {
        return (unsafe || '').toString()
             .replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/"/g, "&quot;")
             .replace(/'/g, "&#039;");
    };

    // Variables para debounce en búsqueda
    let timeoutId;

    const formatPrice = (price) => {
        return new Intl.NumberFormat('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price);
    };

    const fetchProductos = async () => {
        // Indicador de carga ligero
        grid.style.opacity = '0.5';

        const search = searchInput.value.trim();
        const categoria = categoriaSelect.value;
        
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (categoria) params.append('categoria', categoria);
        
        const url = `${urlFiltrar}?${params.toString()}`;

        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            
            const productos = await response.json();
            renderGrid(productos);
        } catch (error) {
            console.error('Error al filtrar productos:', error);
            grid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <h4 class="text-danger font-spartan">Ocurrió un error al cargar los productos.</h4>
                </div>
            `;
        } finally {
            grid.style.opacity = '1';
        }
    };

    const renderGrid = (productos) => {
        grid.innerHTML = ''; // Limpiar grilla
        
        if (!productos || productos.length === 0) {
            const div = document.createElement('div');
            div.className = 'col-12 text-center py-5';
            
            const icon = document.createElement('i');
            icon.className = 'fas fa-search fa-3x text-muted mb-3';
            
            const h4 = document.createElement('h4');
            h4.className = 'text-muted font-spartan';
            h4.textContent = 'No se encontraron productos para tu búsqueda.';
            
            div.appendChild(icon);
            div.appendChild(h4);
            grid.appendChild(div);
            return;
        }

        productos.forEach(prod => {
            const col = document.createElement('div');
            col.className = 'col-12 col-sm-6 col-md-4 col-xl-3';

            const isFav = favoritosIds.includes(parseInt(prod.id_producto)) || favoritosIds.includes(prod.id_producto.toString());
            const heartIcon = isFav ? 'fas text-danger' : 'far text-danger';
            const titleFav = isFav ? 'Quitar de favoritos' : 'Agregar a favoritos';
            const price = parseFloat(prod.precio).toLocaleString('es-AR', {minimumFractionDigits: 2});
            
            col.innerHTML = `
                <div class="card h-100 border-0 rounded-4 card-hover position-relative" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <button type="button" 
                            class="btn p-2 border-0 bg-transparent position-absolute top-0 end-0 m-2" 
                            style="z-index: 10;"
                            title="${titleFav}"
                            onclick="toggleFavorito(${prod.id_producto}, this)">
                        <i class="${heartIcon} fa-heart fs-4"></i>
                    </button>
                    <a href="${urlProductoBase}/${prod.id_producto}" class="text-decoration-none text-dark">
                        <img src="${prod.imagen}" 
                             class="card-img-top product-img bg-light rounded-top-4" 
                             alt="Imagen" 
                             loading="lazy" decoding="async" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                            <h5 class="card-title font-spartan fw-bold mb-3">${escapeHtml(prod.nombre_producto)}</h5>
                            <p class="card-text text-dark fw-bold fs-5 mb-0">$ ${price}</p>
                        </div>
                    </a>
                </div>
            `;
            grid.appendChild(col);
        });
    };

    // Event Listeners
    categoriaSelect.addEventListener('change', fetchProductos);
    
    searchInput.addEventListener('input', () => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(fetchProductos, 300); // debounce de 300ms
    });

    btnLimpiar.addEventListener('click', () => {
        searchInput.value = '';
        categoriaSelect.value = '';
        fetchProductos();
    });
});
</script>
<?= $this->endSection() ?>
