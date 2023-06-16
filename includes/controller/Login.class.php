<?php

namespace controller;

use model\Users as UserModel;

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
        session_destroy() ;
    }

    private function getVerification($login, $password): UserModel|bool
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

    private function saveSession(UserModel $user): bool
    {
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['type_id'] = $user->getTypeId();
        //$_SESSION['role'] = $userController->getRole($_SESSION['type_id']);

        return true;
    }
}