<?php

namespace App\Controllers;

use App\Model\Repository\LikeDislikeSauceRepository;
use Core\AbstractController;

class ApiController extends AbstractController
{
    public function like($id, LikeDislikeSauceRepository $likeDislikeSauceRepository)
    {
        $data = json_decode(file_get_contents("php://input"));
        if ($likeDislikeSauceRepository->hasAlreadyLikedSauce($id, $data->userId) === true) {
            $likeDislikeSauceRepository->deleteLikeToSauce($id, $data->userId);
            echo $this->renderJson('OK-');
        } else {
            $likeDislikeSauceRepository->addLikeToSauce($id, $data->userId);
            echo $this->renderJson('OK+');
        }
    }

    public function dislike($id, LikeDislikeSauceRepository $likeDislikeSauceRepository)
    {
        $data = json_decode(file_get_contents("php://input"));
        if ($likeDislikeSauceRepository->hasAlreadyDislikedSauce($id, $data->userId) === true) {
            $likeDislikeSauceRepository->deleteDislikeSauce($id, $data->userId);
            echo $this->renderJson('OK-');
        } else {
            $likeDislikeSauceRepository->addDislikeSauce($id, $data->userId);
            echo $this->renderJson('OK+');
        }
    }
}