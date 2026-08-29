<?php

declare(strict_types=1);

namespace Stac\Widget;

final class CheckBox extends Widget
{
    protected function typeValue(): string
    {
        return 'checkBox';
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

    public function value(bool $value): self
    {
        return $this->put('value', $value);
    }

    public function tristate(bool $tristate = true): self
    {
        return $this->put('tristate', $tristate);
    }

    public function onChanged(mixed $action): self
    {
        return $this->put('onChanged', $action);
    }

    public function activeColor(string $color): self
    {
        return $this->put('activeColor', $color);
    }
}
