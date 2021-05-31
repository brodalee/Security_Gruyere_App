<?php

namespace App\Controllers;

use App\Model\Entity\Success;
use App\Model\UserSession;
use Core\AbstractController;
use Core\Model\DefaultRepository;

class SauceController extends AbstractController
{

    public function __construct()
    {
        if ($this->getUser() == null) {
            //return $this->redirectTo('app.login.get');
            $user = new \stdClass();
            $user->id = 0;
            $user->role = "USER";
            $user->pseudo = "Vevo Admin";
            $userSession = new UserSession($user);
            if ($userSession->addSuccess(UserSession::$SUCCESSES['ROUTE_ACCESS'])) {
                $this->addFlash(
                    'ROUTE_ACCESS_FOUND',
                    'Vous avez trouvé la faille de droit d\'acces des zones du site : ' . UserSession::$SUCCESSES['ROUTE_ACCESS']['Description']);
            }
        }
        parent::__construct();
    }

    public function getAll(DefaultRepository $sauceRepository)
    {
        echo $this->render('getAll.php', [
            'sauces' => $sauceRepository->findAll()
        ]);
    }

    public function create()
    {
        echo $this->render('createSauce.html');
    }

    public function createPOST(DefaultRepository $sauceRepository)
    {
        $file = incoming_files()[0];
        move_uploaded_file($file['tmp_name'], SITE_BASE_PATH.'public/img/'.$file['name']);
        $_POST['imageUrl'] = $file['name'];
        $_POST['heat'] = (int)
        $_POST['userId'] = (int) $this->getUser()->getId();
        $sauceRepository->createFrom($_POST);
        $this->redirectTo('app.sauce.getAll');
        // TODO : Faille "UPLOAD"
    }

    public function delete(DefaultRepository $sauceRepository)
    {
        // POST['id']
    }

    public function getOneById(string $id, DefaultRepository $sauceRepository)
    {
        echo $this->render('singleSauce.php', [
            'sauce' => $sauceRepository->findAllBy('id', $id)
        ]);
    }

    public function likeSauce(string $sauceId, DefaultRepository $sauceRepository)
    {
    }

    public function dislikeSauce(string $sauceId, DefaultRepository $sauceRepository)
    {
    }
}