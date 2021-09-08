<?php
namespace App\Modules;

use Core\View;

class User extends \Core\Model
{
    protected static $table = "users" ;

    public $columns = [];

    public $id, $name, $surname, $birthdate, $email, $password;

    public function fullName()
    {

        return $this->name . ' ' . $this->surname;

    }

    public function getId()
    {
        return $this->id;
    }


    /**
     * @param array $dataAboutUser
     */

    public function addInfo(array $dataAboutUser)
    {
//        dd($dataAboutUser);
        $this->name = $dataAboutUser["name"];
        $this->surname = $dataAboutUser["surname"];

        $this->email =  $dataAboutUser["email"];
        $this->password =  $dataAboutUser["password"];

        $birthdate = $dataAboutUser["birthdate"];
        $this->birthdate = date("Y-m-d H:i:s",strtotime($birthdate));

//        $this->email =  $dataAboutUser["email"];
//        $this->password =  $dataAboutUser["password"];
//        dd($this);
    }


    public function getColumns(): array
    {

        $this->columns["name"] = $this->name;
        $this->columns["surname"] = $this->surname;
        $this->columns["birthdate"] = $this->birthdate;
        $this->columns["email"] = $this->email;
        $this->columns["password"] = $this->password;

        return $this->columns;
    }

    /**
     * @return string
     */
    public static function getTable(): string
    {
        return User::$table;
    }

    public function registerVerification()
    {
        $data = [
            "title" => "Registration page",
            "nameError" => "",
            "emailError" => "",
            "passwordError" => "",
            "confirmPasswordError" => "",
            "birthdateError" => "",
            "surnameError" => "",
        ];

//        dd($data);
//        dd($_POST);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
//            dd($_POST);
            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "name" => trim($_POST["name"]),
                "email" => trim($_POST["email"]),
                "password" => trim($_POST["password"]),
                "confirmPassword" => trim($_POST["confirmPassword"]),
                "birthdate" => $_POST["birthdate"],
                "surname" => trim($_POST["surname"]),
                "birthdateError" => '',
                "nameError" => '',
                "surnameError" =>'',
                "emailError" => '',
                "passwordError" => '',
                "confirmPasswordError" => ''
            ];

//            dd($data);

            $nameValidation = "/^[a-zA-Z]*$/";
            $passwordValidation = "/[a-zA-Z0-9]*/i";


            //Validation of name
            if (empty($data["name"])) {
                $data["nameError"] = "Please enter name.";
            } elseif (!preg_match($nameValidation, $data["name"])) {
                $data["nameError"] = "Name can only contain letters.";
            }

            //Validate surname
            if (empty($data["surname"])) {
                $data["surnameError"] = "Please enter username.";
            } elseif (!preg_match($nameValidation, $data["surname"])) {
                $data["surnameError"] = "Surname can only contain letters.";
            }

            //Validate birthdate
            if (empty($data["birthdate"])) {
                $data["birthdateError"] = "Please enter birthdate.";
            }

            //Validate email
            if (empty($data["email"])) {
                $data["emailError"] = "Please enter email address.";
            } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                $data["emailError"] = "Please enter the correct format.";
            } else {
                //Check if email exists.
                if (!((new User())->verifiedEmail($data["email"]))) {
                    $data["emailError"] = "Email is already taken.";
                }

            }

            //Validate password
            if (empty($data["password"])) {
                $data["passwordError"] = "Please enter password.";
            } elseif (strlen($data["password"]) < 2) {
                $data["passwordError"] = "Password must be at least 8 characters";
                dd(preg_match($passwordValidation, $data["password"]));
            } elseif (!preg_match($passwordValidation, $data["password"])) {
                $data["passwordError"] = "Password must be have at least one numeric and one symbolic values.";
            }

            //Validate confirm password
            if (empty($data["confirmPassword"])) {
                $data["confirmPasswordError"] = "Please confirm password.";
            } else {
                if ($data["password"] != $data["confirmPassword"]) {
                    $data["confirmPasswordError"] = "Passwords do not match, please try again.";
                }
            }

//            dd($data);
            if (empty($data["nameError"])
                && empty($data["emailError"])
                && empty($data["passwordError"])
                && empty($data["confirmPasswordError"])
                && empty($data["birthdateError"])) {

                $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
//                dd($data);
//                dd((new User())->register($data));
                if ((new User())->register($data)) {
                    //Redirect to the login page
                    (new User())->register($data);
                    header('location: ' . getenv("URLROOT") . '/auth/login');
                }else{
                    $data["emailError"] = "Email {$data["email"]} has already been taken";
                }

            }

        }
        return $data;
    }

    public function register($data)
    {
        $this->addInfo($data);
//        dd($this);
//        dd($this->getColumns());
        try{
            $this->create($this->getColumns());
        }catch (\PDOException $e){
            return false;
        }

        return true;

    }

    public static function loginVerification()
    {
        $data = [
            "email" => "",
            "password" => "",
            "emailError" => "",
            "passwordError" => ""
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "email" => trim($_POST["email"]),
                "password" => trim($_POST["password"]),
                "emailError" => "",
                "passwordError" => ""
            ];

            //Validate email
            if (empty($data["email"])) {
                $data["emailError"] = "Please enter a email";
            }

            //Validate password
            if (empty($data["password"])) {
                $data["passwordError"] = "Please enter a password";
            }


        }
        return $data;
    }

    public function login($email, $password)
    {
        try {
            $users = User::find($email, "email");
            if($users == false) return false;

        }catch (\PDOException $e) {
            return false;
        }

        $user = $users[0];
        $hashedPassword = $user->password;
//        dd( $hashedPassword );
        if(password_verify($password, $hashedPassword)){
            return $user;
        }else{
            return false;
        }
    }

    public function verifiedEmail($email) {
//            dd(User::find($email, 'email'));
        try{
            User::find($email, 'email');
        }catch (\Exception $e){
            return false;
        }
        return true;

    }



}