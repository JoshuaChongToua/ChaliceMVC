<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDO;
use PDOStatement;
use stdClass;

class Profile
{
    private int $userId;
    private ?string $name;
    private ?string $firstName;
    private ?string $phone;
    private ?string $address;
    private ?string $email;
    private ?string $city;
    private int $imageId;

    public function __construct(StdClass $user)
    {

        //echo "<pre>" . print_r($user, true) . "</pre>";

        if (property_exists($user, 'user_id')) {
            $this->userId = intval($user->user_id);
        }
        if (property_exists($user, 'name')) {
            $this->name = $user->name;
        }
        if (property_exists($user, 'firstName')) {
            $this->firstName = $user->firstName;
        }
        if (property_exists($user, 'phone')) {
            $this->phone = $user->phone;
        }
        if (property_exists($user, 'address')) {
            $this->address = $user->address;
        }
        if (property_exists($user, 'email')) {
            $this->email = $user->email;
        }
        if (property_exists($user, 'city')) {
            $this->city = $user->city;
        }
        if (property_exists($user, 'image_id')) {
            $this->imageId = intval($user->image_id);
        }

    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'name' => $this->name,
            'firstName' => $this->firstName,
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
            'city' => $this->city,
            'imageId' => $this->imageId,

        ];
    }


    public function getUserId(): int
    {
        return $this->userId;
    }


    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }


    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }


    public function getPhone(): string
    {
        return $this->phone;
    }


    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }


    public function getAddress(): string
    {
        return $this->address;
    }


    public function setAddress(string $address): void
    {
        $this->address = $address;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


    public function getCity(): string
    {
        return $this->city;
    }


    public function setCity(string $city): void
    {
        $this->city = $city;
    }


    public function getImageId(): int
    {
        return $this->imageId;
    }


    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }

    public function save()
    {

        if (empty($this->userId) && empty($this->name) && empty($this->firstName) && empty($this->phone) && empty($this->address) && empty($this->email) && empty($this->city)) {
            return false;
        }
        //echo "<pre>" . print_r($this->userId, true) . "</pre>";

        if (!empty($this->userId)) {
            $pdo = SPDO::getInstance();
            $query = "UPDATE profile SET 
                 name = :name, 
                 firstname = :firstname, 
                 phone = :phone,
                 address = :address,
                 email = :email,
                 city = :city,
                 image_id = :imageId
                 
                 WHERE user_id = :userId;
            ";
            $pdo->execPrepare($query);
            $pdo->execBindValue(':name', $this->name ?? "", PDO::PARAM_STR);
            $pdo->execBindValue(':firstname', $this->firstName ?? "", PDO::PARAM_STR);
            $pdo->execBindValue(':phone', $this->phone ?? "", PDO::PARAM_STR);
            $pdo->execBindValue(':address', $this->address ?? "", PDO::PARAM_STR);
            $pdo->execBindValue(':email', $this->email ?? "", PDO::PARAM_STR);
            $pdo->execBindValue(':city', $this->city ?? "", PDO::PARAM_STR);
            $pdo->execBindValue(':imageId', $this->imageId ?? "", PDO::PARAM_INT);
            $pdo->execBindValue(':userId', $this->userId ?? "", PDO::PARAM_INT);
        }

        return $pdo->execStatement();
    }


}