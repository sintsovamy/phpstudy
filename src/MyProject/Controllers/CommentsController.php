<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\DifferentRoleEx;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;
use MyProject\Models\Comments\Comment;
use MyProject\Services\Db;


class CommentsController extends AbstractController
{
    public function add(int $articleId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
	}

	$article = Article::getById($articleId);

	if (!empty($_POST)) {
		try{
		$comment = Comment::createFromArray($_POST, $this->user, $article);
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('articles/view.php', ['error' => $e->getMessage()]);
            return;
        }
    
        $anchor = '#comment' . $comment->getId();
        header('Location: /articles/' . $article->getId() . $anchor, true, 302);
        exit();
        }

    }

    public function edit(int $commentId): void
    {
	 $comment = Comment::getById($commentId);

        if (!empty($_POST)) {
            try {
                $comment->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                    $this->view->renderHtml('comments/edit.php', ['error' => $e->getMessage(), 'comment' => $comment]);
              return;
                     }
              header('Location: /articles/' . $comment->getArticle()->getId(), true, 302);
              exit();
	}
	 $this->view->renderHtml('comments/edit.php', ['comment' => $comment]);
    }

	    
}

