<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Radio extends Widget
{
    protected function typeValue(): string
    {
        return 'radio';
    }

    public static function make(mixed $value): self
    {
        return (new self())->value($value);
    }

    public function value(mixed $value): self
    {
        return $this->put('value', $value);
    }

    public function onChanged(mixed $action): self
    {
        return $this->put('onChanged', $action);
    }
}
