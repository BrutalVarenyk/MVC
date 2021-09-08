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

/**
 * <?php echo getenv('URLROOT')?>/articles/<?php echo $article->id ?>
 */

    if(isset($info[0])):

        $article = $info[0];
        $user = $info[1];
        $urlroot = getenv("URLROOT");

        if(isset($_SESSION["user_id"])):
            if ($_SESSION["user_id"] == $article->author || $_SESSION["user_id"] == 1):?>
    <div class="articleButton">
        <form style="display: inline" action="<?php echo getenv('URLROOT')?>/articles/<?php echo $article->id ?>/remove" method="POST" >
            <h2>Are you sure ?</h2>
            <input id="submit" type="submit" name="deleteButton" value="Delete"/>

        </form>
        <button id="submit"
                onclick="window.location.href='<?php echo getenv('URLROOT')?>/articles/<?php echo $article->id ?>'">
            No
        </button>
    </div>
    <article>
         <header class="title"><?php echo $article->title ?></header>
         <p class="description"><?php echo $article->description ?></p>
         <p class="postText"><?php echo $article->postText ?></p>
         <p style="font-size: 14px"><?php echo $article->getDate() ?>
         <a style="" href="<?php echo $urlroot?>/users/<?php $user->getId() ?>/show"><span style="margin-left: 100px"><?php echo $user->fullName() ?></span></a></p>
    </article>
            <?php else: ?>
    <article>
        <header>You haven't got permission for that</header>
    </article>
            <?php endif; ?>
        <?php else: ?>
    <article>
         <header>You haven't got permission for that</header>
    </article>
        <?php endif; ?>

<?php else: ?>
    <article>
        <header>Such article doesn't exist</header>
    </article>
<?php endif; ?>

</div>
