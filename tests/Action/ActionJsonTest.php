<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Action;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\GetFormValue;
use Sdui\Core\Action\Multi;
use Sdui\Core\Action\Navigate;
use Sdui\Core\Action\NetworkRequest;
use Sdui\Core\Action\NetworkResult;
use Sdui\Core\Action\None;
use Sdui\Core\Action\SduiLogout;
use Sdui\Core\Action\SduiNavigate;
use Sdui\Core\Action\SduiReload;
use Sdui\Core\Action\SduiShare;
use Sdui\Core\Action\SetValue;
use Sdui\Core\Action\SetValueEntry;
use Sdui\Core\Action\ShowDialog;
use Sdui\Core\Action\ShowModalBottomSheet;
use Sdui\Core\Action\ShowSnackBar;
use Sdui\Core\Action\ValidateForm;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Text;

final class ActionJsonTest extends TestCase
{
    use EncodesJson;

    public function test_sdui_navigate_omits_default_push_style(): void
    {
        $json = $this->encode(SduiNavigate::make('home'));

        $this->assertSame(['actionType' => 'sduiNavigate', 'screen' => 'home'], $json);
        $this->assertArrayNotHasKey('style', $json);
    }

    public function test_sdui_navigate_emits_non_push_style(): void
    {
        $this->assertSame(
            ['actionType' => 'sduiNavigate', 'screen' => 'details', 'style' => 'replace'],
            $this->encode(SduiNavigate::make('details', 'replace')),
        );
    }

    public function test_sdui_navigate_style_setter(): void
    {
        $json = $this->encode(SduiNavigate::make('form')->style('pop'));

        $this->assertSame('pop', $json['style']);
    }

    public function test_navigate_minimum_and_full_payload(): void
    {
        $this->assertSame(['actionType' => 'navigate'], $this->encode(Navigate::make()));

        $this->assertSame(
            [
                'actionType' => 'navigate',
                'navigationStyle' => 'push',
                'routeName' => '/profile',
                'request' => ['url' => '/sdui/screens/profile'],
                'widgetJson' => ['type' => 'text', 'data' => 'Inline'],
                'assetPath' => 'screens/profile.json',
                'result' => ['ok' => true],
                'arguments' => ['id' => '42'],
            ],
            $this->encode(
                Navigate::make()
                    ->navigationStyle('push')
                    ->routeName('/profile')
                    ->request(['url' => '/sdui/screens/profile'])
                    ->widgetJson(Text::make('Inline'))
                    ->assetPath('screens/profile.json')
                    ->result(['ok' => true])
                    ->arguments(['id' => '42']),
            ),
        );
    }

    public function test_navigate_pop_factory(): void
    {
        $this->assertSame(
            ['actionType' => 'navigate', 'navigationStyle' => 'pop'],
            $this->encode(Navigate::pop()),
        );
    }

    public function test_multi_empty_make_omits_actions(): void
    {
        $json = $this->encode(Multi::make());

        $this->assertSame(['actionType' => 'multiAction'], $json);
        $this->assertArrayNotHasKey('actions', $json);
        $this->assertArrayNotHasKey('sync', $json);
    }

    public function test_multi_unwraps_actions_list_and_sync_false(): void
    {
        $this->assertSame(
            [
                'actionType' => 'multiAction',
                'actions' => [
                    ['actionType' => 'none'],
                    ['actionType' => 'sduiLogout'],
                ],
                'sync' => false,
            ],
            $this->encode(
                Multi::make()->actions([None::make(), SduiLogout::make()])->sync(false),
            ),
        );
    }

    public function test_show_dialog_empty_and_full(): void
    {
        $this->assertSame(['actionType' => 'showDialog'], $this->encode(ShowDialog::make()));

        $this->assertSame(
            [
                'actionType' => 'showDialog',
                'widget' => ['type' => 'text', 'data' => 'Alert'],
                'request' => ['url' => '/dialog'],
                'assetPath' => 'dialogs/alert.json',
                'barrierDismissible' => false,
            ],
            $this->encode(
                ShowDialog::make(Text::make('Alert'))
                    ->request(['url' => '/dialog'])
                    ->assetPath('dialogs/alert.json')
                    ->barrierDismissible(false),
            ),
        );
    }

    public function test_show_snack_bar_empty_and_full(): void
    {
        $this->assertSame(['actionType' => 'showSnackBar'], $this->encode(ShowSnackBar::make()));

        $this->assertSame(
            [
                'actionType' => 'showSnackBar',
                'content' => ['type' => 'text', 'data' => 'Saved'],
                'backgroundColor' => '#111',
                'behavior' => 'floating',
                'action' => ['label' => 'Undo'],
            ],
            $this->encode(
                ShowSnackBar::make(Text::make('Saved'))
                    ->backgroundColor('#111')
                    ->behavior('floating')
                    ->action(['label' => 'Undo']),
            ),
        );
    }

    public function test_validate_form_partial_branches(): void
    {
        $this->assertSame(['actionType' => 'validateForm'], $this->encode(ValidateForm::make()));

        $this->assertSame(
            [
                'actionType' => 'validateForm',
                'isValid' => ['actionType' => 'none'],
            ],
            $this->encode(ValidateForm::make(None::make())),
        );

        $this->assertSame(
            [
                'actionType' => 'validateForm',
                'isNotValid' => ['actionType' => 'showSnackBar'],
            ],
            $this->encode(ValidateForm::make(null, ShowSnackBar::make())),
        );

        $this->assertSame(
            [
                'actionType' => 'validateForm',
                'isValid' => ['actionType' => 'none'],
                'isNotValid' => ['actionType' => 'none'],
            ],
            $this->encode(ValidateForm::make()->isValid(None::make())->isNotValid(None::make())),
        );
    }

    public function test_network_request_query_and_headers(): void
    {
        $this->assertSame(
            [
                'actionType' => 'networkRequest',
                'url' => '/sdui/actions/save',
                'method' => 'put',
                'queryParameters' => ['draft' => '1'],
                'headers' => ['X-Request-Id' => 'abc'],
                'contentType' => 'application/json',
                'body' => ['id' => '1'],
                'results' => [
                    [
                        'statusCode' => 204,
                        'action' => ['actionType' => 'none'],
                    ],
                ],
            ],
            $this->encode(
                NetworkRequest::make('/sdui/actions/save')
                    ->method('put')
                    ->queryParameters(['draft' => '1'])
                    ->headers(['X-Request-Id' => 'abc'])
                    ->contentType('application/json')
                    ->body(['id' => '1'])
                    ->results([NetworkResult::make(204, None::make())]),
            ),
        );
    }

    public function test_none_get_form_value_and_logout(): void
    {
        $this->assertSame(['actionType' => 'none'], $this->encode(None::make()));
        $this->assertSame(
            ['actionType' => 'getFormValue', 'id' => 'email'],
            $this->encode(GetFormValue::make('email')),
        );
        $this->assertSame(['actionType' => 'sduiLogout'], $this->encode(SduiLogout::make()));
    }

    public function test_show_modal_bottom_sheet(): void
    {
        $this->assertSame(['actionType' => 'showModalBottomSheet'], $this->encode(ShowModalBottomSheet::make()));

        $this->assertSame(
            [
                'actionType' => 'showModalBottomSheet',
                'widget' => ['type' => 'text', 'data' => 'Alta'],
                'isScrollControlled' => true,
            ],
            $this->encode(
                ShowModalBottomSheet::make(Text::make('Alta'))->isScrollControlled(),
            ),
        );
    }

    public function test_set_value_entries_have_no_type(): void
    {
        $this->assertSame(['actionType' => 'setValue'], $this->encode(SetValue::make()));

        $entry = $this->encode(SetValueEntry::make('convertResult', '{{response.formatted}}'));
        $this->assertSame(['key' => 'convertResult', 'value' => '{{response.formatted}}'], $entry);
        $this->assertArrayNotHasKey('type', $entry);

        $this->assertSame(
            [
                'actionType' => 'setValue',
                'values' => [
                    ['key' => 'convertResult', 'value' => '{{response.formatted}}'],
                ],
                'action' => ['actionType' => 'none'],
            ],
            $this->encode(
                SetValue::make(SetValueEntry::make('convertResult', '{{response.formatted}}'))
                    ->action(None::make()),
            ),
        );
    }

    public function test_sdui_share_emits_text(): void
    {
        $this->assertSame(
            ['actionType' => 'sduiShare', 'text' => 'Hoy: $ 12,00'],
            $this->encode(SduiShare::make('Hoy: $ 12,00')),
        );
    }

    public function test_sdui_reload_omits_screen_when_null(): void
    {
        $json = $this->encode(SduiReload::make());

        $this->assertSame(['actionType' => 'sduiReload'], $json);
        $this->assertArrayNotHasKey('screen', $json);
    }

    public function test_sdui_reload_emits_named_screen(): void
    {
        $this->assertSame(
            ['actionType' => 'sduiReload', 'screen' => 'movements'],
            $this->encode(SduiReload::make('movements')),
        );
    }
}
