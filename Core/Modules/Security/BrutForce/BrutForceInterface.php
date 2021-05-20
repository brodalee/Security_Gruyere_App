<?php

namespace Core\Modules\Security\BrutForce;

interface BrutForceInterface
{
    public function isBlocked(): bool;
    public function incrementTry(): self;
    public function reset(): self;
}