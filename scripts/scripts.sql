CREATE TABLE `auth`.`users`
(`id` INT NOT NULL AUTO_INCREMENT ,
 `firstName` VARCHAR(50) NOT NULL ,
 `lastName` INT(50) NOT NULL ,
 `username` VARCHAR(50) NOT NULL ,
 `password` VARCHAR(225) NOT NULL ,
 `email` VARCHAR(50) NOT NULL ,
 `role` VARCHAR (50) NOT NULL,
 `verified` TINYINT(1) NULL,
 `photo` LONGBLOB NULL,
 `creationDate` DATE NOT NULL ,
 `modifiedDate` DATE NOT NULL ,
 PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `auth`.`activities`
(`id` INT NOT NULL AUTO_INCREMENT ,
 `name` VARCHAR(100) NOT NULL ,
 `description` TEXT NOT NULL ,
 `info` TEXT NOT NULL ,
 `price` DECIMAL(10,2) NOT NULL ,
 `max_group_number` int(11) NOT NULL ,
 `season` VARCHAR(50) NOT NULL ,
 `country` VARCHAR (50) NOT NULL,
 `category` VARCHAR(50) NOT NULL,
 `photo` LONGBLOB NULL,
 `creationDate` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `auth`.`products`
(`id` INT NOT NULL AUTO_INCREMENT ,
 `name` VARCHAR(100) NOT NULL ,
 `description` TEXT NOT NULL ,
 `info` TEXT  NULL ,
 `price` DECIMAL(10,2) NOT NULL ,
 `quantity` int(11) NOT NULL ,
 `user_id` int(11) NOT NULL ,
 `image` LONGBLOB NULL,
 `creationDate` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `auth`.`reviews`
(`id` INT NOT NULL AUTO_INCREMENT ,
 `rating` int(11) NOT NULL,
 `review` text NULL,
 `user_id` int(11) NOT NULL ,
 `creationDate` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 PRIMARY KEY (`id`)) ENGINE = InnoDB;