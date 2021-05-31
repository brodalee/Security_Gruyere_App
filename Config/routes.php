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

use App\Controllers\AssetsController;
use App\Controllers\AuthController;
use App\Controllers\SauceController;
use App\Controllers\SuccessController;
use App\Model\Entity\Sauce;
use App\Model\Entity\User;
use App\Model\Entity\UserLikeDislikeSauce;

$userRepository = (new User())->getRepository();
$sauceRepository = (new Sauce())->getRepository();
$user_l_d_sauceRepository = (new UserLikeDislikeSauce())->getRepository();

return [
    /** Auth **/
    ["path" => "/auth/signup", "controller" => AuthController::class, "http_method" => "POST", "controller_method" => "signup", "name" => "app.signup.post", 'parameters' => [$userRepository]],
    ["path" => "/auth/signup", "controller" => AuthController::class, "http_method" => "GET", "controller_method" => "signupGet", "name" => "app.signup.get"],
    ["path" => "/auth/login", "controller" => AuthController::class, "http_method" => "POST", "controller_method" => "login", "name" => "app.login.post", 'parameters' => [$userRepository]],
    ["path" => "/auth/login", "controller" => AuthController::class, "http_method" => "GET", "controller_method" => "loginGet", "name" => "app.login.get"],
    ["path" => "/auth/disconnect", "controller" => AuthController::class, "http_method" => "GET", "controller_method" => "disconnect", "name" => "app.disconnect"],

    /** Sauces  **/
    ["path" => "/", "controller" => SauceController::class, "http_method" => "GET", "controller_method" => "getAll", "name" => "app.sauce.getAll", 'parameters' => [$sauceRepository]],
    ["path" => "/sauces/create", "controller" => SauceController::class, "http_method" => "GET", "controller_method" => "create", "name" => "app.sauce.create.get"],
    ["path" => "/sauces/create", "controller" => SauceController::class, "http_method" => "POST", "controller_method" => "createPOST", "name" => "app.sauce.create.post", 'parameters' => [$sauceRepository]],
    ["path" => "/sauces/:id", "controller" => SauceController::class, "http_method" => "GET", "controller_method" => "getOneById", "name" => "app.sauce.getOne", 'parameters' => [$sauceRepository]],
    ["path" => "/sauces/delete", "controller" => SauceController::class, "http_method" => "DELETE", "controller_method" => "delete", "name" => "app.sauce.delete", 'parameters' => [$sauceRepository]],
    ["path" => "/sauces/:id/like", "controller" => SauceController::class, "http_method" => "POST", "controller_method" => "likeSauce", "name" => "app.sauce.like", 'parameters' => [$sauceRepository]],
    ["path" => "/sauces/:id/dislike", "controller" => SauceController::class, "http_method" => "POST", "controller_method" => "dislikeSauce", "name" => "app.sauce.dislike", 'parameters' => [$sauceRepository]],

    /** SUCCESS  **/
    ["path" => "/api/success/add", "controller" => SuccessController::class, "http_method" => "POST", "controller_method" => "add", "name" => "app.success.add"],

    /** Assets **/
    ["path" => "/public", "controller" => AssetsController::class, "http_method" => "GET", "controller_method" => "assets", "name" => "app.assets"],
];
