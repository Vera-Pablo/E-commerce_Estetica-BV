# Reglas de Desarrollo

<aside>
<img src="https://app.notion.com/icons/document_lightgray.svg" alt="https://app.notion.com/icons/document_lightgray.svg" width="40px" />

**Versión: 1.1.0**

**Fecha: 11/8/2026**

**Autor: Vera Pablo G.**

**Cambios: Se agregó el Capítulo VI (Verificación y Pruebas) con la obligación de ejecutar tests de los flujos críticos en cada issue; se renumeró el resumen de prioridad a Capítulo VII y se corrigieron numeraciones de sección.**

**Alcance: Reglas obligatorias (de tipo "sí o sí") que deben cumplirse a la hora de generar un issue y de implementar cada funcionalidad.**

</aside>

---

## Capítulo I: Reglas de Diseño y Estilo

> **Principio rector:** El sistema cuenta con una **identidad visual ya definida** en `public/assets/css/base.css`. Prohibido inventar estilos nuevos o dejar que la IA asuma el diseño por su cuenta. Todo lo que se construya debe reutilizar los recursos ya existentes.

### 1.1 Estilos Base Obligatorios

- **RGL-D-01:** Todo desarrollo debe reutilizar la hoja de estilos base `public/assets/css/base.css`. No crear hojas de estilo nuevas para redefinir comportamiento ya existente.
- **RGL-D-02:** Está **prohibido** agregar tipografías nuevas. Las únicas permitidas son:
    - `Arimo` (sans-serif) → texto general y `body`.
    - `League Spartan` (sans-serif) → títulos `h1`–`h6`, `.fw-bold` y `.font-spartan`.
- **RGL-D-03:** No cambiar el color de fondo base del `body` (`#fff6e9`) ni los estilos globales existentes.

### 1.2 Componentes de Interfaz Reutilizables

Deben utilizarse **exclusivamente** los componentes ya definidos en `base.css`:

- **Botones:**
  - `.btn-custom-nav` → botón principal / acción destacada (fondo gris oscuro `#444444`, hover con elevación).
  - `.btn-custom-back` → botón secundario / volver (fondo blanco, borde `#dee2e6`).
- **Navbar:** Usar la navbar compartida `Layouts/navbar.php` con la clase `navbar-custom` (fondo semitransparente con `backdrop-filter: blur`).
- **Sidebar Admin:** Usar el layout `Layouts/admin/base_admin.php` con su `sidebar.php`; **nunca** reescribir la navegación del panel.
- **Carousel / Hero:** Aprovechar el carrusel `#introCarousel` para secciones de presentación; las imágenes de fondo se gestionan desde `base.css` (`.carousel-item-1/2/3`).

### 1.3 Retroalimentación (Toast)

- **RGL-D-04:** Toda notificación/retroalimentación al usuario debe emitirse usando el helper central `public/assets/js/toast.js` (clase `ToastHelper`).
- **RGL-D-05:** Usar exclusivamente los 3 tipos definidos: `success`, `error`, `warning`. Está prohibido inventar toasts nuevos o reproducir la lógica de notificación por mano.
- **RGL-D-06:** Los mensajes flash del servidor (CodeIgniter 4) deben cargarse como elementos `#flash-success`, `#flash-error`, `#flash-warning` para que `toast.js` los capture automáticamente.

### 1.4 Modales

- **RGL-D-07:** Los modales deben construirse con **Bootstrap 5** respetando su estructura estándar (`.modal-dialog`, `.modal-content`, `.modal-header`, `.modal-body`, `.modal-footer`) y el formato visual ya usado en las vistas admin (ver `app/Views/admin/*`).
- **RGL-D-08:** Mantener la tipografía y el estilo visual según el punto 1.1; no personalizar modales con estilos inline innecesarios.

### 1.5 Animaciones y Transiciones

- **RGL-D-09:** Reutilizar las transiciones ya definidas en `base.css` (hover en botones, `.nav-link`, sidebar). No definir animaciones nuevas para elementos que ya tienen comportamiento definido.
- **RGL-D-10:** Las animaciones nuevas (si fueran estrictamente necesarias) deben seguir el patrón de las existentes: transiciones de `transform` y `box-shadow` de ~0.2s–0.3s, de tono sobrio y sin efectos que compliquen la fluidez de la página.

---

## Capítulo II: Reglas de Estructura y Optimización

### Principio rector:
El e-commerce debe ser **óptimo, fluido y de respuesta rápida**. Respetar las formas adoptadas, incluyendo los `<head>` y la carga de recursos.

### 2.1 Encabezados y Carga de Recursos (`<head>`)

- **RGL-E-01:** Toda vista debe partir de un layout base existente **`Layouts/base.php`** (público) o **`Layouts/admin/base_admin.php`** (panel). Está prohibido generar páginas HTML desde cero sin usar estos layouts.
- **RGL-E-02:** Los `<head>` de los layouts ya incluyen, en orden correcto:
  1. `preconnect` y carga de **Google Fonts** (`Arimo` + `League Spartan`).
  2. **Bootstrap 5.3.2** CSS (CDN jsDelivr).
  3. **Font Awesome 6.4.2** CSS (CDN cdnjs).
  4. `assets/css/base.css` (custom).
  5. Sección `styles` (extensible por la vista hija).
  No duplicar ni reordenar estas cargas en las vistas hijas; solo agregar estilos específicos en la sección `styles`.
- **RGL-E-03:** Carga de scripts al final del `body`: **Bootstrap JS bundle** y **`toast.js`**, seguidos de la sección `scripts`. No cargar scripts en el `<head>`.

### 2.2 Carga de Recursos y Rendimiento

- **RGL-E-04:** Usar **`base_url()`** (helper de CodeIgniter) para todas las rutas a assets, CSS, JS e imágenes. Prohibido rutas relativas duras o `../`.
- **RGL-E-05:** **Imágenes únicamente en formato `webp`** (ya usado en `banners/`, `logos/`, `team/`). No subir PNG/JPG salvo necesidad imperativa.
- **RGL-E-06:** Incluir los atributos `width` y `height` (o `max-height`) en las etiquetas `<img>` para evitar `layout shift / CLS` y optimizar el render.
- **RGL-E-07:** Optimizar consultas a BD: usar los **Modelos** de CI4 con `builder`/`query` eficiente, `select()` de solo columnas necesarias y evitar consultas N+1 en los listados (catálogo, ventas, etc.).
- **RGL-E-08:** Minimizar el JS/DOM: reutilizar `toast.js` y componentes Bootstrap; evitar múltiples copias de bibliotecas o inline script redundante.

### 2.3 Responsividad

- **RGL-E-09:** Toda vista debe ser totalmente **responsiva** (móvil / tablet / escritorio) usando grid de Bootstrap (`.container`, `.row`, `.col-*`, breakpoints `sm/md/lg/xl`).
- **RGL-E-10:** Verificar el comportamiento de la navbar `sticky-top`, el toggler móvil y el dropdown en pantallas pequeñas antes de considerar una funcionalidad completa.

---

## Capítulo III: Buenas Prácticas y Reutilización de Código

### Principio general: **Reutilizar antes de reescribir.** El sistema ya tiene estructura, helpers y componentes. La IA/desarrollador debe apoyarse en lo existente.

### 3.1 Patrón MVC y Estructura

- **RGL-B-01:** Separar estrictamente Modelo – Vista – Controlador. No ejecutar consultas SQL en las Vistas; no escribir HTML en los Controladores.
- **RGL-B-02:** Toda lógica de acceso a datos en `app/Models` (10 modelos ya existentes). Crear un modelo nuevo solo si no existe ninguno cubra la entidad.
- **RGL-B-03:** No duplicar controladores ni layouts; reutilizar `BaseController`, los filters `AdminFilter`/`CustomerFilter` y los layouts existentes.
- **RGL-B-04:** Usar los métodos de validación y los filtros de ruta de CI4 ya configurados (`app/Config/`), sin reinventar helpers de seguridad por visto.

### 3.2 Reutilización y Evitar Redundancia

- **RGL-BC-05:** **Prohibido copiar-pegar bloques** de CSS/JS/HTML entre vistas para adaptarlos ligeramente. Si un bloque se repite, debe ir centralizado en `base.css`, un layout o un partial/helper.
- **RGL-BC-06:** Centralizar utilidades compartidas (tostados, manejo de sesión, cálculo de totales, formateo) en helpers o librerías, no repetirlas por cada controlador.
- **RGL-BC-07:** Antes de crear una función/método, verificar si ya existe en `Libraries/` (`EmailService`, `TokenService`) o en los Modelos.
- **RGL-BC-08:** Evitar **código muerto o basura**: eliminar comentarios innecesarios, código sin usar y archivos de prueba temporales (ej. `public/test_styles_toast.html` deja de persistir en commit).

### 3.3 Nombrado y Organización

- **RGL-BC-09:** Respectar las convenciones de CodeIgniter 4: clases en `PascalCase`, métodos `camelCase`, nombres de archivo iguales a la clase, nombres de tabla/modelo en español del proyecto.
- **RGL-BC-10:** Mantener un modelo por entidad y una migración por tabla, numeradas por fecha (convención CI4 ya usada).

---

## Capítulo IV: Ciberseguridad

### Principio general: **Seguridad es obligatoria**, no opcional. Todo desarrollo debe cumplir como mínimo con estas normas (derivadas de los RNF-03 y de las buenas prácticas de CodeIgniter).

### 4.1 Autenticación y Contraseñas

- **RGL-C-01:** Las contraseñas **nunca** en texto plano. Usar el helper `password_hash()` de PHP (bcrypt) del framework/Services de CI4 para creación y verificación.
- **RGL-C-02:** Usar sesiones seguras (`Session` de CI4 configurada en la App) para gestionar el estado de login; no guardados de datos sensibles en cookies.
- **RGL-C-03:** Al iniciar sesión/registro, validar todos los inputs con las reglas de validación de CI4 (`Validation`) y escape de salida.

### 4.2 Escapado y Protección contra Inyecciones

- **RGL-C-04:** **Siempre** escapar la salida de datos del usuario/vista con `esc()` de CodeIgniter. Prohibido servir variables sin `esc()` en las vistas.
- **RGL-C-05:** Usar preparado ancho (`$builder->where()`, binding de parámetros del Query Builder o `$db->query('...', $params)`) para consultas. **Prohibido** concatenar cadenas SQL.
- **RGL-C-06:** No confiar en datos del cliente (GET, POST, sesión) para lógica de privilegios; validar siempre en servidor de acuerdo al rol (`AdminFilter`, `CustomerFilter`).

### 4.4 Control de Acceso (Roles)

- **RGL-C-07:** Toda ruta del panel **Admin** debe ser protegida por `AdminFilter` (id_rol=1). Toda área de cliente autenticado por `CustomerFilter` (id_rol=2). No exponer endpoints privados.
- **RGL-C-08:** Verificar que el usuario autenticado y su `/roles` no se puedan incrementar/forzar por parámetros de petición.
- **RGL-C-09:** Subir archivos (imágenes de productos) validando **tipo MIME**, **extensión**, **tamaño** y renombrando con nombre único; nunca guardar rutas derivadas del input del usuario sin sanear.
- **RGL-C-10:** Aplicar token anti-CSRF de CI4 en todos los formularios que modifiquen estado/actualizan datos.
- **De la seguridad de la sesión:** uso de `session` server-side; cookies con flags `HttpOnly`, `Secure` en producción (conforme la config absoluta del proyecto).

---

## Capítulo V: Evitar Código Basura, Redundancia y Mantenimiento

### Principio general: **Menos es más.** Un código limpio y sin duplicados es más fácil de mantener, probar y escalar.

### 5.1 Limpieza

- **RGL-CB-01:** Eliminar archivos de prueba/descartés del repositorio (ej.: `public/test_styles_toast.html`) y bloques comentados que no correspondan a lógica activa.
- **RGL-CB-02:** No versionar dependencias temporales ni duplicados de bibliotecas. Toda dependencia se declara en `composer.json` y se instala vía Composer (o CDN cuando corresponde).

### 5.2 Redundancia

- **RGL-CB-03:** Evitar repetir la misma lógica en múltiples controladores; si se repite 2+ veces, extraer a helper/model/service.
- **RGL-CB-04:** No declarar constantes mágicas repetidas; centralizar valores que se repiten (colores, config, rutas) en la config de CI4 y en `base.css`.

### 5.3 Documentación y Trazabilidad de Issues

- **RGL-CB-05:** Todo issue de Linear debe seguir el formato de la skill `crear-issue-linear`:
  - Título estructurado `I{numero}-T{ticket}: {título}` siempre que falten hay que pedirlo al autor.
  - Prioridad en la propiedad `priority` del issue (no en la descripción).
  - Asignado SIEMPRE al único desarrollador (`pgvfacultad`).
  - Etiquetas/labels usadas en el apartado nativo de labels de Linear (no embebidos en la descripción).
  - Descripción limpia: solo lo que declare el autor, sin el módulo donde se trabaja.
- **RGL-CB-06:** Tareas/páginas de Notion deben crearse en la base de datos `"E-commerce: Estetica-BV"` con las propiedades del schema (skill `crear-tarea-notion`).

---

## Capítulo VI: Verificación y Pruebas (Testing)

> **Principio rector:** Cada vez que se realice una issue, debe ejecutarse una batería de pruebas de los diferentes **flujos** del E-commerce para verificar que se cumplan las condiciones y criterios definidos para el proyecto. Implementar una funcionalidad sin verificarla no se considera completar la tarea.

### 6.1 Obligación de Pruebas por Issue

- **RGL-T-01:** Toda issue debe incluir, como parte de su aceptación, la ejecución de pruebas de los flujos afectados **antes** de marcarla como completada. No se considera terminada una issue sin su verificación correspondiente.
- **RGL-T-02:** Al cerrar una issue, se deben ejecutar, como mínimo, las pruebas de **regresión** de los flujos críticos para garantizar que la nueva funcionalidad no rompió comportamiento existente.
- **RGL-T-03:** Los resultados de las pruebas deben quedar **documentados en la issue de Linear** (ver 6.4), indicando flujos probados, resultado (OK/fallo) y, si corresponde, capturas.

### 6.2 Checklist de Flujos a Verificar

Antes de dar por completa una issue, verificar los flujos que la involucran (mínimo los relacionados con el módulo afectado):

- **Autenticación:** registro, activación, login, logout y sesión.
- **Autorización por roles:** cliente (id_rol=2) no accede al panel admin (id_rol=1); protección por `AdminFilter`/`CustomerFilter`.
- **Catálogo:** listado de productos, filtro por categoría, detalle y búsqueda.
- **Carrito:** agregar/quitar productos y cálculo correcto de subtotal/total.
- **Checkout / Venta:** pasarela simulada, registro de la venta, descuento correcto de stock al confirmar.
- **Historial:** perfil del cliente y listado de compras ordenado de forma ascendente.
- **Panel Admin (CRUD):** alta/baja lógica/modificación de categorías y productos; restricción de borrado por integridad (RF-06).
- **Estados de venta y recibo:** cambio de estado y generación del recibo imprimible.
- **Consultas/Contacto:** envío de consultas y respuesta del administrador.
- **Seguridad:** escapado con `esc()`, token anti-CSRF, contraseñas hasheadas.
- **Responsividad:** correcta visualización en móvil, tablet y escritorio.

### 6.3 Criterios de Aceptación (Definition of Done)

Una issue se acepta únicamente cuando cumple **todos** los siguientes criterios:

- La funcionalidad implementada satisface el requerimiento/condición definido en la issue.
- Las pruebas de los flujos relacionados pasaron con resultado **OK** (sin fallos críticos).
- No se detectaron regresiones en flujos existentes.
- Cumple las reglas de estilo, estructura, optimización, ciberseguridad y limpieza de este documento.
- La documentación del resultado de las pruebas quedó registrada en la issue de Linear.

### 6.4 Registro del Resultado en la Issue

Al finalizar las pruebas, se deja constancia en la issue de Linear mediante un comentario con la siguiente estructura:

- **Flujos probados:** (lista de flujos ejecutados, p.ej. login, carrito, checkout)
- **Resultado:** OK / Con fallos
- **Desviaciones o fallos encontrados:** (descripción detallada y, si aplica, captura)
- **¿Cumple criterios de aceptación?:** Sí / No
- **Evidencia:** (link o captura si se generó)

---

## Capítulo VII: Resumen de Prioridad de Reglas

Cuando haya conflicto entre una regla y una instrucción puntual, prevalece **el cumplimiento de las reglas de este documento**, salvo indicación explícita del autor en el issue.

| Regla | Prioridad |
| --- | --- |
| **Ciberseguridad** | Máxima (no negociable) |
| **Verificación y Pruebas (Testing)** | Alta |
| **Estilo / Reutilización de componentes** | Alta |
| **Optimización & rendimiento** | Alta |
| **Buenas prácticas / Evitar código basura** | Media-Alta |
| **Trazabilidad de issues (Linear/Notion)** | Media |

---

*(Fin del documento — reglas.md · v1.1.0)*