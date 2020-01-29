<!DOCTYPE HTML>
<?php
require "includes/functions.php";
setlogin($_POST['username'], md5($_POST['pw']));
?>
