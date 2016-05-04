<?php
$connection = new mysqli("localhost", "root", "", "phpproject");

$passwordRegex = "/^(?=.*[\\p{Ll}])(?=.*[\\p{Lu}])(?=.*\\d)(?=.*[.?~!@#$%^;*])[\\p{L}\\d\\.?~!@#$%^;*]{8,}/";
$usernameRegex = "/^(?=.*[a-zA-Z]{1,})(?=.*[\\d]{0,})[a-zA-Z0-9]{5,30}$/";
$emailRegex = "^([a-z0-9_\\.-]+\\@[\\da-z\\.-]+\\.[a-z\\.]{2,6})$";

/**
 * This will start a session with the username given. Will grab the userID
 * @param $username string - The username to associate the session with.
 * @param $connection mysqli - The connection to use to access the DB.
 */
function Login($username, $connection)
{
    $query = mysqli_query($connection, "SELECT UserID, Username, AccountTypeID, AccountStatusID FROM Users WHERE Username = '$username'");
    if (!$query || !isset($query)) die($connection->error);
    $data = $query->fetch_assoc();
    $_SESSION['UserID'] = $data['UserID'];
    $_SESSION['Username'] = $data['Username'];
    $_SESSION['AccountTypeID'] = $data['AccountTypeID'];
    $_SESSION['AccountStatusID'] = $data['AccountStatusID'];
    header('Location: /PhpLoginSys/Index.php');
}

function passwordSalt()
{
    $salt = chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126));
    return $salt;
}

/**
 * Start the session, ensuring that the session isn't already started.
 */
function StartSessionSafely()
{
    if (session_status() != PHP_SESSION_ACTIVE)
        session_start();
}

/**
 * If Userid is set, then assume we are logged in.
 * @return bool true if logged in.
 */
function IsLoggedIn()
{
    StartSessionSafely();
    if (isset($_SESSION['UserID']))
        return true;
    return false;
}

/**
 * Redirect to the homepage.
 */
function RedirectToHome(){
    header('Location: /PhpLoginSys/Index.php');
}

/**
 * Redirect to the 404 page. Just used as general redirect for not found.
 * @param $reasonOfRedirect int - The reason for redirect. Use Errors enum values.
 */
function RedirectTo404($reasonOfRedirect)
{
    header('Location: /PhpLoginSys/404.php?Reason="' . $reasonOfRedirect . '"');
}

function RedirectTo403($reasonOfRedirect)
{
    header('Location: /PhpLoginSys/403.php?Reason="' . $reasonOfRedirect . '"');
}

/**
 * Redirect to home if already logged in. Useful for signin/singout.
 */
function RedirectIfLoggedIn()
{
    StartSessionSafely();
    if (IsLoggedIn())
        RedirectToHome();
}



abstract class AccountType
{
    const Banned = 1;
    const Standard = 2;
    const Administrator = 3;
    const SuperAdministrator = 4;

    static function GetAccountType($accountToReturn)
    {
        switch ($accountToReturn) {
            case AccountType::Standard:
                return "Standard";
            case AccountType::Banned:
                return "Banned";
            case AccountType::Administrator:
                return "Administrator";
            case AccountType::SuperAdministrator:
                return "Super Admin";
        }
        return "error";
    }
}

abstract class AccountStatus
{
    const Active = 1;
    const NotRegistered = 2;
    const Suspended = 3;
    const Banned = 4;
    const Deleted = 5;

    static function GetAccountStatus($statusToReturn)
    {
        switch ($statusToReturn) {
            case AccountStatus::Active:
                return "Active";
            case AccountStatus::NotRegistered:
                return "Not Registered";
            case AccountStatus::Suspended:
                return "Suspended";
            case AccountStatus::Banned:
                return "Banned";
            case AccountStatus::Deleted:
                return "Deleted";
        }
        return "error";
    }
}

abstract class AccountVisibility
{
    const PrivateAccount = 1;
    const PublicAccount = 2;

    static function GetAccountVisibility($visibilityToReturn)
    {
        switch ($visibilityToReturn) {
            case AccountVisibility::PrivateAccount:
                return "Private Account";
            case AccountVisibility::PublicAccount:
                return "Public Account";
        }
        return "error";
    }
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

abstract class Errors
{
    const AdminOnly = 1;
    const PrivateAccount = 2;
    const NotLoggedIn = 3;
    const UserDoesNotExist = 4;
    const UserNotGiven = 5;

    static function GetError($errorToReturn)
    {
        switch ($errorToReturn) {
            case Errors::AdminOnly:
                return "Admins are allowed there. Not standard users. Sorry.";
            case Errors::PrivateAccount:
                return "You attempted to access a private account. Sadly, you do not have the permissions for this";
            case Errors::NotLoggedIn:
                return "You are not logged in, so you cannot see this page. Please login.";
            case Errors::UserDoesNotExist:
                return "The user account provided doesn't exist.";
            case Errors::UserNotGiven:
                return "A user was not provided.";
        }
        return "error";
    }
}
?>