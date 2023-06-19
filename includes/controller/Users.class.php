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
        $query = "SELECT * from users where user_id='" . intval($userId) . "';";
        $result = $this->execQuery($query);
        $user = $result->fetch();
        if (!$user){
            return false;
        }
        return new UserModel((object)$user);
    }

    public function getAll(): array|bool
    {
        $query = "SELECT * FROM users;";
        $users = $this->execQuery($query);
        if (!$users) {
            return false;
        }
        $return = [];
        foreach ($users as $user) {
            $return[] = new UserModel((object) $user);
        }
        return $return;
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