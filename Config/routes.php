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

use App\Controllers\AuthController;
use App\Controllers\SimpleController;

$userRepository = (new \App\Model\Entity\User())->getRepository();
$sauceRepository = (new \App\Model\Entity\Sauce())->getRepository();
$user_l_d_sauceRepository = (new \App\Model\Entity\UserLikeDislikeSauce())->getRepository();

return [
    ["path" => "/", "controller" => SimpleController::class, "http_method" => "GET", "controller_method" => "homePage", "name" => "app.home"],

    /** Auth **/
    ["path" => "/signup", "controller" => SimpleController::class, "http_method" => "POST", "controller_method" => "signup", "name" => "app.signup", 'parameters' => [$userRepository]],
    ["path" => "/login", "controller" => AuthController::class, "http_method" => "POST", "controller_method" => "login", "name" => "app.login", 'parameters' => [$userRepository]],

    /** Connected  **/
];
