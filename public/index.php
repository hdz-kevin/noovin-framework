<?php

require __DIR__."/../vendor/autoload.php";

use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Server\PhpNativeServer;
use Noovin\Routing\Router;

$router = new Router();

$router->get('/users', function () {
    $response = new Response();
    $response->setStatus(200)
             ->setHeader("Content-Type", "application/json")
             ->setContent(json_encode(["message" => "GET OK"]));

    return $response;
});

$router->post('/users', fn () => "POST OK");
$router->post('/users/{user}/update', fn () => "POST 2 OK");

$server = new PhpNativeServer();
try {
    $action = $router->resolve(new Request($server))->action();
    $server->sendResponse($action());
} catch (HttpNotFoundException|ValueError $e) {
    $response = new Response();
    $response->setStatus(404)
             ->setHeader("Content-Type", "text/plain")
             ->setContent("404 Not Found");
    $server->sendResponse($response);
}
