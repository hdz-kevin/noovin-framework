<?php

namespace Noovin\Tests;

use Noovin\Http\HttpMethod;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Routing\Router;
use Noovin\Server\Server;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private function createMockRequest(string $uri, HttpMethod $method): Request
    {
        return (new Request())
                ->setUri($uri)
                ->setMethod($method);
    }

    public function test_resolve_basic_route_with_callback_action()
    {
        $uri = "/users";
        $action = fn () => "[]";
        $router = new Router();
        $router->get($uri, $action);

        $route = $router->resolveRoute($this->createMockRequest($uri, HttpMethod::GET));
        $this->assertEquals($uri, $route->uri());
        $this->assertEquals($action, $route->action());
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
            $route = $router->resolveRoute($this->createMockRequest($uri, HttpMethod::GET));
            $this->assertEquals($uri, $route->uri());
            $this->assertEquals($action, $route->action());
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
            $route = $router->resolveRoute($this->createMockRequest($uri, $method));
            $this->assertEquals($uri, $route->uri());
            $this->assertEquals($action, $route->action());
        }
    }

    public function test_run_middlewares()
    {
        $middleware1 = new class {
            public function handle(Request $req, \Closure $next): Response
            {
                return $next($req)->setHeader("X-Test-One", "one");
            }
        };

        $middleware2 = new class {
            public function handle(Request $req, \Closure $next): Response
            {
                return $next($req)->setHeader("X-Test-Two", "two");
            }
        };

        $router = new Router();
        $uri = "/test/uri";
        $expectedResponse = Response::json(["message" => "Ok"]);
        $router->get($uri, fn ($req) => $expectedResponse)
                    ->setMiddlewares([$middleware1::class, $middleware2::class]);
        $response = $router->resolve($this->createMockRequest($uri, HttpMethod::GET));

        $this->assertEquals($expectedResponse, $response);
        $this->assertEquals($response->headers("x-test-one"), "one");
        $this->assertEquals($response->headers("x-test-two"), "two");
    }

    public function test_middleware_stack_can_be_stopped()
    {
        $stopMiddleware = new class {
            public function handle(): Response
            {
                return Response::text("Stop Ok");
            }
        };
        $secondMiddleware = new class {
            public function handle(Request $req, \Closure $next): Response
            {
                return $next($req)->setHeader("X-Second", "second");
            }
        };

        $router = new Router();
        $uri = "/stop/middleware/stack";
        $actionResponse = Response::json(["message" => "success"]);
        $router->post($uri, fn ($req) => $actionResponse)
                    ->setMiddlewares([$stopMiddleware::class, $secondMiddleware::class]);
        $response = $router->resolve($this->createMockRequest($uri, HttpMethod::POST));

        $this->assertNotEquals($actionResponse, $response);
        $this->assertNull($response->headers("X-Second"));
        $this->assertEquals("Stop Ok", $response->content());
    }
}
