<?php

session_start();
header('Access-Control-Allow-Origin: "*"');

require_once './vendor/autoload.php';

use Core\Rooting\Rooter\RouteCollection;
use Core\Rooting\Rooter\Route;
use Core\Rooting\Rooter\Router;

define('SITE_BASE_PATH', __DIR__ . '/');

function incoming_files() {
    $files = $_FILES;
    $files2 = [];
    foreach ($files as $input => $infoArr) {
        $filesByInput = [];
        foreach ($infoArr as $key => $valueArr) {
            if (is_array($valueArr)) { // file input "multiple"
                foreach($valueArr as $i=>$value) {
                    $filesByInput[$i][$key] = $value;
                }
            }
            else { // -> string, normal file input
                $filesByInput[] = $infoArr;
                break;
            }
        }
        $files2 = array_merge($files2,$filesByInput);
    }
    $files3 = [];
    foreach($files2 as $file) { // let's filter empty & errors
        if (!$file['error']) $files3[] = $file;
    }
    return $files3;
}

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
$matched = $rooter->matchCurrentRequest();
if (!$matched) {
    http_response_code(404);
}