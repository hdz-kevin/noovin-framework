<?php

namespace Noovin;

interface Server
{
    public function requestUri(): string;

    public function requestMethod(): HttpMethod;

    public function requestBody(): array;

    public function queryParams(): array;
}
