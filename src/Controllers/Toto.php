<?php

namespace App\Controllers;

use Core\AbstractController;

class Toto extends AbstractController
{
    function toto()
    {
        echo $this->render('toto.html');
    }
}