<?php

namespace Core\Interfaces;

interface UserInterface
{

    public function getRole();

    public function getSalt();

    public function getUsername();

    public function serialize();

    public function unserialize($serialized);
}