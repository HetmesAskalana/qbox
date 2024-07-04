<h1>用户信息</h1><br/>
<?php
require "includes/mysql.php";
require "includes/functions.php";
if(!is_login()){
	echo "<script>alert('请先登录');parent:location.href='login.php';</script>";
}
$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
$cmd = "SELECT * FROM user WHERE user_token = '".$_COOKIE['user_token']."';";
$user = $db->query($cmd);
$info = $user->fetch_assoc();
$cmd = "SELECT COUNT(*) as count FROM questions WHERE uid = ".$info['uid'].";";
$n = $db->query($cmd);
$cnt = $n->fetch_assoc();
?>
<font color = "blue"><h1>基本信息</h1></font>
UID：<?php echo $info['uid']; ?><br/>
用户名：<?php echo $info['username']; ?><br/>
<!--问题总数：<?php echo $cnt['COUNT(*)']; ?><br/>-->
您的提问箱链接：<a href = "new_ques.php?target_un=<?php echo $info['username']; ?>"><?php echo $_SERVER['HTTP_HOST']; ?>/new_ques.php?target_un=<?php echo $info['username']; ?></a><br/>
前往查看问题：<a href = "show.php">点此</a><br/>
<font color = "blue"><h1>设置</h1></font>
<form method = "post" action = "set_show_rule.php">
<h2>问题显示模式</h2>
<input type="radio" name="rule" value="single" /> 单一显示<br>
<input type="radio" name="rule" value="all" /> 全部顺次显示<br>
<input type="submit" value = "提交">
</form>
<font color = "blue"><h1>黑名单列表</h1></font>
<a href = 'my_blacklist.php'>点击查看</a>
<h1><a href = "logout.php"><font color = "blue">登出</font></a></h1>
