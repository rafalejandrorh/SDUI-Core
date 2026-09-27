<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class SduiReload extends Action
{
    protected function typeValue(): string
    {
        return 'sduiReload';
    }

    public static function make(?string $screen = null): self
    {
        $action = new self();
        if ($screen !== null && $screen !== '') {
            $action->put('screen', $screen);
        }

        return $action;
    }
}
