# Desarrollado en laravel versión 6

## Variables a configurar en `.env`

- APP_URL
- L5_SWAGGER_BASE_PATH

### Paquetes utilizados:
 - Laravel/Passport
 - darkaonline/l5-swagger


## Instalación del sistema
- Configuración de la base de datos en el .env
- Configuración de variable L5_SWAGGER_BASE_PATH
- Ejecutar comando `composer install` en la terminal
- Ejecutar comando `php artisan migrate`
- Ejecutar comando `php artisan passport:install`
- Ejecutar comando `php artisan db:seed` para los datos de prueba

## Enpoints
Los endpoints están documentados en el swager (url que se establezca en el .env).

### Notas
- Para actualizar la documentación ejecutar el código `php artisan l5-swagger:generate`
- Por instrucciones literales se hizo con Laravel sin embargo, y dependiendo de los requerimientos, el desarrollo quedaría más ligero con Lumen Framework.