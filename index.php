<!DOCTYPE HTML>
<?php
require "includes/functions.php";
if(is_login()){
	echo "<center><a href = 'user_info.php'>点击前往用户页面</a><br/></center>";
}
?>
<center><h1><font color = "blue">欢迎访问提问箱！</font></h1></center><br/>
<center><h2><font color = "red"><a href = "new_ques.php">新建一个问题</a></font></h3></center><br/>
<?php
if(!is_login()){
echo "<center><h2><font color = 'red'><a href = 'register.php'>点击注册</a></font></h2></center><center><h2><font color = 'red'><a href = 'login.php'>点击登陆</a></font></h2></center>";
}else echo "<h2><center><a href = 'logout.php'><font color = 'blue'>登出</font></a></center></h2>"
?>
<br><br><br><br>
<b>Copyright© Hetmes Askalana of UNACAS Org., published on GNU.</b>
