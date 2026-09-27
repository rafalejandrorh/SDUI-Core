<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\None;
use Sdui\Core\Action\SduiNavigate;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Badge;
use Sdui\Core\Widget\Card;
use Sdui\Core\Widget\Chip;
use Sdui\Core\Widget\CircularProgressIndicator;
use Sdui\Core\Widget\FloatingActionButton;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\LinearProgressIndicator;
use Sdui\Core\Widget\ListTile;
use Sdui\Core\Widget\OutlinedButton;
use Sdui\Core\Widget\RefreshIndicator;
use Sdui\Core\Widget\SafeArea;
use Sdui\Core\Widget\SelectableText;
use Sdui\Core\Widget\SingleChildScrollView;
use Sdui\Core\Widget\Text;

final class SurfaceJsonTest extends TestCase
{
    use EncodesJson;

    public function test_card_minimal_and_styled(): void
    {
        $this->assertSame(['type' => 'card'], $this->encode(Card::make()));

        $this->assertSame(
            [
                'type' => 'card',
                'child' => ['type' => 'text', 'data' => 'USD'],
                'color' => '#FFFFFF',
                'elevation' => 1,
                'margin' => 8,
            ],
            $this->encode(
                Card::make(Text::make('USD'))
                    ->color('#FFFFFF')
                    ->elevation(1)
                    ->margin(8),
            ),
        );
    }

    public function test_list_tile_minimal_and_movement_row(): void
    {
        $this->assertSame(['type' => 'listTile'], $this->encode(ListTile::make()));

        $this->assertSame(
            [
                'type' => 'listTile',
                'leading' => ['type' => 'icon', 'icon' => 'restaurant'],
                'title' => ['type' => 'text', 'data' => 'Comida'],
                'subtitle' => ['type' => 'text', 'data' => 'Bs. 100,00'],
                'trailing' => ['type' => 'text', 'data' => '$ 2,00'],
                'onTap' => ['actionType' => 'sduiNavigate', 'screen' => 'movement'],
            ],
            $this->encode(
                ListTile::make()
                    ->leading(Icon::make('restaurant'))
                    ->title(Text::make('Comida'))
                    ->subtitle(Text::make('Bs. 100,00'))
                    ->trailing(Text::make('$ 2,00'))
                    ->onTap(SduiNavigate::make('movement')),
            ),
        );
    }

    public function test_chip_requires_label(): void
    {
        $this->assertSame(
            [
                'type' => 'chip',
                'label' => ['type' => 'text', 'data' => 'Desactualizada'],
            ],
            $this->encode(Chip::make(Text::make('Desactualizada'))),
        );

        $this->assertSame(
            [
                'type' => 'chip',
                'label' => ['type' => 'text', 'data' => 'Desactualizada'],
                'backgroundColor' => '#F4E3B2',
            ],
            $this->encode(
                Chip::make(Text::make('Desactualizada'))->backgroundColor('#F4E3B2'),
            ),
        );
    }

    public function test_badge_minimal_and_label(): void
    {
        $this->assertSame(['type' => 'badge'], $this->encode(Badge::make()));

        $this->assertSame(
            [
                'type' => 'badge',
                'child' => ['type' => 'icon', 'icon' => 'notifications'],
                'label' => ['type' => 'text', 'data' => '3'],
            ],
            $this->encode(
                Badge::make(Icon::make('notifications'))->label(Text::make('3')),
            ),
        );
    }

    public function test_selectable_text_copies_a_rate(): void
    {
        $this->assertSame(
            ['type' => 'selectableText', 'data' => '36,5432'],
            $this->encode(SelectableText::make('36,5432')),
        );

        $this->assertSame(
            [
                'type' => 'selectableText',
                'data' => '36,5432',
                'style' => ['fontSize' => 24],
            ],
            $this->encode(SelectableText::make('36,5432')->style(['fontSize' => 24])),
        );
    }

    public function test_outlined_button_keeps_its_type(): void
    {
        $this->assertSame(['type' => 'outlinedButton'], $this->encode(OutlinedButton::make()));

        $this->assertSame(
            [
                'type' => 'outlinedButton',
                'child' => ['type' => 'text', 'data' => 'Convertir'],
                'onPressed' => ['actionType' => 'sduiNavigate', 'screen' => 'convert'],
            ],
            $this->encode(
                OutlinedButton::make(Text::make('Convertir'), SduiNavigate::make('convert')),
            ),
        );
    }

    public function test_floating_action_button_optional_tooltip(): void
    {
        $this->assertSame(
            ['type' => 'floatingActionButton'],
            $this->encode(FloatingActionButton::make()),
        );

        $this->assertSame(
            [
                'type' => 'floatingActionButton',
                'child' => ['type' => 'icon', 'icon' => 'add'],
                'onPressed' => ['actionType' => 'none'],
                'tooltip' => 'Anotar',
            ],
            $this->encode(
                FloatingActionButton::make(Icon::make('add'), None::make())->tooltip('Anotar'),
            ),
        );
    }

    public function test_refresh_indicator_requires_child_and_action(): void
    {
        $this->assertSame(
            [
                'type' => 'refreshIndicator',
                'child' => ['type' => 'text', 'data' => 'Home'],
                'onRefresh' => ['actionType' => 'none'],
            ],
            $this->encode(RefreshIndicator::make(Text::make('Home'), None::make())),
        );
    }

    public function test_single_child_scroll_view_padding(): void
    {
        $this->assertSame(
            ['type' => 'singleChildScrollView'],
            $this->encode(SingleChildScrollView::make()),
        );

        $this->assertSame(
            [
                'type' => 'singleChildScrollView',
                'child' => ['type' => 'text', 'data' => 'Body'],
                'padding' => 16,
            ],
            $this->encode(SingleChildScrollView::make(Text::make('Body'))->padding(16)),
        );
    }

    public function test_safe_area_wraps_a_child(): void
    {
        $this->assertSame(['type' => 'safeArea'], $this->encode(SafeArea::make()));

        $this->assertSame(
            [
                'type' => 'safeArea',
                'child' => ['type' => 'text', 'data' => 'Home'],
            ],
            $this->encode(SafeArea::make(Text::make('Home'))),
        );
    }

    public function test_progress_indicators(): void
    {
        $this->assertSame(
            ['type' => 'circularProgressIndicator'],
            $this->encode(CircularProgressIndicator::make()),
        );
        $this->assertSame(
            ['type' => 'linearProgressIndicator'],
            $this->encode(LinearProgressIndicator::make()),
        );
        $this->assertSame(
            ['type' => 'linearProgressIndicator', 'value' => 0.4],
            $this->encode(LinearProgressIndicator::make()->value(0.4)),
        );
    }
}
