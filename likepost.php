<?php
	require_once 'connection.php';
	require_once 'functions.php';
	session_start();

	if(!empty($_POST)){
		echo json_encode(likeDislikePost()); 
	}
?>