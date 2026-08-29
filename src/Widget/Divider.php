<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Divider extends Widget
{
    protected function typeValue(): string
    {
        return 'divider';
    }

    public static function make(): self
    {
        return new self();
    }

    public function height(int|float $height): self
    {
        return $this->put('height', $height);
    }

    public function thickness(int|float $thickness): self
    {
        return $this->put('thickness', $thickness);
    }

    public function color(string $color): self
    {
        return $this->put('color', $color);
    }

    public function indent(int|float $indent): self
    {
        return $this->put('indent', $indent);
    }
}
