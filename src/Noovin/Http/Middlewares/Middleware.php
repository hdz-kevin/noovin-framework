<?php

namespace Noovin\Http\Middlewares;

use Noovin\Http\Request;
use Noovin\Http\Response;

interface Middleware
{
    /**
     * Handle the incoming request and pass it to the next middleware.
     *
     * @param Request $req
     * @param \Closure $next
     * @return Response
     */
    public function handle(Request $req, \Closure $next): Response;
}
