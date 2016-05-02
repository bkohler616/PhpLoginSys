<?php $activePage = "Sign Up"; ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php require_once("cssItems.php"); ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container">
    <div class="alert alert-info">
        Username Requirements:
        <ul>
            <li>
                5-30 characters.
            </li>
            <li>
                Alpha-numeric characters.
            </li>
            <li>
                Must start with a letter.
            </li>
        </ul>

        Password Requirements:
        <ul>
            <li>
                8-32 characters.
            </li>
            <li>
                Must start with a letter.
            </li>
            <li>
                May contain any alpha-numeric characters and the allowed special characters (.?~!@#$%^;*)
            </li>
        </ul>
    </div>
    <?php
    require_once("phpItems.php");
    $errorMsg = "";
    $errorExists = false;
    if (isset($_POST["inputUsername"]) && isset($_POST["inputPassword"]) && isset($_POST["inputPasswordConfirm"])) {
        if ($_POST["inputPassword"] == $_POST["inputPasswordConfirm"]) {

            //ReGex checker for the username and password
            //TODO: Fix the regex so that it can validate the password and username.
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


                // The passwords match
                $salt = passwordHash();

                $query = mysqli_query($connection, "SELECT Create_User('$username', '$password', '$salt')");

                if (isset($query)) {
                    $row = mysqli_fetch_assoc($query)["Create_User('$username', '$password', '$salt')"];

                    if ($row == "Username Taken") {
                        $errorMsg = $errorMsg . "User already exists";
                        $errorExists = true;
                    } elseif ($row == "User Added") {
                        //header('Location: http://' . $_SERVER['HTTP_HOST'] . "/PhpLoginSys/Login.php");
                    }

                } else {
                    // Password does not pass the regex.
                    $errorMsg = $errorMsg . "The password is does not meet password requirements";
                    $errorExists = true;
                }
            } else {
                // The passwords do not match
                $errorMsg = $errorMsg . "The passwords do not match";
                $errorExists = true;
            }
        }
    }

    if ($errorExists) {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "Error: " . $errorMsg;
        echo "</div>";

    }

    /*
     * Generate a password salt that is ten characters long
     * Return - Type: String
     *          Value: The salt in a string form.
     */
    function passwordHash()
    {
        $salt = chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126)) . chr(mt_rand(33, 126));
        return $salt;
    }

    ?>
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

</HTML>