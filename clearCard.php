<?php
	session_start();
	if(isset($_SESSION['card_id']))
		unset($_SESSION['card_id']);
?>