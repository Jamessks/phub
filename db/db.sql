-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: phub
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `aliases`
--

DROP TABLE IF EXISTS `aliases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aliases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) DEFAULT NULL,
  `pornstar_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aliases_unique` (`pornstar_id`),
  KEY `pornstar_id` (`pornstar_id`),
  CONSTRAINT `aliases_ibfk_1` FOREIGN KEY (`pornstar_id`) REFERENCES `pornstars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123983 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aliases`
--

LOCK TABLES `aliases` WRITE;
/*!40000 ALTER TABLE `aliases` DISABLE KEYS */;
/*!40000 ALTER TABLE `aliases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hairColor` varchar(50) DEFAULT NULL,
  `ethnicity` varchar(50) DEFAULT NULL,
  `tattoos` tinyint(1) DEFAULT NULL,
  `piercings` tinyint(1) DEFAULT NULL,
  `breastSize` int DEFAULT NULL,
  `breastType` varchar(10) DEFAULT NULL,
  `gender` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `orientation` varchar(50) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `pornstar_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attributes_unique` (`pornstar_id`),
  KEY `pornstar_id` (`pornstar_id`),
  CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`pornstar_id`) REFERENCES `pornstars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=78143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attributes`
--

LOCK TABLES `attributes` WRITE;
/*!40000 ALTER TABLE `attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pornstars`
--

DROP TABLE IF EXISTS `pornstars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pornstars` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `license` varchar(50) NOT NULL,
  `wlStatus` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pornstars`
--

LOCK TABLES `pornstars` WRITE;
/*!40000 ALTER TABLE `pornstars` DISABLE KEYS */;
/*!40000 ALTER TABLE `pornstars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subscriptions` int DEFAULT NULL,
  `monthlySearches` int DEFAULT NULL,
  `views` int DEFAULT NULL,
  `videosCount` int DEFAULT NULL,
  `premiumVideosCount` int DEFAULT NULL,
  `whiteLabelVideoCount` int DEFAULT NULL,
  `rank_value` int DEFAULT NULL,
  `rankPremium` int DEFAULT NULL,
  `rankWl` int DEFAULT NULL,
  `pornstar_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stats_unique` (`pornstar_id`),
  KEY `pornstar_id` (`pornstar_id`),
  CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`pornstar_id`) REFERENCES `pornstars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77868 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thumbnails`
--

DROP TABLE IF EXISTS `thumbnails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thumbnails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `height` int DEFAULT NULL,
  `width` int DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `urls` varchar(255) DEFAULT NULL,
  `pornstar_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `thumbnails_unique` (`pornstar_id`),
  KEY `pornstar_id` (`pornstar_id`),
  CONSTRAINT `thumbnails_ibfk_1` FOREIGN KEY (`pornstar_id`) REFERENCES `pornstars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10247 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thumbnails`
--

LOCK TABLES `thumbnails` WRITE;
/*!40000 ALTER TABLE `thumbnails` DISABLE KEYS */;
/*!40000 ALTER TABLE `thumbnails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'phub'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-26  3:00:26
