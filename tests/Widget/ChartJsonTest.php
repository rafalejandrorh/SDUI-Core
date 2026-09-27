<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\BarChart;
use Sdui\Core\Widget\BarChartBar;

final class ChartJsonTest extends TestCase
{
    use EncodesJson;

    public function test_bar_chart_minimum_omits_optional_keys(): void
    {
        $json = $this->encode(BarChart::make());

        $this->assertSame(['type' => 'barChart'], $json);
        $this->assertArrayNotHasKey('bars', $json);
        $this->assertArrayNotHasKey('emptyLabel', $json);
    }

    public function test_bar_chart_bars_and_empty_label(): void
    {
        $bar = $this->encode(BarChartBar::make('Comida', 42.5));
        $this->assertSame(['label' => 'Comida', 'value' => 42.5], $bar);
        $this->assertArrayNotHasKey('type', $bar);
        $this->assertArrayNotHasKey('color', $bar);

        $this->assertSame(
            [
                'type' => 'barChart',
                'bars' => [
                    ['label' => 'Comida', 'value' => 42.5, 'color' => '#1B6B4A'],
                    ['label' => 'Transporte', 'value' => 10],
                ],
                'emptyLabel' => 'Sin movimientos',
            ],
            $this->encode(
                BarChart::make(
                    BarChartBar::make('Comida', 42.5)->color('#1B6B4A'),
                    BarChartBar::make('Transporte', 10),
                )->emptyLabel('Sin movimientos'),
            ),
        );
    }
}
