<?php

use routes\Router;

require_once __DIR__ . '/../config/env.php'; // Llamamos al archivo del config para poder usar las variables de entorno

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

Router::dispatchUri($httpMethod, $uri);

?>