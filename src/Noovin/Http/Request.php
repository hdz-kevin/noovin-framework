<?php

namespace Noovin\Http;

use Noovin\Server\Server;

class Request {
    /**
     * @property string $uri
     * @property HttpMethod $method
     * @property array $body
     * @property array $query
     */
    protected string $uri;
    protected HttpMethod $method;
    protected array $body;
    protected array $query;

    public function __construct(Server $server) {
        $this->uri = $server->requestUri();
        $this->method = $server->requestMethod();
        $this->body = $server->requestBody();
        $this->query = $server->queryParams();
    }

    public function uri(): string {
        return $this->uri;
    }

    public function method(): HttpMethod {
        return $this->method;
    }
}
