<?php

declare(strict_types=1);

namespace Stac\Widget;

final class Text extends Widget
{
    protected function typeValue(): string
    {
        return 'text';
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

    public function textAlign(string $align): self
    {
        return $this->put('textAlign', $align);
    }

    public function maxLines(int $maxLines): self
    {
        return $this->put('maxLines', $maxLines);
    }

    public function overflow(string $overflow): self
    {
        return $this->put('overflow', $overflow);
    }
}
