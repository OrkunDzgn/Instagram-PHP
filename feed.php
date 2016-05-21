<?php
	//require_once 'connetion.php';
	require_once 'functions.php';
	session_start();

	$getPosts = $database->prepare('SELECT * FROM posts WHERE id IN (SELECT followed FROM follows WHERE follower = :userid)');
	$success = $getPosts->execute([
				':userid' => $_SESSION['user']['id']
				]);

	if($success){
		$posts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
		//var_dump($posts);			
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
		<ul>
			<li>Instagram</li>
			<li>Urunler</li>
			<li>İletişim</li>
		</ul>
	</header>
	<section>
		<div class="middle">
		<?php
			foreach ($posts as $value) {
		?>
			<div class="post">
				<div class="post_header">
					<div class="post_user"> <?php echo $value['id']; ?> </div>
					<div class="post_date"> <?php echo $value['date']; ?> </div>
				</div>
				<img src="/uploads/<?php echo $value['image'] ?> ">

				<div class="likes">
							
				</div>

				<div class="description"> <?php echo $value['description']; ?> </div>
				<?php
			}
		?>
			</div>
	</section>
	<footer>
		
	</footer>

</body>
</html>