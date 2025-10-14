# Sistema Web de Gestión de Adopciones de Ratas Domésticas

## Descripción del Proyecto
Este sistema web tiene como objetivo **promover la adopción responsable de ratas domésticas** y **digitalizar la gestión de refugios**, facilitando los procesos de **registro de usuarios, administración de animales y control de solicitudes de adopción**.


## Instalación del Proyecto

Sigue estos pasos para configurar el proyecto en tu entorno local:

### 1. Clona el repositorio
```bash
git clone https://github.com/beidou2023/webrefuge
cd webrefuge
```
### 2. Instala las dependencias
```bash
composer install
```
### 3. Copia el archivo de entorno
```bash
cp .env.example .env
```

### 4. Genera la clave de la aplicación
```bash
php artisan key:generate
```

### 5. Configura la base de datos
Edita el archivo .env con los datos de tu base de datos:

```bash
env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contrasenia
```


### 6. Ejecuta las migraciones
```bash
php artisan migrate
```

### 7. Carga los datos iniciales (seeders)
```bash
php artisan db:seed
```

## Requisitos
PHP >= 8.1

Composer

MySQL

Laravel 10+

Servidor local XAMPP

## Roles del Sistema
Administrador

Manager

Usuario

## Tecnologías Utilizadas
Laravel

MySQL

Bootstrap

PHP / HTML / CSS / JavaScript

# Autor
Proyecto desarrollado como Trabajo de Grado para la modalidad de Proyecto de Titulación.

© 2025 — Todos los derechos reservados.