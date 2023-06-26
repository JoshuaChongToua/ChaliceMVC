<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDO;
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

    public function save()
    {
        if (empty($this->typeId) && empty($this->role)) {
            return false;
        }

        if (!empty($this->typeId)) {
            $pdo = SPDO::getInstance();
            $query = "UPDATE users_types SET 
                 role = :role
                 WHERE type_id = :typeId;
            ";
            $pdo->execPrepare($query);
            $pdo->execBindValue(':role', $this->role, PDO::PARAM_STR);
            $pdo->execBindValue(':typeId', $this->typeId, PDO::PARAM_INT);
        } else {
            $pdo = SPDO::getInstance();
            $query = "INSERT INTO users_types (role) VALUES (:role)";
            $pdo->execPrepare($query);
            $pdo->execBindValue(':role', $this->role, PDO::PARAM_STR);

        }
        return $pdo->execStatement();
    }

    public function delete(): PDOStatement|bool
    {
        if (empty($this->typeId)) {
            return false;
        }
        $pdo = SPDO::getInstance();
        $query = "DELETE FROM users_types WHERE type_id = :typeId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':typeId', $this->typeId, PDO::PARAM_INT);


        return $pdo->execStatement();
    }

}