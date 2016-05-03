<?php $activePage = "accountEdit";
require_once('phpItems.php'); ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <?php
    require_once("cssItems.php");
    ?>
</head>
<body>
<?php require_once("NavBar.php"); ?>


<!-- THIS IS THE USER SECTION THAT WILL APPEAR IF USER-->
<div class="container-fluid">
    <h1>Hello, *Insert user name*</h1>
    <p>Account Management</p>

    <div class="well well-sm">
        <form class="form-signin">
            <h2 class="form-signin-heading">User Info</h2>

            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" id="inputUsername" class="form-control" placeholder="Username" required=""
                   autofocus="">

            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email" required=""
                   autofocus="">

            <label for="inputPassword" class="sr-only">New Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="New Password" required="">

            <label for="inputPassword" class="sr-only">New Password Confirm</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="New Password Confirm" required="">

            <br>Account Visibility
            <div>
                <input type="radio" name="accountVisibilityPublic" value=<?php AccountVisibility::PublicAccount ?>>
                Visible to Other Users<br>
                <input type="radio" name="accountVisibilityPrivate" value=<?php AccountVisibility::PublicAccount ?>> Not
                Visible to Other Users<br>
            </div>

            <br>*Current Password required to update account*

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Current Password" required=""><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
        </form>
    </div>
</div>



<!-- THIS IS THE ADMIN SECTION THAT WILL APPEAR IF ADMIN-->
<div class="container-fluid">
    <h1>Hello, *Insert user name*</h1>
    <p>Account Management</p>

    <div class="well well-sm">
        <form class="form-signin">
            <h2 class="form-signin-heading">User Info</h2>

            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" id="inputUsername" class="form-control" placeholder="Username" required=""
                   autofocus="">

            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email" required=""
                   autofocus="">

            <label for="inputPassword" class="sr-only">New Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="New Password" required="">

            <label for="inputPassword" class="sr-only">New Password Confirm</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="New Password Confirm" required="">

            <br>Account Visibility
            <div>
                <input type="radio" name="accountVisibility" value=1> Visible to Other Users<br>
                <input type="radio" name="accountVisibility" value=0> Not Visible to Other Users<br>
            </div>

            <br>Account Type
            <div>
                <input type="radio" name="accountType" value=1> User<br>
                <input type="radio" name="accountType" value=0> Admin<br>
            </div>

            <br>Account Status: *Print Status Here*


            <input type="text" id="accountStatus" class="form-control" placeholder="Account Status Update" required=""><br>


            <button class="btn btn-lg btn-primary btn-block" type="submit">Update Information</button>
        </form>
    </div>
</div>
</body>

<?php require_once("jsItems.php"); ?>