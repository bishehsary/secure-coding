/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.21-MariaDB : Database - coding
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

/*Table structure for table `heading` */

DROP TABLE IF EXISTS `heading`;

CREATE TABLE `heading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4;

/*Data for the table `heading` */

insert  into `heading`(`id`,`parent`,`title`) values (1,0,'Header Security (DEV522.3, DEV522.6, DEV541.1, DEV544.1)'),(2,0,'Authentication (DEV522.1, DEV541.2, DEV544.2)'),(3,0,'Authorization (DEV522.1, DEV541.3, DEV544.3)'),(4,0,'Session Management (DEV541.2, DEV544.2)'),(5,0,'Input Validation (DEV541.1, DEV544.1)'),(6,0,'Output Encoding (DEV541.1, DEV544.1)'),(7,0,'Browser Manipulation (DEV541.1, DEV544.1)'),(8,0,'File Handling'),(9,0,'Cryptography (DEV522.2, DEV541.3, DEV544.3)'),(10,0,'AJAX and Web Services Security (DEV522.4)'),(11,0,'Error Handling (DEV541.3, DEV544.3)'),(12,0,'Auditing & Logging (DEV541.3, DEV544.3)'),(13,1,'X-XSS-Protection'),(14,1,'Secure Flag'),(15,1,'Http Only Flag'),(16,1,'PHP Header'),(17,1,'MVC Header'),(18,1,'Server Header'),(19,1,'Other Security Flags'),(20,2,'Authentication Scenarios'),(21,2,'Implementing form authentication'),(22,2,'Password Control'),(23,2,'CAPTCHA Mechanism'),(24,2,'Mitigating brute force attacks'),(25,2,'Authentication Protocols (OAuth, OpenId, SAML, FIDO)'),(26,3,'Authorization models'),(27,3,'URL authorization'),(28,3,'File authorization'),(29,3,'Role Based Access Control (RBAC)'),(30,3,'Discretionary Access Control (DAC)'),(31,3,'Mandatory Access Control (MAC)'),(32,3,'Permission Based Access Control'),(33,3,'Working with identities'),(34,3,'Claim based authorization'),(35,3,'Role manager'),(36,3,'MVC Authorization'),(37,4,'Session management techniques'),(39,4,'Avoiding session hijacking'),(40,4,'Cookie based session management'),(41,4,'Cookie information leakage'),(42,4,'Cookie Attribute'),(43,4,'Session Expiration'),(44,4,'Session management common vulnerabilities'),(45,5,'Data Validation Strategies'),(46,5,'Sanitize with Whitelist'),(47,5,'Sanitize with Blacklist'),(48,5,'Implement Validator'),(49,6,'Preventing HTML injection'),(50,6,'Preventing Cross Site Scripting (XSS)'),(51,7,'Cross Site Request Forgery (CSRF)'),(52,7,'Anti CSRF token'),(53,7,'CSRF Protection for XHR'),(54,7,'Preventing Open Redirection'),(55,7,'Preventing ClickJacking'),(56,8,'Virtual path mapping'),(57,8,'Sanitizing file names'),(58,8,'File extension handling'),(59,8,'Directory listing'),(60,9,'Symmetric Encryption'),(61,9,'Asymmetric Encryption'),(62,9,'Hashing'),(63,10,'Web services overview'),(64,10,'Security in parsing of XML'),(65,10,'XML security'),(66,10,'AJAX technologies overview'),(67,10,'AJAX attack trends and common attacks'),(68,10,'AJAX defense'),(69,11,'Structured exception handling – Try, Catch, Finally'),(70,11,'Creating custom error pages'),(71,11,'HTTP error codes'),(72,11,'Error handling strategies'),(73,12,'Event message structure'),(74,12,'Logging best practices');

ALTER TABLE `heading` ADD `done` TINYINT DEFAULT 0;

CREATE TABLE `accesslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` CHAR(15) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `timestamp` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
