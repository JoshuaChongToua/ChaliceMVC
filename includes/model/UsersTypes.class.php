<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDOStatement;
use stdClass;
class UsersTypes
{

    public const TYPE_ADMIN = 1;
    private int $typeId;
    private string $role;


    public function __construct(stdClass $type = null)
    {
        if ($type !== null) {
            if (property_exists($type, 'type_id')) {
                $this->typeId = intval($type->type_id);
            }
            if (property_exists($type, 'role')) {
                $this->role = $type->role;
            }
        }
    }

    public function toArray(): array
    {
        return [
            'typeId' => $this->typeId,
            'role' => $this->role
        ];
    }


    public function getTypeId(): int
    {
        return $this->typeId;
    }


    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }


    public function getRole(): string
    {
        return $this->role;
    }


    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function save(): PDOStatement|bool
    {
        if (empty($this->typeId) && empty($this->role) ) {
            return false;
        }

        if (!empty($this->typeId)) {
            $query = "UPDATE users_types SET 
                 role = '" . $this->role . "'
                 WHERE type_id = '" . $this->typeId . "';
            ";
        } else {
            $query = "INSERT INTO users_types (role) VALUES (
                                                     '" . $this->role . "'
)";
        }
        return $this->execQuery($query);
    }

    public function delete(): PDOStatement|bool
    {
        if (empty($this->typeId)) {
            return false;
        }

        $query = "DELETE FROM users_types WHERE type_id = $this->typeId;";
        return $this->execQuery($query);
    }
    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }
}