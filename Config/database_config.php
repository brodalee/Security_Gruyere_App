<?php

use Core\Model\DBFactory;

/**
 * Database config.
 * Struct for Maria / MySQL :
 *      ["user_name" => "", "password" => "", "db_name" => "", "host" => ""]
 */
return [
    "type" => DBFactory::$MYSQL,
    "user_name" => "root",
    "password" => "",
    "db_name" => "gruyere_app",
    "host" => "localhost:3306"
];
