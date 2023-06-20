<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDOStatement;
use stdClass;
class Users
{
    private int $userId;
    private string $login;
    private string $password;
    private int $typeId;
    private string $createDate;


    public function __construct(StdClass $user)
    {

            //echo "<pre>" . print_r($user, true) . "</pre>";

            if (property_exists($user, 'user_id')) {
                $this->userId =  intval($user->user_id);
            }
            if (property_exists($user, 'login')) {
                $this->login = $user->login;
            }
            if (property_exists($user, 'password')) {
                $this->password = $user->password;
            }
            if (property_exists($user, 'type_id')) {
                $this->typeId = intval($user->type_id);
            }
            if (property_exists($user, 'create_date')) {
                $this->createDate = $user->create_date;
            }

    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'login' => $this->login,
            'passeword' => $this->password,
            'typeId' => $this->typeId,
            'createDate' => $this->createDate
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
    public function getCreateDate(): string
    {
        return $this->createDate;
    }

    /**
     * @param string $createDate
     */
    public function setCreateDate(string $createDate): void
    {
        $this->createDate = $createDate;
    }


    public function save(): PDOStatement|bool
    {
        echo "<pre>" . print_r($this, true) . "</pre>";

        if (empty($this->userId) && empty($this->login) && empty($this->password) && empty($this->typeId) && empty($this->createDate)) {
            return false;
        }

        if (!empty($this->userId)) {
            $pdo = SPDO::getInstance();
            $query = "UPDATE users SET 
                 login = :login, 
                 password = :password, 
                 type_id = :typeId
                 WHERE user_id = :userId;
            ";
            $pdo->execPrepare($query);
            $pdo->execBindValue(':login', $this->login, PDO::PARAM_STR);
            $pdo->execBindValue(':password', Helper::crypt($this->password), PDO::PARAM_STR);
            $pdo->execBindValue(':typeId', $this->typeId, PDO::PARAM_STR);
            $pdo->execBindValue(':userId', $this->userId, PDO::PARAM_INT);

        } else {
            $pdo = SPDO::getInstance();
            $query = "INSERT INTO users (login, password, type_id) VALUES (
                                                     '" . $this->login . "',
                                                     '" . Helper::crypt($this->password) . "',
                                                     '" . $this->typeId . "'
)";
            $pdo->execPrepare($query);
            $pdo->execBindValue(':login', $this->login, PDO::PARAM_STR);
            $pdo->execBindValue(':password', Helper::crypt($this->password), PDO::PARAM_STR);
            $pdo->execBindValue(':typeId', $this->typeId, PDO::PARAM_STR);
        }

        return $pdo->execQuery();
    }

    public function delete(): PDOStatement|bool
    {
        if (empty($this->userId)) {
            return false;
        }
        $pdo = SPDO::getInstance();
        $query = "DELETE FROM users WHERE user_id = :userId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':userId', $this->userId, PDO::PARAM_INT);
        return $pdo->execQuery($query);
    }

    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }
}

