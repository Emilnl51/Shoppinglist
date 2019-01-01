
CREATE DATABASE ShoppingList;

CREATE TABLE ShoppingList(
Id INT NOT NULL auto_increment,
ListName VARCHAR(50) NOT NULL,
PRIMARY KEY(Id));


CREATE TABLE ListItem(
Id INT NOT NULL auto_increment,
ListId INT NOT NULL,
ItemName VARCHAR(100) NOT NULL,
Done BIT NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(ListId) REFERENCES ShoppingList(Id));