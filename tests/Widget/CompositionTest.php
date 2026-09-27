<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Sdui\Core\Action\None;
use Sdui\Core\Action\ShowModalBottomSheet;
use Sdui\Core\Tests\Support\EncodesJson;
use Sdui\Core\Widget\Card;
use Sdui\Core\Widget\FloatingActionButton;
use Sdui\Core\Widget\Icon;
use Sdui\Core\Widget\ListTile;
use Sdui\Core\Widget\ListView;
use Sdui\Core\Widget\NavigationBar;
use Sdui\Core\Widget\NavigationDestination;
use Sdui\Core\Widget\RefreshIndicator;
use Sdui\Core\Widget\Scaffold;
use Sdui\Core\Widget\Text;

final class CompositionTest extends TestCase
{
    use EncodesJson;

    public function test_scaffold_with_navigation_list_and_sheet(): void
    {
        $screen = Scaffold::make()
            ->bottomNavigationBar(
                NavigationBar::make(
                    NavigationDestination::make(Icon::make('home'), 'Inicio'),
                    NavigationDestination::make(Icon::make('today'), 'Hoy'),
                )->selectedIndex(1),
            )
            ->body(
                RefreshIndicator::make(
                    ListView::make(
                        Card::make()->child(
                            ListTile::make()
                                ->title(Text::make('Comida'))
                                ->subtitle(Text::make('Bs. 100,00')),
                        ),
                    ),
                    None::make(),
                ),
            )
            ->floatingActionButton(
                FloatingActionButton::make()
                    ->child(Icon::make('add'))
                    ->tooltip('Anotar')
                    ->onPressed(
                        ShowModalBottomSheet::make(Text::make('Alta'))->isScrollControlled(true),
                    ),
            );

        $json = $this->encode($screen);

        $this->assertSame('navigationBar', $json['bottomNavigationBar']['type']);
        $this->assertSame(1, $json['bottomNavigationBar']['selectedIndex']);
        $this->assertSame('Inicio', $json['bottomNavigationBar']['destinations'][0]['label']);
        $this->assertArrayNotHasKey('onTap', $json['bottomNavigationBar']['destinations'][0]);

        $this->assertSame('refreshIndicator', $json['body']['type']);
        $this->assertSame('none', $json['body']['onRefresh']['actionType']);
        $this->assertSame('listView', $json['body']['child']['type']);
        $this->assertSame('card', $json['body']['child']['children'][0]['type']);
        $this->assertSame('listTile', $json['body']['child']['children'][0]['child']['type']);

        $this->assertSame('floatingActionButton', $json['floatingActionButton']['type']);
        $this->assertSame('showModalBottomSheet', $json['floatingActionButton']['onPressed']['actionType']);
        $this->assertTrue($json['floatingActionButton']['onPressed']['isScrollControlled']);
        $this->assertSame('Alta', $json['floatingActionButton']['onPressed']['widget']['data']);
    }
}
