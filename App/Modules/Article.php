<?php
namespace App\Modules;

use Core\Model;
use DateTime;

class Article extends Model
{

    protected static $table = "articles" ;

    public $id, $title, $description, $postText, $author, $creation_date;

    public $columns = [];


    /**
     * @return array
     */
    public function getAllArticles(): array
    {
        $table1 = Article::$table;
        $table2 = User::getTable();

        $params['tables'][] = $table1;
        $params['tables'][] = $table2;

        $params['selected_columns'][] = $table1 . ".*";
        $params['selected_columns'][] = $table2 . ".name";
        $params['selected_columns'][] = $table2 . ".surname";

        $params['equal_columns'][] = $table1 . ".author";
        $params['equal_columns'][] = $table2 . ".id";

        $articles = $this->leftJoin($params);

        return $articles;
    }

    public static function verification()
    {
        $data = [
          "titleError" => "",
          "descriptionError" => "",
          "textError" => ""
        ];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    "title" => trim($_POST["title"]),
                    "description" => trim($_POST["description"]),
                    "postText" => trim($_POST["postText"]),
                    "author" => $_SESSION["user_id"],
                    "titleError" => "",
                    "descriptionError" => "",
                    "textError" => ""
                ];

                //Validate article data

                if (empty($data["title"])) {
                    $data["titleError"] = "Please write a title of article";
                }elseif (empty($data["description"])) {
                $data["descriptionError"] = "Please write a description of article";
                }elseif (empty($data["postText"])) {
                $data["textError"] = "Please write a text of article";
                }else{
                    $data["verification"] = true;
                }
        }

        return $data;
    }


    public function addInfo(array $data)
    {
        $this->title = $data["title"];
        $this->description = $data["description"];
        $this->postText = $data["postText"];
        $this->author = $data["author"];
    }

    public function getColumns()
    {

        $this->columns["title"] = $this->title;
        $this->columns["description"] = $this->description;
        $this->columns["postText"] = $this->postText;
        $this->columns["author"] = $this->author;

        return $this->columns;
    }

    public function getDate()
    {
        $dateObj = DateTime::createFromFormat($this->creation_date, 'Y-m-d');
//        dd($dateObj);
        $time = strtotime($this->creation_date);
        $myFormatForView = date("d F Y H:i", $time);
        return $myFormatForView;
    }

    public function saveArticle(array $data, string $method, $where = "id")
    {
        $this->addInfo($data);
//        dd($data);
        try{
            switch ($method){
                case "create":
                    $this->create($this->getColumns());
                    break;
                case "update":
                    $this->update($this->getColumns(), "$where = {$data["article"]->id}");
                    break;
                default:
                    return false;
            }
        }catch (\PDOException $e){
            return false;
        }
        return true;
    }


}