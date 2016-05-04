<?php $activePage = "403";
require_once('phpItems.php');
//TODO: Create a 403 error page.
?>
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
        <h1>403 - Forbidden!!</h1>
        <p>Looks like you stumbled on something that doesn't exist. Sorry 'bout that!
            If you came from a User page, they may be set to private! Keep that in mind!</p>
    </div>
</div>
<div class="container">

</div>
</body>

<? require_once("jsItems.php"); ?>
</HTML>