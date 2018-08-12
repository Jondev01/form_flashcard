<?php
	session_start();
	$name = htmlspecialchars($_REQUEST['q']);
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
	//query to select all decks of the user
	//$sql = 'INSERT INTO decks(userId, name) VALUES (:userId, :name)';
	$sql = 'INSERT INTO decks(userId, name) SELECT :userId, :name WHERE NOT EXISTS (SELECT 1 FROM decks WHERE userId=:userId AND name=:name)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['userId'=>$_SESSION['user_id'], 'name'=>$name]);
?>