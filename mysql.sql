CREATE TABLE books (
    id int AUTO_INCREMENT primary key,
    name varchar(255) NOT NULL,
    price double not null
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE DATABASE phpwebinars CHARACTER SET utf8;

ALTER DATABASE databasename CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE tablename CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;


INSERT INTO books(name, price) values ('книга1','100'),('книга2','200'),('книга3','300'),('книга4','400'),('книга5','500');


ALTER TABLE products ADD (
	`article` int unsigned,
	`price` double unsigned,
	`amount` int unsigned,
	`discription` varchar(255),
	`category_id` int
);

 CREATE TABLE products (
  id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY ,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE products (
                          `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                          `name` varchar(255) NOT NULL DEFAULT '',
                          `article` varchar(255) NOT NULL DEFAULT '',
                          `price` double unsigned DEFAULT NULL,
                          `amount` int unsigned DEFAULT NULL,
                          `description` MEDIUMTEXT DEFAULT NULL,
                          `category_id` int unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;