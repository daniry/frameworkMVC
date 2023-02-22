<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;

//получаем только одну статью

class ArticlesController {
    private $view;

    public function __construct() {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $articleId) {
        $article = Article::getById($articleId);

        $reflector = new \ReflectionObject($article);
        $properties = $reflector->getProperties();
        $propertiesNames = [];
        foreach ($properties as $property) {
            $propertiesNames[] = $property->getName();
        }
//        var_dump($propertiesNames);
//        return;

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHTML('articles/view.php', ['article' => $article]);
    }

    public function edit(int $articleId) {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $article->setName('New name');
        $article->setText('New text');

        $article->save();
    }

    public function add() {
        $author = User::getById(1);

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('New article name');
        $article->setText('New text New text New text');

        $article->save();

        //var_dump($article);
    }

}