<?php

namespace Noovin;

class Router {
    /** @property array<string, array<string, \Closure>> $routes */
    protected array $routes = [];

    public function __construct()
    {
        $this->routes = [];

        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    public function resolve(string $uri, HttpMethod $method): callable
    {
        $action = $this->routes[$method->value][$uri] ?? null;

        if (is_null($action)) {
            throw new HttpNotFoundException();
        }

        return $action;
    }

    public function get(string $uri, callable $action): void
    {
        $this->routes[HttpMethod::GET->value][$uri] = $action;
    }

    public function post(string $uri, callable $action): void
    {
        $this->routes[HttpMethod::POST->value][$uri] = $action;
    }

    public function put(string $uri, callable $action): void
    {
        $this->routes[HttpMethod::PUT->value][$uri] = $action;
    }

    public function patch(string $uri, callable $action): void
    {
        $this->routes[HttpMethod::PATCH->value][$uri] = $action;
    }

    public function delete(string $uri, callable $action): void
    {
        $this->routes[HttpMethod::DELETE->value][$uri] = $action;
    }
}
