<title>黑名单列表</title>
<?php
require "includes/functions.php";
if(!is_login()) die("<script>alert('请先登录');parent:location.href='login.php';</script>");
show_blacklist($_COOKIE['user_token']);
?>
