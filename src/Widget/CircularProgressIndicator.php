<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class CircularProgressIndicator extends Widget
{
    protected function typeValue(): string
    {
        return 'circularProgressIndicator';
    }

    public static function make(): self
    {
        return new self();
    }
}
