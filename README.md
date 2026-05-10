# Hotel Bahia Azul MVC

Sistema de reservas hoteleras en PHP con arquitectura MVC real.

## Estructura
- `app/Controllers`: controladores por módulo
- `app/Models`: acceso a datos y consultas
- `app/Views`: vistas separadas por módulo
- `app/Core`: router, controlador base, modelo base y conexión
- `public/index.php`: front controller
- `database/hotel_bahia_azul_mvc.sql`: base de datos relacional

## Módulos
- Dashboard
- Usuarios
- Habitaciones
- Paquetes de habitación
- Reservas

## Base de datos
Nombre: `hotel_bahia_azul_mvc`

## Ejecución en XAMPP
1. Copiar la carpeta al directorio `htdocs`.
2. Importar `database/hotel_bahia_azul_mvc.sql` en phpMyAdmin.
3. Abrir `http://localhost/HOTEL_BAHIA_AZUL_MVC/public/index.php?route=dashboard`

## Nota
Esta versión entra directo al sistema, sin login, para facilitar pruebas y exposición.
# HOTEL_BAHIA
