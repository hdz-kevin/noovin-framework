<?php

namespace Noovin\Server;

use Noovin\Http\HttpMethod;
use Noovin\Http\Response;

class PhpNativeServer implements Server
{
    public function requestUri(): string
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function requestMethod(): HttpMethod
    {
        return HttpMethod::from($_SERVER["REQUEST_METHOD"]);
    }

    public function requestBody(): array
    {
        return $_POST;
    }

    public function queryParams(): array
    {
        return $_GET;
    }

    public function sendResponse(Response $response): void
    {
        // PHP sends Content-Type header by default, but it has to be removed if
        // the response has no content. Content-Type header can't be removed
        // unless it is set to some value before.
        header("Content-Type: None");
        header_remove("Content-Type");

        $response->prepare();

        http_response_code($response->status());

        foreach ($response->headers() as $header => $value) {
            header("$header: $value");
        }

        echo $response->content() ?? '';
    }
}
