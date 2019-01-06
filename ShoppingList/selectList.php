<?php
include "dataLayer.php";
$shoppingLists = getAllShoppingLists();

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
    	<div class="container-fluid">
    		<div class="row">
        		<div class="col-xs-1">
            		<form action="listDetails.php" method="get">
        				<button type="submit">
        					<span class="glyphicon glyphicon-plus"></span>
        				</button>
        				<input type="hidden" name="listID" value="0">
        				<input type="hidden" name="listName" value="NewList">
            		</form>
        		</div>
			</div>
            <?php foreach ($shoppingLists as $shoppingList) {
                echo "<div class='row'>".
                "<div class='col-xs-12'>".
                "<a href='listDetails.php?listID={$shoppingList->id}".
                "&listName={$shoppingList->listName}'>{$shoppingList->listName}</a>".
                "</div>".
                "</div>";
            }?>
    	</div>
    </body>
</html>