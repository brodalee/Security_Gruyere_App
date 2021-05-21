<?php

namespace App\Controllers;

class AssetsController
{
    private static $TYPES = ['css', 'js', 'php'];

    public function assets()
    {
        if (isset($_GET['type']) && in_array($_GET['type'], static::$TYPES)) {
            if (isset($_GET['resource_name'])) {
                if (file_exists('./public/style/'.$_GET['resource_name']. '.css')) {
                    header('Content-type: text/css');
                    include './public/style/'.$_GET['resource_name'].'.css';
                    return;
                }
                if (file_exists('./public/scripts/'.$_GET['resource_name'].'.js')) {
                    header('Content-type: text/javascript');
                    include './public/scripts/'.$_GET['resource_name'].'.js';
                    return;
                }
                if (pathinfo($_GET['resource_name'], PATHINFO_EXTENSION) == 'php') {
                    // TODO : Faille "INCLUDE".
                    include $_GET['resource_name'];
                }
            }
        }
        http_response_code(404);
    }
}