
## Instrucciones de Instalación

Sigue los siguientes pasos para configurar el proyecto en tu entorno local:



1. **Instala las dependencias de PHP y Node.js:**

   .Composer: Para instalar las dependencias de PHP, ejecuta:

        composer install

   .NPM: Para instalar las dependencias de Node.js, ejecuta:

        npm install
        npm run dev

2. **Configura el archivo de entorno .env:**

   .Copia el archivo .env.example a .env:

       cp .env.example .env

   .Genera la clave de la aplicación:

       php artisan key:generate

   .Configura la base de datos en el archivo .env. Asegúrate de tener una base de datos MySQL disponible y configurada.

3. **Ejecuta las migraciones y seeders para crear las tablas necesarias:**

       php artisan migrate:fresh --seed
4. **Para crear la Nota con el comando ejecutar el comando con las opciones:**

       'app:notes --title= --description= --creation_date= --expiration_date=? --user= --tag=';

