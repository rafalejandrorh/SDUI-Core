<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class GridView extends Widget
{
    protected function typeValue(): string
    {
        return 'gridView';
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

    public function crossAxisCount(int $count): self
    {
        return $this->put('crossAxisCount', $count);
    }

    public function shrinkWrap(bool $shrinkWrap = true): self
    {
        return $this->put('shrinkWrap', $shrinkWrap);
    }
}
