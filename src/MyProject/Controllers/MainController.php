<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Services\Db;
use MyProject\Models\Articles\Article;
use MyProject\Exceptions\DbException;


class MainController
{
    private View $view;
    private Db $db;

    public function __construct()
        {
		$this->view = new View(__DIR__ . '/../../../templates');
		$this->db = Db::getInstance();
        }

    public function main(string $title = 'Главная страница'): void
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => $title]);
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
