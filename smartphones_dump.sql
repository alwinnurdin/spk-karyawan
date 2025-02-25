-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: hp
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.24.04.1

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
-- Table structure for table `smartphones`
--

DROP TABLE IF EXISTS `smartphones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `smartphones` (
  `id_hp` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `prosesor` varchar(255) DEFAULT NULL,
  `memori` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `kamera` varchar(255) DEFAULT NULL,
  `resolusi` varchar(255) DEFAULT NULL,
  `baterai` varchar(255) DEFAULT NULL,
  `prosesor_n` int DEFAULT NULL,
  `resolusi_n` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `harga_n` varchar(255) DEFAULT NULL,
  `memori_n` varchar(255) DEFAULT NULL,
  `ram_n` varchar(255) DEFAULT NULL,
  `kamera_n` varchar(255) DEFAULT NULL,
  `baterai_n` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_hp`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smartphones`
--

LOCK TABLES `smartphones` WRITE;
/*!40000 ALTER TABLE `smartphones` DISABLE KEYS */;
INSERT INTO `smartphones` VALUES (67,'Realme C15','1900000','DualCore','64','4','8','Full HD','5000 - 6000',1,3,'2024-11-24 19:20:00','2024-11-24 19:20:00','3','4','3','1','5'),(68,'Realme C20','2200000','DualCore','32','2','8','Full HD','4000 - 5000',1,3,'2024-11-24 19:21:00','2024-11-24 19:21:00','2','3','1','1','4'),(69,'Realme C25','1499000','DualCore','64','4','28','Full HD','5000 - 6000',1,3,'2024-11-24 19:21:48','2024-11-24 19:21:48','4','4','3','3','5'),(70,'Oppo A16K','1400000','QuadCore','32','4','13','Full HD','4000 - 5000',2,3,'2024-11-24 19:23:18','2024-11-24 19:23:18','4','3','3','2','4'),(72,'Oppo A54','900000','QuadCore','64','6','13','Full HD','4000 - 5000',2,3,'2024-11-24 19:26:19','2024-11-24 19:26:19','5','4','4','2','4'),(73,'Oppo A57','1300000','QuadCore','64','4','13','Full HD','5000 - 6000',2,3,'2024-11-24 19:27:20','2024-11-24 19:27:20','4','4','3','2','5'),(74,'Samsung Galaxy A03 Core','2300000','HexaCore','32','2','8','HD+','5000 - 6000',3,2,'2024-11-24 19:28:50','2024-11-24 19:28:50','2','3','1','1','5'),(75,'Samsung Galaxy A13','800000','HexaCore','32','6','50','HD+','5000 - 6000',3,2,'2024-11-24 19:30:02','2024-11-24 19:30:02','5','3','4','5','5'),(76,'Samsung Galaxy A04S','1200000','HexaCore','32','4','48','HD+','4000 - 5000',3,2,'2024-11-24 19:31:02','2024-11-24 19:31:02','4','3','3','4','4'),(77,'Vivo Y21S','980000','OctaCore','64','4','48','Full HD','4000 - 5000',4,3,'2024-11-24 19:32:06','2024-11-24 19:32:06','5','4','3','4','4'),(78,'Vivo Y21A','1100000','OctaCore','32','4','13','Full HD','4000 - 5000',4,3,'2024-11-24 19:32:58','2024-11-24 19:32:58','4','3','3','2','4'),(79,'Vivo Y22','975000','OctaCore','128','6','48','Full HD','4000 - 5000',4,3,'2024-11-24 19:33:57','2024-11-24 19:33:57','5','5','4','4','4'),(93,'ass','123','QuadCore','128','4','13','4K','2000 - 3000',2,5,'2024-12-20 16:23:26','2024-12-20 16:23:26','-1','5','3','2','2'),(94,'ass','123','DualCore','32','3','8','Full HD','1000 - 2000',1,3,'2024-12-20 16:55:22','2024-12-20 16:55:22','-1','3','2','1','1');
/*!40000 ALTER TABLE `smartphones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-06 18:29:25
