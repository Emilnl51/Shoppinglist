<?php
class ShoppingList {
    public $id;
    public $listName;
    
    function __construct($id, $listName) {
        $this->id = $id;
        $this->listName = $listName;
    }
}

class ListItem {
    public $id;
    public $itemName;
    
    function __construct($id, $itemName) {
        $this->id = $id;
        $this->itemName = $itemName;
    }
}

function getConnection() {
    $connection = new PDO("mysql:dbname=ShoppingList;charset=utf8mb4;host=localhost", "root", "",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        )
        );
    return $connection;
}

function getAllShoppingLists() {
    $sql = sprintf("SELECT * FROM ShoppingList;");
    
    $statement = getConnection()->query($sql);
    $rows = $statement->fetchAll();
    $shoppingLists = array();
    foreach ($rows as $key => $row) {
        $shoppingLists[$key] = new ShoppingList($row["Id"], $row["ListName"]);
    }
    return $shoppingLists;
}


function getAllListItems($listId) {
    $sql = "SELECT * FROM ShoppingList sl INNER JOIN ListItem li ON sl.id = li.listId WHERE sl.id = :listId";

    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':listId' => $listId));
    $rows = $statement->fetchAll();
    $listItems = array();
    foreach ($rows as $key => $row) {
        $listItems[$key] = new ListItem($row["Id"], $row["ItemName"]);
    }
    return $listItems;
}

function insertItem($listId, $itemName) {
    $sql = "INSERT INTO ListItem (Id, ListId, ItemName) VALUES (null, :listId, :itemName);"; 
    
    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':listId' => $listId, ':itemName' => $itemName));
    
}

function deleteItem($listId, $itemId) {
    $sql = "DELETE FROM ListItem WHERE listId = :listId AND Id = :itemId";
    
    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':listId' => $listId, ':itemId' => $itemId));
    
}

function updateItem($listId, $itemId, $itemName) {
    $sql = "UPDATE ListItem SET itemName = :itemName WHERE listId = :listId AND id = :itemId";
    
    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':itemName' => $itemName, ':listId' => $listId, ':itemId' => $itemId));
}

function insertList($listName) {
    $sql = "INSERT INTO ShoppingList (Id, ListName, ExternalId) VALUES (null, :listName, uuid());";
    $conn = getConnection();
    $statement = $conn->prepare($sql);
    $statement->execute(array(':listName' => $listName));

    return $conn->lastInsertId();
}

function updateListName($listId, $listName) {
    $sql = "UPDATE ShoppingList SET ListName = :listName WHERE id = :listId";
    
    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':listName' => $listName, ':listId' => $listId));
}

function deleteList($listId) {
    $sql = "DELETE FROM ListItem WHERE listId = :listId";
    $sql2 = "DELETE FROM ShoppingList WHERE id = :listId";
    $statement = getConnection()->prepare($sql);
    $statement2 = getConnection()->prepare($sql2);
    $statement->execute(array(':listId' => $listId, ':listId' => $listId));
    $statement2->execute(array(':listId' => $listId, ':listId' => $listId));
}
?>