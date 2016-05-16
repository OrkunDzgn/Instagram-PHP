<?php
	session_start();
	require_once 'functions.php';

	if(!empty($_FILES) && $_FILES['photo']['error'] == 0) {
		$success = uploadImage();

		if(!$success) {
			echo 'An error has occured while uploading image...';
		}
		else {
			$success = postEntry();
			if($success){ //POST SUCCESSFUL
				header('Location: ' . getRootDir() . '/feed.php');
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>New Post</title>
</head>
<body>
	<div class="newpost_form">
		<form method="POST" enctype="multipart/form-data" id="newPostForm">
			<input type="file" name="photo">
			<input type="text" name="description" placeholder="Description">
			<input type="submit" value="Post">
		</form>
	</div>
</body>
</html>