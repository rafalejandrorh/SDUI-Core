<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class FloatingActionButton extends Widget
{
    protected function typeValue(): string
    {
        return 'floatingActionButton';
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

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function onPressed(mixed $action): self
    {
        return $this->put('onPressed', $action);
    }

    public function tooltip(string $tooltip): self
    {
        return $this->put('tooltip', $tooltip);
    }
}
