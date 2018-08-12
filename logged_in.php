<?php session_start(); 
	if(!isset($_SESSION['user_id']))
		header('Location: login.php')
	?>
<?php include 'include/header.php' ?>
<header>
	<?php //access flashcard db
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
		$sql = 'SELECT email FROM users WHERE id = :userId';
		$stmt = $pdo->prepare($sql);
		//for testing
		$stmt->execute(['userId'=>$_SESSION['user_id']]);
		$row = $stmt->fetch();
		$user_email = $row->email;
		?>

	<div class="container">
		<ul>
			<li>Welcome <span id="user_name"><?php echo $user_email ?></li>
			<span class="uppercase">
				<br class="defaultHidden">
				<li><a id="current" href="#">Practice</a></li>
				<li><a href="edit_decks.php">Edit Decks</a></li>
				<li><a href="index.php">Log out</a></li>
			</span>
		</ul>
	</div>
</header>
<!-- Put content into a container -->
<div class="container">
	<!-- Edit the deck -->
	<div class="deck_control">
		<?php //access db
		$sql = 'SELECT name FROM decks WHERE userId = :userId';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['userId'=>$_SESSION['user_id']]);
		?>
		<select id="deckSelect" class = "btn" onChange="nextCard()">
			<option value="0" selected disabled>Choose a deck</option>
			<?php while($row = $stmt->fetch()){ ?>
				<option value="<?php echo $row->name; ?>">
					<?php echo $row->name; ?>
				</option>	
			<?php }?> 
		</select>

		<button id="nextCardButton" class="btn" onclick="nextCard()">Next Card</button>
	</div>
	<!-- Display the card -->
	<div id="card_container" class="card" onclick="flipCard()">
		<div id="current_card">
		</div>
	</div>
</div>
<script src="main.js"></script>
<?php include 'include/footer.php' ?>