<?php
include 'header.php';
		if (!empty($_REQUEST['success'])){
			echo "<p class='success'>" . $_REQUEST['success'] . "</p>";
		}
		if (!empty($_REQUEST['error'])){
			echo "<p class='error'>" . $_REQUEST['error'] . "</p>";
		}	

	echo '<h1>Register</h1>
		<form action="processRegister.php" method="POST">
			<input type="text" name="user_name" placeholder="Username"> <br>
			<input type="text" name="user_email" placeholder="E-mail"> <br>
			<input type="password" name="user_pass" placeholder="Password"> <br><br>
			<input type ="submit" value="Register">
		</form>
				<br><a href = "login.php">Log in</a>';
include 'footer.php';
?>
