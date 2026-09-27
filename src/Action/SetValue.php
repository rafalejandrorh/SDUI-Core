<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class SetValue extends Action
{
    protected function typeValue(): string
    {
        return 'setValue';
    }

    public static function make(mixed ...$values): self
    {
        $action = new self();
        if ($values !== []) {
            $action->values(...$values);
        }

        return $action;
    }

    public function values(mixed ...$values): self
    {
        return $this->put('values', self::listOf($values));
    }

    public function action(mixed $action): self
    {
        return $this->put('action', $action);
    }
}
