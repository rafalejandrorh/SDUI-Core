<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class SizedBox extends Widget
{
    protected function typeValue(): string
    {
        return 'sizedBox';
    }

    public static function make(int|float|null $width = null, int|float|null $height = null): self
    {
        $widget = new self();
        if ($width !== null) {
            $widget->put('width', $width);
        }
        if ($height !== null) {
            $widget->put('height', $height);
        }

        return $widget;
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }
}
