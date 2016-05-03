<?php
/**
 * Created by PhpStorm.
 * User: bkohler
 * Date: 5/2/2016
 * Time: 8:26 PM
 */
require_once('phpItems.php');
StartSessionSafely();

echo "UserID: " . $_SESSION['UserID'];
echo "\nUsername: " . $_SESSION['Username'];
echo "\nAccountType: " . $_SESSION['AccountTypeID'];
echo "\nAccountStatus: " . $_SESSION['AccountStatusID'];
