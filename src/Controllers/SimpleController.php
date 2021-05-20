<?php

namespace App\Controllers;

use Core\AbstractController;

class SimpleController extends AbstractController
{

    public function homePage()
    {
        echo $this->render('home.html');
    }
}