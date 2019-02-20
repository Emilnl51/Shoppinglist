<?php
define('COOKIEID',   "externalIds"); 
 class ShoppingList {
    public $id;
    public $listName;
    public $externalId;
    
    function __construct($id, $listName, $externalId) {
        $this->id = $id;
        $this->listName = $listName;
        $this->externalId = $externalId;
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
    $sql = "SELECT * FROM ShoppingList;";
    
    $statement = getConnection()->query($sql);
    $rows = $statement->fetchAll();
    $shoppingLists = array();

    makeSureCookieExists();
    $externalIds = (array)json_decode($_COOKIE[COOKIEID]);
    foreach ($rows as $key => $row) {
        if(isset($_COOKIE["listAdmin"]) or in_array($row["ExternalId"], $externalIds)){
            $shoppingLists[$key] = new ShoppingList($row["Id"], $row["ListName"], $row["ExternalId"]);
        }
    }
    return $shoppingLists;
}


function getAllListItems($externalId) {
    $sql = "SELECT * FROM ShoppingList sl INNER JOIN ListItem li ON sl.id = li.listId WHERE sl.externalId = :externalId";

    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':externalId' => $externalId));
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

function getListFromExternalId($externalId) {
    $sql = "SELECT * FROM ShoppingList WHERE ExternalId = :externalId";
    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':externalId' => $externalId));
    $row = $statement->fetch();
    $shoppingList = new ShoppingList($row["Id"], $row["ListName"], $row["ExternalId"]);

    return $shoppingList;
}

function getExternalIdFromListId($listId) {
    $sql = "SELECT * FROM ShoppingList WHERE Id = :listId";
    $statement = getConnection()->prepare($sql);
    $statement->execute(array(':listId' => $listId));
    $row = $statement->fetch();
    $externalId = $row["ExternalId"];
    
    return $externalId;
}

function addExternalIdToCookie($externalId){
    if ($externalId !== "0") {
        makeSureCookieExists();
        
        $json = $_COOKIE[COOKIEID];
        $externalIds = (array)json_decode($json);
        if(!in_array($externalId, $externalIds)){
            array_push($externalIds, $externalId);
        }
        $json = json_encode($externalIds);
        setcookie(COOKIEID, $json, 2147483647, "/");
    }
}

function makeSureCookieExists(){
    if(!isset($_COOKIE[COOKIEID])){
        $json = json_encode(array());
        setcookie(COOKIEID, $json, 2147483647, "/");
    }
}
?>