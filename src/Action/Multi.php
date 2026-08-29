<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class Multi extends Action
{
    protected function typeValue(): string
    {
        return 'multiAction';
    }

    public static function make(mixed ...$actions): self
    {
        $action = new self();
        if ($actions !== []) {
            $action->actions(...$actions);
        }

        return $action;
    }

    public function actions(mixed ...$actions): self
    {
        return $this->put('actions', self::listOf($actions));
    }

    public function sync(bool $sync = true): self
    {
        return $this->put('sync', $sync);
    }
}
