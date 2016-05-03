<?php
/**
 * Created by PhpStorm.
 * User: bkohler
 * Date: 5/2/2016
 * Time: 8:46 PM
 */
require_once('phpItems.php');
StartSessionSafely();
$allowedAccess = false;
if(isset($_GET['UserID']))
{

    if(isset($_SESSION['UserID']) && $_SESSION['UserID'] == $_GET['UserID'])
    {
        $allowedAccess = true;
    }
    else{
        $query = mysqli_query($connection, "SELECT AccountVisibilityID FROM Users WHERE UserID = " . $_SESSION['UserID']);
        if (!$query || !isset($query)) die($connection->error);
        $data = $query->fetch_assoc();
        if($data['AccountVisibilityID'] == AccountVisibility::PublicAccount)
        {
            $allowedAccess = true;
        }
        $query->close();
    }

    if(!$allowedAccess)
        RedirectTo404();


} else{
    RedirectTo404();
}


//Should be able to see information now. Spool up info.

$query = mysqli_query($connection, "SELECT UserID, AccountTypeID, Username, Email, AccountStatusID, AccountVisibilityID, DateCreated".
                                    "FROM Users" .
                                    "WHERE UserID = " . intval($_SESSION['UserID']) . ";");
if (!$query || !isset($query)) die($connection->error);
$data = $query->fetch_assoc();
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
<div class="container">
    <div class="row">
        <h1>User information:</h1>
        <a class="btn btn-primary btn-lg" href="AccountEdit.php" role="button">Edit Account &rightarrow;</a>
        <div class="col-md-4">
            <h3>User information:</h3>
            <p>Username: <?php $data['Username'] ?></p>
            <p>Email: <?php $data['Email'] != "" ?$data['Email'] : "Not setup"  ?></p>
            <p>Date Created: <?php $data['DateCreated'] ?></p>
        </div>
        <div class="col-md-4">
            <h3>Account Information:</h3>
            <p>Account Type: <?php $data['Username'] ?></p>
            <p>Email: <?php $data['Email'] != "" ?$data['Email'] : "Not setup"  ?></p>
            <p>Date Created: <?php $data['DateCreated'] ?></p>
        </div>
    </div>
</div>

