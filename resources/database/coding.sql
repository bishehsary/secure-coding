/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 5.7.18 : Database - coding
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`coding` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `coding`;

/*Table structure for table `accesslog` */

DROP TABLE IF EXISTS `accesslog`;

CREATE TABLE `accesslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(15) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `accesslog` */

/*Table structure for table `applog` */

DROP TABLE IF EXISTS `applog`;

CREATE TABLE `applog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `date` int(12) NOT NULL,
  `data` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `applog` */

/*Table structure for table `heading` */

DROP TABLE IF EXISTS `heading`;

CREATE TABLE `heading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `done` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4;

/*Data for the table `heading` */

insert  into `heading`(`id`,`parent`,`title`,`done`) values 
(1,0,'Header Security (DEV522.3, DEV522.6, DEV541.1, DEV544.1)',0),
(2,0,'Authentication (DEV522.1, DEV541.2, DEV544.2)',0),
(3,0,'Authorization (DEV522.1, DEV541.3, DEV544.3)',0),
(4,0,'Session Management (DEV541.2, DEV544.2)',0),
(5,0,'Input Validation (DEV541.1, DEV544.1)',0),
(6,0,'Output Encoding (DEV541.1, DEV544.1)',0),
(7,0,'Browser Manipulation (DEV541.1, DEV544.1)',0),
(8,0,'File Handling',0),
(9,0,'Cryptography (DEV522.2, DEV541.3, DEV544.3)',0),
(10,0,'AJAX and Web Services Security (DEV522.4)',0),
(11,0,'Error Handling (DEV541.3, DEV544.3)',0),
(12,0,'Auditing & Logging (DEV541.3, DEV544.3)',0),
(13,1,'X-XSS-Protection',0),
(14,1,'Secure Flag',0),
(15,1,'Http Only Flag',0),
(16,1,'PHP Header',0),
(17,1,'MVC Header',0),
(18,1,'Server Header',0),
(19,1,'Other Security Flags',0),
(20,2,'Authentication Scenarios',0),
(21,2,'Implementing form authentication',0),
(22,2,'Password Control',0),
(23,2,'CAPTCHA Mechanism',0),
(24,2,'Mitigating brute force attacks',0),
(25,2,'Authentication Protocols (OAuth, OpenId, SAML, FIDO)',0),
(26,3,'Authorization models',0),
(27,3,'URL authorization',0),
(28,3,'File authorization',0),
(29,3,'Role Based Access Control (RBAC)',0),
(30,3,'Discretionary Access Control (DAC)',0),
(31,3,'Mandatory Access Control (MAC)',0),
(32,3,'Permission Based Access Control',0),
(33,3,'Working with identities',0),
(34,3,'Claim based authorization',0),
(35,3,'Role manager',0),
(36,3,'MVC Authorization',0),
(37,4,'Session management techniques',0),
(39,4,'Avoiding session hijacking',0),
(40,4,'Cookie based session management',0),
(41,4,'Cookie information leakage',0),
(42,4,'Cookie Attribute',0),
(43,4,'Session Expiration',0),
(44,4,'Session management common vulnerabilities',0),
(45,5,'Data Validation Strategies',0),
(46,5,'Sanitize with Whitelist',0),
(47,5,'Sanitize with Blacklist',0),
(48,5,'Implement Validator',0),
(49,6,'Preventing HTML injection',0),
(50,6,'Preventing Cross Site Scripting (XSS)',0),
(51,7,'Cross Site Request Forgery (CSRF)',0),
(52,7,'Anti CSRF token',0),
(53,7,'CSRF Protection for XHR',0),
(54,7,'Preventing Open Redirection',0),
(55,7,'Preventing ClickJacking',0),
(56,8,'Virtual path mapping',0),
(57,8,'Sanitizing file names',0),
(58,8,'File extension handling',0),
(59,8,'Directory listing',0),
(60,9,'Symmetric Encryption',0),
(61,9,'Asymmetric Encryption',0),
(62,9,'Hashing',0),
(63,10,'Web services overview',0),
(64,10,'Security in parsing of XML',0),
(65,10,'XML security',0),
(66,10,'AJAX technologies overview',0),
(67,10,'AJAX attack trends and common attacks',0),
(68,10,'AJAX defense',0),
(69,11,'Structured exception handling – Try, Catch, Finally',0),
(70,11,'Creating custom error pages',0),
(71,11,'HTTP error codes',0),
(72,11,'Error handling strategies',0),
(73,12,'Event message structure',0),
(74,12,'Logging best practices',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
