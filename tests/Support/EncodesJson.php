<?php

declare(strict_types=1);

namespace Sdui\Core\Tests\Support;

trait EncodesJson
{
    /**
     * @return array<string, mixed>
     */
    protected function encode(\JsonSerializable $value): array
    {
        return json_decode(
            json_encode($value, JSON_THROW_ON_ERROR),
            true,
            flags: JSON_THROW_ON_ERROR,
        );
    }
}
