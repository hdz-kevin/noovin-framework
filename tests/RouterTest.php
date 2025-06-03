<?php

namespace Noovin\Tests;

use Noovin\HttpMethod;
use Noovin\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function test_resolve_basic_route_with_callback_action()
    {
        $uri = "/users";
        $action = fn () => "[]";
        $router = new Router();
        $router->get($uri, $action);

        $this->assertEquals($action, $router->resolve($uri, HttpMethod::GET));
    }

    public function test_resolve_multiple_basic_routes_with_callback_action()
    {
        $router = new Router();
        $routes = [
            "/test" => fn () => "Test Ok",
            "/foo" => fn () => "Foo Ok",
            "/bar" => fn () => "Bar Ok",
            "/long/nested/route" => fn () => "Long neste route OK",
        ];

        foreach ($routes as $uri => $action) {
            $router->get($uri, $action);
        }

        foreach ($routes as $uri => $action) {
            $this->assertEquals($action, $router->resolve($uri, HttpMethod::GET));
        }
    }

    public function test_resolve_multiple_basic_routes_with_callback_action_for_different_http_method()
    {
        $routes = [
            [HttpMethod::GET, "/test", fn () => "GET"],
            [HttpMethod::POST, "/test", fn () => "POST"],
            [HttpMethod::PUT, "/test", fn () => "PUT"],
            [HttpMethod::DELETE, "/test", fn () => "DELETE"],

            [HttpMethod::GET, "/random/get/uri", fn () => "GET"],
            [HttpMethod::POST, "/random/nested/post/route", fn () => "POST"],
            [HttpMethod::PUT, "/some/patch/route", fn () => "PUT"],
            [HttpMethod::DELETE, "/d", fn () => "DELETE"],
        ];

        $router = new Router();

        foreach ($routes as [$method, $uri, $action]) {
            $router->{$method->value}($uri, $action);
        }

        foreach ($routes as [$method, $uri, $action]) {
            $this->assertEquals($action, $router->resolve($uri, $method));
        }
    }
}
