<?php
include 'dataLayer.php';
$listId = $_GET["listID"];
$listName = $_GET["listName"];

$rows = getAllListItems($listId);

function debugToBrowserConsole ( $msg ) {
    $msg = str_replace('"', "''", $msg);  # weak attempt to make sure there's not JS breakage
    echo "<script>console.debug( \"PHP DEBUG: $msg\" );</script>";
}
function errorToBrowserConsole ( $msg ) {
    $msg = str_replace('"', "''", $msg);  # weak attempt to make sure there's not JS breakage
    echo "<script>console.error( \"PHP ERROR: $msg\" );</script>";
}
function warnToBrowserConsole ( $msg ) {
    $msg = str_replace('"', "''", $msg);  # weak attempt to make sure there's not JS breakage
    echo "<script>console.warn( \"PHP WARNING: $msg\" );</script>";
}
function logToBrowserConsole ( $msg ) {
    $msg = str_replace('"', "''", $msg);  # weak attempt to make sure there's not JS breakage
    echo "<script>console.log( \"PHP LOG: $msg\" );</script>";
}

# Convenience functions
function d2c ( $msg ) { debugToBrowserConsole( $msg ); }
function e2c ( $msg ) { errorToBrowserConsole( $msg ); }
function w2c ( $msg ) { warnToBrowserConsole( $msg ); }
function l2c ( $msg ) { logToBrowserConsole( $msg ); }

if (isset($_POST['btnAddItem']) && $_POST['txtAddItem'] != "") {
    $url = $_SERVER['REQUEST_URI'];

    e2c($listName);
    e2c($listId);
    
    if ($listId == 0) {
        $listName = $_POST['txtListName'];
        $listId = insertList($listName);
        $url = "listDetails.php?listID=$listId&listName=$listName";
    }
    
    if($listId != 0 && $listName != $_POST['txtListName']){
        $listName = $_POST['txtListName'];
        updateListName($listId, $listName);
        $url = "listDetails.php?listID=$listId&listName=$listName";
    }
    
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
    					<input type="text" name="txtListName" value="<?php echo $listName;?>" style="width: 100%" />
    				</form>
				</div>
    			<div class="col-xs-1">
    				<button type="button" name="btnSaveList" value="Save" form="frmList">
    					<span class="glyphicon glyphicon-ok"></span>
    				</button>
    			</div>
    			<div class="col-xs-1">
    				<button 
    					type="button" 
    					name="btnDeleteList" 
    					value="Delete" 
    					form="frmList" 
    					onclick="return checkDelete()">
    						<span class="glyphicon glyphicon-remove"></span>
    				</button>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-10" style="padding-bottom:15px">
					<input type="text" name="txtAddItem" style="width: 100%" form="frmList"/>
    			</div>
    			<div class="col-xs-1">
    				<button type="submit" name="btnAddItem" value="Add" form="frmList">
    					<span class="glyphicon glyphicon-plus"></span>
    				</button>
    			</div>
    		</div> <!-- Row -->
			<?php foreach ($rows as $row) { ?>
        		<div class="row">
	    			<div class="col-xs-10">
        				<form method="post" id="<?php echo 'frmItem'.$row['Id'];?>">
        					<input type="text" name="txtItem"
        						value="<?php echo $row['ItemName'];?>" style="width: 100%" />
        					<input type="hidden" name="itemId" value="<?php echo $row['Id'];?>">
        				</form>
        			</div>
        			<div class="col-xs-1">
        				<button type="submit" name="btnSaveItem" value="Save" form="<?php echo 'frmItem'.$row['Id'];?>">
        					<span class="glyphicon glyphicon-ok"></span>
        				</button>
        			</div>
        			<div class="col-xs-1">
        				<button type="submit" name="btnDeleteItem" value="Delete" form="<?php echo 'frmItem'.$row['Id'];?>">
        					<span class="glyphicon glyphicon-remove"></span>
        				</button>
        			</div>
	    		</div> <!-- Row -->
    		<?php }?>
    		<div class="row" padding-top="20px">
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