<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Padding extends Widget
{
    protected function typeValue(): string
    {
        return 'padding';
    }

    public static function make(array|int|float $padding): self
    {
        return (new self())->put('padding', $padding);
    }

    public static function all(int|float $value): self
    {
        return self::make([
            'left' => $value,
            'top' => $value,
            'right' => $value,
            'bottom' => $value,
        ]);
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }
}
