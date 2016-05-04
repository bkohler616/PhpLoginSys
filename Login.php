<?php $activePage = "Login";
require_once('phpItems.php');
RedirectIfLoggedIn(); ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php require_once("cssItems.php"); ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container">
    <?php
    // Username : Password
    // test : test
    $errorMsg = "";
    $errorExists = false;
    // If the values are passed to the page perform the login on the server
    if (isset($_POST["inputUsername"]) && isset($_POST["inputPassword"])) {

        $testUser = preg_match($usernameRegex, $_POST["inputUsername"], $username);
        $testPass = preg_match($passwordRegex, $_POST["inputPassword"], $password);

        $validInfo = false;
        if ($testUser == 1 && $testPass == 1) {
            $validInfo = true;
        }

        $username = $_POST["inputUsername"];
        $password = $_POST["inputPassword"];


        //TODO: Check to see if the regex strings and the originals are the same.
        if ($validInfo) {
            // Call the login function from the db passing the username and password.
            // the login function needs to hash and salt the password then compare to the
            // users password in the db.
            $password = sha1($password, true);
            $query = mysqli_query($connection, "SELECT Login_Check('$username', '$password')") Or die("No Query String");

            If (isset($query)) {
                $row = mysqli_fetch_array($query)["Login_Check('$username', '$password')"];

                if ($row == "Username and password match") {
                    Login($username, $connection);
                } elseif ($row == "Username and password do not match") {
                    $errorExists = true;
                    $errorMsg = $errorMsg . "\nUsername and password do not match.";
                } else {
                    $errorExists = true;
                    $errorMsg = $errorMsg . "\nUsername not found. Maybe you should sign up?";
                }

            } else {
                $errorExists = true;
                $errorMsg = $errorMsg . "\nCritical issue. Query did not generate.";
            }
        } else {
            $errorExists = true;
            if ($testUser == 0)
                $errorMsg = $errorMsg . "\nInvalid username";
            if ($testPass == 0)
                $errorMsg = $errorMsg . "\nInvalid password";
        }
    } ?>
    <?php if ($errorExists) { ?>
        <div class='alert alert-danger' role='alert'>
            Error: <?php echo $errorMsg ?>
        </div>

    <?php } ?>
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


</HTML>