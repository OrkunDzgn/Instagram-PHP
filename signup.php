<?php
	require_once 'connection.php';

	if(!empty($_POST)){
		if($_POST['pass'] == $_POST['passRepeat']){
			$userRegister = $database->prepare('INSERT INTO users SET username = :username, password = :password, email = :email, profilePicture = :profilePicture');
			$success = $userRegister->execute([
				':username' => $_POST['uname'], 
				':password' => password_hash($_POST['pass'], PASSWORD_BCRYPT), 
				':email' => $_POST['email'],
				':profilePicture' => 'egg.png'
				]);
			
			if($success){
				require_once 'login.php';
			}
			else if($userRegister->errorInfo()[1] == 1062){
					echo 'Username already exists';
			}
		}else{
			echo 'Passwords does not match!';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Instagram Sign Up</title>
</head>
<body>
	<div class="signup_form">
		<form method="POST">
			<input type="text" name="uname" placeholder="Username">
			<input type="text" name="email" placeholder="Email">
			<input type="password" name="pass" placeholder="Password">
			<input type="password" name="passRepeat" placeholder="Repeat Password">
			<input type="submit" value="Sign Up">
		</form>
	</div>
</body>
</html>