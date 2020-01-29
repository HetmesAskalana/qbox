<?php
require "includes/functions.php";
$body = $_POST['ques'];
$username = $_POST['username'];
new_ques($username, $body);
?>
