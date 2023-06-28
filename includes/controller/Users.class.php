<?php

namespace controller;
use common\SPDO;
use model\Users as UsersModel;
use controller\UsersTypes as UsersTypesController;
use PDO;
use PDOStatement;
use stdClass;
class Users
{

    public function __construct()
    {
    }

    public function getOne(int $userId): UsersModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * from users where user_id=:userId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':userId', $userId, PDO::PARAM_INT);
        $user = $pdo->execQuery(true);
        if (!$user){
            return false;
        }

        return new UsersModel((object)$user);
    }

    public function getAll(): array|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM users;";
        $pdo->execPrepare($query);
        $users = $pdo->execQuery();
        if (!$users) {
            return false;
        }

        $return = [];
        foreach ($users as $user) {
            $return[] = new UsersModel((object) $user);
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

    public function delete(array $userId): PDOStatement|bool
    {
        $userModel = new UsersModel((object) ["user_id" => $userId['id']]);

        return $userModel->delete();
    }

    private function save(array $user): PDOStatement|bool
    {
        $userModel = new UsersModel((object) $user);

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
        //echo "<pre>" . print_r($array, true) . "</pre>";

        if (!isset($array['login']) && !isset($array['password']) && !isset($array['type_id'])) {
            return false;
        }

        return true;
    }


}