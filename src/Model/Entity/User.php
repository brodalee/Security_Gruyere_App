<?php

namespace App\Model\Entity;

use Core\Interfaces\UserInterface;

class User implements UserInterface
{

    private $id;
    private $name;

    public function __construct()
    {
        $this->id = 43;
        $this->name = "airfbrz";
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