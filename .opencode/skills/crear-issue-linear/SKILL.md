---
name: crear-issue-linear
description: >
  Crea issues en Linear para el proyecto "E-commerce: Estetica-BV".
  Úsala cuando pidan crear/reportar bugs, features, mejoras o tareas técnicas en Linear.
---

# Crear Issue en Linear

## Default
- **Equipo**: "E-commerce: Estetica-BV"
- Si el usuario no especifica otro equipo, usar este.

## Flujo
1. Si el usuario pidió un equipo distinto, usar `linear_search_teams` para ubicarlo
2. Si se menciona un proyecto, usar `linear_search_projects` para obtener `projectId`
3. Preguntar al usuario si no especificó prioridad o assignee
4. Crear el issue con `linear_create_issue`:
   - `title` (requerido)
   - `description` (markdown con contexto/detalles)
   - `priority` (0=ninguna, 1=urgente, 2=alta, 3=media, 4=baja)
   - `teamId` (del equipo default o seleccionado)
   - `assigneeId` (preguntar si no se especifica)
   - `projectId` (si aplica)
   - `labels` (si aplica)
5. Confirmar al usuario con el link del issue creado

## Tips
- Para múltiples issues relacionados, crearlos uno por uno
- Si el usuario pide "varios issues", preguntar cuántos y sus títulos