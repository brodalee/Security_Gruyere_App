<?php

namespace App\Controllers;

use Core\Model\DefaultRepository;

class SuccessController
{

    public function add(DefaultRepository $successRepository)
    {
        var_dump($successRepository);
    }
}