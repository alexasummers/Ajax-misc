DROP TABLE IF EXISTS Item;

CREATE TABLE Item (
ID INT NOT NULL AUTO_INCREMENT,
Name VARCHAR(255) NOT NULL,
Completed Boolean,
PRIMARY KEY (ID)
);


INSERT INTO Item(Name,Completed)
VALUES ('Fruits',FALSE),
('Vegetables',TRUE),
('Milk',False);


