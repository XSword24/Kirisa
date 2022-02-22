<?php
require_once ('connect.php');
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'This file cannot be called directly.';
}
else
{
    //check for sign in status
    if(!isset($_SESSION['logged_in']))
    {
        echo 'You must be signed in to post a reply.';
    }
    else
    {
        //a real user posted a real reply
        $stmt = $pdo->prepare ("INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES (?,?,?,?)");
		$stmt->execute([$_POST['post_content'], date("Y-m-d H:i:s"), $_GET['id'], $_SESSION['user_id']]);
                         
        if(empty($stmt))
        {
            echo 'Your reply has not been saved, please try again later.';
        }
        else
        {
            echo 'Your reply has been saved, check out <a href="topic.php?id=' . $_GET['id'] . '">the topic</a>.';
        }
    }
}
include 'footer.php';
?>