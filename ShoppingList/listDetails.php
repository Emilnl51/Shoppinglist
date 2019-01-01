<?php
include 'dataLayer.php';
$listId = $_GET["listID"];
$listName = $_GET["listName"];

$rows = getAllListItems($listId);

if (isset($_POST['btnAdd'])) {
    $url = $_SERVER['REQUEST_URI'];
    if ($listId == 0) {
        $listId = insertList($listName); 
        $url = "listDetails.php?listID=$listId&listName=$listName";
    }
    insertItem($listId, $_POST["txtItem"]);
    header("Location: " . $url);
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
    	<div class="container-fluid">
    		<div class="row" style="padding-right: 20px; padding-top: 20px">
    			<div class="col-xs-10">
    				<form method="post" id="frmList">
    					<input type="text" name="txtListName" value="<?php echo $listName;?>" style="width: 100%" />
    				</form>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="Save" value="Save" form="frmList">
    					<span class="glyphicon glyphicon-ok"></span>
    				</button>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="Delete" value="Delete" form="frmList">
    					<span class="glyphicon glyphicon-remove"></span>
    				</button>
    			</div>
    		</div>
    		<div class="row" style="padding-right: 20px">
    			<div class="col-xs-10">
    				<form method="post" id="frmAddItem">
    					<input type="text" name="txtAdd" style="width: 100%" />
    				</form>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="btnAdd" value="Add" form="frmAddItem">
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