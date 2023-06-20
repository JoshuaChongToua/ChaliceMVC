<?php

namespace controller;

use common\SPDO;
use model\UsersTypes as TypesModel;
use PDOStatement;
use stdClass;

class UsersTypes
{

    public function __construct()
    {
    }

    public function getAll(): array|bool
    {
        $query = "SELECT * FROM users_types;";
        $types = $this->execQuery($query);
        if (!$types) {
            return false;
        }
        $return = [];
        foreach ($types as $type) {
            $return[] = new TypesModel((object) $type);
        }
        return $return;
    }

    public function getOne($typeId): TypesModel|bool
    {
        $query = "SELECT * FROM users_types WHERE type_id ='" . intval($typeId) . "';";
        $result = $this->execQuery($query);
        $type = $result->fetch();
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

    public function delete(array $array): PDOStatement
    {
        $typeModel = new TypesModel((object) ["type_id" => $typeId]);

        return $typeModel->delete();
    }

    private function save(array $type): PDOStatement|bool
    {
        $typeModel = new TypesModel((object) $type);

        return $typeModel->save();
    }

    public function verifyForm(array $array): bool
    {
        if (!isset($array['role'])) {
            return false;
        }

        return true;
    }



    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }

}