<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class ShowModalBottomSheet extends Action
{
    protected function typeValue(): string
    {
        return 'showModalBottomSheet';
    }

    public static function make(mixed $widget = null): self
    {
        $action = new self();
        if ($widget !== null) {
            $action->widget($widget);
        }

        return $action;
    }

    public function widget(mixed $widget): self
    {
        return $this->put('widget', $widget);
    }

    public function isScrollControlled(bool $scrollControlled = true): self
    {
        return $this->put('isScrollControlled', $scrollControlled);
    }
}
