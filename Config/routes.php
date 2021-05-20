<?php

use App\Controllers\Toto;

/**
 * Array of routes. Defined with struct :
 *      [
 *          "path"                  => "/", (Required)
 *          "controller"            => Toto::class, (Required)
 *          "http_method"           => "GET", (Required)
 *          "controller_method"     => "toto", (Required)
 *          "name"                  => "toto", (Required)
 *          "parameters"            => [Objects, strings, int, etc..]
 *      ]
 */
return [
    ["path" => "/", "controller" => Toto::class, "http_method" => "GET", "controller_method" => "toto", "name" => "app.toto"]
];
