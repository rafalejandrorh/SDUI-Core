<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Flexible extends Widget
{
    protected function typeValue(): string
    {
        return 'flexible';
    }

    public static function make(mixed $child, ?int $flex = null): self
    {
        $widget = (new self())->child($child);
        if ($flex !== null) {
            $widget->flex($flex);
        }

        return $widget;
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function flex(int $flex): self
    {
        return $this->put('flex', $flex);
    }
}
