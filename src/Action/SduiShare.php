<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class SduiShare extends Action
{
    protected function typeValue(): string
    {
        return 'sduiShare';
    }

    public static function make(string $text): self
    {
        return (new self())->put('text', $text);
    }
}
