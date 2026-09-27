<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class NavigationDestination implements \JsonSerializable
{
    /** @var array<string, mixed> */
    private array $data = [];

    public static function make(mixed $icon, string $label): self
    {
        return (new self())
            ->put('icon', $icon)
            ->put('label', $label);
    }

    public function selectedIcon(mixed $icon): self
    {
        return $this->put('selectedIcon', $icon);
    }

    public function tooltip(string $tooltip): self
    {
        return $this->put('tooltip', $tooltip);
    }

    public function enabled(bool $enabled): self
    {
        return $this->put('enabled', $enabled);
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
