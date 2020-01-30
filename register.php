<?php
require "includes/functions.php";
require "includes/mysql.php";
$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
$cmd = "SELECT * FROM config WHERE id = 1;";
$cfg = $db->query($cmd);
$info = $cfg->fetch_assoc();
?>
<form method = "post" action = "set_register.php">
<center>用户名：<input type = "text" name = "un"><br/>
<center>密码：<input type = "password" name = "pw1"><br/>
<center>确认密码：<input type = "password" name = "pw2"><br/>
<?php
if($info['reg_auth'] == 1)
	echo "<center>邀请码：<input type = 'text' name = 'rc'><br/>";
?>
<input type = "submit" value = "提交">
</form>
