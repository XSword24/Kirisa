<?php
require_once ('connect.php');

	$user_name = htmlspecialchars($_POST["user_name"]);
	$user_pass = htmlspecialchars($_POST["user_pass"]);

	if(empty($user_name) or empty($user_pass)){
		$error = "Empty username or password!";
		header("Location: login.php?error=$error") or die("Error when redirecting to the register page.");
	}
	
	$stmt = $pdo->prepare("SELECT user_name, user_pass FROM users WHERE user_name = ?");
	$stmt->execute([$user_name]);
	$data = $stmt ->fetch();
	
	if (is_null($data["user_name"])){
		$error = "Wrong username or password!";
		header("Location: login.php?error=$error") or die("Error when redirecting to the register page.");
	}
	//Check password
	$stmt = $pdo->prepare("SELECT user_pass FROM users WHERE user_name = ?");
	$stmt->execute([$user_name]);
	$data = $stmt ->fetch();
	//Get id
	$stmt = $pdo->prepare("SELECT user_id FROM users WHERE user_name = ?");
	$stmt->execute([$user_name]);
	$data1 = $stmt ->fetch();
	$user_id = $data1["user_id"];
	if (password_verify($user_pass, $data["user_pass"])){
		session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['user_name']  = $user_name;
        $_SESSION['user_level'] = $user_level;
		$_SESSION['user_id'] = $user_id;

		$success ="Hi $user_name!";
		header("Location: login.php?success=$success") or die("Error when redirecting to the register page.");
	} else{
		$error = "Wrong username or password!";
		header("Location: login.php?error=$error") or die("Error when redirecting to the register page.");
	}
	
?>
