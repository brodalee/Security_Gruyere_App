<?php

namespace App\Controllers;

use Core\AbstractController;

class SauceController extends AbstractController
{

    public function getAll()
    {
    }

    public function create()
    {
        // POST['name'] POST['manufacturer'] POST['description'] POST['mainPepper'] FILE['image'] POST['heat']
    }

    public function delete()
    {
        // POST['id']
    }

    public function getOneById(string $id)
    {
    }

    public function likeSauce(string $sauceId)
    {

    }

    public function dislikeSauce(string $sauceId)
    {

    }
}