<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\Models\Articles\Article;


class Comment extends ActiveRecordEntity
{
	protected int $authorId;
	protected int $articleId;
	protected string $text;
	protected $createdAt;

	public function getText(): string
	{
            return $this->text;
	}

	 public function getAuthor(): User
        {
            return User::getById($this->authorId);
        } 

	public function setText(string $text): void
        {
            $this->text = $text;
        
	}

	public function getArticle(): Article
        {
            return Article::getById($this->articleId);
	}

	public function setArticle(Article $article): void
        {
            $this->articleId = $article->getId();
	}

        public function setAuthor(User $author): void
        {
            $this->authorId = $author->getId();
        } 


	public static function createFromArray(array $fields, User $author, Article $article): Comment
        {
            if (empty($fields['text'])) {
                 throw new InvalidArgumentException('Не передан текст комментария');
            }

            $comment = new Comment();

            $comment->setAuthor($author);
            $comment->setArticle($article);
            $comment->setText($fields['text']);
            $comment->save();
            return $comment;
	}

	 protected static function getTableName(): string
         {
            return 'comments';
         }


	public function updateFromArray(array $fields): Comment
        {

        if (empty($fields['text'])) {
                throw new InvalidArgumentException('Не передан текст комментария');
        }

        $this->setText($fields['text']);

        $this->save();
        return $this;
        }

}




