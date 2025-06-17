<?php

require __DIR__ . "/../vendor/autoload.php";

use Noovin\App;
use Noovin\Http\Middlewares\AuthMiddleware;
use Noovin\Http\Request;
use Noovin\Routing\Route;

$app = App::bootstrap();

Route::get("/middlewares", fn (Request $req) => json(["message" => "Ok"]))
        ->setMiddlewares([AuthMiddleware::class]);

Route::get("/html", fn (Request $req) => view("home", ["user" => "Manolo"]));

Route::get("/query", fn (Request $req) => json(["query" => $req->query("page")]));

Route::get("/redirect", fn (Request $req) => redirect("/auth/login"));

Route::get(
    "/users/{username}/posts/{postId}",
    fn (Request $req) => json(["params" => $req->parameters()])
);

Route::post("/users", fn (Request $req) => json(["name" => $req->data("name")]));

$app->run();
