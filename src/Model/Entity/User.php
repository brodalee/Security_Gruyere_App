<?php

namespace App\Model\Entity;

use Core\Interfaces\UserInterface;
use Core\Model\AbstractEntity;

class User extends AbstractEntity implements UserInterface
{
    public $id;
    public $pseudo;
    public $password;

    public function __construct()
    {
        $this->tableName = "User";
    }

    public function getRole()
    {
        return 'USER';
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return 'toto';
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->name
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->name
            ) = unserialize($serialized, ["allowed_class" => false]);
    }
}