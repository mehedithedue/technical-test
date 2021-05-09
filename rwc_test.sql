-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf32;

INSERT INTO `categories` (`id`, `category`, `created_at`, `update_at`) VALUES
(1,	'Personal Document',	'2021-05-08 21:13:24',	'2021-05-08 21:12:56'),
(2,	'Canadian Entity Document',	'2021-05-08 21:13:43',	'2021-05-08 21:13:43'),
(3,	'Current Entity Document',	'2021-05-08 21:14:01',	'2021-05-08 21:14:01');

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf32 NOT NULL,
  `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_foreign` (`category_id`),
  CONSTRAINT `category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `documents` (`id`, `category_id`, `name`, `created_at`, `updated_at`) VALUES
(1,	1,	'Passport',	'2021-05-08 21:29:04',	'2021-05-08 21:29:04'),
(2,	1,	'Photo',	'2021-05-08 21:29:17',	'2021-05-08 21:29:17'),
(3,	2,	'North American Client List',	'2021-05-08 21:29:50',	'2021-05-08 21:29:50'),
(4,	2,	'Potential Clients in North American',	'2021-05-08 21:30:40',	'2021-05-08 21:30:40'),
(5,	2,	'Business Letter Support',	'2021-05-08 21:31:02',	'2021-05-08 21:31:02'),
(6,	3,	'Vendor Contracts',	'2021-05-08 21:31:20',	'2021-05-08 21:31:20'),
(7,	3,	'Lease Contracts',	'2021-05-09 20:27:43',	'2021-05-08 21:31:30'),
(8,	3,	'Technology and Intellectual Property',	'2021-05-08 21:31:49',	'2021-05-08 21:31:49');

-- 2021-05-09 21:36:18
