-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: test_db
-- ------------------------------------------------------
-- Server version	5.7.41

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
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso2` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Afghanistan','AF'),(2,'Aland Islands','AX'),(3,'Albania','AL'),(4,'Algeria','DZ'),(5,'American Samoa','AS'),(6,'Andorra','AD'),(7,'Angola','AO'),(8,'Anguilla','AI'),(9,'Antarctica','AQ'),(10,'Antigua And Barbuda','AG'),(11,'Argentina','AR'),(12,'Armenia','AM'),(13,'Aruba','AW'),(14,'Australia','AU'),(15,'Austria','AT'),(16,'Azerbaijan','AZ'),(17,'The Bahamas','BS'),(18,'Bahrain','BH'),(19,'Bangladesh','BD'),(20,'Barbados','BB'),(21,'Belarus','BY'),(22,'Belgium','BE'),(23,'Belize','BZ'),(24,'Benin','BJ'),(25,'Bermuda','BM'),(26,'Bhutan','BT'),(27,'Bolivia','BO'),(28,'Bosnia and Herzegovina','BA'),(29,'Botswana','BW'),(30,'Bouvet Island','BV'),(31,'Brazil','BR'),(32,'British Indian Ocean Territory','IO'),(33,'Brunei','BN'),(34,'Bulgaria','BG'),(35,'Burkina Faso','BF'),(36,'Burundi','BI'),(37,'Cambodia','KH'),(38,'Cameroon','CM'),(39,'Canada','CA'),(40,'Cape Verde','CV'),(41,'Cayman Islands','KY'),(42,'Central African Republic','CF'),(43,'Chad','TD'),(44,'Chile','CL'),(45,'China','CN'),(46,'Christmas Island','CX'),(47,'Cocos (Keeling) Islands','CC'),(48,'Colombia','CO'),(49,'Comoros','KM'),(50,'Congo','CG'),(51,'Democratic Republic of the Congo','CD'),(52,'Cook Islands','CK'),(53,'Costa Rica','CR'),(54,'Cote D\'Ivoire (Ivory Coast)','CI'),(55,'Croatia','HR'),(56,'Cuba','CU'),(57,'Cyprus','CY'),(58,'Czech Republic','CZ'),(59,'Denmark','DK'),(60,'Djibouti','DJ'),(61,'Dominica','DM'),(62,'Dominican Republic','DO'),(63,'East Timor','TL'),(64,'Ecuador','EC'),(65,'Egypt','EG'),(66,'El Salvador','SV'),(67,'Equatorial Guinea','GQ'),(68,'Eritrea','ER'),(69,'Estonia','EE'),(70,'Ethiopia','ET'),(71,'Falkland Islands','FK'),(72,'Faroe Islands','FO'),(73,'Fiji Islands','FJ'),(74,'Finland','FI'),(75,'France','FR'),(76,'French Guiana','GF'),(77,'French Polynesia','PF'),(78,'French Southern Territories','TF'),(79,'Gabon','GA'),(80,'Gambia The','GM'),(81,'Georgia','GE'),(82,'Germany','DE'),(83,'Ghana','GH'),(84,'Gibraltar','GI'),(85,'Greece','GR'),(86,'Greenland','GL'),(87,'Grenada','GD'),(88,'Guadeloupe','GP'),(89,'Guam','GU'),(90,'Guatemala','GT'),(91,'Guernsey and Alderney','GG'),(92,'Guinea','GN'),(93,'Guinea-Bissau','GW'),(94,'Guyana','GY'),(95,'Haiti','HT'),(96,'Heard Island and McDonald Islands','HM'),(97,'Honduras','HN'),(98,'Hong Kong S.A.R.','HK'),(99,'Hungary','HU'),(100,'Iceland','IS'),(101,'India','IN'),(102,'Indonesia','ID'),(103,'Iran','IR'),(104,'Iraq','IQ'),(105,'Ireland','IE'),(106,'Israel','IL'),(107,'Italy','IT'),(108,'Jamaica','JM'),(109,'Japan','JP'),(110,'Jersey','JE'),(111,'Jordan','JO'),(112,'Kazakhstan','KZ'),(113,'Kenya','KE'),(114,'Kiribati','KI'),(115,'North Korea','KP'),(116,'South Korea','KR'),(117,'Kuwait','KW'),(118,'Kyrgyzstan','KG'),(119,'Laos','LA'),(120,'Latvia','LV'),(121,'Lebanon','LB'),(122,'Lesotho','LS'),(123,'Liberia','LR'),(124,'Libya','LY'),(125,'Liechtenstein','LI'),(126,'Lithuania','LT'),(127,'Luxembourg','LU'),(128,'Macau S.A.R.','MO'),(129,'North Macedonia','MK'),(130,'Madagascar','MG'),(131,'Malawi','MW'),(132,'Malaysia','MY'),(133,'Maldives','MV'),(134,'Mali','ML'),(135,'Malta','MT'),(136,'Man (Isle of)','IM'),(137,'Marshall Islands','MH'),(138,'Martinique','MQ'),(139,'Mauritania','MR'),(140,'Mauritius','MU'),(141,'Mayotte','YT'),(142,'Mexico','MX'),(143,'Micronesia','FM'),(144,'Moldova','MD'),(145,'Monaco','MC'),(146,'Mongolia','MN'),(147,'Montenegro','ME'),(148,'Montserrat','MS'),(149,'Morocco','MA'),(150,'Mozambique','MZ'),(151,'Myanmar','MM'),(152,'Namibia','NA'),(153,'Nauru','NR'),(154,'Nepal','NP'),(155,'Bonaire, Sint Eustatius and Saba','BQ'),(156,'Netherlands','NL'),(157,'New Caledonia','NC'),(158,'New Zealand','NZ'),(159,'Nicaragua','NI'),(160,'Niger','NE'),(161,'Nigeria','NG'),(162,'Niue','NU'),(163,'Norfolk Island','NF'),(164,'Northern Mariana Islands','MP'),(165,'Norway','NO'),(166,'Oman','OM'),(167,'Pakistan','PK'),(168,'Palau','PW'),(169,'Palestinian Territory Occupied','PS'),(170,'Panama','PA'),(171,'Papua new Guinea','PG'),(172,'Paraguay','PY'),(173,'Peru','PE'),(174,'Philippines','PH'),(175,'Pitcairn Island','PN'),(176,'Poland','PL'),(177,'Portugal','PT'),(178,'Puerto Rico','PR'),(179,'Qatar','QA'),(180,'Reunion','RE'),(181,'Romania','RO'),(182,'Russia','RU'),(183,'Rwanda','RW'),(184,'Saint Helena','SH'),(185,'Saint Kitts And Nevis','KN'),(186,'Saint Lucia','LC'),(187,'Saint Pierre and Miquelon','PM'),(188,'Saint Vincent And The Grenadines','VC'),(189,'Saint-Barthelemy','BL'),(190,'Saint-Martin (French part)','MF'),(191,'Samoa','WS'),(192,'San Marino','SM'),(193,'Sao Tome and Principe','ST'),(194,'Saudi Arabia','SA'),(195,'Senegal','SN'),(196,'Serbia','RS'),(197,'Seychelles','SC'),(198,'Sierra Leone','SL'),(199,'Singapore','SG'),(200,'Slovakia','SK'),(201,'Slovenia','SI'),(202,'Solomon Islands','SB'),(203,'Somalia','SO'),(204,'South Africa','ZA'),(205,'South Georgia','GS'),(206,'South Sudan','SS'),(207,'Spain','ES'),(208,'Sri Lanka','LK'),(209,'Sudan','SD'),(210,'Suriname','SR'),(211,'Svalbard And Jan Mayen Islands','SJ'),(212,'Swaziland','SZ'),(213,'Sweden','SE'),(214,'Switzerland','CH'),(215,'Syria','SY'),(216,'Taiwan','TW'),(217,'Tajikistan','TJ'),(218,'Tanzania','TZ'),(219,'Thailand','TH'),(220,'Togo','TG'),(221,'Tokelau','TK'),(222,'Tonga','TO'),(223,'Trinidad And Tobago','TT'),(224,'Tunisia','TN'),(225,'Turkey','TR'),(226,'Turkmenistan','TM'),(227,'Turks And Caicos Islands','TC'),(228,'Tuvalu','TV'),(229,'Uganda','UG'),(230,'Ukraine','UA'),(231,'United Arab Emirates','AE'),(232,'United Kingdom','GB'),(233,'United States','US'),(234,'United States Minor Outlying Islands','UM'),(235,'Uruguay','UY'),(236,'Uzbekistan','UZ'),(237,'Vanuatu','VU'),(238,'Vatican City State (Holy See)','VA'),(239,'Venezuela','VE'),(240,'Vietnam','VN'),(241,'Virgin Islands (British)','VG'),(242,'Virgin Islands (US)','VI'),(243,'Wallis And Futuna Islands','WF'),(244,'Western Sahara','EH'),(245,'Yemen','YE'),(246,'Zambia','ZM'),(247,'Zimbabwe','ZW'),(248,'Kosovo','XK'),(249,'Curaçao','CW'),(250,'Sint Maarten (Dutch part)','SX');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-27  3:58:44
