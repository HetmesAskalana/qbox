<!DOCTYPE HTML>
<?php
require "includes/functions.php";
if(is_login()){
	echo "<script>alert('已经登录');parent:location.href='/index.php';</script>";
	die();
}
?>
<form method = "post" action = "setlogin.php">
<center>用户名<input type = "text" name = "username"></center>
<center>密码<input type = "password" name = "pw"></center>
<center><input type = "submit" value = "登录"></center>
</form>
<center><font color = "blue">如果只是提问请点击<a href = "add_ques.php">这里</a></font></center>
