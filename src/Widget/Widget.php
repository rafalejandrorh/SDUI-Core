<?php

declare(strict_types=1);

namespace Stac\Widget;

use Stac\Element;

abstract class Widget extends Element
{
    protected function typeKey(): string
    {
        return 'type';
    }
}
