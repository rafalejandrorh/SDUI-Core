<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class IconButton extends Widget
{
    protected function typeValue(): string
    {
        return 'iconButton';
    }

    public static function make(mixed $icon = null, mixed $onPressed = null): self
    {
        $widget = new self();
        if ($icon !== null) {
            $widget->icon($icon);
        }
        if ($onPressed !== null) {
            $widget->onPressed($onPressed);
        }

        return $widget;
    }

    public function icon(mixed $icon): self
    {
        return $this->put('icon', $icon);
    }

    public function onPressed(mixed $action): self
    {
        return $this->put('onPressed', $action);
    }

    public function iconSize(int|float $size): self
    {
        return $this->put('iconSize', $size);
    }

    public function tooltip(string $tooltip): self
    {
        return $this->put('tooltip', $tooltip);
    }
}
