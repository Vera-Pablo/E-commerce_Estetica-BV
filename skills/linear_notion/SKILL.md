---
name: linear_notion
description: "Skill para crear tickets en Linear y páginas en Notion mediante los MCP configurados en opencode.json"
---
# linear_notion

Esta skill expone dos acciones:

- `accion=linear`  → crea un ticket en Linear.
- `accion=notion`  → crea una página en Notion.

Los parámetros se envían en el argumento `payload` como JSON.

## Uso en el chat
```
/skill linear_notion accion=linear payload='{"title":"Bug 123","project":"EST"}'
```
```
/skill linear_notion accion=notion payload='{"title":"Página demo","parent_id":"12345"}'
```

Los scripts PHP bajo `scripts/` manejan la conexión real con los MCP.
