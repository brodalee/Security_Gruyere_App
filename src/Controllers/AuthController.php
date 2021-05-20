<?php

namespace App\Controllers;

use Core\AbstractController;
use Core\Model\DefaultRepository;

class AuthController extends AbstractController
{

    public function login(DefaultRepository $userRepository)
    {
        // POST['pseudo']  POST['password']
    }

    public function signup(DefaultRepository $userRepository)
    {
        // POST['pseudo']  POST['password']
    }

    public function disconnect()
    {
        $this->disconnectSession();
        return $this->redirectTo('app.home');
    }
}