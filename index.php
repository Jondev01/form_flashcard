<?php
	//message variables
	$msg='';
	$msgClass='';
	//Check if submitted
	if(filter_has_var(INPUT_POST, 'submit')){
		$email = htmlspecialchars($_POST['email']);
		$user_password = htmlspecialchars($_POST['password']);
		$validate_password = htmlspecialchars($_POST['validate_password']);
		//Check fields
		if(!empty($email) && !empty($user_password) && !empty($validate_password)){
			//all fields filled in
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				//email not valid
				$msg = 'Please enter a valid email.';
				$msgClass = 'alert-danger';
			}
			else if(strlen($user_password)<7){
				$msg = "Your password must be at least 7 characters long.";
				$msgClass = 'alert-danger';
			}
			else if($user_password!=$validate_password){
				//Passwords don't match
				$msg = "The passwords don't match.";
				$msgClass = 'alert-danger';
			} else{
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
				$sql = 'INSERT INTO users(email,password) VALUES(:email,:password)';
				$stmt = $pdo->prepare($sql);
				//Try to insert data into db table
				if(!$stmt->execute(['email'=>$email, 'password'=>$user_password])){
					//if the email is already registered
					$msg = 'The email '.$email.' is already registered';
					$msgClass = 'alert-danger';
				} else{
					$msg = 'Signup successfull';
					$msgClass = 'alert-success';
				}

			}
		} else { //not all fields filled in
			$msg = 'Please fill in all fields';
			$msgClass = 'alert-danger';
		}
	}
?>



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
	   		<label class="sr-only">Verify Password</label>
	   		<input type="password" name="validate_password" class="form-control" placeholder="Verify Password"><br>
	   		<button type="submit" name="submit" class="btn">Submit</button>
	   	</form>
	</div>


<?php include 'include/footer.php'; ?>
