-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bd_safe
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apartamento`
--

DROP TABLE IF EXISTS `apartamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apartamento` (
  `apartamento_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `propietario_id` int(10) unsigned NOT NULL,
  `numero_apartamento` int(200) DEFAULT NULL,
  PRIMARY KEY (`apartamento_id`),
  KEY `propietario_id` (`propietario_id`),
  CONSTRAINT `apartamento_ibfk_1` FOREIGN KEY (`propietario_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartamento`
--

LOCK TABLES `apartamento` WRITE;
/*!40000 ALTER TABLE `apartamento` DISABLE KEYS */;
INSERT INTO `apartamento` VALUES (3,20,NULL);
/*!40000 ALTER TABLE `apartamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autorizacion`
--

DROP TABLE IF EXISTS `autorizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorizacion` (
  `autorizacion_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `propietario_id` int(10) unsigned NOT NULL,
  `nombre_visitante` varchar(100) NOT NULL,
  `apellidos_visitante` varchar(100) NOT NULL,
  `cedula_visitante` varchar(20) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `tipo_autorizacion` enum('visitante','contratista') NOT NULL,
  `permanente` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`autorizacion_id`),
  KEY `propietario_id` (`propietario_id`),
  CONSTRAINT `autorizacion_ibfk_1` FOREIGN KEY (`propietario_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autorizacion`
--

LOCK TABLES `autorizacion` WRITE;
/*!40000 ALTER TABLE `autorizacion` DISABLE KEYS */;
INSERT INTO `autorizacion` VALUES (3,20,'Andres','Rodriguez','698745','2024-08-07','2024-08-15','visitante',0),(7,23,'Pedro','Gomez Hernandez','12354689','2024-08-07','2024-08-20','visitante',0),(8,24,'Sofia','Hernandez Garzon','123547','2024-09-04','2024-09-05','visitante',0),(9,20,'Andres','Rodriguez','698745','2024-08-07','2024-08-15','visitante',0);
/*!40000 ALTER TABLE `autorizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingreso`
--

DROP TABLE IF EXISTS `ingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingreso` (
  `ingreso_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guarda_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `tipo_ingreso` enum('Propietario','Autorizado','Visitante') NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `cedula` varchar(150) DEFAULT NULL,
  `parqueadero_id` int(10) unsigned DEFAULT NULL,
  `vehiculo` tinyint(1) NOT NULL,
  `fecha_hora_ingreso` datetime NOT NULL,
  PRIMARY KEY (`ingreso_id`),
  UNIQUE KEY `cedula` (`cedula`),
  KEY `guarda_id` (`guarda_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `parqueadero_id` (`parqueadero_id`),
  CONSTRAINT `ingreso_ibfk_1` FOREIGN KEY (`guarda_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ingreso_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ingreso_ibfk_3` FOREIGN KEY (`parqueadero_id`) REFERENCES `parqueadero` (`parqueadero_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingreso`
--

LOCK TABLES `ingreso` WRITE;
/*!40000 ALTER TABLE `ingreso` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingreso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimientos` (
  `movimiento_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL,
  `guarda_id` int(10) unsigned NOT NULL,
  `tipo_movimiento` enum('Ingreso','Salida') NOT NULL,
  `tipo_ingreso` enum('Propietario','Autorizado','Visitante') NOT NULL,
  `parqueadero_id` int(10) unsigned DEFAULT NULL,
  `vehiculo` tinyint(1) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`movimiento_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `guarda_id` (`guarda_id`),
  KEY `parqueadero_id` (`parqueadero_id`),
  CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`guarda_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `movimientos_ibfk_3` FOREIGN KEY (`parqueadero_id`) REFERENCES `parqueadero` (`parqueadero_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimientos`
--

LOCK TABLES `movimientos` WRITE;
/*!40000 ALTER TABLE `movimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parqueadero`
--

DROP TABLE IF EXISTS `parqueadero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parqueadero` (
  `parqueadero_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  PRIMARY KEY (`parqueadero_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parqueadero`
--

LOCK TABLES `parqueadero` WRITE;
/*!40000 ALTER TABLE `parqueadero` DISABLE KEYS */;
INSERT INTO `parqueadero` VALUES (1,'P1',1),(2,'P2',0),(3,'P3',1),(4,'P4',0),(5,'P5',1);
/*!40000 ALTER TABLE `parqueadero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propietarios`
--

DROP TABLE IF EXISTS `propietarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propietarios` (
  `propietario_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datos_propietario` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_propietario`)),
  PRIMARY KEY (`propietario_id`),
  CONSTRAINT `propietarios_ibfk_1` FOREIGN KEY (`propietario_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propietarios`
--

LOCK TABLES `propietarios` WRITE;
/*!40000 ALTER TABLE `propietarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `propietarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_ingreso_peatonal`
--

DROP TABLE IF EXISTS `registro_ingreso_peatonal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_ingreso_peatonal` (
  `ingreso_peatonal_id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `cedula` bigint(20) NOT NULL,
  `tipo_ingreso` enum('propietario','contratista','visitante') NOT NULL,
  `apartamento_id` int(10) unsigned NOT NULL,
  `observaciones` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ingreso_peatonal_id`),
  KEY `apartamento_id` (`apartamento_id`),
  CONSTRAINT `registro_ingreso_peatonal_ibfk_1` FOREIGN KEY (`apartamento_id`) REFERENCES `apartamento` (`apartamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_ingreso_peatonal`
--

LOCK TABLES `registro_ingreso_peatonal` WRITE;
/*!40000 ALTER TABLE `registro_ingreso_peatonal` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_ingreso_peatonal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_ingreso_vehicular`
--

DROP TABLE IF EXISTS `registro_ingreso_vehicular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_ingreso_vehicular` (
  `ingreso_vehicular_id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `cedula` bigint(20) NOT NULL,
  `tipo_ingeso` enum('propietario','contratista','visitante') NOT NULL,
  `tipo_vehiculo` enum('bicicleta','automovil') NOT NULL,
  `apartamento_id` int(10) unsigned NOT NULL,
  `observaciones` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ingreso_vehicular_id`),
  KEY `apartamento_id` (`apartamento_id`),
  CONSTRAINT `registro_ingreso_vehicular_ibfk_1` FOREIGN KEY (`apartamento_id`) REFERENCES `apartamento` (`apartamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_ingreso_vehicular`
--

LOCK TABLES `registro_ingreso_vehicular` WRITE;
/*!40000 ALTER TABLE `registro_ingreso_vehicular` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_ingreso_vehicular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salida`
--

DROP TABLE IF EXISTS `salida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salida` (
  `salida_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ingreso_id` int(10) unsigned NOT NULL,
  `fecha_hora_salida` datetime NOT NULL,
  `guarda_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`salida_id`),
  KEY `ingreso_id` (`ingreso_id`),
  KEY `guarda_id` (`guarda_id`),
  CONSTRAINT `salida_ibfk_1` FOREIGN KEY (`ingreso_id`) REFERENCES `ingreso` (`ingreso_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `salida_ibfk_2` FOREIGN KEY (`guarda_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salida`
--

LOCK TABLES `salida` WRITE;
/*!40000 ALTER TABLE `salida` DISABLE KEYS */;
/*!40000 ALTER TABLE `salida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `apellidos` int(11) DEFAULT NULL,
  `cedula` varchar(150) DEFAULT NULL,
  `perfil` enum('Propietario','Administrador','Guarda') NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `apartamento_id` int(10) unsigned DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `cedula` (`cedula`),
  UNIQUE KEY `email` (`email`),
  KEY `apartamento_id` (`apartamento_id`),
  CONSTRAINT `apartamento_id` FOREIGN KEY (`apartamento_id`) REFERENCES `apartamento` (`apartamento_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (20,'Juan ',0,'123456','Propietario',31555555,NULL,'esdee@gmail.com','asd123','2024-09-11 18:30:53'),(21,'Maria ',0,'456987','Guarda',325555555,NULL,'mariads@gmail.com','pass98745','2024-09-11 18:30:53'),(22,'Carlos ',0,'9874564','Administrador',98745621,NULL,'carlossd@gmail.com','asder12354','2024-09-11 18:30:53'),(23,'Ana ',0,'987451648','Propietario',2011554,NULL,'anasd@gmail.com','ahsge125478','2024-09-11 18:30:53'),(24,'Luisa ',0,'3654647','Propietario',62332546,NULL,'luisa@gmail.com','ajsd123654','2024-09-11 18:30:53');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-12 11:10:39
