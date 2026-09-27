<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class TableColumnWidth implements \JsonSerializable
{
    private function __construct(
        private string $type,
        private int|float $value,
    ) {
    }

    public static function flex(int|float $value): self
    {
        return new self('flexColumnWidth', $value);
    }

    public static function fixed(int|float $value): self
    {
        return new self('fixedColumnWidth', $value);
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'value' => $this->value,
        ];
    }
}
