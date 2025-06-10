<?php

require __DIR__ . "/../vendor/autoload.php";

use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Server\PhpNativeServer;
use Noovin\Routing\Router;

$router = new Router();

$router->get('/users', function () {
    return Response::json([
        "message" => "GET OK",
    ]);
});

$router->get('/users/{user}/update', function () {
    return Response::redirect("/users");
});

$router->post('/users', fn () => "POST OK");
$router->post('/users/{user}/update', fn () => "POST 2 OK");

$server = new PhpNativeServer();

try {
    $action = $router->resolve(new Request($server))->action();
    $server->sendResponse($action());
} catch (HttpNotFoundException | ValueError $e) {
    $response = Response::text("404 Not Found")->setStatus(404);
    $server->sendResponse($response);
}
