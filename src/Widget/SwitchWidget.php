<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class SwitchWidget extends Widget
{
    protected function typeValue(): string
    {
        return 'switch';
    }

    public static function make(?bool $value = null): self
    {
        $widget = new self();
        if ($value !== null) {
            $widget->value($value);
        }

        return $widget;
    }

    public function value(bool $value): self
    {
        return $this->put('value', $value);
    }

    public function onChanged(mixed $action): self
    {
        return $this->put('onChanged', $action);
    }
}
