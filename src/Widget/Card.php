<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Card extends Widget
{
    protected function typeValue(): string
    {
        return 'card';
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

    public function color(string $color): self
    {
        return $this->put('color', $color);
    }

    public function elevation(int|float $elevation): self
    {
        return $this->put('elevation', $elevation);
    }

    /** @param array<string, mixed>|int|float $margin */
    public function margin(array|int|float $margin): self
    {
        return $this->put('margin', $margin);
    }
}
