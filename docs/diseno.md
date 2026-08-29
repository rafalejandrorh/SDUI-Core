# Diseño

Las convenciones de este paquete están en el código, no en un contenedor ni en interfaces extra. El contrato público es: `make()` + setters fluentes → `JsonSerializable` → JSON Stac.

## Patrones

| Patrón | Dónde |
|--------|--------|
| **Builder fluente** | Casi todas las clases: `::make()` y setters que devuelven `static` / `self` |
| **Fábrica estática** | `Image::network()`, `Image::asset()`, `Navigate::pop()`, `Padding::all()` |
| **Template Method** | `Element::jsonSerialize()`; las subclases solo definen `typeKey()` y `typeValue()` |
| **Composite** | Árbol de widgets/acciones anidados en `child`, `children` y payloads de acción |
| **Null Object** | `None` (`actionType: none`) |
| **Escape hatch** | `Raw` (objeto completo) y `extra()` (atributos sueltos) |
| **DTO** | `NetworkResult`, `DropdownMenuEntry` (sin discriminator) |

No hay inyección de dependencias, eventos, middleware, traits de Laravel ni interfaces más allá de `JsonSerializable`.

## Convenciones

- `declare(strict_types=1)` en todo `src/` y `tests/`.
- PSR-4: `Sdui\Core\` → `src/`.
- Valores de `type` / `actionType` en camelCase alineados con Stac: `appBar`, `textFormField`, `multiAction`, `sduiNavigate`.
- Hijos y acciones como `mixed` para permitir builders, arrays o `Raw`.
- Setters booleanos con default `true` cuando el flag es opt-in (`shrinkWrap()`, `obscureText()`, `centerTitle()`, `sync()`). El caller puede pasar `false`.
- `listOf()` desempaqueta un único array-lista pasado a `children(...)` / `actions(...)`, pero no un array asociativo (evita tragar un widget crudo `{type: text, ...}` como lista de hijos).
- Atributos `null` no se serializan en `Element`. `Raw` sí conserva `null`.

## Escape hatches

`extra()` añade o pisa claves en la bolsa de atributos sin un setter dedicado:

```php
Text::make('Hello')->extra(['semanticsLabel' => 'Greeting']);
```

`Raw` inyecta JSON que Core aún no modela:

```php
Raw::make(['actionType' => 'none']);
```

Usar `Raw` cuando el *objeto* no existe como clase; usar `extra()` cuando la clase existe pero falta un atributo.

## Acciones de aplicación vs Stac

`Navigate` es la acción stock de Stac (`navigationStyle`, `routeName`, `widgetJson`, …). `SduiNavigate` y `SduiLogout` son específicas de esta app: el cliente Flutter las interpreta fuera del set genérico de Stac.

`SduiNavigate::make($screen)` omite `style` cuando vale `push`, para no ensuciar el JSON con el default.

## Qué queda fuera a propósito

- Service providers, facades, config files.
- Una interfaz `Screen` o un router.
- Validación de que el JSON sea Stac-legal en runtime (eso lo cubren los tests y el cliente).
- Mapeo Laravel/Symfony → `validatorRules` (host / `sdui/symfony`).

## Cómo añadir un widget

1. Crear `src/Widget/MiWidget.php` que extienda `Widget` (o `Button` si comparte `child` / `onPressed`).
2. Implementar `typeValue()` con el `type` Stac exacto (camelCase).
3. `make()` inicializa los campos obligatorios vía `put()`. Los opcionales van en setters que devuelven `self`.
4. Hijos múltiples: `children(mixed ...$children)` + `self::listOf($children)`.
5. Test de JSON en `tests/Widget/` con el trait `EncodesJson`: payload mínimo (sin claves opcionales) y payload completo.
6. Si forma parte de una pantalla de referencia, actualizar el snapshot en `tests/fixtures/` (ver [tests](tests.md)).

## Cómo añadir una acción

Igual, bajo `src/Action/`, extendiendo `Action` y devolviendo `actionType` en `typeValue()`. Si el objeto no es widget ni acción (p. ej. un mapa status → follow-up), un DTO `JsonSerializable` como `NetworkResult` es más honesto que forzar un `type`.

Inventario completo en [arquitectura](arquitectura.md). Ejemplos de composición en [uso](uso.md).
