<?php
require getenv("VIEWROOT") . "/includes/head.php";
?>

<div class="navbar">
    <?php
    require getenv("VIEWROOT") . "/includes/navigation.php";
    ?>
</div>

<div class='allUserPosts'>
    <?php
//    dd($articles);
    foreach ($articles as $key => $value)
    {
        allPosts($articles[$key]);
    }

    function allPosts($article)
    {
        $urlroot = getenv("URLROOT");
        echo <<<AA
    <article>
    <a href="{$urlroot}/articles/{$article->id}"><header class="title">{$article->title}</header></a>
    <p class="description">{$article->description}</p>
    <p style="font-size: 14px">{$article->getDate()} 
    <a style="" href="{$urlroot}/users/{$article->author}/show"><span style="margin-left: 100px">{$article->name} {$article->surname}</span></a></p>
</article>
AA;
    }?>
    </div>
