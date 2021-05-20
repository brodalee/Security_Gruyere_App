<?php

namespace App\Model\Entity;

use App\Model\Repository\UserRepository;
use Core\Model\AbstractEntity;

class User extends AbstractEntity
{
    public $id;
    public $pseudo;
    public $password;

    public function __construct()
    {
        $this->tableName = "User";
        $this->repositoryName = UserRepository::class;
    }
}