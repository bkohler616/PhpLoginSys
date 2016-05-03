<?php $activePage = "Index" ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php
    require_once("cssItems.php");
    ?>
    <? require_once("cssItems.php"); ?>
    <style>
        .navbar {
            margin-bottom: 0;
        }
        .col-md-4 {
            margin-bottom: 45px;
        }
    </style>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="jumbotron">
    <div class="container">
        <h1>Hello!</h1>
        <p>Welcome to the PHP-Project Final! Here you will arbitrarily log in, and log out!
            We have a few admins and a few users. Some are even public!
            Feel free to browse as you wish!</p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1> See some users!</h1>
            <p>We don't have any yet! Come again another time!</p>
        </div>
        <div class="col-md-4">
            <h1>Ready to try?</h1>
            <p>Feel free to sign up!</p>
            <a class="btn btn-primary btn-lg" href="SignUp.php" role="button">Sign Up &rightarrow;</a>
        </div>
        <div class="col-md-4">
            <h1>Already have an account?</h1>
            <p>Login and get back to doing... whatever!</p>
            <a class="btn btn-primary btn-lg" href="Login.php" role="button">Login &rightarrow;</a>
        </div>
    </div>

    <div class="row">
        <h1>Here's some technologies we used...</h1>
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="Images/Bootstrap-logo.jpg" width="175" height="175" alt="Bootstrap">
                <div class="caption">
                    <h3>Bootstrap</h3>
                    <p>A framework to design our UI. This is a framework to make responsive design simple.</p>
                    <p><a href="#" class="btn btn-primary" role="button">Get Bootstrap Here</a></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="thumbnail">
                <img src="Images/Github-logo.png" width="175" height="175" alt="Github">
                <div class="caption">
                    <h3>GitHub</h3>
                    <p>Github is a host for our project to allow version control, so many people can work on the same
                        project at once.</p>
                    <p><a href="#" class="btn btn-primary" role="button">GitHub Here</a> <a
                            href="https://github.com/bkohler616/PhpLoginSys.git" class="btn btn-default" role="button">Our
                            Repo</a></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="thumbnail">
                <img src="Images/MySQL-logo.jpg" width="175" height="175" alt="MySql">
                <div class="caption">
                    <h3>MySQL</h3>
                    <p>MySql is our database of choice for simplicity. It's built into WAMP and has many tools for it to
                        use.</p>
                    <p><a href="https://www.mysql.com" class="btn btn-primary" role="button">MySQL Here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<? require_once("jsItems.php"); ?>
</HTML>