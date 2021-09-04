<?php
namespace App\Controllers;

use App\Modules\Article;
use Core\Controller;
use Core\View;

class ArticlesController extends Controller
{
//    protected string $beforeError = "User id not equal 100";

    protected function show(int $id)
    {

    }

    protected function index()
    {

        $articles = (new Article)->getAllArticles();

        dd($articles);

        View::render('posts/index.php', compact('articles'));

    }


//    public function before(): bool
//    {
//        return $this->routeParams['id'] === 100;
//    }

}