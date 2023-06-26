<?php

namespace model;

use common\Helper;
use common\SPDO;
use PDO;
use PDOStatement;
use stdClass;

class News
{
    public const NEWS_ENABLE = 1;
    public const NEWS_DISABLE = 0;
    private int $newsId;
    private string $title;
    private string $description;
    private int $imageId;
    private string $link;
    private string $publicationDate;
    private bool $enable;

    public function __construct(StdClass $news)
    {

        //echo "<pre>" . print_r($news, true) . "</pre>";

        if (property_exists($news, 'news_id')) {
            $this->newsId = intval($news->news_id);
        }
        if (property_exists($news, 'title')) {
            $this->title = $news->title;
        }
        if (property_exists($news, 'description')) {
            $this->description = $news->description;
        }
        if (property_exists($news, 'image_id')) {
            $this->imageId = intval($news->image_id);
        }
        if (property_exists($news, 'link')) {
            $this->link = $news->link;
        }
        if (property_exists($news, 'publicationDate')) {
            $this->publicationDate = $news->publicationDate;
        }
        if (property_exists($news, 'enable')) {
            $this->enable = $news->enable;
        }

    }

    public function toArray(): array
    {
        return [
            'newsId' => $this->newsId,
            'title' => $this->title,
            'description' => $this->description,
            'imageId' => $this->imageId,
            'link' => $this->link,
            'publicationDate' => $this->publicationDate,
            'enable' => $this->enable
        ];
    }


    public function getNewsId(): int
    {
        return $this->newsId;
    }


    public function setNewsId(int $newsId): void
    {
        $this->newsId = $newsId;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    public function getDescription(): string
    {
        return $this->description;
    }


    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    public function getImageId(): int
    {
        return $this->imageId;
    }


    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }


    public function getLink(): string
    {
        return $this->link;
    }


    public function setLink(string $link): void
    {
        $this->link = $link;
    }


    public function getPublicationDate(): string
    {
        return $this->publicationDate;
    }


    public function setPublicationDate(string $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }


    public function isEnable(): bool
    {
        return $this->enable;
    }


    public function setEnable(bool $enable): void
    {
        $this->enable = $enable;
    }

    public function save()
    {
        //echo "<pre>" . print_r($this, true) . "</pre>";

        if (empty($this->newsId) && empty($this->title) && empty($this->description) && empty($this->imageId) && empty($this->link) && empty($this->publicationDate) && empty($this->enable)) {
            return false;
        }
        if (!empty($this->newsId)) {
            $pdo = SPDO::getInstance();
            $query = "UPDATE news SET 
                 title = :title, 
                 description = :description, 
                 image_id = :imageId,
                 link = :link,
                 publicationDate = :publicationDate,
                 enable = :enable
                 WHERE news_id = :newsId;
            ";


        } else {
            $pdo = SPDO::getInstance();
            $query = "INSERT INTO news (title, description, image_id, link ,publicationDate, enable) 
                        VALUES (:title, :description, :imageId, :link, :publicationDate, :enable);";
        }
        $pdo->execPrepare($query);
        $pdo->execBindValue(':title', $this->title, PDO::PARAM_STR);
        $pdo->execBindValue(':description', $this->description ?? '', PDO::PARAM_STR);
        $pdo->execBindValue(':imageId', $this->imageId ?? null, PDO::PARAM_INT);
        $pdo->execBindValue(':link', $this->link ?? '', PDO::PARAM_STR);
        $pdo->execBindValue(':publicationDate', $this->publicationDate ?? date("Y-m-d"), PDO::PARAM_STR);
        $pdo->execBindValue(':enable', $this->enable ?? self::NEWS_ENABLE, PDO::PARAM_BOOL);
        if (!empty($this->newsId)) {
            $pdo->execBindValue(':newsId', $this->newsId, PDO::PARAM_INT);
        }

        return $pdo->execStatement();
    }

    public function delete(): PDOStatement|bool
    {
        if (empty($this->newsId)) {
            return false;
        }
        $pdo = SPDO::getInstance();
        $query = "DELETE FROM news WHERE news_id = :newsId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':newsId', $this->newsId, PDO::PARAM_INT);

        return $pdo->execStatement();
    }
}