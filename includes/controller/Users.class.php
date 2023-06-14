<?php

namespace controller;
use common\SPDO;
use model\Users as UserModel;
use PDOStatement;
use stdClass;
class Users
{

    public function __construct()
    {
    }

    public function getOne(int $userId): UserModel|bool
    {
        $query = "SELECT * from users where user_id='" . inval($userId) . "';";
        $user = $this->execQuery($query);
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
        $animeModel = new AnimeModel((object) $user);

        return $animeModel->save();
    }



    public function getRole($typeId): UserModel|bool
    {
        $query = "SELECT role FROM users_types WHERE type_id ='" . intval($typeId) . "';";
        $result = $this->execQuery($query);
        $user = $result->fetch();
        //echo "<pre>" . print_r($user, true) . "</pre>";

        if (!$user) {
            return false;
        }
        return new UserModel((object)$user);
    }

    public function getVerification($login, $password): UserModel|bool
    {
        $query = "SELECT * FROM users WHERE login='" . $login . "'";
        $result = $this->execQuery($query);
        $user = $result->fetch();
        //echo "<pre>" . print_r($user, true) . "</pre>";
        //echo $user['password'];

        if (password_verify($password, $user['password'])) {
            return new UserModel((object)$user);
        }
        return false;


    }

    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }
}