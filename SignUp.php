<?php $activePage = "Sign Up"; ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php require_once("cssItems.php"); ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container">
    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Sign Up</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" required="required"
               autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password"
               required="required">
        <label for="inputPasswordConfirm" class="sr-only">Confirm Password</label>
        <input type="password" id="inputPasswordConfirm" name="inputPasswordConfirm" class="form-control form-final" placeholder="Confirm password"
               required="required">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
    </form>
</div>
</body>

<?php require_once("jsItems.php"); ?>

<?php
require_once("phpItems.php");

if(isset($_POST["inputUsername"]) && isset($_POST["inputPassword"]) && isset($_POST["inputPasswordConfirm"])) {
    if($_POST["inputPassword"] == $_POST["inputPasswordConfirm"]) {

        //ReGex checker for the username and password
        //TODO: Fix the regex so that it can validate the password and username.
        //preg_match($regexString, $_POST["inputUsername"], $username);
        //preg_match($regexString, $_POST["inputPassword"], $password);

        $username = $_POST["inputUsername"];
        $password = $_POST["inputPassword"];

        //TODO: Check to see if the regex strings and the originals are the same.
        if (true) {

            // The passwords match
            $salt = passwordHash();

            $query = mysqli_query($connection, "CALL Create_User(1, '$username', '', '$password', '$salt', 1)");

            if (isset($query)) {
                header('Location: http://' . $_SERVER['HTTP_HOST'] . "/PhpLoginSys/Login.php");
            }
        }
        else {
            // Password does not pass the regex.
            echo "The password is not allowed";
        }
    } else {
        // The passwords do not match
        echo "The passwords do not match";
    }
}

/*
 * Generate a password salt that is ten characters long
 * Return - Type: String
 *          Value: The salt in a string form.
 */
function passwordHash() {
    $salt = chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126));
    return $salt;
}
?>

</HTML>