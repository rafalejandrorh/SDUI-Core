<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

use Sdui\Core\Element;

abstract class Widget extends Element
{
    protected function typeKey(): string
    {
        return 'type';
    }
}
