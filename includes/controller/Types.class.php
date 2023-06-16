<?php

namespace controller;

use common\SPDO;
use model\Types as TypesModel;
use PDOStatement;
use stdClass;

class Types
{

    public function __construct()
    {
    }

    public function getAllTypes(): array|bool
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

    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }

}