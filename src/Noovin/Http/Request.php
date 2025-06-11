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
     * @var Route Route matched for this request.
     */
    protected Route $route;

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
     * Get POST data.
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
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
     * Get all query parameters.
     *
     * @return array
     */
    public function query(): array
    {
        return $this->query;
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
