CREATE DATABASE  IF NOT EXISTS `pedidos-online` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pedidos-online`;
-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: pedidos-online
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `senha` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),(4,'Carla','8cb2237d0679ca88db6464eac60da96345513964');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compras` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preço` int(10) NOT NULL,
  `quantidade` int(10) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico`
--

DROP TABLE IF EXISTS `historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `pedido` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico`
--

LOCK TABLES `historico` WRITE;
/*!40000 ALTER TABLE `historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensagem`
--

DROP TABLE IF EXISTS `mensagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensagem` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contacto` varchar(12) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensagem`
--

LOCK TABLES `mensagem` WRITE;
/*!40000 ALTER TABLE `mensagem` DISABLE KEYS */;
INSERT INTO `mensagem` VALUES (4,1,'Ramazani Antonio','willscottking@gmail.com','942145095','Bom dia'),(5,1,'Ramazani Antonio','willscottking@gmail.com','942145095','triste');
/*!40000 ALTER TABLE `mensagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motoboy`
--

DROP TABLE IF EXISTS `motoboy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motoboy` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `nome` varchar(255) NOT NULL DEFAULT 'Motoboy',
  `disponivel` varchar(255) DEFAULT 'true',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motoboy`
--

LOCK TABLES `motoboy` WRITE;
/*!40000 ALTER TABLE `motoboy` DISABLE KEYS */;
INSERT INTO `motoboy` VALUES (1,'motoboy001@gmail.com','123','Motoboy','true');
/*!40000 ALTER TABLE `motoboy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos` (
  `id` varchar(255) NOT NULL,
  `user_id` int(100) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `contacto` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `endereço` varchar(500) NOT NULL,
  `total_produtos` text NOT NULL,
  `total_preço` int(100) NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `estado_pagamento` varchar(20) NOT NULL DEFAULT '1',
  `confirmacao_cliente` varchar(20) DEFAULT 'false',
  `confirmacao_motoboy` varchar(20) DEFAULT 'false',
  `motoboy_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES ('0a102c0b-2cfa-4a27-9e5a-e53f6e6913ae',199270,'Domingos Nkula Pedro','944895118','novoemail29102001@gmail.com','Paypal','Cazenga, Luanda, Angola','[{\"pedido\":{\"id_compra\":\"da982c54-ae8f-4e05-85fc-65a3db7f534a\",\"nome\":\"Banana\",\"qntd\":29,\"preco\":200,\"subtotal\":5800}},{\"pedido\":{\"id_compra\":\"a6a08ec0-bbcf-49fd-89dd-2e8e1d5cf462\",\"nome\":\"Peixe\",\"qntd\":5,\"preco\":500,\"subtotal\":2500}}]',8300,'2023-05-29','3','true','true',NULL),('4f75e213-2ba1-4074-88f3-1e2b08cb056c',199270,'Domingos Nkula Pedro','944895118','novoemail29102001@gmail.com','dinheiro na entrega','Cazenga, Luanda, Angola','[{\"pedido\":{\"id_compra\":\"da982c54-ae8f-4e05-85fc-65a3db7f534a\",\"nome\":\"Banana\",\"qntd\":20,\"preco\":200,\"subtotal\":4000}},{\"pedido\":{\"id_compra\":\"a6a08ec0-bbcf-49fd-89dd-2e8e1d5cf462\",\"nome\":\"Peixe\",\"qntd\":3,\"preco\":500,\"subtotal\":1500}}]',5500,'2023-05-29','1','false','false',NULL),('5b3429f0-77a3-4301-8944-2467fc0fe172',199270,'Domingos Nkula Pedro','944895118','novoemail29102001@gmail.com','dinheiro na entrega','Cazenga, Luanda, Angola','[{\"pedido\":{\"id_compra\":\"a6a08ec0-bbcf-49fd-89dd-2e8e1d5cf462\",\"nome\":\"Peixe\",\"qntd\":2,\"preco\":500,\"subtotal\":1000}},{\"pedido\":{\"id_compra\":\"da982c54-ae8f-4e05-85fc-65a3db7f534a\",\"nome\":\"Banana\",\"qntd\":1,\"preco\":200,\"subtotal\":200}}]',1200,'2023-05-30','1','false','false',NULL);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtos` (
  `id` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `preço` int(10) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `disponivel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES ('a6a08ec0-bbcf-49fd-89dd-2e8e1d5cf462','Peixe','comida',500,'descarregar.jfif',0),('da982c54-ae8f-4e05-85fc-65a3db7f534a','Banana','comida',200,'bananas-1119790_1920.jpg',0);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` varchar(200) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contacto` varchar(10) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `endereço` varchar(500) NOT NULL,
  `cod_recuperar_senha` varchar(255) DEFAULT NULL,
  `acesso` int(1) DEFAULT 3,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('199270ed-7aee-4607-b36a-a9a0b89bf952','Domingos Nkula Pedro','novoemail29102001@gmail.com','944895118','39dfa55283318d31afe5a3ff4a0e3253e2045e43','Cazenga, Luanda, Angola','471664',3);
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

-- Dump completed on 2023-06-11 14:27:14
