<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\None;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\AppBar;
use Sdui\Core\Widget\CheckBox;
use Sdui\Core\Widget\DropdownMenu;
use Sdui\Core\Widget\DropdownMenuEntry;
use Sdui\Core\Widget\FilledButton;
use Sdui\Core\Widget\Form;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\Scaffold;
use Sdui\Core\Widget\Text;
use Sdui\Core\Widget\TextFormField;

final class FormJsonTest extends TestCase
{
    use EncodesJson;

    public function test_form_empty_make_and_with_child(): void
    {
        $this->assertSame(['type' => 'form'], $this->encode(Form::make()));

        $this->assertSame(
            [
                'type' => 'form',
                'child' => ['type' => 'text', 'data' => 'Inside'],
                'autovalidateMode' => 'always',
            ],
            $this->encode(
                Form::make(Text::make('Inside'))->autovalidateMode('always'),
            ),
        );
    }

    public function test_text_form_field_minimum_and_full(): void
    {
        $this->assertSame(
            ['type' => 'textFormField', 'id' => 'password'],
            $this->encode(TextFormField::make('password')),
        );

        $this->assertSame(
            [
                'type' => 'textFormField',
                'id' => 'password',
                'decoration' => ['labelText' => 'Password'],
                'validatorRules' => [['rule' => 'isLength', 'options' => ['min' => 8]]],
                'keyboardType' => 'visiblePassword',
                'obscureText' => true,
                'initialValue' => 'secret',
                'autovalidateMode' => 'onUserInteraction',
                'hintText' => '••••',
                'maxLines' => 1,
                'enabled' => false,
            ],
            $this->encode(
                TextFormField::make('password')
                    ->decoration(['labelText' => 'Password'])
                    ->validatorRules([['rule' => 'isLength', 'options' => ['min' => 8]]])
                    ->keyboardType('visiblePassword')
                    ->obscureText()
                    ->initialValue('secret')
                    ->autovalidateMode('onUserInteraction')
                    ->hintText('••••')
                    ->maxLines(1)
                    ->enabled(false),
            ),
        );
    }

    public function test_text_form_field_obscure_text_false(): void
    {
        $json = $this->encode(TextFormField::make('name')->obscureText(false));

        $this->assertFalse($json['obscureText']);
    }

    public function test_checkbox_without_id_and_full_fields(): void
    {
        $this->assertSame(['type' => 'checkBox'], $this->encode(CheckBox::make()));

        $this->assertSame(
            [
                'type' => 'checkBox',
                'id' => 'terms',
                'value' => true,
                'tristate' => true,
                'onChanged' => ['actionType' => 'none'],
                'activeColor' => '#0a0',
            ],
            $this->encode(
                CheckBox::make('terms')
                    ->value(true)
                    ->tristate()
                    ->onChanged(None::make())
                    ->activeColor('#0a0'),
            ),
        );
    }

    public function test_checkbox_tristate_false(): void
    {
        $json = $this->encode(CheckBox::make()->tristate(false));

        $this->assertFalse($json['tristate']);
    }

    public function test_dropdown_menu_full_and_entry_icons(): void
    {
        $this->assertSame(['type' => 'dropdownMenu'], $this->encode(DropdownMenu::make()));

        $json = $this->encode(
            DropdownMenu::make('country')
                ->dropdownMenuEntries([
                    DropdownMenuEntry::make('es', 'Spain')
                        ->enabled(true)
                        ->leadingIcon(Icon::make('flag'))
                        ->trailingIcon(Icon::make('check')),
                    DropdownMenuEntry::make('fr', 'France')->enabled(false),
                ])
                ->initialSelection('es')
                ->label(Text::make('Country'))
                ->hintText('Pick one')
                ->width(200)
                ->enabled(true),
        );

        $this->assertSame(
            [
                'type' => 'dropdownMenu',
                'id' => 'country',
                'dropdownMenuEntries' => [
                    [
                        'value' => 'es',
                        'label' => 'Spain',
                        'enabled' => true,
                        'leadingIcon' => ['type' => 'icon', 'icon' => 'flag'],
                        'trailingIcon' => ['type' => 'icon', 'icon' => 'check'],
                    ],
                    [
                        'value' => 'fr',
                        'label' => 'France',
                        'enabled' => false,
                    ],
                ],
                'initialSelection' => 'es',
                'label' => ['type' => 'text', 'data' => 'Country'],
                'hintText' => 'Pick one',
                'width' => 200,
                'enabled' => true,
            ],
            $json,
        );
    }

    public function test_scaffold_and_app_bar_optional_slots(): void
    {
        $this->assertSame(['type' => 'scaffold'], $this->encode(Scaffold::make()));
        $this->assertSame(['type' => 'appBar'], $this->encode(AppBar::make()));

        $this->assertSame(
            [
                'type' => 'scaffold',
                'appBar' => [
                    'type' => 'appBar',
                    'title' => ['type' => 'text', 'data' => 'Home'],
                    'leading' => ['type' => 'text', 'data' => 'Back'],
                    'actions' => [
                        ['type' => 'text', 'data' => 'Help'],
                    ],
                    'backgroundColor' => '#111',
                    'centerTitle' => true,
                ],
                'body' => ['type' => 'text', 'data' => 'Body'],
                'backgroundColor' => '#eee',
                'floatingActionButton' => ['type' => 'filledButton', 'child' => ['type' => 'text', 'data' => '+']],
                'drawer' => ['type' => 'text', 'data' => 'Drawer'],
                'bottomNavigationBar' => ['type' => 'text', 'data' => 'Tabs'],
            ],
            $this->encode(
                Scaffold::make()
                    ->appBar(
                        AppBar::make()
                            ->title(Text::make('Home'))
                            ->leading(Text::make('Back'))
                            ->actions([Text::make('Help')])
                            ->backgroundColor('#111')
                            ->centerTitle(),
                    )
                    ->body(Text::make('Body'))
                    ->backgroundColor('#eee')
                    ->floatingActionButton(FilledButton::make(Text::make('+')))
                    ->drawer(Text::make('Drawer'))
                    ->bottomNavigationBar(Text::make('Tabs')),
            ),
        );
    }

    public function test_app_bar_center_title_false(): void
    {
        $json = $this->encode(AppBar::make()->centerTitle(false));

        $this->assertFalse($json['centerTitle']);
    }
}
