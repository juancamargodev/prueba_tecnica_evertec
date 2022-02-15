# Prueba Tecnica Evertec API

## Desarrollado por Juan Pablo Camargo Vanegas

###Desarrollo de la prueba técnica de evertec. Api desarrollada en lumen

##Requerimiéntos

* ``php v7.4.27`` o superior
* `composer v2.2.5` o superior
* [Angular CLI](https://github.com/angular/angular-cli) version 12.2.11.

##Inicialización del proyecto
1. ejecute el comando ``composer install``
2. cree una copia del archivo ``.env.example``, ingrese las variables de entorno y nómbrelo como ``.env``
3. ejecute el comando ```php artisan jwt:secret``
4. ejecute  el comando ``php artisan migrate --seed``
5. efecute el comando ``php -S localhost:8000 -t public``
6. la página se visalizará en la url [`http://localhost:8000/`](http://localhost:8000/)

## Official Documentation
Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing
Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

##Testing

Para ejecutar las pruebas, ejecutar dentro del proyecto el comando **php vendor/bin/phpunit**
