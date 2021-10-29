<?php

use Core\Model\DBFactory;

/**
 * Database config.
 * Struct for Maria / MySQL :
 *      ["user_name" => "", "password" => "", "db_name" => "", "host" => ""]
 */
return [
    "type" => getenv('DB_TYPE'),
    "user_name" => getenv("DB_USER"),
    "password" => getenv("DB_PASS"),
    "db_name" => getenv("DB_NAME"),
    "host" => getenv("DB_HOST")
];
