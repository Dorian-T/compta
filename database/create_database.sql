-- Database creation
CREATE DATABASE IF NOT EXISTS `compta`;
USE `compta`;

-- transaction table
CREATE TABLE IF NOT EXISTS `transactions` (
    `id`               int(11)      NOT NULL AUTO_INCREMENT,
    `banking_date`     date         NOT NULL,
    `transaction_date` date         DEFAULT NULL,
    `description`      varchar(128) NOT NULL,
    `amount`           decimal(6,2) NOT NULL,
    `source_account`   varchar(16)  NOT NULL,
    `target`           varchar(32)  DEFAULT NULL,
    `payment_method`   varchar(16)  NOT NULL,
    `category`         varchar(16)  DEFAULT NULL, -- régulier, exceptionnel, loisir
    `subcategory`      varchar(16)  DEFAULT NULL, -- loyer, salaire, courses, essence, ...
    PRIMARY KEY (`id`)
);