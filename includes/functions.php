<?php
require "mysql.php";
$db = mysql_connect("localhost", $db_username, $db_pw);
mysql_selcect_db("qbox", $db);
function is_login(){
	if(empty($_COOKIE['user_token'])){
		return false;
	}else{
		$cmd = "SELECT * FROM user WHERE 'user_token' = ".$_COOKIE['user_token'].";";
		$user = mysql_query($cmd);
		$info = mysql_fetch_array($user);
		if(empty($info['username'])) return false;
			else return true;
	}
}
function set_login($un, $pw){
	$cmd = "SELECT * FROM user WHERE 'username' = ".$un.";";
	$user = mysql_query($cmd);
	$info = mysql_fetch_array($user);
	if(empty($info['username'])) die("用户不存在");
	if($pw == $info['pw']){
		setcookie("user_token", $info['token'], time()+315360000);
		echo "<script>alert('登陆完成');parent:location.href='/index.php';</script>";
	}else die("密码错误");
}
function set_logout(){
	setcookie("user_token", "null", time()-1);
}
function new_ques($name, $message){
	$cmd = "SELECT * FROM 'user' WHERE 'username' = '".$name."';";
	$user = mysql_query($cmd);
	$info = mysql_fetch_array($user);
	if(empty($info)) die("用户不存在");
	$uid = $info['uid'];
	$cmd = "INSERT INTO 'questions' ('uid', 'msg') VALUE ('".$info['uid']."', '".$msg."');";
	mysql_query($cmd);
}
function set_readed($quesid){
	$cmd = "UPDATE questions SET 'readed' = 1 WHERE 'id' = ".$quesid.";";
	$ques = mysql_query($cmd);
}
function show_ques($tok){
	$cmd = "SELECT * FROM 'user' WHERE 'user_token' = ".$tok.";";
	$user = mysql_query($cmd);
	$userinfo = mysql_fetch_array($user);
	$cmd = "SELECT * FROM questions WHERE 'id' > ".$userinfo['last_id']." and 'uid' = ".$userinfo['uid'].";";
	$ques = mysql_query($cmd);
	while($info = mysql_fetch_array($ques)){
		$cmd = "UPDATE 'user' SET 'last_id' = '".$info['id']."' WHERE 'user_token' = '".$tok."';";
		mysql_query($cmd);
		return $info['msg'];
		break;
	}
}
?>
