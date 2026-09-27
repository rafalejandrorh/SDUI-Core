<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class SingleChildScrollView extends Widget
{
    protected function typeValue(): string
    {
        return 'singleChildScrollView';
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

    /** @param array<string, mixed>|int|float $padding */
    public function padding(array|int|float $padding): self
    {
        return $this->put('padding', $padding);
    }
}
