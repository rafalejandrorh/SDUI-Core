<?php

declare(strict_types=1);

namespace Stac\Action;

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
