<?php

namespace Noovin\Server;

use Noovin\Http\HttpMethod;
use Noovin\Http\Request;
use Noovin\Http\Response;

/**
 * Similar to PHP `$_SERVER` but having an interface allows us to mock these
 * global variables, useful for testing.
 */
interface Server
{
    /**
     * Get the current HTTP request.
     *
     * @return Request
     */
    public function request(): Request;

    /**
     * Send the HTTP response to the client.
     *
     * @param Response $response
     * @return void
     */
    public function sendResponse(Response $response): void;
}
