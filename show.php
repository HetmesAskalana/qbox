<center><h1><font color = "blue">显示问题</font></h1></center><br/>
<?php
require "includes/functions.php";
require "includes/mysql.php";
$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
$cmd = "SELECT * FROM user WHERE user_token = '".$_COOKIE['user_token']."';";
$user = $db->query($cmd);
$userinfo = $user->fetch_assoc();
if(!is_login()){
	echo "<script>alert('请先登录');parent:location.href='login.php';</script>";
}
if($userinfo['show_rule'] == 0){
	echo "<center>问题将被展示在下面，点击已读将会展示下一个问题。<br/></center><center><h2><font color = 'gray'>";
	show_ques($_COOKIE['user_token']);
}else if($userinfo['show_rule'] == 1){
	echo "<center>正在展示全部问题，已读的将不会展示。<br/></center>";
	show_ques($_COOKIE['user_token']);
}else die("设置选项非法，请联系系统管理员");
?>
