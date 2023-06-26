<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDO;
use PDOStatement;
use stdClass;

class ImagesProfile
{
    private int $imageId;
    private int $userId;

    public function __construct(StdClass $imageProfile)
    {
        if (property_exists($imageProfile, 'image_id')) {
            $this->imageId = intval($imageProfile->image_id);
        }
        if (property_exists($imageProfile, 'user_id')) {
            $this->userId = intval($imageProfile->user_id);
        }
    }

    public function toArray(): array
    {
        return [
            'imageId' => $this->imageId,
            'userId' => $this->userId
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


    public function getUserId(): int
    {
        return $this->userId;
    }


    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function save()
    {
        //echo "<pre>" . print_r($this, true) . "</pre>";

        if (empty($this->imageId) && empty($this->userId)) {
            return false;
        }
        $pdo = SPDO::getInstance();
        $query = "INSERT INTO images_profile(user_id) VALUES (:userId);";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':userId', $this->userId, PDO::PARAM_INT);

        return $pdo->execStatement();
    }

    public function delete(): PDOStatement|bool
    {
        if (empty($this->imageId)) {
            return false;
        }
        $pdo = SPDO::getInstance();
        $query = "DELETE FROM images_profile WHERE image_id = :imageId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':imageId', $this->imageId, PDO::PARAM_INT);

        return $pdo->execStatement();
    }

    public function getLastInsertedId(): int
    {
        $pdo = SPDO::getInstance();

        return $pdo->getLastInsertedId();

    }
}