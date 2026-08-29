<?php

declare(strict_types=1);

namespace Stac\Widget;

final class AppBar extends Widget
{
    protected function typeValue(): string
    {
        return 'appBar';
    }

    public static function make(): self
    {
        return new self();
    }

    public function title(mixed $title): self
    {
        return $this->put('title', $title);
    }

    public function leading(mixed $leading): self
    {
        return $this->put('leading', $leading);
    }

    /** @param list<mixed> $actions */
    public function actions(array $actions): self
    {
        return $this->put('actions', $actions);
    }

    public function backgroundColor(string $color): self
    {
        return $this->put('backgroundColor', $color);
    }

    public function centerTitle(bool $centerTitle = true): self
    {
        return $this->put('centerTitle', $centerTitle);
    }
}
