<?php

namespace MyProject\Models\Articles;

use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\Models\ActiveRecordEntity;

class Article extends ActiveRecordEntity
{   
    /** @var string*/
    protected $name;
    /** @var string*/
    protected $text;
    /** @var int*/
    protected $authorId;
    /** @var string*/
    protected $createdAt;


    /**
     * @var User $author
     */
    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
            return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
            return $this->text;   
    }

    /**
     * @return string
     */
    protected static function getTableName(): string     
    {
            return 'articles';
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    /**
     * @param $text
     */
    public function setText(string $text): void
    {
            $this->text = $text;
    }

    /**
     * @param $name
     */
    public function setName(string $name): void
    {
            $this->name = $name;
    }

}




