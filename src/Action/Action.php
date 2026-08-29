<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

use Sdui\Core\Element;

abstract class Action extends Element
{
    protected function typeKey(): string
    {
        return 'actionType';
    }
}
