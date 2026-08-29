<?php

declare(strict_types=1);

namespace Stac\Widget;

final class Row extends Widget
{
    protected function typeValue(): string
    {
        return 'row';
    }

    public static function make(mixed ...$children): self
    {
        $widget = new self();
        if ($children !== []) {
            $widget->children(...$children);
        }

        return $widget;
    }

    public function children(mixed ...$children): self
    {
        return $this->put('children', self::listOf($children));
    }

    public function mainAxisAlignment(string $alignment): self
    {
        return $this->put('mainAxisAlignment', $alignment);
    }

    public function crossAxisAlignment(string $alignment): self
    {
        return $this->put('crossAxisAlignment', $alignment);
    }

    public function mainAxisSize(string $size): self
    {
        return $this->put('mainAxisSize', $size);
    }

    public function spacing(float|int $spacing): self
    {
        return $this->put('spacing', $spacing);
    }
}
