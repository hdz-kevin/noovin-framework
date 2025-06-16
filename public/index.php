<?php

require __DIR__ . "/../vendor/autoload.php";

use Noovin\App;
use Noovin\Http\Middlewares\AuthMiddleware;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Routing\Route;

$app = App::bootstrap();

Route::get("/middlewares", fn (Request $req) => Response::json(["message" => "Ok"]))
        ->setMiddlewares([AuthMiddleware::class]);

Route::get("/html", fn (Request $req) => Response::view("home"));

Route::get("/query", fn (Request $req) => Response::json(["query" => $req->query("page")]));

Route::get("/redirect", fn (Request $req) => Response::redirect("/auth/login"));

Route::get("/users/{username}/posts/{postId}", fn (Request $req) => Response::json([
    "params" => $req->parameters(),
]));

Route::post("/users", fn (Request $req) => Response::json(["name" => $req->data("name")]));

$app->run();
