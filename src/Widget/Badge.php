<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Badge extends Widget
{
    protected function typeValue(): string
    {
        return 'badge';
    }

    public static function make(mixed $child = null): self
    {
        $widget = new self();
        if ($child !== null) {
            $widget->child($child);
        }

        return $widget;
    }

    public function label(mixed $label): self
    {
        return $this->put('label', $label);
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }
}
