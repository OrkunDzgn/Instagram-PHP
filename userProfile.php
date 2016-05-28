<?php
	require_once 'functions.php';
	session_start();


	if (!empty($_GET)) {
		$userID = $_GET['user_id'];
	}
	else {
		echo '404 Not Found!';
	}

	$canFollow = CheckFollowing($userID);

	echo $canFollow;

	$getUser = $database->prepare('SELECT * FROM `users` WHERE id = :userid');
		$success = $getUser->execute([
					':userid' => $userID
					]);

		if($success){
			$userInfo = $getUser->fetch(PDO::FETCH_ASSOC);
			//var_dump($userInfo);
		}
		else {
			echo 'NO POST!';
		}
	
	$getPosts = $database->prepare('SELECT * FROM `posts` WHERE user_id = :userid');
		$success = $getPosts->execute([
					':userid' => $userID
					]);

		if($success){
			$userPosts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
			//var_dump($userPosts);
		}
		else {
			echo 'NO POST!';
		}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Instagram</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<header>
		<div class="myHeader">
			<ul>
				<img src="images/logo.png">
			</ul>
		</div>
	</header>
	<section>
		<div class="userMiddle">
			<div class="userHeader">
				<img src="/uploads/<?php echo $userInfo['profilePicture'] ?> ">
				<a> <?php echo $userInfo['username'] ?> </a>
				<a> <?php echo $userInfo['date'] ?> </a>
				<?php if($canFollow == 1) echo '<a>Takip Et.</a>'; elseif($canFollow == 0) echo '<a>Takibi Bırak.</a>';?>
			</div>

			<div class="userPosts">
			<?php foreach ($userPosts as $post) { 
		?>
				<div class="eachUserPost">
				<img src="/uploads/<?php echo $post['image'] ?> ">
				</div>
			<?php
			}
		?>
				</div>
			</div>
		</div>
	</section>
</body>
</html>