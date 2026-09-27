<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class RefreshIndicator extends Widget
{
    protected function typeValue(): string
    {
        return 'refreshIndicator';
    }

    public static function make(mixed $child, mixed $onRefresh): self
    {
        return (new self())->child($child)->onRefresh($onRefresh);
    }

    public function child(mixed $child): self
    {
        return $this->put('child', $child);
    }

    public function onRefresh(mixed $action): self
    {
        return $this->put('onRefresh', $action);
    }
}
