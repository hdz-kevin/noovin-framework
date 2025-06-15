<?php

namespace Noovin\Http;

use Noovin\Routing\Route;

class Request
{
    /**
     * @var string URI requested by the client.
     */
    protected string $uri;

    /**
     * @var \Noovin\Routing\Route Route matched for this request.
     */
    protected Route $route;

    /**
     * @var HttpMethod HTTP method used for this request.
     */
    protected HttpMethod $method;

    /**
     * @var string[] HTTP headers.
     */
    protected array $headers = [];

    /**
     * @var array POST data.
     */
    protected array $data;

    /**
     * @var array Query parameters.
     */
    protected array $query;

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
     * Set request URI.
     *
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Get the route matched for this request.
     *
     * @return Route
     */
    public function route(): Route
    {
        return $this->route;
    }

    /**
     * Set route for this request.
     *
     * @param Route $route
     * @return self
     */
    public function setRoute(Route $route): self
    {
        $this->route = $route;
        return $this;
    }

    /**
     * Get request route parameters.
     * If a key is provided, returns the value for that key or null if it does not exist.
     *
     * @param string|null $key
     * @return array|string|null
     */
    public function parameters(?string $key = null): array|string|null
    {
        $params = $this->route->parseParameters($this->uri);

        return $key === null ? $params : ($params[$key] ?? null);
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
     * Set request HTTP method.
     *
     * @param HttpMethod $method
     * @return self
     */
    public function setMethod(HttpMethod $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get HTTP headers.
     * If a key is provided, returns the value for that key or null if it does not exist.
     *
     * @param string|null $key
     * @return array|string|null
     */
    public function headers(?string $key = null): array|string|null
    {
        return $key === null ? $this->headers : ($this->headers[strtolower($key)] ?? null);
    }

    /**
     * Set HTTP headers.
     *
     * @param array<string, string> $headers
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_map('strtolower', $headers);
        return $this;
    }

    /**
     * Get POST data.
     * If a key is provided, returns the value for that key or null if it does not exist.
     *
     * @param string|null $key
     * @return array|string|null
     */
    public function data(?string $key = null): array|string|null
    {
        return $key === null ? $this->data : ($this->data[$key] ?? null);
    }

    /**
     * Set POST data.
     *
     * @param array $data
     * @return self
     */
    public function setPostData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get query parameters.
     * If a key is provided, returns the value for that key or null if it does not exist.
     *
     * @param string|null $key
     * @return array|string|null
     */
    public function query(?string $key = null): array|string|null
    {
        return $key === null ? $this->query : ($this->query[$key] ?? null);
    }

    /**
     * Set query parameters.
     *
     * @param array $parameters
     * @return self
     */
    public function setQueryParameters(array $queryParameters): self
    {
        $this->query = $queryParameters;
        return $this;
    }
}
