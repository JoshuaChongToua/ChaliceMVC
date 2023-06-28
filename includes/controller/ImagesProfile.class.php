<?php

namespace controller;

use common\Helper;
use common\SPDO;
use model\ImagesProfile as ImagesProfilesModel;
use PDO;
use PDOStatement;
use stdClass;

class ImagesProfile
{
    public function __construct()
    {
    }

    public function getOne(int $imageId): ImagesProfilesModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * from images_profile where image_id=:imageId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':imageId', $imageId, PDO::PARAM_INT);
        $image = $pdo->execQuery(true);

        if (!$image) {
            return false;
        }

        return new ImagesProfilesModel((object)$image);
    }


    public function getAll(int $userId = null): array|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM images_profile ";
        if (!empty($userId)) {
            $query .= "WHERE user_id = :userId;";
        }
        $pdo->execPrepare($query);
        if (!empty($userId)) {
            $pdo->execBindValue(':userId', $userId, PDO::PARAM_INT);
        }
        $images = $pdo->execQuery();

        if (!$images) {
            return false;
        }
        $return = [];
        foreach ($images as $image) {
            $return[] = new ImagesProfilesModel((object)$image);
        }

        return $return;
    }

    public function addNew(array $image): PDOStatement|bool
    {
        return $this->save($image);
    }

    public function update(array $image): PDOStatement|bool
    {
        return $this->save($image);
    }

    public function delete(array $imageId): PDOStatement|bool
    {
        $ImagesProfileModel = new ImagesProfilesModel((object)["image_id" => $imageId['id']]);
        $this->delImage($_SESSION['user_id'], $ImagesProfileModel->getImageId());

        return $ImagesProfileModel->delete();
    }

    private function save(array $image): PDOStatement|bool
    {
        $ImagesProfileModel = new ImagesProfilesModel((object)$image);
        if (!$ImagesProfileModel->save()) {
            return false;
        }

        return $this->addImage($_SESSION['user_id'], $ImagesProfileModel->getLastInsertedId());
    }

    public function verifyForm(array $array): bool
    {
        if (!isset($array['image_id']) && !isset($array['user_id'])) {
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

    private function addImage(int $userId, int $lastInsertedId): bool
    {
        if (!Helper::mkdirUser($userId)) {
            return false;
        }

        $file = $_FILES['image'];
        $tmpFilePath = $file['tmp_name'];
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $destination = 'includes/assets/images/profiles/' . $userId . '/' . $this->kodex_random_string($length = 10) . '.' . $fileExtension;

        if (!in_array($fileExtension, $allowedExtensions)) {
            return false;
        }
        if (!move_uploaded_file($tmpFilePath, $destination)) {
            // Le fichier a été téléchargé avec succès, vous pouvez effectuer d'autres actions si nécessaire
            //echo "L'image a été téléchargée avec succès.";
            return false;
        }
        $destination2 = 'includes/assets/images/profiles/' . $userId . '/' . $lastInsertedId . '.' . $fileExtension;
        if (!rename($destination, $destination2)) {
            return false;
        }

        return true;
    }

    private function delImage(int $userId, int $imageId): bool
    {
        $image = $this->getOne($imageId);
        //echo "<pre>" . print_r($image, true) . "</pre>";

        if ($image) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $filename = $imageId;
            $fileCollection = glob('includes/assets/images/profiles/' . $userId . '/' . $filename . '.*');
            $tempPath = 'includes/assets/images/profiles/' . $userId . '/' . $filename;
            foreach ($fileCollection as $filePath) {
                foreach ($allowedExtensions as $extension) {

                    if ($tempPath . '.' . $extension == $filePath) {
                        $filename = $imageId . '.' . $extension;
                        //echo "<pre>" . print_r($filename, true) . "</pre>";
                    }

                }
            }


            $imagePath = 'includes/assets/images/profiles/' . $userId . '/' . $filename;

            if (file_exists($imagePath)) {
                // Supprimer l'image du dossier
                unlink($imagePath);
                // Supprimer l'entrée correspondante dans la base de données
                return true;
            } else {
                return false;
            }
        } else {
            echo "L'image n'a pas été trouvée dans la base de données.";
        }
        return false;
    }


}