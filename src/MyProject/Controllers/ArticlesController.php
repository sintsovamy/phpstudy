<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\DifferentRoleEx;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Models\Comments\Comment;
use MyProject\View\View;
use MyProject\Services\Db;


class ArticlesController extends AbstractController
{
    public function view(int $articleId): void
    {   
        $article = Article::getById($articleId);

	if ($article == null) {
	     throw new NotFoundException();
	}

	$db = Db::getInstance();
        $comments = $db->query('SELECT * FROM comments  WHERE article_id=:id;', [':id' => $articleId], Comment::class);

        $this->view->renderHtml('articles/view.php', [
            'article' => $article, 'comments' => $comments
        ]);
    }

    public function edit(int $articleId): void
    {
	$article = Article::getById($articleId);

	if ($article == null) {
            throw new NotFoundException();
	}

	if ($this->user === null) {
            throw new UnauthorizedException();
	}

	if ($this->user->getRole() !== 'admin') {
             throw new DifferentRoleEx();
        }


	if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
	    } catch (InvalidArgumentException $e) {
		    $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
	      return;
		     }
	    header('Location: /articles/' . $article->getId(), true, 302);
	    exit();
	}
	$this->view->renderHtml('articles/edit.php', ['article' => $article]);

    }

    public function add(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
	} 
	if ($this->user->getRole() !== 'admin') {
            throw new DifferentRoleEx();
	}

        if (!empty($_POST)) {
        try {
            $article = Article::createFromArray($_POST, $this->user);
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
            return;
        }

        header('Location: /articles/' . $article->getId(), true, 302);
        exit();
    }

    $this->view->renderHtml('articles/add.php');
    }

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

	if ($article) {
            $article->delete();
            var_dump($article);
	} else {
            echo 'Такой статьи нет!';
	}
    }

}
