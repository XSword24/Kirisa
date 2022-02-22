<?php
//create_cat.php
require_once('connect.php');
include 'header.php';
 
//first select the category based on $_GET['cat_id']
$stmt = $pdo->prepare ("SELECT cat_id, cat_name, cat_description FROM categories WHERE cat_id = ?");
$stmt->execute([$_GET['id']]);
 
if(empty($stmt))
{
    echo 'The category could not be displayed, please try again later.';
}
else
{
    if($stmt->rowCount() == 0)
    {
        echo 'This category does not exist.';
    }
    else
    {
        //display category data
        while($row = $stmt->fetch())
        {
            echo '<h2>Topics in ′' . $row['cat_name'] . '′ category</h2>';
        }
     
        //do a query for the topics
        $stmt = $pdo->prepare("SELECT  topic_id, topic_subject, topic_date, topic_cat FROM topics WHERE topic_cat = ?");
        $stmt->execute([$_GET['id']]);
         
        if(empty($stmt))
        {
            echo 'The topics could not be displayed, please try again later.';
        }
        else
        {
            if($stmt->rowCount() == 0)
            {
                echo 'There are no topics in this category yet.';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th>Topic</th>
                        <th>Created at</th>
                      </tr>'; 
                     
                while($row = $stmt->fetch())
                {               
                    echo '<tr>
						  <td class="leftpart">
                          <h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>
                          </td>
                          <td class="rightpart">' . date('d-m-Y', strtotime($row['topic_date'])) .
                         '</td>
						 </tr>';
                }
            }
        }
    }
}
 echo '</table>';
include 'footer.php';
?>