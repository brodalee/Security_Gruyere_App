<?php

namespace Core\Pattern;

use Exception;

class Singleton
{
    /**
     * @var Singleton
     */
    private static $instance;

    private function __construct() {}

    /**
     * Get an instance of SuperSingleton
     *
     * @return Singleton
     */
    public static function getInstanceClass(): Singleton
    {
        if (self::$instance === null) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }

    /**
     * Verify, and return a unique instance of the commanded class
     *
     * @param string $className name(space) of the wanted instance
     * @param null $arg
     *
     * @return object $className
     *
     * @throws Exception
     */
    public function getInstance(string $className, $arg = null): object
    {
        if (class_exists($className)) {
            return $this->setAttribute($className, $className, $arg);
        }

        throw new Exception("");
    }

    private function setAttribute(string $name, string $class, $arg)
    {
        $name = str_replace('\\', '', $name);
        if (!$this->obj($name)) {
            if ($arg !== null) {
                $this->$name = (object) new $class($arg);
                return $this->$name;
            }
            $this->$name = (object) new $class();
        }
        return $this->$name;
    }

    private function obj(string $name): bool
    {
        foreach (get_object_vars($this) as $key) {
            if ($name === $key) {
                return true;
            }
        }
        return false;
    }
}