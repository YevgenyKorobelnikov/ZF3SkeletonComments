/*
SQLyog Community Edition- MySQL GUI v6.05 Beta3
Host - 5.5.21 : Database - zf2tutorial
*********************************************************************
Server version : 5.5.21
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `zf2tutorial`;

USE `zf2tutorial`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `root_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `text` tinytext CHARACTER SET utf8 NOT NULL,
  `dt_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dt_added_idx` (`dt_added`),
  KEY `parent_id_idx` (`parent_id`),
  KEY `root_id_idx` (`root_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `comments` */

insert  into `comments`(`id`,`parent_id`,`root_id`,`post_id`,`username`,`email`,`text`,`dt_added`) values (1,0,0,NULL,'user1','user1@domaim.com','Hi, I\'am first!','2019-01-03 18:05:09'),(2,0,0,NULL,'user2','user2@domain.com','Ура! Я первый','2019-01-03 18:09:16'),(3,1,1,NULL,'user3','user3@domain.com','Поздравляю!','2019-01-03 18:09:24'),(4,3,1,NULL,'user4','user4@domain.com','Тест level 2','2019-01-09 11:57:04'),(5,2,2,NULL,'user4','user@domain.com','blablabla','2019-01-09 12:25:21'),(6,4,1,NULL,'usweerw','asfedsdf','qwerwerwer','2019-01-09 14:55:59'),(7,0,0,NULL,'user7','232323','test\r\ntest','2019-01-11 00:02:45'),(8,0,0,NULL,'user8','sdsadsdas','21111111111','2019-01-11 00:03:29'),(9,0,0,NULL,'user9','sdddddddd','222222234','2019-01-11 00:04:55'),(10,9,9,NULL,'www','m@w.com','Тест 10 уровень 2','2019-01-11 00:04:35');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
