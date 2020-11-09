# Prueba LemSystems
Prueba de ingreso a LemSystems. Consiste en consumir la API de Deezer y mostrar la respuesta en VueJS usando Laravel 5.7 como backend

## Requisitos

 - PHP 7.3
 - Servidor Apache
 - Composer
 - Base de datos MySQL o PostgreSQL

### Desarrollo Javascript
Si quiere desarrollar y compilar los archivos Javascript necesita adempás de NodeJS y NPM instalado

### Docker
En el repositorio se incluye un Dockerfile y un docker-compose para crear y levantar los servicios requeridos para el ejercicio. Este incluye el contenedor de PHP + Composer, PostgreSQL, NPM y Adminer

## Instalacion
 1. Clone el repositorio usando git clone en la carpeta /var/www/html/ y luego entre al directorio recien creado
 2. Copie el archivo .env.example y renombrelo a .env
 3. Abra el archivo .env e ingrese las credenciales de la base de datos, no olvide especificar el motor de base de datos y luego guardelo
### Sin Docker
 4. Ejecute **composer install** para instalar las dependencias de PHP
 5. Ejecute **php artisan key:generate** para generar la llave de encriptación de Laravel
 6. Ejecute **php artisan migrate** para crear las migraciones, el sistema arrojará un error si hay problemas de conexión con la base de datos
 7. Entre a http://localhost

### Usando Docker
 4.  En el .env cambie las credenciales de conexion a la base de datos por las siguientes:
 
 DB_CONNECTION=pgsql
 DB_HOST=postgresql 
 DB_PORT=5432
 DB_DATABASE=app_prueba
 DB_USERNAME=lem_systems
 DB_PASSWORD=lem_systems
 
 6. Ejecute los contenedores con **docker-compose up -d --build**. Espere a que se descargue todo y los contenedores se hayan incializado
 7. Ejecute **docker-compose run --rm php composer install** para instalar las dependencias de PHP
 8. Ejecute **docker exec -it lem_systems_php bash** y luego **php artisan key:generate** para generar la llave de encriptación de Laravel. Para salir del contenedor escriba **exit** en la terminal
 9. Ejecute **docker exec -it lem_systems_php bash** y luego **php artisan migrate** para crear las migraciones. Para salir del contenedor escriba **exit** en la terminal
 10. Entre a http://localhost
 11. Para visualizar la base de datos entre a http://localhost:8080 y use las mismas credenciales indicadas en el .env
