<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Services\Db;
use MyProject\Models\Articles\Article;
use MyProject\Exceptions\DbException;


class MainController
{
    /** @var View */
    private View $view;
    /** @var Db */
    private Db $db;

    public function __construct()
        {
		$this->view = new View(__DIR__ . '/../../../templates');
		$this->db = Db::getInstance();
        }

    /**
     * @param string $title
     */
    public function main(string $title = 'Главная страница'): void
    {
        /* @var Article $articles */
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => $title]);
        }

    /**
    * @param string $title
    * @param string $name
    */

    public function sayHello(string $name, string $title = 'Страница приветствия'): void
        {
            $this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => $title]);	
        }

    /**
    * @param string $title
    * @param string $name
    */
    public function sayBye(string $name, string $title = 'Страница приветствия'): void
        {
            $this->view->renderHtml('main/bye.php', ['name' => $name, 'title' => $title]);
        }

}
