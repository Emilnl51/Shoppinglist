<?php
include 'dataLayer.php';
include 'log2Console.php';
$externalId = $_GET["listId"];
$listItems = getAllListItems($externalId);
$list = getListFromExternalId($externalId);
$listId = $list->id;
$listName = $list->listName;

if (isset($_POST['btnAddItem']) && $_POST['txtAddItem'] != "" && $listId != 0) {

    $url = $_SERVER['REQUEST_URI'];    
    insertItem($listId, $_POST["txtAddItem"]);
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

if (isset($_POST["btnSaveList"]) && $_POST["txtListName"] != "") {
    $listName = $_POST["txtListName"];
    if ($listId == 0) {
        $listId = insertList($listName);
    } 
    else {
        updateListName($listId, $listName);
    }
    $externalId = getExternalIdFromListId($listId);
    $url = "listDetails.php?listId=$externalId";
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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <script>
			function checkDelete(){
    			return confirm('Are you sure?');
			}
		</script>
    </head>
    <body>
    	<div class="container-fluid">
    		<div class="row" style="padding-top:15px">
        		<div class="col-xs-1">
            		<form action="selectList.php" method="get">
        				<button type="submit">
        					<span class="glyphicon glyphicon-arrow-left"></span>
        				</button>
            		</form>
        		</div>
			</div>
    		<div class="row">
    			<div class="col-xs-10">
					<form method="post" id="frmList">
    					<input 
    						type="text" 
    						name="txtListName" 
    						value="<?php echo $listId == 0 ? 'NewList' : $listName;?>" 
    						style="width: 100%"
    						<?php if($listId == 0) { ?> autofocus <?php } ?>
    						<?php if($listId == 0) { ?> onfocus="this.select()" <?php } ?> />
    				</form>
				</div>
    			<div class="col-xs-1">
    				<button type="submit" name="btnSaveList" value="Save" form="frmList">
    					<span class="glyphicon glyphicon-ok"></span>
    				</button>
    			</div>
    			<div class="col-xs-1">
    				<button 
    					type="submit" 
    					name="btnDeleteList" 
    					value="Delete" 
    					form="frmList" 
    					onclick="return checkDelete()">
    						<span class="glyphicon glyphicon-remove"></span>
    				</button>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-10">
					<form method="post" id="frmAddItem">
						<input 
							type="text" 
							name="txtAddItem" 
							style="width: 100%"
							<?php if($listId != 0) { ?> autofocus <?php } ?>/>
    				</form>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="btnAddItem" value="Add" form="frmAddItem">
    					<span class="glyphicon glyphicon-plus"></span>
    				</button>
    			</div>
    		</div> <!-- Row -->
			<?php foreach ($listItems as $listItem) {  //foreach($rows as $row){ ?>
        		<div class="row">
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
    		<div class="row">
        		<div class="col-xs-1">
            		<form action="selectList.php" method="get">
        				<button type="submit">
        					<span class="glyphicon glyphicon-arrow-left"></span>
        				</button>
            		</form>
        		</div>
			</div>
		</div> <!-- Container -->
    </body>
</html>