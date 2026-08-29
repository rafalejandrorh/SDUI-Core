<?php

declare(strict_types=1);

namespace Stac\Action;

use Stac\Element;

abstract class Action extends Element
{
    protected function typeKey(): string
    {
        return 'actionType';
    }
}
