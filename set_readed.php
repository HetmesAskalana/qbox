<?php
require "includes/functions.php";
if(!is_login()) die("<script>alert('请先登录');parent:location.href='login.php';</script>");
set_readed($_COOKIE['user_token'], $_GET['qid']);
?>
