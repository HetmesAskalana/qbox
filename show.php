<?php
require "includes/functions.php";
if(!is_login()){
	echo "<script>alert('请先登录');parent:location.href='/login.php';</script>";
}
echo "问题将被展示在下面，刷新将会展示下一个问题。"；
echo show_ques($_COOKIE['user_token']);
?>
