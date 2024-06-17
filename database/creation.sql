-- Database creation
CREATE DATABASE IF NOT EXISTS `compta`;
USE `compta`;

-- Bank accounts table
CREATE TABLE IF NOT EXISTS `bank_accounts` (
    `id`        int(11)         NOT NULL AUTO_INCREMENT,
    `name`      varchar(16)     NOT NULL,

    PRIMARY KEY (`id`)
);

-- Payment methods table
CREATE TABLE IF NOT EXISTS `payment_methods` (
    `id`        int(11)         NOT NULL AUTO_INCREMENT,
    `name`      varchar(16)     NOT NULL,

    PRIMARY KEY (`id`)
);

-- Frequencies table
CREATE TABLE IF NOT EXISTS `frequencies` (
    `id`        int(11)         NOT NULL AUTO_INCREMENT,
    `name`      varchar(16)     NOT NULL,

    PRIMARY KEY (`id`)
);

-- Categories table
CREATE TABLE IF NOT EXISTS `categories` (
    `id`        int(11)         NOT NULL AUTO_INCREMENT,
    `name`      varchar(16)     NOT NULL,
    `type`      int(1)          NOT NULL, -- 0: Expense, 1: Income

    PRIMARY KEY (`id`)
);

-- Transactions table
CREATE TABLE IF NOT EXISTS `transactions` (
    `id`                int(11)         NOT NULL AUTO_INCREMENT,
    `date`              date            NOT NULL,
    `banking_date`      date            DEFAULT NULL,
    `description`       varchar(256)    NOT NULL,
    `amount`            decimal(6,2)    NOT NULL,
    `bank_account`      int(11)         NOT NULL,
    `payment_method`    int(11)         NOT NULL,
    `frequency`         int(11)         NOT NULL,
    `category`          int(11)         DEFAULT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`bank_account`) REFERENCES `bank_accounts`(`id`),
    FOREIGN KEY (`payment_method`) REFERENCES `payment_methods`(`id`),
    FOREIGN KEY (`frequency`) REFERENCES `frequencies`(`id`),
    FOREIGN KEY (`category`) REFERENCES `categories`(`id`)
);