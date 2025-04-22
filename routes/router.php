<?php

namespace routes;

require_once __DIR__ . '/../config/env.php';

use FastRoute;
use src\controllers\InicioController;
use src\controllers\StudentController;

class Router {

    private array $dbconfig;

    public function __construct(?array $dbconfig = [])
    {
        $this->dbconfig = $dbconfig;
    }

    public function dispatchUri(string $httpmethod, string $url)
    {
        $root = $_ENV['APP_ROOT']; // Contiene la url base de la app

        if (false !== $pos = strpos($url, '?')) {
            $url = substr($url, 0, $pos);
        }
        $url = rawurldecode($url);

        // Rutas de la aplicación: MÉTODO + URL + FUNCIÓN DEL CONTROLADOR
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) use ($root) {

            $studentController = new StudentController($this->dbconfig);

            $r->addRoute('GET', "$root/", [InicioController::class, 'index']);
            $r->addRoute('GET', "$root/users", [InicioController::class, 'users']);

            $r->addRoute('GET', "$root/alumnos", [$studentController, 'index']);
            $r->addRoute('GET', "$root/alumnos/{id}", [$studentController, 'show']);
            $r->addRoute('POST', "$root/alumnos", [$studentController, 'create']);
            $r->addRoute('PUT', "$root/alumnos/{id}", [$studentController, 'update']);
            $r->addRoute('DELETE', "$root/alumnos/{id}", [$studentController, 'delete']);
        });

        // Se compara la $url que nos llega por parámetro a la función con la lista en $dispatcher
        $routeInfo = $dispatcher->dispatch($httpmethod, $url);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                echo 'BAD BOY';
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                echo 'NO';
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                if($_GET && $_SERVER['REQUEST_METHOD'] === 'GET') { // El método también debe ser 'GET'
                    // Incluimos las query params si están en $_GET. Llegan al controlador como parámetro de la función
                    return call_user_func($handler, array_merge($vars, $_GET)); 
                }
                return call_user_func($handler, $vars); // Devuelve la función del controlador para ver la vista
                break;
        }
    }
}

?>