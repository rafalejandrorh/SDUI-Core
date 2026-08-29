<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class SduiLogout extends Action
{
    protected function typeValue(): string
    {
        return 'sduiLogout';
    }

    public static function make(): self
    {
        return new self();
    }
}
