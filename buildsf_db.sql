-- MySQL dump 10.13  Distrib 8.3.0, for macos14.2 (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `weight` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
INSERT INTO `blocks` VALUES (9,'','footer','<h2><a href=\"/contact\">Build/Sf</a></h2><p>415.602.4062  |  <a href=\"mailto:info@buildsf.com\">info@buildsf.com</a></p><p>968 Corbett Avenue, San Francisco, CA 94131</p><p>License #1049987</p>',0,'2021-06-19 01:40:17','2024-01-14 02:08:01'),(12,'basic','footer','<h2><a href=\"/affiliates\">Affiliates</a></h2><p><a href=\"https://buildsf.com/affiliates\">Join our affiliate program!<br /></a></p><p><a target=\"_blank\" href=\"https://www.longarchitectureproject.com\" rel=\"noreferrer noopener\"><img alt=\"The Long Architecture Project\" class=\"image-\" src=\"/storage/media/60e89d9e15496.png\" /></a><a target=\"_blank\" href=\"https://www.kimberleyharrison.com/\" rel=\"noreferrer noopener\"><img alt=\"Kimberly Harrison Interiors\" class=\"image-\" src=\"/storage/media/60e89d9e038a2.png\" /></a><a target=\"_blank\" href=\"https://www.pencilboxarchitects.com/\" rel=\"noreferrer noopener\"><img alt=\"Pencil Box Architects\" class=\"image-original image-left\" src=\"/storage/media/60e89d9e1abb1.png\" /></a><a target=\"_blank\" href=\"http://www.knock-ad.com/\" rel=\"noreferrer noopener\"><img alt=\"Knock Architecture and Design\" class=\"image-small image-left\" src=\"/storage/media/60e8b8a8c3f79.png\" /></a></p>',1,'2021-06-20 05:00:10','2022-04-18 17:44:30');
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('1b6453892473a467d07372d45eb05abc2031647a','i:2;',1712560474),('1b6453892473a467d07372d45eb05abc2031647a:timer','i:1712560474;',1712560474),('5c785c036466adea360111aa28563bfd556b5fba','i:3;',1712560454),('5c785c036466adea360111aa28563bfd556b5fba:timer','i:1712560454;',1712560454);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` bigint unsigned DEFAULT NULL,
  `weight` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_project_id_foreign` (`project_id`),
  CONSTRAINT `media_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (56,'2021-06-30 20:33:32','2021-06-30 20:33:32','60dcd51ce9349.png','',NULL,NULL),(78,'2021-07-09 19:03:58','2021-07-09 19:03:58','60e89d9e038a2.png','',NULL,NULL),(80,'2021-07-09 19:03:58','2021-07-09 19:03:58','60e89d9e15496.png','',NULL,NULL),(81,'2021-07-09 19:03:58','2021-07-09 19:03:58','60e89d9e1abb1.png','',NULL,NULL),(83,'2021-07-09 20:59:20','2021-07-09 20:59:20','60e8b8a8c3f79.png','',NULL,NULL),(84,'2021-07-09 20:59:34','2021-07-09 20:59:34','60e8b8b61cec5.png','',NULL,NULL),(85,'2021-07-09 21:24:49','2021-07-09 21:24:49','60e8bea15b582.png','',NULL,NULL),(86,'2021-07-09 21:48:33','2021-07-09 21:48:33','60e8c4319b46c.jpg','',15,0),(87,'2021-07-09 21:48:33','2021-07-09 21:48:33','60e8c431a2a10.jpg','',15,1),(88,'2021-07-09 21:48:33','2021-07-09 21:48:33','60e8c431a78b6.jpg','',15,2),(89,'2021-07-09 21:48:33','2021-07-09 21:48:33','60e8c431ac529.jpg','',15,3),(90,'2021-07-09 21:48:33','2021-07-09 21:48:33','60e8c431b1103.jpg','',15,4),(91,'2021-07-09 21:48:33','2021-07-09 21:48:33','60e8c431b6f30.jpg','',15,5),(93,'2021-07-11 20:46:00','2021-07-27 22:26:06','60eb588863cae.jpg','Facade',4,0),(94,'2021-07-11 20:46:00','2021-07-11 20:46:00','60eb588887830.jpg','',4,1),(95,'2021-07-11 20:46:00','2021-07-11 20:46:00','60eb5888a0866.jpg','',4,2),(96,'2021-07-11 20:46:00','2021-07-11 20:46:00','60eb5888b9332.jpg','',4,3),(97,'2021-07-11 20:46:00','2021-07-11 20:46:00','60eb5888cf7fc.jpg','',4,4),(98,'2021-07-11 20:46:01','2021-07-11 20:46:01','60eb5888ecb93.jpg','',4,5),(99,'2021-07-11 20:46:01','2021-07-11 20:46:01','60eb58890a789.jpg','',4,6),(100,'2021-07-11 20:46:01','2021-07-11 20:46:01','60eb58891c1df.jpg','',4,7),(101,'2021-07-11 20:46:01','2021-07-11 20:46:01','60eb58892ddfc.jpg','',4,8),(102,'2021-07-11 20:46:01','2021-07-11 20:46:01','60eb58894752d.jpg','',4,9),(103,'2021-07-11 20:46:01','2021-07-11 20:46:01','60eb58895abd5.jpg','',4,10),(104,'2021-07-11 20:46:01','2021-07-11 20:46:01','60eb588988e9d.jpg','',4,11),(105,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6d43a94.jpg','',5,0),(106,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6d53631.jpg','',5,1),(107,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6d75ff4.jpg','',5,2),(108,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6d8687d.jpg','',5,3),(109,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6d96276.jpg','',5,4),(110,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6da7e14.jpg','',5,5),(111,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6db8aa2.jpg','',5,6),(112,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6dca3e5.jpg','',5,7),(113,'2021-07-11 21:06:53','2021-07-11 21:06:53','60eb5d6ddbc99.jpg','',5,8),(114,'2021-07-11 21:06:54','2021-07-11 21:06:54','60eb5d6dee204.jpg','',5,9),(115,'2021-07-11 21:06:54','2021-07-11 21:06:54','60eb5d6e0a88c.jpg','',5,10),(116,'2021-07-11 21:06:54','2021-07-11 21:06:54','60eb5d6e1afe6.jpg','',5,11),(117,'2021-07-11 21:19:28','2021-07-11 21:19:28','60eb6060ac0e8.jpg','',8,0),(118,'2021-07-11 21:19:28','2021-07-11 21:19:28','60eb6060c603d.jpg','',8,1),(119,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb6060e6d4f.jpg','',8,2),(120,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb60610b50c.jpg','',8,3),(121,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb606120813.jpg','',8,4),(122,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb606135b78.jpg','',8,5),(123,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb60614de86.jpg','',8,6),(124,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb6061634b5.jpg','',8,7),(125,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb60617baa2.jpg','',8,8),(126,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb6061a5074.jpg','',8,9),(127,'2021-07-11 21:19:29','2021-07-11 21:19:29','60eb6061c39a5.jpg','',8,10),(128,'2021-07-11 21:19:29','2021-07-11 21:19:30','60eb6061dcb01.jpg','',8,11),(130,'2021-07-11 23:00:31','2021-07-11 23:00:31','60eb780f61fe1.jpg','',9,0),(131,'2021-07-11 23:00:31','2021-07-11 23:00:31','60eb780f721f9.jpg','',9,1),(132,'2021-07-11 23:00:31','2021-07-11 23:00:31','60eb780f869a5.jpg','',9,2),(133,'2021-07-11 23:00:31','2021-07-11 23:00:31','60eb780f98d76.jpg','',9,3),(134,'2021-07-11 23:00:31','2021-07-11 23:00:31','60eb780fb872f.jpg','',9,4),(135,'2021-07-11 23:00:31','2021-07-11 23:00:31','60eb780fcf7be.jpg','',9,5),(136,'2021-07-11 23:00:32','2021-07-11 23:00:32','60eb780feaf91.jpg','',9,6),(137,'2021-07-11 23:00:32','2021-07-11 23:00:32','60eb781007e9b.jpg','',9,7),(138,'2021-07-11 23:00:32','2021-07-11 23:00:32','60eb7810196fa.jpg','',9,8),(139,'2021-07-11 23:00:32','2021-07-11 23:00:32','60eb78102322c.jpg','',9,9),(140,'2021-07-11 23:22:04','2021-07-11 23:22:04','60eb7d1c431ce.jpg','',10,0),(141,'2021-07-11 23:22:04','2021-07-11 23:22:04','60eb7d1c57830.jpg','',10,1),(142,'2021-07-11 23:22:04','2021-07-11 23:22:04','60eb7d1c7223b.jpg','',10,2),(143,'2021-07-11 23:22:04','2021-09-03 23:22:37','60eb7d1c87eaf.jpg',NULL,17,3),(144,'2021-07-11 23:22:04','2021-09-03 23:22:41','60eb7d1ca0d08.jpg',NULL,17,4),(145,'2021-07-11 23:22:04','2021-07-11 23:22:04','60eb7d1cb5793.jpg','',10,5),(146,'2021-07-11 23:38:06','2021-09-03 23:23:56','60eb80de68dee.jpg',NULL,13,6),(147,'2021-07-12 16:16:46','2021-07-12 16:16:46','60ec6aee1a417.jpg','',11,0),(148,'2021-07-12 16:16:46','2021-07-12 16:16:46','60ec6aee30a04.jpg','',11,1),(149,'2021-07-12 16:16:46','2021-07-12 16:16:46','60ec6aee460c8.jpg','',11,2),(150,'2021-07-12 16:16:46','2021-07-12 16:16:46','60ec6aee6268a.jpg','',11,3),(151,'2021-07-12 16:16:46','2021-07-12 16:16:46','60ec6aee76489.jpg','',11,4),(152,'2021-07-12 16:16:46','2021-07-12 16:16:46','60ec6aee89822.jpg','',11,5),(153,'2021-07-12 16:21:17','2021-07-12 16:21:17','60ec6bfd408ed.jpg','',12,0),(155,'2021-07-12 16:22:49','2021-07-12 17:20:08','60ec6c59c61b6.jpg','',12,1),(156,'2021-07-12 16:22:50','2021-07-12 17:20:08','60ec6c59eb62f.jpg','',12,2),(160,'2021-07-12 16:22:50','2021-07-12 17:31:51','60ec6c5a84b94.jpg','',12,3),(161,'2021-07-12 16:22:50','2021-07-12 17:31:51','60ec6c5a9f885.jpg','',12,4),(163,'2021-07-12 17:33:54','2021-07-12 17:33:54','60ec7d021ad68.jpg','',12,5),(164,'2021-07-12 17:33:54','2021-07-12 17:33:54','60ec7d0237ed1.jpg','',12,6),(165,'2021-07-12 17:33:54','2021-07-12 17:33:54','60ec7d0246980.jpg','',12,7),(166,'2021-07-12 17:33:54','2021-07-12 17:33:54','60ec7d0253586.jpg','',12,8),(167,'2021-07-12 17:51:30','2021-07-12 17:51:30','60ec81227d958.jpg','',13,0),(168,'2021-07-12 17:51:30','2021-07-12 17:51:30','60ec812293a5c.jpg','',13,1),(169,'2021-07-12 17:51:30','2021-07-12 17:51:30','60ec8122a6f2e.jpg','',13,2),(170,'2021-07-12 17:51:30','2021-07-12 17:51:30','60ec8122bd330.jpg','',13,3),(171,'2021-07-12 17:51:30','2021-07-12 17:51:30','60ec8122cd179.jpg','',13,4),(172,'2021-07-12 17:51:30','2021-07-12 17:51:30','60ec8122dd649.jpg','',13,5),(173,'2021-07-12 17:58:00','2021-07-12 17:58:00','60ec82a85de7d.jpg','',14,0),(175,'2021-07-12 17:58:00','2021-07-12 18:04:25','60ec82a881cf0.jpg','',14,1),(176,'2021-07-12 17:58:00','2021-07-12 18:04:25','60ec82a89a2e6.jpg','',14,2),(177,'2021-07-12 18:09:17','2021-07-12 18:09:17','60ec854d731e2.jpg','',17,0),(178,'2021-07-12 18:09:17','2021-07-12 18:09:17','60ec854d88e1c.jpg','',17,1),(179,'2021-07-12 18:09:17','2021-07-12 18:09:17','60ec854da20bc.jpg','',17,2),(180,'2021-07-12 18:09:17','2021-07-12 18:09:17','60ec854db50d4.jpg','',17,3),(190,'2021-07-12 18:35:08','2021-07-12 18:35:08','60ec8b5c299bb.jpg','',19,0),(191,'2021-07-12 18:35:08','2021-07-12 18:35:08','60ec8b5c3df98.jpg','',19,1),(192,'2021-07-12 18:35:08','2021-07-12 18:35:08','60ec8b5c518ae.jpg','',19,2),(193,'2021-07-12 18:35:08','2021-07-12 18:35:08','60ec8b5c697f2.jpg','',19,3),(215,'2021-07-12 19:22:51','2021-07-12 19:22:51','60ec968b28a28.jpg','',NULL,NULL),(216,'2021-07-12 19:22:51','2021-07-12 19:22:51','60ec968b47073.jpg','',NULL,NULL),(217,'2021-07-12 19:22:51','2021-07-12 19:22:51','60ec968b5a6f1.jpg','',NULL,NULL),(219,'2021-07-12 19:22:51','2021-07-12 19:22:51','60ec968b78e14.jpg','',NULL,NULL),(220,'2021-07-12 19:22:51','2021-07-12 19:22:51','60ec968b8d56b.jpg','',NULL,NULL),(221,'2021-07-12 19:22:51','2021-07-12 19:22:51','60ec968b9ca38.jpg','',NULL,NULL),(223,'2021-07-12 19:33:26','2021-07-27 22:26:49','60ec9905dfbc1.jpg','deck',NULL,NULL),(224,'2021-07-12 19:33:26','2021-07-12 19:33:26','60ec99060502f.jpg','',NULL,NULL),(225,'2021-07-12 19:35:43','2021-07-12 19:35:43','60ec998f4ff51.jpg','',NULL,NULL),(226,'2021-07-12 20:16:51','2021-07-12 20:16:51','60eca3330a732.jpg','',NULL,NULL),(227,'2021-07-12 20:24:45','2021-07-12 20:24:45','60eca50d72c37.jpg','',NULL,NULL),(228,'2021-07-12 20:24:45','2021-07-12 20:24:45','60eca50d80d34.jpg','',NULL,NULL),(229,'2021-07-12 20:31:37','2021-07-27 22:18:52','60eca6a90fab6.jpg',NULL,NULL,NULL),(230,'2021-07-12 20:34:40','2021-09-02 17:25:18','60eca76092f59.jpg',NULL,NULL,NULL),(231,'2021-07-23 18:11:20','2021-09-02 18:11:35','60fb06486da2b.jpg','test',NULL,NULL);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_04_08_043420_create_blocks_table',1),(5,'2024_04_08_044156_create_settings_table',1),(6,'2024_04_08_044818_create_pages_table',1),(7,'2024_04_08_044821_create_projects_table',1),(8,'2024_04_08_044824_create_media_table',1),(9,'2024_04_08_044828_create_reviews_table',1),(10,'2024_04_08_044832_create_sections_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Page Title',
  `weight` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `homepage` tinyint(1) NOT NULL DEFAULT '0',
  `meta_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (8,'projects','Projects',1,'2021-06-09 18:17:22','2021-08-01 19:05:08',0,NULL),(14,'recognition','Recognition',3,'2021-06-11 19:02:50','2021-08-01 19:05:08',0,NULL),(17,'home','Home',0,'2021-06-15 19:04:41','2021-06-24 20:48:38',1,NULL),(18,'profile','Profile',2,'2021-06-18 03:09:28','2021-08-01 19:05:08',0,NULL),(19,'contact','Contact',4,'2021-06-22 21:44:23','2021-08-01 19:05:08',0,NULL),(20,'affiliates','Affiliates',5,'2021-07-09 17:44:07','2021-07-22 20:59:22',0,NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Project Title',
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `featured_image_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` int DEFAULT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (4,'eureka','Eureka Valley','<p>One of our most astonishing projects yet, with great thanks to our photographers and our team. We give a Special Thanks to Simon Orchover, an extraordinary Architect and Designer who designed and worked on the interior of this project, his personal home, and who drafted the plans for our quality construction of its facade. We display a mastery in modern architecture with this project. We loved building this home facade and working with Simon Orchover to execute this project. We appreciate his accolades on our well-produced and thought-out work.<br /></p>',94,'2021-06-14 22:53:00','2021-09-01 21:51:37',0,'Modern high-end remodel of Eureka Valley home. San Francisco residential construction, sf contractors.'),(5,'cole-valley','Cole Valley','',113,'2021-06-15 19:20:22','2021-09-03 23:56:11',1,'Design and Build Project Cole Valley, San Francisco high-end residential construction and expert builders, modern eclectic building, SF contractors.'),(8,'fulton-street','Fulton Residence','<p>The Fulton Residence is a classic Victorian remodel, bringing functionality and ingenuity to a historical San Francisco building. We love working with clients who want to restore the historical features of their home. We\'ve worked on many historical restoration projects, bringing the everyday ease of modern  living to the construction of the building while keeping its Victorian or Edwardian charming features.</p><p>Architect: Ernie Selander</p><p>Photographer: Ariel Canvas</p>',121,'2021-06-21 18:17:39','2021-09-01 21:53:16',2,'Classic home renovation, Fulton Street Whole house remodel, Victorian restoration, high end residential remodelers, San Francisco Construction builders.'),(9,'pacific-heights','Pacific Heights','<p>Our full house remodel in Pacific Heights was influenced by a luxurious feel. There\'s a touch of 70\'s greens and golds, modernized to make the whole look and feel of the house come together. <br /></p><p><br /></p><p>Architect: John Goldman Architects</p><p>Designer: Fisher Weisman</p>',130,'2021-06-21 18:17:41','2021-09-01 21:46:22',5,'San Francisco Pacific Heights high end remodel, San Francisco construction, SF restoration projects.'),(10,'chenery-street','Chenery Residence','',141,'2021-06-21 18:17:45','2021-09-01 21:47:28',4,'Modern Home remodel, San Francisco high end construction, beautiful home renovation in Glen Park.'),(11,'Merced','Merced Manor','',150,'2021-06-21 18:23:46','2021-09-01 21:44:23',6,'San Francisco Home Remodel, sf builders, sf construction.'),(12,'firehouse','Twin Peaks','',153,'2021-06-21 18:23:49','2021-09-01 21:48:18',7,'Twin peaks Home reconstruction, whole house remodel, modern home renovation, San Francisco high end builders and remodelers.'),(13,'dubocepark','Duboce Park','',170,'2021-06-21 18:23:51','2021-09-01 21:49:17',8,'Duboce Park Home reconstruction, whole house remodel, eclectic home renovation, San Francisco high end builders and remodelers.'),(14,'noe-valley','Noe Valley Office','',176,'2021-06-21 18:23:53','2021-09-01 21:50:16',9,'Noe Valley Office reconstruction, commercial construction, modern classic office renovation, San Francisco high end builders and remodelers.'),(15,'ashbury-heights','Ashbury Heights','<p>Ashbury Heights is an example of the kinds of classic construction projects we do. Special Thanks to Jessica Johnson Architect and Designer on the project. We do what we do best when we work with designers who seem limitless in their abilities and who create a timeless design homeowners love and appreciate. <br /></p><p>Designer: Jessica Johnson</p>',87,'2021-06-21 18:23:55','2021-09-01 21:45:28',3,'High end construction in Ashbury Heights, San Francisco construction, whole house remodel.'),(17,'glen-park','Glen Park','',180,'2021-07-12 18:08:35','2021-09-01 21:48:48',10,'Glen Park Home reconstruction, whole house remodel, classic home renovation, San Francisco high end builders and remodelers.'),(19,'edgewood','Edgewood','',192,'2021-07-12 18:34:17','2021-09-02 15:45:10',11,'Edgewood office reconstruction, classic design and build remodel, San Francisco high end builders and remodelers.');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES ('060347a7-b1e7-4c4a-b148-964b9548bb41','2021-06-08 02:24:38','2021-06-08 02:24:38','sdfghkj','<p>ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb</p>',0),('4e0f7e6a-b87e-4533-afe6-f5eb4e5dc1ac','2021-06-08 02:24:51','2021-06-08 02:24:51','dsf','<p>ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb ftsdghgv dvgsh sdb</p>',0),('f9c246d9-955a-490b-8c9b-c8b5c72a664f','2021-06-08 02:30:09','2021-06-08 02:30:23','test','<p>test</p>',1);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Section Title',
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'basic',
  `weight` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `page_id` bigint unsigned DEFAULT NULL,
  `image_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collapsible_body` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (4,'dolor','Dolores','<p>Nam id erat eleifend, pellentesque eros id, bibendum sapien. Integer dolor nunc, sagittis ac elit ac, sollicitudin ultrices risus. Etiam a nisi sapien. Mauris mollis elit turpis, ac tristique mauris eleifend non. Maecenas maximus interdum pellentesque. In sed sagittis elit. Proin fermentum, arcu nec sollicitudin egestas, justo lectus viverra purus, in cursus tellus nibh vitae ex. Nam volutpat enim eu nunc luctus egestas. Donec eget accumsan dui, ut dignissim ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque vel libero vel nulla vulputate lobortis. Donec vulputate neque vitae ligula ullamcorper euismod.</p>','reviews',-3,'2021-03-25 18:21:20','2021-06-09 19:13:58',1,NULL,0),(5,'contact','Contact','<p>Add your contact information here!</p>','contact',-3,'2021-03-25 18:35:24','2021-06-09 19:13:58',NULL,NULL,0),(6,'feature','Section Title','<p>Feature content!</p>','feature',-3,'2021-03-25 18:37:48','2021-06-09 19:13:58',NULL,NULL,0),(7,'new-section-948b993f-03e7-4ca7-bd94-b248c7ea340d','Section Title','<p>Add your content here!</p>','basic',-2,'2021-06-02 20:44:49','2021-06-09 19:13:58',NULL,NULL,0),(9,'new-section-aacd3b6a-2222-4091-bfd8-c0e63374a134','Section Title','<p>Add your content here!</p><p>To change this page\'s URL, title, or order in the navigation menu, edit the page settings below. </p>','basic',-3,'2021-06-03 02:02:48','2021-06-09 19:13:55',5,NULL,0),(10,'new-section-cdfffc8d-2563-4044-8da2-66cd21eab3e7','Section Title','<p>Add your content here!</p><p>To change this page\'s URL, title, or order in the navigation menu, edit the page settings below. </p>','basic',-4,'2021-06-03 21:23:26','2021-06-09 19:13:58',6,NULL,0),(11,'new-section-7eddbfa3-6113-4181-b745-8d7c5d3a7569','Section Title','<p>Add your content here!</p><p>To change this page\'s URL, title, or order in the navigation menu, edit the page settings below. </p>','basic',-4,'2021-06-03 21:31:51','2021-06-09 19:13:58',7,NULL,0),(12,'new-section-262dec07-11f7-4f45-b759-9d7aeea0e085','Section Title','<p>Add your content here!</p>','basic',-1,'2021-06-03 22:17:56','2021-06-09 19:13:58',NULL,NULL,0),(13,'new-section-54681dfa-320d-4ca5-89e0-6eb00b656b3c','Section Title','<p>Add your content here!</p>','basic',0,'2021-06-03 22:30:55','2021-06-09 19:13:58',NULL,NULL,0),(14,'new-section-1638c1ed-545f-41de-b2c0-a9214873e76f','Section Title','<p>Add your content here!</p>','basic',1,'2021-06-03 22:33:12','2021-06-09 19:13:58',NULL,NULL,0),(15,'new-section-3f9b1e23-ce4c-498a-b666-e8a82f1f4959','Section Title','<p>Add your content here!</p>','basic',2,'2021-06-03 22:33:51','2021-06-09 19:13:58',NULL,NULL,0),(16,'new-section-c0861d3b-1082-4a4a-b39f-f87c9da0d190','Section Title','<p>Add your content here!</p>','basic',3,'2021-06-03 22:34:18','2021-06-09 19:13:58',NULL,NULL,0),(17,'new-section-cfeda178-5906-4f32-83c8-0f867efbe871','Section Title','<p>Add your content here!</p>','basic',4,'2021-06-03 22:34:54','2021-06-09 19:13:58',NULL,NULL,0),(18,'new-section-dd70a14c-f6f5-497b-9753-eb99e685d0b8','Section Title','<p>Add your content here!</p>','basic',5,'2021-06-03 22:37:20','2021-06-09 19:13:58',NULL,NULL,0),(19,'new-section-390e388b-a962-42e0-9e3d-891334f57513','Section Title','<p>Add your content here!</p>','basic',6,'2021-06-03 22:37:34','2021-06-09 19:13:58',NULL,NULL,0),(20,'new-section-dbee887d-d534-4b6d-8ea5-6427e72d1b3c','Section Title','<p>Add your content here!</p>','basic',7,'2021-06-03 22:37:54','2021-06-09 19:13:58',NULL,NULL,0),(21,'new-section-29b89c67-4fba-439a-a086-acc3bf5bd478','Section Title','<p>Add your content here!</p>','basic',8,'2021-06-03 22:38:25','2021-06-09 19:13:58',NULL,NULL,0),(22,'new-section-370517e1-0c3b-4452-b649-cb8fba97d2ca','Section Title','<p>Add your content here!</p>','basic',9,'2021-06-03 22:38:50','2021-06-09 19:13:58',NULL,NULL,0),(23,'new-section-a83eb3dc-5eb5-4091-b558-020e60689b02','Section Title','<p>Add your content here!</p>','basic',10,'2021-06-03 22:39:20','2021-06-09 19:13:58',NULL,NULL,0),(24,'a','Section Title','<p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p>','basic',-3,'2021-06-03 22:40:08','2021-06-09 19:13:58',1,NULL,0),(25,'b','New Section','<p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p><p>Add your content here!</p>','basic',-2,'2021-06-04 01:12:02','2021-06-09 19:13:58',1,NULL,0),(33,'new-section-a19f1930-f0af-4a30-afef-39e5286b6100','Collapsible Section','<p>Add your content here!</p><p>To change this page\'s URL, title, or order in the navigation menu, edit the page settings below. </p>','basic',-3,'2021-06-09 18:18:50','2021-06-10 19:56:26',9,NULL,0),(34,'new-section-3ec392cb-886d-4ced-9843-43c61b547b14','Collapsible Section 2','<p>Add your content here!</p>','basic',-3,'2021-06-09 18:19:25','2021-06-10 19:53:32',9,NULL,0),(35,'new-section-7a9377d0-8289-4d7d-8fb6-c874fc99ffc8','Collapsible Section 3','<p>Add your content here!</p>','basic',-3,'2021-06-09 18:19:29','2021-06-09 19:13:58',9,NULL,0),(37,'new-section-61632d59-5d88-4723-921d-c415bf44089a','Collapsible section 2','<p>Add your content here!</p>','basic',-3,'2021-06-09 18:20:38','2021-06-09 19:13:58',10,NULL,0),(50,'new-section-e5d6f2e9-22a5-4671-819c-618ef506dd0c','a','<p>esdrfgdsaw</p>','basic',3,'2021-06-11 17:34:09','2021-06-11 20:09:23',4,NULL,0),(51,'new-section-6be9fc94-1339-4d8c-b3ce-fc7c21f35158','b','<p>Add your content here!</p>','basic',0,'2021-06-11 17:35:40','2021-06-11 20:07:45',4,NULL,0),(52,'new-section-5b923803-c8b2-4b33-9d92-32a5bb1761e0','c','<p>Add your content here!</p>','basic',1,'2021-06-11 17:36:38','2021-06-11 20:09:21',4,NULL,0),(53,'134a0d7e-9968-458d-b3e3-1f611ce6eb12','New Section','<p>Add your content here!</p>','basic',2,'2021-06-11 18:49:27','2021-06-11 20:09:23',4,NULL,0),(54,'27ea897a-9a64-452e-97aa-122d0cc20589','New Section','<p>Add your content here!</p>','basic',0,'2021-06-11 18:50:19','2021-06-11 18:50:19',11,NULL,0),(55,'b8a0e963-085a-44f9-b44a-f30eccb4b61a','New Section','<p>Add your content here!</p>','basic',0,'2021-06-11 18:50:40','2021-06-11 18:50:40',12,NULL,0),(56,'e0571549-b099-4780-8346-dba125f88c6e','New Section','<p>Add your content here!</p>','basic',1,'2021-06-11 18:52:20','2021-06-11 18:52:20',12,NULL,0),(57,'31fb5f0d-05c6-4c4d-ac15-335321bef2f9','New Section','<p>Add your content here!</p>','basic',0,'2021-06-11 18:52:57','2021-06-11 18:52:57',13,NULL,0),(59,'f2214339-f9f2-40da-9973-90e3d59f01e4','New Section','<p>Add your content here!</p>','basic',0,'2021-06-11 19:20:55','2021-06-11 19:20:55',15,NULL,0),(60,'5b00906d-441f-4721-9358-65b71134feb1','New Section','<p>Add your content here!</p>','basic',0,'2021-06-14 22:53:03','2021-06-14 22:53:03',16,NULL,0),(66,'about','About','<p>BUILD/SF is a full-service construction firm, helping San Francisco and Bay Area residents re-en envision their homes to fit their individual needs. We are committed to proactive and detail-oriented project management, producing excellent work from home remodels and restoration projects to new kitchen and bathroom construction. Our collaborative approach allows us to familiarize ourselves with our clients wishes and enables us to advocate for homeowners from the pre-construction and permitting phases to the final inspection and finishing touches on a project. We work with select designers, architects and engineers to plan and create a design for homeowners which embodies their lifestyle. </p><p></p><p>We have the pleasure of working with the same experienced team of project managers and expert builders for 25 years. Working under the direction of Principal and Founder Simon Spark, our crew works seamlessly together to build beautiful high-end residential projects for our clients around San Francisco. We showcase highly-detailed work on our projects and we execute them on schedule, always remaining readily transparent on costs and our business practices. Our primary purpose is to help clients reinvent their homes to reflect their personal style while using our craftsmanship to bring functionality and purpose to the forefront. Communication, integrity, and aesthetics are the forces that drive us throughout our diverse portfolio of projects. We invite you to look at our projects for inspiration and we are happy to speak with you at any construction stage.</p>','basic',0,'2021-06-18 03:15:14','2021-09-04 00:08:02',18,'',1),(67,'process','Our Process','<p>We distinguish ourselves from other construction companies through our unparalleled craftsmanship, seamless and proactive project management, primary focus on client retention, and transparent communication and business practices. We use weekly cost projections to track our budget and ensure our projects are always on schedule and we meet with clients frequently to maintain a close relationships with them throughout the project and we continue to check on them long after our projects come to a close. We know that building trust is equally important to building houses, and we show our dedication to our clients, their vision and all those involved through action. We’re always available to our clients, designers, architects, engineers, and subcontractors throughout the duration of the project and we maintain direct supervision over all aspects of the construction process. </p><p>We produce whole house restorations and whole-house remodels. Our crews perform structural concrete work, framing, and finish carpentry. We have a sizable roster of reliable and highly proficient subcontractors. <br /></p><p></p><h3>Pre-Construction</h3><p>At the onset of a project we start by developing an initial project budget, refining its component scopes as details become available.  We solicit reliable competitive bids from eligible subcontractors and specialty contractors to ensure that most of the project is produced under fixed contracts so that the schedule and costs of the project are controlled. Most importantly, we make sure that our clients understand the cost implications and that they are aligned with the owner’s cost expectations. We provide Value Engineering (cost cutting suggestions) in the context of the design’s architectural intent.</p><p>If there are any unforeseen conditions which change the scope of work we schedule a budget approval meeting. Following a thorough meeting over the budget, we include all changes in scope or additional scope in a revised document and submit it to the Owner/s for approval. Once approved we adjust the budget and schedule according to any new conditions.</p><p>The project schedule will be developed based on the information gained from our senior supervisors, the project team, as well as input from our specialty subcontractors. The schedule is reviewed regularly and we notify our clients promptly of any changes made to the schedule before we distribute it to the entire project team, supervisors, crew members and any subcontractors it affects.</p><p></p><p>We advocate for collaboration and open communication throughout the project timeline between our clients and all stakeholders of the Project Team including the Architect/s, Interior Designer/s, Engineer/s, Outside Consultant/s, and Sub-Contractors. By working in concert with the Owner/s and their team, we realize economies of scale while advancing design intent, along with the Owner’s specific financial objectives. Individually tailored project teams are selected for every project, ensuring that we apply our best talent for the unique requirements of any project and the opportunity to excel that each project scope presents. </p><h3>Design Build Capability</h3><p>BUILD/SF also offers design build services to clients who are not already working with an architectural firm. Our associate designers are able to help our clients execute beautiful designs that engender the sentiment they wish to express in home renovation and design. We design with architectural intent, producing innovative work that is high end in quality. As a firm that can both express design and contracting work, we are careful to always bring in architects for larger scopes of work, and we always work with licensed interior designers to bring the client’s vision to full fruition. By working dually as a design build and contracting company, we are well aware of the design build process and our artistic capabilities are an asset that is welcomed by the designers, architects and engineers we work with. From our design build experience, our supervisors are attentive to small details and work closely with all team members to create the project designs flawlessly and with the intent of the designs. Our design build process is slightly different from our contracting process and we consult our clients on which one they should contract us for at the very beginning of their project’s review. </p><p>Well-schooled in architecture and Interiors, we lend our guidance where it will help most to move the process or the outcomes forward. We can design an entire remodel, add details to an already programmed project, or simply be of assistance whenever needed. As a design/build firm, we often partner with architects, engineers, and interior designers. Our aim is to provide value from the onset of the project, providing our expertise to the design team, spearheading preliminary concept development, programming, and design development. Because we will be the eventual contractor, our input to the project is strategic to the owner’s objectives, the designer’s vision, the project’s finances, and the property value.</p><h3>Construction + Site Management</h3><p>Our Project Managers are responsible for handling the flow of communications between the project team Client, Designer, Architect, Engineer, and the Site Superintendent. They maintain comprehensive documentation, initiate clarification of design and site conditions, artfully manage budgets and schedules, and reconcile costs. Project Managers conduct weekly site meetings with the Architect, Owner (or Owner Rep.) and the Site Superintendent to provide detailed updates on job progress. The weekly meetings provide an opportunity to discuss unresolved design, construction, schedule or budgetary issues.</p><p></p><p>Build SF’s Site Superintendents control and manage daily operations at the site. They, in conjunction with the Project Managers, determine the weekly production schedule, coordinate Subcontractors and manage our in-house crews. Their top responsibilities are to ensure timely and efficient construction practices and the highest level of quality achievable within the physical and financial constraints of the work.</p>','basic',1,'2021-06-18 03:18:58','2021-09-04 00:09:04',18,'',1),(68,'core-values','Core Values','<p><b>Excellence, craftsmanship, and collaboration are the building blocks of a successful project, and these are the principles by which we operate. </b></p><p>Our projects’ success is measured by our clients\' satisfaction, their experience with our company, and the immaculate rendering of their project’s design.</p><p>We bring a wealth of knowledge and experience to every project we’re contracted to build. From the initial design of a project to its impeccable realization, we stress the importance of creating excellence.</p><p>We employ a level of unparalleled craftsmanship to the designs drafted for our clients. Our team is held to the highest standards of residential building and the results are apparent in every regard. </p><p></p><p>We collaborate with all parties involved to bring our client’s vision forward during all stages of construction. It is essential that every person has the same understanding of how the designs work, function and look. With this mission we carry out construction as its design was intended. </p>','basic',2,'2021-06-18 03:23:23','2021-09-04 00:13:14',18,'',1),(72,'','All Projects','','projects',0,'2021-06-20 05:01:57','2021-07-29 19:25:28',8,'',0),(74,'','Slideshow','<p>Build/SF is a full service construction firm serving the San Francisco Bay Area.</p>','slideshow',0,'2021-06-21 17:06:56','2021-09-03 23:52:40',17,'223 224 231 140 130 121 94 95',0),(75,'','Contact Us','','contact',0,'2021-06-22 21:44:23','2021-07-30 19:36:55',19,'',0),(78,'architects','Architects','<h3>Simon Orchover</h3><p><b>Architect and Client, construction and design of his home and facade on Eureka Street.</b></p><p>\"I worked with Simon Spark on the remodeling of my house and facade. As an architect I was very amazed at his ability to masterfully execute the plans of my intricate designs. He did a spectacular job on the facade of my home. I was very happy with his execution of the project and I continue to enjoy the results.\"</p><p><img src=\"/storage/media/60eb588988e9d.jpg\" alt=\"\" class=\"image-fullwidth image-\" /></p><h3>Abraham Burickson<br /></h3><p><img src=\"/storage/media/60eca3330a732.jpg\" alt=\"\" class=\"image-fullwidth image-\" /></p>','basic',1,'2021-06-28 18:42:14','2021-08-18 22:06:45',14,'',1),(79,'designers','Designers','<h3>Caroline Brede</h3><p><b>Interior Designer</b></p><p>\"Simon has a deep understanding of architecture and construction. I\'ve worked with Simon on numerous projects and his attention to detail and ability to build beautiful projects astonishes. His work speaks volumes.\"</p><p><img src=\"/storage/media/60eca50d80d34.jpg\" alt=\"\" class=\"image-\" /></p>','basic',2,'2021-06-28 18:42:26','2021-09-01 21:40:19',14,'',1),(80,'homeowners','Homeowners','<h3>Annella Wynyard</h3><p><b>Client of 10+ years, construction and design of whole house remodel on Jackson Street, as well as various condos and rental units.</b></p><p>\"I\'ve been working with Build/SF and Simon Spark for 10 years on various projects. It\'s not always easy to find the right contractor. Simon is very approachable, and he\'s executed every project we\'ve had beautifully. At the start of a project, Simon really listens, then he takes on the job and executes it. He renovated and re-detailed our Edwardian family home in San Francisco, which was built in 1916. Simon has an attention to detail and an intimate knowledge of historical buildings that is really necessary for the projects we work on. This includes condos and different rental units along the years, mainly a lot of internal remodeling. On every project the continuity has been incredible. We always see and speak with the same crew, who are all trained very well.\"</p><p><img src=\"/storage/media/60ec8a382d35c_thumb.jpg\" alt=\"\" class=\"image-fullwidth image-center\" /></p><h3>Jason Gerlach</h3><p><b>Client and homeowner of the Gerlach Residence, design build renovation of bedroom and bathroom.</b></p><p>\"They did things when they said they were going to do them and they were very responsive when we had issues. Renovations should not be pursued without serious consideration. If you are going to do it, you want someone like Simon and his dedicated crew at BUILD/SF. The final product was beautiful, the new bedroom and bathroom are gorgeous.\"</p><p><img src=\"/storage/media/60eca6a90fab6.jpg\" alt=\"\" class=\"image-fullwidth image-\" /></p><h3>Micci Toliver</h3><p><b>Client of the Garber Stair and Deck project.</b></p><p>\"Simon did outstanding work! The job was a 3-Tier Deck. The main deck was a second story with a landing and patio deck added. They made our job affordable and the communication was just great. They are wonderful craftsman, great skills, very polite and pleasant to work with. We are very happy with the results. We will always use and refer BUILD SF.\"</p><h3>Tracy Hogan</h3><p><b>Client and homeowner of the Hogan Residence, design build renovation of bedroom and bathroom.</b></p><p>\"I could not be more pleased. I didn’t ever feel like I was being taken advantage of, or get the sense that things were inflated. The prices were right in line with what I expected them to be. The quality of work and the attention to detail far surpassed my expectations. The Project Manager did not let anything get by. We lived in the house during the renovation and I felt very taken care of.\"</p><p><img src=\"/storage/media/60ec81227d958.jpg\" alt=\"\" class=\"image-fullwidth image-\" /><br /></p><h3>Kip Daggett Howard</h3><p><b>Client and homeowner of the Fulton Street project, design build renovation of bedroom and bathroom.</b></p><p>\"They did things when they said they were going to do them and they were very responsive when we had issues. Renovations should not be pursued without serious consideration. If you are going to do it, you want someone like Simon and his dedicated crew at BUILD/SF. The final product was beautiful, the new bedroom and bathroom are gorgeous.\"</p><p><img src=\"/storage/media/60eb606120813.jpg\" alt=\"\" class=\"image-fullwidth image-\" /><br /></p><h3>Kim Jordan</h3><p><b>Client, whole house remodel on project name.</b></p><p>\"The work was done very professionally and I was quite amazed at how quickly and neatly the assignment was completed. In addition to the quality of the work, I was very happy with the way the staff conducted themselves during the project. I would recommend their services to anyone who wants a skilled job completed by professional gentleman.\"</p><p><img src=\"https://buildsf.camilledavis.com/storage/media/60eb5d6d8687d.jpg\" alt=\"\" class=\"image-fullwidth image-\" /><br /></p>','basic',0,'2021-06-28 18:48:47','2021-09-03 23:51:45',14,'',1),(81,'program','Design & Building Community Affiliate Program','<p><b>Build/SF</b> presents the <b>Design &amp; Building Community Affiliate Program </b></p><p>Referred to as the BSF Affiliate Program, and our members are referred to as BSF Affiliates. Our goal still remains the same, to connect the best in the industry to one another so we can discuss projects, new demands in the industry, and how to approach new adversity that keeps us from being our best. The “Community” in Design &amp; Build Community Affiliate program is no design flaw on our part, we are a collaborative program based on the principles of networking, connecting, and bringing the best service possible to our clients.<br /><br /></p><p><img src=\"/storage/media/60fb06486da2b.jpg\" alt=\"\" class=\"image-fullwidth image-center\" /></p><h3>Overview</h3><p>BUILD/SF is an experienced construction firm with a fully integrated team of expert builders. We partner with renown architects spanning from Simon Orchover, Abraham Burickson, Ernie Selander, and Pencil Box Architects, Kyle Brunel and Fumiko and interior designers like Caroline Brede who brings her Scandinavian touch to all her work while continuing to modernize to create innovative, long lasting designs. </p><p><b>We Honor Our Members of BSF Community Affiliate Program.</b></p><p>The BSF Affiliate Program offers designers, architects, niche artisan subcontractors, decorators, and artisan craftsmanship stores to envision a better SF. Build/SF is a construction firm with design build capabilities. Our experience constructing a diverse collection of projects (view the full spectrum of our capabilities in our portfolio) has imbued us with the ability to see the details in design instruction and architectural planning that too often contractors miss. We see simple design solutions where others see problems. Thus we want to bring together the best of the best in the design and build community.</p><h3>Goals</h3><ol><li>The wonderful aspect about this program is that it is founded on the principles of community building and strengthening.</li><li>The Design &amp; Build Community Affiliate program strives to form a base for communication; Our BSF Affiliates can connect to one another through forums and meetings through a coded link to our website.</li><li>Our intention is to help industry professionals connect to one another and to us. Through our networking we hope to build a better San Francisco as professionals in residential home renovation and remodeling.</li><li>Our ultimate goal is to create a community of diverse building and design professionals, each affiliate bringing their unique approach from various backgrounds. We believe this way we can find the right industry professionals for a specific project with reassurance. This program is a reflection of how we work with our clients, we believe that by creating a transparent affiliation we can better represent our clients needs and desires. </li></ol><h3>Specifications</h3><p>To apply to our program you must be in the business of remodeling or renovation. We consider a broad spectrum of applicants. If you are interested in joining our program, see our requirements, which detail who can apply and what our expectations from our BSF Affiliates are in return for our advertisement placement and networking service.</p><p><b>Requirements</b></p><p>Types of businesses we welcome to join our affiliate program:</p><ul><li>Architects </li><li>Interior Designers</li><li>Interior Decorators</li><li>Building Sub-Contractors</li><li>Specialty Artists &amp; Subcontractors (glass art, wood work, textiles, decorative painters, handcrafted wallpaper, metal work, sculptors, artisan tiles)</li><li>Home decor boutique stores</li><li>Home Organizing Services</li></ul><h3>Milestones</h3><ol><li><b>The Program</b><br />Cross-promotion is our biggest commitment to you. We are established contractors and we want to show our clients the depth of our organization as well as the wonderful partners and affiliates we work with everyday to execute a project well.</li><li><b>The Platform</b><br />We have an exclusive platform on Facebook for our Affiliation of industry designers and leaders to talk and create lasting relationships with trusted professionals we have vetted and worked with. </li></ol><h3>Reasons to Join the BSF Community</h3><ul><li>Our affiliate program</li><li>Partnerships</li><li>Industry member leaders</li><li>Teambuilding &amp; relationships</li></ul><p>We partner with design leaders and craftspeople like eindustry experienced and top rated cabinet makers as well as artisan workers. We build relationships across the industry with experts, creating cross-cultural experiences around the board. We have a wide spectrum of designers and subcontractors we work with in order to establish our presence and make yours more prominent as well.</p><ol><li>BUILD/SF’S affiliate program provides businesses the opportunity to collaborate with us in new and innovative ways. The purpose of our program is to promote community growth in the design industry.</li><li>We are building stronger relationships than ever before, making an inclusive platform for all our affiliates to benefit from. </li><li>Our affiliate program allows new kinds of businesses to work with us on both new and unconventional marketing tactics, promoting mutual benefits. We are strongly committed to cross-promotion and believe in the benefit it serves both parties. We will promote you as our Affiliates on our homepage, using your logo and a link to your website’s URL, and we’re open to more extensive affiliate marketing as long as it’s mutually beneficial, supportive to the needs of all those involved and helpful to our clients.</li><li>The BSF Affiliation unlocks the unlimited potential design-oriented businesses have by allowing everyone to be community leaders in their respective fields.</li><li>By joining the BSF Affiliate program you’re one step away from unlocking your potential in the art and design market. We’re not just building strong relationships with our affiliates, we’re creating a platform for those selected to become leaders in the design community. There are varying degrees of commitment a business can make in joining. While our main offer is cross promotion and mutual marketing, we are also giving you the opportunity to use us as an outreach network.</li><li>BUILD/SF is building a bridge to connect all professions and professionals in the high-end residential remodeling and building industry to San Francisco’s flourishing art+design, building and contracting, as well as development community. Come join our program, bring your ideas, and let’s thrive together. </li></ol>','sheet',0,'2021-07-09 17:44:07','2021-07-24 19:56:16',20,'',0),(82,'current','Current Affiliates','<p>We proudly work in Affiliation with these prominent Architects and Designers:</p><p><br /></p><p><img src=\"/storage/media/60e89d9e15496.png\" alt=\"\" class=\"image-small image-inline\" /></p><p>Abraham Burickson – Architect and Professor at the Academy of Art for Architecture and Writing<br /></p><p>Website: <a href=\"https://www.longarchitectureproject.com\">www.longarchitectureproject.com</a><br /></p><p>More information: <a href=\"https://architecture.academyart.edu/portfolio-item/abraham-burickson/\">architecture.academyart.edu/portfolio-item/abraham-burickson</a></p><p><br /></p><p><img src=\"/storage/media/60e89d9e1abb1.png\" alt=\"\" class=\"image-small image-inline\" /></p><p>Kyle Brunel, AIA, LEED AP BD+C</p><p>Fumiko Docker, AIA, LEED AP BD+C, WELL AP</p><p>Website: <a href=\"https://www.pencilboxarchitects.com/\">www.pencilboxarchitects.com</a></p><p><br /></p><p><img src=\"/storage/media/60e89d9e038a2.png\" alt=\"\" class=\"image-small image-inline\" /></p><p>Kimberley Harrison – Interior Designer<br /></p><p>Website: <a href=\"https://www.kimberleyharrison.com\">www.kimberleyharrison.com</a></p><p><br /></p><p><img src=\"/storage/media/60e8b8a8c3f79.png\" alt=\"\" class=\"image-small image-inline\" /></p><p>Ryan Knock – Knock A+D, Architecture and Design</p><p>Website: <a href=\"http://www.knock-ad.com\">www.knock-ad.com</a></p>','basic',1,'2021-07-09 18:05:57','2021-07-24 19:57:26',20,'',0),(84,'4faa8e6d-bbd3-4c22-b589-349b18eb18d8','New Section','<p>Add your content here!</p>','basic',0,'2021-07-14 20:01:04','2021-07-14 20:01:04',21,NULL,0),(88,'d08542ec-a828-4f28-92ae-5554a91858dd','New Section','<p>Add your content here!</p>','basic',0,'2021-07-26 19:29:40','2021-07-26 19:29:40',22,NULL,0),(89,'af2d4bcc-7c81-41cc-af5b-3a3cad036cf3','New Section','<p>Add your content here!</p>','basic',0,'2021-07-30 22:44:38','2021-07-30 22:44:38',23,NULL,0),(90,'5ac64f7e-7922-4dc0-8349-51fd8c36f94f','New Section','<p>Add your content here!</p>','basic',0,'2021-07-31 20:53:34','2021-07-31 20:53:34',24,NULL,0),(91,'1448ab12-3a6d-49da-8412-2b2828196cf3','New Section','<p>Add your content here!</p>','basic',0,'2021-07-31 20:58:06','2021-07-31 20:58:06',25,NULL,0),(92,'f0632b9d-60ea-4e82-a9a3-a4a4aca03100','New Section','<p>Add your content here!</p>','basic',0,'2021-07-31 20:59:48','2021-07-31 20:59:48',26,NULL,0),(93,'b1cf8237-1129-467c-a4b5-9539daff2d53','New Section','<p>Add your content here!</p>','basic',0,'2021-08-17 21:32:53','2021-08-17 21:32:53',27,NULL,0);
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('3nwA6pz1g943hWm2YsHlmdvWTxAWGGT4h1xRVcot',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:124.0) Gecko/20100101 Firefox/124.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0xRTVFFZ2FwenhnNVlYcEJ1TUFTdkxOT0lYQUhDcHhlYUN3UWhTbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1712556005),('9ksPWKMS5eFsTPSDe71t7FA97jYq0vOn4mkBEvjh',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:124.0) Gecko/20100101 Firefox/124.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRE9ibkhmeHBJV240bzJ4dEFzR1NTa1FBNHZBajBHZFB3OUlaVDV2WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1712553724),('UpgXMwPwn49OgDGJj6Pehsdw9uYQsTfsOnJTzmoz',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:124.0) Gecko/20100101 Firefox/124.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlBIUllEN0psV1JiRUNOUkVrcjFWY0d5ZUI1TEJqbXpMQUw2UUNnZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=',1712560422);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_ads` tinyint(1) NOT NULL DEFAULT '0',
  `google_ads_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_ads_slot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_analytics` tinyint(1) NOT NULL DEFAULT '0',
  `tracking_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_social_in_nav` tinyint(1) NOT NULL DEFAULT '0',
  `social_twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `projects` tinyint(1) NOT NULL DEFAULT '0',
  `esoteric_social` tinyint(1) NOT NULL DEFAULT '0',
  `social_houzz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_pinterest` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_js` tinyint(1) NOT NULL DEFAULT '0',
  `nav_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pages',
  `transparent_nav` tinyint(1) NOT NULL DEFAULT '0',
  `layout` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_bandcamp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_youtube` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sendinblue_form` tinyint(1) NOT NULL DEFAULT '0',
  `sendinblue_action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('Build/SF','/storage/media/60e8b8b61cec5_thumb.png','simon@buildsf.com','Build/SF is a design build construction firm serving San Francisco.',1,'2021-03-24 19:11:56','2022-04-18 18:30:07',0,'','',1,'G-ZPR68NS0RS',1,'','build.sf.better','simon-spark-28225a40','light',1,1,'professionals/general-contractors/build-sf™-pfvwus-pf~2013837979?','buildsfconstruction','buildsfinc',1,'pages',0,NULL,'','','',NULL,1,'https://ecf797b7.sibforms.com/serve/MUIEAHjxj1MN4x7z_Xt5YrNRuU6JQcHIoIwnAe812RQou4STfKTY458ftaxD8sDmz04Fj00Q1efuOm0156Bxuf2IfSxM_80kVUzlfyMN3OCba8Rp2VYQOnhUuXdBjeiZjkISwkmBS7_AsoA45vXAq6KEFaIgAk1J4CQ4g5AVGO1m10olfrhJBDYMlERsE-K1qLi0sGy4XI-n0dJK');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'test_user','test@test.com','Test User','$2y$12$DVAR8S54c0AejeNw391pReesrurU0XnzRUcp5Pl1Uoo5zToSDEg1u',NULL,NULL,'2024-04-08 14:13:34','2024-04-08 14:13:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-08  0:14:00
