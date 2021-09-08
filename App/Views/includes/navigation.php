<nav class="top-nav">
    <ul>
        <li>
            <a href="<?php echo getenv("URLROOT"); ?>/">Articles</a>
        </li>
        <li>
            <a href="<?php echo getenv("URLROOT");?>/articles/create">Create article</a>
        </li>
        <li>
            <a href="<?php echo getenv("URLROOT"); ?>/users/">Users</a>
        </li>
        <li class="btn-login">
            <?php if(isset($_SESSION["user_id"])) : ?>
                <a href="<?php echo getenv("URLROOT"); ?>/auth/logout">Log out</a>
            <?php else : ?>
                <a href="<?php echo getenv("URLROOT"); ?>/auth/login">Log in</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>
