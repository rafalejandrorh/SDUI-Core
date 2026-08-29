<?php

declare(strict_types=1);

namespace Stac\Widget;

final class Scaffold extends Widget
{
    protected function typeValue(): string
    {
        return 'scaffold';
    }

    public static function make(): self
    {
        return new self();
    }

    public function appBar(mixed $appBar): self
    {
        return $this->put('appBar', $appBar);
    }

    public function body(mixed $body): self
    {
        return $this->put('body', $body);
    }

    public function backgroundColor(string $color): self
    {
        return $this->put('backgroundColor', $color);
    }

    public function floatingActionButton(mixed $button): self
    {
        return $this->put('floatingActionButton', $button);
    }

    public function drawer(mixed $drawer): self
    {
        return $this->put('drawer', $drawer);
    }

    public function bottomNavigationBar(mixed $bar): self
    {
        return $this->put('bottomNavigationBar', $bar);
    }
}
