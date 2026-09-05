---
name: crear-tarea-notion
description: >
  Crea tareas/páginas en la base de datos de Notion "E-commerce: Estetica-BV".
  Úsala cuando pidan registrar tareas, features, bugs o ítems de producto en Notion.
---

# Crear Tarea en Notion

## Default
- **Base de datos**: "E-commerce: Estetica-BV"
- Si el usuario no especifica otra DB, usar esta.

## Flujo
1. Si el usuario pidió otra DB, usar `notion_search` con filter=`database` para encontrarla
2. Opcional: usar `notion_retrieve_database` para inspeccionar el schema de propiedades
3. Preguntar al usuario por propiedades obligatorias faltantes (Status, Due Date, etc.)
4. Crear la página con `notion_create_page`:
   - `parent.database_id` (de la DB default o seleccionada)
   - Propiedades mapeadas según el schema de la DB
5. Confirmar al usuario con el link de la página creada