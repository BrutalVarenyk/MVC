<?php

namespace App\Controllers;


use App\Modules\Article;
use App\Modules\User;
use Core\Controller;
use Core\View;
use JetBrains\PhpStorm\NoReturn;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        View::render("users/index.php", compact("users"));

    }

    public function show($id)
    {
        $user = User::find($id);

        if($user !== false) {
            $posts = Article::find($id, "author");
            $info = [$user, $posts];
        }else{
            return View::render("404.php");
        }

        View::render("/users/user.php", compact("info"));
    }

    public function register()
    {
        $data = (new User())->registerVerification();

        View::render("users/registration.php", $data);
    }

    public function login()
    {
        $data = User::loginVerification();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Check if all error are empty
//            dd($data);
            if (empty($data["emailError"]) && empty($data["passwordError"])) {
                $loggedInUser = (new User())->login($data["email"], $data["password"]);
//                dd($loggedInUser);
                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data["passwordError"] = "Password or email is incorrect. Please try again";
                    return View::render("users/login.php", $data);
                }
            }
        }
        return View::render("users/login.php", $data);
    }

    public function createUserSession($user)
    {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["email"] = $user->email;
        header("location: " . getenv("URLROOT") . "/");
    }

    public function logout()
    {
        unset($_SESSION["user_id"]);
        unset($_SESSION["email"]);

        header("location: " . getenv("URLROOT") . "/auth/login");
    }




}