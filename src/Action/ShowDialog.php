<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class ShowDialog extends Action
{
    protected function typeValue(): string
    {
        return 'showDialog';
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

    public function request(mixed $request): self
    {
        return $this->put('request', $request);
    }

    public function assetPath(string $path): self
    {
        return $this->put('assetPath', $path);
    }

    public function barrierDismissible(bool $dismissible): self
    {
        return $this->put('barrierDismissible', $dismissible);
    }
}
