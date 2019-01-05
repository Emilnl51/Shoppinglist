<?php
include "dataLayer.php";
$shoppingLists = getAllShoppingLists();

?>
<html>
    <head>
    </head>
    <body>
    	<a href="listDetails.php?listID=0&listName=NewList">New list</a> 
    	<br />
        <?php foreach ($shoppingLists as $shoppingList) {
            echo "<a href='listDetails.php?listID={$shoppingList->id}".
            "&listName={$shoppingList->listName}'>{$shoppingList->listName}</a>".
            "<br />";
        }?>
    </body>
</html>