<?php
$connection = new mysqli("localhost", "root", "", "phpproject");

$passwordRegex = "/^(?=.*[\\p{Ll}])(?=.*[\\p{Lu}])(?=.*\\d)(?=.*[.?~!@#$%^;*])[\\p{L}\\d\\.?~!@#$%^;*]{8,}/";
$usernameRegex = "/^(?=.*[a-zA-Z]{1,})(?=.*[\\d]{0,})[a-zA-Z0-9]{5,30}$/"
?>