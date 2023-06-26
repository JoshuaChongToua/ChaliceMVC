<?php

namespace controller;

use common\SPDO;
use model\UsersTypes as TypesModel;
use PDO;
use PDOStatement;
use stdClass;

class UsersTypes
{

    public function __construct()
    {
    }

    public function getAll(): array|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM users_types;";
        $pdo->execPrepare($query);
        $types = $pdo->execQuery();
        if (!$types) {
            return false;
        }
        $return = [];
        foreach ($types as $type) {
            $return[] = new TypesModel((object)$type);
        }
        return $return;
    }

    public function getOne($typeId): TypesModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM users_types WHERE type_id =:typeId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':typeId', intval($typeId), PDO::PARAM_INT);
        $type = $pdo->execQuery(true);
        //echo "<pre>" . print_r($type, true) . "</pre>";

        if (!$type) {
            return false;
        }
        return new TypesModel((object)$type);
    }

    public function addNew(array $type): PDOStatement|bool
    {
        return $this->save($type);
    }

    public function update(array $type): PDOStatement|bool
    {
        return $this->save($type);
    }

    public function delete(array $typeId): PDOStatement|bool
    {
        $typeModel = new TypesModel((object)["type_id" => $typeId['type_id']]);

        return $typeModel->delete();
    }

    private function save(array $type): PDOStatement|bool
    {
        $typeModel = new TypesModel((object)$type);

        return $typeModel->save();
    }

    public function verifyForm(array $array): bool
    {
        if (!isset($array['role'])) {
            return false;
        }

        return true;
    }


}