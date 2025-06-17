<?php

use Noovin\App;
use Noovin\Container\Container;

function app(string $class = App::class): ?object {
    return Container::resolve($class);
}

function singleton(string $class): ?object {
    return Container::singleton($class);
}
