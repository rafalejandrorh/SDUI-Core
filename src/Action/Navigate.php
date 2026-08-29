<?php

declare(strict_types=1);

namespace Stac\Action;

final class Navigate extends Action
{
    protected function typeValue(): string
    {
        return 'navigate';
    }

    public static function make(): self
    {
        return new self();
    }

    public static function pop(): self
    {
        return self::make()->navigationStyle('pop');
    }

    public function navigationStyle(string $style): self
    {
        return $this->put('navigationStyle', $style);
    }

    public function routeName(string $routeName): self
    {
        return $this->put('routeName', $routeName);
    }

    public function request(mixed $request): self
    {
        return $this->put('request', $request);
    }

    public function widgetJson(mixed $widget): self
    {
        return $this->put('widgetJson', $widget);
    }

    public function assetPath(string $path): self
    {
        return $this->put('assetPath', $path);
    }

    /** @param array<string, mixed> $result */
    public function result(array $result): self
    {
        return $this->put('result', $result);
    }

    /** @param array<string, mixed> $arguments */
    public function arguments(array $arguments): self
    {
        return $this->put('arguments', $arguments);
    }
}
