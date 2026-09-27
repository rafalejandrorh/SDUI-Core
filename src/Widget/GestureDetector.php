<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class GestureDetector extends Widget
{
    protected function typeValue(): string
    {
        return 'gestureDetector';
    }

    public static function make(mixed $child = null, mixed $onTap = null): self
    {
        $widget = new self();
        if ($child !== null) {
            $widget->child($child);
        }
        if ($onTap !== null) {
            $widget->onTap($onTap);
        }

        return $widget;
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function onTap(mixed $action): self
    {
        return $this->put('onTap', $action);
    }
}
