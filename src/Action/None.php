<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class None extends Action
{
    protected function typeValue(): string
    {
        return 'none';
    }

    public static function make(): self
    {
        return new self();
    }
}
