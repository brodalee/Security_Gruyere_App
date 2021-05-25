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
        // TODO : FAILLE "ROUTE_ACCESS".
        parent::__construct();
    }

    public function getAll(DefaultRepository $sauceRepository)
    {
        // TODO : FAILLE "XSS".
        $sauces = $sauceRepository->findAll();
        include './src/templates/getAll.php';
    }

    public function create()
    {
        echo $this->render('createSauce.html');
    }

    public function createPOST(DefaultRepository $sauceRepository)
    {
        var_dump($_POST, $_FILES);
        // TODO : Faille "UPLOAD"
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