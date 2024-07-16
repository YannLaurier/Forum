CREATE DATABASE IF NOT EXISTS `Forum`;

CREATE TABLE `Report`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_reporter` INT NOT NULL,
    `reason` TEXT NOT NULL,
    `id_post` INT NULL,
    `id_answer` INT NULL,
    `treated` BOOLEAN NOT NULL
);
CREATE TABLE `Answers`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FK_author_id` INT NOT NULL,
    `FK_post_id` INT NOT NULL,
    `time` DATETIME NOT NULL,
    `content` TEXT NOT NULL
);
CREATE TABLE `Subcat`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FK_mother_cat` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL
);
CREATE TABLE `User`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Pseudo` VARCHAR(50) NOT NULL,
    `Pass` VARCHAR(255) NOT NULL,
    `Profile_pic` TEXT NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `status` VARCHAR(10) NOT NULL
);
CREATE TABLE `Cat`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL
);
CREATE TABLE `Posts`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FK_author_id` INT NOT NULL,
    `FK_category_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `publication_date` DATETIME NOT NULL
);
ALTER TABLE
    `Subcat` ADD CONSTRAINT `subcat_fk_mother_cat_foreign` FOREIGN KEY(`FK_mother_cat`) REFERENCES `Cat`(`id`);
ALTER TABLE
    `Report` ADD CONSTRAINT `report_id_answer_foreign` FOREIGN KEY(`id_answer`) REFERENCES `Answers`(`id`);
ALTER TABLE
    `Posts` ADD CONSTRAINT `posts_fk_author_id_foreign` FOREIGN KEY(`FK_author_id`) REFERENCES `User`(`id`);
ALTER TABLE
    `Report` ADD CONSTRAINT `report_id_reporter_foreign` FOREIGN KEY(`id_reporter`) REFERENCES `User`(`id`);
ALTER TABLE
    `Posts` ADD CONSTRAINT `posts_fk_category_id_foreign` FOREIGN KEY(`FK_category_id`) REFERENCES `Subcat`(`id`);
ALTER TABLE
    `Report` ADD CONSTRAINT `report_id_post_foreign` FOREIGN KEY(`id_post`) REFERENCES `Posts`(`id`);
ALTER TABLE
    `Answers` ADD CONSTRAINT `answers_fk_post_id_foreign` FOREIGN KEY(`FK_post_id`) REFERENCES `Posts`(`id`);
ALTER TABLE
    `Answers` ADD CONSTRAINT `answers_fk_author_id_foreign` FOREIGN KEY(`FK_author_id`) REFERENCES `User`(`id`);