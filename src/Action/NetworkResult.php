<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class NetworkResult implements \JsonSerializable
{
    public function __construct(
        private int $statusCode,
        private mixed $action,
    ) {
    }

    public static function make(int $statusCode, mixed $action): self
    {
        return new self($statusCode, $action);
    }

    public function jsonSerialize(): array
    {
        return [
            'statusCode' => $this->statusCode,
            'action' => $this->action,
        ];
    }
}
