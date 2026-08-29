<?php

declare(strict_types=1);

namespace Stac\Widget;

final class ListView extends Widget
{
    protected function typeValue(): string
    {
        return 'listView';
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

    public function shrinkWrap(bool $shrinkWrap = true): self
    {
        return $this->put('shrinkWrap', $shrinkWrap);
    }

    public function padding(array|int|float $padding): self
    {
        return $this->put('padding', $padding);
    }

    public function separator(mixed $separator): self
    {
        return $this->put('separator', $separator);
    }

    public function physics(string $physics): self
    {
        return $this->put('physics', $physics);
    }
}
