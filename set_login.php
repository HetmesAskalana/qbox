<!DOCTYPE HTML>
<?php
require "includes/functions.php";
set_login($_POST['username'], md5($_POST['pw']));
?>
