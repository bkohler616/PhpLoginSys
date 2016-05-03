<?php
$connection = new mysqli("localhost", "root", "", "phpproject");

$passwordRegex = "/^(?=.*[\\p{Ll}])(?=.*[\\p{Lu}])(?=.*\\d)(?=.*[.?~!@#$%^;*])[\\p{L}\\d\\.?~!@#$%^;*]{8,}/";
$usernameRegex = "/^(?=.*[a-zA-Z]{1,})(?=.*[\\d]{0,})[a-zA-Z0-9]{5,30}$/";

/**
 * This will start a session with the username given. Will grab the userID
 * @param $username string - The username to associate the session with.
 * @param $connection mysqli - The connection to use to access the DB.
 */
function Login($username, $connection)
{
    $query = mysqli_query($connection, "SELECT * FROM Users WHERE Username = '$username'");
    if (!$query || !isset($query)) die($connection->error);
    $data = $query->fetch_assoc();
    $_SESSION['UserID'] = $data['UserID'];
    $_SESSION['Username'] = $data['Username'];
    $_SESSION['AccountTypeID'] = $data['AccountTypeID'];
    $_SESSION['AccountStatusID'] = $data['AccountStatusID'];
    header('Location: /PhpLoginSys/Index.php');
}

function StartSessionSafely()
{
    if (session_status() != PHP_SESSION_ACTIVE)
        session_start();
}

function IsLoggedIn()
{
    StartSessionSafely();
    if (isset($_SESSION['UserID']))
        return true;
    return false;
}

function RedirectToHome(){
    header('Location: /PhpLoginSys/Index.php');
}

function RedirectTo404(){
    header('Location: /PhpLoginSys/404.php');
}

function RedirectIfLoggedIn()
{
    StartSessionSafely();
    if (IsLoggedIn())
        RedirectToHome();
}


abstract class AccountType
{
    const Standard = 1;
    const Banned = 2;
    const Administrator = 3;
    const SuperAdministrator = 4;
}

abstract class AccountStatus
{
    const Active = 1;
    const NotRegistered = 2;
    const Suspended = 3;
    const Banned = 4;
    const Deleted = 5;
}

abstract class AccountVisibility
{
    const PrivateAccount = 1;
    const PublicAccount = 2;
}

abstract class LoginAction
{
    const UserLoggedInSuccessfully = 1;
    const UserLoggedOut = 2;
    const UserSessionEnded = 3;
    const AttemptedLoginBadPassword = 4;
}

abstract class UserUpdateAction
{
    const ChangedPassword = 1;
    const ChangedUsername = 2;
    const ChangedEmail = 3;
    const ChangedUsernamePassword = 4;
    const ChangedUsernameEmail = 5;
    const ChangedPasswordEmail = 6;
    const ChangedUsernamePasswordEmail = 7;
    const DeletedAccount = 8;
}
?>