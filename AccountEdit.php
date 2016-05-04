<?php $activePage = "accountEdit";
require_once('phpItems.php');
StartSessionSafely();
if (!isset($_GET['UserID']))
    RedirectTo404(Errors::UserNotGiven);
if (!isset($_SESSION['UserID']))
    RedirectTo403(Errors::NotLoggedIn);
//User should be logged in from here on.
$errorExists = false;
$errorMsg = "";
$IsPasswordConfirmed = false;
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


if (isset($_POST['changingUserID'])) {
    //Validate if password is okay.
    $password = $_POST['currentPassword'];
    $testPass = preg_match($passwordRegex, $_POST["currentPassword"]);

    $validInfo = false;
    if ($testPass == 1) {
        $validInfo = true;
    }
    if ($validInfo) {
        $password = sha1($password, true);
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
    $changeUsername = false;
    $changeEmail = false;
    $changePassword = false;
    $addedInfo = false;


    $query = "UPDATE Users SET UserID=" . $_POST['changingUserID'] . ", ";
    if (isset($_POST['checkbox'])) {
        if (in_array('username', $_POST['checkbox'])) {
            $testUser = preg_match($usernameRegex, $_POST["inputUsername"]);
            if ($testUser == 1) {
                $query = $query . "Username='" . $_POST["inputUsername"] . "', ";
            } else {
                $errorMsg = $errorMsg . "\nUsername invalid";
                $errorExists = true;
                $addedInfo = false;
            }
        }
        if (in_array('email', $_POST['checkbox'])) {
            $testEmail = preg_match($emailRegex, $_POST['inputEmail']);
            if ($testEmail == 1) {
                $query = $query . "Email='" . $_POST['inputEmail'] . "', ";
            } else {
                $errorMsg = $errorMsg . "\nEmail Invalid: " . $testEmail;
                $errorExists = true;
                $addedInfo = false;
            }
        }
        if (in_array('password', $_POST['checkbox'])) {
            if ($_POST['inputConfirmPassword'] == $_POST['inputNewPassword']) {
                $testPassword = preg_match($passwordRegex, $_POST['inputNewPassword']);
                if ($testPassword == 1) {
                    $salt = passwordSalt();
                    $password = sha1($_POST['inputNewPassword'], true);
                    $userID = $_POST['changingUserID'];
                    $passQuery = mysqli_query($connection, "SELECT Pass_Check('$userID', '$password', '$salt')");
                    if (isset($passQuery)) {
                    } else {
                        $errorMsg = $errorMsg . "\nPassword Query failed.";
                        $errorExists = true;
                    }
                } else {
                    $errorMsg = $errorMsg . "\nPassword invalid.";
                    $errorExists = true;
                    $addedInfo = false;
                }
            } else {
                $errorMsg = $errorMsg . "\nPasswords did not match.";
                $errorExists = true;
                $addedInfo = false;
            }
        }
    }
    if ($UserIsSelfSuper) {
        $query = $query . "AccountStatusID=" . $_POST['accountStatus'] . ", AccountVisibilityID=" .
            $_POST['accountVisibility'] . " ";
    } elseif ($UserIsAdmin) {
        $query = $query . "AccountStatusID=" . $_POST['accountStatus'] . ", AccountVisibilityID=" .
            $_POST['accountVisibility'] . ", AccountTypeID=" . $_POST['accountType'] . " ";
    } elseif ($IsOwnAccount) { //User is self.
        $query = $query . "AccountVisibilityID=" . $_POST['accountVisibility'] . " ";
    }

    $query = $query . "WHERE UserID=" . $_POST['changingUserID'];
    $query = mysqli_query($connection, $query) Or die("No Query String");

}


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
                    <input type="checkbox" name="checkbox[]" value="username">
                </span>
                <input type="text" name="inputUsername" class="form-control" placeholder="Username"
                       value="<?php echo $data['Username'] ?>">
            </div>

            <label class="form-item-heading" for="inputEmail">Change Email:</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" name="checkbox[]" value="email">
                </span>
                <input type="email" name="inputEmail" class="form-control" placeholder="Email"
                       value="<?php echo $data['Email'] ?>">
            </div>

            <label class="form-item-heading" for="inputPassword">Change Password:</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" name="checkbox[]" value="password">
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