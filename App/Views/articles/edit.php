<?php
require getenv("VIEWROOT") . "/includes/head.php";
?>


<div class="navbar">
    <?php
    require getenv("VIEWROOT") . "/includes/navigation.php";
    ?>
</div>

<?php //dd($article); ?>

<div class="container-create">
        <div class="wrapper-create">
            <?php if(isset($_SESSION["user_id"])) : ?>
            <?php
            if ($_SESSION["user_id"] == $article->author || $_SESSION["user_id"] == 1):
            ?>
            <h2>Create article</h2>
            <form action="<?php echo getenv('URLROOT')?>/articles/<?php echo $article->id ?>/edit" method="POST">
                <textarea name="title" id="title" placeholder="Title *" ><?php echo $article->title; ?></textarea>
                <span class="invalidFeedback">
               <?php echo $titleError; ?>
           </span>
                <textarea name="description" id="description"  placeholder="Description *" ><?php echo $article->description; ?></textarea>
                <span class="invalidFeedback">
               <?php echo $descriptionError; ?>
           </span>
                <textarea name="postText" id="postText" placeholder="Text of article *" ><?php echo $article->postText; ?></textarea>
                <span class="invalidFeedback">
               <?php echo $textError; ?>
           </span>
                <br>
                <button id="submit" type="submit" value="submit">Edit article</button>
            </form>
            <?php else: ?>
                <h3>You can not edit this article</h3>
            <?php endif;?>
            <?php else: ?>
                <h3>Please login to edit article</h3>
            <?php endif;?>
        </div>


</div>