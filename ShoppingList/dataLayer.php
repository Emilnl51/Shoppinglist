<?php
class ShoppingList {
    public $id;
    public $listName;
    
    function __construct($id, $listName) {
        $this->id = $id;
        $this->listName = $listName;
    }
}

function getConnection() {
    $connection = new PDO("mysql:dbname=shoppinglist;charset=utf8mb4;host=localhost", "root", "",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
        );
    return $connection;
}

function getAllShoppingLists() {
    $sql = sprintf("SELECT * FROM shoppinglist;");
    
    $statement = getConnection()->query($sql);
    $rows = $statement->fetchAll();
    $shoppingLists = array();
    foreach ($rows as $key => $row) {
        $shoppingLists[$key] = new ShoppingList($row["Id"], $row["ListName"]);
    }
    return $shoppingLists;
}


function getAllListItems($listId) {
    $sql = sprintf(
        "SELECT * FROM shoppinglist sl INNER JOIN listitem li ON sl.id = li.listId WHERE sl.id = %d;", 
        $listId);

    $statement = getConnection()->query($sql);
    $rows = $statement->fetchAll();
    return $rows;
}

function insertItem($listId, $itemName) {
    $sql = sprintf(
        "INSERT INTO listItem (Id, ListId, ItemName) VALUES (null, %d, '%s');", 
        $listId, 
        $itemName);
    
    getConnection()->exec($sql);
}

function deleteItem($listId, $itemId) {
    $sql = sprintf("DELETE FROM listItem WHERE listId = %d AND Id = %d", $listId, $itemId);
    getConnection()->exec($sql);
}

function updateItem($listId, $itemId, $itemName) {
    $sql = sprintf("UPDATE listItem SET itemName = '%s' WHERE listId = %d AND id = %d", 
        $itemName, $listId, $itemId);
    
    getConnection()->exec($sql);
}

function insertList($listName) {
    $sql = sprintf(
        "INSERT INTO shoppinglist (Id, ListName) VALUES (null, '%s');",
        $listName);
    $conn = getConnection();
    $conn->exec($sql);
    return $conn->lastInsertId();
}

function updateListName($listId, $listName) {
    $sql = sprintf("UPDATE shoppinglist SET ListName = '%s' WHERE id = %d",
        $listName, $listId);
    
    getConnection()->exec($sql);
}

function deleteList($listId) {
    $sql = sprintf("DELETE FROM listItem WHERE listId = %d", $listId);
    $sql2 = sprintf("DELETE FROM shoppinglist WHERE id = %d", $listId);
    getConnection()->exec($sql);
    getConnection()->exec($sql2);
}
?>