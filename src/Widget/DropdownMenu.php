<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class DropdownMenu extends Widget
{
    protected function typeValue(): string
    {
        return 'dropdownMenu';
    }

    public static function make(?string $id = null): self
    {
        $widget = new self();
        if ($id !== null) {
            $widget->id($id);
        }

        return $widget;
    }

    public function id(string $id): self
    {
        return $this->put('id', $id);
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
