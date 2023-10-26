<?php

namespace MyProject\Models\Users;
use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    /** @var string*/
    protected $nickname;
    /** @var string*/
    protected $email;
    /** @var bool*/
    protected $isConfirmed;
    /** @var string*/
    protected $role;
    /** @var string*/
    protected $passwordHash;
    /** @var string*/
    protected $authToken;
    /** @var string*/
    protected $createdAt;

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    protected static function getTableName(): string

    {
        return 'users';
    }

}
