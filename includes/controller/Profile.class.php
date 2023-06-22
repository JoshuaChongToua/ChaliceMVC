<?php

namespace controller;
use common\SPDO;
use model\Profile as ProfileModel;
use PDO;
use PDOStatement;
use stdClass;

class Profile
{

    public function __construct()
    {
    }

    public function getOne(int $userId): ProfileModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * from profile where user_id=:userId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':userId', $userId, PDO::PARAM_INT);
        $user = $pdo->execQuery(true);
        if (!$user){
            return false;
        }

        return new ProfileModel((object)$user);
    }

    public function getAll(): array|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM profile;";
        $pdo->execPrepare($query);
        $users = $pdo->execQuery();
        if (!$users) {
            return false;
        }

        $return = [];
        foreach ($users as $user) {
            $return[] = new ProfileModel((object) $user);
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
        $userModel = new ProfileModel((object) ["user_id" => $userId['user_id']]);

        return $userModel->delete();
    }

    private function save(array $user): PDOStatement|bool
    {
        $userModel = new ProfileModel((object) $user);

        return $userModel->save();
    }
    public function verifyForm(array $array): bool
    {
        //echo "<pre>" . print_r($array, true) . "</pre>";

        return true;
    }
}