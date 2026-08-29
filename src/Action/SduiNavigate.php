<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class SduiNavigate extends Action
{
    protected function typeValue(): string
    {
        return 'sduiNavigate';
    }

    public static function make(string $screen, string $style = 'push'): self
    {
        $action = (new self())->put('screen', $screen);
        if ($style !== 'push') {
            $action->put('style', $style);
        }

        return $action;
    }

    public function style(string $style): self
    {
        return $this->put('style', $style);
    }
}
