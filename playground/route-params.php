<?php

$route = "/users/{user}/posts/{post}/update";

# Extraer los nombres de los parametros
$parameters = [];
preg_match_all("/\{([a-zA-Z-]+)\}/", $route, $parameters);
$parameters = $parameters[1];

print_r($parameters);

# Comprobar si una uri matchea con una ruta definida en el router
$uri = "/users/kevin/posts/51/update";

$routeRegex = preg_replace("/\{([a-zA-Z-]+)\}/", "([a-zA-Z0-9]+)", $route);
print($routeRegex . PHP_EOL);

var_dump(preg_match("#^$routeRegex$#", $uri));

# Obtener los valores asociados a los parametros de la ruta
$arguments = [];
preg_match("#^$routeRegex$#", $uri, $arguments);
print_r($arguments);
