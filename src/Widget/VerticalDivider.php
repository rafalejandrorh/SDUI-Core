<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class VerticalDivider extends Widget
{
    protected function typeValue(): string
    {
        return 'verticalDivider';
    }

    public static function make(): self
    {
        return new self();
    }

    public function width(int|float $width): self
    {
        return $this->put('width', $width);
    }

    public function thickness(int|float $thickness): self
    {
        return $this->put('thickness', $thickness);
    }

    public function color(string $color): self
    {
        return $this->put('color', $color);
    }
}
