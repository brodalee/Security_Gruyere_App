<?php

namespace Core\Modules\Security\BrutForce;

class AntiBrutForceDatabase extends AbstractBrutForce
{
    private $_db;

    public function __construct()
    {
        $this->_db = new AntiBrutForceDatabaseEntity();
    }

    /**
     * Reset current tries.
     *
     * @return $this
     */
    protected function resetTries(): BrutForceInterface
    {
        $entity = $this->_db->getRepository()->findOneBy('user_addr', $this->getClientAddr());
        if ($entity == false) return $this;

        $entity->tries = '';
        $this->_db->getRepository()->update($entity);
        return $this;
    }

    /**
     * Increment current count.
     *
     * @return $this
     */
    protected function incrementCount(): BrutForceInterface
    {
        $entity = $this->_db->getRepository()->findOneBy('user_addr', $this->getClientAddr());
        if ($entity == false) return $this;

        $entity->count = (int) $entity->count + 1;
        $this->_db->getRepository()->update($entity);
        return $this;
    }

    /**
     * Return current count of tries chaining.
     *
     * @return int
     */
    protected function getCurrentCount(): int
    {
        $entity = $this->_db->getRepository()->findOneBy('user_addr', $this->getClientAddr());
        if ($entity == false) return 0;
        return $entity->count;
    }

    /**
     * Return if user request is blocked or not.
     *
     * @return boolean
     */
    public function isBlocked(): bool
    {
        $entity = $this->_db->getRepository()->findOneBy('user_addr', $this->getClientAddr());
        if ($entity == false) return false;

        $tries = explode(',', $entity->tries);
        if (count($tries) >= $this->maxTry) {
            $lastTry = $tries[count($tries) - 1];
            if ( ($lastTry + $this->blockedTime * (int) $entity->count) < time() ) {
                $entity->tries = '';
                $entity->count = (int) $entity->count += 1;
                $this->_db->getRepository()->update($entity);
            }
            return true;
        }
        return count($tries) >= $this->maxTry;
    }

    /**
     * Increment current tries.
     *
     * @return $this
     */
    public function incrementTry(): BrutForceInterface
    {
        $entity = $this->_db->getRepository()->findOneBy('user_addr', $this->getClientAddr());
        if ($entity == false) {
            $this->_db->getRepository()->create($this->getClientAddr());
        } else {
            $tries = explode(',', $entity->tries);
            $tries[] = time();
            $entity->tries = implode(',', $tries);
            $this->_db->getRepository()->update($entity);
        }
        return $this;
    }

    /**
     * Reset client addr session.
     *
     * @return $this
     */
    public function reset(): BrutForceInterface
    {
        $entity = $this->_db->getRepository()->findOneBy('user_addr', $this->getClientAddr());
        if ($entity == false) return $this;

        $entity->tries = '';
        $entity->count = 1;
        $this->_db->getRepository()->update($entity);
        return $this;
    }
}