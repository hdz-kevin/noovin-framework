<?php

namespace Noovin\Routing;

use Noovin\Http\HttpMethod;
use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;
use Noovin\Http\Response;

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
     * @param Request $req
     * @return Route
     * @throws HttpNotFoundException
     */
    public function resolveRoute(Request $req): Route
    {
        foreach ($this->routes[$req->method()->value] as $route) {
            if ($route->matches($req->uri())) {
                return $route;
            }
        }

        throw new HttpNotFoundException();
    }

    public function resolve(Request $req): Response
    {
        $route = $this->resolveRoute($req);
        $req->setRoute($route);
        $action = $route->action();

        if ($route->hasMiddlewares()) {
            return $this->runMiddlewares($req, $route->middlewares(), $action);
        }

        return $action($req);
    }

    /**
     * Run the middleware stack.
     *
     * @param Request $req
     * @param \Noovin\Http\Middlewares\Middleware[] $middlewares
     * @param \Closure $target
     * @return Response
     */
    protected function runMiddlewares(Request $req, array $middlewares, \Closure $target): Response
    {
        if (count($middlewares) == 0) {
            return $target($req);
        }

        return $middlewares[0]->handle(
            $req,
            fn (Request $request) => $this->runMiddlewares($request, array_slice($middlewares, 1), $target)
        );
    }

    /**
     * Register a new route with the given `$method`, `$uri`, and `$action`.
     *
     * @param HttpMethod $method
     * @param string $uri
     * @param \Closure $action
     * @return Route
     */
    protected function registerRoute(HttpMethod $method, string $uri, \Closure $action): Route
    {
        $route = new Route($uri, $action);
        $this->routes[$method->value][] = $route;

        return $route;
    }

    /**
     * Register a GET route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return Route
     */
    public function get(string $uri, \Closure $action): Route
    {
        return $this->registerRoute(HttpMethod::GET, $uri, $action);
    }

    /**
     * Register a POST route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return Route
     */
    public function post(string $uri, \Closure $action): Route
    {
        return $this->registerRoute(HttpMethod::POST, $uri, $action);
    }

    /**
     * Register a PUT route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return Route
     */
    public function put(string $uri, \Closure $action): Route
    {
        return $this->registerRoute(HttpMethod::PUT, $uri, $action);
    }

    /**
     * Register a PATCH route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return Route
     */
    public function patch(string $uri, \Closure $action): Route
    {
        return $this->registerRoute(HttpMethod::PATCH, $uri, $action);
    }

    /**
     * Register a DELETE route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return Route
     */
    public function delete(string $uri, \Closure $action): Route
    {
        return $this->registerRoute(HttpMethod::DELETE, $uri, $action);
    }
}
