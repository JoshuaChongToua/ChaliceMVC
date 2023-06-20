<?php

namespace controller;

use common\SPDO;
use model\Images as ImagesModel;
use PDOStatement;
use stdClass;
class Images
{

    public function __construct()
    {
    }

    public function getOne(int $imageId): UserModel|bool
    {


        $pdo = SPDO::getInstance();
        $query = "SELECT role FROM users_types WHERE type_id =:id;";
        $pdo->execPrepare($query);
        $pdo->execBindValue();
        $pdo->execQuery();


        $query = "SELECT * from images where image_id='" . intval($imageId) . "';";
        $result = $this->execQuery($query);
        $image = $result->fetch();
        if (!$image){
            return false;
        }

        return new ImagesModel((object)$image);
    }

    public function getAll(): array|bool
    {
        $query = "SELECT * FROM images;";
        $images = $this->execQuery($query);
        if (!$images) {
            return false;
        }
        $return = [];
        foreach ($images as $image) {
            $return[] = new ImagesModel((object) $image);
        }

        return $return;
    }

    function getImage(string $id)
    {
        $imageDirectory = 'includes/assets/images/upload/';

        foreach (['jpg', 'jpeg', 'png'] as $extension) {
            if (file_exists($imageDirectory . $id . '.' . $extension)) {
                return $imageDirectory . $id . '.' . $extension;
            }
        }

        return $imageDirectory . "default.png";
    }

    public function addNew(array $image): PDOStatement|bool
    {
        return $this->save($image);
    }

    public function update(array $image): PDOStatement|bool
    {
        return $this->save($image);
    }

    public function delete(int $imageId): PDOStatement
    {
        $imageModel = new ImagesModel((object) ["user_id" => $imageId]);

        return $imageModel->delete();
    }

    private function save(array $image): PDOStatement|bool
    {
        $imageModel = new ImagesModel((object) $image);

        return $imageModel->save();
    }

    public function verifyForm(array $array): bool
    {
        if (!isset($array['name'])) {
            //var_dump($array);
            return false;
        }

        return true;
    }

    public function kodex_random_string($length = 20): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

    public function



    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }

}