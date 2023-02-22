<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;
use MyProject\Services\Db;

class MainController
{
    private $view;

    public function __construct() {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
//      получить данные из БД в контроллере (без прямой зависимости от БД)
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    public function sayHello(string $name) {
        $title = 'Страница приветствия';
        $this->view->renderHTML('main/hello.php', ['name' => $name, 'title' => $title]);
    }

    public function sayBye(string $name) {
        $this->view->renderHTML('main/bye.php', ['name' => $name, 'title' => 'Страница прощания']);
    }
}