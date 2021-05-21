<?php

namespace App\Controllers;

class AssetsController
{
    private static $TYPES = ['css', 'js'];

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
            }
        }
        http_response_code(404);
    }
}