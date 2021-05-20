<?php

namespace Core\Model;

use Core\Pattern\Singleton;

abstract class AbstractEntity
{
    protected $repositoryName = DefaultRepository::class;

    protected $tableName = "";

    public function getRepository(): AbstractRepository
    {
        return Singleton::getInstanceClass()->getInstance($this->repositoryName, $this->tableName);
    }
}