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
		if(empty($info['username'])) return false;
			else return true;
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
		echo "<script>alert('登陆完成');parent:location.href='index.php';</script>";
	}else die("密码错误");
}
function set_logout(){
	setcookie("user_token", "null", time()-1);
}
function new_ques($name, $message){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE username = '".$name."';";
	$user = $db->query($cmd);
	$info = $user->fetch_assoc();
	if(empty($info)) die("用户不存在");
	$uid = $info['uid'];
	$cmd = "INSERT INTO questions (uid, msg) VALUES (".$info['uid'].", '".$message."');";
	$db->query($cmd);
}
function set_readed($quesid){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "UPDATE questions SET 'readed' = 1 WHERE 'id' = ".$quesid.";";
	$ques = $db->query($cmd);
}
function show_ques($tok){
	require "mysql.php";
	$db = new mysqli($db_address, $db_username, $db_pw, $db_name);
	$cmd = "SELECT * FROM user WHERE user_token = '".$tok."';";
	$user = $db->query($cmd);
	$userinfo = $user->fetch_assoc();
	$cmd = "SELECT * FROM questions WHERE id > ".$userinfo['last_id']." and uid = ".$userinfo['uid'].";";
	$ques = $db->query($cmd);
        $info = $ques->fetch_assoc();
        if(empty($info)) echo "现在莫得问题";
	$cmd = "UPDATE user SET last_id = ".$info['id']." WHERE user_token = '".$tok."';";
	mysqli_query($db, $cmd);
	echo $info['msg'];
}
?>
