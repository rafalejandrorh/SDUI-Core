<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class Spacer extends Widget
{
    protected function typeValue(): string
    {
        return 'spacer';
    }

    public static function make(?int $flex = null): self
    {
        $widget = new self();
        if ($flex !== null) {
            $widget->flex($flex);
        }

        return $widget;
    }

    public function flex(int $flex): self
    {
        return $this->put('flex', $flex);
    }
}
