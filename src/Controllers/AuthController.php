<?php

namespace App\Controllers;

use App\Model\Repository\UserRepository;
use App\Model\UserSession;
use Core\AbstractController;
use Core\Modules\Security\BrutForce\AntiBrutForceSession;

class AuthController extends AbstractController
{

    public function login(UserRepository $userRepository)
    {
        $afb = new AntiBrutForceSession();
        if ($afb->isBlocked()) {
            if ((new UserSession())->addSuccess(UserSession::$SUCCESSES['FORCE_BRUTE'])) {
                $this->addFlash(
                    'FORCE_BRUTE',
                    "Vous forcez la porte comme une brute ! : " . UserSession::$SUCCESSES['FORCE_BRUTE']['Description']);
            }
            //return $this->redirectTo('app.login.get');
        }
        $afb->incrementTry();

        if (isset($_POST['pseudo']) && isset($_POST['password'])) {

            if ($_POST['pseudo'] == 'admin' && $_POST['password'] == 'admin') {
                $user = $userRepository->findOneWhere([
                    'pseudo = "admin"',
                    'password = "admin"'
                ]);
                if (!$user) {
                    $userRepository->create("admin", 'admin');
                }
                $user = $userRepository->findOneWhere([
                    'pseudo = "admin"',
                    'password = "admin"'
                ]);
                $userSession = new UserSession($user);
                $afb->reset();
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
                    if ($this->getUser()->addSuccess(UserSession::$SUCCESSES['SQL_INJECTION'])) {
                        $this->addFlash('SQL_INJECTION_FOUND', "Vous avez trouvé la faille d'injection SQL !");
                    }
                }
                $afb->reset();
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
        echo $this->render('connexion.html', [
            'pseudo' => 'admin',
            'password' => 'admin'
        ]);
    }

    public function signupGet()
    {
        echo $this->render('inscription.html');
    }

    public function signup(UserRepository $userRepository)
    {
        if (isset($_POST['pseudo']) && isset($_POST['password'])) {

            $userRepository->create($_POST['pseudo'], $_POST['password']);
            $this->addFlash('account_created', 'Votre compte a bien été crée.');
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