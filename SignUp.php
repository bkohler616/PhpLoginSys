<?php $activePage = "Sign Up"; ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php require_once("cssItems.php"); ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>
<div class="container">
    <form class="form-signin">
        <h2 class="form-signin-heading">Sign Up</h2>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required="required"
               autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password"
               required="required">
        <label for="inputPasswordConfirm" class="sr-only">Confirm Password</label>
        <input type="password" id="inputPasswordConfirm" class="form-control form-final" placeholder="Confirm password"
               required="required">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
    </form>
</div>
</body>

<?php require_once("jsItems.php"); ?>
</HTML>