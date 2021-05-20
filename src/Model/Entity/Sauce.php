<?php

namespace App\Model\Entity;

use Core\Model\AbstractEntity;

class Sauce extends AbstractEntity
{
    public $id;
    public $name;
    public $userId;
    public $manufacturer;
    public $description;
    public $mainPepper;
    public $imageUrl;
    public $heat;

    public function __construct()
    {
        $this->tableName = "Sauce";
    }
}