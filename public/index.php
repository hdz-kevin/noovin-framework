<?php

require __DIR__."/../vendor/autoload.php";

use Noovin\HttpNotFoundException;
use Noovin\Request;
use Noovin\Router;
use Noovin\Server;

$router = new Router();

$router->get('/users', fn () => "GET OK");
$router->post('/users', fn () => "POST OK");
$router->post('/users/{user}/update', fn () => "POST 2 OK");

try {
    $action = $router->resolve(new Request(new Server()))->action();

    print_r($action());
} catch (HttpNotFoundException|ValueError $e) {
    http_response_code(404);
    print("Not Found");
}
