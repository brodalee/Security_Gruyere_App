<?php

namespace App\Controllers;

use Core\AbstractController;
use Core\Model\DefaultRepository;

class AuthController extends AbstractController
{

    public function login(DefaultRepository $userRepository)
    {
    }

    public function signup(DefaultRepository $userRepository)
    {
    }

    public function disconnect()
    {
        $this->disconnectSession();
        return $this->redirectTo('app.home');
    }
}