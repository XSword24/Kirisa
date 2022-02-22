<?php
//create_cat.php
require_once('connect.php');
include 'header.php';
$stmt = $pdo->query("SELECT cat_id, cat_name, cat_description FROM categories");
 
if(is_null($stmt)){
    echo 'The categories could not be displayed, please try again later.';
}
else{
    if($stmt->rowCount() == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table border="1">
              <tr>
                <th>Category</th>
                <th>Last topic</th>
              </tr>'; 
             
        while($row = $stmt->fetch())
        {               
            echo '<tr>
					<td class="leftpart">
						<h3><a href="category.php?id='. $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'] . '
					</td>
					<td class="rightpart">
						<a href="topic.php?id=">Topic subject</a> at 06-12-2000
					</td>
				</tr>';
        }
		echo '</table>';
    }
}
include 'footer.php';
?>