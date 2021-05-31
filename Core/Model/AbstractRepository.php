<?php

namespace Core\Model;

use PDO;

abstract class AbstractRepository
{
    protected $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    protected function getDb()
    {
        $config = require 'Config/database_config.php';
        return DBFactory::get($config['type']);
    }

    public function createFrom($data)
    {
        $c = $data;
        $names = '';
        $values = '';
        if (is_object($data)) {
            $c = get_object_vars($data);
        }
        foreach ($c as $name => $value) {
            if (trim($names) !== '') $names.=', ';
            $names .= "`$name`";
            if (trim($values) !== '') $values.=', ';
            if (is_int($value)) {
                $values .= "$value";
            } else {
                $values .= "'$value'";
            }
        }
        $this->customQuery("
            INSERT INTO `{$this->tableName}` ({$names}) VALUES({$values})
        ");
    }

    public function findAll()
    {
        $table = $this->tableName;
        $prep = $this->getDb()->prepare("SELECT * FROM $table");
        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_CLASS);
    }

    public function findOneBy(string $field, $value)
    {
        $table = $this->tableName;
        $prep = $this->getDb()->prepare("SELECT * FROM $table WHERE $field = ?");
        $prep->execute([$value]);
        return $prep->fetchObject();
    }

    public function findAllBy(string $field, $value)
    {
        $table = $this->tableName;
        $prep = $this->getDb()->prepare("SELECT * FROM $table WHERE $field = ?");
        $prep->execute([$value]);
        return $prep->fetchAll(PDO::FETCH_CLASS);
    }

    public function findAllWhere(array $conditions)
    {
        $c = "";
        foreach ($conditions as $condition) {
            if (trim($c) === "") {
                $c .= " WHERE $condition ";
            } else {
                $c .= " AND $condition ";
            }
        }
        $table = $this->tableName;
        $prep = $this->getDb()->prepare("SELECT * FROM $table $c");
        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_CLASS);
    }

    public function findOneWhere(array $conditions)
    {
        $c = "";
        foreach ($conditions as $condition) {
            if (trim($c) === "") {
                $c .= " WHERE $condition ";
            } else {
                $c .= " AND $condition ";
            }
        }
        $table = $this->tableName;
        $prep = $this->getDb()->prepare("SELECT * FROM $table $c");
        $prep->execute();
        return $prep->fetchObject();
    }

    public function customQuery(string $query, array $parameters = [], bool $asArray = true)
    {
        $prep = $this->getDb()->prepare($query);
        $prep->execute($parameters);
        if ($asArray) return $prep->fetchAll(PDO::FETCH_CLASS);
        return $prep->fetchObject();
    }

    public function deleteById($id)
    {
        $table = $this->tableName;
        $prep = $this->getDb()->prepare("DELETE FROM $table WHERE id = ?");
        return $prep->execute([$id]);
    }

    public function deleteByField(string $field, $value)
    {
        $table = $this->tableName;
        $prep = $this->getDb()->prepare("DELETE FROM `$table` WHERE $field = ?");
        return $prep->execute([$value]);
    }
}