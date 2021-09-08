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
if(isset($info[0])){

    $article = $info[0];
    $user = $info[1];
    $urlroot = getenv("URLROOT");

    echo <<<AA
<article>
    <header class="title">{$article->title}</header>
    <p class="description">{$article->description}</p>
    <p class="postText">{$article->postText}</p>
    <p style="font-size: 14px">{$article->getDate()} 
    <a style="" href="{$urlroot}/users/{$user->getId()}/show"><span style="margin-left: 100px">{$user->fullName()}</span></a></p>
</article>
AA;

    if(isset($_SESSION["user_id"])){
        if ($_SESSION["user_id"] == $article->author || $_SESSION["user_id"] == 1){
            echo <<<AA
        <div class="articleButton">
            <button class="edit" id="submit" onclick="window.location.href='{$urlroot}/articles/{$article->id}/edit'">
                Edit article
            </button>
            <button class="delete" id="submit" onclick="window.location.href='{$urlroot}/articles/{$article->id}/remove'">
                Delete article
            </button>
        </div>
AA;

        }
    }

}else{
    echo <<<AA
<article>
    <header>Such article doesn't exist</header>
</article>
AA;

}?>


</div>

