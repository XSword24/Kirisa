<?php
//create_cat.php
require_once('connect.php');
include 'header.php';
echo '<h2>Create a topic</h2>';
if($_SESSION['logged_in'] == false)
{
    //the user is not signed in
    echo 'Sorry, you have to be <a href="/forum/login.php">logged in</a> to create a topic.';
}
else
{
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {   
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $stmt = $pdo->query("SELECT cat_id, cat_name, cat_description FROM categories");   
        if(is_null($stmt))
        {
            //query failed :c
            echo 'Error while selecting from database. Please try again later.';
        }
        else
        {
            if($stmt->rowCount() == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_level'] == 1)
                {
                    echo 'You have not created categories yet.';
                }
                else
                {
                    echo 'Before you can post a topic, you must wait for the webmaster to create some categories.';
                }
            }
            else
            {
         
                echo '<form method="post" action="">
                    Subject: <input type="text" name="topic_subject" />
                    Category:'; 
                 
                echo '<select name="topic_cat">';
                    while($row = $stmt->fetch())
                    {
                        echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                    }
                echo '</select>'; 
                     
                echo 'Message: <textarea name="post_content" /></textarea>
                    <input type="submit" value="Create topic" />
                 </form>';
            }
        }
    }
    else
    {
        //start the transaction
		$pdo->beginTransaction();  
		//the form has been posted, so save it
		//insert the topic into the topics table first, then we'll save the post into the posts table
		$stmt =$pdo->prepare ("INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by) VALUES(?,?,?,?)");
		$stmt->execute([$_POST['topic_subject'], date("Y-m-d H:i:s"), $_POST['topic_cat'], $_SESSION['user_id']]);
		if(is_null($stmt))
		{
			//something went wrong, display the error
			echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
			$pdo->rollback();
		}
		else
		{
			//the first query worked, now start the post query
			//retrieve the id of the freshly created topic for usage in the posts query
			$topicid = $pdo->lastInsertId();
			 
			$stmt =$pdo->prepare ("INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES(?,?,?,?)");
			$stmt ->execute([$_POST['post_content'], date("Y-m-d H:i:s"), $topicid, $_SESSION['user_id']]);
			if(is_null($stmt))
			{
				//something went wrong, display the error
				echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
				$pdo->rollback();
			}
			else
			{
				$pdo->commit();
				 
				//after a lot of work, the query succeeded!
				echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
			}
		}
        
    }
}
include 'footer.php';
?>