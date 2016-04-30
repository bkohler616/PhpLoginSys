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


// Username : Password
// test : test


// If the values are passed to the page perform the login on the server
if (isset($_POST["inputUsername"]) && isset($_POST["inputPassword"])) {

    require_once("phpItems.php");

    //ReGex checker for the username and password
    //TODO: Fix the regex so that it can validate the password and username.
    //preg_match($regexString, $_POST["inputUsername"], $username);
    //preg_match($regexString, $_POST["inputPassword"], $password);
    $username = $_POST["inputUsername"];
    $password = $_POST["inputPassword"];

    //TODO: Check to see if the regex strings and the originals are the same.
    if (true) {
        // Call the login function from the db passing the username and password.
        // the login function needs to hash and salt the password then compare to the
        // users password in the db.
        $query = mysqli_query($connection, "SELECT Login_Check('$username', '$password')") Or die("No Query String");

        If (isset($query)) {
            $row = mysqli_fetch_array($query)["Login_Check('$username', '$password')"];

            if ($row == "Username and password match") {
                session_start();

                $_SESSION["User"] = $username;

                // Redirect to a page after login
                header('Location: http://' . $_SERVER['HTTP_HOST'] . "/PhpLoginSys/Index.php");
            }
            elseif($row == "Username and password do not match") {
                //TODO: Output that the tha username and password do not match.
                echo "The Username and Password do not match";
            }
            else {
                //TODO: Output that the username is not found.
                echo "The Username was not found";
            }

        } else {
            //echo "Please enter your Username and Password";
        }
    }
    else {

    }
}

?>
</HTML>