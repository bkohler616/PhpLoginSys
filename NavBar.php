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
            <a class="navbar-brand" href="#">Login Project</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                if ($activePage == "Index")
                    echo "<li class='active'><a href='./Index.php'>Home</a></li>";
                else
                    echo "<li><a href='./Index.php'>Home</a></li>";
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                //If a session isn't made, show login/signup stuff.
                if ($activePage == "Login")
                    echo "<li class='active'><a href='./Login.php'>Login</a></li>";
                else
                    echo "<li><a href='./Login.php'>Login</a></li>";
                if ($activePage == "Sign Up")
                    echo "<li class='active'><a href='./SignUp.php'>Sign Up</a></li>";
                else
                    echo "<li><a href='./SignUp.php'>Sign Up</a></li>";

                //If a session is made, have a User Page, and Logout button
                //TODO: Add a session exists check
                ?>
            </ul>
        </div>
    </div>
</nav>