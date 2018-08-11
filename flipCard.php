<?php
	session_start();
	$text = htmlspecialchars($_REQUEST['t']);
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
	$sql = 'SELECT front, back FROM cards WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['id'=>$_SESSION['card_id']]);
	$card = $stmt->fetch();
	if($card->front == $text){
		echo json_encode(array("back", $card->back));
	}
	else if($card->back == $text){
		echo json_encode(array("front",$card->front));
	}
	//echo json_encode($cards);
?>