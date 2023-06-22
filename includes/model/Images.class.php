<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDO;
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
        $imageController = new ImageController();

        if (empty($this->imageId) && empty($this->name) && empty($this->createDate)) {
            return false;
        }
        //echo "aaaaa";

        if (!empty($this->imageId)) {
            $pdo = SPDO::getInstance();
            $query = "UPDATE images SET 
                 name = :name 
                 WHERE image_id = :imageId;";
                 $pdo->execPrepare($query);
                 $pdo->execBindValue(':name', $this->name, PDO::PARAM_STR);
                 $pdo->execBindValue(':imageId', $this->imageId, PDO::PARAM_INT);


        } else {
            $pdo = SPDO::getInstance();
            $query = "INSERT INTO images (name) VALUES (:name);";
            $pdo->execPrepare($query);
            $pdo->execBindValue(':name', $this->name, PDO::PARAM_STR);


        }

        return $pdo->execStatement();
    }


    public function delete(): PDOStatement|bool
    {
        if (empty($this->imageId)) {
            return false;
        }
        $pdo = SPDO::getInstance();
        $query = "DELETE FROM images WHERE image_id = :imageId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':imageId', $this->imageId, PDO::PARAM_INT);

        return $pdo->execStatement(false, true);
    }




    public function getLastInsertedId(): int
    {
        $pdo = SPDO::getInstance();

        return $pdo->getLastInsertedId();

    }

}