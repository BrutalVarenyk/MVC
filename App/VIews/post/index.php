<style type="text/css">
<?php require 'style/post.css' ?>
    </style>
    <div class = 'all-Posts'>
<?php

//require 'users.css';

/**
 * $post - object oj Users with parameters from module
 */
function allPosts($post)
{
    echo <<<AA
    <div>
    <a href="http://mvc/posts/{$post->getId()}/show">
    <p>Title: {}</p></a>
    </div>
AA;


}

foreach ($posts as $key => $value)
{
//    dd($_SERVER);
    allUsers($posts[$key]);
//    echo $users[$key]->fullName();
}

?>