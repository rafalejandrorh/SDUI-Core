<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Icon extends Widget
{
    protected function typeValue(): string
    {
        return 'icon';
    }

    public static function make(string $icon): self
    {
        return (new self())->put('icon', $icon);
    }

    public function iconType(string $iconType): self
    {
        return $this->put('iconType', $iconType);
    }

    public function size(int|float $size): self
    {
        return $this->put('size', $size);
    }

    public function color(string $color): self
    {
        return $this->put('color', $color);
    }
}
