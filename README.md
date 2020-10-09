
# Desarrollado en laravel versión 6

### Paquetes utilizados:

| Package | README |
| ------ | ------ |
| Laravel/Passport | https://laravel.com/docs/6.x/passport |
| darkaonline/l5-swagger | https://github.com/DarkaOnLine/L5-Swagger |

## Instalación del sistema
- Renombrar el archivo `.env.example` a `.env` 
- Configuración de la base de datos en el archivo `.env`. (creado con mysql)
- Configuración de variable `L5_SWAGGER_BASE_PATH` en el archivo `.env` con el dominio utilizado para el sistema
- Ejecutar los siguientes comandos en la terminal situándote dentro la carpeta del proyecto:

```sh
$ composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan passport:install
$ php artisan db:seed
```

## Enpoints
Los endpoints están registrados en el swagger (`/api/documentation`).

## Notas del proyecto

Accesos para probar API profesor y alumno:
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