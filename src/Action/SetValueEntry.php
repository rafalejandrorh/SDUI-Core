<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class SetValueEntry implements \JsonSerializable
{
    public function __construct(
        private string $key,
        private mixed $value,
    ) {
    }

    public static function make(string $key, mixed $value): self
    {
        return new self($key, $value);
    }

    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
