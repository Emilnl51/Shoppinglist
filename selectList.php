<?php
    include 'dataLayer.php';
    $sql = "SELECT * FROM ShoppingList";
//    echo nl2br($sql."\n");
    $statement = getConnection()->query($sql);
    $rows = $statement->fetchAll();

?>
<html>
    <head>
    </head>
    <body>
    	<a href="listDetails.php?ListID=null&ListName=NewList">New list</a> 
    	<br />
    <?php foreach ($rows as $row) {
        echo "<a href='listDetails.php?listID={$row["Id"]}&listName={$row["ListName"]}'>{$row["ListName"]}</a>"."<br />";
  			 }?>
    </body>
</html>