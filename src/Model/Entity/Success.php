<?php

namespace App\Model\Entity;

use Core\Model\AbstractEntity;

class Success extends AbstractEntity
{

    public $id;
    public $name;

    public function __construct()
    {
        $this->tableName = "Success";
    }
}