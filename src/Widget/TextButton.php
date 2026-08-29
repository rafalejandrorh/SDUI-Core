<?php

declare(strict_types=1);

namespace Stac\Widget;

final class TextButton extends Button
{
    protected function typeValue(): string
    {
        return 'textButton';
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
