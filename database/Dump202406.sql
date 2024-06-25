CREATE DATABASE  IF NOT EXISTS `log_book` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `log_book`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: log_book
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `activesubjects`
--

DROP TABLE IF EXISTS `activesubjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activesubjects` (
  `subjectID` int NOT NULL,
  `specialtyID` int NOT NULL,
  `classID` int NOT NULL,
  KEY `subjectID` (`subjectID`),
  KEY `specialtyID` (`specialtyID`),
  KEY `classID` (`classID`),
  CONSTRAINT `activesubjects_ibfk_1` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`),
  CONSTRAINT `activesubjects_ibfk_2` FOREIGN KEY (`specialtyID`) REFERENCES `specialty` (`specialtyID`),
  CONSTRAINT `activesubjects_ibfk_3` FOREIGN KEY (`classID`) REFERENCES `class` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activesubjects`
--

LOCK TABLES `activesubjects` WRITE;
/*!40000 ALTER TABLE `activesubjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `activesubjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `adminuserinfo`
--

DROP TABLE IF EXISTS `adminuserinfo`;
/*!50001 DROP VIEW IF EXISTS `adminuserinfo`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `adminuserinfo` AS SELECT
 1 AS `id`,
 1 AS `username`,
 1 AS `fullName`,
 1 AS `email`,
 1 AS `signupDate`,
 1 AS `token`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `bookentry`
--

DROP TABLE IF EXISTS `bookentry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookentry` (
  `entryID` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` varchar(6500) NOT NULL,
  `periods` varchar(10) NOT NULL,
  `username` int NOT NULL,
  `subjectID` int NOT NULL,
  `specialtyID` int NOT NULL,
  `class` int NOT NULL,
  `year` int NOT NULL,
  `season` varchar(10) NOT NULL,
  `semester` char(1) NOT NULL,
  PRIMARY KEY (`entryID`),
  KEY `username` (`username`),
  KEY `subjectID` (`subjectID`),
  KEY `specialtyID` (`specialtyID`),
  CONSTRAINT `bookentry_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`id`),
  CONSTRAINT `bookentry_ibfk_2` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`),
  CONSTRAINT `bookentry_ibfk_3` FOREIGN KEY (`specialtyID`) REFERENCES `class` (`specialtyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookentry`
--

LOCK TABLES `bookentry` WRITE;
/*!40000 ALTER TABLE `bookentry` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookentry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numOfClasses` int NOT NULL,
  `specialtyID` int NOT NULL,
  `edPeriodID` int NOT NULL,
  `semester` char(1) NOT NULL,
  PRIMARY KEY (`id`,`specialtyID`,`edPeriodID`,`semester`),
  KEY `specialtyID` (`specialtyID`),
  KEY `edPeriodID` (`edPeriodID`),
  CONSTRAINT `class_ibfk_1` FOREIGN KEY (`specialtyID`) REFERENCES `specialty` (`specialtyID`),
  CONSTRAINT `class_ibfk_2` FOREIGN KEY (`edPeriodID`) REFERENCES `edperiod` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edperiod`
--

DROP TABLE IF EXISTS `edperiod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edperiod` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` int NOT NULL,
  `season` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `edperiod_chk_1` CHECK ((`SEASON` in (_utf8mb4'A',_utf8mb4'B')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edperiod`
--

LOCK TABLES `edperiod` WRITE;
/*!40000 ALTER TABLE `edperiod` DISABLE KEYS */;
/*!40000 ALTER TABLE `edperiod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `fulluserview`
--

DROP TABLE IF EXISTS `fulluserview`;
/*!50001 DROP VIEW IF EXISTS `fulluserview`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `fulluserview` AS SELECT
 1 AS `id`,
 1 AS `username`,
 1 AS `fullName`,
 1 AS `email`,
 1 AS `signupDate`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `iptimeout`
--

DROP TABLE IF EXISTS `iptimeout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `iptimeout` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(46) DEFAULT NULL,
  `uid` int DEFAULT NULL,
  `currentMisdemeanors` int DEFAULT NULL,
  `timeoutCount` int DEFAULT '0',
  `timeout` int DEFAULT '0',
  `timeoutUntil` timestamp NULL DEFAULT NULL,
  `registered` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iptimeout`
--

LOCK TABLES `iptimeout` WRITE;
/*!40000 ALTER TABLE `iptimeout` DISABLE KEYS */;
/*!40000 ALTER TABLE `iptimeout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passwordrecovery`
--

DROP TABLE IF EXISTS `passwordrecovery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passwordrecovery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `token` varchar(42) NOT NULL,
  `isActive` int DEFAULT '1',
  `requestTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expiresAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `passwordrecovery_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passwordrecovery`
--

LOCK TABLES `passwordrecovery` WRITE;
/*!40000 ALTER TABLE `passwordrecovery` DISABLE KEYS */;
/*!40000 ALTER TABLE `passwordrecovery` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`UWCC`@`localhost`*/ /*!50003 TRIGGER `recoveryTokenExpiration` BEFORE INSERT ON `passwordrecovery` FOR EACH ROW BEGIN
    SET NEW.expiresAt = DATE_ADD(NOW(), INTERVAL 1 HOUR);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `registrationtokens`
--

DROP TABLE IF EXISTS `registrationtokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrationtokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `token` varchar(20) NOT NULL,
  `maxUses` int NOT NULL,
  `used` int DEFAULT '0',
  `isActive` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrationtokens`
--

LOCK TABLES `registrationtokens` WRITE;
/*!40000 ALTER TABLE `registrationtokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `registrationtokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serverlog`
--

DROP TABLE IF EXISTS `serverlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `serverlog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pageDir` varchar(100) DEFAULT NULL,
  `logDesc` varchar(510) NOT NULL,
  `ip` varchar(46) DEFAULT NULL,
  `uid` int DEFAULT NULL,
  `logTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serverlog`
--

LOCK TABLES `serverlog` WRITE;
/*!40000 ALTER TABLE `serverlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `serverlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialty`
--

DROP TABLE IF EXISTS `specialty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specialty` (
  `specialtyID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`specialtyID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialty`
--

LOCK TABLES `specialty` WRITE;
/*!40000 ALTER TABLE `specialty` DISABLE KEYS */;
INSERT INTO `specialty` VALUES (1,'ΣΤΕΛΕΧΟΣ ΨΗΦΙΑΚΟΥ MARKETING ΣΤΟ ΗΛΕΚΤΡΟΝΙΚΟ ΕΜΠΟΡΙΟ'),(2,'ΤΕΧΝΙΚΟΙ ΕΦΑΡΜΟΓΩΝ ΠΛΗΡΟΦΟΡΙΚΗΣ'),(3,'ΤΕΧΝΙΚΟΣ ΜΗΧΑΝΙΚΟΣ ΘΕΡΜΙΚΩΝ ΕΓΚΑΤΑΣΤΑΣΕΩΝ & ΜΗΧΑΝΙΚΟΣ ΤΕΧΝΟΛΟΓΙΑΣ ΠΕΤΡΕΛΑΙΟΥ ΚΑΙ ΦΥΣΙΚΟΥ ΑΕΡΙΟΥ'),(4,'ΤΕΧΝΙΚΟΣ ΕΓΚΑΤΑΣΤΑΣΕΩΝ ΑΝΑΝΕΩΣΙΜΩΝ ΠΗΓΩΝ ΕΝΕΡΓΕΙΑΣ'),(5,'ΕΣΩΤΕΡΙΚΗ ΑΡΧΙΤΕΚΤΟΝΙΚΗ ΔΙΑΚΟΣΜΙΣΗ & ΣΧΕΔΙΑΣΜΟΣ ΑΝΤΙΚΕΙΜΕΝΩΝ'),(6,'ΤΕΧΝΙΚΟΣ ΑΝΕΛΚΥΣΤΗΡΩΝ'),(7,'ΤΕΧΝΙΚΟΣ ΜΗΧΑΝΟΤΡΟΝΙΚΗΣ'),(8,'ΤΕΧΝΙΚΟΣ Η/Υ'),(9,'ΤΕΧΝΙΚΟΣ ΣΥΣΤΗΜΑΤΩΝ ΑΝΟΙΧΤΟΥ ΛΟΓΙΣΜΙΚΟΥ'),(10,'ΤΕΧΝΙΚΟΣ ΑΥΤΟΜΑΤΙΣΜΩΝ ΝΑΥΤΙΛΙΑΣ'),(11,'ΤΕΧΝΙΚΟΣ ΙΑΤΡΙΚΩΝ ΟΡΓΑΝΩΝ');
/*!40000 ALTER TABLE `specialty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `subjectID` int NOT NULL AUTO_INCREMENT,
  `specialtyID` int NOT NULL,
  `name` varchar(128) NOT NULL,
  `semester` varchar(2) NOT NULL,
  PRIMARY KEY (`subjectID`),
  KEY `specialtyID` (`specialtyID`),
  CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`specialtyID`) REFERENCES `specialty` (`specialtyID`),
  CONSTRAINT `subject_chk_1` CHECK ((`semester` in (_utf8mb4'A',_utf8mb4'B',_utf8mb4'C',_utf8mb4'D')))
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,1,'ΨΗΦΙΑΚΟ ΜΑΡΚΕΤΙΝΓΚ Ι - (Θ)','A'),(2,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ Ι (ΨΗΦΙΑΚΗ ΣΤΡΑΤΙΓΙΚΗ) - (Θ)','A'),(3,1,'ΜΑΡΚΕΤΙΝΓΚ ΣΤΑ ΜΕΣΑ ΚΟΙΝΩΝΙΚΗΣ ΔΙΚΤΥΩΣΗΣ - (Θ)','A'),(4,1,'ΕΙΣΑΓΩΓΗ ΣΤΙΣ ΤΕΧΝΟΛΟΓΙΕΣ ΠΛΗΡΟΦΟΡΙΚΗΣ - (Θ)','A'),(5,1,'ΨΗΦΙΑΚΗ ΟΙΚΟΝΟΜΙΑ ΚΑΙ ΕΠΙΧΕΙΡΗΜΑΤΙΚΟΤΗΤΑ - (Θ)','A'),(6,1,'ΜΑΡΚΕΤΙΝΓΚ ΣΤΑ ΜΕΣΑ ΚΟΙΝΩΝΙΚΗΣ ΔΙΚΤΥΩΣΗΣ - (Ε)','A'),(7,1,'ΕΙΣΑΓΩΓΗ ΣΤΙΣ ΤΕΧΝΟΛΟΓΙΕΣ ΠΛΗΡΟΦΟΡΙΚΗΣ - (Ε)','A'),(8,1,'ΨΗΦΙΑΚΗ ΟΙΚΟΝΟΜΙΑ ΚΑΙ ΕΠΙΧΕΙΡΗΜΑΤΙΚΟΤΗΤΑ - (Ε)','A'),(9,1,'ΜΑΡΚΕΤΙΝΓΚ ΠΕΡΙΕΧΟΜΕΝΟΥ - (Ε)','A'),(10,1,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(11,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ Ι (ΕΦΑΡΜΟΓΕΣ ΨΗΦΙΑΚΗΣ ΕΠΙΧΕΙΡΗΜΑΤΙΚΟΤΗΤΑΣ ΚΑΙ ΔΥΝΑΜΙΚΗΣ ΑΝΑΔΙΟΡΓΑΝΩΣΗΣ) - (Ε)','A'),(12,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ ΙΙ (ΕΠΙΧΕΙΡΗΣΙΑΚΗ ΣΤΡΑΤΙΓΙΚΗ & ΠΟΛΙΤΙΚΗ) - (Θ)','B'),(13,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ ΙΙ (ΨΗΦΙΑΚΟΣ ΜΕΤΑΣΧΗΜΑΤΙΣΜΟΣ ΚΑΙ ΗΛΕΚΤΡΟΝΙΚΗ ΔΙΑΦΗΜΙΣΗ) - (Θ)','B'),(14,1,'ΨΗΦΙΑΚΟ ΜΑΡΚΕΤΙΝΓ ΙΙ - (Θ)','B'),(15,1,'ΤΕΧΝΟΛΟΓΙΕΣ ΔΙΑΔΙΚΤΥΟΥ & ΠΑΓΚΟΣΜΙΟΥ ΙΣΤΟΥ - (Θ)','B'),(16,1,'ΕΙΣΑΓΩΓΗ ΣΤΙΣ ΒΑΣΕΙΣ ΔΕΔΟΜΕΝΩΝ - (Θ)','B'),(17,1,'ΕΠΙΧΕΙΡΗΜΑΤΙΚΟ ΠΛΑΝΟ (BUSINESS PLAN) - (Θ)','B'),(18,1,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗΣΤΗΝ ΕΔΙΚΟΤΗΤΑ ΙΙ - (Ε)','B'),(19,1,'ΨΗΦΙΑΚΟ ΜΑΡΚΕΤΙΝΓ ΙΙ - (Ε)','B'),(20,1,'ΤΕΧΝΟΛΟΓΙΕΣ ΔΙΑΔΙΚΤΥΟΥ & ΠΑΓΚΟΣΜΙΟΥ ΙΣΤΟΥ - (Ε)','B'),(21,1,'ΕΙΣΑΓΩΓΗ ΣΤΙΣ ΒΑΣΕΙΣ ΔΕΔΟΜΕΝΩΝ - (Ε)','B'),(22,1,'ΕΠΙΧΕΙΡΗΜΑΤΙΚΟ ΠΛΑΝΟ (BUSINESS PLAN) - (Ε)','B'),(23,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ ΙΙΙ (ΜΑΡΚΕΤΙΝΓΚ ΠΡΟΪΟΝΤΩΝ ΥΨΗΛΗΣ ΤΕΧΝΟΛΟΓΙΑΣ) - (Θ)','C'),(24,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ ΙΙΙ (Η ΣΤΡΑΤΙΓΙΚΗ ΚΑΙ ΤΑ ΕΡΓΑΛΙΑ ΤΟΥ ΨΗΦΙΑΚΟΥ ΜΑΡΚΕΤΙΝΓΚ) - (Θ)','C'),(25,1,'ΕΙΣΑΓΩΓΗ ΣΤΟΝ ΣΧΕΔΙΑΣΜΟ ΑΛΛΗΛΕΠΙΔΡΑΣΤΙΚΩΝ ΙΣΤΟΤΟΠΩΝ - (Θ)','C'),(26,1,'ΗΛΕΚΤΡΟΝΙΚΟ ΕΜΠΟΡΙΟ Ι - (Θ)','C'),(27,1,'ΚΑΤΑΡΡΤΗΣΗ ΚΑΙ ΑΞΙΟΛΟΓΗΣΗ MARKETING PLAN  - (Θ)','C'),(28,1,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗΣΤΗΝ ΕΔΙΚΟΤΗΤΑ ΙΙΙ - (Ε)','C'),(29,1,'ΤΕΧΝΙΚΕΣ ΚΑΙ ΕΡΓΑΛΕΙΑ ΨΗΦΙΑΚΗΣ ΔΙΑΦΗΜΙΣΗΣ - (Ε)','C'),(30,1,'ΕΙΣΑΓΩΓΗ ΣΤΟΝ ΣΧΕΔΙΑΣΜΟ ΑΛΛΗΛΕΠΙΔΡΑΣΤΙΚΩΝ ΙΣΤΟΤΟΠΩΝ - (Ε)','C'),(31,1,'ΗΛΕΚΤΡΟΝΙΚΟ ΕΜΠΟΡΙΟ Ι - (Ε)','C'),(32,1,'ΚΑΤΑΡΡΤΗΣΗ ΚΑΙ ΑΞΙΟΛΟΓΗΣΗ MARKETING PLAN  - (Ε)','C'),(33,1,'ΙΔΙΩΤΙΚΟΤΗΤΑ & ΠΡΟΣΩΠΙΚΑ ΔΕΔΟΜΕΝΑ ΔΙΑΔΙΚΤΥΟΥ (GDPR) - (Θ)','D'),(34,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ ΙV (ΕΙΣΑΓΩΓΗ ΣΤΗ ΔΙΕΘΝΗ ΟΙΚΟΝΟΜΙΑ) - (Θ)','D'),(35,1,'ΕΥΕΛΙΚΤΗ ΖΩΝΗ ΙV (ΣΤΡΑΤΗΓΙΚΕΣ ΜΑΡΚΕΤΙΝΓΚ ΓΙΑ ΔΙΕΘΝΕΙΣ ΑΓΟΡΕΣ) - (Θ)','D'),(36,1,'ΑΝΑΛΥΣΗ ΔΕΔΟΜΕΝΩΝ ΣΤΟ ΨΗΦΙΑΚΟ ΜΑΡΚΕΤΙΝΓΚ - (Θ)','D'),(37,1,'ΗΛΕΚΤΡΟΝΙΚΟ ΕΜΠΟΡΙΟ ΙΙ - (Θ)','D'),(38,1,'ΕΡΕΥΝΑ ΜΑΡΚΕΤΙΝΓΚ - (Θ)','D'),(39,1,'ΠΡΑΚΤΙΚΗ ΕΦΑΤΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ ΙV - (Ε)','D'),(40,1,'ΑΝΑΛΥΣΗ ΔΕΔΟΜΕΝΩΝ ΣΤΟ ΨΗΦΙΑΚΟ ΜΑΡΚΕΤΙΝΓΚ - (Ε)','D'),(41,1,'ΗΛΕΚΤΡΟΝΙΚΟ ΕΜΠΟΡΙΟ ΙΙ - (Ε)','D'),(42,1,'ΕΡΕΥΝΑ ΜΑΡΚΕΤΙΝΓΚ - (Ε)','D'),(43,2,'ΕΠΙΚΟΙΝΩΝΙΚΕΣ ΔΕΔΟΜΕΝΩΝ - (Θ)','A'),(44,2,'ΕΙΣΑΓΩΓΗ ΣΤΗΝ ΠΛΗΡΟΦΟΡΙΚΗ - (Θ)','A'),(45,2,'ΑΛΓΟΡΙΘΜΙΚΗ ΚΑΙ ΔΟΜΕΣΔΕΔΟΜΕΝΩΝ Ι ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ Ι - (Θ)','A'),(46,2,'ΑΡΧΙΤΕΚΤΟΝΙΚΗ ΥΠΟΛΟΓΙΣΤΩΝ - (Θ)','A'),(47,2,'ΛΕΙΤΟΥΡΓΙΚΑ ΣΥΣΤΗΜΑΤΑ - (Θ)','A'),(48,2,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ Ι - (Ε)','A'),(49,2,'ΕΙΣΑΓΩΓΗ ΣΤΗΝ ΠΛΗΡΟΦΟΡΙΚΗ - (Ε)','A'),(50,2,'ΑΛΓΟΡΙΘΜΙΚΗ ΚΑΙ ΔΟΜΕΣΔΕΔΟΜΕΝΩΝ Ι ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ Ι - (Ε)','A'),(51,2,'ΑΡΧΙΤΕΚΤΟΝΙΚΗ ΥΠΟΛΟΓΙΣΤΩΝ - (Ε)','A'),(52,2,'ΛΕΙΤΟΥΡΓΙΚΑ ΣΥΣΤΗΜΑΤΑ - (Ε)','A'),(53,2,'ΒΑΣΕΙΣ ΔΕΔΟΜΕΝΩΝ Ι - (Θ)','B'),(54,2,'ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ ΙΙ - (Θ)','B'),(55,2,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗΣΤΗΝ ΕΔΙΚΟΤΗΤΑ ΙΙ - (Θ)','B'),(56,2,'ΕΡΓΑΛΕΙΑ ΑΝΑΠΤΥΞΗΣ ΕΦΑΡΜΟΓΩΝ INTERNET  - (Ε)','B'),(57,2,'ΗΛΕΚΤΡΟΝΙΚΗ ΕΠΕΞΕΡΓΑΣΙΑ ΕΙΚΟΝΑΣ - (Ε)','B'),(58,2,'ΒΑΣΕΙΣ ΔΕΔΟΜΕΝΩΝ Ι - (Ε)','B'),(59,2,'ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ ΙΙ - (Ε)','B'),(60,2,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗΣΤΗΝ ΕΔΙΚΟΤΗΤΑ ΙΙ - (Ε)','B'),(61,2,'ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ ΙΙΙ (ΑΝΤΙΚΕΙΜΕΝΟΣΤΡΑΦΗΣ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΣ) - (Ε)','C'),(62,2,'ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ ΙV (OPENGL) - (Ε)','C'),(63,2,'ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ V(PHP) - (Ε)','C'),(64,2,'ΕΡΓΑΛΕΙΑ ΚΑΤΑΣΚΕΥΗΣ ΠΑΙΧΝΙΔΙΩΝ - (Ε)','C'),(65,2,'ΕΡΓΑΛΕΙΑ ΔΗΜΙΟΥΡΓΙΑΣ ΤΡΙΣΔΙΑΣΤΑΤΩΝ ΓΡΑΦΙΚΩΝ - (Ε)','C'),(66,2,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ ΙΙΙ - (Ε)','C'),(67,2,'ΓΛΩΣΣΑ ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΥ IV (OPENGL) - (Ε)','D'),(68,2,'ΕΡΓΑΛΕΙΑ ΚΑΤΑΣΚΕΥΗΣ ΠΑΙΧΝΙΔΙΩΝ (Unreal Editor, Half Life, Doom Editor) - (Ε)','D'),(69,2,'ΕΡΓΑΛΕΙΑ ΔΗΜΙΟΥΡΓΙΑΣ ΤΡΙΣΔΙΑΣΤΑΤΩΝ ΓΡΑΦΙΚΩΝ - (Ε)','D'),(70,2,'ΑΝΑΠΤΥΞΗ ΔΙΑΔΡΑΣΤΙΚΩΝ ΠΑΙΧΝΙΔΙΩΝ ΣΕ ΠΕΡΙΒΑΛΛΟΝ ΜΙΚΡΟΣΥΣΚΕΥΩΝ ΚΑΙ Η/Υ (C++, JAVA) - (Ε)','D'),(71,2,'ΟΛΟΚΛΗΡΩΜΕΝΑ ΕΡΓΑΛΕΙΑ ΑΝΑΠΤΥΞΗΣ ΙΣΤΟΧΩΡΩΝ - (Ε)','D'),(72,2,'ΕΡΓΑΛΕΙΑ ΕΠΕΞΕΡΓΑΣΙΑΣ VIDEO - (Ε)','D'),(73,2,'ΠΟΛΥΜΕΣΙΚΑ ΕΡΓΑΛΕΙΑ ΚΑΤΑΣΚΕΥΗΣ ΠΑΙΧΝΙΔΙΩΝ (FLASH) - (Ε)','D'),(74,2,'ΕΡΓΑΛΕΙΑ ΑΝΑΠΤΥΞΗΣ ΕΦΑΡΜΟΓΩΝ INTERNET - (Ε)','D'),(75,2,'ΠΡΑΚΤΙΚΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ IV - (Ε)','D'),(76,3,'ΤΕΧΝΟΛΟΓΙΑ ΥΛΙΚΩΝ - (Θ)','A'),(77,3,'ΜΗΧΑΝΙΚΗ – ΑΝΤΟΧΗ ΥΛΙΚΩΝ  - (Θ)','A'),(78,3,'ΤΕΧΝΟΛΟΓΙΑ ΚΑΤΑΣΚΕΥΩΝ  - (Θ)','A'),(79,3,'ΑΣΦΑΛΕΙΑ ΕΡΓΑΣΙΑΣ - (Θ)','A'),(80,3,'ΣΤΟΙΧΕΙΑ ΜΗΧΑΝΩΝ - (Θ)','A'),(81,3,'ΣΧΕΔΙΟ - (Ε)','A'),(82,3,'ΤΕΧΝΟΛΟΓΙΑ ΚΑΤΑΣΚΕΥΩΝ  - (Ε)','A'),(83,3,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(84,3,'ΤΕΧΝΟΛΟΓΙΑ ΚΑΤΑΣΚΕΥΩΝ - (Θ)','B'),(85,3,'ΠΡΟΣΤΑΣΙΑ ΠΕΡΙΒΑΛΛΟΝΤΟΣ - (Θ)','B'),(86,3,'ΣΤΟΙΧΕΙΑ ΘΕΡΜΟΔΥΝΑΜΙΚΗΣ & ΜΗΧ. ΡΕΥΣΤΩΝ - (Θ)','B'),(87,3,'ΗΛΕΚΤΡΟΤΕΧΝΙΚΕΣ ΕΦΑΡΜΟΓΕΣ - (Θ)','B'),(88,3,'ΤΕΧΝΟΛΟΓΙΑ ΚΑΤΑΣΚΕΥΩΝ - (Ε)','B'),(89,3,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ  - (Ε)','B'),(90,3,'ΗΛΕΚΤΡΟΤΕΧΝΙΚΕΣ ΕΦΑΡΜΟΓΕΣ - (Ε)','B'),(91,3,'ΕΓΚΑΤΑΣΤΑΣΕΙΣ ΚΕΝΤΡΙΚΗΣ ΘΕΡΜΑΝΣΗΣ - (Θ)','C'),(92,3,'ΠΑΡΑΓΩΓΗ ΥΓΡΩΝ ΚΑΙ ΑΕΡΙΩΝ ΚΑΥΣΙΜΩΝ - (Θ)','C'),(93,3,'ΜΕΤΑΦΟΡΑ ΔΙΑΝΟΜΗ ΑΠΟΘΗΚΕΥΣΗ ΚΑΥΣΙΜΩΝ - (Θ)','C'),(94,3,'ΚΑΤΑΣΚΕΥΗ – ΣΥΝΤΗΡΗΣΗ ΚΑΙ ΕΠΙΣΚΕΥΗ ΕΓΚΑΤΑΣΤΑΣΕΩΝ ΥΔΡΕΥΣΗΣ ΚΑΙ ΑΠΟΧΕΤΕΥΣΗΣ - (Θ)','C'),(95,3,'ΑΥΤΟΜΑΤΙΣΜΟΙ ΕΓΚΑΤΑΣΤΑΣΕΩΝ - (Θ)','C'),(96,3,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ  - (Ε)','C'),(97,3,'ΕΓΚΑΤΑΣΤΑΣΕΙΣ ΚΕΝΤΡΙΚΗΣ ΘΕΡΜΑΝΣΗΣ - (Ε)','C'),(98,3,'ΣΧΕΔΙΟ ΕΓΚΑΤΑΣΤΑΣΕΩΝ - (Ε)','C'),(99,3,'ΚΑΤΑΣΚΕΥΗ – ΣΥΝΤΗΡΗΣΗ ΚΑΙ ΕΠΙΣΚΕΥΗ ΕΓΚΑΤΑΣΤΑΣΕΩΝ ΥΔΡΕΥΣΗΣ ΚΑΙ ΑΠΟΧΕΤΕΥΣΗΣ - (Ε)','C'),(100,3,'ΑΥΤΟΜΑΤΙΣΜΟΙ ΕΓΚΑΤΑΣΤΑΣΕΩΝ - (Ε)','C'),(101,3,'ΕΓΚΑΤΑΣΤΑΣΕΙΣ ΚΕΝΤΡΙΚΗΣ ΘΕΡΜΑΝΣΗΣ - (Θ)','D'),(102,3,'ΠΟΙΟΤΙΚΟΣ ΕΛΕΓΧΟΣ ΚΑΥΣΙΜΩΝ - (Θ)','D'),(103,3,'ΕΦΑΡΜΟΓΕΣ ΚΑΥΣΤΗΡΩΝ ΚΑΥΣΙΜΩΝ - (Θ)','D'),(104,3,'ΠΥΡΟΣΒΕΣΤΙΚΑ ΣΥΣΤΗΜΑΤΑ - (Θ)','D'),(105,3,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ  - (Ε)','D'),(106,3,'ΕΓΚΑΤΑΣΤΑΣΕΙΣ ΚΕΝΤΡΙΚΗΣ ΘΕΡΜΑΝΣΗΣ - (Ε)','D'),(107,3,'ΕΦΑΡΜΟΓΕΣ ΚΑΥΣΤΗΡΩΝ ΚΑΥΣΙΜΩΝ - (Ε)','D'),(108,3,'ΠΥΡΟΣΒΕΣΤΙΚΑ ΣΥΣΤΗΜΑΤΑ - (Ε)','D'),(109,4,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - (Θ)','A'),(110,4,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','A'),(111,4,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','A'),(112,4,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Θ)','A'),(113,4,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - (Ε)','A'),(114,4,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','A'),(115,4,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','A'),(116,4,'ΜΗΧΑΝΟΛΟΓΙΑ - (Ε)','A'),(117,4,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Ε)','A'),(118,4,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(119,4,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(120,4,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(121,4,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Θ)','B'),(122,4,'ΜΕΤΡΗΣΕΙΣ – ΑΙΣΘΗΤΗΡΙΑ - (Θ)','B'),(123,4,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(124,4,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(125,4,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Ε)','B'),(126,4,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','B'),(127,4,'ΜΕΤΡΗΣΕΙΣ – ΑΙΣΘΗΤΗΡΙΑ - (Ε)','B'),(128,4,'ΣΧΕΔΙΟ - (Ε)','B'),(129,4,'ΑΥΤΟΜΑΤΟΠΟΙΗΜΕΝΕΣ ΕΓΚΑΤΑΣΤΑΣΕΙΣ - (Θ)','C'),(130,4,'ΒΙΟΜΗΧΑΝΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','C'),(131,4,'ΑΝΑΝΕΩΣΙΜΕΣ ΠΗΓΕΣ ΕΝΕΡΓΕΙΑΣ (Α.Π.Ε.)  - (Θ)','C'),(132,4,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','C'),(133,4,'ΑΥΤΟΜΑΤΟΠΟΙΗΜΕΝΕΣ ΕΓΚΑΤΑΣΤΑΣΕΙΣ - (Ε)','C'),(134,4,'ΒΙΟΜΗΧΑΝΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','C'),(135,4,'ΑΝΑΝΕΩΣΙΜΕΣ ΠΗΓΕΣ ΕΝΕΡΓΕΙΑΣ (Α.Π.Ε.)  - (Ε)','C'),(136,4,'ΑΝΑΝΕΩΣΙΜΕΣ ΠΗΓΕΣ ΕΝΕΡΓΕΙΑΣ (Α.Π.Ε.)  - (Θ)','D'),(137,4,'ΗΛΕΚΤΡΙΚΗ ΚΙΝΗΣΗ - (Θ)','D'),(138,4,'ΕΝΕΡΓΕΙΑΚΗ ΟΙΚΟΝΟΜΙΑ - (Θ)','D'),(139,4,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','D'),(140,4,'ΑΝΑΝΕΩΣΙΜΕΣ ΠΗΓΕΣ ΕΝΕΡΓΕΙΑΣ (Α.Π.Ε.)  - (Ε)','D'),(141,4,'ΗΛΕΚΤΡΙΚΗ ΚΙΝΗΣΗ - (Ε)','D'),(142,4,'ΠΡΑΣΙΝΗ ΕΓΚΑΤΑΣΤΑΣΗ - (Ε)','D'),(143,5,'ΤΕΧΝΟΛΟΓΙΑ ΥΛΙΚΩΝ - (Θ)','A'),(144,5,'ΙΣΤΟΡΙΑ ΤΕΧΝΗΣ - ΑΡΧΙΤΕΚΤΟΝΙΚΗΣ - (Θ)','A'),(145,5,'ΜΕΘΟΔΟΙ ΑΠΟΤΥΠΩΣΗΣ ΚΑΙ ΣΧΕΔΙΑΣΗΣ - (Ε)','A'),(146,5,'ΕΛΕΥΘΕΡΟ ΣΧΕΔΙΟ ΚΑΙ ΠΡΑΚΤΙΚΗ ΧΡΩΜΑΤΟΣ - (Ε)','A'),(147,5,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(148,5,'ΤΕΧΝΟΛΟΓΙΑ ΥΛΙΚΩΝ - (Θ)','B'),(149,5,'ΙΣΤΟΡΙΑ ΤΕΧΝΗΣ - ΑΡΧΙΤΕΚΤΟΝΙΚΗΣ - (Θ)','B'),(150,5,'ΔΙΑΚΟΣΜΗΤΙΚΟ ΣΧΕΔΙΟ - (Ε)','B'),(151,5,'ΔΟΜΙΚΟ - ΚΑΤΑΣΚΕΥΑΣΤΙΚΟ ΣΧΕΔΙΟ - (Ε)','B'),(152,5,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','B'),(153,5,'ΤΕΧΝΟΛΟΓΙΑ ΥΛΙΚΩΝ - (Θ)','C'),(154,5,'ΟΡΓΑΝΩΣΗ ΕΡΓΑΣΙΩΝ ΚΑΤΑΣΚΕΥΗΣ - (Θ)','C'),(155,5,'ΣΧΕΔΙΟ ΜΕΣΩ Η/Υ - (Θ)','C'),(156,5,'ΔΟΜΙΚΟ - ΚΑΤΑΣΚΕΥΑΣΤΙΚΟ ΣΧΕΔΙΟ - (Ε)','C'),(157,5,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','C'),(158,5,'ΣΧΕΔΙΟ ΜΕΣΩ Η/Υ - (Ε)','C'),(159,5,'ΣΧΕΔΙΟ ΜΕΣΩ Η/Υ - (Ε)','D'),(160,5,'ΔΙΑΘΕΜΑΤΙΚΗ ΕΡΓΑΣΙΑ - (Ε)','D'),(161,5,'ΠΡΑΚΤΙΚΗ ΑΣΚΗΣΗ - (Ε)','D'),(162,6,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - ΗΛ.ΜΕΤΡΗΣΕΙΣ - (Θ)','A'),(163,6,'ΜΗΧΑΝΙΚΗ - (Θ)','A'),(164,6,'ΑΝΤΟΧΗ ΥΛΙΚΩΝ - (Θ)','A'),(165,6,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - ΗΛ.ΜΕΤΡΗΣΕΙΣ - (Ε)','A'),(166,6,'ΜΗΧΑΝΟΛΟΓΙΚΟ ΣΧΕΔΙΟ - (Ε)','A'),(167,6,'ΜΗΧΑΝΟΥΡΓΙΚΟ ΕΡΓΑΣΤΗΡΙΟ ΑΝΕΛΚΥΣΤΗΡΩΝ - (Ε)','A'),(168,6,'ΗΛΕΚΤΡΙΚΕΣ ΜΗΧΑΝΕΣ - (Θ)','B'),(169,6,'ΗΛΕΚΤΡΟΝΙΚΑ ΙΣΧΥΟΣ-ΡΥΘΜΙΣΗ ΜΗΧΑΝΩΝ - (Θ)','B'),(170,6,'ΗΛΕΚΤΡΙΚΕΣ ΜΗΧΑΝΕΣ - (Ε)','B'),(171,6,'ΗΛΕΚΤΡΟΛΟΓΙΚΟ ΣΧΕΔΙΟ - (Ε)','B'),(172,6,'ΜΗΧΑΝΟΥΡΓΙΚΟ ΕΡΓΑΣΤΗΡΙΟ ΑΝΕΛΚΥΣΤΗΡΩΝ - (Ε)','B'),(173,6,'ΗΛΕΚΤΡΟΝΙΚΑ ΙΣΧΥΟΣ-ΡΥΘΜΙΣΗ ΜΗΧΑΝΩΝ - (Ε)','B'),(174,6,'ΤΕΧΝΙΚΗ ΕΠΙΚΟΙΝΩΝΙΑΣ ΚΑΙ ΕΠΙΧΕΙΡΗΜΑΤΙΚΟΤΗΤΑ  - (Θ)','C'),(175,6,'ΑΝΕΛΚΥΣΤΗΡΕΣ ΕΦΑΡΜΟΓΕΣ - (Θ)','C'),(176,6,'ΛΟΓΙΚΑ ΚΥΚΛΩΜΑΤΑ - ΑΥΤΟΜΑΤΙΣΜΟΙ -PLC  - (Θ)','C'),(177,6,'ΑΝΕΛΚΥΣΤΗΡΕΣ ΕΦΑΡΜΟΓΕΣ - (Ε)','C'),(178,6,'ΛΟΓΙΚΑ ΚΥΚΛΩΜΑΤΑ - ΑΥΤΟΜΑΤΙΣΜΟΙ -PLC  - (Ε)','C'),(179,6,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','C'),(180,6,'ΑΝΕΛΚΥΣΤΗΡΕΣ ΕΦΑΡΜΟΓΕΣ - (Θ)','D'),(181,6,'ΑΝΕΛΚΥΣΤΗΡΕΣ ΕΦΑΡΜΟΓΕΣ - (Ε)','D'),(182,6,'ΗΛ.ΕΓΚΑΤΑΣΤΑΣΕΙΣ-ΗΛ.ΚΥΚΛΩΜΑΤΑ ΚΑΙ ΑΥΤΟΜΑΤΙΣΜΟΙ ΑΝΕΛΚΥΣΤΗΡΩΝ - (Ε)','D'),(183,6,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','D'),(184,7,'ΟΡΓΑΝΩΣΗ, ΛΕΙΤΟΥΡΓΙΑ ΚΑΙ ΑΣΦΑΛΕΙΑ ΣΥΝΕΡΓΕΙΟΥ – ΠΕΡΙΒΑΛΛΟΝ - (Θ)','A'),(185,7,'ΣΤΟΙΧΕΙΑ ΗΛΕΚΤΡΟΤΕΧΝΙΑΣ ΚΑΙ ΗΛΕΚΤΡΟΝΙΚΑ ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΚΙΝΗΤΩΝ- ΜΟΤΟΣΥΚΛΕΤΩΝ - (Θ)','A'),(186,7,'ΕΦΑΡΜΟΣΜΕΝΗ ΜΗΧΑΝΟΛΟΓΙΑ - (Θ)','A'),(187,7,'ΣΤΟΙΧΕΙΑ ΗΛΕΚΤΡΟΤΕΧΝΙΑΣ ΚΑΙ ΗΛΕΚΤΡΟΝΙΚΑ ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΚΙΝΗΤΩΝ- ΜΟΤΟΣΥΚΛΕΤΩΝ - (Ε)','A'),(188,7,'ΜΗΧΑΝΟΛΟΓΙΚΟ ΣΧΕΔΙΟ - (Ε)','A'),(189,7,'ΕΦΑΡΜΟΣΜΕΝΗ ΜΗΧΑΝΟΛΟΓΙΑ - (Ε)','A'),(190,7,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(191,7,'ΔΟΜΗ ΚΑΙ ΛΕΙΤΟΥΡΓΙΑ ΥΠΟΛΟΓΙΣΤΙΚΩΝ ΜΟΝΑΔΩΝ  - (Θ)','B'),(192,7,'ΣΥΣΤΗΜΑΤΑ ΠΑΡΑΓΩΓΗΣ ΙΣΧΥΟΣ - (Θ)','B'),(193,7,'ΣΥΣΤΗΜΑΤΑ ΜΕΤΑΔΟΣΗΣ ΙΣΧΥΟΣ - (Θ)','B'),(194,7,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','B'),(195,7,'ΔΟΜΗ ΚΑΙ ΛΕΙΤΟΥΡΓΙΑ ΥΠΟΛΟΓΙΣΤΙΚΩΝ ΜΟΝΑΔΩΝ - (Ε)','B'),(196,7,'ΣΥΣΤΗΜΑΤΑ ΠΑΡΑΓΩΓΗΣ ΙΣΧΥΟΣ - (Ε)','B'),(197,7,'ΣΥΣΤΗΜΑΤΑ ΜΕΤΑΔΟΣΗΣ ΙΣΧΥΟΣ - (Ε)','B'),(198,7,'ΣΤΟΙΧΕΙΑ ΘΕΩΡΙΑΣ ΕΠΙΚΟΙΝΩΝΙΩΝ ΚΑΙ ΔΙΚΤΥΑ ΣΥΣΤΗΜΑΤΩΝ ΣΕ ΟΧΗΜΑΤΑ - (Θ)','C'),(199,7,'ΛΕΙΤΟΥΡΓΙΑ, ΕΠΙΣΚΕΥΗ ΚΑΙ ΣΥΝΤΗΡΗΣΗ ΑΥΤΟΚΙΝΗΤΟΥ  - (Θ)','C'),(200,7,'ΛΕΙΤΟΥΡΓΙΑ, ΕΠΙΣΚΕΥΗ ΚΑΙ ΣΥΝΤΗΡΗΣΗ ΜΟΤΟΣΥΚΛΕΤΩΝ - (Θ)','C'),(201,7,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','C'),(202,7,'ΣΤΟΙΧΕΙΑ ΘΕΩΡΙΑΣ ΕΠΙΚΟΙΝΩΝΙΩΝ ΚΑΙ ΔΙΚΤΥΑ ΣΥΣΤΗΜΑΤΩΝ ΣΕ ΟΧΗΜΑΤΑ  - (Ε)','C'),(203,7,'ΛΕΙΤΟΥΡΓΙΑ, ΕΠΙΣΚΕΥΗ ΚΑΙ ΣΥΝΤΗΡΗΣΗ ΑΥΤΟΚΙΝΗΤΟΥ  - (Ε)','C'),(204,7,'ΛΕΙΤΟΥΡΓΙΑ, ΕΠΙΣΚΕΥΗ ΚΑΙ ΣΥΝΤΗΡΗΣΗ ΜΟΤΟΣΥΚΛΕΤΩΝ  - (Ε)','C'),(205,7,'ΗΛΕΚΤΡΙΚΑ ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΚΙΝΗΤΩΝ - ΜΟΤΟΣΥΚΛΕΤΩΝ - (Θ)','D'),(206,7,'ΔΥΝΑΜΙΚΗ ΟΧΗΜΑΤΩΝ - (Θ)','D'),(207,7,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','D'),(208,7,'ΗΛΕΚΤΡΙΚΑ ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΚΙΝΗΤΩΝ - ΜΟΤΟΣΥΚΛΕΤΩΝ - (Ε)','D'),(209,7,'ΔΙΑΓΝΩΣΗ ΒΛΑΒΩΝ ΑΥΤΟΚΙΝΗΤΟΥ - (Ε)','D'),(210,7,'ΔΙΑΓΝΩΣΗ ΒΛΑΒΩΝ ΜΟΤΟΣΥΚΛΕΤΩΝ - (Ε)','D'),(211,8,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ  - (Θ)','A'),(212,8,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','A'),(213,8,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ  - (Θ)','A'),(214,8,'ΛΕΙΤΟΥΡΓΙΚΑ ΣΥΣΤΗΜΑΤΑ Ι - (Θ)','A'),(215,8,'ΕΠΙΚΟΙΝΩΝΙΕΣ ΔΕΔΟΜΕΝΩΝ - (Θ)','A'),(216,8,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ  - (Ε)','A'),(217,8,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','A'),(218,8,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ  - (Ε)','A'),(219,8,'ΛΕΙΤΟΥΡΓΙΚΑ ΣΥΣΤΗΜΑΤΑ Ι - (Ε)','A'),(220,8,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(221,8,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(222,8,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(223,8,'ΔΙΚΤΥΑ ΥΠΟΛΟΓΙΣΤΩΝ Ι - (Θ)','B'),(224,8,'ΛΕΙΤΟΥΡΓΙΚΑ ΣΥΣΤΗΜΑΤΑ ΙΙ - (Θ)','B'),(225,8,'ΑΡΧΙΤΕΚΤΟΝΙΚΗ ΥΠΟΛΟΓΙΣΤΩΝ - (Θ)','B'),(226,8,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(227,8,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(228,8,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','B'),(229,8,'ΔΙΚΤΥΑ ΥΠΟΛΟΓΙΣΤΩΝ Ι - (Ε)','B'),(230,8,'ΛΕΙΤΟΥΡΓΙΚΑ ΣΥΣΤΗΜΑΤΑ ΙΙ - (Ε)','B'),(231,8,'ΑΡΧΙΤΕΚΤΟΝΙΚΗ ΥΠΟΛΟΓΙΣΤΩΝ - (Ε)','B'),(232,8,'ΑΡΧΙΤΕΚΤΟΝΙΚΗ ΥΠΟΛΟΓΙΣΤΩΝ  - (Θ)','C'),(233,8,'ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΣ Η/Υ - (Θ)','C'),(234,8,'ΠΡΟΣΩΠΙΚΟΣ ΗΛΕΚΤΡΟΝΙΚΟΣ ΥΠΟΛΟΓΙΣΤΗΣ - (Θ)','C'),(235,8,'ΠΕΡΙΦΕΡΕΙΑΚΕΣ ΜΟΝΑΔΕΣ Η/Υ  - (Θ)','C'),(236,8,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','C'),(237,8,'ΑΡΧΙΤΕΚΤΟΝΙΚΗ ΥΠΟΛΟΓΙΣΤΩΝ - (Ε)','C'),(238,8,'ΠΡΟΣΩΠΙΚΟΣ ΗΛΕΚΤΡΟΝΙΚΟΣ ΥΠΟΛΟΓΙΣΤΗΣ - (Ε)','C'),(239,8,'ΠΕΡΙΦΕΡΕΙΑΚΕΣ ΜΟΝΑΔΕΣ Η/Υ  - (Ε)','C'),(240,8,'ΔΙΑΘΕΜΑΤΙΚΗ ΕΡΓΑΣΙΑ - (Ε)','D'),(241,8,'ΠΡΑΚΤΙΚΗ ΑΣΚΗΣΗ - (Ε)','D'),(242,9,'Αρχιτεκτονική και υλικό ηλεκτρονικών υπολογιστών  - (Θ)','A'),(243,9,'Γλώσσα προγραμματισμού Ι (C11) - αλγοριθμική και δομές Δεδομένων - (Θ)','A'),(244,9,'Αρχιτεκτονική και υλικό ηλεκτρονικών υπολογιστών  - (Ε)','A'),(245,9,'Σύγχρονα λειτουργικά Συστήματα - (Ε)','A'),(246,9,'Εργαλεία ανάπτυξης εφαρμογών διαδικτύου (HTML5, CSS3) - (Ε)','A'),(247,9,'Γλώσσα προγραμματισμού Ι (C11) - αλγοριθμική και δομές Δεδομένων - (Ε)','A'),(248,9,'Εφαρμογές γραφείου και ψηφιακές δεξιότητες στη σύγχρονη αγορά εργασίας - (Ε)','A'),(249,9,'Γλώσσα client-side διαδικτυακού προγραμματισμού (JavaScript) - (Ε)','B'),(250,9,'Συστήματα διαχείρισης βάσεων Δεδομένων - (Ε)','B'),(251,9,'Εισαγωγή στη γλώσσα προγραμματισμού Python - (Ε)','B'),(252,9,'Γλώσσα προγραμματισμού ΙΙ (C++14) - αντικειμενοστρεφής Προγραμματισμός - (Ε)','B'),(253,9,'Ανοικτά λειτουργικά συστήματα βασισμένα στο Linux - (Ε)','B'),(254,9,'Βασικές έννοιες και εφαρμογές της ανοικτότητας - (Θ)','C'),(255,9,'Τεχνολογία λογισμικού (σύγχρονες τεχνικές με έμφαση στην ανάπτυξη ανοικτού Λογισμικού) - (Θ)','C'),(256,9,'Ανάλυση και σχεδιασμός πληροφοριακών συστημάτων - (Θ)','C'),(257,9,'Διαχείριση βάσεων δεδομένων ανοικτού κώδικα - (Θ)','C'),(258,9,'Βασικές έννοιες και εφαρμογές της ανοικτότητας - (Ε)','C'),(259,9,'Τεχνολογία λογισμικού (σύγχρονες τεχνικές με έμφαση στην ανάπτυξη ανοικτού Λογισμικού) - (Ε)','C'),(260,9,'Ολοκληρωμένα περιβάλλοντα ανάπτυξης (IDE) ανοικτού Κώδικα - (Ε)','C'),(261,9,'Διαχείριση βάσεων δεδομένων ανοικτού κώδικα - (Ε)','C'),(262,9,'Λειτουργικά συστήματα διακομιστή  - (Ε)','C'),(263,9,'Διαδικτυακές εφαρμογές με εργαλεία ανοικτού κώδικα - (Θ)','D'),(264,9,'Αλληλεπίδραση συστημάτων και ανοικτά δεδομένα - (Θ)','D'),(265,9,'Συστήματα ελέγχου εκδόσεων, workflows και συνεργατικές τεχνικές (git, gitlab, github) - (Ε)','D'),(266,9,'Διαδικτυακές εφαρμογές με εργαλεία ανοικτού κώδικα - (Ε)','D'),(267,9,'Ειδικά θέματα και εφαρμογές στα δίκτυα υπολογιστών  - (Ε)','D'),(268,9,'Υπηρεσίες νέφους με τη χρήση microservices και containers  - (Ε)','D'),(269,9,'Αλληλεπίδραση συστημάτων και ανοικτά δεδομένα - (Ε)','D'),(270,9,'Διαθεματική εργασία  - (Ε)','D'),(271,10,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - (Θ)','A'),(272,10,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','A'),(273,10,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','A'),(274,10,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Θ)','A'),(275,10,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - (Ε)','A'),(276,10,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','A'),(277,10,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','A'),(278,10,'ΜΗΧΑΝΟΛΟΓΙΑ & ΜΗΧΑΝΟΥΡΓΙΚΕΣ ΕΦΑΡΜΟΓΕΣ - (Ε)','A'),(279,10,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Ε)','A'),(280,10,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(281,10,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(282,10,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(283,10,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Θ)','B'),(284,10,'ΜΕΤΡΗΣΕΙΣ – ΑΙΣΘΗΤΗΡΙΑ - (Θ)','B'),(285,10,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(286,10,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(287,10,'ΗΛΕΚΤΡΟΛΟΓΙΑ - (Ε)','B'),(288,10,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','B'),(289,10,'ΜΕΤΡΗΣΕΙΣ – ΑΙΣΘΗΤΗΡΙΑ - (Ε)','B'),(290,10,'ΣΧΕΔΙΟ - (Ε)','B'),(291,10,'ΒΙΟΜΗΧΑΝΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','C'),(292,10,'ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΜΑΤΟΥ ΕΛΕΓΧΟΥ - (Θ)','C'),(293,10,'ΤΗΛΕΠΙΚΟΙΝΩΝΙΕΣ - (Θ)','C'),(294,10,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','C'),(295,10,'ΗΛΕΚΤΡΟΝΙΚΑ ΣΥΣΤΗΜΑΤΑ ΜΕΤΡΗΣΕΩΝ - ΑΙΣΘΗΤΗΡΙΑ και ΜΕΤΑΤΡΟΠΕΙΣ - (Ε)','C'),(296,10,'ΒΙΟΜΗΧΑΝΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','C'),(297,10,'ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΣ Η/Υ - (Ε)','C'),(298,10,'ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΜΑΤΟΥ ΕΛΕΓΧΟΥ  - (Ε)','C'),(299,10,'ΤΗΛΕΠΙΚΟΙΝΩΝΙΕΣ - (Ε)','C'),(300,10,'ΗΛΕΚΤΡΙΚΗ ΚΙΝΗΣΗ - (Θ)','D'),(301,10,'ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΜΑΤΟΥ ΕΛΕΓΧΟΥ - (Θ)','D'),(302,10,'ΤΗΛΕΠΙΚΟΙΝΩΝΙΕΣ - (Θ)','D'),(303,10,'ΗΛΕΚΤΡΙΚΟ ΣΥΣΤΗΜΑ ΠΛΟΙΟΥ - (Θ)','D'),(304,10,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ  - (Ε)','D'),(305,10,'ΗΛΕΚΤΡΙΚΗ ΚΙΝΗΣΗ - (Ε)','D'),(306,10,'ΣΥΣΤΗΜΑΤΑ ΑΥΤΟΜΑΤΟΥ ΕΛΕΓΧΟΥ  - (Ε)','D'),(307,10,'ΜΙΚΡΟΕΛΕΓΚΤΕΣ - (Ε)','D'),(308,10,'ΤΗΛΕΠΙΚΟΙΝΩΝΙΕΣ - (Ε)','D'),(309,10,'ΗΛΕΚΤΡΙΚΟ ΣΥΣΤΗΜΑ ΠΛΟΙΟΥ  - (Ε)','D'),(310,11,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','A'),(311,11,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','A'),(312,11,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - (Θ)','A'),(313,11,'ΑΝΑΤΟΜΙΑ - (Θ)','A'),(314,11,'ΦΥΣΙΟΛΟΓΙΑ - (Θ)','A'),(315,11,'ΙΑΤΡΙΚΗ ΦΥΣΙΚΗ - (Θ)','A'),(316,11,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','A'),(317,11,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','A'),(318,11,'ΗΛΕΚΤΡΟΤΕΧΝΙΑ - (Ε)','A'),(319,11,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','A'),(320,11,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(321,11,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Θ)','B'),(322,11,'ΙΑΤΡΙΚΑ ΣΗΜΑΤΑ ΚΑΙ ΣΥΣΤΗΜΑΤΑ - (Θ)','B'),(323,11,'ΤΕΧΝΟΛΟΓΙΑ ΙΑΤΡΙΚΩΝ ΟΡΓΑΝΩΝ - (Θ)','B'),(324,11,'ΑΝΑΛΟΓΙΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(325,11,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ - (Ε)','B'),(326,11,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','B'),(327,11,'ΙΑΤΡΙΚΑ ΣΗΜΑΤΑ ΚΑΙ ΣΥΣΤΗΜΑΤΑ - (Ε)','B'),(328,11,'ΤΕΧΝΟΛΟΓΙΑ ΙΑΤΡΙΚΩΝ ΟΡΓΑΝΩΝ - (Ε)','B'),(329,11,'ΤΕΧΝΟΛΟΓΙΑ ΙΑΤΡΙΚΩΝ ΟΡΓΑΝΩΝ - (Θ)','C'),(330,11,'ΕΙΔΙΚΕΣ ΕΓΚΑΤΑΣΤΑΣΕΙΣ ΝΟΣΟΚΟΜΕΙΩΝ, ΥΓΙΕΙΝΗ & ΠΡΟΣΤΑΣΙΑ ΠΕΡΙΒΑΛΛΟΝΤΟΣ - (Θ)','C'),(331,11,'ΠΡΑΚΤΙΚΗ ΕΦΑΡΜΟΓΗ ΣΤΗΝ ΕΙΔΙΚΟΤΗΤΑ - (Ε)','C'),(332,11,'ΤΕΧΝΟΛΟΓΙΑ ΙΑΤΡΙΚΩΝ ΟΡΓΑΝΩΝ - (Ε)','C'),(333,11,'ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΣ Η/Υ - (Ε)','C'),(334,11,'ΙΑΤΡΙΚΗ ΠΛΗΡΟΦΟΡΙΚΗ - (Θ)','D'),(335,11,'ΔΙΑΧΕΙΡΙΣΗ ΒΙΟΪΑΤΡΙΚΗΣ ΤΕΧΝΟΛΟΓΙΑΣ - (Θ)','D'),(336,11,'ΤΕΧΝΟΛΟΓΙΑ ΙΑΤΡΙΚΩΝ ΟΡΓΑΝΩΝ - (Ε)','D'),(337,11,'ΙΑΤΡΙΚΗ ΠΛΗΡΟΦΟΡΙΚΗ - (Ε)','D'),(338,11,'ΠΡΑΚΤΙΚΗ ΑΣΚΗΣΗ - (Ε)','D');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `teacheruserinfo`
--

DROP TABLE IF EXISTS `teacheruserinfo`;
/*!50001 DROP VIEW IF EXISTS `teacheruserinfo`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `teacheruserinfo` AS SELECT
 1 AS `id`,
 1 AS `username`,
 1 AS `fullName`,
 1 AS `email`,
 1 AS `signupDate`,
 1 AS `token`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `email` varchar(20) DEFAULT NULL,
  `isAdmin` int DEFAULT '0',
  `isActive` int DEFAULT '1',
  `tokenUsed` int DEFAULT NULL,
  `signupDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_chk_1` CHECK ((`isAdmin` in (0,1,2)))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','$argon2id$v=19$m=65536,t=11,p=2$NHIxcVFXMWRTTVpPeTdGbQ$Yhh3a6S+rqD+HS8U3yOcbW3WpbKOfdJe3WvbO4XMwLg','Admin','Doe',NULL,1,1,NULL,'2024-05-24'),(2,'teacher','$argon2id$v=19$m=65536,t=11,p=2$RG5YWWJBS3NHcVVQM3hqbA$XBoqO4f1VwdfNYL3ZyjRs5bpoggZy71QLiZuZ5uEcCA','Teacher','Doe','teacher@example.com',0,1,NULL,'2024-05-24'),(3,'John@Super','$argon2id$v=19$m=65536,t=11,p=2$WlVPOURWS1hvL053S205ZA$pHxxNcvtCuVnY9cBxYeToYZDqFqL9/NmtLSvlk2m5Jg','John','Super',NULL,2,1,NULL,'2024-05-24'),(4,'Ilias@Super','$argon2id$v=19$m=65536,t=11,p=2$WlVPOURWS1hvL053S205ZA$pHxxNcvtCuVnY9cBxYeToYZDqFqL9/NmtLSvlk2m5Jg','Ilias','Super',NULL,2,1,NULL,'2024-05-24');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`UWCC`@`localhost`*/ /*!50003 TRIGGER `updateTokenUses` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    DECLARE tokenIsActive INT;
    DECLARE maxUsers INT;
    DECLARE currentUsers INT;

    SELECT isActive, maxUses, used
    INTO tokenIsActive, maxUsers, currentUsers
    FROM registrationtokens
    WHERE registrationtokens.id = NEW.tokenUsed;

    -- Update the token's `used` count if it's active and within bounds
    IF tokenIsActive = 1 AND currentUsers < maxUsers THEN
        UPDATE registrationtokens
        SET used = used + 1
        WHERE id = NEW.tokenUsed;
    END IF;

    -- Retrieve the updated `used` count to check if the token should be deactivated
    SELECT used INTO currentUsers FROM registrationtokens WHERE id = NEW.tokenUsed;

    -- Deactivate the token if it's reached or exceeded the `maxUses`
    IF currentUsers >= maxUsers THEN
        UPDATE registrationtokens
        SET isActive = 0
        WHERE id = NEW.tokenUsed;
    END IF;

    -- Log if a user was registered beyond token bounds
    IF currentUsers > maxUsers THEN
        INSERT INTO serverLog(pageID, logDesc, uid)
        VALUES (4, "CRITICAL: User registered out of token Active Bounds!!", NEW.id);
    END IF;

    -- Set the sign up date for the user
    SET NEW.signupDate = NOW();

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'log_book'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `checkRecoveryTokenExpire` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`UWCC`@`localhost`*/ /*!50106 EVENT `checkRecoveryTokenExpire` ON SCHEDULE EVERY 30 MINUTE STARTS '2024-05-24 01:29:05' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN

    -- Update tokens that have expired by setting them to inactive
    UPDATE passwordrecovery
    SET isActive = 0
    WHERE isActive = 1
      AND expiresAt < NOW();

END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `checkTokenExpire` */;;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`UWCC`@`localhost`*/ /*!50106 EVENT `checkTokenExpire` ON SCHEDULE EVERY 1 HOUR STARTS '2024-05-24 01:29:05' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DECLARE tokenID INT;
    DECLARE tokenDate DATE;
    DECLARE done INT DEFAULT 0;  -- Variable to indicate end of cursor

    -- Cursor to select tokens that might need updating
    DECLARE token_cursor CURSOR FOR
    SELECT id, endDate FROM registrationtokens WHERE isActive = 1;

    -- Handler for cursor ending
    DECLARE CONTINUE HANDLER FOR NOT FOUND
    BEGIN

		SET done = 1;
	END;
    -- Open the cursor
    OPEN token_cursor;

    -- Loop through the results
    token_loop: LOOP
        -- Fetch data into variables
        FETCH token_cursor INTO tokenID, tokenDate;

        -- Exit the loop if there are no more rows
        IF done THEN
            LEAVE token_loop;
        END IF;

        -- Check if the token has expired
        IF tokenDate < NOW() THEN
            -- Update the token to be inactive
            UPDATE registrationtokens SET isActive = 0 WHERE id = tokenID;
        END IF;

    END LOOP;

    -- Close the cursor
    CLOSE token_cursor;

END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'log_book'
--
/*!50003 DROP PROCEDURE IF EXISTS `startTokenEvent` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`UWCC`@`localhost` PROCEDURE `startTokenEvent`()
BEGIN

	DECLARE eventStatus VARCHAR(10);



    #select current status of event

    SELECT

		STATUS

	INTO

		eventStatus

	FROM

		information_schema.EVENTS

	WHERE

		EVENT_SCHEMA = DATABASE()

		AND EVENT_NAME LIKE 'checkTokenExpire';



    IF eventStatus LIKE 'DISABLED' THEN

		ALTER EVENT checkTokenExpire ENABLE;

    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `adminuserinfo`
--

/*!50001 DROP VIEW IF EXISTS `adminuserinfo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`UWCC`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `adminuserinfo` AS select `user`.`id` AS `id`,`user`.`username` AS `username`,concat(`user`.`fname`,' ',`user`.`lname`) AS `fullName`,`user`.`email` AS `email`,`user`.`signupDate` AS `signupDate`,`user`.`tokenUsed` AS `token` from `user` where (`user`.`isAdmin` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `fulluserview`
--

/*!50001 DROP VIEW IF EXISTS `fulluserview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`UWCC`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `fulluserview` AS select `user`.`id` AS `id`,`user`.`username` AS `username`,concat(`user`.`fname`,' ',`user`.`lname`) AS `fullName`,`user`.`email` AS `email`,`user`.`signupDate` AS `signupDate` from `user` where (`user`.`isActive` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `teacheruserinfo`
--

/*!50001 DROP VIEW IF EXISTS `teacheruserinfo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`UWCC`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `teacheruserinfo` AS select `user`.`id` AS `id`,`user`.`username` AS `username`,concat(`user`.`fname`,' ',`user`.`lname`) AS `fullName`,`user`.`email` AS `email`,`user`.`signupDate` AS `signupDate`,`user`.`tokenUsed` AS `token` from `user` where (`user`.`isAdmin` = 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-24  1:31:30
