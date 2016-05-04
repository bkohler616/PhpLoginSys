<?php $activePage = "UserListing";
require_once('phpItems.php');
StartSessionSafely();
if (!isset($_SESSION['UserID']))
    RedirectTo404(Errors::NotLoggedIn);
if (!($_SESSION['AccountTypeID'] >= AccountType::Administrator))
    RedirectTo403(Errors::AdminOnly);
//Safe to assume the user is an admin. Build Data.
$query = "SELECT UserID, Username FROM Users";
$result = $connection->query($query);
if (!$result) die($conn->error);
$rows = $result->num_rows;
?>
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
    <h1>User Listing</h1>

    <div class="well well-sm">
        <div class="panel panel-default">
            <table class="table">
            <tr>
                <th>UserID</th>
                <th>Username</th>
                <th>Edit Account</th>
            </tr>
                <?php
                for ($j = 0; $j < $rows; ++$j) {
                    echo '<tr>';
                    $result->data_seek($j);
                    echo '<td> UserID: ' . $result->fetch_assoc()['UserID'] . '</td>';
                    $result->data_seek($j);
                    echo '<td> Username: ' . $result->fetch_assoc()['Username'] . '</td>';
                    $result->data_seek($j);
                    echo '<td> <a class="btn btn-primary btn-block" href="AccountEdit.php?UserID=' . $result->fetch_assoc()['UserID'] . '">Edit Account</a></td>';
                    echo '</tr>';
                }
                ?>

            </table>
        </div>
    </div>
</div>
</body>

<?php require_once("jsItems.php"); ?>