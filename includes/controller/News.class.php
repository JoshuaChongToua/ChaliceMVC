<?php

namespace controller;
use common\SPDO;
use model\News as NewsModel;
use PDO;
use PDOStatement;
use stdClass;
class News
{

    public function __construct()
    {
    }

    public function getOne(int $newsId): NewsModel|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * from news where news_id=:newsId;";
        $pdo->execPrepare($query);
        $pdo->execBindValue(':newsId', $newsId, PDO::PARAM_INT);
        $news = $pdo->execQuery(true);
        if (!$news){
            return false;
        }

        return new NewsModel((object)$news);
    }

    public function getAll(): array|bool
    {
        $pdo = SPDO::getInstance();
        $query = "SELECT * FROM news;";
        $pdo->execPrepare($query);
        $news = $pdo->execQuery();
        if (!$news) {
            return false;
        }

        $return = [];
        foreach ($news as $oneNews) {
            $return[] = new NewsModel((object) $oneNews);
        }

        return $return;
    }
    public function addNew(array $news): PDOStatement|bool
    {

        return $this->save($news);
    }

    public function update(array $news): PDOStatement|bool
    {
        //echo "<pre>" . print_r($news, true) . "</pre>";
        return $this->save($news);
    }

    public function delete(array $newsId): PDOStatement|bool
    {
        $newsModel = new NewsModel((object) ["news_id" => $newsId['news_id']]);

        return $newsModel->delete();
    }

    public function verifyForm(array $array): bool
    {
        //echo "<pre>" . print_r($array, true) . "</pre>";

        if (!isset($array['title'])) {
            return false;
        }

        return true;
    }

    private function save(array $news): PDOStatement|bool
    {
        $newsModel = new NewsModel((object) $news);

        return $newsModel->save();
    }
}