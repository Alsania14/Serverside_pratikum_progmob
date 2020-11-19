/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.1.38-MariaDB : Database - pratikum_progmob
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `detail_events` */

DROP TABLE IF EXISTS `detail_events`;

CREATE TABLE `detail_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` datetime DEFAULT NULL,
  `status_member` enum('accept','denied','pending') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `detail_events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `detail_events_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `detail_events` */

insert  into `detail_events`(`id`,`event_id`,`user_id`,`tanggal_masuk`,`tanggal_keluar`,`status_member`,`created_at`,`updated_at`,`deleted_at`) values 
(4,3,1,'2020-11-01',NULL,'denied','2020-11-01 16:14:03','2020-11-01 16:26:22',NULL);

/*Table structure for table `event_images` */

DROP TABLE IF EXISTS `event_images`;

CREATE TABLE `event_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `image_name` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_images_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `event_images` */

insert  into `event_images`(`id`,`event_id`,`image_name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,3,'Baktisosial.png','2020-11-03 13:14:39',NULL,NULL);

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `maximal_member` int(11) DEFAULT NULL,
  `status` enum('open','close','ongoing','done') DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `events` */

insert  into `events`(`id`,`user_id`,`nama`,`deskripsi`,`tanggal_mulai`,`tanggal_selesai`,`maximal_member`,`status`,`updated_at`,`created_at`) values 
(3,1,'udayana goes to nature','udayanan mantap','2020-11-01','2020-11-05',NULL,'open',NULL,NULL),
(4,2,'udayana carnival','udayana carnival','2020-11-01','2020-11-11',NULL,'open',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `no_telp` varchar(50) DEFAULT NULL,
  `bio` varchar(100) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`full_name`,`username`,`no_telp`,`bio`,`password`,`updated_at`,`created_at`) values 
(1,'alin','alin',NULL,NULL,'8df03bca3f48d310f74fe6092af08c95','2020-10-22 19:48:01','2020-10-22 19:48:01'),
(2,'alin4154','alin4154',NULL,NULL,'8c7698f79dc39e69e7ba8936e512f4ab','2020-10-24 14:49:44','2020-10-24 14:49:44');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
