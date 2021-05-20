<?php

namespace Core\Modules\Security\CSRF;

class Csrf
{
    private $token;
    private $expiration_time;
    private $generated_time;

    public function __construct(string $token, int $expiration_time)
    {
        $this->token = $token;
        $this->expiration_time = time() + $expiration_time;
        $this->generated_time = time();
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return Csrf
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpirationTime()
    {
        return $this->expiration_time;
    }

    /**
     * @param mixed $expiration_time
     * @return Csrf
     */
    public function setExpirationTime($expiration_time)
    {
        $this->expiration_time = $expiration_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeneratedTime()
    {
        return $this->generated_time;
    }
}