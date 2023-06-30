<?php

namespace common;

class Helper
{
    public const IMG_DIR_UPLOAD = 'upload';
    public const IMG_DIR_PROFILES = 'profiles/';
    public static function crypt(string $string): string
    {
        return password_hash($string, PASSWORD_DEFAULT);

    }

    public static function uncrypt(string $passwordPost, string $passwordDb): bool
    {
        return password_verify($passwordPost, $passwordDb);
    }

    public static function getImage(string $id, string $dir): string
    {
        $imageDirectory = '/home/bjxo0033/chaliceautumn/admin/includes/assets/images/' . $dir . '/';
        $urlDirectory = '/admin/includes/assets/images/' . $dir . '/';

        foreach (['jpg', 'jpeg', 'png'] as $extension) {
            //echo $imageDirectory . $id . '.' . $extension . '<br>';
            if (file_exists($imageDirectory . $id . '.' . $extension)) {
                return $urlDirectory . $id . '.' . $extension;
            }
        }
        return $urlDirectory . "default.png";
    }

    public static function mkdirUser(int $userId): bool
    {
        $path = "/home/bjxo0033/chaliceautumn/admin/includes/assets/images/profiles/" . $userId;
        if (!is_dir($path)) {
            return mkdir($path, 0755, true);
        }

        return true;
    }
}

