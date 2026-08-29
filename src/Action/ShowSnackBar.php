<?php

declare(strict_types=1);

namespace Stac\Action;

final class ShowSnackBar extends Action
{
    protected function typeValue(): string
    {
        return 'showSnackBar';
    }

    public static function make(mixed $content = null): self
    {
        $action = new self();
        if ($content !== null) {
            $action->content($content);
        }

        return $action;
    }

    public function content(mixed $content): self
    {
        return $this->put('content', $content);
    }

    public function backgroundColor(string $color): self
    {
        return $this->put('backgroundColor', $color);
    }

    public function behavior(string $behavior): self
    {
        return $this->put('behavior', $behavior);
    }

    /** @param array<string, mixed> $action */
    public function action(array $action): self
    {
        return $this->put('action', $action);
    }
}
