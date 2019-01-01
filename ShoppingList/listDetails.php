<?php
include 'dataLayer.php';
$listId = $_GET["listID"];
$listName = $_GET["listName"];

$rows = getAllListItems($listId);

if (isset($_POST['btnAdd'])) {
    insertItem($listId, $_POST["txtAdd"]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST["Delete"])) {
    deleteItem($listId, $_POST["itemId"]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST["Save"])) {
    updateItem($listId, $_POST["itemId"], $_POST["txtItem"]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<html>
    <head>
        <title>Shopping List Details</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
    	<!-- Gör om detta till ett formulär där jag kan spara listans namn i ShoppingList tabellen -->
    	<div class="container-fluid">
    		<h1><?php echo $listName;?></h1>
    		<div class="row" style="padding-right: 20px">
    			<div class="col-xs-10">
    				<form method="post" id="frmAdd">
    					<input type="text" name="txtAdd" style="width: 100%" />
    				</form>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="btnAdd" value="Add" form="frmAdd">
    					<span class="glyphicon glyphicon-plus"></span>
    				</button>
    			</div>
    		</div> <!-- Row -->
			<?php foreach ($rows as $row) { ?>
        		<div class="row" style="padding-right: 20px">
	    			<div class="col-xs-10">
        				<form method="post" id="<?php echo 'frmItem'.$row['Id'];?>">
        					<input type="text" name="txtItem"
        						value="<?php echo $row['ItemName'];?>" style="width: 100%" />
        					<input type="hidden" name="itemId" value="<?php echo $row['Id'];?>">
        				</form>
        			</div>
        			<div class="col-xs-1">
        				<button type="submit" name="Save" value="Save" form="<?php echo 'frmItem'.$row['Id'];?>">
        					<span class="glyphicon glyphicon-ok"></span>
        				</button>
        			</div>
        			<div class="col-xs-1">
        				<button type="submit" name="Delete" value="Delete" form="<?php echo 'frmItem'.$row['Id'];?>">
        					<span class="glyphicon glyphicon-remove"></span>
        				</button>
        			</div>
	    		</div> <!-- Row -->
    		<?php }?>
		</div> <!-- Container -->
    </body>
</html>