<?php

declare(strict_types=1);

namespace Stac\Widget;

final class TextFormField extends Widget
{
    protected function typeValue(): string
    {
        return 'textFormField';
    }

    public static function make(string $id): self
    {
        return (new self())->put('id', $id);
    }

    /** @param array<string, mixed> $decoration */
    public function decoration(array $decoration): self
    {
        return $this->put('decoration', $decoration);
    }

    /** @param list<array<string, mixed>> $rules */
    public function validatorRules(array $rules): self
    {
        return $this->put('validatorRules', $rules);
    }

    public function keyboardType(string $keyboardType): self
    {
        return $this->put('keyboardType', $keyboardType);
    }

    public function obscureText(bool $obscureText = true): self
    {
        return $this->put('obscureText', $obscureText);
    }

    public function initialValue(string $value): self
    {
        return $this->put('initialValue', $value);
    }

    public function autovalidateMode(string $mode): self
    {
        return $this->put('autovalidateMode', $mode);
    }

    public function hintText(string $hintText): self
    {
        return $this->put('hintText', $hintText);
    }

    public function maxLines(int $maxLines): self
    {
        return $this->put('maxLines', $maxLines);
    }

    public function enabled(bool $enabled): self
    {
        return $this->put('enabled', $enabled);
    }
}
