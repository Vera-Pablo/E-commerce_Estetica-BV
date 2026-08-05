---
name: crear-issue-linear
description: >
  Crea issues en Linear para el proyecto "E-commerce: Estetica-BV".
  Úsala cuando pidan crear/reportar bugs, features, mejoras o tareas técnicas en Linear.
---

# Crear Issue en Linear

## Default
- **Equipo**: "E-commerce: Estetica-BV"
- **Asignado**: "pgvfacultad" (auto-asignado a todas las issues)
- Si el usuario no especifica otro equipo, usar este.

## Flujo
1. Si el usuario pidió un equipo distinto, usar `linear_search_teams` para ubicarlo
2. Si se menciona un proyecto, usar `linear_search_projects` para obtener `projectId`
3. **Obtener datos obligatorios del usuario** (si no vinieron en el prompt):
   - Número de issue (I) y ticket (T) para el título estructurado
   - Prioridad (0=ninguna, 1=urgente, 2=alta, 3=media, 4=baja)
   - Labels opcionales (array de nombres/IDs)
4. Crear el issue con `linear_create_issue`:
   - `title`: `"I{issue}-T{ticket}: {titulo}"` (formato obligatorio)
   - `description`: solo lo que el usuario provea (sin módulo, prioridad ni labels)
   - `priority`: valor numérico 0-4
   - `teamId`: del equipo default o seleccionado
   - `assigneeId`: `"pgvfacultad"`
   - `projectId`: si aplica
   - `labels`: array de labels (si se proveyeron)
5. Confirmar al usuario con el link del issue creado

## Tips
- Para múltiples issues relacionados, crearlos uno por uno preguntando I/T de cada uno
- Si el usuario pide "varios issues", preguntar cuántos y sus títulos + I/T de cada uno
- El formato I-T es obligatorio: siempre pedir si falta