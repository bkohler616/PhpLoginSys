<?php $activePage = "accountEdit";
require_once('phpItems.php');
StartSessionSafely();
$errorExists = false;
$errorMsg = "";
$IsPasswordConfirmed = false;
if (isset($_POST['changingUserID'])) {
    //Validate if password is okay.
    $password = $_POST['currentPassword'];
    $testPass = preg_match($passwordRegex, $_POST["currentPassword"]);

    $validInfo = false;
    if ($testPass == 1) {
        $validInfo = true;
    }
    if ($validInfo) {
        $username = $_SESSION['Username'];
        $query = mysqli_query($connection, "SELECT Login_Check('$username', '$password')") Or die("No Query String");
        if (isset($query)) {
            $row = mysqli_fetch_array($query)["Login_Check('$username', '$password')"];

            if ($row == "Username and password match") {
                $IsPasswordConfirmed = true;
            } elseif ($row == "Username and password do not match") {
                $errorExists = true;
                $errorMsg = $errorMsg . "\nUsername and password do not match.";
            } else {
                $errorExists = true;
                $errorMsg = $errorMsg . "\nUsername not found. Maybe you should sign up? (shouldn't appear here";
            }
        } else {
            $errorExists = true;
            $errorMsg = $errorMsg . "\nCritical issue. Query did not generate.";
        }
    } else {
        $errorExists = true;
        $errorMsg = "Confirmation password not valid.";
    }

}
if ($IsPasswordConfirmed) {
    $errorExists = true;
    $errorMsg = "password confirmed!";

}

if (!isset($_GET['UserID']))
    RedirectTo404(Errors::UserNotGiven);
//TODO: Only specific people can edit. User and admins in hierarchy.
if (!isset($_SESSION['UserID']))
    RedirectTo403(Errors::NotLoggedIn);

//User should be logged in from here on.
$IsAllowedAccess = false;
$IsOwnAccount = false;
$UserIsAdmin = false;
$UserIsSelfSuper = false;
//Make a quick query to gather the information. Might as well grab it all just in case.
$query = mysqli_query($connection, "SELECT UserID, AccountTypeID, Username, Email, AccountStatusID, AccountVisibilityID, DateCreated FROM Users WHERE UserID = " . $_GET['UserID']);
if (!isset($query) || !$query) die($connection->error);
$data = $query->fetch_assoc();

if (($_SESSION['AccountTypeID'] > $data['AccountTypeID'] && $_SESSION['AccountTypeID'] != AccountType::Standard))
    $UserIsAdmin = true;
elseif ($_SESSION['AccountTypeID'] == AccountType::SuperAdministrator && $_GET['UserID'] == $_SESSION['UserID']) {
    $UserIsAdmin = true;
    $UserIsSelfSuper = true;
} elseif ($_SESSION['UserID'] == $_GET['UserID'])
    $IsOwnAccount = true;
else
    RedirectTo403(Errors::AdminOnly);

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
    <h1>Editing accountID <?php echo $data['UserID'] . " ~~ " . $data['Username'] ?></h1>
    <p>Remember to "check" the box next to the item you want to edit.</p>
    <?php if ($errorExists) { ?>
        <div class='alert alert-danger' role='alert'>
            Error: <?php echo $errorMsg ?>
        </div>

    <?php } ?>

    <div class="well well-sm">
        <form class="form-signin" method="post">
            <input type="hidden" name="changingUserID" value="<?php echo $data['UserID'] ?>"
            <h2 class="form-signin-heading">User Info</h2>

            <label class="form-item-heading" for="changeUsername"> Change Username: </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" name="changeUsername">
                </span>
                <input type="text" name="inputUsername" class="form-control" placeholder="Username"
                       value="<?php echo $data['Username'] ?>">
            </div>

            <label class="form-item-heading" for="inputEmail">Change Email:</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" name="changeEmail">
                </span>
                <input type="email" name="inputEmail" class="form-control" placeholder="Email"
                       value="<?php echo $data['Email'] ?>">
            </div>

            <label class="form-item-heading" for="inputEmail">Change Password:</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" name="changeEmail">
                </span>
                <input type="password" name="inputNewPassword" class="form-control" placeholder="New Password">
            </div>
            <input type="password" name="inputConfirmPassword" class="form-control" placeholder="Confirm New Password">


            <label class="form-item-heading" for="accountVisibility">Account Visibility</label>
            <br>
            <input type="radio" name="accountVisibility" value=<?php echo AccountVisibility::PublicAccount ?>
                <?php if ($data['AccountVisibilityID'] == AccountVisibility::PublicAccount) echo "checked" ?>>
            Public
            <br>
            <input type="radio" name="accountVisibility" value=<?php echo AccountVisibility::PrivateAccount ?>
                <?php if ($data['AccountVisibilityID'] == AccountVisibility::PrivateAccount) echo "checked" ?>>
            Private
            <br>
            <br>

            <?php if ($UserIsAdmin) { ?>
                <label class="form-item-heading" for="accountStatus">Account Status</label>
                <br>
                <input type="radio" name="accountStatus" value=<?php echo AccountStatus::Active ?>
                    <?php if ($data['AccountStatusID'] == AccountStatus::Active) echo "checked" ?>> Active
                <br>
                <input type="radio" name="accountStatus" value=<?php echo AccountStatus::NotRegistered ?>
                    <?php if ($data['AccountStatusID'] == AccountStatus::NotRegistered) echo "checked" ?>> Not Registered
                <br>
                <input type="radio" name="accountStatus" value=<?php echo AccountStatus::Suspended ?>
                    <?php if ($data['AccountStatusID'] == AccountStatus::Suspended) echo "checked" ?>> Suspended
                <br>
                <input type="radio" name="accountStatus" value=<?php echo AccountStatus::Banned ?>
                    <?php if ($data['AccountStatusID'] == AccountStatus::Banned) echo "checked" ?>> Banned
                <br>
                <input type="radio" name="accountStatus" value=<?php echo AccountStatus::Deleted ?>
                    <?php if ($data['AccountStatusID'] == AccountStatus::Deleted) echo "checked" ?>> Deleted
                <br>
                <?php if (!$UserIsSelfSuper) { ?>
                    <br>
                    <label class="form-item-heading" for="accountType">Account Type</label>
                    <br>
                    <input type="radio" name="accountType" value=<?php echo AccountType::Banned ?>
                        <?php if ($data['AccountTypeID'] == AccountType::Banned) echo "checked" ?>> Banned
                    <br>
                    <input type="radio" name="accountType" value=<?php echo AccountType::Standard ?>
                        <?php if ($data['AccountTypeID'] == AccountType::Standard) echo "checked" ?>> Standard
                    <br>
                    <?php if ($_SESSION['AccountTypeID'] == AccountType::SuperAdministrator) { ?>
                        <input type="radio" name="accountType" value=<?php echo AccountType::Administrator ?>
                            <?php if ($data['AccountTypeID'] == AccountType::Administrator) echo "checked" ?>> Administrator
                        <br>
                    <?php }
                }
            } ?>

            <br>*Current Password required to update account*

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="currentPassword" class="form-control" placeholder="Current Password"
                   required=""><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit" formmethod="post">Update</button>
        </form>
    </div>
</div>
</body>

<?php require_once("jsItems.php"); ?>