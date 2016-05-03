<?php
$activePage = "User";
/**
 * Created by PhpStorm.
 * User: bkohler
 * Date: 5/2/2016
 * Time: 8:46 PM
 */
require_once('phpItems.php');
StartSessionSafely();
$allowedAccess = false;
$adminAccess = false;
$IsOwnPage = false;

if(isset($_GET['UserID']))
{

    if ((isset($_SESSION['UserID']) && $_SESSION['UserID'] == $_GET['UserID']))
    {
        $allowedAccess = true;
        $IsOwnPage = true;
        $activePage = "OwnUser";
        if ($_SESSION['AccountTypeID'] == AccountType::Administrator || $_SESSION['AccountTypeID'] == AccountType::SuperAdministrator) {
            $adminAccess = true;
        }
    } elseif (isset($_SESSION['UserID']) && ($_SESSION['AccountTypeID'] == AccountType::Administrator || $_SESSION['AccountTypeID']) == AccountType::SuperAdministrator) {
        $allowedAccess = true;
        $adminAccess = true;
    }
    else {
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

$query = mysqli_query($connection, "SELECT UserID, AccountTypeID, Username, Email, AccountStatusID, AccountVisibilityID, DateCreated FROM Users WHERE UserID = " . $_SESSION['UserID']);
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
    <div class="well">
        <h1>User information:</h1>
        <br/>
        <div class="row">
            <div class="col-md-4">
                <h3>User information:</h3>
                <p>Username: <?php echo $data['Username'] ?></p>
                <p>Email: <?php echo $data['Email'] != "" ? $data['Email'] : "Not setup" ?></p>
                <p>Date Created: <?php echo $data['DateCreated'] ?></p>
            </div>
            <div class="col-md-4">
                <h3>Account Information:</h3>
                <p>UserID: <?php echo $data['UserID'] ?></p>
                <p>Account Type: <?php echo AccountType::GetAccountType($data['AccountTypeID']) ?></p>
                <p>Account Status: <?php echo AccountStatus::GetAccountStatus($data['AccountStatusID']) ?></p>
                <p>Account
                    Visibility: <?php echo AccountVisibility::GetAccountVisibility($data['AccountVisibilityID']) ?></p>
            </div>
            <div class="col-md-4">
                <?php if ($adminAccess) {
                    echo "<h3>Administrative access: </h3>";
                    echo "<a class='btn btn-primary' href='./AccountEdit.php?UserID=" . $data['UserID'] . "'>Edit This account &rightarrow;</a></br></br>";
                    echo "<a class='btn btn-primary' href='./UserListing.php'>Return to user listing</a>";
                } else if ($IsOwnPage) {
                    echo "<a class='btn btn-primary' href='./AccountEdit?UserID=" . $data['UserID'] . "'>Edit This account &rightarrow;</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

