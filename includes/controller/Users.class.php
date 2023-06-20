<?php

namespace controller;
use common\SPDO;
use model\Users as UserModel;
use controller\UsersTypes as UsersTypesController;
use PDOStatement;
use stdClass;
class Users
{

    public function __construct()
    {
    }

    public function getOne(int $userId): UserModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * from users where user_id=:userId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':userId', $userId, PDO::PARAM_INT);
        $pdo->execQuery();
        $user = $pdo->fetch();
        if (!$user){
            return false;
        }

        return new UserModel((object)$user);
    }

    public function getAll(): array|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM users;";
        $pdo->execQuery($query);
        $users = $pdo->fetchAll();
        if (!$users) {
            return false;
        }

        return new UserModel((object) $users);
    }

    public function addNew(array $user): PDOStatement|bool
    {
        return $this->save($user);
    }

    public function update(array $user): PDOStatement|bool
    {
        return $this->save($user);
    }

    public function delete(int $userId): PDOStatement
    {
        $userModel = new UserModel((object) ["user_id" => $userId]);

        return $userModel->delete();
    }

    private function save(array $user): PDOStatement|bool
    {
        $userModel = new UserModel((object) $user);

        return $userModel->save();
    }



    public function getRole(int $userTypeId): ?string
    {
        $userTypeController = new UsersTypesController();
        $role = $userTypeController->getOne($userTypeId);
        //var_dump($role);

        if ($role === false) {
            return null;
        }

        return $role->getRole();
    }




    public function verifyForm(array $array): bool
    {
        if (!isset($array['login']) && !isset($array['password']) && !isset($array['type_id'])) {
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