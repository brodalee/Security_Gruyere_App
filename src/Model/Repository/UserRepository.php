<?php

namespace App\Model\Repository;

use Core\Model\AbstractRepository;

class UserRepository extends AbstractRepository
{

    public function create(string $pseudo, string $password)
    {
        return $this->customQuery(
            "INSERT INTO `{$this->tableName}` (`id`, `pseudo`, `password`) 
                    VALUES (NULL, '$pseudo', '$password')"
        );
    }
}