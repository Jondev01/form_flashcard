<?php
	session_start();
	//access flashcard db
	$host = 'localhost';
	$user = 'root';
	$password = 'ThisIsThePassword';
	$dbname = 'flashcard';
	$deckId = htmlspecialchars($_REQUEST['d']);
	//Set DSN
	$dsn = 'mysql:host='. $host .';dbname='. $dbname;
	//create PDO instance and set default fetch to object
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	//delete deck
	$sql = 'DELETE FROM decks WHERE userId=:userId AND id=:id';
	$stmt = $pdo->prepare($sql);
	if($stmt->execute(['userId'=>$_SESSION['user_id'], 'id'=>$deckId])) {
		unset($_SESSION['card_id']);
		echo true;
	}
	else
		echo false;
?>