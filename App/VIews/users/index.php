
<style type="text/css">
<?php require 'style/users.css' ?>
</style>
<div class = 'all-Users'>
<?php

//require 'users.css';

/**
 * $users - object oj Users with parameters from module
 */
function allUsers($user)
{
    echo <<<AA
    <div>
    <a href="http://mvc/users/{$user->getId()}/show">{$user->fullName()}</a>
    </div>
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
