<?php $activePage = "Login"; ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php require_once("cssItems.php"); ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container">
    <form class="form-signin">
        <h2 class="form-signin-heading">Login</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required="required"
               autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control form-final" placeholder="Password"
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