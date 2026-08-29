<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Form extends Widget
{
    protected function typeValue(): string
    {
        return 'form';
    }

    public static function make(mixed $child = null): self
    {
        $widget = new self();
        if ($child !== null) {
            $widget->child($child);
        }

        return $widget;
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function autovalidateMode(string $mode): self
    {
        return $this->put('autovalidateMode', $mode);
    }
}
