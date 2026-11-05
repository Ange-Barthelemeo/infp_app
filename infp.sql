/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bd_infp
-- ------------------------------------------------------
-- Server version	10.11.14-MariaDB-0ubuntu0.24.04.1

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
-- Table structure for table `AUDIT_LOG`
--

DROP TABLE IF EXISTS `AUDIT_LOG`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `AUDIT_LOG` (
  `IDLOG` int(11) NOT NULL AUTO_INCREMENT,
  `IMMUTILISATEUR` varchar(30) NOT NULL,
  `ACTION` varchar(255) NOT NULL,
  `DATEACTION` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`IDLOG`),
  KEY `FK_LOG_UTILISATEUR` (`IMMUTILISATEUR`),
  CONSTRAINT `FK_LOG_UTILISATEUR` FOREIGN KEY (`IMMUTILISATEUR`) REFERENCES `UTILISATEUR` (`IMMUTILISATEUR`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AUDIT_LOG`
--

LOCK TABLES `AUDIT_LOG` WRITE;
/*!40000 ALTER TABLE `AUDIT_LOG` DISABLE KEYS */;
INSERT INTO `AUDIT_LOG` VALUES
(1,'000 001 - A','Modification du compte utilisateur : 014 789-C','2026-10-19 19:25:05'),
(2,'000 001 - A','Désactivation du compte utilisateur : 014 789-C','2026-10-19 19:25:50'),
(3,'000 001 - A','Activation du compte utilisateur : 002','2026-10-19 19:26:46'),
(4,'000 001 - A','Désactivation du compte utilisateur : 001 236-R','2026-10-19 20:02:02'),
(5,'000 001 - A','Activation du compte utilisateur : 002 014-B','2026-10-19 20:05:44'),
(6,'000 001 - A','Création du compte utilisateur : 123 478-C (gej dd)','2026-10-22 20:05:03'),
(7,'000 001 - A','Création du compte utilisateur : 145 698-C (hh ggggg)','2026-10-22 20:09:18'),
(8,'000 001 - A','Activation du compte utilisateur : 145 698-C','2026-10-22 20:25:59'),
(9,'000 001 - A','Mise à jour des paramètres système','2026-10-22 20:58:36'),
(10,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:01:45'),
(11,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:10:21'),
(12,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:10:32'),
(13,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:31:44'),
(14,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:31:51'),
(15,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:32:19'),
(16,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:39:04'),
(17,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:57:11'),
(18,'000 001 - A','Mise à jour des paramètres système','2026-10-22 21:59:15'),
(19,'000 001 - A','Désactivation du compte utilisateur : 145 698-C','2026-10-23 01:07:25'),
(20,'000 001 - A','Création du compte utilisateur : 124 999-C (Tsiresy Gerard)','2026-10-23 07:41:25'),
(21,'000 001 - A','Activation du compte utilisateur : 145 698-C','2026-10-25 17:53:15');
/*!40000 ALTER TABLE `AUDIT_LOG` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AVOIRNOTE`
--

DROP TABLE IF EXISTS `AVOIRNOTE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `AVOIRNOTE` (
  `CODEEC` varchar(5) NOT NULL,
  `MATRICULEELEVE` varchar(10) NOT NULL,
  `VALEURNOTE` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`CODEEC`,`MATRICULEELEVE`),
  KEY `I_FK_AVOIRNOTE_ELEMCONST` (`CODEEC`),
  KEY `I_FK_AVOIRNOTE_ELEVEMAITRE` (`MATRICULEELEVE`),
  CONSTRAINT `FK_AVOIRNOTE_ELEMCONST` FOREIGN KEY (`CODEEC`) REFERENCES `ELEMCONST` (`CODEEC`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_AVOIRNOTE_ELEVEMAITRE` FOREIGN KEY (`MATRICULEELEVE`) REFERENCES `ELEVEMAITRE` (`MATRICULEELEVE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AVOIRNOTE`
--

LOCK TABLES `AVOIRNOTE` WRITE;
/*!40000 ALTER TABLE `AVOIRNOTE` DISABLE KEYS */;
/*!40000 ALTER TABLE `AVOIRNOTE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CENTRE`
--

DROP TABLE IF EXISTS `CENTRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `CENTRE` (
  `CODECENTRE` varchar(5) NOT NULL,
  `NOMCENTRE` varchar(100) NOT NULL,
  `LOCALISATION` enum('Antananarivo','Fianarantsoa','Toamasina','Mahajanga','Toliara','Antsiranana','Ambatondrazaka','Antsirabe','Fénérive Est','Ihosy','Maintirano','Manakara','Maroantsetra','Morondava','Sambava','Flanarantsoa') NOT NULL,
  `CAPACITEDACCUEIL` int(11) NOT NULL DEFAULT 100,
  `STATUT` tinyint(1) DEFAULT 1 COMMENT '1: Actif, 0: Inactif',
  PRIMARY KEY (`CODECENTRE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CENTRE`
--

LOCK TABLES `CENTRE` WRITE;
/*!40000 ALTER TABLE `CENTRE` DISABLE KEYS */;
INSERT INTO `CENTRE` VALUES
('10101','INFP Centre Régional Antananarivo Ville','Antananarivo',150,0),
('20101','INFP Centre Régional Fianarantsoa','Fianarantsoa',120,1),
('30101','INFP Centre Régional Toamasina','Toamasina',100,1),
('40101','INFP Centre Régional Mahajanga','Mahajanga',100,1),
('50101','INFP Centre Régional Antsiranana','Antsiranana',80,1),
('60101','INFP Centre Régional Toliara','Toliara',90,1),
('C6010','INFP Ambositra','Fianarantsoa',70,1);
/*!40000 ALTER TABLE `CENTRE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CENTRE_SECTION`
--

DROP TABLE IF EXISTS `CENTRE_SECTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `CENTRE_SECTION` (
  `CODECENTRE` varchar(5) NOT NULL,
  `CODESECTION` varchar(10) NOT NULL,
  PRIMARY KEY (`CODECENTRE`,`CODESECTION`),
  KEY `fk_cs_section` (`CODESECTION`),
  CONSTRAINT `fk_cs_centre` FOREIGN KEY (`CODECENTRE`) REFERENCES `CENTRE` (`CODECENTRE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cs_section` FOREIGN KEY (`CODESECTION`) REFERENCES `SECTION` (`CODESECTION`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CENTRE_SECTION`
--

LOCK TABLES `CENTRE_SECTION` WRITE;
/*!40000 ALTER TABLE `CENTRE_SECTION` DISABLE KEYS */;
INSERT INTO `CENTRE_SECTION` VALUES
('C6010','EP'),
('C6010','L1'),
('C6010','L2');
/*!40000 ALTER TABLE `CENTRE_SECTION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CERTIFICAT`
--

DROP TABLE IF EXISTS `CERTIFICAT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `CERTIFICAT` (
  `NUMCERTIFICAT` int(11) NOT NULL AUTO_INCREMENT,
  `MATRICULEELEVE` varchar(10) NOT NULL,
  `MENTION` varchar(30) DEFAULT NULL,
  `DATEDELIVRANCE` date DEFAULT NULL,
  `CODEQR` longblob DEFAULT NULL,
  PRIMARY KEY (`NUMCERTIFICAT`),
  UNIQUE KEY `I_FK_CERTIFICAT_ELEVEMAITRE` (`MATRICULEELEVE`),
  CONSTRAINT `FK_CERTIFICAT_ELEVEMAITRE` FOREIGN KEY (`MATRICULEELEVE`) REFERENCES `ELEVEMAITRE` (`MATRICULEELEVE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CERTIFICAT`
--

LOCK TABLES `CERTIFICAT` WRITE;
/*!40000 ALTER TABLE `CERTIFICAT` DISABLE KEYS */;
/*!40000 ALTER TABLE `CERTIFICAT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASSE`
--

DROP TABLE IF EXISTS `CLASSE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `CLASSE` (
  `CODECLASSE` varchar(5) NOT NULL,
  `CODECENTRE` varchar(5) NOT NULL,
  `CODEPROM` varchar(10) NOT NULL,
  `CODESECTION` varchar(10) NOT NULL,
  `NOMCLASSE` varchar(50) DEFAULT NULL,
  `CAPACITEMAX` int(11) DEFAULT NULL,
  PRIMARY KEY (`CODECLASSE`),
  KEY `I_FK_CLASSE_CENTRE` (`CODECENTRE`),
  KEY `I_FK_CLASSE_PROMOTION` (`CODEPROM`),
  KEY `I_FK_CLASSE_SECTION` (`CODESECTION`),
  CONSTRAINT `FK_CLASSE_CENTRE` FOREIGN KEY (`CODECENTRE`) REFERENCES `CENTRE` (`CODECENTRE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CLASSE_PROMOTION` FOREIGN KEY (`CODEPROM`) REFERENCES `PROMOTION` (`CODEPROM`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CLASSE_SECTION` FOREIGN KEY (`CODESECTION`) REFERENCES `SECTION` (`CODESECTION`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASSE`
--

LOCK TABLES `CLASSE` WRITE;
/*!40000 ALTER TABLE `CLASSE` DISABLE KEYS */;
/*!40000 ALTER TABLE `CLASSE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DIRECTION`
--

DROP TABLE IF EXISTS `DIRECTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `DIRECTION` (
  `CODEDIRECTION` varchar(10) NOT NULL,
  `NOMDIRECTION` varchar(100) NOT NULL,
  PRIMARY KEY (`CODEDIRECTION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DIRECTION`
--

LOCK TABLES `DIRECTION` WRITE;
/*!40000 ALTER TABLE `DIRECTION` DISABLE KEYS */;
INSERT INTO `DIRECTION` VALUES
('01','Direction Générale (DG)'),
('02','Direction de la Pédagogie et des Technologies Éducatives (DPTE)'),
('03','Direction Administrative et Financière (DAF)'),
('04','Direction des Examens et de la Certification (DEC)');
/*!40000 ALTER TABLE `DIRECTION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ELEMCONST`
--

DROP TABLE IF EXISTS `ELEMCONST`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ELEMCONST` (
  `CODEEC` varchar(5) NOT NULL,
  `CODEUE` varchar(10) NOT NULL,
  `CODESPECIALITE` varchar(20) NOT NULL,
  `NOMEC` varchar(50) DEFAULT NULL,
  `VOLUMEHORAIRE` int(11) DEFAULT NULL,
  `COEFF` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`CODEEC`),
  KEY `I_FK_ELEMCONST_UNITENS` (`CODEUE`),
  KEY `I_FK_ELEMCONST_SPECIALITE` (`CODESPECIALITE`),
  CONSTRAINT `FK_ELEMCONST_SPECIALITE` FOREIGN KEY (`CODESPECIALITE`) REFERENCES `SPECIALITE` (`CODESPECIALITE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ELEMCONST_UNITENS` FOREIGN KEY (`CODEUE`) REFERENCES `UNITENS` (`CODEUE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ELEMCONST`
--

LOCK TABLES `ELEMCONST` WRITE;
/*!40000 ALTER TABLE `ELEMCONST` DISABLE KEYS */;
/*!40000 ALTER TABLE `ELEMCONST` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ELEVEMAITRE`
--

DROP TABLE IF EXISTS `ELEVEMAITRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ELEVEMAITRE` (
  `MATRICULEELEVE` varchar(10) NOT NULL,
  `CODECLASSE` varchar(5) NOT NULL,
  `NUMCINELEVE` varchar(20) NOT NULL,
  `NOMELEVE` varchar(50) DEFAULT NULL,
  `PRENOMELEVE` varchar(50) DEFAULT NULL,
  `DATENAISSANCE` date DEFAULT NULL,
  `LIEUNAISSANCE` varchar(100) DEFAULT NULL,
  `SEXE` char(1) DEFAULT NULL,
  `NATIONALITE` varchar(50) DEFAULT 'Malagasy',
  `EST_BACHELIER` tinyint(1) NOT NULL DEFAULT 1,
  `ADRESSEELEVE` varchar(100) DEFAULT NULL,
  `TELEPHONEELEVE` varchar(30) DEFAULT NULL,
  `STATUTEXAMEN` enum('Autorisé','Disqualifié') DEFAULT 'Autorisé',
  `STATUTFINAL` enum('En cours','Admis','Non Admis') DEFAULT 'En cours',
  `CUMULABSENCE` decimal(5,2) DEFAULT 0.00,
  PRIMARY KEY (`MATRICULEELEVE`),
  UNIQUE KEY `NUMCINELEVE` (`NUMCINELEVE`),
  KEY `I_FK_ELEVEMAITRE_CLASSE` (`CODECLASSE`),
  CONSTRAINT `FK_ELEVEMAITRE_CLASSE` FOREIGN KEY (`CODECLASSE`) REFERENCES `CLASSE` (`CODECLASSE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ELEVEMAITRE`
--

LOCK TABLES `ELEVEMAITRE` WRITE;
/*!40000 ALTER TABLE `ELEVEMAITRE` DISABLE KEYS */;
/*!40000 ALTER TABLE `ELEVEMAITRE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ETRE_PRESENT`
--

DROP TABLE IF EXISTS `ETRE_PRESENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ETRE_PRESENT` (
  `MATRICULEELEVE` varchar(10) NOT NULL,
  `NUMSEANCE` int(11) NOT NULL,
  `ESTPRESENT` tinyint(1) DEFAULT NULL,
  `ESTJUSTIFIE` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`MATRICULEELEVE`,`NUMSEANCE`),
  KEY `I_FK_ETRE_PRESENT_ELEVEMAITRE` (`MATRICULEELEVE`),
  KEY `I_FK_ETRE_PRESENT_SEANCE` (`NUMSEANCE`),
  CONSTRAINT `FK_ETRE_PRESENT_ELEVEMAITRE` FOREIGN KEY (`MATRICULEELEVE`) REFERENCES `ELEVEMAITRE` (`MATRICULEELEVE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ETRE_PRESENT_SEANCE` FOREIGN KEY (`NUMSEANCE`) REFERENCES `SEANCE` (`NUMSEANCE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ETRE_PRESENT`
--

LOCK TABLES `ETRE_PRESENT` WRITE;
/*!40000 ALTER TABLE `ETRE_PRESENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `ETRE_PRESENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FORMATEUR`
--

DROP TABLE IF EXISTS `FORMATEUR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `FORMATEUR` (
  `NUMCINFORM` char(20) NOT NULL,
  `CODECENTRE` varchar(5) NOT NULL,
  `NOMFORMATEUR` varchar(50) DEFAULT NULL,
  `PRENOMFORMATEUR` varchar(50) DEFAULT NULL,
  `CONTACTFORMATEUR` varchar(50) DEFAULT NULL,
  `NATIONALITE` varchar(50) DEFAULT 'Malagasy',
  `EST_ACTIF` tinyint(1) DEFAULT 1,
  `ADRESSEFORMATEUR` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`NUMCINFORM`),
  KEY `I_FK_FORMATEUR_CENTRE` (`CODECENTRE`),
  CONSTRAINT `FK_FORMATEUR_CENTRE` FOREIGN KEY (`CODECENTRE`) REFERENCES `CENTRE` (`CODECENTRE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FORMATEUR`
--

LOCK TABLES `FORMATEUR` WRITE;
/*!40000 ALTER TABLE `FORMATEUR` DISABLE KEYS */;
/*!40000 ALTER TABLE `FORMATEUR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PARAMETRE_SYSTEME`
--

DROP TABLE IF EXISTS `PARAMETRE_SYSTEME`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PARAMETRE_SYSTEME` (
  `CLE` varchar(50) NOT NULL,
  `VALEUR` text DEFAULT NULL,
  `GROUPE` varchar(50) NOT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CLE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PARAMETRE_SYSTEME`
--

LOCK TABLES `PARAMETRE_SYSTEME` WRITE;
/*!40000 ALTER TABLE `PARAMETRE_SYSTEME` DISABLE KEYS */;
INSERT INTO `PARAMETRE_SYSTEME` VALUES
('app_name','INFP Madagascar','general','Nom principal de la plateforme'),
('app_subtitle','Administration Technique','general','Sous-titre ou description courte'),
('maintenance_mode','0','maintenance','État du mode maintenance (0 = Inactif, 1 = Actif)'),
('max_login_attempts','5','securite','Nombre maximal de tentatives de connexion échouées'),
('pwd_min_length','8','securite','Longueur minimale des mots de passe'),
('smtp_host','smtp.gmail.com','email','Serveur Hôte SMTP'),
('smtp_pass','password','email','Mot de passe ou clé d\'application SMTP'),
('smtp_port','587','email','Port du serveur SMTP'),
('smtp_user','barthelemeoange@gmail.com','email','Adresse e-mail expéditrice');
/*!40000 ALTER TABLE `PARAMETRE_SYSTEME` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PERMANENT`
--

DROP TABLE IF EXISTS `PERMANENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PERMANENT` (
  `NUMCINFORM` char(20) NOT NULL,
  `IMMFORMATEUR` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`NUMCINFORM`),
  CONSTRAINT `FK_PERMANENT_FORMATEUR` FOREIGN KEY (`NUMCINFORM`) REFERENCES `FORMATEUR` (`NUMCINFORM`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PERMANENT`
--

LOCK TABLES `PERMANENT` WRITE;
/*!40000 ALTER TABLE `PERMANENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `PERMANENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PROMOTION`
--

DROP TABLE IF EXISTS `PROMOTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PROMOTION` (
  `CODEPROM` varchar(10) NOT NULL,
  `NOMPROM` varchar(50) DEFAULT NULL,
  `ANNEEDEBUT` int(11) DEFAULT NULL,
  `ANNEEFIN` int(11) DEFAULT NULL,
  PRIMARY KEY (`CODEPROM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PROMOTION`
--

LOCK TABLES `PROMOTION` WRITE;
/*!40000 ALTER TABLE `PROMOTION` DISABLE KEYS */;
/*!40000 ALTER TABLE `PROMOTION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `QUALIFIER`
--

DROP TABLE IF EXISTS `QUALIFIER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `QUALIFIER` (
  `NUMCINFORM` char(20) NOT NULL,
  `CODESPECIALITE` varchar(20) NOT NULL,
  PRIMARY KEY (`NUMCINFORM`,`CODESPECIALITE`),
  KEY `I_FK_QUALIFIER_FORMATEUR` (`NUMCINFORM`),
  KEY `I_FK_QUALIFIER_SPECIALITE` (`CODESPECIALITE`),
  CONSTRAINT `FK_QUALIFIER_FORMATEUR` FOREIGN KEY (`NUMCINFORM`) REFERENCES `FORMATEUR` (`NUMCINFORM`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_QUALIFIER_SPECIALITE` FOREIGN KEY (`CODESPECIALITE`) REFERENCES `SPECIALITE` (`CODESPECIALITE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `QUALIFIER`
--

LOCK TABLES `QUALIFIER` WRITE;
/*!40000 ALTER TABLE `QUALIFIER` DISABLE KEYS */;
/*!40000 ALTER TABLE `QUALIFIER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SEANCE`
--

DROP TABLE IF EXISTS `SEANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `SEANCE` (
  `NUMSEANCE` int(11) NOT NULL AUTO_INCREMENT,
  `CODECLASSE` varchar(5) NOT NULL,
  `CODEEC` varchar(5) NOT NULL,
  `NUMCINFORM` char(20) NOT NULL,
  `DATESEANCE` date DEFAULT NULL,
  `HEUREDEBUT` time DEFAULT NULL,
  `HEUREFIN` time DEFAULT NULL,
  PRIMARY KEY (`NUMSEANCE`),
  KEY `I_FK_SEANCE_CLASSE` (`CODECLASSE`),
  KEY `I_FK_SEANCE_ELEMCONST` (`CODEEC`),
  KEY `I_FK_SEANCE_FORMATEUR` (`NUMCINFORM`),
  CONSTRAINT `FK_SEANCE_CLASSE` FOREIGN KEY (`CODECLASSE`) REFERENCES `CLASSE` (`CODECLASSE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SEANCE_ELEMCONST` FOREIGN KEY (`CODEEC`) REFERENCES `ELEMCONST` (`CODEEC`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SEANCE_FORMATEUR` FOREIGN KEY (`NUMCINFORM`) REFERENCES `FORMATEUR` (`NUMCINFORM`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SEANCE`
--

LOCK TABLES `SEANCE` WRITE;
/*!40000 ALTER TABLE `SEANCE` DISABLE KEYS */;
/*!40000 ALTER TABLE `SEANCE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SECTION`
--

DROP TABLE IF EXISTS `SECTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `SECTION` (
  `CODESECTION` varchar(10) NOT NULL,
  `NOMSECTION` varchar(50) NOT NULL,
  PRIMARY KEY (`CODESECTION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SECTION`
--

LOCK TABLES `SECTION` WRITE;
/*!40000 ALTER TABLE `SECTION` DISABLE KEYS */;
INSERT INTO `SECTION` VALUES
('EP','Enseignant primaire'),
('L1','Licence 1'),
('L2','Licence 2'),
('S1','Semestre 1'),
('S2','Semestre 2');
/*!40000 ALTER TABLE `SECTION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SPECIALITE`
--

DROP TABLE IF EXISTS `SPECIALITE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `SPECIALITE` (
  `CODESPECIALITE` varchar(20) NOT NULL,
  `LIBELLESPECIALITE` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CODESPECIALITE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SPECIALITE`
--

LOCK TABLES `SPECIALITE` WRITE;
/*!40000 ALTER TABLE `SPECIALITE` DISABLE KEYS */;
/*!40000 ALTER TABLE `SPECIALITE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SUIVRE`
--

DROP TABLE IF EXISTS `SUIVRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `SUIVRE` (
  `CODESECTION` varchar(10) NOT NULL,
  `CODEEC` varchar(5) NOT NULL,
  PRIMARY KEY (`CODESECTION`,`CODEEC`),
  KEY `I_FK_SUIVRE_SECTION` (`CODESECTION`),
  KEY `I_FK_SUIVRE_ELEMCONST` (`CODEEC`),
  CONSTRAINT `FK_SUIVRE_ELEMCONST` FOREIGN KEY (`CODEEC`) REFERENCES `ELEMCONST` (`CODEEC`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SUIVRE_SECTION` FOREIGN KEY (`CODESECTION`) REFERENCES `SECTION` (`CODESECTION`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SUIVRE`
--

LOCK TABLES `SUIVRE` WRITE;
/*!40000 ALTER TABLE `SUIVRE` DISABLE KEYS */;
/*!40000 ALTER TABLE `SUIVRE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UNITENS`
--

DROP TABLE IF EXISTS `UNITENS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `UNITENS` (
  `CODEUE` varchar(10) NOT NULL,
  `LIBELLEUE` varchar(50) DEFAULT NULL,
  `COEFFTOTAL` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`CODEUE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UNITENS`
--

LOCK TABLES `UNITENS` WRITE;
/*!40000 ALTER TABLE `UNITENS` DISABLE KEYS */;
/*!40000 ALTER TABLE `UNITENS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UTILISATEUR`
--

DROP TABLE IF EXISTS `UTILISATEUR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `UTILISATEUR` (
  `IMMUTILISATEUR` varchar(20) NOT NULL,
  `NOM` varchar(100) DEFAULT NULL,
  `PRENOMS` varchar(150) DEFAULT NULL,
  `TELEPHONE` varchar(20) DEFAULT NULL,
  `CODEDIRECTION` varchar(10) DEFAULT NULL,
  `CODECENTRE` varchar(5) DEFAULT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `MOTDEPASSE` varchar(255) NOT NULL,
  `PROFIL` enum('ADMIN','GESTIONNAIRE_CENTRAL','GESTIONNAIRE_CENTRE','RESPONSABLE_CENTRE') NOT NULL,
  `ACTIF` tinyint(1) DEFAULT 1,
  `PREMIERE_CONNEXION` tinyint(1) DEFAULT 1,
  `TENTATIVES_ECHOUEES` int(11) DEFAULT 0,
  PRIMARY KEY (`IMMUTILISATEUR`),
  UNIQUE KEY `uk_utilisateur_telephone` (`TELEPHONE`),
  KEY `I_FK_UTILISATEUR_DIRECTION` (`CODEDIRECTION`),
  KEY `I_FK_UTILISATEUR_CENTRE` (`CODECENTRE`),
  CONSTRAINT `FK_UTILISATEUR_CENTRE` FOREIGN KEY (`CODECENTRE`) REFERENCES `CENTRE` (`CODECENTRE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_UTILISATEUR_DIRECTION` FOREIGN KEY (`CODEDIRECTION`) REFERENCES `DIRECTION` (`CODEDIRECTION`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UTILISATEUR`
--

LOCK TABLES `UTILISATEUR` WRITE;
/*!40000 ALTER TABLE `UTILISATEUR` DISABLE KEYS */;
INSERT INTO `UTILISATEUR` VALUES
('000 001 - A','Barthelemeo','Brit',NULL,NULL,NULL,'ange@gmail.com','$2y$10$6r4Ofj7c4gmzjbadwEa3xOQLeFZ/Df8iY4gKQzryzf4mEFZLhmvpq','ADMIN',1,0,0),
('000 022-C','Jea','Flou',NULL,NULL,NULL,'ahej@gmail.com','$2y$10$N84bwgBLaMnUPrJ92h.Lf.szWS8KhgdUBOcIrssUDdmCYD1nrvSS2','GESTIONNAIRE_CENTRAL',0,1,0),
('000001','Haja','Tahiana',NULL,'04',NULL,'barthelemeoange@gmail.com','$2y$10$VUr50iAa1R2maWCJ.aRCeeU1HrtEZs.lEKjVB7FFkDu4VnrFV6IE.','GESTIONNAIRE_CENTRAL',1,1,0),
('001 002-R','Haja','Jean',NULL,NULL,'20101','Jean@gmail.com','$2y$10$hDkbsStBAEN15TLgBB.Xs.bcC8m7hMw8c6r0pLkpbXrVYmH6S9RfG','RESPONSABLE_CENTRE',0,1,0),
('001 201-B','fdy','haja',NULL,NULL,'30101','jj@gmail.com','$2y$10$PmGh24FJn0REGvB.KsrbM.jhxFIUQz/FGAZyBddIL0p0N9oJ7JVAu','GESTIONNAIRE_CENTRE',1,1,0),
('001 236-R','TSIRESYgggggg','Freedom',NULL,NULL,'40101','tee@gmail.com','$2y$10$dRVH66l.Ce2YYMuPJdOTlu1I5miLHOX3na2YVoOWW5U/hkPnuraAO','RESPONSABLE_CENTRE',0,1,0),
('002','haha','kolo',NULL,NULL,NULL,'haja@gmail.com','$2y$10$5P1zdM/rJSQW9iFi6gUFxekdT9NkHktUn4bTIg4O3C8vPHITENQAi','GESTIONNAIRE_CENTRAL',1,1,0),
('002 001-R','Brit','Gang',NULL,NULL,'60101','barthelemeoa@gmail.com','$2y$10$9XGDuWf97o2JPZGNWSmGFOxWeLRkgEdujtfrXzsJKIiqOdpGV4CDm','RESPONSABLE_CENTRE',0,0,0),
('002 005-C','Ange','Brit',NULL,'02',NULL,'barthelemeoange@gmail.com','$2y$10$JeduoyaOVWkfkZoLcKBUUe9AE8/TI9TV.yjIgHM3IcPZqbwccfM2O','GESTIONNAIRE_CENTRAL',1,1,0),
('002 014-B','Badzo','Freddy',NULL,NULL,'20101','britange777@gmail.com','$2y$10$nmiQDS8FfgnSmCpq9mVsuuDN.QdptBFh1cRgb7itY/gE6eAgR2Sya','GESTIONNAIRE_CENTRE',1,0,0),
('014 789-C','gang','brit',NULL,NULL,NULL,'brit@gmail.com','$2y$10$zp5JhLDPx4mvYeZ5e9i5R.yIp7n8w6pkvidLozIbIWrXiwEWh.VyS','GESTIONNAIRE_CENTRAL',0,1,0),
('123 478-C','gej','dd',NULL,'01',NULL,'britgang33@gmail.com','$2y$10$/TkTHTg9NpcXAshJGWP11On6UIVHCpZMm5xfNWx8f9S17a.GXZEgO','GESTIONNAIRE_CENTRAL',1,1,0),
('124 999-C','Tsiresy','Gerard',NULL,NULL,NULL,'pattysoaniaina@gmail.com','$2y$10$7mq7mk1gerHWu/XR4r3azOOxO9cDPRG6CqH2lWMQeqd9CftyrCH46','GESTIONNAIRE_CENTRAL',1,1,0),
('145 698-C','hh','ggggg',NULL,NULL,NULL,'sarobidytsilavina83@gmail.com','$2y$10$jT9PV2kgr7Caj5BeqZx3vOwmi6yfZeEwgERdFcIPhaNn5LwN014DG','GESTIONNAIRE_CENTRAL',1,0,0);
/*!40000 ALTER TABLE `UTILISATEUR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `VACATAIRE`
--

DROP TABLE IF EXISTS `VACATAIRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `VACATAIRE` (
  `NUMCINFORM` char(20) NOT NULL,
  `CODEVAC` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`NUMCINFORM`),
  CONSTRAINT `FK_VACATAIRE_FORMATEUR` FOREIGN KEY (`NUMCINFORM`) REFERENCES `FORMATEUR` (`NUMCINFORM`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VACATAIRE`
--

LOCK TABLES `VACATAIRE` WRITE;
/*!40000 ALTER TABLE `VACATAIRE` DISABLE KEYS */;
/*!40000 ALTER TABLE `VACATAIRE` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-25 22:23:10
