<?php

declare(strict_types=1);

namespace Stac\Tests;

use PHPUnit\Framework\TestCase;
use Stac\Action\GetFormValue;
use Stac\Action\Multi;
use Stac\Action\NetworkRequest;
use Stac\Action\NetworkResult;
use Stac\Action\None;
use Stac\Action\ShowSnackBar;
use Stac\Raw;
use Stac\Widget\CheckBox;
use Stac\Widget\DropdownMenu;
use Stac\Widget\DropdownMenuEntry;
use Stac\Widget\Image;
use Stac\Widget\Text;

final class BuilderJsonTest extends TestCase
{
    public function test_network_request_with_status_results(): void
    {
        $action = NetworkRequest::make('/sdui/actions/profile')
            ->method('post')
            ->contentType('application/json')
            ->body([
                'name' => GetFormValue::make('name'),
                'email' => GetFormValue::make('email'),
            ])
            ->results([
                NetworkResult::make(200, ShowSnackBar::make(Text::make('Saved.'))),
                NetworkResult::make(422, ShowSnackBar::make(Text::make('Check the fields.'))),
                NetworkResult::make(500, None::make()),
            ]);

        $this->assertSame(
            [
                'actionType' => 'networkRequest',
                'url' => '/sdui/actions/profile',
                'method' => 'post',
                'contentType' => 'application/json',
                'body' => [
                    'name' => ['actionType' => 'getFormValue', 'id' => 'name'],
                    'email' => ['actionType' => 'getFormValue', 'id' => 'email'],
                ],
                'results' => [
                    [
                        'statusCode' => 200,
                        'action' => [
                            'actionType' => 'showSnackBar',
                            'content' => ['type' => 'text', 'data' => 'Saved.'],
                        ],
                    ],
                    [
                        'statusCode' => 422,
                        'action' => [
                            'actionType' => 'showSnackBar',
                            'content' => ['type' => 'text', 'data' => 'Check the fields.'],
                        ],
                    ],
                    [
                        'statusCode' => 500,
                        'action' => ['actionType' => 'none'],
                    ],
                ],
            ],
            json_decode(json_encode($action, JSON_THROW_ON_ERROR), true),
        );
    }

    public function test_multi_action_and_raw_escape_hatch(): void
    {
        $action = Multi::make(
            ShowSnackBar::make(Text::make('Working...')),
            Raw::make(['actionType' => 'none']),
        )->sync();

        $this->assertSame('multiAction', json_decode(json_encode($action), true)['actionType']);
        $this->assertTrue(json_decode(json_encode($action), true)['sync']);
        $this->assertCount(2, json_decode(json_encode($action), true)['actions']);
    }

    public function test_checkbox_and_dropdown_menu(): void
    {
        $checkbox = CheckBox::make('terms')->value(false);
        $menu = DropdownMenu::make()
            ->hintText('Pick one')
            ->dropdownMenuEntries([
                DropdownMenuEntry::make('a', 'Alpha'),
                DropdownMenuEntry::make('b', 'Beta'),
            ]);

        $this->assertSame('checkBox', json_decode(json_encode($checkbox), true)['type']);
        $this->assertSame('dropdownMenu', json_decode(json_encode($menu), true)['type']);
        $this->assertSame('Alpha', json_decode(json_encode($menu), true)['dropdownMenuEntries'][0]['label']);
    }

    public function test_image_network_omits_nulls(): void
    {
        $json = json_decode(json_encode(Image::network('https://example.com/x.png')->fit('cover')), true);

        $this->assertSame('image', $json['type']);
        $this->assertSame('network', $json['imageType']);
        $this->assertArrayNotHasKey('width', $json);
    }
}
