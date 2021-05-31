<?php

namespace App\Controllers;

use App\Model\UserSession;
use Core\AbstractController;

class SuccessController extends AbstractController
{

    public function add()
    {
        $user = new \stdClass();
        $user->id = 0;
        $user->role = "USER";
        $user->pseudo = "Vevo Admin";
        $userSession = new UserSession($user);
        if ($userSession->addSuccess(UserSession::$SUCCESSES['XSS'])) {
            $this->addFlash(
                'XSS_FOUND',
                'Vous avez trouvé une faille XSS : ' . UserSession::$SUCCESSES['XSS']['Description']);
        }
        echo $this->renderJson([
            $_SESSION
        ]);
    }
}