<?php

namespace Noovin\Http;

use Noovin\Server\Server;

class Request
{
    /**
     * @var string URI requested by the client.
     */
    protected string $uri;

    /**
     * @var HttpMethod HTTP method used for this request.
     */
    protected HttpMethod $method;

    /**
     * @var array POST data.
     */
    protected array $data;

    /**
     * @var array Query parameters.
     */
    protected array $query;

    /**
     * Create a new request instance.
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->uri = $server->requestUri();
        $this->method = $server->requestMethod();
        $this->data = $server->postData();
        $this->query = $server->queryParams();
    }

    /**
     * Get the request URI.
     *
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Get the request HTTP method.
     *
     * @return HttpMethod
     */
    public function method(): HttpMethod
    {
        return $this->method;
    }

    /**
     * Get POST data.
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Get query parameters.
     *
     * @return array
     */
    public function query(): array
    {
        return $this->query;
    }
}
