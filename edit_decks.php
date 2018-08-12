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
				<li><a href="logged_in.php">Practice</a></li>
				<li><a id="current" href="edit_decks.php">Edit Decks</a></li>
				<li><a href="login.php">Log out</a></li>
			</span>
		</ul>
	</div>
</header>
<!-- Put content into a container -->
<div class="container">
	<!-- Edit the deck -->
	<div>
		<?php //access db
		$sql = 'SELECT id,name FROM decks WHERE userId = :userId';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['userId'=>$_SESSION['user_id']]);
		?>
		<select id="deckSelect" class = "btn" onChange="updateCardList()">
			<option value="0" selected disabled>Choose a deck</option>
			<?php while($row = $stmt->fetch()){ ?>
				<option value="<?php echo $row->id; ?>">
					<?php echo $row->name; ?>
				</option>	
			<?php }?> 
		</select>
		<button id="deleteDeck" class="btn" onclick="deleteDeck()">Delete Deck</button>
	</div>
	<div class="listOfCards">
			<h3 class="yellow">List of Cards</h3>
			<select multiple id="cardSelect">
			</select>
			<button id="deleteCard" class="btn" onclick="deleteCards()">Delete Card</button>
	</div>
	<div class="top-margin">
		<!-- Add deck -->
		<form class="form-signin inline-block">
			<h3 class="yellow">New Deck</h3>
			<label class="sr-only">Name of deck</label>
		   	<input id="newDeckName" type="text" name="deck" class="form-control" placeholder="Name of deck"><br>
			<button class="btn" onclick="addDeck(1)">Add Deck</button>
		</form> <br>
		<!-- add card -->
		<form id="addCard" class="form-signin inline-block" onsubmit="return addCard(1)">
			<h3 class="yellow">New Card</h3>
			<label class="sr-only">Front</label>
		   	<input id="front" type="text" name="front" class="form-control" placeholder="Front"><br>
		   	<label class="sr-only">Back</label>
		   	<input id="back" type="text" name="back" class="form-control" placeholder="Back">
		   	<input type="submit" class="btn" value="Add Card"/>
		</form>
	</div>
</div>
<script src="main.js"></script>
<?php include 'include/footer.php' ?>