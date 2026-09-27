<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\BoundText;

final class BoundTextJsonTest extends TestCase
{
    use EncodesJson;

    public function test_bound_text_minimum_is_the_value_key(): void
    {
        $json = $this->encode(BoundText::make('convertResult'));

        $this->assertSame([
            'type' => 'boundText',
            'valueKey' => 'convertResult',
        ], $json);
        $this->assertArrayNotHasKey('placeholder', $json);
    }

    public function test_bound_text_emits_placeholder_and_style(): void
    {
        $this->assertSame(
            [
                'type' => 'boundText',
                'valueKey' => 'convertResult',
                'placeholder' => 'El resultado aparece aquí',
                'style' => ['fontSize' => 18],
            ],
            $this->encode(
                BoundText::make('convertResult')
                    ->placeholder('El resultado aparece aquí')
                    ->style(['fontSize' => 18]),
            ),
        );
    }
}
