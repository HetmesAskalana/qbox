<h1>用户信息</h1><br/>
<?php
require "includes/mysql.php";
require "includes/funtions.php";
if(!is_login()){
	echo "<script>alert('请先登录');parent:location.href='/login.php';</script>";
}
$cmd = "SELECT * FROM 'user' WHERE 'user_token' = '".$name."';";
$user = mysql_query($cmd);
$info = mysql_fetch_array($user);
?>
UID：<?php echo $info['uid']; ?><br/>
用户名：<?php echo $info['username']; ?><br/>
您的提问箱链接：https://qbox.unacas.org/new_ques.php?target_un=<?php echo $info['username']; ?><br/>
前往查看问题：https://qbox.unacas.org/show.php<br/>
