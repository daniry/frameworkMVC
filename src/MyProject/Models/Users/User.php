<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;

// наследуемся от нашего ActiveRecordEntity и получаем все эти возможности, что есть у сущности Article
class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNickname(): string {
        return $this->nickname;
    }

// указываем нужную таблицу, где хранятся пользователи
    protected static function getTableName(): string
    {
        // TODO: Implement getTableName() method.
        return 'users';
    }
}