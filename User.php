<?php
/**
 * Created by PhpStorm.
 * User: bkohler
 * Date: 5/2/2016
 * Time: 8:46 PM
 */
require_once('phpItems.php');
StartSessionSafely();
if(isset($_GET['UserID']))
{
    //TODO: Generate User info.
    if($_GET['UserID'] == "test")
        echo "test";
} else{
    RedirectToHome();
}
