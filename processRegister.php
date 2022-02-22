<?php
require_once('connect.php');
	
	$success ="";
	$error = "";
	$user_name = htmlspecialchars($_POST["user_name"]);
	$user_email = htmlspecialchars($_POST["user_email"]);
	$user_pass = htmlspecialchars($_POST["user_pass"]);
	
	if(empty($user_name) or empty($user_email) or empty($user_pass) or !filter_var($user_email,
		FILTER_VALIDATE_EMAIL)){
		$error = "One or more input values are invalid!";
		header("Location: register.php?error=$error") or die("Error when redirecting to the register page.");
	} else{
		//query
		$stmt = $pdo->prepare("SELECT user_name FROM users WHERE user_name = ?");
		$stmt->execute([$user_name]);
		$data = $stmt ->fetch();
		
		if(!empty($data["user_name"])){
			$error="Username already exists!";
			header("Location: register.php?error=$error") or die("Error when redirecting to the register page.");
		}
		
		$stmt = $pdo->prepare("SELECT user_email FROM users WHERE user_email = ?");
		$stmt->execute([$user_email]);
		$data = $stmt ->fetch();
		
		if(!empty($data["user_email"])){
			$error="Email already in use!";
			header("Location: register.php?error=$error") or die("Error when redirecting to the register page.");
		}
		//date
		date_default_timezone_set('UTC');
		$user_date = date("Y-m-d H:i:s");
		//Insert
		$user_pass = password_hash($user_pass, PASSWORD_DEFAULT);
		$stmt = $pdo->prepare("INSERT INTO users (user_name, user_email, user_pass, user_date) VALUES (?,?,?,?)");
		$check = $stmt->execute([$user_name, $user_email, $user_pass, $user_date]);
	}
	
	if($check){
		$success = "Registration sucessful!";
		header("Location: register.php?success=$success") or die("Error when redirecting to the register page.");
	} else{
		$error = "Error when adding the data to the database.";
		header("Location: register.php?error=$error") or die("Error when redirecting to the register page.");
	}
?>
