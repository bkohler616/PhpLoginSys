<?php
/**
 * Created by PhpStorm.
 * User: bkohler
 * Date: 5/2/2016
 * Time: 8:12 PM
 */

/**
 * @param $_SESSION array - The session to destroy.
 */
session_start();
$_SESSION = array();
unset($_SESSION);
session_destroy();
header('Location: /PhpLoginSys/Index.php');
?>