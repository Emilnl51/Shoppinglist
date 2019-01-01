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
        updateItem($listId, $_POST["itemId"] ,$_POST["txtItem"]);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
?>

<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
<!-- Gör om detta till ett formulär där jag kan spara listans namn i ShoppingList tabellen -->
		<h1><?php echo $listName;?></h1>
		<table>
			<tbody>
				<tr>
					<td>
    					<form method="post" id="frmAdd">
    						<input type="text" name="txtAdd" />
    					</form>
    				</td>
    				<td>
						<button type="submit" name="btnAdd" value="Add" form="frmAdd"><span class="glyphicon glyphicon-plus"></span></button>
    				</td>	
				</tr>
				<?php foreach ($rows as $row) { ?>
            		<tr>
            			<td>
            				<form method="post" id="<?php echo 'frmItem'.$row['Id'];?>">
            					<input type="text" name="txtItem" value="<?php echo $row['ItemName'];?>"/>
            					<input type="hidden" name="itemId" value="<?php echo $row['Id'];?>">
            				</form>
            			</td>
                		<td>
                        	<button type="submit" name="Save" value="Save" form="<?php echo 'frmItem'.$row['Id'];?>"><span class="glyphicon glyphicon-ok"></span></button>
                            <button type="submit" name="Delete" value="Delete" form="<?php echo 'frmItem'.$row['Id'];?>"><span class="glyphicon glyphicon-remove"></span></button>
                        </td>	
            		</tr>
        		<?php }?>
        	</tbody>
		</table>
	</body>
</html>