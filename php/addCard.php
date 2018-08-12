<?php
	session_start();
	$front = htmlspecialchars($_REQUEST['f']);
	$back = htmlspecialchars($_REQUEST['b']);
	$deckId = htmlspecialchars($_REQUEST['d']);
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
	//insert card
	$sql = 'INSERT INTO cards(userId, deckId, front, back) VALUES (:userId, :deckId, :front, :back)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['userId'=>$_SESSION['user_id'], 'deckId'=>$deckId, 'front'=>$front, 'back'=>$back]);
?>