<?php session_start(); ?>
<?php include 'include/header.php' ?>
<div class="container">
	<div class="deck_control">
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
		$sql = 'SELECT name FROM decks WHERE userId = :userId';
		$stmt = $pdo->prepare($sql);
		//for testing
		if(!isset($_SESSION['user_id']))
			$_SESSION['user_id'] = 1;
		$stmt->execute(['userId'=>$_SESSION['user_id']]);
		?>
		<h4>Choose a deck</h4>
		<select id="deckSelect" onChange="clearCard()">
			<?php while($row = $stmt->fetch()){ ?>
				<option value="<?php echo $row->name; ?>">
					<?php echo $row->name; ?>
				</option>	
			<?php }?> 
		</select>


		<form class="form-signin" onsubmit="false">
			<h4>Add a deck</h4>
			<label class="sr-only">Name of deck</label>
		   	<input id="newDeckName" type="text" name="deck" class="form-control" placeholder="Name of deck"><br>
			<button class="btn" onclick="addDeck()">Add Deck</button>
		</form>

		<form class="form-signin" onsubmit="false">
			<h4>Add a card</h4>
			<label class="sr-only">Front</label>
		   	<input id="front" type="text" name="front" class="form-control" placeholder="Front"><br>
		   	<label class="sr-only">Back</label>
		   	<input id="back" type="text" name="back" class="form-control" placeholder="Back">
		   	<button class="btn" onclick="addCard()">Add</button>
		</form>
	</div>

	<div id="card_container" class="card" onclick="flipCard()">
		<div id="current_card">
		</div>
	</div>
	<button id="newCardButton" onclick="nextCard()">Next Card</button>
	<button id="deleteCard" onclick="deleteCard()">Delete Card</button>
</div>
<script src="main.js"></script>
<?php include 'include/footer.php' ?>