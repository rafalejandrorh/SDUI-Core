<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Container;
use Sdui\Core\Widget\Divider;
use Sdui\Core\Widget\Expanded;
use Sdui\Core\Widget\ListView;
use Sdui\Core\Widget\Row;
use Sdui\Core\Widget\Text;

final class LayoutJsonTest extends TestCase
{
    use EncodesJson;

    public function test_container_minimum_and_full(): void
    {
        $this->assertSame(['type' => 'container'], $this->encode(Container::make()));

        $this->assertSame(
            [
                'type' => 'container',
                'child' => ['type' => 'text', 'data' => 'Hi'],
                'width' => 100,
                'height' => 50.5,
                'color' => '#fff',
                'alignment' => 'center',
                'padding' => 8,
                'margin' => ['left' => 1, 'top' => 2, 'right' => 3, 'bottom' => 4],
                'decoration' => ['color' => '#000'],
                'clipBehavior' => 'hardEdge',
            ],
            $this->encode(
                Container::make()
                    ->child(Text::make('Hi'))
                    ->width(100)
                    ->height(50.5)
                    ->color('#fff')
                    ->alignment('center')
                    ->padding(8)
                    ->margin(['left' => 1, 'top' => 2, 'right' => 3, 'bottom' => 4])
                    ->decoration(['color' => '#000'])
                    ->clipBehavior('hardEdge'),
            ),
        );
    }

    public function test_container_padding_accepts_array(): void
    {
        $json = $this->encode(Container::make()->padding(['left' => 4, 'right' => 4]));

        $this->assertSame(['left' => 4, 'right' => 4], $json['padding']);
    }

    public function test_divider_minimum_and_full(): void
    {
        $this->assertSame(['type' => 'divider'], $this->encode(Divider::make()));

        $this->assertSame(
            [
                'type' => 'divider',
                'height' => 16,
                'thickness' => 2.5,
                'color' => '#ccc',
                'indent' => 8,
            ],
            $this->encode(
                Divider::make()
                    ->height(16)
                    ->thickness(2.5)
                    ->color('#ccc')
                    ->indent(8),
            ),
        );
    }

    public function test_expanded_omits_nulls_and_emits_child_flex(): void
    {
        $this->assertSame(['type' => 'expanded'], $this->encode(Expanded::make()));

        $this->assertSame(
            [
                'type' => 'expanded',
                'child' => ['type' => 'text', 'data' => 'Grow'],
                'flex' => 2,
            ],
            $this->encode(Expanded::make(Text::make('Grow'), 2)),
        );
    }

    public function test_list_view_empty_make_omits_children(): void
    {
        $json = $this->encode(ListView::make());

        $this->assertSame(['type' => 'listView'], $json);
        $this->assertArrayNotHasKey('children', $json);
    }

    public function test_list_view_unwraps_children_and_optional_fields(): void
    {
        $separator = Divider::make();

        $this->assertSame(
            [
                'type' => 'listView',
                'children' => [
                    ['type' => 'text', 'data' => 'A'],
                    ['type' => 'text', 'data' => 'B'],
                ],
                'shrinkWrap' => true,
                'padding' => 12,
                'separator' => ['type' => 'divider'],
                'physics' => 'neverScrollableScrollPhysics',
            ],
            $this->encode(
                ListView::make()
                    ->children([Text::make('A'), Text::make('B')])
                    ->shrinkWrap()
                    ->padding(12)
                    ->separator($separator)
                    ->physics('neverScrollableScrollPhysics'),
            ),
        );
    }

    public function test_list_view_variadic_children_and_shrink_wrap_false(): void
    {
        $json = $this->encode(
            ListView::make(Text::make('A'), Text::make('B'))->shrinkWrap(false),
        );

        $this->assertCount(2, $json['children']);
        $this->assertFalse($json['shrinkWrap']);
    }

    public function test_row_empty_make_and_alignment_fields(): void
    {
        $this->assertSame(['type' => 'row'], $this->encode(Row::make()));

        $this->assertSame(
            [
                'type' => 'row',
                'children' => [
                    ['type' => 'text', 'data' => 'A'],
                    ['type' => 'text', 'data' => 'B'],
                ],
                'mainAxisAlignment' => 'spaceBetween',
                'crossAxisAlignment' => 'center',
                'mainAxisSize' => 'min',
                'spacing' => 8,
            ],
            $this->encode(
                Row::make()
                    ->children(Text::make('A'), Text::make('B'))
                    ->mainAxisAlignment('spaceBetween')
                    ->crossAxisAlignment('center')
                    ->mainAxisSize('min')
                    ->spacing(8),
            ),
        );
    }

    public function test_row_unwraps_a_single_list_of_children(): void
    {
        $json = $this->encode(Row::make([Text::make('A'), Text::make('B')]));

        $this->assertSame(
            [
                ['type' => 'text', 'data' => 'A'],
                ['type' => 'text', 'data' => 'B'],
            ],
            $json['children'],
        );
    }
}
