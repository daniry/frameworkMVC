<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

// Наследуемся от класса
class Article extends  ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $authorId;
    protected $createdAt;


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): string {
        return $this->name = $name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): string {
        return $this->text = $text;
    }



// просим статью давать нам не id автора, а сразу автора
// просим сущность юзера выполнить запрос в базу и получить нужного пользователя, по id, который хранится в статье
    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setAuthor(User $author) {
        $this->authorId = $author->getId();
    }


    protected static function getTableName(): string
    {
        return 'articles';
    }

}
