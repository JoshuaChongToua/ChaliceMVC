<?php

namespace controller;

use common\Helper;
use common\SPDO;
use model\Users as UserModel;
use PDO;
use PDOStatement;

class Login
{

    public function __construct()
    {
    }

    public function verifyForm(array $array): bool
    {
        if (!isset($array['login']) && !isset($array['password'])) {
            return false;
        }
        $user = $this->getVerification($array['login'], $array['password']);
        if (!$user) {
            return false;
        }

        return $this->saveSession($user);
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
    }

    private function getVerification($login, $password): UserModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM users WHERE login=:login";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':login', $login, PDO::PARAM_STR);
        $user = $pdo->execQuery(true);
        //echo "<pre>" . print_r($user, true) . "</pre>";
        //echo $user['password'];
        if (!$user) {
            return false;
        }
        if (Helper::uncrypt($password, $user['password'])) {
            return new UserModel((object)$user);
        }

        return false;
    }

    private function saveSession(UserModel $user): bool
    {
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['type_id'] = $user->getTypeId();

        return true;
    }


}