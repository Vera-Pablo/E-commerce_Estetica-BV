# 🛍️ Estética BV - E-commerce

Bienvenido al repositorio oficial del proyecto e-commerce **Estética BV**, una plataforma de venta de productos de belleza y cuidado personal desarrollada con CodeIgniter 4.

## 📋 Descripción del Proyecto

El sistema está diseñado para ofrecer una experiencia de compra fluida e intuitiva, permitiendo a los clientes explorar el catálogo, gestionar su carrito y realizar pedidos (checkout simulado). Además, incluye un robusto panel de administración para la gestión integral de productos, categorías, ventas, consultas de clientes y configuración de la tienda.

## ⭐ Características Principales

### Para Clientes (Rol `Cliente` - id_rol: 2)
- **Catálogo de Productos**: Búsqueda, filtros por categoría y visualización de detalles.
- **Carrito Persistente**: Carrito de compras dual (sesión y cookie nativa con TTL de 7 días). El carrito persiste incluso tras el logout y no requiere estar autenticado para utilizarlo (solo la sección de checkout lo requiere).
- **Favoritos**: Añadir/quitar productos a favoritos usando AJAX (con icono de corazón en la navegación, catálogo y detalles).
- **Proceso de Checkout**: Confirmación de compra simulada con diferentes métodos de pago y de envío.
- **Área Personal**: Gestión de perfil de usuario, historial de compras, descarga de recibos en formato PDF y revisión de productos favoritos.
- **Consultas**: Envío de dudas o comentarios directos a la administración desde el portal web.
- **Rendimiento**: Pre-carga instantánea de páginas (prefetching con `instantpage.js` y Speculation Rules API).

### Para Administración (Rol `Admin` - id_rol: 1)
- **Dashboard y KPIs**: Panel con estadísticas de ventas comparativas mensuales, distribución de métodos de pago y tipos de entrega, alertas de bajo stock (<= 5), contador de clientes activos y ranking del top 10 de clientes.
- **Gestión de Catálogo**: CRUD completo de Categorías y Productos.
- **Gestión de Ventas**: Control de ventas y actualización de los estados (*Pendiente*, *En Preparación*, *Listo para retirar/enviar*, *Entregado*). El estado "Entregado" (id=4) es definitivo e inmutable.
- **Gestión de Usuarios**: Visualización y control de cuentas de clientes.
- **Diseñador (Designer)**: Gestión visual de los banners promocionales del inicio (modifica `writable/banners.json`).
- **Atención al Cliente**: Bandeja de lectura y seguimiento de consultas enviadas por los usuarios.
- **Recibos**: Generación y visualización de recibos en formato PDF mediante `PdfService`.

*Nota: La autenticación mediante Google OAuth se encuentra en desarrollo (rutas existentes pero comentadas, implementación pendiente).*

## 💻 Tech Stack

### Backend
- **Framework**: CodeIgniter 4
- **Lenguaje**: PHP 8.1+
- **Base de Datos**: MySQL (MySQLi)
- **Servidor**: Apache (entorno XAMPP en Windows)
- **Autenticación**: Sesiones nativas de CI4 + encriptación bcrypt, validación/recuperación vía correo electrónico (usando `TokenService` y `EmailService`).

### Frontend
- **Maquetado y Estilos**: HTML5, CSS3, Vanilla JS, Bootstrap 5.3. CSS unificado en un solo archivo: `base.css`.
- **Tipografía e Iconos**: Google Fonts (Arimo para textos, League Spartan para títulos), Font Awesome.
- **Formatos y Optimización**: Todas las imágenes se sirven en formato `.webp` (banners/, logos/, team/) con procesamiento mediante Cloudinary.

### Testing & Herramientas
- **Testing**: PHPUnit con base de datos en memoria SQLite3 para el entorno de pruebas.
- **Gestión de Proyecto**: Linear (Issue tracking) y Notion (Kanban). Integración con MCP (en `.opencode/skills/`).
- **Debugging y Desarrollo**: Antigravity 2.0.

## 🚀 Instalación en Entorno Local (XAMPP/Windows)

### Requisitos Previos
- XAMPP (con PHP 8.1+ y MySQL)
- Composer instalado globalmente
- Git

### Pasos de Instalación

1. **Clonar el repositorio**
   Dentro del directorio de XAMPP `c:\xampp\htdocs\`:
   ```bash
   git clone <url-del-repositorio> E-commerce_Estetica-BV
   cd E-commerce_Estetica-BV
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Iniciar servicios**
   Abre el panel de control de XAMPP e inicia los módulos **Apache** y **MySQL**.

4. **Configuración del entorno**
   Duplica el archivo `env` provisto y renómbralo a `.env`:
   ```bash
   cp env .env
   ```
   Edita el archivo `.env` para ajustar la conexión a la base de datos, entorno y la URL base:
   ```env
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost/E-commerce_Estetica-BV/public/'
   
   database.default.hostname = localhost
   database.default.database = esteticabv
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   ```
   *(Asegúrate de crear la base de datos `esteticabv` en tu phpMyAdmin antes de proceder).*

5. **Migraciones y Seeders**
   El proyecto incluye 11 migraciones y 5 seeders. Ejecuta los siguientes comandos para crear las tablas y poblar la base de datos con los datos iniciales (roles, estados, métodos de pago y usuarios por defecto):
   ```bash
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

6. **Ejecución de Pruebas**
   Para verificar la integridad del sistema usando PHPUnit y SQLite3 en memoria:
   ```bash
   composer test
   # o en su defecto:
   vendor\bin\phpunit
   ```

7. **Acceso al proyecto**
   Ingresa a través de tu navegador web a la siguiente dirección:
   ```text
   http://localhost/E-commerce_Estetica-BV/public/
   ```

## ⚡ Optimización para Producción

Antes de desplegar en un entorno de producción, es vital aplicar las siguientes optimizaciones:

1. **Autoloading optimizado de Composer**
   ```bash
   composer dump-autoload -o
   ```

2. **Caché y Optimización de CodeIgniter**
   Genera cachés de configuración y rutas precompiladas ejecutando:
   ```bash
   php spark optimize
   ```

3. **Caché OPcache**
   Asegúrate de tener habilitada y correctamente configurada la extensión OPcache en el `php.ini` del servidor en producción. Además, el proyecto hace uso del Page Caching nativo en las páginas estáticas.

## 📁 Estructura del Proyecto

```text
E-commerce_Estetica-BV/
├── app/
│   ├── Config/
│   ├── Controllers/         # 15 Controladores en total
│   │   ├── Admin/           # Categoria.php, Consulta.php, Dashboard.php, Designer.php, Producto.php, Usuario.php, Venta.php
│   │   ├── Auth/            # AuthController.php
│   │   └──                  # BaseController.php, Carrito.php, Catalogo.php, FavoritoController.php, Home.php, MisCompras.php, Perfil.php
│   ├── Filters/             # AdminFilter, CustomerFilter, CartFilter
│   ├── Libraries/           # EmailService, TokenService, PdfService, LinearNotionSkill
│   ├── Models/              # CategoriaModel, ConsultaModel, EstadoVentaModel, FavoritoModel, MetodoPagoModel, ProductoModel, RolModel, UsuarioModel, VentaDetalleModel, VentaModel
│   └── Views/               
│       ├── Layouts/         # base.php, navbar.php, footer.php, admin/base_admin.php, admin/sidebar.php
│       ├── admin/           # categorias, clientes, consultas, dashboard, designer, productos, ventas
│       ├── public/          # carrito, catalogo, checkout, estáticas, mis_compras, mis_favoritos, perfil
│       ├── public/auth/     # login, registro, recuperar
│       └── pdf/             # recibo.php
├── public/                  
│   ├── assets/              
│   │   ├── css/             # base.css
│   │   └── js/              # toast.js, instantpage.js
│   └── index.php            
├── tests/                   # Pruebas PHPUnit
├── writable/                # Sesiones, logs, cache, y banners.json (Designer)
├── vendor/                  # Dependencias Composer
└── .env                     # Variables de configuración
```

## 🤝 Créditos

Desarrollo integral para Estética BV. Apoyado con Antigravity 2.0 como principal herramienta de depuración para asegurar un entorno libre de errores.
