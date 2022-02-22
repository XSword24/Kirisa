<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Kirisa</title>
<link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Kirisa</h1>
	<div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">Home</a> -
        <a class="item" href="create_topic.php">Create a topic</a>
    </div>     
    <div id="userbar">
        <?php
		session_start();		
				if(isset($_SESSION['logged_in']))
				{
					echo 'Hello ' . $_SESSION['user_name'] . '. Not you? <a href="signout.php">Sign out</a>';
				}
				else
				{
					echo '<a href="login.php">Log in</a> or <a href="register.php">create an account</a>.';
				}
		?>
    </div>
    <div id="content">