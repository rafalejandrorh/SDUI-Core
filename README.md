# stac-php

PHP builders whose `json_encode` output matches [Stac JSON](https://docs.stac.dev). Framework-agnostic (`php ^8.2`).

```php
use Stac\Widget\Scaffold;
use Stac\Widget\Text;

echo json_encode(Scaffold::make()->body(Text::make('Hello')));
```

Widgets: `scaffold`, `appBar`, `column`, `row`, `padding`, `sizedBox`, `center`, `expanded`, `container`, `listView`, `text`, `image`, `icon`, `divider`, `elevatedButton`, `filledButton`, `textButton`, `iconButton`, `form`, `textFormField`, `checkBox`, `dropdownMenu`.

Actions: `navigate`, `showDialog`, `showSnackBar`, `networkRequest` (+ `results` for 200/422/500), `validateForm`, `getFormValue`, `multiAction`, `sduiNavigate`, `sduiLogout`.

Use `Stac\Raw` for anything not covered yet.

```bash
composer install
composer test
```
