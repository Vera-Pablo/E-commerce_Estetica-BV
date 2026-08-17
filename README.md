# Estética - BV 🌸

![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue.svg?logo=php)
![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.x-EE4323.svg?logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1.svg?logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-HTTP_Server-D22128.svg?logo=apache&logoColor=white)
![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5.3-7952B3.svg?logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

**Estética BV** es una plataforma de comercio electrónico (E-commerce) desarrollada a medida para un negocio real del sector de la estética femenina. Su propósito es digitalizar el catálogo de productos, automatizar la gestión de inventario y ofrecer a las clientas un canal web ágil para simular compras. Desarrollado con **CodeIgniter 4**, implementa un patrón MVC sólido y un diseño responsivo de alto rendimiento.

---

## ✨ Características Principales

### 👩‍🦰 Para Clientes (Vistas Públicas)
- **Catálogo Dinámico:** Navegación por productos con búsqueda en tiempo real y filtrado por categoría (potenciado por AJAX).
- **Carrito de Compras:** Sistema ágil para agregar, visualizar y eliminar productos, con recálculo automático de subtotales.
- **Checkout Simulado:** Proceso de finalización de compra mediante una pasarela de pago artificial (fines académicos).
- **Panel de Usuario:** Gestión del perfil personal e historial de compras detallado.
- **Rendimiento Optimizado:** Imágenes en formato WebP con `loading="lazy"` (Carga diferida) y tipografías cargadas con `<link rel="preconnect">` para evitar el bloqueo del renderizado.

### 🛡️ Para Administración (Panel Privado)
- **Dashboard Protegido:** Acceso restringido exclusivamente a usuarios con rol Administrador.
- **Gestión de Inventario (CRUD):** Creación, edición y baja lógica (TINYINT) de Categorías y Productos.
- **Control de Ventas:** Visualización del historial de transacciones, actualización de estados de envío y gestión de métodos de pago.
- **Respuestas a Consultas:** Sistema integrado para leer y responder inquietudes de los clientes.

---

## 💻 Stack Tecnológico y Arquitectura

El sistema está construido bajo la arquitectura **Cliente-Servidor** y respeta estrictamente el patrón **Modelo-Vista-Controlador (MVC)**.

- **Backend:** PHP 8.1+ y CodeIgniter 4.
- **Base de Datos:** MySQL (MySQLi) relacional con integridad referencial.
- **Frontend:** HTML5, CSS3, Vanilla JS, Bootstrap 5. Tipografías *Arimo* y *League Spartan* (Google Fonts).
- **Servidor Web:** **Apache 2.4** multihilo ejecutándose en Ubuntu (WSL2), con el módulo **OPcache** activado en el SAPI para maximizar el rendimiento y la concurrencia, prescindiendo del servidor mono-hilo integrado de PHP CLI.
- **Seguridad:** Cifrado Bcrypt para contraseñas, escapado obligatorio de datos (`esc()`), protección CSRF en formularios de mutación y protección contra inyecciones XSS en manipulaciones del DOM mediante la API nativa `textContent`.

---

## 🚀 Instalación y Despliegue Local

Para levantar este proyecto en un entorno de desarrollo local (preferentemente Ubuntu sobre **WSL2** en Windows):

1. **Requisitos Previos:**
   - Git, Composer, PHP 8.1+ (con extensiones intl, mbstring, mysqlnd).
   - Servidor Apache2 (`libapache2-mod-php`).
   - Motor MySQL o MariaDB.

2. **Clonar y Preparar el Repositorio:**
   ```bash
   git clone https://github.com/Vera-Pablo/Estetica.git
   cd Estetica-BV
   composer install
   ```

3. **Configuración del Entorno (.env):**
   Duplica el archivo `env` y nómbralo `.env`. Ajusta los parámetros de base de datos:
   ```ini
   CI_ENVIRONMENT = development
   database.default.hostname = localhost
   database.default.database = estetica_bv
   database.default.username = tu_usuario
   database.default.password = tu_contraseña
   database.default.DBDriver = MySQLi
   ```

4. **Base de Datos (Migraciones y Seeders):**
   Abre la terminal en la raíz del proyecto y ejecuta:
   ```bash
   # Generar las 10 tablas de la DB
   php spark migrate
   
   # Cargar roles, estados, métodos de pago y el usuario Admin base
   php spark db:seed DatabaseSeeder
   ```

5. **Servidor Apache y OPcache:**
   - Asegúrate de que el *Document Root* de tu VirtualHost apunte a la carpeta `/public` del proyecto.
   - Arranca los servicios manualmente:
     ```bash
     sudo service mysql start
     sudo service apache2 start
     ```
   *(Nota: Ya no se utiliza `php spark serve`, el proyecto se sirve vía Apache para aprovechar el OPcache y resolver concurrencias)*.

6. **¡Listo!**
   Ingresa a `http://localhost/` desde tu navegador web.

---

## 📁 Estructura del Proyecto

Las áreas más relevantes del código se organizan de la siguiente manera:

- `app/Controllers/`: Lógica de negocio separada en `/Admin`, `/Auth` y Controladores Públicos (`Catalogo`, `Home`).
- `app/Views/`:
  - `/Layouts`: Plantillas base reutilizables (`base.php`, `navbar.php`, `admin/base_admin.php`).
  - `/public`: Vistas front-end para los clientes.
  - `/admin`: Vistas del panel de control privado.
- `app/Models/`: Interacciones directas con las tablas de MySQL (10 modelos principales).
- `app/Filters/`: Filtros de intercepción de rutas para asegurar los permisos de Administrador y Cliente.
- `public/assets/`: Única hoja de estilos permitida (`css/base.css`), utilidades de alertas dinámicas (`js/toast.js`) y recursos de imagen altamente comprimidos.
- `docs/`: Documentación formal del sistema (Reglas, Especificaciones y Diagramas ER/MVC).

---

## 👨‍💻 Créditos y Mantenimiento

Proyecto desarrollado en el marco de la asignatura *Taller de Programación I* y mantenido activamente por:
**Vera Pablo G.** (@Vera-Pablo)

> Las contribuciones formales se gestionan mediante *Issues* en Linear y tareas en Notion integradas en el entorno local a través del sistema MCP (`.opencode/skills/`).
