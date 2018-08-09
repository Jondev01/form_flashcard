<?php
	//message variables
	$msg='';
	$msgClass='';
	//Check if submitted
	if(filter_has_var(INPUT_POST, 'submit')){
		$email = htmlspecialchars($_POST['email']);
		$user_password = htmlspecialchars($_POST['password']);
		//Check fields
		if(!empty($email) && !empty($user_password)){
			//all fields filled in
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
			 //Query
			/*$stmt = $pdo->query('SELECT * from users');
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				echo $row['username'].'<br>';
			}*/
			//Use prepared statements to insert
			$sql = 'SELECT password FROM users WHERE email=:email';
			$stmt = $pdo->prepare($sql);
			//Check if record exists and password is correct
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($stmt->rowCount()>0 && $row->password == $user_password){
				//account exists and password correct
				$msg = 'Log in successfull';
				$msgClass = 'alert-success'; 
			} else{
				$msg = 'Email or password incorrect';
				$msgClass = 'alert-danger'; 
			}
		} else { //not all fields filled in
			$msg = 'Please fill in all fields';
			$msgClass = 'alert-danger';
		}
	}
?>
<!--Here html starts -->
<?php include 'include/header.php'; ?>

	<div class="container">
		<?php if($msg != ''): ?>
			<div class="<?php echo $msgClass; ?>"><?php echo $msg;?> </div>
		<?php endif; ?> 
	   	<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	   		<label class="sr-only">Email</label>
	   		<input id="inputEmail" type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : '';?>" placeholder="Email address"><br>
	   		<label class="sr-only">Password</label>
	   		<input id="inputPassword" type="password" name="password" class="form-control" placeholder="Password"><br>
	   		<button type="submit" name="submit" class="btn">Submit</button>
	   	</form>
	</div>


<?php include 'include/footer.php'; ?>
