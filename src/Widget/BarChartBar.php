<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class BarChartBar implements \JsonSerializable
{
    /** @var array<string, mixed> */
    private array $data = [];

    public static function make(string $label, int|float $value): self
    {
        return (new self())
            ->put('label', $label)
            ->put('value', $value);
    }

    public function color(string $color): self
    {
        return $this->put('color', $color);
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }

    private function put(string $key, mixed $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }
}
