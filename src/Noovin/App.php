<?php

namespace Noovin;

use Noovin\Container\Container;
use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Routing\Router;
use Noovin\Server\PhpNativeServer;
use Noovin\Server\Server;
use Noovin\View\NoovinEngine;
use Noovin\View\ViewEngine;

/**
 * The main application class that initializes the router, server, and request.
 */
class App
{
    public Router $router;

    public Request $request;

    public Server $server;

    public ViewEngine $viewEngine;

    public static function bootstrap(): self
    {
        $app = Container::singleton(self::class);
        $app->router = new Router();
        $app->server = new PhpNativeServer();
        $app->request = $app->server->request();
        $app->viewEngine = new NoovinEngine(__DIR__."/../../views");

        return $app;
    }

    public function run()
    {
        try {
            $response = $this->router->resolve($this->request);
            $this->server->sendResponse($response);
        } catch (HttpNotFoundException | \ValueError $e) {
            $response = Response::text("404 Not Found")->setStatus(404);
            $this->server->sendResponse($response);
        }
    }
}
