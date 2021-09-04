<?php
namespace App\Modules;

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
        $this->name = $dataAboutUser["name"];
        $this->surname = $dataAboutUser["surname"];

//        $this->email =  $dataAboutUser["email"];
//        $this->password =  $dataAboutUser["password"];

        $birthdate = $dataAboutUser["birthdate"];
        $this->birthdate = date("Y-m-d H:i:s",strtotime($birthdate));

        $this->email =  $dataAboutUser["email"];
        $this->password =  $dataAboutUser["password"];
//        dd($this);
    }


    public function getColumns(): array
    {

        $this->columns["name"] = $this->name;
        $this->columns["surname"] = $this->surname;
        $this->columns["birthdate"] = $this->birthdate;
//        $this->columns["email"] = $this->email;
//        $this->columns["password"] = $this->password;

        return $this->columns;
    }

    /**
     * @return string
     */
    public static function getTable(): string
    {
        return User::$table;
    }



}