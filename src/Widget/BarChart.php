<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class BarChart extends Widget
{
    protected function typeValue(): string
    {
        return 'barChart';
    }

    public static function make(mixed ...$bars): self
    {
        $widget = new self();
        if ($bars !== []) {
            $widget->bars(...$bars);
        }

        return $widget;
    }

    public function bars(mixed ...$bars): self
    {
        return $this->put('bars', self::listOf($bars));
    }

    public function emptyLabel(string $label): self
    {
        return $this->put('emptyLabel', $label);
    }
}
