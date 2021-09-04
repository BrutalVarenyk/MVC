<?php

?>

<form class="form-insert" action="http://mvc/auth/registration" method="post">
    <p>
        Email
        <input type="email" name="email" class="email field" required/>
    </p>
    <p>
        Password
        <input type="password" name="passwod" class="password field" onchange="check_pass();" required/>
    </p>
    <p>
        Confirm password
        <input type="password" name="confirm_password" class="confirm_password field"  onchange="check_pass();" required/>
    </p>
    <span class = "password_verification"></span>
    <p>
        Name
        <input type="text" name="name" class="name field" required/>
    </p>
    <p>
        Surname
        <input type="text" name="surname" class="surname field" required/>
    </p>
    <p>
        Birthdate
        <input type="date" name="birthdate" class="birthdate field" required/>
    </p>

    <button class='table-add-information hidden'>Add to table</button>
</form>
<p class='result'></p>
<script type="text/javascript">
    <?php require "scripts/user_creation.js"?>
</script>

