<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
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

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHTML('articles/view.php', ['article' => $article]);
    }

    public function edit(int $articleId) {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
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

    public function delete(int $articleId) {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->delete();
        var_dump($article);
    }

}