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
use App\Controllers\SauceController;
use App\Controllers\SimpleController;
use App\Model\Entity\Sauce;
use App\Model\Entity\User;
use App\Model\Entity\UserLikeDislikeSauce;

$userRepository = (new User())->getRepository();
$sauceRepository = (new Sauce())->getRepository();
$user_l_d_sauceRepository = (new UserLikeDislikeSauce())->getRepository();

return [
    ["path" => "/", "controller" => SimpleController::class, "http_method" => "GET", "controller_method" => "homePage", "name" => "app.home"],

    /** Auth **/
    ["path" => "/signup", "controller" => SimpleController::class, "http_method" => "POST", "controller_method" => "signup", "name" => "app.signup", 'parameters' => [$userRepository]],
    ["path" => "/login", "controller" => AuthController::class, "http_method" => "POST", "controller_method" => "login", "name" => "app.login", 'parameters' => [$userRepository]],
    ["path" => "/disconnect", "controller" => AuthController::class, "http_method" => "GET", "controller_method" => "disconnect", "name" => "app.disconnect"],

    /** Sauces  **/
    ["path" => "/sauces", "controller" => SauceController::class, "http_method" => "GET", "controller_method" => "getAll", "name" => "app.sauce.getAll", 'parameters' => [$sauceRepository]],
    ["path" => "/sauces/:id", "controller" => SauceController::class, "http_method" => "GET", "controller_method" => "getOneById", "name" => "app.sauce.getOne", 'parameters' => [$sauceRepository]],
    ["path" => "/sauce/delete", "controller" => SauceController::class, "http_method" => "POST", "controller_method" => "create", "name" => "app.sauce.create", 'parameters' => [$sauceRepository]],
    ["path" => "/sauce/create", "controller" => SauceController::class, "http_method" => "DELETE", "controller_method" => "delete", "name" => "app.sauce.delete", 'parameters' => [$sauceRepository]],
];
