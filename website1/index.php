<?php include 'include/header.php'; ?>
   	<h1>Home</h1>
   	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   		<input type="text" name="email"><br>
   		<input type="text" name="password"><br>
   		<input type="text" name="validate_password">
   		<input type="submit" name="submit">
   	</form>


<?php include 'include/footer.php'; ?>