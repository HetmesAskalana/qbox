<!DOCTYPE HTML>
<?php
require "includes/functions.php";
if(is_login()){
	echo "<a href = '/user_info.php'>点击前往用户页面</a><br/>";
}
?>
<center><h1><font color = "blue">欢迎访问提问箱！</font></h1></center><br/>
<center><h2><font color = "blud">新建一个问题？</font></h3></center><br/>
<center><h3><font color = "red"><a href = "new_ques.php">点击这里！</a></font></h3></center>
