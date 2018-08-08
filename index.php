<?php
	//message variables
	$msg='';
	$msgClass='';
	//Check if submitted
	if(filter_has_var(INPUT_POST, 'submit')){
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);
		$validate_password = htmlspecialchars($_POST['validate_password']);

		//Check fields
		if(!empty($email) && !empty($password) && !empty($validate_password)){
			//passed
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				$msg = 'Please enter a valid email';
				$msgClass = 'alert-danger';
			} else{

			}
		} else {
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
	   		<input id="inputPassword" type="text" name="password" class="form-control" placeholder="Password"><br>
	   		<label class="sr-only">Verify Password</label>
	   		<input type="text" name="validate_password" class="form-control" placeholder="Verify Password"><br>
	   		<button type="submit" name="submit" class="btn">Submit</button>
	   	</form>
	</div>


<?php include 'include/footer.php'; ?>
