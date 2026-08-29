<?php

declare(strict_types=1);

namespace Sdui\Core\Action;

final class NetworkRequest extends Action
{
    protected function typeValue(): string
    {
        return 'networkRequest';
    }

    public static function make(string $url): self
    {
        return (new self())->put('url', $url);
    }

    public function method(string $method): self
    {
        return $this->put('method', $method);
    }

    /** @param array<string, mixed> $query */
    public function queryParameters(array $query): self
    {
        return $this->put('queryParameters', $query);
    }

    /** @param array<string, mixed> $headers */
    public function headers(array $headers): self
    {
        return $this->put('headers', $headers);
    }

    public function contentType(string $contentType): self
    {
        return $this->put('contentType', $contentType);
    }

    public function body(mixed $body): self
    {
        return $this->put('body', $body);
    }

    /** @param list<NetworkResult|array<string, mixed>> $results */
    public function results(array $results): self
    {
        return $this->put('results', $results);
    }
}
