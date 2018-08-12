<?php
	session_start();
	$cardId;
	if(isset($_REQUEST['c']))
		$cardId = htmlspecialchars($_REQUEST['c']);
	else
		$cardId = $_SESSION['card_id'];
	//access flashcard db
	$host = 'localhost';
	$user = 'root';
	$password = 'ThisIsThePassword';
	$dbname = 'flashcard';
	//Set DSN
	$dsn = 'mysql:host='. $host .';dbname='. $dbname;
	//create PDO instance and set default fetch to object
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	//fetch front text and card id
	$sql = 'DELETE FROM cards WHERE id=:id AND userId=:userId';
	$stmt = $pdo->prepare($sql);
	if($stmt->execute(['id'=>$cardId, 'userId'=>$_SESSION['user_id']])) {
		unset($_SESSION['card_id']);
		echo true;
	}
	else
		echo false;
?>