<?php

namespace App\Controllers;

use App\Model\Entity\Success;
use App\Model\UserSession;
use Core\AbstractController;

class AssetsController extends AbstractController
{
    private static $TYPES = ['css', 'js', 'php','image'];
    private static $img_ext = ['jpg', 'png', 'svg'];

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
                if (in_array(pathinfo($_GET['resource_name'], PATHINFO_EXTENSION), static::$img_ext)) {
                    if ($this->containsExecutableCode($_GET['resource_name']) === TRUE) {
                        if ($this
                            ->getUser()
                            ->addSuccess(UserSession::$SUCCESSES['INCLUDE'])) {
                            $this->addFlash('INCLUDE_FOUND', 'Vous avez trouvé la faille Include : ' . UserSession::$SUCCESSES['INCLUDE']['Description']);
                        }
                    }
                    require_once './public/img/' . $_GET['resource_name'];
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

    private function containsExecutableCode($name) {
        $content = file_get_contents('./public/img/' . $name);
        preg_match_all('/\<\?php(.*)\?\>/i', $content, $match);
        return !empty($match[0]);
    }
}