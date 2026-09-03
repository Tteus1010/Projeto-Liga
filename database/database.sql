CREATE DATABASE  IF NOT EXISTS `db_projliga` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_projliga`;
-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_projliga
-- ------------------------------------------------------
-- Server version	8.4.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cardgame`
--

DROP TABLE IF EXISTS `cardgame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cardgame` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_cardgame_nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cardgame`
--

LOCK TABLES `cardgame` WRITE;
/*!40000 ALTER TABLE `cardgame` DISABLE KEYS */;
INSERT INTO `cardgame` VALUES (1,'Magic: The Gathering'),(3,'Pokémon'),(4,'Yu-Gi-Oh!');
/*!40000 ALTER TABLE `cardgame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edicao`
--

DROP TABLE IF EXISTS `edicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cardgame` int DEFAULT NULL,
  `id_edicao` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_edicao_cardgame_id` (`cardgame`,`id_edicao`),
  CONSTRAINT `fk_edicao_cardgame` FOREIGN KEY (`cardgame`) REFERENCES `cardgame` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edicao`
--

LOCK TABLES `edicao` WRITE;
/*!40000 ALTER TABLE `edicao` DISABLE KEYS */;
INSERT INTO `edicao` VALUES (1,'Dominaria',1,'dom'),(2,'War of the Spark',1,'war'),(3,'Throne of Eldraine',1,'eld'),(4,'The Hobbit',1,'hob'),(5,'Marvel Super Heroes',1,'msh'),(6,'Base Set',3,'base1'),(7,'Sword & Shield',3,'swsh1'),(8,'Scarlet & Violet',3,'sv1'),(9,'30th Celebration',3,'30c'),(10,'Chaos Rising',3,'cri'),(11,'Legend of Blue Eyes White Dragon',4,'lob'),(12,'Metal Raiders',4,'mrd'),(13,'Starter Deck: Yugi',4,'sdy'),(14,'Rise of the Duelist',4,'rotd'),(15,'Blazing Dominion',4,'blzd');
/*!40000 ALTER TABLE `edicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `nome_port` varchar(255) DEFAULT NULL,
  `cardgame` int NOT NULL,
  `edicao` int DEFAULT NULL,
  `imagem` varchar(500) DEFAULT NULL,
  `raridade` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produto_cardgame` (`cardgame`),
  KEY `fk_produto_edicao` (`edicao`),
  CONSTRAINT `fk_produto_cardgame` FOREIGN KEY (`cardgame`) REFERENCES `cardgame` (`id`),
  CONSTRAINT `fk_produto_edicao` FOREIGN KEY (`edicao`) REFERENCES `edicao` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,'Jinzo','Jinzo',4,13,'7e27202215ef4d2cf09cc357868480b9.webp','comum'),(4,'Black Chaos','Caos das Trevas',4,14,'b9aeb0142df797e27a11a9ff130eaaf2.jpg','comum');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuario_usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Administrador','admin','$2y$12$qQKu2mjjlfyB7w1Y0u/Y3eVf8ax5nWk5TByEu4JUkogYn.r7dzCBO',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-03  3:35:36
