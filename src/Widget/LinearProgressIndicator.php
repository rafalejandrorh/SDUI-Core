<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class LinearProgressIndicator extends Widget
{
    protected function typeValue(): string
    {
        return 'linearProgressIndicator';
    }

    public static function make(): self
    {
        return new self();
    }

    public function value(int|float $value): self
    {
        return $this->put('value', $value);
    }
}
