<?php

namespace Core;

use Core\Interfaces\UserInterface;

abstract class AbstractController
{
    private $template;

    public function __construct()
    {
        $this->template = new Template();
    }

    public function redirectTo(string $routeName)
    {
        $routes = require 'Config/routes.php';
        $t = array_search($routeName, array_map(function ($el){return $el['name'];}, $routes));
        if ($t === false) throw new \Exception("");
        $path = $routes[$t]['path'];
        header("Location: $path");
    }

    public function render($template, $params = [])
    {
        return $this->template->render($template, $params);
    }

    public function renderJson($content, int $http_code = 200)
    {
        http_response_code($http_code);
        header('Content-Type: application/json');
        return json_encode($content);
    }

    public function addFlash(string $name, string $message)
    {
        $_SESSION['flashes'][$name] = $message;
        return $this;
    }

    public function getFlash(string $name)
    {
        if (!isset($_SESSION['flashes'][$name])) return null;
        $flash = $_SESSION['flashes'][$name];
        unset($_SESSION['flashes'][$name]);
        return $flash;
    }

    public function connectSession(UserInterface $user)
    {
        $data = base64_encode(get_class($user)) . '.' . base64_encode($user->serialize());
        $_SESSION['user_session'] = $data;
        return $this;
    }

    public function getUser()
    {
        if (!$this->isConnected()) return null;

        $data = explode('.', $_SESSION['user_session']);
        $className = base64_decode($data[0]);
        $class = new $className();
        $class->unserialize(base64_decode($data[1]));
        return $class;
    }

    private function isConnected()
    {
        return isset($_SESSION['user_session']) ? $_SESSION['user_session'] !== null : false;
    }

    public function disconnectSession()
    {
        $_SESSION['user_session'] = null;
        return $this;
    }
}