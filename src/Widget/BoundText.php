<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class BoundText extends Widget
{
    protected function typeValue(): string
    {
        return 'boundText';
    }

    public static function make(string $valueKey): self
    {
        return (new self())->put('valueKey', $valueKey);
    }

    public function placeholder(string $placeholder): self
    {
        return $this->put('placeholder', $placeholder);
    }

    /** @param array<string, mixed> $style */
    public function style(array $style): self
    {
        return $this->put('style', $style);
    }
}
