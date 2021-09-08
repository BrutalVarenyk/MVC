<?php
require getenv("VIEWROOT") . "/includes/head.php";
?>

<div class="navbar">
    <?php
    require getenv("VIEWROOT") . "/includes/navigation.php";
    ?>
</div>


<div class="container-login">
    <div class="wrapper-login">
        <h2>Sign in</h2>

        <form action="<?php echo getenv('URLROOT')?>/auth/registration" method="POST">


            <input type="email" placeholder="Email *" name="email">
            <span class="invalidFeedback">
               <?php echo $emailError; ?>
           </span>
            <input type="password" placeholder="Password *" name="password">
            <span class="invalidFeedback">
               <?php echo $passwordError; ?>
           </span>
            <input type="password" placeholder="Confirm Password *" name="confirmPassword">
            <span class="invalidFeedback">
               <?php echo $confirmPasswordError; ?>
           </span>
              <input type="text" placeholder="Name *" name="name">
            <span class="invalidFeedback">
               <?php echo $nameError; ?>
            </span>

            <input type="text" placeholder="Surname *" name="surname"><span class="invalidFeedback">
               <?php echo $surnameError; ?>
            </span>
                <label class="birthdate">Birthdate:</label>
                <input type="date" placeholder="Birthdate *" name="birthdate">
            <span class="invalidFeedback">
               <?php echo $birthdateError; ?>
            </span>
                <br>


            <button id="submit" type="submit" value="submit">Submit</button>

            <p class="options">Not register yet ? <a href="<?php echo getenv('URLROOT');
                ?>/auth/registration">Create an account</a></p>
        </form>
    </div>
</div>

<!---->
<!--<div>-->
<!--    <form class="form-insert" action="http://mvc/auth/registration" method="post">-->
<!--        <p>-->
<!--            Email-->
<!--            <input type="email" name="email" class="email field" required/>-->
<!--        </p><span>--><?php //echo $emailError?><!--</span>-->
<!--        <p>-->
<!--            Password-->
<!--            <input type="password" name="password" class="password field" onchange="check_pass();" required/>-->
<!--        </p>-->
<!--        <p>-->
<!--            Confirm password-->
<!--            <input type="password" name="confirm_password" class="confirm_password field"  onchange="check_pass();" required/>-->
<!--        </p>-->
<!--        <span class = "password_verification"></span>-->
<!--        <p>-->
<!--            Name-->
<!--            <input type="text" name="name" class="name field" required/>-->
<!--        </p>-->
<!--        <p>-->
<!--            Surname-->
<!--            <input type="text" name="surname" class="surname field" required/>-->
<!--        </p>-->
<!--        <p>-->
<!--            Birthdate-->
<!--            <input type="date" name="birthdate" class="birthdate field" required/>-->
<!--        </p>-->
<!---->
<!--        <button class='table-add-information hidden'>Add to table</button>-->
<!--    </form>-->
<!--    <p class='result'>-->
<!--        </p>-->
<!--</div>-->
<!--<script type="text/javascript">-->
<!--    --><?php //require "scripts/user_creation.js"?>
<!--</script>-->

