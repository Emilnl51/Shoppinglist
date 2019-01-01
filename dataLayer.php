<?php
function getConnection() {
    $connection = new PDO("mysql:dbname=shoppinglist;charset=utf8mb4;host=localhost", "root", "",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
        );
    return $connection;
}

function getAllListItems($listId) {
    $sql = sprintf(
        "SELECT * FROM shoppinglist sl INNSER JOIN listitem li ON sl.id = li.listId WHERE sl.id = %d;", 
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
?>