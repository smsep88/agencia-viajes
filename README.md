# Agencia de Viajes

Aplicación web en PHP y MySQL para gestionar vuelos, hoteles y reservas de una agencia de viajes.

## Requisitos
- PHP 8 con la extensión `mysqli` activada
- MySQL 8 (o MariaDB)

## Puesta en marcha
1. Crear la base de datos ejecutando `sql/agencia.sql` en MySQL Workbench.
2. Copiar `config/conexion.example.php` como `config/conexion.php` y completar usuario y contraseña.
3. Levantar el sitio (por ejemplo con `php -S localhost:8000`) y abrir `index.html`.

## Forma de trabajo
- La rama `main` siempre debe estar estable.
- Cada funcionalidad se desarrolla en una rama propia: `feature/nombre-corto`.
- Los cambios llegan a `main` solo mediante *pull request*, revisado por al menos otra persona.
- Los problemas y propuestas se registran como *issues* y se enlazan desde el PR (`Closes #n`).
- Las credenciales nunca se suben: `config/conexion.php` está en `.gitignore`.
