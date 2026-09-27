<?php

declare(strict_types=1);

namespace Sdui\Core\Widget;

final class SelectableText extends Widget
{
    protected function typeValue(): string
    {
        return 'selectableText';
    }

    public static function make(string $data): self
    {
        return (new self())->put('data', $data);
    }

    /** @param array<string, mixed> $style */
    public function style(array $style): self
    {
        return $this->put('style', $style);
    }
}
