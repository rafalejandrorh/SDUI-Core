<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class OutlinedButton extends Button
{
    protected function typeValue(): string
    {
        return 'outlinedButton';
    }

    public static function make(mixed $child = null, mixed $onPressed = null): self
    {
        $widget = new self();
        if ($child !== null) {
            $widget->child($child);
        }
        if ($onPressed !== null) {
            $widget->onPressed($onPressed);
        }

        return $widget;
    }
}
