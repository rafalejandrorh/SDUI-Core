<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\None;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Align;
use Sdui\Core\Widget\Flexible;
use Sdui\Core\Widget\GestureDetector;
use Sdui\Core\Widget\GridView;
use Sdui\Core\Widget\InkWell;
use Sdui\Core\Widget\Spacer;
use Sdui\Core\Widget\Stack;
use Sdui\Core\Widget\Table;
use Sdui\Core\Widget\TableCell;
use Sdui\Core\Widget\TableColumnWidth;
use Sdui\Core\Widget\TableRow;
use Sdui\Core\Widget\Text;
use Sdui\Core\Widget\VerticalDivider;
use Sdui\Core\Widget\Wrap;

final class StructureJsonTest extends TestCase
{
    use EncodesJson;

    public function test_spacer_flex_is_optional(): void
    {
        $this->assertSame(['type' => 'spacer'], $this->encode(Spacer::make()));
        $this->assertSame(['type' => 'spacer', 'flex' => 2], $this->encode(Spacer::make(2)));
    }

    public function test_wrap_spacing(): void
    {
        $this->assertSame(['type' => 'wrap'], $this->encode(Wrap::make()));

        $this->assertSame(
            [
                'type' => 'wrap',
                'children' => [
                    ['type' => 'text', 'data' => 'Comida'],
                    ['type' => 'text', 'data' => 'Ocio'],
                ],
                'spacing' => 8,
                'runSpacing' => 4,
            ],
            $this->encode(
                Wrap::make(Text::make('Comida'), Text::make('Ocio'))
                    ->spacing(8)
                    ->runSpacing(4),
            ),
        );
    }

    public function test_flexible_requires_child(): void
    {
        $this->assertSame(
            [
                'type' => 'flexible',
                'child' => ['type' => 'text', 'data' => 'Monto'],
            ],
            $this->encode(Flexible::make(Text::make('Monto'))),
        );

        $this->assertSame(
            [
                'type' => 'flexible',
                'child' => ['type' => 'text', 'data' => 'Monto'],
                'flex' => 2,
            ],
            $this->encode(Flexible::make(Text::make('Monto'), 2)),
        );
    }

    public function test_align_and_stack(): void
    {
        $this->assertSame(['type' => 'align'], $this->encode(Align::make()));
        $this->assertSame(
            [
                'type' => 'align',
                'child' => ['type' => 'text', 'data' => 'USD'],
                'alignment' => 'centerRight',
            ],
            $this->encode(Align::make(Text::make('USD'))->alignment('centerRight')),
        );

        $this->assertSame(['type' => 'stack'], $this->encode(Stack::make()));
        $this->assertSame(
            [
                'type' => 'stack',
                'children' => [
                    ['type' => 'text', 'data' => 'A'],
                    ['type' => 'text', 'data' => 'B'],
                ],
                'alignment' => 'bottomCenter',
            ],
            $this->encode(Stack::make(Text::make('A'), Text::make('B'))->alignment('bottomCenter')),
        );
    }

    public function test_ink_well_and_gesture_detector(): void
    {
        $this->assertSame(['type' => 'inkWell'], $this->encode(InkWell::make()));
        $this->assertSame(
            [
                'type' => 'inkWell',
                'child' => ['type' => 'text', 'data' => 'Fila'],
                'onTap' => ['actionType' => 'none'],
            ],
            $this->encode(InkWell::make(Text::make('Fila'), None::make())),
        );

        $this->assertSame(['type' => 'gestureDetector'], $this->encode(GestureDetector::make()));
        $this->assertSame(
            [
                'type' => 'gestureDetector',
                'child' => ['type' => 'text', 'data' => 'Fila'],
                'onTap' => ['actionType' => 'none'],
            ],
            $this->encode(GestureDetector::make(Text::make('Fila'), None::make())),
        );
    }

    public function test_vertical_divider(): void
    {
        $this->assertSame(['type' => 'verticalDivider'], $this->encode(VerticalDivider::make()));
        $this->assertSame(
            [
                'type' => 'verticalDivider',
                'width' => 16,
                'thickness' => 1,
                'color' => '#CCCCCC',
            ],
            $this->encode(VerticalDivider::make()->width(16)->thickness(1)->color('#CCCCCC')),
        );
    }

    public function test_grid_view_shrink_wrap(): void
    {
        $this->assertSame(['type' => 'gridView'], $this->encode(GridView::make()));
        $this->assertSame(
            [
                'type' => 'gridView',
                'children' => [
                    ['type' => 'text', 'data' => 'A'],
                    ['type' => 'text', 'data' => 'B'],
                ],
                'crossAxisCount' => 2,
                'shrinkWrap' => true,
            ],
            $this->encode(
                GridView::make(Text::make('A'), Text::make('B'))
                    ->crossAxisCount(2)
                    ->shrinkWrap(),
            ),
        );
    }

    public function test_table_row_has_no_type_discriminator(): void
    {
        $this->assertSame(
            [
                'children' => [
                    ['type' => 'text', 'data' => 'Comida'],
                    ['type' => 'text', 'data' => '12,00'],
                ],
            ],
            $this->encode(TableRow::make(Text::make('Comida'), Text::make('12,00'))),
        );
        $this->assertArrayNotHasKey('type', $this->encode(TableRow::make()));
    }

    public function test_table_column_widths_are_a_map(): void
    {
        $this->assertSame(['type' => 'table'], $this->encode(Table::make()));
        $this->assertSame(['type' => 'tableCell'], $this->encode(TableCell::make()));

        $this->assertSame(
            [
                'type' => 'table',
                'children' => [
                    [
                        'children' => [
                            [
                                'type' => 'tableCell',
                                'child' => ['type' => 'text', 'data' => 'Comida'],
                                'verticalAlignment' => 'middle',
                            ],
                            [
                                'type' => 'tableCell',
                                'child' => ['type' => 'text', 'data' => '12,00'],
                            ],
                        ],
                    ],
                ],
                'columnWidths' => [
                    '0' => ['type' => 'flexColumnWidth', 'value' => 2],
                    '1' => ['type' => 'fixedColumnWidth', 'value' => 80],
                ],
            ],
            $this->encode(
                Table::make(
                    TableRow::make(
                        TableCell::make(Text::make('Comida'))->verticalAlignment('middle'),
                        TableCell::make(Text::make('12,00')),
                    ),
                )->columnWidths([
                    TableColumnWidth::flex(2),
                    TableColumnWidth::fixed(80),
                ]),
            ),
        );
    }
}
