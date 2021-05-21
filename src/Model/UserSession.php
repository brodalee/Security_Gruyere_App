<?php

namespace App\Model;

use App\Model\Entity\User;
use Core\Interfaces\UserInterface;

class UserSession implements UserInterface
{
    private $id;
    private $role;
    private $pseudo;

    public function __construct($user = NULL, string $role = 'USER')
    {
        $this->role = $role;
        if ($user != NULL) {
            $this->pseudo = $user->pseudo;
            $this->id = $user->id;
        }
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->pseudo;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->pseudo,
            $this->role
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->pseudo,
            $this->role
            ) = unserialize($serialized, ["allowed_class" => false]);
    }
}