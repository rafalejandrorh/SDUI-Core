<?php

declare(strict_types=1);

namespace Sdui\Core\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\Navigate;
use Sdui\Core\Action\SduiLogout;
use Sdui\Core\Action\SduiNavigate;
use Sdui\Core\Action\ShowDialog;
use Sdui\Core\Action\ValidateForm;
use Sdui\Core\Widget\AppBar;
use Sdui\Core\Widget\Column;
use Sdui\Core\Widget\FilledButton;
use Sdui\Core\Widget\Form;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\IconButton;
use Sdui\Core\Widget\Padding;
use Sdui\Core\Widget\Scaffold;
use Sdui\Core\Widget\SizedBox;
use Sdui\Core\Widget\Text;
use Sdui\Core\Widget\TextButton;
use Sdui\Core\Widget\TextFormField;

final class ScreenSnapshotTest extends TestCase
{
    #[DataProvider('screens')]
    public function test_builders_match_phase1_fixtures(string $name, \JsonSerializable $screen): void
    {
        $expected = json_decode(
            file_get_contents(__DIR__.'/fixtures/'.$name.'.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );
        $actual = json_decode(
            json_encode($screen, JSON_THROW_ON_ERROR),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        $this->assertSame($this->normalize($expected), $this->normalize($actual));
    }

    public static function screens(): array
    {
        return [
            'home' => ['home', self::home()],
            'details' => ['details', self::details()],
            'form' => ['form', self::form()],
        ];
    }

    private static function home(): Scaffold
    {
        return Scaffold::make()
            ->appBar(AppBar::make()->title(Text::make('Home')))
            ->body(
                Padding::make(24)->child(
                    Column::make()
                        ->crossAxisAlignment('stretch')
                        ->children(
                            Text::make('Welcome')->style(['fontSize' => 24]),
                            SizedBox::make(height: 12),
                            Text::make('These screens are bundled Stac JSON. Later they will come from the server.'),
                            SizedBox::make(height: 24),
                            FilledButton::make(Text::make('View details'), SduiNavigate::make('details')),
                            SizedBox::make(height: 12),
                            FilledButton::make(Text::make('Profile form'), SduiNavigate::make('form')),
                            SizedBox::make(height: 24),
                            TextButton::make(Text::make('Sign out'), SduiLogout::make()),
                        ),
                ),
            );
    }

    private static function details(): Scaffold
    {
        $back = Navigate::pop();

        return Scaffold::make()
            ->appBar(
                AppBar::make()
                    ->title(Text::make('Details'))
                    ->leading(IconButton::make(Icon::make('arrow_back'), $back)),
            )
            ->body(
                \Sdui\Core\Widget\Center::make(
                    Column::make()
                        ->mainAxisSize('min')
                        ->children(
                            Text::make('This screen was opened from JSON.'),
                            SizedBox::make(height: 24),
                            FilledButton::make(Text::make('Back'), $back),
                        ),
                ),
            );
    }

    private static function form(): Scaffold
    {
        $back = Navigate::pop();

        return Scaffold::make()
            ->appBar(
                AppBar::make()
                    ->title(Text::make('Profile'))
                    ->leading(IconButton::make(Icon::make('arrow_back'), $back)),
            )
            ->body(
                Padding::make(24)->child(
                    Form::make()
                        ->autovalidateMode('onUserInteraction')
                        ->child(
                            Column::make()
                                ->crossAxisAlignment('stretch')
                                ->children(
                                    TextFormField::make('name')
                                        ->decoration(['labelText' => 'Name'])
                                        ->validatorRules([
                                            [
                                                'rule' => 'isLength',
                                                'options' => ['min' => 2],
                                                'message' => 'Enter your name',
                                            ],
                                        ]),
                                    SizedBox::make(height: 16),
                                    TextFormField::make('email')
                                        ->keyboardType('emailAddress')
                                        ->decoration(['labelText' => 'Email'])
                                        ->validatorRules([
                                            ['rule' => 'isEmail'],
                                        ]),
                                    SizedBox::make(height: 24),
                                    FilledButton::make(
                                        Text::make('Submit'),
                                        ValidateForm::make(
                                            ShowDialog::make(Text::make('Looks good. The API will receive this in phase 2.')),
                                            ShowDialog::make(Text::make('Check the highlighted fields.')),
                                        ),
                                    ),
                                ),
                        ),
                ),
            );
    }

    private function normalize(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        $isList = array_is_list($value);
        foreach ($value as $key => $item) {
            $value[$key] = $this->normalize($item);
        }

        if (! $isList) {
            ksort($value);
        }

        return $value;
    }
}
