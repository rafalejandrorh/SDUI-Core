<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Chip extends Widget
{
    protected function typeValue(): string
    {
        return 'chip';
    }

    public static function make(mixed $label): self
    {
        return (new self())->label($label);
    }

    public function label(mixed $label): self
    {
        return $this->put('label', $label);
    }

    public function backgroundColor(string $color): self
    {
        return $this->put('backgroundColor', $color);
    }
}
