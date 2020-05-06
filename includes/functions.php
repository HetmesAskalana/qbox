<?php
function is_login(){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	if(empty($_COOKIE['user_token'])){
		return false;
	}else{
		$cmd = "SELECT * FROM user WHERE user_token = '".$_COOKIE['user_token']."';";
		$user = $db->query($cmd);
		$info = $user->fetch_assoc();
		if(empty($info['username'])){
			setcookie("user_token", "null", time()-1);
			return false;
		}else return true;
	}
}
function set_login($un, $pw){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM qbox.user WHERE username = '".$un."';";
	$user = mysqli_query($db, $cmd);
	$info = mysqli_fetch_array($user);
	if(empty($info['username'])) die("用户不存在");
	if($pw == $info['pw']){
		$time = time() + 3600;
		setcookie("user_token", $info['user_token'], $time);
		$cmd = "UPDATE user SET last_ip = '".$_SERVER[REMOTE_ADDR]."' WHERE uid = ".$info['uid'].";";
		$db->query($cmd);
		echo "<script>alert('登陆完成');parent:location.href='index.php';</script>";
	}else die("密码错误");
}
function set_logout(){
	setcookie("user_token", "null", time()-1);
	echo "<script>alert('登出完成，正在前往主页');parent:location.href='index.php';</script>";
}
function set_register($un, $pw){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE username = '".$name."';";
	$user = $db->query($cmd);
	$info = $user->fetch_assoc();
	if(!empty($info)) die("用户名已被占用");
	$tok = md5(mt_rand(1, 1000).$username.$pw.time());
	$cmd = "INSERT INTO user (username, pw, user_token, last_ip) VALUES ('".$un."', ".md5($pw).", ".$tok.", '');";
	$db->query($cmd);
	echo "<script>alert('注册完成，前往登录');parent:location.href='login.php';</script>";
}
function new_ques($name, $message){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE username = '".$name."';";
	$user = $db->query($cmd);
	$info = $user->fetch_assoc();
	if(empty($info)) die("<script>alert('用户不存在');parent:location.href='new_ques.php';</script>");
	$uid = $info['uid'];
	$cmd = "INSERT INTO questions (uid, msg, submit_ip) VALUES (".$info['uid'].", '".$message."', '".$_SERVER[REMOTE_ADDR]."');";
	$db->query($cmd);
	echo "<script>alert('成功！即将返回到主界面');parent:location.href='index.php';</script>";
}
function set_readed($tok, $quesid){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE user_token = '".$tok."';";
	$user = $db->query($cmd);
	$info = $user->fetch_assoc();
	$cmd = "SELECT * FROM questions WHERE id = ".$quesid.";";
	$ques = $db->query($cmd);
	$ques_info = $ques->fetch_assoc();
	if($ques_info['uid'] == $info['uid']){
		$cmd = "UPDATE questions SET readed = 1 WHERE id = '".$quesid."';";
		$db->query($cmd);
		//echo "<script>alert('设置完成');window.opener=null;window.open('', '_self');window.close();</script>";
		echo "<script>alert('设置完成');parent:location.href='show.php';</script>";
	}else die("<script>alert('权限错误');parent:location.href='show.php';</script>");
}
function show_ques($tok){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE user_token = '".$tok."';";
	$user = $db->query($cmd);
	$userinfo = $user->fetch_assoc();
	$cmd = "SELECT * FROM questions WHERE readed = 0 and uid = ".$userinfo['uid'].";";
	$ques = $db->query($cmd);
    
	if($userinfo['show_rule'] == 0){
		$cmd = "UPDATE user SET last_id = ".$info['id']." WHERE user_token = '".$tok."';";
		$db->query($cmd);
		$info = $ques->fetch_assoc();
		if(empty($info)) die("<center><h2><font color = 'blue'>现在莫得问题</font></h2></center>");
		echo $info['msg'];
		echo "</font></h2></center><br/><center><center><font color = 'blue'><a href = 'set_readed.php?qid=".$info['id']."'>已读</a></font></center><br/>";
		echo "<center><font color = 'red'><a href = 'set_blacklist.php?qid=".$info['id']."'>骚扰项目（加入黑名单）</a></font></center><br/>";
	}else if($userinfo['show_rule'] == 1){
		if($ques->num_rows <= 0) die("<center><h2><font color = 'blue'>现在莫得问题</font></h2></center>");
		$cnt = 0;
		while($info = $ques->fetch_array()){
			echo "<center><h2><font color = 'gray'>第".++$cnt."条：".$info['msg']."</font></h2></center>";
			echo "<center><font color = 'blue'><a href = 'set_readed.php?qid=".$info['id']."'>已读</a></font></center><br/>";
			echo "<center><font color = 'red'><a href = 'set_blacklist.php?qid=".$info['id']."'>骚扰项目（加入黑名单）</a></font></center><br/>";
		}
	}
}
function set_show_rule($token, $rule){
	//0 -> 单一显示， 1 -> 全部显示
	if($rule != "single" and $rule != "all") die("设置信息非法");
	if($rule == "single") $rule_id = 0; else $rule_id = 1;
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "UPDATE user SET show_rule = ".$rule_id." WHERE user_token = '".$token."';";
	$db->query($cmd);
	echo "<script>alert('设置完成');parent:location.href='user_info.php';</script>";
}
//黑名单部分
function set_blacklist($tok, $qid){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM questions WHERE id = '".$qid."';";
	$ques = $db->query($cmd);
	$info = $ques->fetch_assoc();
	$ip = $info['submit_ip'];
	$cmd = "SELECT * FROM user WHERE user_token = '".$tok."';";
	$user = $db->query($cmd);
	$userinfo = $user->fetch_assoc();
	$uid = $userinfo['uid'];
	$cmd = "INSERT INTO blacklist (ip, uid, qid) VALUES ('".$ip."', ".$uid.", ".$qid.");";
	$db->query($cmd);
	set_readed($tok, $qid);
	echo "<script>alert('已将IP:".$ip."添加进黑名单');parent:location.href='show.php';</script>";
}
function unset_blacklist($id, $tok){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE user_token = '".$tok."';";
	$user = $db->query($cmd);
	$userinfo = $user->fetch_assoc();
	$uid = $userinfo['uid'];
	$cmd = "SELECT * FROM blacklist WHERE id = ".$id.";";
	$b = $db->query($cmd);
	$bl = $b->fetch_assoc();
	if(!$bl) die("<script>alert('无效的黑名单ID');parent:location.href='my_blacklist.php';</script>");
	if($uid != $bl['uid']) die("<script>alert('无效的用户账户');parent:location.href='my_blacklist.php';</script>");
	$cmd = "UPDATE blacklist SET active = 0 WHERE id = ".$id.";";
	$db->query($cmd);
	echo "<script>alert('已将IP:".$bl['ip']."移出黑名单');parent:location.href='my_blacklist.php';</script>";
}
function show_blacklist($tok){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE user_token = '".$tok."';";
	$user = $db->query($cmd);
	$userinfo = $user->fetch_assoc();
	$cmd = "SELECT * FROM blacklist WHERE uid = ".$userinfo['uid']." and active = 1;";
	$bl = $db->query($cmd);
	$cnt = 1;
	while($info = $bl->fetch_array()){
		$cmd = "SELECT * FROM questions WHERE id = '".$info['qid']."';";
		$q = $db->query($cmd);
		$ques = $q->fetch_assoc();
		echo "<h2>第".$cnt++."条黑名单</h2><br/>IP:".$info['ip']."<br/>被拉进黑名单时的问题:".$ques['msg']."<br/><a href = 'unset_blacklist.php?id=".$info['id']."'>点击移除</a>";
	}
	if($cnt == 1) die("<center><h1><font color = ‘blue’>暂时没有被加入黑名单的ip</font></h1></center>");
}
function in_blacklist($ip){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM blacklist WHERE ip = '".$ip."';";
	$bl = $db->query($cmd);
	if(!$bl) return false;
		else return true;
}
?>
