<?php

namespace common;

class Helper
{
    public const IMG_DIR_UPLOAD = 'upload';
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
        $imageDirectory = 'includes/assets/images/' . $dir . '/';

        foreach (['jpg', 'jpeg', 'png'] as $extension) {
            if (file_exists($imageDirectory . $id . '.' . $extension)) {
                return $imageDirectory . $id . '.' . $extension;
            }
        }
        return $imageDirectory . "default.png";
    }
}

