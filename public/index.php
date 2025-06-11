<?php

require __DIR__ . "/../vendor/autoload.php";

use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Server\PhpNativeServer;
use Noovin\Routing\Router;

$router = new Router();

$router->get('/users', function (Request $request) {
    return Response::json([
        "message" => "GET OK",
    ]);
});
$router->get('/query', fn (Request $request) => Response::json($request->query()));

$router->get('/redirect', fn (Request $request) => Response::redirect("/auth/login"));

$router->post('/users', fn (Request $request) => Response::json([
    "data" => $request->data(),
    "query" => $request->query(),
]));

$server = new PhpNativeServer();

try {
    $request = $server->request();
    $action = $router->resolve($request)->action();
    $server->sendResponse($action($request));
} catch (HttpNotFoundException | ValueError $e) {
    $response = Response::text("404 Not Found")->setStatus(404);
    $server->sendResponse($response);
}
