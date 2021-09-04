<?php
namespace App\Controllers;


use App\Modules\Article;
use App\Modules\User;
use Core\Controller;
use Core\View;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        View::render('users/index.php', compact('users'));

    }

    public function show($id)
    {
        $info = User::find($id);

        $posts = Article::find($id, 'author');

        $info[] = $posts;

        View::render('users/user.php', compact('info'));
    }

    public function create()
    {
        if($_POST){
//            dd($_POST);
            $user = new \App\Modules\User();
            $user->addInfo($_POST);
            $user->create($user->getColumns());

        }
        View::render('users/create.php');
    }


}