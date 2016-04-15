<?php
/**
 * Created by PhpStorm.
 * User: bkohler
 * Date: 4/15/2016
 * Time: 9:22 AM
 */
?>
    <HTML>
<head>
    <?php
    require_once("cssItems.php");
    ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container-fluid">
    <h1>Hello World!</h1>
    <p>Welcome here.</p>
    <div class="well">
        <h2>
            Here's some stuff
        </h2>
        <p>
            It's in a well.
        </p>
    </div>
    <div class="well well-sm">
        Here's a small signin example:
        <form class="form-signin">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required=""
                   autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
        That's a decent signin.
    </div>
</div>
</body>

<?php
require_once("jsItems.php");
?>