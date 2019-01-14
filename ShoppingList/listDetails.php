<?php
include 'dataLayer.php';
$listId = $_GET["listID"];
$listName = $_GET["listName"];
$rows = getAllListItems($listId);

$listItems = getAllListItems($listId);

if (isset($_POST['btnAdd'])) {
    $url = $_SERVER['REQUEST_URI'];
    if ($listId == 0) {
        $listId = insertList($listName); 
        $url = "listDetails.php?listID=$listId&listName=$listName";
    }
    insertItem($listId, $_POST["txtAdd"]);
    header("Location: " . $url);
    exit();
}

if (isset($_POST["btnDeleteItem"])) {
    deleteItem($listId, $_POST["itemId"]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST["btnSaveItem"])) {
    updateItem($listId, $_POST["itemId"], $_POST["txtItem"]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST["btnSaveList"])) {
    $listName = $_POST["txtListName"];
    if ($listId == 0) {
        $listId = insertList($listName);
    } 
    else {
        updateListName($listId, $listName);
    }
    $url = "listDetails.php?listID=$listId&listName=$listName";
    header("Location: " . $url);
    exit();
}

if (isset($_POST["btnDeleteList"])) {
    deleteList($listId);
    header("Location: " . "selectList.php");
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
        <script>
			function checkDelete(){
    			return confirm('Are you sure?');
			}
		</script>
    </head>
    <body>
    	<div class="container-fluid">
        	<div>
        		<a href="selectList.php">Back</a>
        	</div>
    		<div class="row" style="padding-right: 20px; padding-top: 20px">
    			<div class="col-xs-10">
    				<form method="post" id="frmList">
    					<input type="text" name="txtListName" value="<?php echo $listName;?>" style="width: 100%" />
    				</form>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="btnSaveList" value="Save" form="frmList">
    					<span class="glyphicon glyphicon-ok"></span>
    				</button>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="btnDeleteList" value="Delete" form="frmList" onclick="return checkDelete()">
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
			<?php foreach ($listItems as $listItem) {  //foreach($rows as $row){ ?>
        		<div class="row" style="padding-right: 20px">
	    			<div class="col-xs-10">
        				<form method="post" id="<?php echo 'frmItem'.$listItem->id;?>">
        					<input type="text" name="txtItem"
        						value="<?php echo $listItem->itemName;?>" style="width: 100%" />
        					<input type="hidden" name="itemId" value="<?php echo $listItem->id;?>">
        				</form>
        			</div>
        			<div class="col-xs-1">
        				<button type="submit" name="btnSaveItem" value="Save" form="<?php echo 'frmItem'.$listItem->id;?>">
        					<span class="glyphicon glyphicon-ok"></span>
        				</button>
        			</div>
        			<div class="col-xs-1">
        				<button type="submit" name="btnDeleteItem" value="Delete" form="<?php echo 'frmItem'.$listItem->id;?>">
        					<span class="glyphicon glyphicon-remove"></span>
        				</button>
        			</div>
	    		</div> <!-- Row -->
    		<?php }?>
           	<div>
        		<a href="selectList.php">Back</a>
        	</div>
    		
		</div> <!-- Container -->
    </body>
</html>