<?php

namespace Core\Modules\Security\BrutForce;

class AntiBrutForceSession extends AbstractBrutForce
{

    public function __construct()
    {
        $this->initAddrSession();
    }

    /**
     * Return if user request is blocked or not.
     *
     * @return boolean
     */
    public function isBlocked(): bool
    {
        $addrSession = $_SESSION[$this->getClientAddr()]['tries'];
        if (count($addrSession) >= $this->maxTry) {
            $lastTry = $_SESSION[$this->getClientAddr()]['tries'][count($_SESSION[$this->getClientAddr()]['tries']) - 1];
            if ( ($lastTry + $this->blockedTime * $this->getCurrentCount()) < time() ) {
                $this->resetTries()
                    ->incrementCount();
                return false;
            }
            return true;
        }
        return count($addrSession) >= $this->maxTry;
    }

    /**
     * Increment current tries.
     *
     * @return $this
     */
    public function incrementTry(): BrutForceInterface
    {
        $this->initAddrSession();
        $_SESSION[$this->getClientAddr()]["tries"][] = time();
        return $this;
    }

    /**
     * Reset client addr session.
     *
     * @return $this
     */
    public function reset(): BrutForceInterface
    {
        $_SESSION[$this->getClientAddr()] = ["tries" => [], "count" => 1];
        return $this;
    }

    /**
     * Initialize client addr session brut force.
     */
    private function initAddrSession()
    {
        if (!isset($_SESSION[$this->getClientAddr()])) {
            $_SESSION[$this->getClientAddr()] = ["tries" => [], "count" => 1];
        }
    }

    /**
     * Reset current tries.
     *
     * @return $this
     */
    protected function resetTries(): AbstractBrutForce
    {
        $_SESSION[$this->getClientAddr()]["tries"] = [];
        return $this;
    }

    /**
     * Increment current count.
     *
     * @return $this
     */
    protected function incrementCount(): AbstractBrutForce
    {
        $_SESSION[$this->getClientAddr()]['count'] = $_SESSION[$this->getClientAddr()]['count'] + 1;
        return $this;
    }

    /**
     * Return current count of tries chaining.
     *
     * @return int
     */
    protected function getCurrentCount(): int
    {
        return $_SESSION[$this->getClientAddr()]['count'];
    }
}