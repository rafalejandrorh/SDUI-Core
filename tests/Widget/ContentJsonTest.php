<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Center;
use Sdui\Core\Widget\Column;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\Image;
use Sdui\Core\Widget\Padding;
use Sdui\Core\Widget\SizedBox;
use Sdui\Core\Widget\Text;

final class ContentJsonTest extends TestCase
{
    use EncodesJson;

    public function test_padding_scalar_vs_all_ltrb(): void
    {
        $this->assertSame(
            [
                'type' => 'padding',
                'padding' => 24,
                'child' => ['type' => 'text', 'data' => 'Padded'],
            ],
            $this->encode(Padding::make(24)->child(Text::make('Padded'))),
        );

        $this->assertSame(
            [
                'type' => 'padding',
                'padding' => [
                    'left' => 8,
                    'top' => 8,
                    'right' => 8,
                    'bottom' => 8,
                ],
            ],
            $this->encode(Padding::all(8)),
        );
    }

    public function test_sized_box_dimension_combinations(): void
    {
        $this->assertSame(['type' => 'sizedBox'], $this->encode(SizedBox::make()));
        $this->assertSame(['type' => 'sizedBox', 'width' => 10], $this->encode(SizedBox::make(10)));
        $this->assertSame(
            ['type' => 'sizedBox', 'height' => 20],
            $this->encode(SizedBox::make(height: 20)),
        );
        $this->assertSame(
            [
                'type' => 'sizedBox',
                'width' => 10,
                'height' => 20,
                'child' => ['type' => 'text', 'data' => 'Box'],
            ],
            $this->encode(SizedBox::make(10, 20)->child(Text::make('Box'))),
        );
    }

    public function test_image_asset_and_optional_geometry(): void
    {
        $this->assertSame(
            [
                'type' => 'image',
                'src' => 'assets/logo.png',
                'imageType' => 'asset',
                'width' => 40,
                'height' => 40,
                'fit' => 'contain',
                'alignment' => 'center',
            ],
            $this->encode(
                Image::asset('assets/logo.png')
                    ->width(40)
                    ->height(40)
                    ->fit('contain')
                    ->alignment('center'),
            ),
        );

        $this->assertSame(
            [
                'type' => 'image',
                'src' => 'https://example.com/x.png',
            ],
            $this->encode(Image::make('https://example.com/x.png')),
        );
    }

    public function test_icon_optional_fields(): void
    {
        $this->assertSame(
            ['type' => 'icon', 'icon' => 'home'],
            $this->encode(Icon::make('home')),
        );

        $this->assertSame(
            [
                'type' => 'icon',
                'icon' => 'home',
                'iconType' => 'material',
                'size' => 24,
                'color' => '#333',
            ],
            $this->encode(
                Icon::make('home')
                    ->iconType('material')
                    ->size(24)
                    ->color('#333'),
            ),
        );
    }

    public function test_text_optional_fields(): void
    {
        $this->assertSame(
            [
                'type' => 'text',
                'data' => 'Hello',
                'style' => ['fontSize' => 16],
                'textAlign' => 'center',
                'maxLines' => 2,
                'overflow' => 'ellipsis',
            ],
            $this->encode(
                Text::make('Hello')
                    ->style(['fontSize' => 16])
                    ->textAlign('center')
                    ->maxLines(2)
                    ->overflow('ellipsis'),
            ),
        );
    }

    public function test_column_empty_make_and_alignment_fields(): void
    {
        $this->assertSame(['type' => 'column'], $this->encode(Column::make()));

        $this->assertSame(
            [
                'type' => 'column',
                'children' => [
                    ['type' => 'text', 'data' => 'A'],
                ],
                'mainAxisAlignment' => 'start',
                'crossAxisAlignment' => 'stretch',
                'mainAxisSize' => 'max',
                'spacing' => 4.5,
            ],
            $this->encode(
                Column::make(Text::make('A'))
                    ->mainAxisAlignment('start')
                    ->crossAxisAlignment('stretch')
                    ->mainAxisSize('max')
                    ->spacing(4.5),
            ),
        );
    }

    public function test_center_empty_and_with_child(): void
    {
        $this->assertSame(['type' => 'center'], $this->encode(Center::make()));

        $this->assertSame(
            [
                'type' => 'center',
                'child' => ['type' => 'text', 'data' => 'Mid'],
            ],
            $this->encode(Center::make(Text::make('Mid'))),
        );
    }
}
