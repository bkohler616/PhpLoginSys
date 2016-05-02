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
    <h1>Hello, *Insert Admin name*</h1>

    <div class="well well-sm">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">User Account Information</div>
            <div class="panel-body">
            </div>

            <!-- Table -->
            <table class="table">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Account Status</th>
                <th>Account Visibility</th>
                <th>Date Created</th>
                <th>Edit *button in column*</th>
            </tr>

            </table>
        </div>
    </div>
</div>
</body>

<?php require_once("jsItems.php"); ?>