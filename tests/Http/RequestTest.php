<?php

namespace Noovin\Tests\Http;

use Noovin\Http\HttpMethod;
use Noovin\Http\Request;
use Noovin\Server\Server;
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
}
