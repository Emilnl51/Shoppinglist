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
        <link rel="stylesheet" type="text/css" href="mystyle.css">
    </head>
    <body>
    	<div>
        	<div class="container-fluid">
        		<div class="row">
            		<div class="col-xs-1">
                		<form action="listDetails.php" method="get">
            				<button type="submit">
            					<span class="glyphicon glyphicon-plus"></span>
            				</button>
            				<input type="hidden" name="listId" value=0>
                		</form>
            		</div>
    			</div>
                <?php foreach ($shoppingLists as $shoppingList) {
                    $url = "listDetails.php?listId=".$shoppingList->externalId;                ;
                    echo "<div class='row'>
                        <div class='col-xs-12'>
                            <a href='{$url}'>{$shoppingList->listName}</a>
                        </div>
                    </div>";
                }?>
        	</div>
    	</div>
    </body>
</html>