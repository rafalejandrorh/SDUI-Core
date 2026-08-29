# SDUI-Core

Builders fluentes en PHP (`sdui/core`, PHP `^8.2`, MIT) que emiten JSON [Stac](https://docs.stac.dev) / SDUI a través de `JsonSerializable`. Sin dependencias de runtime y sin acoplamiento a Laravel ni Symfony.

```php
use Sdui\Core\Widget\Scaffold;
use Sdui\Core\Widget\Text;

echo json_encode(Scaffold::make()->body(Text::make('Hello')));
// {"type":"scaffold","body":{"type":"text","data":"Hello"}}
```

Los adaptadores de framework no viven aquí: el mapeo Laravel está en la aplicación host; el de formularios Symfony está en [`sdui/symfony`](../SDUI-Symfony).

## Documentación

| Documento | Contenido |
|-----------|-----------|
| [Objetivos](docs/objetivos.md) | Problema, metas, no-objetivos y ecosistema |
| [Arquitectura](docs/arquitectura.md) | Jerarquía, serialización e inventario de widgets y acciones |
| [Diseño](docs/diseno.md) | Patrones, convenciones y cómo extender el paquete |
| [Tests](docs/tests.md) | Suite PHPUnit, cómo ejecutarla y cobertura |
| [Instalación](docs/instalacion.md) | Requisitos y consumo vía Composer (VCS o path) |
| [Uso](docs/uso.md) | Guía práctica: pantallas, layout, formularios y `Raw` |
