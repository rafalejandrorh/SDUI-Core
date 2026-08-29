<?php

declare(strict_types=1);

namespace Stac\Widget;

abstract class Button extends Widget
{
    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function onPressed(mixed $action): self
    {
        return $this->put('onPressed', $action);
    }

    public function onLongPress(mixed $action): self
    {
        return $this->put('onLongPress', $action);
    }

    /** @param array<string, mixed> $style */
    public function style(array $style): self
    {
        return $this->put('style', $style);
    }
}
