<?php

use Noovin\Http\Request;
use Noovin\Http\Response;

function json(array $data): Response {
    return Response::json($data);
}

function view(string $view, array $data = [], ?string $layout = null): Response {
    return Response::view($view, $data, $layout);
}

function redirect(string $uri, int $status = 302): Response {
    return Response::redirect($uri, $status);
}

function request(): Request {
    return app()->request;
}
