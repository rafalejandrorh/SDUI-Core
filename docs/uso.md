# Uso

Ciclo de trabajo: componer un árbol de widgets y acciones → `json_encode($widget)` → JSON Stac que el cliente Flutter renderiza. Core no conoce rutas, cache ni HTTP; el host se encarga de servir el payload.

La forma del JSON está en [arquitectura](arquitectura.md). Cómo añadir un builder nuevo, en [diseño](diseno.md).

## Pantalla mínima

La raíz habitual es un `Scaffold` con `AppBar` y `body`:

```php
use Sdui\Core\Widget\AppBar;
use Sdui\Core\Widget\Scaffold;
use Sdui\Core\Widget\Text;

$screen = Scaffold::make()
    ->appBar(AppBar::make()->title(Text::make('Home')))
    ->body(Text::make('Hello'));

echo json_encode($screen);
```

```json
{
  "type": "scaffold",
  "appBar": { "type": "appBar", "title": { "type": "text", "data": "Home" } },
  "body": { "type": "text", "data": "Hello" }
}
```

## Layout

`Column`, `Row`, `ListView` aceptan hijos por varargs o por lista. `Element::listOf()` desempaqueta un único array-lista para no anidar `[[...]]`.

```php
use Sdui\Core\Widget\Column;
use Sdui\Core\Widget\Padding;
use Sdui\Core\Widget\SizedBox;
use Sdui\Core\Widget\Text;

Padding::make(24)->child(
    Column::make()
        ->crossAxisAlignment('stretch')
        ->children(
            Text::make('Welcome')->style(['fontSize' => 24]),
            SizedBox::make(height: 12),
            Text::make('These screens come from JSON.'),
        ),
);
```

Equivalente con lista:

```php
Column::make()->children([
    Text::make('A'),
    Text::make('B'),
]);
```

Otras piezas de layout: `Center`, `Expanded`, `Container`, `Row`, `ListView`, `Padding::all(8)` (emite `{left, top, right, bottom}`).

## Interacción

Los botones (`FilledButton`, `ElevatedButton`, `TextButton`, `IconButton`) reciben el hijo y la acción `onPressed` en `make()`, o por setters.

```php
use Sdui\Core\Action\Navigate;
use Sdui\Core\Action\SduiLogout;
use Sdui\Core\Action\SduiNavigate;
use Sdui\Core\Widget\FilledButton;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\IconButton;
use Sdui\Core\Widget\Text;
use Sdui\Core\Widget\TextButton;

FilledButton::make(Text::make('View details'), SduiNavigate::make('details'));
TextButton::make(Text::make('Sign out'), SduiLogout::make());
IconButton::make(Icon::make('arrow_back'), Navigate::pop());
```

- `SduiNavigate::make('details')` emite `{ actionType: sduiNavigate, screen: details }`. El estilo por defecto `push` se omite; otros estilos (`replace`, `pop`) sí salen en JSON.
- `Navigate::pop()` es la acción Stac stock `{ actionType: navigate, navigationStyle: pop }`.

## Formularios

Campos con `id` (lo usa `GetFormValue`), reglas Stac en `validatorRules`, y envío detrás de `ValidateForm`.

```php
use Sdui\Core\Action\GetFormValue;
use Sdui\Core\Action\NetworkRequest;
use Sdui\Core\Action\NetworkResult;
use Sdui\Core\Action\ShowDialog;
use Sdui\Core\Action\ShowSnackBar;
use Sdui\Core\Action\ValidateForm;
use Sdui\Core\Widget\FilledButton;
use Sdui\Core\Widget\Form;
use Sdui\Core\Widget\Text;
use Sdui\Core\Widget\TextFormField;

$submit = NetworkRequest::make('/sdui/actions/profile')
    ->method('post')
    ->contentType('application/json')
    ->body([
        'name' => GetFormValue::make('name'),
        'email' => GetFormValue::make('email'),
    ])
    ->results([
        NetworkResult::make(200, ShowSnackBar::make(Text::make('Saved.'))),
        NetworkResult::make(422, ShowSnackBar::make(Text::make('Check the fields.'))),
        NetworkResult::make(500, ShowDialog::make(Text::make('Something went wrong.'))),
    ]);

Form::make()
    ->autovalidateMode('onUserInteraction')
    ->child(
        FilledButton::make(
            Text::make('Submit'),
            ValidateForm::make(
                $submit,
                ShowDialog::make(Text::make('Check the highlighted fields.')),
            ),
        ),
    );
```

`validatorRules` es un array de reglas Stac, no de Laravel:

```php
TextFormField::make('email')
    ->keyboardType('emailAddress')
    ->decoration(['labelText' => 'Email'])
    ->validatorRules([
        ['rule' => 'isEmail'],
    ]);
```

El host Laravel (p. ej. `UpdateProfileRequest::stacRules()`) traduce reglas del framework a esta forma. Esa traducción no está en Core.

## Varias acciones

`Multi` (`actionType: multiAction`) encadena acciones. `sync()` es opcional.

```php
use Sdui\Core\Action\Multi;
use Sdui\Core\Action\ShowSnackBar;
use Sdui\Core\Raw;
use Sdui\Core\Widget\Text;

Multi::make(
    ShowSnackBar::make(Text::make('Working...')),
    Raw::make(['actionType' => 'none']),
)->sync();
```

`make()` vacío no emite `actions` ni `sync` (los `null` se omiten).

## Extender sin nueva clase

Atributos que el builder aún no expone:

```php
Text::make('Hello')->extra(['textAlign' => 'center', 'semanticsLabel' => 'Greeting']);
```

JSON Stac sin builder tipado:

```php
use Sdui\Core\Raw;

Raw::make([
    'type' => 'customWidget',
    'payload' => ['foo' => 1],
]);
```

`Raw` no omite `null`: el payload se emite tal cual. `Element::jsonSerialize()` sí omite atributos `null`.

## En el host Laravel

Las pantallas viven en la app, no en Core. Una clase devuelve un `Scaffold`; el catálogo lo convierte en array y el controller lo sirve.

```php
// App\Sdui\Screens\DetailsScreen::build(): Scaffold

final class ScreenCatalog
{
    public function build(string $name): array
    {
        $widget = $this->widget($name);

        return json_decode(json_encode($widget, JSON_THROW_ON_ERROR), true, flags: JSON_THROW_ON_ERROR);
    }
}
```

Core no sabe de nombres de pantalla, cache ni locale. Eso es responsabilidad del host.
