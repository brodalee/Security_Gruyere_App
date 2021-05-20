<?php

namespace Core\Modules\Security\BrutForce;

use Core\Model\AbstractEntity;

class AntiBrutForceDatabaseEntity extends AbstractEntity
{

    public function __construct()
    {
        $this->tableName = "Client_Session_Tries";
        $this->repositoryName = AntiBrutForceDatabaseRepository::class;
        $this->initTable();
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function initTable()
    {
        return $this->getRepository()->initTable();
    }
}