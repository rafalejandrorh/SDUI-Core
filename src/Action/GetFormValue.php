<?php

declare(strict_types=1);

namespace Stac\Action;

final class GetFormValue extends Action
{
    protected function typeValue(): string
    {
        return 'getFormValue';
    }

    public static function make(string $id): self
    {
        return (new self())->put('id', $id);
    }
}
