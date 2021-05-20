<?php

namespace Core\Modules\Security\BrutForce;

use Core\Model\AbstractRepository;

class AntiBrutForceDatabaseRepository extends AbstractRepository
{
    public function initTable()
    {
        $this->customQuery(
            'CREATE TABLE IF NOT EXISTS `'.$this->tableName.'` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `user_addr` varchar(128) NOT NULL,
                            `tries` varchar(255) NOT NULL,
                            `count` int(10) NOT NULL,
                            PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf32;'
        );
    }

    public function create(string $user_addr)
    {
        $this->customQuery(
            'INSERT INTO `' . $this->tableName .'` 
            (`user_addr`, `tries`, `count`) 
            VALUES ("' . $user_addr . '", "' . time() . '", 1)'
        );
    }

    public function update($entity)
    {
        $this->customQuery(
            'UPDATE `' . $this->tableName . '` 
                    SET `tries` = "' . $entity->tries . '", 
                    `count` = ' . $entity->count . ' 
                    WHERE `id` = ' . $entity->id
        );
    }
}