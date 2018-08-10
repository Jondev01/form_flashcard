<?php
	session_start();
	$deck = htmlspecialchars($_REQUEST['d']);
	$front = htmlspecialchars($_REQUEST['t']);
	//access flashcard db
	$host = 'localhost';
	$user = 'root';
	$password = 'ThisIsThePassword';
	$dbname = 'flashcard';
	//Set DSN
	$dsn = 'mysql:host='. $host .';dbname='. $dbname;
	//create PDO instance and set default fetch to object
	$pdo = new PDO($dsn, $user, $password);
	//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	//insert card
	$sql = 'SELECT front FROM cards WHERE deckId=(SELECT id FROM decks WHERE userId=:userId AND name=:deck) AND userId=:userid AND front<>:front';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['userId'=>$_SESSION['user_id'], 'deck'=>$deck, 'userid'=>$_SESSION['user_id'], 'front'=>$front]);
	$cards = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
	echo json_encode($cards);
?>