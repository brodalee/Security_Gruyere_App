<?php

namespace App\Controllers;

use App\Model\Repository\UserRepository;
use App\Model\UserSession;
use Core\AbstractController;

class AuthController extends AbstractController
{

    public function login(UserRepository $userRepository)
    {
        // TODO : Faille "FORCE_BRUTE".
        if (isset($_POST['pseudo']) && isset($_POST['password'])) {

            if ($_POST['pseudo'] == 'toto' && $_POST['password'] == 'admin') {
                $user = new \stdClass();
                $user->id = 0;
                $user->role = "USER";
                $user->pseudo = "Vevo Admin";
                $userSession = new UserSession($user);
                if ($userSession->addSuccess(UserSession::$SUCCESSES['LOGS_IN_FILE'])) {
                    $this->addFlash(
                        'LOG_IN_FILE_FOUND',
                        "Vous avez trouvé la faille de Vevo avec Youtube ! : " . UserSession::$SUCCESSES['LOGS_IN_FILE']['Description']);
                }
                $this->connectSession($userSession);
                return $this->redirectTo('app.sauce.getAll');
            }

            $user = $userRepository->findOneWhere([
                'pseudo = "'.$_POST['pseudo'].'"',
                'password = "'.$_POST['password'].'"'
            ]);
            if ($user != null) {
                $userSession = new UserSession($user);
                $this->connectSession($userSession);
                if ($userRepository->findOneWhere([
                    "pseudo = '{$_POST['pseudo']}'",
                    "password = '{$_POST['password']}'"
                ]) == null) {
                    $this->connectSession(
                        $this->getUser()->addSuccess(UserSession::$SUCCESSES['SQL_INJECTION'])
                    );
                    $this->addFlash('SQL_INJECTION_FOUND', "Vous avez trouvé la faille d'injection SQL !");
                }
                return $this->redirectTo('app.sauce.getAll');
            }
            $this->addFlash('failure', 'Mot de passe incorrect');
            return $this->redirectTo('app.login.get');
        }
        $this->addFlash('failure', 'Identifiant inconnu.');
        return $this->redirectTo('app.login.get');
    }

    public function loginGet()
    {
        echo $this->render('connexion.html');
    }

    public function signupGet()
    {
        echo $this->render('inscription.html');
    }

    public function signup(UserRepository $userRepository)
    {
        if (isset($_POST['pseudo']) && isset($_POST['password'])) {

            $userRepository->create($_POST['pseudo'], $_POST['password']);
            return $this->redirectTo('app.login.get');
        }
        $this->addFlash('failure', 'Une erreur est survenue.');
        return $this->redirectTo('app.signup.get');
    }

    public function disconnect()
    {
        $this->disconnectSession();
        return $this->redirectTo('app.login.get');
    }
}