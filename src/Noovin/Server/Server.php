<?php

namespace Noovin\Server;

use Noovin\Http\HttpMethod;
use Noovin\Http\Response;

interface Server
{
    public function requestUri(): string;

    public function requestMethod(): HttpMethod;

    public function requestBody(): array;

    public function queryParams(): array;

    public function sendResponse(Response $response): void;
}
