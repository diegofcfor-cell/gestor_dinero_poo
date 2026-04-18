<?php

class Router
{
    public static function run()
    {
        $controller = $_REQUEST['controller'] ?? 'login';
        $action     = $_REQUEST['action'] ?? 'index';


        $controllerName = ucfirst($controller) . 'Controller';
        $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("Controlador no encontrado");
        }

        require_once $controllerFile;

        $controllerObject = new $controllerName();

        if (!method_exists($controllerObject, $action)) {
            die("Acción no encontrada");
        }

        $controllerObject->$action();
    }
}
