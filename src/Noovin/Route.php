<?php

namespace Noovin;

class Route {
    protected string $uri;

    protected \Closure $action;

    protected string $regex;

    protected array $parameters;

    public function __construct(string $uri, \Closure $action)
    {
        $this->uri = $uri;
        $this->action = $action;

        if (str_ends_with($this->uri, "/") && $this->uri !== "/") {
            // Remove trailing slash if it's not the root URI
            $this->uri = rtrim($this->uri, "/");
        }

        $this->regex = preg_replace("/\{([a-zA-Z]+)\}/", "([a-zA-Z0-9]+)", $this->uri);
        preg_match_all("/\{([a-zA-Z]+)\}/", $this->uri, $parameters);
        $this->parameters = $parameters[1];
    }

    public function matches(string $uri): bool
    {
        return preg_match("#^$this->regex/?$#", $uri);
    }

    public function hasParameters(): bool
    {
        return count($this->parameters) > 0;
    }

    public function parseParameters(string $uri): array
    {
        preg_match("#^$this->regex/?$#", $uri, $args);

        return array_combine($this->parameters, array_slice($args, 1));
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function action(): \Closure
    {
        return $this->action;
    }
}
