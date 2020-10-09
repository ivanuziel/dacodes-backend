
# Desarrollado en laravel versión 6

### Paquetes utilizados:

| Package | README |
| ------ | ------ |
| Laravel/Passport | https://laravel.com/docs/6.x/passport |
| darkaonline/l5-swagger | https://github.com/DarkaOnLine/L5-Swagger |

## Instalación del sistema
- Configuración de la base de datos en el `.env`
- Configuración de variable `L5_SWAGGER_BASE_PATH` con el dominio utilizado para el sistema
- Ejecutar comando `composer install` en la terminal
- Ejecutar comando `php artisan migrate` en la terminal
- Ejecutar comando `php artisan passport:install` en la terminal
- Ejecutar comando `php artisan db:seed` en la terminal para los datos de prueba

## Enpoints
Los endpoints están registrados en el swagger (`/api/documentation`).

## Notas del proyecto

Accesos para probar API del profesor:
| Username | Password |
| ------ | ------ |
| professor@mail.com | 1234567890 |
| student@mail.com | 1234567890 |

El **client_id_** y **client_secret** del passport se encuentra en la tabla `oauth_clients` en la base de datos, usar el **Laravel Password Grant Client**.

Elementos editados:
- Middleware: Validar acceso de profesores
- Exception handler: Capturar errores 404 ocasionados por el métido firstOrFail u otros y retornarlos como json
- Request: Separación de validaciones en request
- Security: Implementación de Laravel Passport (OAuth2)
- Data: Implementación básica de seeders y factories para datos de prueba (`GlobalSeeder`)
- API: Implementación de Swagger OpenApi para documentación básica de endpoints

### Notas
- Por instrucciones literales se hizo con Laravel sin embargo, y dependiendo de los requerimientos, el desarrollo quedaría más ligero con Lumen Framework.