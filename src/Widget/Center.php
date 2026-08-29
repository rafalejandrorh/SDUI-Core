<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Center extends Widget
{
    protected function typeValue(): string
    {
        return 'center';
    }

    public static function make(mixed $child = null): self
    {
        $widget = new self();
        if ($child !== null) {
            $widget->child($child);
        }

        return $widget;
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }
}
