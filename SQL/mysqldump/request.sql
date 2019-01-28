-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: VETERINARY_2
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

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
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request` (
  `id_req` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `pet_name` varchar(40) DEFAULT NULL,
  `specie` varchar(40) NOT NULL,
  `age` int(3) unsigned DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  `comment` text,
  `time_req` int(10) unsigned NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_req`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request`
--

LOCK TABLES `request` WRITE;
/*!40000 ALTER TABLE `request` DISABLE KEYS */;
INSERT INTO `request` VALUES (1,1,'Eclipse','CHAT',10,'F','<p style=\"\">fdxcghbklm&ugrave;;jkl,</p><p style=\"\">rycughu<br></p>',1515598031,0),(2,1,'Vannile','Chat',9,'F','<p style=\"\">Pour prendre rendez-vous, vous devez remplir ce formulaire en y indiquant le nom, l&#39;ann&eacute;e de naissance, le sexe, l&#39;esp&egrave;ce, ainsi que le motif de celui-ci. Essayez de remplir ce formulaire avec le plus de d&eacute;tails possible car cela nous permettra de vous donner un rendez-vous qui correspond le plus possible a vos attentes. Nous vous r&eacute;pondrons par mail tr&egrave;s prochainement.</p>',1515598258,0),(3,1,'Samy','Tigre',10,'M','<p style=\"\">sieurs variations de Lorem Ipsum peuvent &ecirc;tre trouv&eacute;es ici ou l&agrave;, mais la majeure partie d&#39;entre elles a &eacute;t&eacute; alt&eacute;r&eacute;e par l&#39;addition d&#39;humour ou de mots al&eacute;atoires qui ne ressemblent pas une seconde &agrave; du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez &ecirc;tre s&ucirc;r qu&#39;il n&#39;y a rien d&#39;embarrassant cach&eacute; dans le texte. Tous les g&eacute;n&eacute;rateurs de Lorem Ipsum sur Internet tendent &agrave; reproduire le m&ecirc;me extrait sans fin, ce qui fait de <a href=\"lipsum.com\">lipsum.com</a> le seul vrai g&eacute;n&eacute;rateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour g&eacute;n&eacute;rer un Lorem Ipsum irr&eacute;prochable. Le Lorem Ipsum ainsi obtenu ne contient aucune r&eacute;p&eacute;tition, ni ne contient des mots farfelus, ou des touches d&#39;humour.</p>',1515598338,0),(4,1,'Tifou','Lynx',0,'0','<p style=\"\">ydney College, en Virginie, s&#39;est int&eacute;ress&eacute; &agrave; un des mots latins les plus obscurs, consectetur, extrait d&#39;un passage du Lorem Ipsum, et en &eacute;tudiant tous les usages de ce mot dans la litt&eacute;rature classique, d&eacute;couvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du &quot;De Finibus Bonorum et Malorum&quot; (Des Supr&ecirc;mes Biens et des Supr&ecirc;mes Maux) de Cic&eacute;ron. Cet ouvrage, tr&egrave;s populaire pendant la Renaissance, est un trait&eacute; sur la th&eacute;orie de l&#39;&eacute;thique. Les premi&egrave;res lignes du Lorem Ipsum, &quot;Lorem ipsum dolor sit amet...&quot;, proviennent de la section 1.10.32.</p>',1515598555,0);
/*!40000 ALTER TABLE `request` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-14 15:24:54
