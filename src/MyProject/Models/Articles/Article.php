<?php

namespace MyProject\Models\Articles;

use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\Models\ActiveRecordEntity;

class Article extends ActiveRecordEntity
{   
    protected string $name;
    protected string $text;
    protected id $authorId;
    protected string $createdAt;

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function getName(): string
    {
            return $this->name;
    }

    public function getText(): string
    {
            return $this->text;   
    }

    protected static function getTableName(): string     
    {
            return 'articles';
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setText(string $text): void
    {
            $this->text = $text;
    }

    public function setName(string $name): void
    {
            $this->name = $name;
    }

}




