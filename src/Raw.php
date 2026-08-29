<?php

declare(strict_types=1);

namespace Stac;

/**
 * Escape hatch for widget or action JSON that has no typed builder yet.
 */
final class Raw implements \JsonSerializable
{
    /** @param array<string, mixed> $data */
    public function __construct(private array $data)
    {
    }

    /** @param array<string, mixed> $data */
    public static function make(array $data): self
    {
        return new self($data);
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
