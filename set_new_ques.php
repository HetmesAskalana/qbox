<?php
require "includes/functions.php";
if(in_blacklist($_SERVER[REMOTE_ADDR])) die("<script>alert('正处在该用户的黑名单中');parent:location.href='new_ques.php';</script>");
$body = $_POST['ques'];
$username = $_POST['username'];
if(empty($body) or empty($username)) die("<script>alert('不能有任何一项为空');parent:location.href='new_ques.php';</script>");
new_ques($username, $body);
?>
