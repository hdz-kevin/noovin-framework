<?php

namespace Noovin\Server;

use Noovin\Http\HttpMethod;

interface Server
{
    public function requestUri(): string;

    public function requestMethod(): HttpMethod;

    public function requestBody(): array;

    public function queryParams(): array;
}
