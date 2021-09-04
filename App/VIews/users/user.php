<?php

$user = $info[0];
$posts = $info[1];

echo <<<AA
<div style=""> 
    <p>id: {$user->id}</p>
    <p>Name: {$user->name}</p>
    <p>Surname: {$user->surname}</p>
    <p>Birthdate: {$user->birthdate}</p>
</div>
<h3>Posts of the user:</h3>
AA;



foreach ($posts as $key => $value) {

    echo <<<POST
        <div>
                <div>
                <a href="http://mvc/posts/{$posts[$key]->id}"><p>{$posts[$key]->title}</p></a>
                <p>{$posts[$key]->description}</p>
                </div>
        </div>
POST;

}

function allUserPost()
{


}
