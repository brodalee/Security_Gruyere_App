<?php

namespace App\Controllers;

use App\Model\Entity\Success;
use App\Model\Entity\UserLikeDislikeSauce;
use App\Model\UserSession;
use Core\AbstractController;
use Core\Model\DefaultRepository;

class SauceController extends AbstractController
{

    public function __construct($params)
    {
        if ($this->getUser() == null) {
            //return $this->redirectTo('app.login.get');
            $userRepository = $params[0];
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
            if ($userSession->addSuccess(UserSession::$SUCCESSES['ROUTE_ACCESS'])) {
                $this->addFlash(
                    'ROUTE_ACCESS_FOUND',
                    'Vous avez trouvé la faille de droit d\'acces des zones du site : ' . UserSession::$SUCCESSES['ROUTE_ACCESS']['Description']);
            }
        }
    }

    public function getAll(DefaultRepository $sauceRepository)
    {
        echo $this->render('getAll.php', [
            'sauces' => $sauceRepository->findAll(),
            'count' => count(UserSession::$SUCCESSES)
        ]);
    }

    public function create()
    {
        echo $this->render('createSauce.html');
    }

    public function createPOST(DefaultRepository $sauceRepository)
    {
        $files = incoming_files();
        $imgUrl = '';
        if (count($files) === 1) {
            $file = $files[0];
            move_uploaded_file($file['tmp_name'], SITE_BASE_PATH.'public/img/'.$file['name']);
            $imgUrl = $file['name'];
            preg_match('/^[^?]*\.(php)/', $imgUrl, $match);
            if (isset($match[0]) && !empty($match[0])) {
                if ($this->getUser()->addSuccess(UserSession::$SUCCESSES['UPLOAD'])) {
                    $this->addFlash(
                        'UPLOAD_FOUND',
                        'Vous avez trouvé la faille Upload : ' . UserSession::$SUCCESSES['UPLOAD']['Description']);
                }
            }
        }

        $_POST['imageUrl'] = $imgUrl;
        $_POST['heat'] = (int) $_POST['heat'];
        $_POST['userId'] = (int) $this->getUser()->getId();
        $sauceRepository->createFrom($_POST);
        $this->redirectTo('app.sauce.getAll');
    }

    public function getOneById(string $id, DefaultRepository $sauceRepository)
    {
        $sauce = $sauceRepository->findAllBy('id', $id)[0];
        $likesDislikes = (new UserLikeDislikeSauce())->getRepository()->getLikeDislikeCount($sauce->id);
        echo $this->render('sauce.html', [
            'sauce' => $sauce,
            'likes' => $likesDislikes->likes,
            'dislikes' => $likesDislikes->dislikes,
            'userId' => $this->getUser()->getId()
        ]);
    }

    public function vulnerabilityHistory(DefaultRepository $successRepository)
    {
        echo $this->render('vulnerabilityHistory.html',
            ['vh' => array_map(function($el) use($successRepository) {
                $el['notfound'] = 'Pas trouvé';
                $el['found'] = '';
                $success = $successRepository->findOneWhere(['name = "' . $el['Name']. '"']);
                if ($success) {
                    $el['found'] = 'Trouvé';
                    $el['notfound'] = '';
                }
                return (object) $el;
            }, UserSession::$SUCCESSES)]
        );
    }
}