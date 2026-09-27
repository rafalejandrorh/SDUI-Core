<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class NavigationBar extends Widget
{
    protected function typeValue(): string
    {
        return 'navigationBar';
    }

    public static function make(mixed ...$destinations): self
    {
        return (new self())->destinations(...$destinations);
    }

    public function destinations(mixed ...$destinations): self
    {
        return $this->put('destinations', self::listOf($destinations));
    }

    public function selectedIndex(int $index): self
    {
        return $this->put('selectedIndex', $index);
    }
}
