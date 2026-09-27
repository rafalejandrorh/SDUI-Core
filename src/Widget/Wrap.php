<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Wrap extends Widget
{
    protected function typeValue(): string
    {
        return 'wrap';
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

    public function spacing(int|float $spacing): self
    {
        return $this->put('spacing', $spacing);
    }

    public function runSpacing(int|float $runSpacing): self
    {
        return $this->put('runSpacing', $runSpacing);
    }
}
