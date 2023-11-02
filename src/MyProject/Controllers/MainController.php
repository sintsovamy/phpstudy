<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Services\Db;
use MyProject\Models\Articles\Article;
use MyProject\Exceptions\DbException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;

class MainController extends AbstractController
{
    public function main(string $title = 'Главная страница'): void
    {
        $articles = Article::findAll();
	$this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }


    public function sayHello(string $name, string $title = 'Страница приветствия'): void
        {
            $this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => $title]);	
        }

    public function sayBye(string $name, string $title = 'Страница приветствия'): void
        {
            $this->view->renderHtml('main/bye.php', ['name' => $name, 'title' => $title]);
        }

}
