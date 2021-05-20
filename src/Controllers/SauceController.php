<?php

namespace App\Controllers;

use Core\AbstractController;
use Core\Model\DefaultRepository;

class SauceController extends AbstractController
{

    public function getAll(DefaultRepository $sauceRepository)
    {
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
    }

    public function likeSauce(string $sauceId, DefaultRepository $sauceRepository)
    {
    }

    public function dislikeSauce(string $sauceId, DefaultRepository $sauceRepository)
    {
    }
}