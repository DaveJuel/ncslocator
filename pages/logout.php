<?php  session_start();

if (isset($_COOKIE["user_id"]) && isset($_COOKIE["username"]) && isset($_COOKIE["type"])) {
	setcookie("user_id", '', strtotime('-5 days'), '/');
	setcookie("username", '', strtotime('-5 days'), '/');
	setcookie("type", '', strtotime('-5 days'), '/');
	// Destroy the session variables
	$_SESSION['user_id']=null;
	$_SESSION['username']=null;
	$_SESSION['type']=null;
	session_destroy();	
}
// Double check to see if their sessions exists
if (isset($_SESSION['username'])) {
	header("location: home.php?msg=Error:_Logout_Failed");
} else {
	header("location:login.php");
	exit();
}
?>
