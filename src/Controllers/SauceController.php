<?php

namespace App\Controllers;

use Core\AbstractController;
use Core\Model\DefaultRepository;

class SauceController extends AbstractController
{

    public function __construct()
    {
        if ($this->getUser() == null) {
            $this->redirectTo('app.login.get');
        }
    }

    public function getAll(DefaultRepository $sauceRepository)
    {
        $sauces = $sauceRepository->findAll();
        /*echo $this->render('getAll.php', [
            'sauces' => $sauceRepository->findAll()
        ]);*/
        include './src/templates/getAll.php';
    }

    public function create(DefaultRepository $sauceRepository)
    {
        // POST['name'] POST['manufacturer'] POST['description'] POST['mainPepper'] FILE['image'] POST['heat']
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