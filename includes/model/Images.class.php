<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDOStatement;
use stdClass;
use controller\Images as ImageController;

class Images
{
    private int $imageId;
    private string $name;
    private string $createDate;


    public function __construct(StdClass $image)
    {
        if (property_exists($image, 'image_id')) {
            $this->imageId = intval($image->image_id);
        }
        if (property_exists($image, 'name')) {
            $this->name = $image->name;
        }
        if (property_exists($image, 'create_date')) {
            $this->createDate = $image->create_date;
        }
    }

    public function toArray(): array
    {
        return [
            'image_id' => $this->imageId,
            'name' => $this->name,
            'create_date' => $this->createDate
        ];
    }


    public function getImageId(): int
    {
        return $this->imageId;
    }


    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function getCreateDate(): string
    {
        return $this->createDate;
    }

    public function setCreateDate(string $createDate): void
    {
        $this->createDate = $createDate;
    }


    public function save(): PDOStatement|bool
    {
        //echo "<pre>" . print_r($this, true) . "</pre>";

        if (empty($this->imageId) && empty($this->name) && empty($this->createDate)) {
            return false;
        }
        //echo "aaaaa";

        if (!empty($this->imageId)) {
            $query = "UPDATE images SET 
                 name = '" . $this->name . "' 
                 WHERE image_id = '" . $this->imageId. "';
            ";
        } else {


                    $query = "INSERT INTO images (name) VALUES ('" . $filename . "');";
                    $destination2 = 'includes/assets/images/upload/' .  . '.' . $fileExtension;

                    if (rename($destination, $destination2)) {
                        echo 'Fichier bien renomee';
                    } else {
                        echo 'echec';
                    }
                } else {
                    echo "Une erreur s'est produite lors du téléchargement de l'image.";
                }
            } else {
                echo "Le format de fichier n'est pas pris en charge. Veuillez sélectionner une image valide.";
            }
        }

        return $this->execQuery($query);
    }


    public function delete(): PDOStatement|bool
    {
        if (empty($this->imageId)) {
            return false;
        }

        $query = "DELETE FROM images WHERE image_id = $this->imageId;";
        return $this->execQuery($query);
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


    private function execQuery(string $query): PDOStatement
    {
        $pdo = SPDO::getInstance();

        return $pdo->execQuery($query);
    }

}