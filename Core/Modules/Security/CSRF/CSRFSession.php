<?php

namespace Core\Modules\Security\CSRF;

class CSRFSession
{
    /**
     * @return Csrf
     */
    public function getCsrf(): Csrf
    {
        return $_SESSION['csrf'];
    }

    /**
     * Return if token is expired.
     *
     * @return bool
     */
    public function isTokenExpired(): bool
    {
        if(!isset($_SESSION['csrf'])) return true;
        return $this->getCsrfSession()->getExpirationTime() < time();
    }

    /**
     * Return if token is still valid.
     *
     * @param string $token
     * @return bool
     */
    public function isTokenValid(string $token): bool
    {
        if (!isset($_SESSION['csrf'])) return false;
        return base64_decode($token) === $this->getCsrfSession()->getToken();
    }

    /**
     * Return the token.
     *
     * @return string
     */
    public function getToken(): string
    {
        if (!isset($_SESSION['csrf'])) return '';
        return base64_encode($this->getCsrfSession()->getToken());
    }

    /**
     * Create csrf token in session.
     *
     * @param int $expiration_time
     * @return $this
     */
    public function createCsrfInSession(int $expiration_time = 60): self
    {
        $token = uniqid(rand(), true);
        $csrf = new Csrf($token, $expiration_time);
        $_SESSION['csrf'] = base64_encode(serialize($csrf));
        return $this;
    }

    /**
     * Return csrf session object.
     *
     * @return Csrf
     */
    private function getCsrfSession(): Csrf
    {
        return unserialize(base64_decode($_SESSION['csrf']));
    }
}