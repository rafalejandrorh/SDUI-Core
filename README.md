# stac-php

PHP builders whose `json_encode` output matches [Stac JSON](https://docs.stac.dev). Framework-agnostic (`php ^8.2`).

```php
use Sdui\Core\Widget\Scaffold;
use Sdui\Core\Widget\Text;

echo json_encode(Scaffold::make()->body(Text::make('Hello')));
```

Widgets: `scaffold`, `appBar`, `column`, `row`, `padding`, `sizedBox`, `center`, `expanded`, `container`, `listView`, `text`, `image`, `icon`, `divider`, `elevatedButton`, `filledButton`, `textButton`, `iconButton`, `form`, `textFormField`, `checkBox`, `dropdownMenu`.

Actions: `navigate`, `showDialog`, `showSnackBar`, `networkRequest` (+ `results` for 200/422/500), `validateForm`, `getFormValue`, `multiAction`, `sduiNavigate`, `sduiLogout`.

Use `Sdui\Core\Raw` for anything not covered yet.

Framework adapters (not in this package): Laravel mapper in the host app; Symfony Forms in [`sdui/symfony`](../SDUI-Symfony).

```bash
composer install
composer test
composer test:coverage
```
