<?php

namespace Noovin;

use Noovin\Container\Container;
use Noovin\Http\HttpNotFoundException;
use Noovin\Http\Request;
use Noovin\Http\Response;
use Noovin\Routing\Router;
use Noovin\Server\PhpNativeServer;
use Noovin\Server\Server;

class App
{
    public Router $router;

    public Request $request;

    public Server $server;

    public static function bootstrap()
    {
        $app = Container::singleton(self::class);
        $app->router = new Router();
        $app->server = new PhpNativeServer();
        $app->request = $app->server->request();

        return $app;
    }

    public function run()
    {
        try {
            $route = $this->router->resolve($this->request);
            $this->request->setRoute($route);
            $this->server->sendResponse($route->action()($this->request));
        } catch (HttpNotFoundException | \ValueError $e) {
            $response = Response::text("404 Not Found")->setStatus(404);
            $this->server->sendResponse($response);
        }
    }
}
