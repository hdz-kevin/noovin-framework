<?php

namespace Noovin\Http\Middlewares;

use Noovin\Http\Request;
use Noovin\Http\Response;

class AuthMiddleware implements Middleware
{
    public function handle(Request $req, \Closure $next): Response
    {
        if ($req->headers("Authorization") != "token") {
            return Response::json(["msg" => "Unauthorized"])->setStatus(401);
        }

        return $next($req);
    }
}
