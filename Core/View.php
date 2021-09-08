<?php
namespace Core;

class View
{

    public static function render($view, $args =[])
    {

        extract($args, EXTR_SKIP);

        $file = getenv('VIEWROOT') . '/' . $view;

        if (is_readable($file)) {
//            require self::getViewPath() . "header.php";
            require $file;
//            require self::getViewPath() . "footer.php";
        } else {
            throw new \Exception("{$file} not found");
        }
    }
}