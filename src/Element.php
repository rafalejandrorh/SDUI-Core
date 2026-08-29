<?php

declare(strict_types=1);

namespace Stac;

abstract class Element implements \JsonSerializable
{
    /** @var array<string, mixed> */
    private array $attributes = [];

    abstract protected function typeKey(): string;

    abstract protected function typeValue(): string;

    public function extra(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        $payload = [$this->typeKey() => $this->typeValue()];

        foreach ($this->attributes as $key => $value) {
            if ($value === null) {
                continue;
            }

            $payload[$key] = $value;
        }

        return $payload;
    }

    protected function put(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param  list<mixed>  $items
     * @return list<mixed>
     */
    protected static function listOf(array $items): array
    {
        if (count($items) === 1 && is_array($items[0]) && array_is_list($items[0])) {
            return $items[0];
        }

        return $items;
    }
}
