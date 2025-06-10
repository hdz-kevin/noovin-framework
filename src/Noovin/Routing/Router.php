<?php

namespace Noovin\Routing;

use Noovin\Http\HttpMethod;
use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;

/**
 * Router class for handling HTTP routes.
 */
class Router
{
    /**
     * @var array<string, Route[]> HTTP routes indexed by HTTP method.
     */
    protected array $routes = [];

    /**
     * Create a new Router instance.
     */
    public function __construct()
    {
        $this->routes = [];

        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    /**
     * Resolve the route for the given request.
     *
     * @param Request $request
     * @return Route
     * @throws HttpNotFoundException
     */
    public function resolve(Request $request): Route
    {
        foreach ($this->routes[$request->method()->value] as $route) {
            if ($route->matches($request->uri())) {
                return $route;
            }
        }

        throw new HttpNotFoundException();
    }

    /**
     * Register a new route with the given `$method`, `$uri`, and `$action`.
     *
     * @param HttpMethod $method
     * @param string $uri
     * @param \Closure $action
     * @return void
     */
    protected function registerRoute(HttpMethod $method, string $uri, \Closure $action): void
    {
        $this->routes[$method->value][] = new Route($uri, $action);
    }

    /**
     * Register a GET route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return void
     */
    public function get(string $uri, \Closure $action): void
    {
        $this->registerRoute(HttpMethod::GET, $uri, $action);
    }

    /**
     * Register a POST route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return void
     */
    public function post(string $uri, \Closure $action): void
    {
        $this->registerRoute(HttpMethod::POST, $uri, $action);
    }

    /**
     * Register a PUT route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return void
     */
    public function put(string $uri, \Closure $action): void
    {
        $this->registerRoute(HttpMethod::PUT, $uri, $action);
    }

    /**
     * Register a PATCH route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return void
     */
    public function patch(string $uri, \Closure $action): void
    {
        $this->registerRoute(HttpMethod::PATCH, $uri, $action);
    }

    /**
     * Register a DELETE route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return void
     */
    public function delete(string $uri, \Closure $action): void
    {
        $this->registerRoute(HttpMethod::DELETE, $uri, $action);
    }
}
