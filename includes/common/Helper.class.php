<?php

namespace common;

class Helper
{
    public static function crypt(string $string): string
    {
        return password_hash($string, PASSWORD_DEFAULT);

    }

    public static function uncrypt(string $passwordPost, string $passwordDb): bool
    {
        return password_verify($passwordPost, $passwordDb);
    }
}