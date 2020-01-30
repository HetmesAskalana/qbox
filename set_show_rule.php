<?php
require "includes/functions.php";
if(!is_login()) die("<script>alert('请先登录');parent:location.href='login.php';</script>");
set_show_rule($_COOKIE['user_token'], $_POST['rule']);
?>
