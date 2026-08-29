<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\None;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\ElevatedButton;
use Sdui\Core\Widget\FilledButton;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\IconButton;
use Sdui\Core\Widget\Text;
use Sdui\Core\Widget\TextButton;

final class ButtonJsonTest extends TestCase
{
    use EncodesJson;

    public function test_elevated_button_empty_make(): void
    {
        $this->assertSame(['type' => 'elevatedButton'], $this->encode(ElevatedButton::make()));
    }

    public function test_elevated_button_child_on_pressed_long_press_and_style(): void
    {
        $this->assertSame(
            [
                'type' => 'elevatedButton',
                'child' => ['type' => 'text', 'data' => 'Go'],
                'onPressed' => ['actionType' => 'none'],
                'onLongPress' => ['actionType' => 'none'],
                'style' => ['elevation' => 2],
            ],
            $this->encode(
                ElevatedButton::make(Text::make('Go'), None::make())
                    ->onLongPress(None::make())
                    ->style(['elevation' => 2]),
            ),
        );
    }

    public function test_filled_button_make_with_child_and_on_pressed(): void
    {
        $this->assertSame(
            [
                'type' => 'filledButton',
                'child' => ['type' => 'text', 'data' => 'Save'],
                'onPressed' => ['actionType' => 'none'],
            ],
            $this->encode(FilledButton::make(Text::make('Save'), None::make())),
        );
    }

    public function test_filled_button_on_long_press_and_style(): void
    {
        $json = $this->encode(
            FilledButton::make()
                ->child(Text::make('Save'))
                ->onPressed(None::make())
                ->onLongPress(None::make())
                ->style(['backgroundColor' => '#00f']),
        );

        $this->assertSame('filledButton', $json['type']);
        $this->assertSame(['actionType' => 'none'], $json['onLongPress']);
        $this->assertSame(['backgroundColor' => '#00f'], $json['style']);
    }

    public function test_text_button_empty_and_setters(): void
    {
        $this->assertSame(['type' => 'textButton'], $this->encode(TextButton::make()));

        $this->assertSame(
            [
                'type' => 'textButton',
                'child' => ['type' => 'text', 'data' => 'Link'],
                'onPressed' => ['actionType' => 'none'],
            ],
            $this->encode(TextButton::make(Text::make('Link'), None::make())),
        );

        $json = $this->encode(
            TextButton::make(Text::make('Link'))
                ->onPressed(None::make())
                ->onLongPress(None::make())
                ->style(['foregroundColor' => '#00f']),
        );

        $this->assertSame('textButton', $json['type']);
        $this->assertArrayHasKey('onLongPress', $json);
        $this->assertArrayHasKey('style', $json);
    }

    public function test_icon_button_empty_and_full(): void
    {
        $this->assertSame(['type' => 'iconButton'], $this->encode(IconButton::make()));

        $this->assertSame(
            [
                'type' => 'iconButton',
                'icon' => ['type' => 'icon', 'icon' => 'close'],
                'onPressed' => ['actionType' => 'none'],
                'iconSize' => 18,
                'tooltip' => 'Close',
            ],
            $this->encode(
                IconButton::make(Icon::make('close'), None::make())
                    ->iconSize(18)
                    ->tooltip('Close'),
            ),
        );
    }
}
