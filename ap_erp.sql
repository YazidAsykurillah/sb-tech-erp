-- MariaDB dump 10.17  Distrib 10.4.8-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: app_erp
-- ------------------------------------------------------
-- Server version	10.4.8-MariaDB-1:10.4.8+maria~bionic

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
-- Table structure for table `accounting_expenses`
--

DROP TABLE IF EXISTS `accounting_expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounting_expenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounting_expenses_code_unique` (`code`),
  UNIQUE KEY `accounting_expenses_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting_expenses`
--

LOCK TABLES `accounting_expenses` WRITE;
/*!40000 ALTER TABLE `accounting_expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounting_expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `allowance_items`
--

DROP TABLE IF EXISTS `allowance_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allowance_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `allowance_id` int(11) NOT NULL,
  `type` enum('transportation','meal') COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allowance_items`
--

LOCK TABLES `allowance_items` WRITE;
/*!40000 ALTER TABLE `allowance_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `allowance_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `allowances`
--

DROP TABLE IF EXISTS `allowances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allowances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allowances`
--

LOCK TABLES `allowances` WRITE;
/*!40000 ALTER TABLE `allowances` DISABLE KEYS */;
/*!40000 ALTER TABLE `allowances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_categories`
--

DROP TABLE IF EXISTS `asset_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_categories`
--

LOCK TABLES `asset_categories` WRITE;
/*!40000 ALTER TABLE `asset_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Harga aset',
  `asset_category_id` int(11) DEFAULT NULL COMMENT 'Asset category, related to AssetCategory model',
  `type` enum('current','fixed','intangible') COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Current = lancar, fixed = tetap, intangible = tidak berwujud',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assets_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_accounts`
--

DROP TABLE IF EXISTS `bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_accounts`
--

LOCK TABLES `bank_accounts` WRITE;
/*!40000 ALTER TABLE `bank_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_administrations`
--

DROP TABLE IF EXISTS `bank_administrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_administrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cash_id` int(11) NOT NULL,
  `refference_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The refference number from the bank',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bank_administrations_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_administrations`
--

LOCK TABLES `bank_administrations` WRITE;
/*!40000 ALTER TABLE `bank_administrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_administrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bpjs_kesehatans`
--

DROP TABLE IF EXISTS `bpjs_kesehatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bpjs_kesehatans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bpjs_kesehatans`
--

LOCK TABLES `bpjs_kesehatans` WRITE;
/*!40000 ALTER TABLE `bpjs_kesehatans` DISABLE KEYS */;
/*!40000 ALTER TABLE `bpjs_kesehatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bpjs_ketenagakerjaans`
--

DROP TABLE IF EXISTS `bpjs_ketenagakerjaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bpjs_ketenagakerjaans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bpjs_ketenagakerjaans`
--

LOCK TABLES `bpjs_ketenagakerjaans` WRITE;
/*!40000 ALTER TABLE `bpjs_ketenagakerjaans` DISABLE KEYS */;
/*!40000 ALTER TABLE `bpjs_ketenagakerjaans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashbond_installments`
--

DROP TABLE IF EXISTS `cashbond_installments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashbond_installments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cashbond_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `installment_schedule` date DEFAULT NULL,
  `status` enum('paid','unpaid') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashbond_installments`
--

LOCK TABLES `cashbond_installments` WRITE;
/*!40000 ALTER TABLE `cashbond_installments` DISABLE KEYS */;
/*!40000 ALTER TABLE `cashbond_installments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashbond_sites`
--

DROP TABLE IF EXISTS `cashbond_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashbond_sites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','checked','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_date` date DEFAULT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `cash_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cashbond_sites_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashbond_sites`
--

LOCK TABLES `cashbond_sites` WRITE;
/*!40000 ALTER TABLE `cashbond_sites` DISABLE KEYS */;
/*!40000 ALTER TABLE `cashbond_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashbonds`
--

DROP TABLE IF EXISTS `cashbonds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashbonds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','checked','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_date` date DEFAULT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `accounted_approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `remitter_bank_id` int(11) DEFAULT NULL,
  `cut_from_salary` tinyint(1) NOT NULL DEFAULT 0,
  `term` int(11) NOT NULL DEFAULT 1,
  `payment_status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cashbonds_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashbonds`
--

LOCK TABLES `cashbonds` WRITE;
/*!40000 ALTER TABLE `cashbonds` DISABLE KEYS */;
/*!40000 ALTER TABLE `cashbonds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashes`
--

DROP TABLE IF EXISTS `cashes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('cash','bank') COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cashes_name_unique` (`name`),
  UNIQUE KEY `cashes_account_number_unique` (`account_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashes`
--

LOCK TABLES `cashes` WRITE;
/*!40000 ALTER TABLE `cashes` DISABLE KEYS */;
INSERT INTO `cashes` VALUES (1,'bank','Mandiri','111111','Test',0.00,'2019-11-26 00:28:11','2019-11-26 00:28:11',1);
/*!40000 ALTER TABLE `cashes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competency_allowances`
--

DROP TABLE IF EXISTS `competency_allowances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competency_allowances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competency_allowances`
--

LOCK TABLES `competency_allowances` WRITE;
/*!40000 ALTER TABLE `competency_allowances` DISABLE KEYS */;
/*!40000 ALTER TABLE `competency_allowances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configurations`
--

DROP TABLE IF EXISTS `configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configurations_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configurations`
--

LOCK TABLES `configurations` WRITE;
/*!40000 ALTER TABLE `configurations` DISABLE KEYS */;
INSERT INTO `configurations` VALUES (49,'estimated-cost-margin-limit','15',NULL,NULL),(50,'prefix-invoice-customer','INVC',NULL,NULL),(51,'company-logo','http://localhost/img/logo-sbt.jpeg',NULL,NULL),(52,'company-office','Jl. Raya Ciangsana, Ruko SA 1 No.24\nVilla Nusa Indah 5, Ciangsana, Gunung Putri, Kab. Bogor\nJawa Barat 16968 - Indonesia\n                        ',NULL,NULL),(53,'company-worskhop','Jl. Raya Ciangsana, Ruko SA 1 No.24\nVilla Nusa Indah 5, Ciangsana, Gunung Putri, Kab. Bogor\nJawa Barat 16968 - Indonesia',NULL,NULL),(54,'company-bank-account','Bank Syariah Mandiri Cabang Jatibening\n(IDR) Acc. No. 7891113336 : PT. Sedulang Bintang Teknik',NULL,NULL);
/*!40000 ALTER TABLE `configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Block, Schmidt and Frami','661.693.7775','84515 Adell Path\nJerrybury, UT 30696-6834','2019-11-16 07:45:57','2019-11-16 07:45:57'),(2,'Armstrong and Sons','847.651.7394','141 Jaime Brook Suite 797\nWest Melyssahaven, MO 69231','2019-11-16 07:45:57','2019-11-16 07:45:57'),(3,'Moen, Hayes and Lueilwitz','573.953.8924 x76008','2781 Dietrich Dam\nMaeganhaven, HI 04037','2019-11-16 07:45:57','2019-11-16 07:45:57'),(4,'Veum Ltd','1-294-846-4727 x640','2378 Shea Fields Apt. 906\nAbbyfurt, AK 35606-6296','2019-11-16 07:45:57','2019-11-16 07:45:57'),(5,'Heidenreich PLC','650-868-4948','568 Auer Trace\nEast Daijaberg, NV 45474','2019-11-16 07:45:57','2019-11-16 07:45:57'),(6,'O\'Kon PLC','1-391-943-5456 x8116','79005 Gorczany Junction Suite 490\nReinholdview, CT 16264','2019-11-16 07:45:57','2019-11-16 07:45:57'),(7,'Kerluke PLC','1-989-715-0557 x92739','84956 Randy Stravenue Suite 840\nEast Derrickfort, IN 72070-5755','2019-11-16 07:45:57','2019-11-16 07:45:57'),(8,'Dare Inc','447.553.6612 x782','4590 Willow Trace Suite 931\nEnochfurt, RI 13948','2019-11-16 07:45:58','2019-11-16 07:45:58'),(9,'Blanda, Heidenreich and Reilly','(818) 742-5507 x3604','38740 Anderson Bypass\nMohrmouth, NC 18835','2019-11-16 07:45:58','2019-11-16 07:45:58'),(10,'Fahey, Weimann and Pagac','991-744-7066 x3976','39245 Hilpert Burgs Suite 203\nKautzerhaven, MD 16184-8377','2019-11-16 07:45:58','2019-11-16 07:45:58');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_orders`
--

DROP TABLE IF EXISTS `delivery_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Creator',
  `sender_id` int(11) NOT NULL,
  `status` enum('draft','delivered','received') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `receiver` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `delivery_orders_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_orders`
--

LOCK TABLES `delivery_orders` WRITE;
/*!40000 ALTER TABLE `delivery_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ets`
--

DROP TABLE IF EXISTS `ets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `the_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `normal` decimal(20,2) DEFAULT NULL,
  `I` decimal(20,2) DEFAULT NULL,
  `II` decimal(20,2) DEFAULT NULL,
  `III` decimal(20,2) DEFAULT NULL,
  `IV` decimal(20,2) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `plant` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location` enum('site-local','site-non-local','workshop') COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('site','office','other') COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_incentive_week_day` tinyint(1) NOT NULL DEFAULT 0,
  `has_incentive_week_end` tinyint(1) NOT NULL DEFAULT 0,
  `checker_notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_manhour` decimal(20,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Man hour rate of the user',
  `transport` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'transport rate of the user',
  `allowance` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'allowance rate of the user',
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'total cost per project per day for the user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ets`
--

LOCK TABLES `ets` WRITE;
/*!40000 ALTER TABLE `ets` DISABLE KEYS */;
/*!40000 ALTER TABLE `ets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extra_payroll_payments`
--

DROP TABLE IF EXISTS `extra_payroll_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extra_payroll_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `type` enum('adder','substractor') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'adder',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extra_payroll_payments`
--

LOCK TABLES `extra_payroll_payments` WRITE;
/*!40000 ALTER TABLE `extra_payroll_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `extra_payroll_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incentive_week_days`
--

DROP TABLE IF EXISTS `incentive_week_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incentive_week_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incentive_week_days`
--

LOCK TABLES `incentive_week_days` WRITE;
/*!40000 ALTER TABLE `incentive_week_days` DISABLE KEYS */;
/*!40000 ALTER TABLE `incentive_week_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incentive_week_ends`
--

DROP TABLE IF EXISTS `incentive_week_ends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incentive_week_ends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incentive_week_ends`
--

LOCK TABLES `incentive_week_ends` WRITE;
/*!40000 ALTER TABLE `incentive_week_ends` DISABLE KEYS */;
/*!40000 ALTER TABLE `incentive_week_ends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internal_requests`
--

DROP TABLE IF EXISTS `internal_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `internal_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Internal request number',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `remitter_bank_id` int(11) NOT NULL COMMENT 'Bank pengirim, taken from Cash model',
  `beneficiary_bank_id` int(11) NOT NULL COMMENT 'Bank penerima, taken from Bank Account model',
  `project_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL COMMENT 'the user who make the internal request',
  `status` enum('pending','checked','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `approver_id` int(11) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `settled` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Define if this IR has settled or not',
  `accounted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Define is this accounted on cash or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_petty_cash` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'define if this IR is petty cash or not',
  `type` enum('material','operational','pindah_buku') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'operational',
  `accounted_approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'Check the condition of accounted status of this internal request',
  `vendor_id` int(11) DEFAULT NULL,
  `bank_target_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `internal_requests_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internal_requests`
--

LOCK TABLES `internal_requests` WRITE;
/*!40000 ALTER TABLE `internal_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `internal_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_customer_taxes`
--

DROP TABLE IF EXISTS `invoice_customer_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_customer_taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_customer_id` int(11) NOT NULL,
  `source` enum('vat','wht') COLLATE utf8_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(20,2) NOT NULL,
  `status` enum('pending','paid') COLLATE utf8_unicode_ci NOT NULL,
  `approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cash_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_customer_taxes`
--

LOCK TABLES `invoice_customer_taxes` WRITE;
/*!40000 ALTER TABLE `invoice_customer_taxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_customer_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_customers`
--

DROP TABLE IF EXISTS `invoice_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Initial amount taken from item price summary',
  `vat` int(11) NOT NULL DEFAULT 0,
  `wht` decimal(20,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('pending','paid') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `submitted_date` date NOT NULL DEFAULT '2019-11-16',
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `prepared_by` int(11) DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `discount_value` decimal(20,2) NOT NULL DEFAULT 0.00,
  `after_discount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `down_payment` decimal(20,2) NOT NULL DEFAULT 0.00,
  `down_payment_value` decimal(20,2) NOT NULL DEFAULT 0.00,
  `vat_value` decimal(20,2) NOT NULL DEFAULT 0.00,
  `type` enum('dp','term','pelunasan','billing') COLLATE utf8_unicode_ci DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `tax_date` date DEFAULT NULL,
  `cash_id` int(11) DEFAULT NULL,
  `claimed_by_salesman` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Define if invoice is already claimed by the salesman',
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_customers_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_customers`
--

LOCK TABLES `invoice_customers` WRITE;
/*!40000 ALTER TABLE `invoice_customers` DISABLE KEYS */;
INSERT INTO `invoice_customers` VALUES (1,1,'INV-19-11-001','fffff',1000.00,0,0.00,1000.00,'2019-11-14',NULL,'pending','2019-11-16',0,'2019-11-16 02:30:07','2019-11-18 05:55:16',0,NULL,0.00,0.00,1000.00,100.00,1000.00,0.00,'pelunasan','2019-11-01','2019-11-01',NULL,0);
/*!40000 ALTER TABLE `invoice_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_vendor_taxes`
--

DROP TABLE IF EXISTS `invoice_vendor_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_vendor_taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_vendor_id` int(11) NOT NULL,
  `source` enum('vat','wht') COLLATE utf8_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(20,2) NOT NULL,
  `status` enum('pending','paid') COLLATE utf8_unicode_ci NOT NULL,
  `approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cash_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_vendor_taxes`
--

LOCK TABLES `invoice_vendor_taxes` WRITE;
/*!40000 ALTER TABLE `invoice_vendor_taxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_vendor_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_vendors`
--

DROP TABLE IF EXISTS `invoice_vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_vendors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Invoice vendor number',
  `tax_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `project_id` int(11) NOT NULL,
  `purchase_order_vendor_id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','paid') COLLATE utf8_unicode_ci NOT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `received_date` date NOT NULL DEFAULT '2019-11-16',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cash_id` int(11) DEFAULT NULL COMMENT 'The source cash of this invoice vendor to be transacted',
  `accounted_approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `sub_total` decimal(20,2) NOT NULL DEFAULT 0.00,
  `discount` int(11) NOT NULL DEFAULT 0,
  `after_discount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `vat` int(11) NOT NULL DEFAULT 0,
  `vat_amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `wht_amount` decimal(20,2) NOT NULL,
  `type` enum('dp','term','pelunasan') COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount_before_type` decimal(20,2) DEFAULT NULL,
  `type_percent` int(11) NOT NULL DEFAULT 0,
  `amount_from_type` decimal(20,2) DEFAULT NULL,
  `tax_date` date DEFAULT NULL,
  `bill_amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_vendors_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_vendors`
--

LOCK TABLES `invoice_vendors` WRITE;
/*!40000 ALTER TABLE `invoice_vendors` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_vendors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_delivery_order`
--

DROP TABLE IF EXISTS `item_delivery_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_delivery_order` (
  `delivery_order_id` int(11) NOT NULL,
  `item_purchase_request_id` int(11) NOT NULL,
  `quantity` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_delivery_order`
--

LOCK TABLES `item_delivery_order` WRITE;
/*!40000 ALTER TABLE `item_delivery_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_delivery_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_invoice_customer`
--

DROP TABLE IF EXISTS `item_invoice_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_invoice_customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_customer_id` text COLLATE utf8_unicode_ci NOT NULL,
  `item` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_invoice_customer`
--

LOCK TABLES `item_invoice_customer` WRITE;
/*!40000 ALTER TABLE `item_invoice_customer` DISABLE KEYS */;
INSERT INTO `item_invoice_customer` VALUES (3,'1','item 1','1','t',1000.00,1000.00);
/*!40000 ALTER TABLE `item_invoice_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_purchase_order_vendor`
--

DROP TABLE IF EXISTS `item_purchase_order_vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_purchase_order_vendor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_vendor_id` text COLLATE utf8_unicode_ci NOT NULL,
  `item` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_purchase_order_vendor`
--

LOCK TABLES `item_purchase_order_vendor` WRITE;
/*!40000 ALTER TABLE `item_purchase_order_vendor` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_purchase_order_vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_purchase_request`
--

DROP TABLE IF EXISTS `item_purchase_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_purchase_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_request_id` text COLLATE utf8_unicode_ci NOT NULL,
  `item` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL,
  `is_received` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_purchase_request`
--

LOCK TABLES `item_purchase_request` WRITE;
/*!40000 ALTER TABLE `item_purchase_request` DISABLE KEYS */;
INSERT INTO `item_purchase_request` VALUES (1,'1','Baut','10','pcs',1000.00,10000.00,0,NULL,NULL),(2,'2','ttt','1','r',1.00,1.00,0,NULL,NULL);
/*!40000 ALTER TABLE `item_purchase_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leaves` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaves`
--

LOCK TABLES `leaves` WRITE;
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'NULL if this location is the MASTER parent location, example : office, warehouse building, ... etc',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Can be used to describe about the material to store in this location',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `locations_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lock_configurations`
--

DROP TABLE IF EXISTS `lock_configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lock_configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facility_name` enum('create_internal_request','create_project','create_cashbond') COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lock_configurations`
--

LOCK TABLES `lock_configurations` WRITE;
/*!40000 ALTER TABLE `lock_configurations` DISABLE KEYS */;
/*!40000 ALTER TABLE `lock_configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_allowances`
--

DROP TABLE IF EXISTS `medical_allowances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_allowances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_allowances`
--

LOCK TABLES `medical_allowances` WRITE;
/*!40000 ALTER TABLE `medical_allowances` DISABLE KEYS */;
/*!40000 ALTER TABLE `medical_allowances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migos`
--

DROP TABLE IF EXISTS `migos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_request_id` int(11) DEFAULT NULL,
  `creator_id` int(11) NOT NULL COMMENT 'The user id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `migos_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migos`
--

LOCK TABLES `migos` WRITE;
/*!40000 ALTER TABLE `migos` DISABLE KEYS */;
/*!40000 ALTER TABLE `migos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2017_03_25_175938_create_permissions_table',1),('2017_03_25_180028_create_roles_table',1),('2017_03_25_180446_create_permission_role_table',1),('2017_03_25_180549_create_role_user_table',1),('2017_03_25_191644_create_bank_accounts_table',1),('2017_03_26_082742_create_customers_table',1),('2017_03_26_101217_create_vendors_table',1),('2017_04_05_155019_create_purchase_order_customers_table',1),('2017_04_14_143528_create_projects_table',1),('2017_04_20_053902_create_purchase_requests_table',1),('2017_04_22_172048_create_invoice_customers_table',1),('2017_04_24_093720_create_purchase_order_vendors_table',1),('2017_04_26_075934_create_invoice_vendors_table',1),('2017_04_27_050032_create_internal_requests_table',1),('2017_05_05_073108_create_categories_table',1),('2017_05_05_095128_create_sub_categories_table',1),('2017_05_09_084626_create_settlements_table',1),('2017_05_10_063625_create_quotation_customers_table',1),('2017_05_10_100742_create_quotation_vendors_table',1),('2017_05_16_094746_create_cashbonds_table',1),('2017_05_16_125614_create_cashes_table',1),('2017_05_16_135614_create_transactions_table',1),('2017_05_22_053902_add quotation_vendor_id to purchase order vendor',1),('2017_05_22_100504_create_bank_administrations_table',1),('2017_05_23_101624_create_lock_configuration_table',1),('2017_05_28_194409_create_periods_table',1),('2017_05_28_200001_create_time_reports_table',1),('2017_05_30_163703_create_user_time_period_table',1),('2017_06_14_120440_add_column_is_petty_cash_to_internal_requests_table',1),('2017_06_16_095357_create_item_invoice_customer_table',1),('2017_06_19_070454_add_column_prepared_by_to_table_invoice_customers',1),('2017_06_19_152254_add_incentive_to_users_table',1),('2017_07_13_092406_create_the_logs_table',1),('2017_07_14_073640_add_file_column_to_table_quotation_customers',1),('2017_07_14_094632_add_column_file_to_table_purchase_order_customers',1),('2017_07_17_064456_add_column_file_to_table_invoice_customers',1),('2017_07_17_094814_create_item_purchase_order_vendor_table',1),('2017_07_17_122602_add_additional_coloumns_to_table_purchase_order_vendor',1),('2017_07_18_071139_add_column_address_and_telphone_to_table_vendors',1),('2017_07_18_084223_add_column_user_id_to_table_purchase_requests',1),('2017_07_18_113526_add_additional_columns_to_table_invoice_customers',1),('2017_07_24_120548_add_column_type_to_table_internal_requests',1),('2017_07_28_195947_add_column_accounted_approval_to_table_internal_Request',1),('2017_07_29_060806_add_column_position to_table_users',1),('2017_07_29_083621_create_invoice_customer_taxes_table',1),('2017_07_29_151420_add_column_vendor_id_to_table_internal_requests',1),('2017_07_29_160614_add_column_quotation_vendor_id_to_table_purchase_requests',1),('2017_07_30_115753_add_column_tax_number_to_invoice_customer_taxes_table',1),('2017_07_30_122734_add_column_cash_id_to_table_invoice_customer_taxes',1),('2017_07_31_095925_add_column_type_to_table_invoice_customers',1),('2017_08_02_011521_add_column_posting_date_to_table_invoice_customers',1),('2017_08_16_073524_add_column_cash_id_and_acconted_approval_status_to_table_invoice_vendors',1),('2017_08_16_111859_add_column_bank_target_id_to_table_internal_requests',1),('2017_08_21_044947_add_column_notes_to_table_transactions',1),('2017_08_22_093413_add_terms_to_purchase_order_vendors_table',1),('2017_08_23_044105_add_column_reference_amount_to_table_transactions',1),('2017_08_24_043208_add_column_accounted_approval_to_table_settlements',1),('2017_08_29_072600_create_item_purchase_request_table',1),('2017_08_29_075414_add_additional_columns_to_purchase_requests_table',1),('2017_08_30_033330_add_column_remitter_bank_id_to_table_settlements',1),('2017_08_31_083910_add_additional_column_to_table_cashbonds',1),('2017_09_02_080621_add_tax_date_to_invoice_customer',1),('2017_09_04_064249_add_transaction_date_to_transaction',1),('2017_09_06_041048_create_invoice_vendor_taxes_table',1),('2017_09_06_095649_add_tax_parameter_columns_to_invoice_vendors_table',1),('2017_09_08_091318_add_wht_and_type_to_invoice_vendors',1),('2017_09_11_060647_add_tax_number_to_invoice_vendor_taxes_table',1),('2017_09_11_103145_add_cash_id_to_table_invoice_vendor_taxes',1),('2017_09_14_173805_add_column_status_to_purchase_order_vendors_table',1),('2017_09_15_065010_add_type_percent_and_amount_from_type_to_invoice_vendors_table',1),('2017_09_27_064025_add_column_cash_id_to_invoice_customers',1),('2017_09_29_044609_add_column_enabled_to_table_cashes',1),('2017_10_02_122127_create_cashbond_sites_table',1),('2017_10_05_113317_add_column_cut_from_salary_to_table_cashonds',1),('2017_10_10_091903_add_column_term_to_table_cashbonds',1),('2017_10_12_055433_add tax_date_to_invoice_vendors_table',1),('2017_10_23_051328_add_user_id_to_quotation_vendor',1),('2017_10_26_082638_create_ets_table',1),('2017_11_27_154618_add_bill_amount_to_invoice_vendor',1),('2017_12_22_095130_add_column_is_received_to_item_purchase_request_table',1),('2018_02_19_041008_create_configurations_table',1),('2019_04_04_140443_create_assets_table',1),('2019_04_04_141735_create_asset_categories_table',1),('2019_04_24_123103_add_work_activation_date_to_users_table',1),('2019_04_26_122619_create_delivery_orders_table',1),('2019_04_27_091013_create_accounting_expenses',1),('2019_04_27_091359_create_allowances',1),('2019_04_27_092341_create_allowance_items_table',1),('2019_04_27_092957_cashbond_installments',1),('2019_04_27_095819_create_medical_allowances_table',1),('2019_04_27_100740_create_payrolls_table',1),('2019_04_27_101458_add_column_accounting_expense_id_to_transactions_table',1),('2019_05_02_075730_create_products_table',1),('2019_05_06_133844_add_is_completed_to_table_projects',1),('2019_05_13_155443_create_leaves_table',1),('2019_05_16_165535_item_delivery_order',1),('2019_05_29_122917_add_location_to_ets',1),('2019_05_29_123409_add_type_to_ets',1),('2019_06_14_031012_add_has_incentive_weekday_and_has_incentive_week_end_to_table_ets',1),('2019_06_14_032100_add_checker_notes_to_ets',1),('2019_06_17_051225_add_has_workshop_alloacne_and_workshop_allowance_amount_to_users',1),('2019_06_20_081335_add_additional_allowance_to_table_users',1),('2019_06_21_065208_create_workshop_allowances_table',1),('2019_06_21_094845_add_competency_allowance_to_users_table',1),('2019_06_21_144155_create_competency_allowances_table',1),('2019_06_22_204614_create_extra_payroll_payments_table',1),('2019_06_23_065727_create_incentive_week_days_table',1),('2019_06_23_073403_create_incentive_week_ends_table',1),('2019_06_23_092235_create_bpjs_kesehatans_table',1),('2019_06_23_093243_create_bpjs_ketenagakerjaans_table',1),('2019_06_24_072214_add_status_to_payolls_table',1),('2019_06_24_085634_Add related accounting columns to table payrolls',1),('2019_07_01_135504_create_settlement_payrolls_table',1),('2019_07_02_075521_add_gross_amount_to_payrolls_table',1),('2019_07_03_084159_add_timestamps_field_to_item_purchase_request_table',1),('2019_07_16_100835_add_price_to_products_table',1),('2019_07_17_034048_create_locations_table',1),('2019_07_17_065010_add_brand_and_part_number_to_products_table',1),('2019_07_17_065254_add_product_category_id_to_products_table',1),('2019_07_17_070447_create_product_categories_table',1),('2019_08_15_031618_create_tasks_table',1),('2019_08_26_082649_create_migos_table',1),('2019_09_04_041934_add_claimed_by_salesman_to_invoice_customers_table',1),('2019_09_16_014137_create_task_assignees_table',1),('2019_09_17_021506_add_additional_manhour_parameters_to_ets_table',1),('2019_09_20_085857_add_payment_term_days_to_vendors_table',1),('2019_09_26_082249_add_eat_allowance_and_transportation_allowance_non_local_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payrolls`
--

DROP TABLE IF EXISTS `payrolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payrolls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `thp_amount` decimal(20,2) NOT NULL,
  `gross_amount` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Payroll amount without the settlements',
  `is_printed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','checked','approved') COLLATE utf8_unicode_ci DEFAULT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `remitter_bank_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payrolls`
--

LOCK TABLES `payrolls` WRITE;
/*!40000 ALTER TABLE `payrolls` DISABLE KEYS */;
/*!40000 ALTER TABLE `payrolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periods`
--

DROP TABLE IF EXISTS `periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `the_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `the_month` enum('january','february','march','april','may','june','july','august','september','october','november','december') COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `periods_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periods`
--

LOCK TABLES `periods` WRITE;
/*!40000 ALTER TABLE `periods` DISABLE KEYS */;
/*!40000 ALTER TABLE `periods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (17,7),(21,7),(22,7),(23,7),(24,7),(25,7),(26,7),(27,7),(28,7),(34,7),(35,7),(36,7),(37,7),(1,6),(2,6),(3,6),(4,6),(25,6),(26,6),(27,6),(28,6),(34,6),(35,6),(36,6),(37,6),(25,3),(26,3),(27,3),(28,3),(34,3),(35,3),(36,3),(37,3),(71,3),(72,3),(73,3),(74,3),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2),(43,2),(44,2),(45,2),(46,2),(47,2),(48,2),(49,2),(50,2),(51,2),(52,2),(53,2),(54,2),(55,2),(56,2),(57,2),(58,2),(59,2),(60,2),(61,2),(62,2),(63,2),(64,2),(65,2),(66,2),(67,2),(68,2),(69,2),(70,2),(71,2),(72,2),(73,2),(74,2),(83,2),(84,2),(85,2),(86,2),(87,2),(93,2),(95,2);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=1117 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view-quotation-customer','View Quotation Customer',NULL,NULL),(2,'create-quotation-customer','Create Quotation Customer ',NULL,NULL),(3,'edit-quotation-customer','Edit Quotation Customer',NULL,NULL),(4,'delete-quotation-customer','Delete Quotation Customer',NULL,NULL),(5,'change-quotation-customer-status','Change quotation customer status',NULL,NULL),(6,'pending-quotation-customer','Change quotation customer to pending',NULL,NULL),(7,'submit-quotation-customer','Change quotation customer to submitted',NULL,NULL),(8,'reject-quotation-customer','Change quotation customer to rejected',NULL,NULL),(9,'view-quotation-vendor','View Quotation Vendor',NULL,NULL),(10,'create-quotation-vendor','Access Quotation Vendor Create method',NULL,NULL),(11,'edit-quotation-vendor','Access Quotation Vendor Edit method',NULL,NULL),(12,'delete-quotation-vendor','Access Quotation Vendor Delete method',NULL,NULL),(13,'view-purchase-order-customer','View Purchase Order Customer',NULL,NULL),(14,'create-purchase-order-customer','Access Purchase Order Customer Create method',NULL,NULL),(15,'edit-purchase-order-customer','Access Purchase Order Customer Edit method',NULL,NULL),(16,'delete-purchase-order-customer','Access Purchase Order Customer Delete method',NULL,NULL),(17,'view-purchase-order-vendor','View Purchase Order Vendor',NULL,NULL),(18,'create-purchase-order-vendor','Access Purchase Order Vendor Create method',NULL,NULL),(19,'edit-purchase-order-vendor','Access Purchase Order Vendor Edit method',NULL,NULL),(20,'delete-purchase-order-vendor','Access Purchase Order Vendor Delete method',NULL,NULL),(21,'view-purchase-request','View Purchase Request',NULL,NULL),(22,'create-purchase-request','Access Purchase Request Create method',NULL,NULL),(23,'edit-purchase-request','Access Purchase Request Edit method',NULL,NULL),(24,'delete-purchase-request','Access Purchase Request Delete method',NULL,NULL),(25,'view-internal-request','View Internal request',NULL,NULL),(26,'create-internal-request','Create internal request',NULL,NULL),(27,'edit-internal-request','Edit internal request',NULL,NULL),(28,'delete-internal-request','Delete internal request',NULL,NULL),(29,'create-internal-request-to-other','Create internal request for other member',NULL,NULL),(30,'change-status-internal-request','Change status internal request',NULL,NULL),(31,'check-internal-request','Change internal request status to Checked',NULL,NULL),(32,'approve-internal-request','Change internal request status to Approved',NULL,NULL),(33,'reject-internal-request','Change internal request status to Rejected',NULL,NULL),(34,'view-settlement','View settlement',NULL,NULL),(35,'create-settlement','Create settlement',NULL,NULL),(36,'edit-settlement','Edit settlement',NULL,NULL),(37,'delete-settlement','Delete settlement',NULL,NULL),(38,'view-project','View project',NULL,NULL),(39,'create-project','Access Project Create method',NULL,NULL),(40,'edit-project','Access Project Edit method',NULL,NULL),(41,'delete-project','Access Project Delete method',NULL,NULL),(42,'transfer-task','Access Transfer Task Module',NULL,NULL),(43,'transfer-task-internal-request','Access Transfer Task Internal Request Module',NULL,NULL),(44,'transfer-task-invoice-vendor','Access Transfer Task Invoice Vendor',NULL,NULL),(45,'transfer-task-settlement','Access Transfer Task Settlement module',NULL,NULL),(46,'view-invoice-customer','View Invoice Customer',NULL,NULL),(47,'create-invoice-customer','Access invoice-customer Create method',NULL,NULL),(48,'edit-invoice-customer','Access invoice-customer Edit method',NULL,NULL),(49,'delete-invoice-customer','Access invoice-customer Delete method',NULL,NULL),(50,'view-invoice-vendor','View Invoice Vendor',NULL,NULL),(51,'create-invoice-vendor','Access invoice-vendor Create method',NULL,NULL),(52,'edit-invoice-vendor','Access invoice-vendor Edit method',NULL,NULL),(53,'delete-invoice-vendor','Access invoice-vendor Delete method',NULL,NULL),(54,'view-cash','View cash',NULL,NULL),(55,'create-cash','Create cash',NULL,NULL),(56,'edit-cash','Edit Cash',NULL,NULL),(57,'delete-cash','Delete Cash',NULL,NULL),(58,'view-customer','View customer',NULL,NULL),(59,'create-customer','Create customer',NULL,NULL),(60,'edit-customer','Edit customer',NULL,NULL),(61,'delete-customer','Delete customer',NULL,NULL),(62,'view-the-vendor','View Vendor',NULL,NULL),(63,'create-the-vendor','Create the-vendor',NULL,NULL),(64,'edit-the-vendor','Edit the-vendor',NULL,NULL),(65,'delete-the-vendor','Delete the-vendor',NULL,NULL),(66,'access-master-data','View Master Data Menu',NULL,NULL),(67,'view-bank-account','View Member Bank Account',NULL,NULL),(68,'create-bank-account','Create Member Bank Account',NULL,NULL),(69,'edit-bank-account','Edit Member Bank Account',NULL,NULL),(70,'delete-bank-account','Delete Member Bank Account',NULL,NULL),(71,'view-user','View User',NULL,NULL),(72,'create-user','Create user',NULL,NULL),(73,'edit-user','Edit user',NULL,NULL),(74,'delete-user','Delete user',NULL,NULL),(75,'view-role','View Role',NULL,NULL),(76,'create-role','Create role',NULL,NULL),(77,'edit-role','Edit role',NULL,NULL),(78,'delete-role','Delete role',NULL,NULL),(79,'view-permission','View Permission',NULL,NULL),(80,'create-permission','Create permission',NULL,NULL),(81,'edit-permission','Edit permission',NULL,NULL),(82,'delete-permission','Delete permission',NULL,NULL),(83,'view-cash-bond','View Cashbonnd',NULL,NULL),(84,'create-cash-bond','Create cash-bond',NULL,NULL),(85,'edit-cash-bond','Edit cash-bond',NULL,NULL),(86,'delete-cash-bond','Delete cash-bond',NULL,NULL),(87,'change-cash-bond-status','Change cashbond status',NULL,NULL),(93,'access-finance-statistic','View Master Finance Statistic menu',NULL,NULL),(94,'reset-user-password','Reset User Password',NULL,NULL),(95,'view-all-quotation-customer','View All Quotation Customer',NULL,NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_code_unique` (`code`),
  UNIQUE KEY `product_categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_categories`
--

LOCK TABLES `product_categories` WRITE;
/*!40000 ALTER TABLE `product_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `initial_stock` decimal(20,2) DEFAULT 0.00 COMMENT 'Initial stock',
  `stock` decimal(20,2) DEFAULT 0.00 COMMENT 'Current stock',
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_unique` (`code`),
  UNIQUE KEY `products_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` enum('internal','external') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'external' COMMENT 'Internal project means this project is made by company it self',
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The project number',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_order_customer_id` int(11) DEFAULT NULL COMMENT 'Related to the purchase_order_customers table, required if the project is external project',
  `sales_id` int(11) DEFAULT NULL COMMENT 'relate to the user with the role of sales, null if the project category is internal',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'if this value is TRUE, then ignore the invoice customer due and pending attribute',
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'external','P-19-00001','Test Project',1,1,1,'2019-11-16 02:29:04','2019-11-16 02:29:04',0);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order_customers`
--

DROP TABLE IF EXISTS `purchase_order_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `quotation_customer_id` int(11) DEFAULT NULL,
  `status` enum('received','on-process','cancelled') COLLATE utf8_unicode_ci NOT NULL,
  `received_date` date NOT NULL DEFAULT '2019-11-16',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_order_customers_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_customers`
--

LOCK TABLES `purchase_order_customers` WRITE;
/*!40000 ALTER TABLE `purchase_order_customers` DISABLE KEYS */;
INSERT INTO `purchase_order_customers` VALUES (1,'fff',1,'fafasfasf',10000.00,2,'received','2019-11-01','2019-11-16 02:28:34','2019-11-16 02:28:34',NULL);
/*!40000 ALTER TABLE `purchase_order_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order_vendors`
--

DROP TABLE IF EXISTS `purchase_order_vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order_vendors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_request_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quotation_vendor_id` int(11) NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Initial amount taken from item price summary',
  `vat` int(11) NOT NULL DEFAULT 0,
  `wht` decimal(20,2) NOT NULL DEFAULT 0.00,
  `discount` int(11) NOT NULL DEFAULT 0,
  `after_discount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `terms` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('uncompleted','completed','unresolved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'uncompleted',
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_order_vendors_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_vendors`
--

LOCK TABLES `purchase_order_vendors` WRITE;
/*!40000 ALTER TABLE `purchase_order_vendors` DISABLE KEYS */;
INSERT INTO `purchase_order_vendors` VALUES (1,8,'POV-19-11-001',1,'ERERer',10000.00,'2019-11-16 08:01:55','2019-11-16 08:01:55',1,10000.00,0,0.00,0,10000.00,'','uncompleted'),(2,8,'POV-19-11-002',2,'ERERer',1.00,'2019-11-17 23:45:00','2019-11-17 23:45:00',1,1.00,0,0.00,0,1.00,'','uncompleted');
/*!40000 ALTER TABLE `purchase_order_vendors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_requests`
--

DROP TABLE IF EXISTS `purchase_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Purchase request number',
  `project_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Transaction description',
  `amount` decimal(20,2) NOT NULL,
  `status` enum('pending','approved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quotation_vendor_id` int(11) DEFAULT NULL,
  `sub_amount` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Initial amount taken from item price summary',
  `vat` int(11) NOT NULL DEFAULT 0,
  `wht` decimal(20,2) NOT NULL DEFAULT 0.00,
  `discount` int(11) NOT NULL DEFAULT 0,
  `after_discount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `terms` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_requests_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_requests`
--

LOCK TABLES `purchase_requests` WRITE;
/*!40000 ALTER TABLE `purchase_requests` DISABLE KEYS */;
INSERT INTO `purchase_requests` VALUES (1,'PR-00001',1,'ERERer',10000.00,'approved','2019-11-16 08:01:24','2019-11-16 08:01:36',1,1,10000.00,0,0.00,0,10000.00,''),(2,'PR-00002',1,'ERERer',1.00,'approved','2019-11-17 23:43:42','2019-11-17 23:44:11',7,1,1.00,0,0.00,0,1.00,'');
/*!40000 ALTER TABLE `purchase_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_customers`
--

DROP TABLE IF EXISTS `quotation_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotation_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `amount` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','submitted','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `submitted_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_customers_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_customers`
--

LOCK TABLES `quotation_customers` WRITE;
/*!40000 ALTER TABLE `quotation_customers` DISABLE KEYS */;
INSERT INTO `quotation_customers` VALUES (2,'QC-19-11-001',1,1,'10000','fafasfasf','submitted','2019-11-16','2019-11-16 02:28:09','2019-11-16 02:28:17',NULL),(3,'QC-19-11-002',1,6,'200000','afafafaf','submitted','2019-11-16','2019-11-16 08:18:59','2019-11-16 08:19:10',NULL);
/*!40000 ALTER TABLE `quotation_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_vendors`
--

DROP TABLE IF EXISTS `quotation_vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotation_vendors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_request_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `amount` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','received','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'received',
  `received_date` date DEFAULT NULL,
  `purchase_order_vendored` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'To define if this has purchase order vendor related or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_vendors_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_vendors`
--

LOCK TABLES `quotation_vendors` WRITE;
/*!40000 ALTER TABLE `quotation_vendors` DISABLE KEYS */;
INSERT INTO `quotation_vendors` VALUES (1,'WEWRTT',0,8,'10000','ERERer','received','2019-11-01',1,'2019-11-16 08:00:47','2019-11-17 23:45:00',1);
/*!40000 ALTER TABLE `quotation_vendors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(7,8),(7,9),(7,10),(7,11),(7,12);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_code_unique` (`code`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'SUP','Super Admin','User with this role will have full access to apllication',NULL,NULL),(2,'ADM','Administrator','User with this role will have semi-full access to apllication',NULL,NULL),(3,'HRD','Human Resource Development','User with this role will have full access to HRD modules',NULL,NULL),(4,'WRH','Warehouse','User with this role will have full access to warehouse modules',NULL,NULL),(5,'MKT','Marketing','User with this role will have full access to marketing modules',NULL,NULL),(6,'SAL','Sales','User with this role will have full access to sales modules',NULL,NULL),(7,'ENG','Engineer','User with this role will have full access to engineer modules',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlement_payrolls`
--

DROP TABLE IF EXISTS `settlement_payrolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlement_payrolls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `settlement_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlement_payrolls`
--

LOCK TABLES `settlement_payrolls` WRITE;
/*!40000 ALTER TABLE `settlement_payrolls` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlement_payrolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlements`
--

DROP TABLE IF EXISTS `settlements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_request_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `result` enum('clear','additional') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'clear',
  `status` enum('pending','checked','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `last_updater_id` int(11) DEFAULT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Define is this accounted on cash or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `accounted_approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL,
  `remitter_bank_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settlements_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlements`
--

LOCK TABLES `settlements` WRITE;
/*!40000 ALTER TABLE `settlements` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_assignees`
--

DROP TABLE IF EXISTS `task_assignees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_assignees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `working_hour` decimal(20,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_assignees`
--

LOCK TABLES `task_assignees` WRITE;
/*!40000 ALTER TABLE `task_assignees` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_assignees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'the creator of the task',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date_schedule` date DEFAULT NULL,
  `finish_date_schedule` date DEFAULT NULL,
  `status` enum('draft','ongoing','completed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `the_logs`
--

DROP TABLE IF EXISTS `the_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `the_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source` enum('internal_request','cashbond','settlement','invoice_vendor','invoice_customer','quotation_customer','quotation_vendor') COLLATE utf8_unicode_ci DEFAULT NULL,
  `mode` enum('create','update','delete','approve','reject') COLLATE utf8_unicode_ci DEFAULT NULL,
  `refference_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `the_logs`
--

LOCK TABLES `the_logs` WRITE;
/*!40000 ALTER TABLE `the_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `the_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_report_user`
--

DROP TABLE IF EXISTS `time_report_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_report_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL,
  `time_report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `incentive` enum('non','week_day','week_end') COLLATE utf8_unicode_ci NOT NULL,
  `allowance` tinyint(1) NOT NULL,
  `non_allowance` tinyint(1) NOT NULL,
  `off_allowance` tinyint(1) NOT NULL,
  `normal_time` int(11) DEFAULT NULL,
  `overtime_one` int(11) DEFAULT NULL,
  `overtime_two` int(11) DEFAULT NULL,
  `overtime_three` int(11) DEFAULT NULL,
  `overtime_four` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_report_user`
--

LOCK TABLES `time_report_user` WRITE;
/*!40000 ALTER TABLE `time_report_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `time_report_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_reports`
--

DROP TABLE IF EXISTS `time_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL,
  `the_date` date NOT NULL,
  `type` enum('usual','week_end','day_off') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_reports`
--

LOCK TABLES `time_reports` WRITE;
/*!40000 ALTER TABLE `time_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `time_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cash_id` int(11) NOT NULL,
  `refference` enum('internal_request','settlement','cashbond','invoice_customer','invoice_vendor','bank_administration','invoice_customer_tax','invoice_vendor_tax','manual','site_internal_request','site_settlement','cashbond-site','payroll') COLLATE utf8_unicode_ci DEFAULT NULL,
  `refference_id` int(11) DEFAULT NULL,
  `refference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('credit','debet') COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_amount` decimal(20,2) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `accounting_expense_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'As NOMOR Karyawan',
  `type` enum('office','outsource') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'office',
  `salary` decimal(20,2) DEFAULT NULL,
  `man_hour_rate` decimal(20,2) DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `profile_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eat_allowance` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Uang makan per hari',
  `eat_allowance_non_local` decimal(20,2) NOT NULL DEFAULT 0.00,
  `transportation_allowance` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Transportasi per hari',
  `transportation_allowance_non_local` decimal(20,2) NOT NULL DEFAULT 0.00,
  `medical_allowance` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Tunjangan kesehatan perbulan',
  `bpjs_tk` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'BPJS Ketenagakerjaan',
  `bpjs_ke` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'BPJS Kesehatan',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `incentive_week_day` decimal(20,2) NOT NULL DEFAULT 0.00,
  `incentive_week_end` decimal(20,2) NOT NULL DEFAULT 0.00,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_activation_date` date DEFAULT NULL,
  `has_workshop_allowance` tinyint(1) NOT NULL DEFAULT 0,
  `workshop_allowance_amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `additional_allowance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `competency_allowance` decimal(20,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Solksjaer','solksjaer@email.com','$2y$10$T9cXb8Zm0qD2CXnS2TnSP.A3umb.t4/tT4aCpO7S1lVxzdpYhqNDy','A-0001','office',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,'XdgGYEZlbh5Tr1gFVoatWZLLjejpOTfPRNYcuhyDY0JjKX1868RjFDqnJMTp',NULL,'2019-11-16 08:14:30',0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(2,'Zlatan Ibrahimovic','ibrahimovic@email.com','$2y$10$wEruCifQV7qlS8J8TNmE5OZZtSzCYprxjxHZ2VWpflirBcPWJNKzO','A-0002','office',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,'0USvTwRL2XyvQ3dIokbII4UNbAtYEYm6GeArxom7UkyJsRWt1wnnfuZvpbak',NULL,'2019-11-26 00:06:34',0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(3,'Wayne Rooney','rooney@email.com','$2y$10$O90Q5Yw/B3RSwinCene7QOdjncFpoe9rLeYS5ZBuJIGVg6NLzvbDa','A-0003','office',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(4,'Ander Herrera','herrera@email.com','$2y$10$rXfK2VP/t6U5chZs/LM3V.LkX7M4PgtRY5vyYvVUaJIXV5BV9FyeC','A-0004','office',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(5,'Juan Mata','mata@email.com','$2y$10$.FF.lGL9OPJJ3tF6cQeZqOjXAX/wHJMhJZRvf7J5eny93egQI0J3G','A-0005','office',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(6,'Michael Carrick','carrick@email.com','$2y$10$Kbd01ljW6GaiZ/nKECuwRu2KBNQqakwHxs0rL0npmx7WqZw/gGqYy','A-0005','office',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,'TeZiSmAhzHX0Q66clnU1wWneVsOa4Gz4zm73JigJFL1rCTc53fukCpKl1US9',NULL,'2019-11-26 00:06:56',0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(7,'Marouane Fellaini','fellaini@email.com','$2y$10$H37VQ/vFAY1lVWxCytk.4OJCsNF0sx83Gytf37NbU6zAVA/W8cP22','A-0007','office',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,'CJ3ndFTyv6KtXSuCtKdUu68cR6oVpKHPQawr5CsKFulNT51WQTFEUvcll1N1',NULL,'2019-11-22 03:22:52',0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(8,'Marcos Rojo','rojo@email.com','$2y$10$ru3LDLP1DO4fn5HovRhOxuSqCRPAgyINc50JrRLv.6kgwLo.WoFnG','A-0008','outsource',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(9,'Daley Blind','blind@email.com','$2y$10$tqXNElr8J65H9G5zzEzru.3Nm081WeWaI.zUGtT.v2ZTsuDnJuJy6','A-0009','outsource',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(10,'Antony Valencia','valencia@email.com','$2y$10$f.TIFDjxIJrsIeAwXdzdi.EAQdscu7pR5H16liWo2dF5ReNKduHhG','A-0010','outsource',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(11,'Luke Shaw','shaw@email.com','$2y$10$TW.VkHfFs/vc4wfwyNWt3expETgausQuD2I3ykhlPzEhESDcRm.aG','A-0011','outsource',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00),(12,'David De Gea','degea@email.com','$2y$10$o.VZNU5olcnsPVSsmZMLweL9vsVwN7H2.M6k2TEKolP2wA3sJ27rW','A-0012','outsource',5000000.00,10000.00,'active',NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,NULL,0.00,0.00,NULL,NULL,0,0.00,0.00,0.00);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_term_days` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendors_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendors`
--

LOCK TABLES `vendors` WRITE;
/*!40000 ALTER TABLE `vendors` DISABLE KEYS */;
INSERT INTO `vendors` VALUES (1,'Wehner Inc','non',NULL,'2019-11-16 07:45:58','2019-11-16 07:45:58','249.332.1269 x755','639 Javier Mission\nEast Chet, NY 97920',NULL),(2,'Trantow, Upton and Paucek','enim',NULL,'2019-11-16 07:45:58','2019-11-16 07:45:58','816-328-3610 x7981','478 Marcel Turnpike Suite 901\nSouth Doraland, IA 19090',NULL),(3,'Larson Inc','est',NULL,'2019-11-16 07:45:58','2019-11-16 07:45:58','520.342.5732','345 Jerel Parkways\nNorth Nadialand, IL 47442',NULL),(4,'Harris-Davis','harum',NULL,'2019-11-16 07:45:58','2019-11-16 07:45:58','1-432-314-6241 x6394','90674 Borer Unions Apt. 412\nAlanatown, CO 50526-4765',NULL),(5,'Dickens-Gutkowski','neque',NULL,'2019-11-16 07:45:58','2019-11-16 07:45:58','610.656.4057','6102 Hilpert Club\nPort Pierreborough, DE 33077-0482',NULL),(6,'Jones-Hoppe','dolor',NULL,'2019-11-16 07:45:58','2019-11-16 07:45:58','1-218-876-7102','1121 Lance Lodge Suite 639\nWest Zack, MS 39582',NULL),(7,'Hessel, Donnelly and Schinner','facilis',NULL,'2019-11-16 07:45:59','2019-11-16 07:45:59','818-410-1448 x00949','640 Mya Meadow\nEast Clarabelleland, MT 65325-0798',NULL),(8,'Bergstrom-Prohaska','repellat',NULL,'2019-11-16 07:45:59','2019-11-16 07:45:59','865.822.8648 x838','529 Hyatt Estates\nPort Helmer, MA 65204',NULL),(9,'Ortiz-Kling','vel',NULL,'2019-11-16 07:45:59','2019-11-16 07:45:59','1-720-236-6027 x28277','493 Florian Corners\nNew Brandyn, KS 54254-8724',NULL),(10,'Wuckert Ltd','dolorum',NULL,'2019-11-16 07:45:59','2019-11-16 07:45:59','1-983-753-1417','91788 Olson Turnpike\nEast Lourdesmouth, AR 86406',NULL);
/*!40000 ALTER TABLE `vendors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workshop_allowances`
--

DROP TABLE IF EXISTS `workshop_allowances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workshop_allowances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workshop_allowances`
--

LOCK TABLES `workshop_allowances` WRITE;
/*!40000 ALTER TABLE `workshop_allowances` DISABLE KEYS */;
/*!40000 ALTER TABLE `workshop_allowances` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-26 14:31:08
