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
	$cmd = "INSERT INTO user (username, pw, user_token) VALUES ('".$un."', ".$pw.", ".$tok.");";
	echo "<script>alert('注册完成，前往登录');parent:location.href='login.php';</script>";
}
function new_ques($name, $message){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE username = '".$name."';";
	$user = $db->query($cmd);
	$info = $user->fetch_assoc();
	if(empty($info)) die("用户不存在");
	$uid = $info['uid'];
	$cmd = "INSERT INTO questions (uid, msg, submit_ip) VALUES (".$info['uid'].", '".$message."', '".$_SERVER_[REMOTE_ADDR]."');";
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
	}else if($userinfo['show_rule'] == 1){
		if($ques->num_rows <= 0) die("<center><h2><font color = 'blue'>现在莫得问题</font></h2></center>");
		$cnt = 0;
		while($info = $ques->fetch_array()){
			echo "<center><h2><font color = 'gray'>第".++$cnt."条：".$info['msg']."</font></h2></center>";
			echo "<center><font color = 'blue'><a href = 'set_readed.php?qid=".$info['id']."'>已读</a></font></center><br/>";
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
?>
