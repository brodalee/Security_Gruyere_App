<?php

namespace Core\Modules\Security\BrutForce;

abstract class AbstractBrutForce implements BrutForceInterface
{
    protected $maxTry = 5;
    protected $blockedTime = 300;

    /**
     * Return client addr.
     *
     * @return string
     */
    protected function getClientAddr(): string
    {
        return filter_input(INPUT_SERVER, 'REMOTE_ADDR');
    }

    abstract protected function resetTries(): self;
    abstract protected function incrementCount(): self;
    abstract protected function getCurrentCount(): int;
}