<?php

namespace App\Core;

class Router{
    protected $routes = [];

    public function add($route, $params = []){
        $this->routes[$route] = $params;
    }

    public function post(){

    }

    public function get(){

    }

    public function put(){

    }

    public function delete(){
        
    }

    public function dispatch($url, $method) {
        $url = trim($url, '/');
        foreach ($this->routes as $route => $params) {
            if ($url == $route) {
                $controller = $params['controller'];
                $action = strtolower($method) . ucfirst($params['action']);
                
                if (class_exists($controller)) {
                    $controllerObject = new $controller();
                    $request = new Request();
                    if (method_exists($controllerObject, $action)) {
                        $controllerObject->$action($request);
                    } else {
                        echo "Method $action not found in controller $controller";
                    }
                } else {
                    echo "Controller class $controller not found";
                }
                return;
            }
        }
        echo "No route matched.";
    }
}