<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class ListTile extends Widget
{
    protected function typeValue(): string
    {
        return 'listTile';
    }

    public static function make(): self
    {
        return new self();
    }

    public function leading(mixed $leading): self
    {
        return $this->put('leading', $leading);
    }

    public function title(mixed $title): self
    {
        return $this->put('title', $title);
    }

    public function subtitle(mixed $subtitle): self
    {
        return $this->put('subtitle', $subtitle);
    }

    public function trailing(mixed $trailing): self
    {
        return $this->put('trailing', $trailing);
    }

    public function onTap(mixed $action): self
    {
        return $this->put('onTap', $action);
    }
}
