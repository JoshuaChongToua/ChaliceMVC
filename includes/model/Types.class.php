<?php

namespace model;

use common\SPDO;
use PDOStatement;
use stdClass;
class Types
{
    private int $typeId;
    private string $role;

    /**
     * @param int $typeId
     * @param string $role
     */
    public function __construct(stdClass $type = null)
    {
        if ($type !== null) {
            if (property_exists($type, 'type_id')) {
                $this->typeId = $type->type_id;
            }
            if (property_exists($type, 'role')) {
                $this->role = $type->role;
            }
        }
    }

    public function toArray(): array
    {
        return [
            'typeId' => $this->type_id,
            'role' => $this->role
        ];
    }

    /**
     * @return int
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     */
    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }
}