<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\None;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Column;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\NavigationBar;
use Sdui\Core\Widget\NavigationDestination;
use Sdui\Core\Widget\Radio;
use Sdui\Core\Widget\RadioGroup;
use Sdui\Core\Widget\SwitchWidget;

final class ChoiceJsonTest extends TestCase
{
    use EncodesJson;

    public function test_navigation_destination_has_no_action(): void
    {
        $json = $this->encode(NavigationDestination::make(Icon::make('home'), 'Inicio'));

        $this->assertSame(
            [
                'icon' => ['type' => 'icon', 'icon' => 'home'],
                'label' => 'Inicio',
            ],
            $json,
        );
        $this->assertArrayNotHasKey('onTap', $json);
    }

    public function test_navigation_bar_selected_index(): void
    {
        $this->assertSame(
            ['type' => 'navigationBar', 'destinations' => []],
            $this->encode(NavigationBar::make()),
        );

        $this->assertSame(
            [
                'type' => 'navigationBar',
                'destinations' => [
                    [
                        'icon' => ['type' => 'icon', 'icon' => 'home'],
                        'label' => 'Inicio',
                        'selectedIcon' => ['type' => 'icon', 'icon' => 'home_filled'],
                    ],
                    [
                        'icon' => ['type' => 'icon', 'icon' => 'today'],
                        'label' => 'Hoy',
                    ],
                ],
                'selectedIndex' => 1,
            ],
            $this->encode(
                NavigationBar::make(
                    NavigationDestination::make(Icon::make('home'), 'Inicio')
                        ->selectedIcon(Icon::make('home_filled')),
                    NavigationDestination::make(Icon::make('today'), 'Hoy'),
                )->selectedIndex(1),
            ),
        );
    }

    public function test_switch_has_no_id(): void
    {
        $minimal = $this->encode(SwitchWidget::make());

        $this->assertSame(['type' => 'switch'], $minimal);
        $this->assertArrayNotHasKey('id', $minimal);

        $this->assertSame(
            [
                'type' => 'switch',
                'value' => true,
                'onChanged' => ['actionType' => 'none'],
            ],
            $this->encode(SwitchWidget::make(true)->onChanged(None::make())),
        );
    }

    public function test_radio_group_options_are_child_radios(): void
    {
        $this->assertSame(['type' => 'radioGroup'], $this->encode(RadioGroup::make()));
        $this->assertSame(
            ['type' => 'radio', 'value' => 'expense'],
            $this->encode(Radio::make('expense')),
        );

        $this->assertSame(
            [
                'type' => 'radioGroup',
                'id' => 'kind',
                'groupValue' => 'expense',
                'child' => [
                    'type' => 'column',
                    'children' => [
                        ['type' => 'radio', 'value' => 'expense'],
                        ['type' => 'radio', 'value' => 'income', 'onChanged' => ['actionType' => 'none']],
                    ],
                ],
                'onChanged' => ['actionType' => 'none'],
            ],
            $this->encode(
                RadioGroup::make('kind')
                    ->groupValue('expense')
                    ->child(
                        Column::make(
                            Radio::make('expense'),
                            Radio::make('income')->onChanged(None::make()),
                        ),
                    )
                    ->onChanged(None::make()),
            ),
        );
    }
}
