<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Stack extends Widget
{
    protected function typeValue(): string
    {
        return 'stack';
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

    public function alignment(string $alignment): self
    {
        return $this->put('alignment', $alignment);
    }
}
