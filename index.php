<?php

session_start();

require_once './vendor/autoload.php';

use Core\Rooting\Rooter\RouteCollection;
use Core\Rooting\Rooter\Route;
use Core\Rooting\Rooter\Router;

$collection = new RouteCollection();
$routes = require_once './Config/routes.php';
foreach ($routes as $route) {
    $collection->attachRoute(new Route(
        $route['path'], array(
            '_controller'   => $route['controller'] . "::" . $route['controller_method'],
            'methods'       => $route['http_method'],
            'parameters'    => isset($route['parameters']) ? $route['parameters'] : []
        )
    ));
}

$rooter = new Router($collection);
$rooter->matchCurrentRequest();