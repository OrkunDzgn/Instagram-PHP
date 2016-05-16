<?php
	session_start();
	require_once 'connection.php';
	require_once 'functions.php';
	
	if(empty($_SESSION['user'])){
		login();
	}
	else { //if session is available on browser, go to feed
		header('Location: ' . getRootDir() . '/feed.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Instagram Login</title>
	<meta charset="UTF-8">
</head>
<body>
	<form method="POST">
		<input type="text" name="uname" placeholder="Username">
		<input type="password" name="pass" placeholder="Password">
		<input type="submit" value="Login">
	</form>
</body>
</html>