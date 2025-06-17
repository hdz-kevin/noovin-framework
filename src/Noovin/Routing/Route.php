<?php

namespace Noovin\Routing;

/**
 * Contains a uri definition and its associated action.
 */
class Route
{
    /**
     * @var string The URI pattern for the route
     */
    protected string $uri;

    /**
     * @var \Closure Action associated to the route.
     */
    protected \Closure $action;

    /**
     * @var string Regular expression used to match incoming requests URIs.
     */
    protected string $regex;

    /**
     * @var string[] Route parameter names.
     */
    protected array $parameters;

    /**
     * @var \Noovin\Http\Middlewares\Middleware[] Middlewares to be applied to the route.
     */
    protected array $middlewares = [];

    /**
     * Create a new Route instance with the given URI and action.
     *
     * @param string $uri
     * @param \Closure $action
     */
    public function __construct(string $uri, \Closure $action)
    {
        $this->uri = $uri;
        $this->action = $action;
        $this->regex = preg_replace("/\{([a-zA-Z]+)\}/", "([a-zA-Z0-9]+)", $this->uri);
        preg_match_all("/\{([a-zA-Z]+)\}/", $this->uri, $parameters);
        $this->parameters = $parameters[1];
    }

    /**
     * Checks if the given `$uri` matches the route's URI pattern.
     *
     * @param string $uri
     * @return boolean
     */
    public function matches(string $uri): bool
    {
        return preg_match("#^$this->regex/?$#", $uri);
    }

    /**
     * Checks if the route has parameters defined in its URI pattern.
     *
     * @return boolean
     */
    public function hasParameters(): bool
    {
        return count($this->parameters) > 0;
    }

    /**
     * Parses the parameters from the given `$uri` based on the route's URI pattern.
     *
     * @param string $uri
     * @return array<string, mixed>
     */
    public function parseParameters(string $uri): array
    {
        preg_match("#^$this->regex/?$#", $uri, $args);

        return array_combine($this->parameters, array_slice($args, 1));
    }

    /**
     * Check if the route has any middlewares.
     *
     * @return bool
     */
    public function hasMiddlewares(): bool
    {
        return count($this->middlewares) > 0;
    }

    /**
     * Get all HTTP middlewares associated with this route.
     *
     * @return \Noovin\Http\Middlewares\Middleware[]
     */
    public function middlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * Set the HTTP middlewares to be applied to this route.
     *
     * @param string[] $middlewares Array of middleware class names.
     * @return \Noovin\Routing\Route
     */
    public function setMiddlewares(array $middlewares): self
    {
        $this->middlewares = array_map(fn (string $middleware) => new $middleware(), $middlewares);
        return $this;
    }

    /**
     * Get the URI pattern for the route.
     *
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Action that handles requests to this route.
     *
     * @return \Closure
     */
    public function action(): \Closure
    {
        return $this->action;
    }

    /**
     * Register a new GET route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return \Noovin\Routing\Route
     */
    public static function get(string $uri, \Closure $action): self
    {
        return app()->router->get($uri, $action);
    }

    /**
     * Register a new POST route with the given `$uri` and `$action`.
     *
     * @param string $uri
     * @param \Closure $action
     * @return \Noovin\Routing\Route
     */
    public static function post(string $uri, \Closure $action): self
    {
        return app()->router->post($uri, $action);
    }
}
