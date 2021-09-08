<?php
namespace App\Controllers;

use App\Modules\Article;
use App\Modules\User;
use Core\Controller;
use Core\View;

class ArticlesController extends Controller
{
//    protected string $beforeError = "User id not equal 100";

    protected function show(int $id)
    {
        $info = $this->findArticle($id);

        return View::render("/articles/article.php", compact('info'));

    }

    protected function index()
    {
        $articles = (new Article)->getAllArticles();

        return View::render('articles/index.php', compact('articles'));
    }

    public function create()
    {
        $data = Article::verification();

        if (isset($data["verification"])) {
            $addArticle = (new Article())->saveArticle($data, "create");
            if ($addArticle) {
                header("location: " . getenv("URLROOT") . "/");
            } else {
                $data["textError"] = "Something go wrong :(";
            }
        }

        return View::render("articles/create.php", $data);
    }

    public function edit(int $id)
    {
        $articleinfo = Article::find($id);
//        dd($articleinfo !== false);
        if ($articleinfo !== false) {
            $data = Article::verification();
            $data["article"] = $articleinfo[0];
            if (isset($data["verification"])) {
                $data["author"] = $data["article"]->author;
                (new Article())->saveArticle($data, "update");
                header("location: " . getenv("URLROOT") . "/users/{$data["article"]->author}/show");
            }
        }else{
            return View::render("404.php");
        }
        return View::render("articles/edit.php", $data);

    }

    public function findArticle(int $id)
    {
        $articleinfo = Article::find($id);
        if (!empty($articleinfo)) {
            $userinfo = User::find($articleinfo[0]->author);

            $info = [$articleinfo[0], $userinfo[0]];
        } else {
            $info = [];
        }
        return $info;
    }

    public function remove(int $id)
    {
        $info = $this->findArticle($id);


        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (isset($_POST["deleteButton"])){
                (new Article())->delete("`id` = $id");
                header("location: " . getenv("URLROOT") . "/");
            }
        }
//        dd($info);

        return View::render("articles/remove.php", compact("info"));
    }

}