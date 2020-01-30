<center><h1><font color = "blue">显示问题</font></h1></center><br/>
<?php
require "includes/functions.php";
if(!is_login()){
	echo "<script>alert('请先登录');parent:location.href='login.php';</script>";
}
echo "<center>问题将被展示在下面，刷新将会展示下一个问题。<br/></center><center><h2><font color = 'gray'>";
show_ques($_COOKIE['user_token']);
echo "</font></h2></center><br/><center><a href = 'show.php' >点击刷新</a></center>";
?>
