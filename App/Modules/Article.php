<?php
namespace App\Modules;

use Core\Model;

class Article extends Model
{

    protected static $table = "posts" ;

    public $id, $title, $description, $postText, $author;

//    public $allPosts = [];

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

        $params['equal_columns'][] = $table1 . ".id";
        $params['equal_columns'][] = $table2 . ".id";

        $articles = $this->leftJoin($params);

        return $articles;
    }


}