<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class ValidateForm extends Action
{
    protected function typeValue(): string
    {
        return 'validateForm';
    }

    public static function make(mixed $isValid = null, mixed $isNotValid = null): self
    {
        $action = new self();
        if ($isValid !== null) {
            $action->isValid($isValid);
        }
        if ($isNotValid !== null) {
            $action->isNotValid($isNotValid);
        }

        return $action;
    }

    public function isValid(mixed $action): self
    {
        return $this->put('isValid', $action);
    }

    public function isNotValid(mixed $action): self
    {
        return $this->put('isNotValid', $action);
    }
}
