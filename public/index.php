<?php

require __DIR__ . "/../vendor/autoload.php";

use Noovin\App;
use Noovin\Http\Request;
use Noovin\Http\Response;

$app = App::bootstrap();

$app->router->get("/users", function (Request $req) {
    return Response::json([
        "message" => "GET OK",
    ]);
});
$app->router->get("/query", fn (Request $req) => Response::json(["param" => $req->query("page")]));

$app->router->get("/redirect", fn (Request $req) => Response::redirect("/auth/login"));

$app->router->get("/users/{username}/posts/{postId}", fn (Request $req) => Response::json([
    "params" => $req->parameters(),
]));

$app->router->post("/users", fn (Request $req) => Response::json(["name" => $req->data("name")]));

$app->run();
