<?php
require getenv("VIEWROOT") . "/includes/head.php";
?>


<div class="navbar">
    <?php
    require getenv("VIEWROOT") . "/includes/navigation.php";
    ?>
</div>


<div class="container-create">

    <div class="wrapper-create">
        <?php if(isset($_SESSION["user_id"])) : ?>
        <h2>Create article</h2>

        <form action="<?php echo getenv('URLROOT')?>/articles/create" method="POST">


            <textarea name="title" id="title" placeholder="Title *" ></textarea>
            <span class="invalidFeedback">
               <?php echo $titleError; ?>
           </span>
            <textarea name="description" id="description"  placeholder="Description *" ></textarea>
            <span class="invalidFeedback">
               <?php echo $descriptionError; ?>
           </span>
            <textarea name="postText" id="postText" placeholder="Text of article *" ></textarea>
            <span class="invalidFeedback">
               <?php echo $textError; ?>
           </span>
            <br>
            <button id="submit" type="submit" value="submit">Add article</button>
        </form>
        <?php else: ?>
            <h3>Please login to create article</h3>
        <?php endif;?>
    </div>


</div>