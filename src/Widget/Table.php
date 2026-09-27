<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Table extends Widget
{
    protected function typeValue(): string
    {
        return 'table';
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

    /** @param array<int|string, mixed> $widths */
    public function columnWidths(array $widths): self
    {
        $map = new \stdClass();
        foreach ($widths as $index => $width) {
            $map->{(string) $index} = $width;
        }

        return $this->put('columnWidths', $map);
    }
}
