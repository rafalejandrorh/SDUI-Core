# Tests

La suite es PHPUnit 11 (`phpunit/phpunit: ^11.0`), sin Pest. Un único testsuite `"SDUI Core"` que barre `tests/`. `<source>` incluye `src/` para cobertura. No hay grupos, ni process isolation, ni CI configurado en el repo.

## Cómo ejecutar

Desde la raíz del paquete, tras `composer install`:

```bash
composer test
# equivalente
vendor/bin/phpunit

composer test:coverage
# phpunit --coverage-text --coverage-html=coverage
```

Filtros útiles:

```bash
vendor/bin/phpunit --filter ActionJsonTest
vendor/bin/phpunit --filter test_image_network_omits_nulls
vendor/bin/phpunit --list-tests
```

## Organización

```
tests/
├── BuilderJsonTest.php          # árboles compuestos (network, multi, form widgets)
├── ScreenSnapshotTest.php       # pantallas home / details / form vs fixtures
├── ElementTest.php              # extra(), listOf(), Raw vs omisión de nulls
├── Support/
│   └── EncodesJson.php          # trait: json_encode → array
├── Action/
│   └── ActionJsonTest.php
├── Widget/
│   ├── ButtonJsonTest.php
│   ├── ContentJsonTest.php
│   ├── FormJsonTest.php
│   └── LayoutJsonTest.php
└── fixtures/
    ├── home.json
    ├── details.json
    └── form.json
```

Todo es unitario: no hay HTTP, base de datos ni mocks. Se serializa el builder como lo vería el cliente (`json_encode` + `json_decode` a array) y se compara con `assertSame`.

El trait `EncodesJson` centraliza esa conversión con `JSON_THROW_ON_ERROR`.

## Qué valida cada archivo

### `ElementTest`

Contrato de `Element` y `Raw`:

- `jsonSerialize()` omite atributos `null` (también los metidos con `extra()`).
- `extra()` fusiona y pisa claves.
- `listOf()`: varargs, unwrap de una sola lista, no unwrap de un asociativo, un solo hijo no-array.
- `Raw` conserva `null` y se emite literal dentro de `Multi`.

### `BuilderJsonTest`

Árboles de integración corta:

- `NetworkRequest` POST con `GetFormValue` en el body y `NetworkResult` para 200 / 422 / 500.
- `Multi` + `Raw` (`sync`, recuento de acciones).
- `CheckBox` y `DropdownMenu` / `DropdownMenuEntry`.
- `Image::network()` omite `width` si no se setea.

### `Action/ActionJsonTest`

Cada acción de `src/Action/`: `SduiNavigate` (omite `push`, emite otros estilos), `Navigate` mínimo/completo y `pop()`, `Multi` vacío vs lista + `sync(false)`, `ShowDialog`, `ShowSnackBar`, ramas de `ValidateForm`, `NetworkRequest` con query/headers, `None` / `GetFormValue` / `SduiLogout`.

### `Widget/ButtonJsonTest`

`ElevatedButton`, `FilledButton`, `TextButton` (setters de `Button`) e `IconButton` (vacío y completo).

### `Widget/ContentJsonTest`

`Padding` (escalar vs `all()`), combinaciones de `SizedBox`, `Image::asset()` y `Image::make()`, `Icon`, `Text`, `Column` (alineación/spacing), `Center`.

### `Widget/FormJsonTest`

`Form`, `TextFormField` (mínimo, completo, `obscureText(false)`), `CheckBox`, `DropdownMenu` con iconos en entries, `Scaffold` / `AppBar` (slots opcionales y `centerTitle(false)`).

### `Widget/LayoutJsonTest`

`Container` (mínimo, completo, padding array), `Divider`, `Expanded`, `ListView` (sin children, unwrap, varargs, `shrinkWrap(false)`), `Row`.

### `ScreenSnapshotTest`

Un test parametrizado (`#[DataProvider('screens')]`) que construye tres `Scaffold` inline y los compara, tras `normalize()` (ksort recursivo de objetos, listas intactas), con:

| Dataset | Fixture | Contenido |
|---------|---------|-----------|
| `home` | `tests/fixtures/home.json` | Home, navegación `SduiNavigate`, logout |
| `details` | `tests/fixtures/details.json` | Detalle con `Navigate::pop()` |
| `form` | `tests/fixtures/form.json` | Formulario de perfil; submit → `ValidateForm` + `ShowDialog` |

Esas fábricas son documentación viva del JSON de fase 1. El `FormScreen` de Laravel ha evolucionado a un `networkRequest` real; el fixture de Core sigue siendo el contrato del snapshot, no un espejo del host.

## Cobertura

Prácticamente todos los widgets y acciones de `src/` tienen un test de forma JSON (mínimo y, en la mayoría, payload completo). Los huecos, si los hay, son combinaciones de setters poco usadas, no clases enteras sin ejercicio.

`composer.json` define `test:coverage` (`--coverage-text --coverage-html=coverage`). El directorio `coverage/` está en `.gitignore`.

## Cómo actualizar un fixture

Cuando el contrato JSON de una pantalla de referencia cambia **a propósito**:

1. Ajustar el builder en `ScreenSnapshotTest` (`home()`, `details()` o `form()`).
2. Regenerar el golden file a mano (o copiar el JSON emitido) en `tests/fixtures/<nombre>.json`.
3. Correr `composer test` y confirmar que solo cambia ese snapshot.

No “arreglar” un fallo de snapshot reescribiendo el fixture si el builder no debía cambiar: el test está para detectar regresiones de forma.

## CI

No hay workflows en este repositorio. La red de seguridad es `composer test` en local y en los hosts que dependen de Core.
