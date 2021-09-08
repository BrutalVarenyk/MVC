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

       <form action="<?php echo getenv('URLROOT')?>/auth/login" method="POST">
           <input type="email" placeholder="Email *" name="email">
           <span class="incalidFeedback">
               <?php echo $emailError; ?>
           </span>
           <input type="password" placeholder="Password *" name="password">
           <span class="incalidFeedback">
               <?php echo $passwordError; ?>
           </span><br>

           <button id="submit" type="submit" value="submit">Submit</button>

           <p class="options">Not register yet ? <a href="<?php echo getenv('URLROOT');
           ?>/auth/registration">Create an account</a></p>
       </form>
   </div>
</div>

<!--<div class="container-login">-->
<!--    <p>-->
<!--        Email-->
<!--        <input type="email" name="email" class="email field" required/>-->
<!--    </p>-->
<!--    <p>-->
<!--        Password-->
<!--        <input type="password" name="password" class="password field" onchange="check_pass();" required/>-->
<!--    </p>-->
<!--    <p class = 'message'></p>-->
<!--</div>-->