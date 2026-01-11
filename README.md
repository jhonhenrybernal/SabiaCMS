# SabiaCMS

SabiaCMS es un CMS moderno construido con **Laravel 12 + Inertia.js +
Vue 3 + TailwindCSS**, enfocado en rendimiento, SEO y escalabilidad.

------------------------------------------------------------------------

## Características principales

-   CRUD de mensajes multi-idioma (ES, EN, FR, IT)
-   Panel administrativo completo (Inertia + Vue)
-   Sitemap dinámico con caché
-   Robots.txt administrable desde el panel
-   Integración con Laravel Telescope (solo admins)
-   Autenticación con Laravel Fortify
-   Arquitectura lista para SEO (Meta, OpenGraph, Schema.org)
-   Stack moderno frontend/backend desacoplado

------------------------------------------------------------------------

## Requisitos

-   PHP \>= 8.2
-   Composer
-   Node.js \>= 18
-   SQLite / MySQL / PostgreSQL

------------------------------------------------------------------------

## Instalación

``` bash
git clone https://github.com/tuusuario/sabiacms.git
cd sabiacms
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

------------------------------------------------------------------------

## Crear usuario administrador

Ejecuta el seeder:

``` bash
php artisan db:seed --class=AdminUserSeeder
```

O crea manualmente y marca:

``` sql
is_admin = 1
```

------------------------------------------------------------------------

## Accesos importantes

  URL               Descripción
  ----------------- ------------------------------
  /admin            Panel administrativo
  /admin/messages   Gestión de mensajes
  /admin/robots     Editor de robots.txt
  /admin/sitemap    Panel de sitemap
  /telescope        Debug avanzado (solo admins)
  /robots.txt       Público
  /sitemap.xml      Público

------------------------------------------------------------------------

## Arquitectura SEO

-   Sitemap dinámico con caché (6h)
-   Robots.txt editable
-   Meta tags configurables
-   Preparado para Google Search Console

------------------------------------------------------------------------

## Desarrollo

``` bash
npm run dev
php artisan serve
```

Para producción:

``` bash
npm run build
```

------------------------------------------------------------------------

## Seguridad

-   Acceso admin protegido por middleware
-   Telescope restringido
-   Archivos sensibles en .gitignore

------------------------------------------------------------------------

## Roadmap

-   Páginas públicas multi-idioma
-   Editor visual tipo blocks
-   Plugins/modulos
-   Temas
-   API pública
-   Indexación automática por contenido

------------------------------------------------------------------------

## Licencia

MIT License

------------------------------------------------------------------------

## Autor

SabiaCMS -- CMS moderno orientado a SEO y rendimiento.
