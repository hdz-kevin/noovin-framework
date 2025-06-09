<?php

namespace Noovin\Tests;

use Noovin\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public static function routesWithoutParameters(): array
    {
        return [
            ["/"],
            ["test"],
            ["/test/nested"],
            ["/test/another/nested"],
            ["/test/another/nested/router"],
        ];
    }

    /**
     * @dataProvider routesWithoutParameters
     */
    public function test_regex_without_parameters(string $uri)
    {
        $route = new Route($uri, fn () => "users");

        $this->assertTrue($route->matches($uri));
        $this->assertFalse($route->matches("$uri/extra/path"));
        $this->assertFalse($route->matches("/extra/path/$uri"));
        $this->assertFalse($route->matches("/random/uri"));
    }

    /**
     * @dataProvider routesWithoutParameters
     */
    public function test_regex_on_uri_ends_with_slash(string $uri)
    {
        $route = new Route("$uri/", fn () => "test");
        $this->assertTrue($route->matches($uri));
    }

    public static function routesWithParameters(): array
    {
        return [
            [
                "/users/{user}",
                "/users/13",
                ["user" => 13],
            ],
            [
                "/users/{user}",
                "/users/kevin",
                ["user" => "kevin"],
            ],
            [
                "/users/nested/{some}",
                "/users/nested/23",
                ["some" => 23],
            ],
            [
                "/posts/{post}/{user}/update/with/{param}/params/",
                "/posts/391/kevin/update/with/something/params/",
                ["post" => 391, "user" => "kevin", "param" => "something"],
            ],
        ];
    }

    /**
     * @dataProvider routesWithParameters
     */
    public function test_regex_with_parameters(string $uri, string $requestUri)
    {
        $route = new Route($uri, fn () => "users");

        $this->assertTrue($route->matches("$requestUri"));
        $this->assertFalse($route->matches("$requestUri/extra/path"));
        $this->assertFalse($route->matches("/extra/path/$requestUri"));
        $this->assertFalse($route->matches("/random/uri"));
    }

    /**
     * @dataProvider routesWithParameters
    */
    public function test_parse_parameters(string $uri, string $requestUri, array $expectedParams)
    {
        $route = new Route($uri, fn () => "test");

        $this->assertTrue($route->hasParameters());
        $this->assertEquals($expectedParams, $route->parseParameters($requestUri));
    }
}
