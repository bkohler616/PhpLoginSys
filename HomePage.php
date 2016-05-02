<!DOCTYPE HTML>
<HTML>
<head>
    <?php
    require_once("cssItems.php");
    ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container-fluid">
    <div class="jumbotron">
        <h1>Welcome to Login Project</h1>
        <p>This website is a collaborative effort put forth to create a general website with basic login functions. Our website uses powerful encryption in order to protect out users passwords! To get started click the button below!</p>
        <p><a class="btn btn-primary btn-lg" href="SignUp.php" role="button">Sign Up</a>  <a href="Login.php" class="btn btn-default btn-lg" role="button">Sign In</a></p>
    </div>


    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="Bootstrap-logo.jpg" width="175" height="175" alt="...">
                <div class="caption">
                    <h3>Bootstrap</h3>
                    <p>Here is a bunch of test to simulate text that I might have in the this section. Its useless text but it needs to be here!</p>
                    <p><a href="#" class="btn btn-primary" role="button">Get Bootstrap Here</a></p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="Github-logo.png" width="175" height="175" alt="...">
                <div class="caption">
                    <h3>GitHub</h3>
                    <p>Here is a bunch of test to simulate text that I might have in the this section. Its useless text but it needs to be here!</p>
                    <p><a href="#" class="btn btn-primary" role="button">GitHub Here</a> <a href="https://github.com/bkohler616/PhpLoginSys.git" class="btn btn-default" role="button">Our Repo</a></p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="MySQL-logo.jpg" width="175" height="175" alt="...">
                <div class="caption">
                    <h3>MySQL</h3>
                    <p>Here is a bunch of test to simulate text that I might have in the this section. Its useless text but it needs to be here!</p>
                    <p><a href="https://www.mysql.com" class="btn btn-primary" role="button">MySQL Here</a></p>
                </div>
            </div>
        </div>

    </div>
</>
</body>

<?php require_once("jsItems.php"); ?>