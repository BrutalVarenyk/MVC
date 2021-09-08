<?php
require getenv("VIEWROOT") . "/includes/head.php";
?>

<div class="navbar">
    <?php
    require getenv("VIEWROOT") . "/includes/navigation.php";
    ?>
</div>

<div class = 'all-Users'>
    <h2>Registered users of site:</h2>
<?php

//require 'users.css';

/**
 * $users - object oj Users with parameters from module
 */
function allUsers($user)
{
    $urlroot = getenv("URLROOT");
    echo <<<AA
    <p>
    <a href="{$urlroot}/users/{$user->getId()}/show">{$user->fullName()}</a>
    </p>
AA;


}

foreach ($users as $key => $value)
{
//    dd($_SERVER);
    allUsers($users[$key]);
//    echo $users[$key]->fullName();
}

?>


</div>
