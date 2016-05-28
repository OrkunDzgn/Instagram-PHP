<?php
	require_once 'connection.php';

	function getRootDir(){
		$protocol = $_SERVER['HTTPS'] == '' ? 'http://' : 'https://';
		$folder = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
		return $folder;
	}


	function uploadImage(){
		global $new_doc_name;
		$extensions = array('image/jpeg' => '.jpeg',
						'image/jpg' => '.jpg',
                        'image/png' => '.png',
                        'image/gif' => '.gif'
                       );
		$doc_type = mime_content_type($_FILES['photo']['tmp_name']); 

		if($doc_type == 'image/jpeg' || $doc_type == 'image/png' || $doc_type == 'image/gif' || $doc_type == 'image/jpg'){
			$new_doc_name = uniqid() . $extensions[$doc_type];
			move_uploaded_file($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $new_doc_name);
			return true;
		}
		else {
			return false;
		}
	}


	function postEntry(){
		global $_SESSION;
		global $new_doc_name;
		global $database;
		$sqlPostEntry = $database->prepare('INSERT INTO posts SET user_id = :user_id, image = :image, description = :description');
		$success = $sqlPostEntry->execute(array(
				':user_id'=>$_SESSION['user']['id'],
				':image' => $new_doc_name,
				'description' => $_POST['description']
			));

		var_dump($new_doc_name);
		var_dump($_SESSION);
	}



	function login(){
		global $database;
		if(!empty($_POST)){
			$userLogin = $database->prepare('SELECT * FROM users WHERE username = :username');
			$userLogin->execute([
				':username' => $_POST['uname']
				]);

			if($userLogin->rowCount() == 1){
				$userCredentials = $userLogin->fetch(PDO::FETCH_ASSOC);
				$passCheck = password_verify($_POST['pass'], $userCredentials['password']);
				if($passCheck){
					$_SESSION['user'] = $userCredentials;
					header('Location: ' . getRootDir() . '/feed.php');
				}
				else {
					echo 'Please check your email or password!';
				}
			}
			else {
				echo 'Please check your email or password!';
			}
		}
	}



	function CheckFollowing($userID){
		global $_SESSION;
		global $database;
		if($userID != $_SESSION['user']['id']){
			$getFollow = $database->prepare('SELECT * FROM `follows` WHERE follower = :userid AND followed = :postuserid');
			$getFollow->execute([
							':userid' => $_SESSION['user']['id'],
							'postuserid' => $userID
							]); 
			if($getFollow->rowCount() > 0) {
				echo 'Takibi Bırak';
				return 0; //Unsubscribe button
			}else{
				echo 'Takip Et';
				return 1; //Subscribe button
			}
		}
		return 2; //User enters his own profile - No subscribe button
	}
?>