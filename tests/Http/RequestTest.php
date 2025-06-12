<?php

namespace Noovin\Tests\Http;

use Noovin\Http\HttpMethod;
use Noovin\Http\Request;
use Noovin\Routing\Route;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function test_request_returns_data_obtained_from_server_correctly()
    {
        $uri = '/test/route';
        $postData = ['post' => 'test', 'foo' => 'bar'];
        $queryParams = ['a' => 1, 'b' => 2, 'test' => 'foo'];

        $request = (new Request())
                    ->setUri($uri)
                    ->setMethod(HttpMethod::POST)
                    ->setPostData($postData)
                    ->setQueryParameters($queryParams);

        $this->assertEquals($uri, $request->uri());
        $this->assertEquals($queryParams, $request->query());
        $this->assertEquals($postData, $request->data());
        $this->assertEquals(HttpMethod::POST, $request->method());
    }

    public function test_data_returns_value_if_key_is_given()
    {
        $data = ["name" => "kevin", "email" => "kevin@kevin.com", "age" => 21];
        $request = (new Request())->setPostData($data);

        $this->assertEquals(21, $request->data("age"));
        $this->assertEquals("kevin", $request->data("name"));
        $this->assertNull($request->data("notexists"));
        $this->assertEquals($data, $request->data());
    }

    public function test_query_returns_value_if_key_is_given()
    {
        $query = ["page" => 6, "search" => "gatitos"];
        $request = (new Request())->setQueryParameters($query);

        $this->assertEquals("gatitos", $request->query("search"));
        $this->assertEquals(6, $request->query("page"));
        $this->assertNull($request->query("notexists"));
        $this->assertEquals($query, $request->query());
    }

    public function test_route_parameters_returns_value_if_key_is_given()
    {
        $uriDefinition = "/users/{username}/posts/{postId}";
        $uriRequest =    "/users/kevin/posts/459";

        $route = new Route($uriDefinition, fn () => "OK");
        $request = (new Request())
                    ->setRoute($route)
                    ->setUri($uriRequest);

        $this->assertEquals("kevin", $request->parameters("username"));
        $this->assertEquals(459, $request->parameters("postId"));
        $this->assertNull($request->parameters("notexists"));
        $this->assertEquals(["username" => "kevin", "postId" => 459], $request->parameters());
    }
}
