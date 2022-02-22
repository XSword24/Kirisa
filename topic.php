<?php
//create_cat.php
require_once('connect.php');
include 'header.php';
//first select the topic based on $_GET['id']
$stmt = $pdo->prepare ("SELECT topic_id, topic_subject FROM topics WHERE topics.topic_id = ?");
$stmt->execute([$_GET['id']]);

if(empty($stmt))
{
    echo 'The topic could not be displayed, please try again later.';
}
else
{
    if($stmt->rowCount() == 0)
    {
        echo 'This topic does not exist.';
    }
    else
    {
		$row=$stmt->fetch();
        //display topic subject
		echo '<table border = 1>
			<tr> <th colspan="2">'
			 .$row['topic_subject']  .'</th></tr>';

        //do a query for the posts
        $stmt = $pdo->prepare("SELECT posts.post_topic, posts.post_content, posts.post_date, posts.post_by, users.user_id, users.user_name
								FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.post_topic = ?");
        $stmt->execute([$_GET['id']]);
         
        if(empty($stmt))
        {
            echo 'The posts could not be displayed, please try again later.';
        }
        else
        {
            if($stmt->rowCount() == 0)
            {
                echo 'There are no posts in this topic yet.';
            }
            else
            {                     
                while($row = $stmt->fetch())
                {               
                    echo '<tr>
						  <td class="leftpart">'
                          . $row['user_name'] .'</br>'. date('d-m-Y H:m', strtotime($row['post_date'])) . '
                          </td>
                          <td class="rightpart">'
						  . $row['post_content'] .
                         '</td>
						 </tr>';
                }
            }
        }
    }
}
 echo '</table>';
 echo '<h2>Reply:</h2>
		<form action="processPost.php?id=' .$_GET['id'].'" method="POST">
		Message: <textarea name="post_content" /></textarea>
                    <input type="submit" value="Post" />
		</form>

 ';
include 'footer.php';
?>