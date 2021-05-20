<?php

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

use App\Controllers\SimpleController;

return [
    ["path" => "/", "controller" => SimpleController::class, "http_method" => "GET", "controller_method" => "homePage", "name" => "app.home"]
];
