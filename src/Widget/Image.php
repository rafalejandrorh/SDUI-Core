<?php

declare(strict_types=1);

namespace Stac\Widget;

final class Image extends Widget
{
    protected function typeValue(): string
    {
        return 'image';
    }

    public static function make(string $src): self
    {
        return (new self())->put('src', $src);
    }

    public static function network(string $url): self
    {
        return self::make($url)->imageType('network');
    }

    public static function asset(string $path): self
    {
        return self::make($path)->imageType('asset');
    }

    public function imageType(string $imageType): self
    {
        return $this->put('imageType', $imageType);
    }

    public function width(int|float $width): self
    {
        return $this->put('width', $width);
    }

    public function height(int|float $height): self
    {
        return $this->put('height', $height);
    }

    public function fit(string $fit): self
    {
        return $this->put('fit', $fit);
    }

    public function alignment(string $alignment): self
    {
        return $this->put('alignment', $alignment);
    }
}
