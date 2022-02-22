<?php
include 'header.php';
		if (!empty($_REQUEST['success'])){
			echo "<p class='success'>" . $_REQUEST['success'] . "</p>";
		}
		if (!empty($_REQUEST['error'])){
			echo "<p class='error'>" . $_REQUEST['error'] . "</p>";
		}	

echo '<h1>Log in</h1>
		<form action="processLogin.php" method="POST">
			<input type="text" name="user_name" placeholder="Username"> <br>
			<input type="password" name="user_pass" placeholder="Password"> <br><br>
			<input type ="submit" value="Log in">
		</form>
		<br><a href = "register.php">Register</a>';
include 'footer.php';
?>