<?php

declare(strict_types=1);

namespace Sdui\Core\Tests;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\Multi;
use Sdui\Core\Action\None;
use Sdui\Core\Raw;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Column;
use Sdui\Core\Widget\Text;

final class ElementTest extends TestCase
{
    use EncodesJson;

    public function test_json_serialize_omits_null_attributes(): void
    {
        $json = $this->encode(Text::make('Hello')->extra(['maxLines' => null]));

        $this->assertSame(['type' => 'text', 'data' => 'Hello'], $json);
        $this->assertArrayNotHasKey('maxLines', $json);
    }

    public function test_extra_merges_and_overwrites_keys(): void
    {
        $json = $this->encode(
            Text::make('Hello')
                ->extra(['textAlign' => 'left', 'overflow' => 'clip'])
                ->extra(['textAlign' => 'center']),
        );

        $this->assertSame(
            [
                'type' => 'text',
                'data' => 'Hello',
                'textAlign' => 'center',
                'overflow' => 'clip',
            ],
            $json,
        );
    }

    public function test_list_of_keeps_variadic_children(): void
    {
        $json = $this->encode(Column::make(Text::make('A'), Text::make('B')));

        $this->assertSame(
            [
                ['type' => 'text', 'data' => 'A'],
                ['type' => 'text', 'data' => 'B'],
            ],
            $json['children'],
        );
    }

    public function test_list_of_unwraps_a_single_list_array(): void
    {
        $json = $this->encode(Column::make()->children([Text::make('A'), Text::make('B')]));

        $this->assertSame(
            [
                ['type' => 'text', 'data' => 'A'],
                ['type' => 'text', 'data' => 'B'],
            ],
            $json['children'],
        );
    }

    public function test_list_of_does_not_unwrap_a_single_associative_array(): void
    {
        $json = $this->encode(Column::make()->children(['type' => 'text', 'data' => 'A']));

        $this->assertSame(
            [
                ['type' => 'text', 'data' => 'A'],
            ],
            $json['children'],
        );
    }

    public function test_list_of_keeps_a_single_non_array_child(): void
    {
        $json = $this->encode(Column::make(Text::make('A')));

        $this->assertSame(
            [
                ['type' => 'text', 'data' => 'A'],
            ],
            $json['children'],
        );
    }

    public function test_raw_passthrough_keeps_nulls(): void
    {
        $json = $this->encode(Raw::make([
            'actionType' => 'custom',
            'payload' => null,
        ]));

        $this->assertSame(
            [
                'actionType' => 'custom',
                'payload' => null,
            ],
            $json,
        );
    }

    public function test_raw_nested_in_multi_is_emitted_verbatim(): void
    {
        $json = $this->encode(Multi::make(
            None::make(),
            Raw::make(['actionType' => 'none', 'note' => null]),
        ));

        $this->assertSame(
            [
                'actionType' => 'multiAction',
                'actions' => [
                    ['actionType' => 'none'],
                    ['actionType' => 'none', 'note' => null],
                ],
            ],
            $json,
        );
    }
}
