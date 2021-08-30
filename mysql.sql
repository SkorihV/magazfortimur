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




products | CREATE TABLE `products` (
           `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
           `name` varchar(255) NOT NULL DEFAULT '',
           `article` varchar(255) NOT NULL DEFAULT '',
           `price` double unsigned DEFAULT NULL,
           `amount` int(10) unsigned DEFAULT NULL,
           `description` mediumtext,
           `category_id` int(10) unsigned DEFAULT NULL,
           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 |

| categories | CREATE TABLE `categories` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 |

CREATE  TABLE `product_images` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `product_id` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL DEFAULT '',
    `path` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
    )

CREATE  TABLE `tasks_queue` (
               `id` int unsigned NOT NULL AUTO_INCREMENT,
               `name` varchar(255) NOT NULL DEFAULT '',
               `task` varchar(255) NOT NULL DEFAULT '',
               `params` text NOT NULL,
               `status` ENUM('new', 'in_process', 'done') DEFAULT 'new',
               `create_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
               PRIMARY KEY (`id`)
);

ALTER TABLE `tasks_queue` CHANGE COLUMN `create_at` `created_at` DATETIME NOT NULL;

ALTER TABLE tasks_queue CHANGE updated_at `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
