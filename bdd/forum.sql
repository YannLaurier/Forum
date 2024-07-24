-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           11.4.2-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `forum`;

-- Listage de la structure de la table forum. answers
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FK_author_id` int(11) unsigned DEFAULT NULL,
  `FK_post_id` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_answers_posts` (`FK_post_id`),
  KEY `FK_answers_user` (`FK_author_id`),
  CONSTRAINT `FK_answers_posts` FOREIGN KEY (`FK_post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_answers_user` FOREIGN KEY (`FK_author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table forum. cat
CREATE TABLE IF NOT EXISTS `cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table forum. posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FK_author_id` int(11) unsigned NOT NULL,
  `FK_category_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publication_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_posts_user` (`FK_author_id`),
  KEY `FK_posts_subcat` (`FK_category_id`),
  CONSTRAINT `FK_posts_subcat` FOREIGN KEY (`FK_category_id`) REFERENCES `subcat` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_posts_user` FOREIGN KEY (`FK_author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table forum. report
CREATE TABLE IF NOT EXISTS `report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FK_id_reporter` int(11) unsigned NOT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `FK_id_post` int(11) unsigned DEFAULT NULL,
  `FK_id_answer` int(11) unsigned DEFAULT NULL,
  `treated` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_report_user` (`FK_id_reporter`),
  KEY `FK_report_answers` (`FK_id_answer`),
  KEY `FK_report_posts` (`FK_id_post`),
  CONSTRAINT `FK_report_answers` FOREIGN KEY (`FK_id_answer`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_report_posts` FOREIGN KEY (`FK_id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_report_user` FOREIGN KEY (`FK_id_reporter`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table forum. subcat
CREATE TABLE IF NOT EXISTS `subcat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FK_mother_cat` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_subcat_cat` (`FK_mother_cat`),
  CONSTRAINT `FK_subcat_cat` FOREIGN KEY (`FK_mother_cat`) REFERENCES `cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Pseudo` varchar(50) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `profilePicFilename` varchar(255) DEFAULT NULL,
  `profilePicType` varchar(10) DEFAULT NULL,
  `profilePicData` mediumblob DEFAULT NULL,
  `description` tinytext NOT NULL DEFAULT 'Cet utilisateur n\'a pas encore dit quoi que ce soit sur sa personne.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Pseudo` (`Pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Les données exportées n'étaient pas sélectionnées.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
