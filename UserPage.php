<!DOCTYPE HTML>
<HTML>
<head>
    <?php
    require_once("cssItems.php");
    ?>
    </head>
    <body>
    <?php require_once("NavBar.php"); ?>
    <div class="container-fluid">
        <h1>Hello, *Insert user name*</h1>
        <p>Account Management</p>

        <div class="well well-sm">
            <form class="form-signin">
                <h2 class="form-signin-heading">User Info</h2>

                <label for="inputUsername" class="sr-only">Username</label>
                <input type="Username" id="inputUsername" class="form-control" placeholder="Username" required=""
                       autofocus="">

                <label for="inputPassword" class="sr-only">New Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="New Password" required="">

                <label for="inputPassword" class="sr-only">New Password Confirm</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="New Password Confirm" required="">

                <br>*Current Password required to update account*

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Current Password" required=""><br>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
            </form>
        </div>
    </div>
    </body>

<?php require_once("jsItems.php"); ?>