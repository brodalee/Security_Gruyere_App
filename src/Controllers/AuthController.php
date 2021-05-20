<?php

namespace App\Controllers;

use App\Model\Repository\UserRepository;
use App\Model\UserSession;
use Core\AbstractController;

class AuthController extends AbstractController
{

    public function login(UserRepository $userRepository)
    {
        if (isset($_POST['pseudo']) && isset($_POST['password'])) {

            $user = $userRepository->findOneWhere([
                'pseudo = "'.$_POST['pseudo'].'"',
                'password = "'.$_POST['password'].'"'
            ]);
            if ($user != null) {
                $userSession = new UserSession($user);
                $this->connectSession($userSession);
                echo "azeaze";
                //return $this->redirectTo('app.sauce.getAll');
            }
            $this->addFlash('failure', 'Mot de passe incorrect');
            //return $this->redirectTo('app.home');
        }
        $this->addFlash('failure', 'Identifiant inconnu.');
        //return $this->redirectTo('app.home');
    }

    public function signup(UserRepository $userRepository)
    {
        if (isset($_POST['pseudo']) && isset($_POST['password'])) {

            $userRepository->create($_POST['pseudo'], $_POST['password']);
            return $this->redirectTo('app.home');
        }
        $this->addFlash('failure', 'Une erreur est survenue.');
        return $this->redirectTo('app.home');
    }

    public function disconnect()
    {
        $this->disconnectSession();
        return $this->redirectTo('app.home');
    }
}