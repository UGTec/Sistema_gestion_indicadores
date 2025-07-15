# sigin

Sistema de Gestión de Indicadores, para Subsecretaria de Educación Parvularia.

## Requisitos

- PHP 8.4
- Composer
- Nodejs 24
- Servidor web (Apache o Nginx)
- Postgresql

## Instalación

Clonar el repositorio

``` bash
ssh clone ssh://git@git.eldelassombras.cl:50022/csanhueza/sigin.git
```

``` bash
cp .env.example .env
```

``` bash
APP_URL=URL o IP
DB_HOST=IP_BASE_POSTGRESQL
DB_PORT=PUERTO_POSTGRESQL
DB_DATABASE=NOMBRE_BASE_DE_DATOS
DB_USERNAME=USUARIO_BASE_DE_DATOS
DB_PASSWORD=CONTRASEÑA_BASE_DE_DATOS
```

``` bash
# Para producción
composer install --no-dev
# Para desarrollo
composer install
```

``` bash
# Para producción
npm install --production
# Para desarrollo
npm install
```

``` bash
npm run build
```

``` bash
php artisan key:generate
```

``` bash
php artisan migrate --seed
```

``` bash
php artisan storage:link
```

``` bash

```

