# Pantalla Extremeña

Aplicación web desarrollada con Laravel para consultar películas y series rodadas en Extremadura a través de sus localizaciones reales de rodaje. La aplicación permite explorar un mapa interactivo, consultar detalles de localizaciones, registrarse, iniciar sesión, guardar favoritos, publicar comentarios y acceder a un panel de administración.

## 1. Requisitos previos

Para ejecutar el proyecto en local, tal y como se ha desarrollado en Visual Studio Code, es necesario tener instalado:

- Windows
- XAMPP, usando el servicio MySQL/MariaDB
- PHP 8.2.12
- Composer
- Node.js
- npm
- Git
- Visual Studio Code
- MySQL Workbench

El proyecto se ha desarrollado usando Laravel 12 y una base de datos MySQL/MariaDB gestionada desde MySQL Workbench.

## 2. Clonar el repositorio

Abrir una terminal en la carpeta donde se quiera descargar el proyecto y ejecutar:

```bash
git clone https://github.com/NachoBanosMartin/Proyecto.git
```

Entrar en la carpeta del proyecto:

```bash
cd Proyecto
```

Si la carpeta del repositorio tiene otro nombre, entrar en la carpeta correspondiente.

## 3. Instalar dependencias de Laravel

Ejecutar:

```bash
composer install
```

Después instalar las dependencias de Node:

```bash
npm install
```

## 4. Crear el archivo .env

El archivo `.env` no se incluye en GitHub por seguridad. Para crearlo, copiar el archivo de ejemplo:

```bash
copy .env.example .env
```

En PowerShell también se puede usar:

```powershell
Copy-Item .env.example .env
```

Después abrir el archivo `.env` y configurar los datos principales:

```env
APP_NAME="PantallaExtremena"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pantalla_extremena_db
DB_USERNAME=root
DB_PASSWORD=

CACHE_STORE=file
SESSION_DRIVER=file
```

Es importante que `CACHE_STORE` y `SESSION_DRIVER` estén configurados como `file`, ya que la base de datos del proyecto no incluye las tablas propias de Laravel para guardar caché o sesiones.


## 5. Generar la clave de Laravel

Ejecutar:

```bash
php artisan key:generate
```

Este comando rellenará automáticamente la variable `APP_KEY` del archivo `.env`.

## 6. Crear la base de datos

Abrir XAMPP y activar el servicio MySQL.

Después abrir MySQL Workbench y ejecutar el script SQL del proyecto. La base de datos debe llamarse:

```sql
pantalla_extremena_db
```

El script debe crear las siguientes tablas:

- usuarios
- producciones
- localizaciones
- produccion_localizacion
- favoritos
- comentarios

La tabla `producciones` no tiene campo de imagen. Las imágenes se gestionan desde la tabla `localizaciones`, mediante el campo `imagen_url`, que almacena URLs públicas de imágenes alojadas en Amazon S3.

Las contraseñas de los usuarios de prueba están guardadas con SHA-256. Las credenciales incluidas en el script son:

```text
Administrador:
Email: ibannosm01@educarex.es
Contraseña: 123456

Usuario registrado:
Email: delafuentepineroa@gmail.com
Contraseña: 123456
```

## 7. Comprobar la conexión con la base de datos

Una vez configurado el `.env` y creada la base de datos, se puede comprobar la conexión arrancando el servidor de Laravel:

```bash
php artisan serve
```

Abrir en el navegador:

```text
http://127.0.0.1:8000
```

Si aparece un error de conexión, revisar:

- Que MySQL esté activo en XAMPP.
- Que el nombre de la base de datos sea `pantalla_extremena_db`.
- Que `DB_USERNAME=root`.
- Que `DB_PASSWORD=` esté vacío si se usa la configuración por defecto de XAMPP.

## 8. Compilar recursos del frontend

Para trabajar en local, ejecutar:

```bash
npm run dev
```

Si solo se quiere compilar la versión final de los recursos:

```bash
npm run build
```

Además, el proyecto utiliza estilos personalizados en:

```text
public/css/estilos.css
```

Y las imágenes propias del diseño visual están en:

```text
public/img/
```

Ejemplos de imágenes internas del proyecto:

logo
clapper
fondo verde
cinta de celuloide del footer

Las imágenes de las localizaciones no están dentro del proyecto Laravel, sino que se cargan mediante URLs externas guardadas en la base de datos.


## 9. Funcionalidades principales para probar

### Usuario no registrado

Puede:

Acceder a la página principal.
Elegir entre películas o series.
Usar el buscador por título.
Ver el mapa interactivo con marcadores.
Consultar el detalle de una localización.
Leer comentarios.

### Usuario registrado

Además de lo anterior, puede:

Iniciar sesión.
Acceder a su perfil.
Editar sus datos.
Cambiar su contraseña.
Eliminar su cuenta.
Añadir o quitar localizaciones favoritas.
Ver su listado de favoritos.
Publicar comentarios.

### Administrador

Además de las funciones del usuario registrado, puede acceder al panel de administración y gestionar:

Producciones.
Localizaciones.
Relaciones entre producciones y localizaciones.
Comentarios.
Usuarios.
Estadísticas.

## 10. Rutas principales

Algunas rutas principales de la aplicación son:

```text
/                              Página de inicio
/login                         Formulario de inicio de sesión
/registro                      Formulario de registro
/producciones/pelicula         Mapa y listado de películas
/producciones/serie            Mapa y listado de series
/localizacion/{idProduccion}/{idLocalizacion}    Detalle de una localización
/favoritos                     Favoritos del usuario autenticado
/perfil                        Perfil del usuario
/admin                         Panel de administración
/admin/producciones            Gestión de producciones
/admin/localizaciones          Gestión de localizaciones
/admin/relaciones              Gestión de relaciones
/admin/comentarios             Gestión de comentarios
/admin/usuarios                Gestión de usuarios
/admin/estadisticas            Estadísticas generales
```

Para consultar todas las rutas disponibles:

```bash
php artisan route:list
```

## 11. Limpieza de cachés

Si se realizan cambios en rutas, vistas o configuración, ejecutar:

```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

Después recargar el navegador con:

```text
Ctrl + F5
```

## 12. Imágenes de Amazon S3

Las imágenes de las localizaciones se guardan como URLs públicas en el campo `imagen_url` de la tabla `localizaciones`.

Ejemplo:

```sql
SELECT idLocalizacion, nombre, imagen_url
FROM localizaciones;
```

Laravel muestra estas imágenes directamente en las vistas mediante la URL guardada en la base de datos.

Si una imagen no aparece, comprobar:

Que la URL se abre directamente en el navegador.
Que el objeto del bucket S3 tiene permiso público de lectura.
Que la URL guardada en MySQL Workbench es correcta.
Que se ha modificado la base de datos que realmente usa Laravel.

Si al abrir la imagen aparece `AccessDenied`, el problema está en los permisos del bucket S3, no en Laravel.

## 13. Despliegue en Railway

La aplicación también se ha desplegado en Railway.

URL de producción:

```text
https://web-production-6a624b.up.railway.app/
```

En Railway, el archivo `.env` no se sube al repositorio. Las variables de entorno deben configurarse desde el panel de Railway.

Variables importantes en producción:

```env
APP_NAME="PantallaExtremeña"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://web-production-6a624b.up.railway.app
ASSET_URL=https://web-production-6a624b.up.railway.app

DB_CONNECTION=mysql
DB_HOST=valor_proporcionado_por_Railway
DB_PORT=valor_proporcionado_por_Railway
DB_DATABASE=pantalla_extremena_db
DB_USERNAME=valor_proporcionado_por_Railway
DB_PASSWORD=valor_proporcionado_por_Railway

CACHE_STORE=file
SESSION_DRIVER=file
```

Para la base de datos en Railway, es importante que `DB_DATABASE` sea `pantalla_extremena_db`. Si Railway usa por defecto otro nombre, como `railway`, la aplicación buscará las tablas en una base de datos incorrecta.

## 14. Notas importantes

No se han usado migraciones propias de Laravel para crear la base de datos. La base de datos se crea mediante script SQL.
No se debe subir el archivo `.env` a GitHub.
Las sesiones y la caché se gestionan mediante archivos, no mediante base de datos.
Las imágenes de diseño están en `public/img`.
Las imágenes de localizaciones están en Amazon S3 y se referencian mediante URLs guardadas en la base de datos.
Las estadísticas se calculan en tiempo real a partir de los datos existentes. No se registran búsquedas ni visualizaciones individuales.
La autenticación es propia y utiliza SHA-256 para mantener coherencia con el script SQL trabajado en el proyecto.

## 15. Comandos útiles

Instalar dependencias PHP:

```bash
composer install
```

Instalar dependencias Node:

```bash
npm install
```

Generar clave de Laravel:

```bash
php artisan key:generate
```

Arrancar servidor local:

```bash
php artisan serve
```

Compilar recursos en desarrollo:

```bash
npm run dev
```

Compilar recursos para producción:

```bash
npm run build
```

Limpiar cachés:

```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

Ver rutas:

```bash
php artisan route:list
```

## 16. Autor

Proyecto desarrollado por Ignacio Baños Martín como proyecto final del Grado Superior de Desarrollo de Aplicaciones Web.
