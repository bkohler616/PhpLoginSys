<?php $activePage = "Index" ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php
    require_once("cssItems.php");
    ?>
    <style>
        /*Comment to sync failed push */
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
</div>
</body>

<?php
require_once("jsItems.php");
?>
</HTML>