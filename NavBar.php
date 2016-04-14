<?php
/**
 * Created by PhpStorm.
 * User: bkohler
 * Date: 4/14/2016
 * Time: 10:03 AM
 */

?>
<nav class="navbar navbar-default navbar-static-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only"> Toggled navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./Index.php">Login Project</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="./Index.php">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?
                //Put some php here for login detection.
                //If logged in: Show hello and link for UserPage
                //If not, show Login and Sign Up buttons (for now I'll place the buttons)
                ?>
                <li><a href="./Login.php">Login</a></li>
                <li><a href="./SignUp.php">Sign Up</a></li>
            </ul>
        </div>
    </div>
</nav>