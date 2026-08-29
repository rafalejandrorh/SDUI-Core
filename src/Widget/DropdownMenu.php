<?php

declare(strict_types=1);

namespace Stac\Widget;

final class DropdownMenu extends Widget
{
    protected function typeValue(): string
    {
        return 'dropdownMenu';
    }

    public static function make(): self
    {
        return new self();
    }

    /** @param list<mixed> $entries */
    public function dropdownMenuEntries(array $entries): self
    {
        return $this->put('dropdownMenuEntries', $entries);
    }

    public function initialSelection(mixed $value): self
    {
        return $this->put('initialSelection', $value);
    }

    public function label(mixed $label): self
    {
        return $this->put('label', $label);
    }

    public function hintText(string $hintText): self
    {
        return $this->put('hintText', $hintText);
    }

    public function width(int|float $width): self
    {
        return $this->put('width', $width);
    }

    public function enabled(bool $enabled): self
    {
        return $this->put('enabled', $enabled);
    }
}
