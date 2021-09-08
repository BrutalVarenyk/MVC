<?php
require getenv("VIEWROOT") . "/includes/head.php";
?>
    <div class="navbar">
        <?php
        require getenv("VIEWROOT") . "/includes/navigation.php";
        ?>
    </div>

<?php

if($info !== false) {
    $user = $info[0][0];
    $posts = $info[1];

//    dd($user);


    echo <<<AA
<div class="all-Users"> 
    <h2>User info:</h2>
    <p>User's id: {$user->id}</p>
    <p>Name: {$user->name}</p>
    <p>Surname: {$user->surname}</p>
    <p>Birthdate: {$user->birthdate}</p>
AA;

    if (isset($_SESSION["user_id"])) {
        if ($_SESSION["user_id"] == $user->id || $_SESSION["user_id"] == 1) {
            echo "<p>Email: {$user->email} </p>";
        }
    }

    echo "<h2>Posts of the user:</h2></div>
          <div class='allUserPosts'>";

    function allUserPost($posts)
    {
        $urlroot = getenv("URLROOT");
        foreach ($posts as $key => $value) {

            echo <<<POST
        <article>
                <a href="$urlroot/articles/{$posts[$key]->id}"><header class="title">{$posts[$key]->title}</header></a>
                <p class="description">{$posts[$key]->description}</p>
                <p class="postText">{$posts[$key]->postText}</p>
                <p style="font-size: 14px; margin-bottom: 5%">Data of creation: {$posts[$key]->getDate()}</p>
                <p></p>
        </article>
POST;
        }
    }

    if (!empty($posts)) {
        allUserPost($posts);
    } else {
        echo "<h3>User have not got posts yet</h3>";
    }
    echo "</div>";


}else{
    echo <<<AA
<div class="all-Users">
<p>There is no such user</p>
</div>
AA;

}
