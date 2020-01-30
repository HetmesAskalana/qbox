<?php
require "includes/functions.php";
$body = $_POST['ques'];
$username = $_POST['username'];
if(empty($body) or empty($username)) die("不能有任何一项为空");
new_ques($username, $body);
?>
