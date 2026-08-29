<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Container extends Widget
{
    protected function typeValue(): string
    {
        return 'container';
    }

    public static function make(): self
    {
        return new self();
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function width(int|float $width): self
    {
        return $this->put('width', $width);
    }

    public function height(int|float $height): self
    {
        return $this->put('height', $height);
    }

    public function color(string $color): self
    {
        return $this->put('color', $color);
    }

    public function alignment(string $alignment): self
    {
        return $this->put('alignment', $alignment);
    }

    public function padding(array|int|float $padding): self
    {
        return $this->put('padding', $padding);
    }

    public function margin(array|int|float $margin): self
    {
        return $this->put('margin', $margin);
    }

    public function decoration(array $decoration): self
    {
        return $this->put('decoration', $decoration);
    }

    public function clipBehavior(string $clipBehavior): self
    {
        return $this->put('clipBehavior', $clipBehavior);
    }
}
