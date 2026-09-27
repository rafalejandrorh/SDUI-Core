<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class RadioGroup extends Widget
{
    protected function typeValue(): string
    {
        return 'radioGroup';
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

    public function groupValue(mixed $value): self
    {
        return $this->put('groupValue', $value);
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function onChanged(mixed $action): self
    {
        return $this->put('onChanged', $action);
    }
}
