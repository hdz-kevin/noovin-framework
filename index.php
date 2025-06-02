<?php

require "./Router.php";

$router = new Router();

$router->get('/users', fn () => "GET OK");
$router->post('/users', fn () => "POST OK");
$router->post('/users/1/update', fn () => "POST 2 OK");

try {
    $action = $router->resolve();
    print_r($action());
} catch (HttpNotFoundException $e) {
    http_response_code(404);
    print("Not Found");
}
