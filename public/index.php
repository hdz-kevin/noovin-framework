<?php

require __DIR__ . "/../vendor/autoload.php";

use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Server\PhpNativeServer;
use Noovin\Routing\Router;

$router = new Router();

$router->get("/users", function (Request $req) {
    return Response::json([
        "message" => "GET OK",
    ]);
});
$router->get("/query", fn (Request $req) => Response::json(["param" => $req->query("page")]));

$router->get("/redirect", fn (Request $req) => Response::redirect("/auth/login"));

$router->get("/users/{username}/posts/{postId}", fn (Request $req) => Response::json([
    "params" => $req->parameters(),
]));

$router->post("/users", fn (Request $req) => Response::json(["name" => $req->data("name")]));

$server = new PhpNativeServer();

try {
    $request = $server->request();
    $route = $router->resolve($request);
    $request->setRoute($route);
    $server->sendResponse($route->action()($request));
} catch (HttpNotFoundException | ValueError $e) {
    $response = Response::text("404 Not Found")->setStatus(404);
    $server->sendResponse($response);
}
