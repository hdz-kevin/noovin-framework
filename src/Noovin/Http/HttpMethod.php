<?php

namespace Noovin\Http;

/**
 * Enum representing HTTP methods.
 */
enum HttpMethod: string
{
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case PATCH = "PATCH";
    case DELETE = "DELETE";
}
