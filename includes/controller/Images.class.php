<?php

namespace controller;

use common\SPDO;
use model\Images as ImagesModel;
use PDO;
use PDOStatement;
use stdClass;

class Images
{

    public const ACTION_ADD = "add";
    public const ACTION_UPDATE = "update";
    public const ACTION_DELETE = "delete";

    public function __construct()
    {
    }

    public function getOne(int $imageId): ImagesModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * from images where image_id=:imageId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':imageId', $imageId, PDO::PARAM_INT);
        $image = $pdo->execQuery(true);
        if (!$image) {
            return false;
        }

        return new ImagesModel((object)$image);
    }

    public function getAll(): array|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM images;";
        $pdo->execPrepare($query);
        $images = $pdo->execQuery();
        if (!$images) {
            return false;
        }
        $return = [];
        foreach ($images as $image) {
            $return[] = new ImagesModel((object)$image);
        }

        return $return;
    }


    public function addNew(array $image): PDOStatement|bool
    {
        return $this->save($image, self::ACTION_ADD);
    }

    public function update(array $image): PDOStatement|bool
    {
        return $this->save($image, self::ACTION_UPDATE);
    }

    public function delete(array $imageId): PDOStatement|bool
    {
        $imageModel = new ImagesModel((object)["image_id" => $imageId['image_id']]);
        $this->delImage($imageModel->getImageId());
        return $imageModel->delete();
    }

    private function save(array $image, string $action): PDOStatement|bool
    {
        $imageModel = new ImagesModel((object)$image);
        $return = $imageModel->save();
        if ($action == self::ACTION_UPDATE) {
            return $return;
        }

        return $this->addImage($imageModel->getLastInsertedId());
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

    private function addImage(int $lastInsertId): bool
    {
        $file = $_FILES['image'];
        $tmpFilePath = $file['tmp_name'];
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $destination = 'includes/assets/images/upload/' . $this->kodex_random_string($length = 10) . '.' . $fileExtension;
        if (!in_array($fileExtension, $allowedExtensions)) {
            //echo "Le format de fichier n'est pas pris en charge. Veuillez sélectionner une image valide.";
            return false;
        }

        if (!move_uploaded_file($tmpFilePath, $destination)) {
            //echo "Une erreur s'est produite lors du téléchargement de l'image.";
            return false;
        }
        $destination2 = 'includes/assets/images/upload/' . $lastInsertId . '.' . $fileExtension;
        if (!rename($destination, $destination2)) {
            return false;
        }

        return true;

    }

    private function delImage(int $imageId): bool
    {
        $image = $this->getOne($imageId);
        if ($image) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $filename = $image->getImageId();
            $fileCollection = glob('includes/assets/images/upload/' . $filename . '.*');
            $tempPath = 'includes/assets/images/upload/' . $filename;
            foreach ($fileCollection as $filePath) {
                //echo "<pre>" . print_r($filePath, true) . "</pre>";
                foreach ($allowedExtensions as $extension) {

                    if ($tempPath . '.' . $extension == $filePath) {
                        $filename = $image->getImageId() . '.' . $extension;
                        //echo "<pre>" . print_r($filename, true) . "</pre>";
                    }

                }
            }


            $imagePath = 'includes/assets/images/upload/' . $filename;
            //echo "<pre>" . print_r($imagePath, true) . "</pre>";

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