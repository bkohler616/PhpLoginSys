<?php
$connection = new mysqli("localhost", "root", "", "phpproject");

$regexString = "/^(?=.*[\\p{Ll}])(?=.*[\\p{Lu}])(?=.*\\d)(?=.*[.?~!@#$%^;*])[\\p{L}\\d\\.?~!@#$%^;*]{8,}/";
?>