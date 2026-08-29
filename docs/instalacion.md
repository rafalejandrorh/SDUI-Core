# Instalación

El paquete se llama `sdui/core`. No está publicado en Packagist: se consume como repositorio Composer (VCS o path).

## Requisitos

- PHP `^8.2`
- Composer 2
- Sin extensiones ni dependencias de runtime adicionales

Autoload PSR-4: `Sdui\Core\` → `src/`. No hay service provider, facades, ni `extra.laravel`. Instalar Core no publica config, no registra contenedores y no corre migraciones.

## Desarrollo del propio Core

```bash
git clone git@github.com:rafalejandrorh/SDUI-Core.git
cd SDUI-Core
composer install
composer test
```

Detalle de la suite en [tests](tests.md).

## Como dependencia (VCS)

Patrón usado por Api-SDUI-App: el host declara el repositorio Git y pide `@dev` porque Core aún no publica tags.

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/rafalejandrorh/SDUI-Core"
        }
    ],
    "require": {
        "sdui/core": "@dev"
    }
}
```

Luego:

```bash
composer update sdui/core
```

Los hosts con `"minimum-stability": "stable"` necesitan la constraint `@dev` (o un tag semver cuando exista). Sin eso Composer rechaza la rama `master`/`main`.

## Como dependencia (path + symlink)

Patrón usado por SDUI-Symfony cuando Core está en un directorio hermano. Ideal para desarrollo local: los cambios en `src/` se ven al instante.

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../SDUI-Core",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
        "sdui/core": "@dev"
    }
}
```

```bash
composer update sdui/core
```

## Verificación

Tras instalar, las clases deben resolverse por autoload:

```php
use Sdui\Core\Widget\Scaffold;
use Sdui\Core\Widget\Text;

json_encode(Scaffold::make()->body(Text::make('Hello')));
```

Guía de composición en [uso](uso.md).
