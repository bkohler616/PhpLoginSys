<?php $activePage = "Login"; ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php require_once("cssItems.php"); ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container">
    <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Login</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" required="required"
               autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control form-final" placeholder="Password"
               required="required">
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div>
</body>

<?php require_once("jsItems.php"); ?>

<?php
// If the values are passed to the page perform the login on the server
if (isset($_POST["inputUsername"]) && isset($_POST["inputPassword"])) {
    //ReGex checker for the username and password
    //TODO: Change the Regex to the correct one to test for sql injection.
    if (preg_match("/(.*)/", $_POST["inputUsername"], $output_array)){
        //TESTING: Don't output data. Instead verify and replace if necessary.
        print_r($output_array);
    }

    require_once("dbItems.php");

    //TODO: Query the database to see if the information is correct.
    $result = $connection->query("") Or die("No Query Selected");   // Call the login function from the db passing the username and password.
                                                                    // the login function needs to hash and salt the password then compare to the
                                                                    // users password in the db.

    If (isset($result)) {

        session_start();

        $_SESSION["activePage"] = "Login";

        // Redirect to a page after login
       header('Location: http://' . $_SERVER['HTTP_HOST'] . "/PhpLoginSys/Index.php");
    } else {
        //echo "Please enter your Username and Password";
    }
}

?>
</HTML>