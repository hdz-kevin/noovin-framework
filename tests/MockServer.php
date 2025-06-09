<?php

namespace Noovin\Tests;

use Noovin\HttpMethod;

class MockServer implements \Noovin\Server
{
    public string $uri;
    public HttpMethod $method;

    public function __construct(string $uri, HttpMethod $method)
    {
        $this->uri = $uri;
        $this->method = $method;
    }

    public function requestUri(): string
    {
        return $this->uri;
    }

    public function requestMethod(): HttpMethod
    {
        return $this->method;
    }

    public function requestBody(): array
    {
        return [];
    }

    public function queryParams(): array
    {
        return [];
    }
}
