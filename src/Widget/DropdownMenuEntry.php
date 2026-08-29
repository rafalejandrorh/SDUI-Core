<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class DropdownMenuEntry implements \JsonSerializable
{
    /** @var array<string, mixed> */
    private array $data = [];

    public static function make(mixed $value, string $label): self
    {
        return (new self())
            ->put('value', $value)
            ->put('label', $label);
    }

    public function enabled(bool $enabled): self
    {
        return $this->put('enabled', $enabled);
    }

    public function leadingIcon(mixed $icon): self
    {
        return $this->put('leadingIcon', $icon);
    }

    public function trailingIcon(mixed $icon): self
    {
        return $this->put('trailingIcon', $icon);
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
