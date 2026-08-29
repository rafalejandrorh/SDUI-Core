<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class ElevatedButton extends Button
{
    protected function typeValue(): string
    {
        return 'elevatedButton';
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
