-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2021 at 05:46 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounting_expenses`
--

CREATE TABLE `accounting_expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `period_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowance_items`
--

CREATE TABLE `allowance_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `allowance_id` int(11) NOT NULL,
  `type` enum('transportation','meal') COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Harga aset',
  `asset_category_id` int(11) DEFAULT NULL COMMENT 'Asset category, related to AssetCategory model',
  `type` enum('current','fixed','intangible') COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Current = lancar, fixed = tetap, intangible = tidak berwujud',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_categories`
--

CREATE TABLE `asset_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_administrations`
--

CREATE TABLE `bank_administrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cash_id` int(11) NOT NULL,
  `refference_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The refference number from the bank',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_kesehatans`
--

CREATE TABLE `bpjs_kesehatans` (
  `id` int(10) UNSIGNED NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_ketenagakerjaans`
--

CREATE TABLE `bpjs_ketenagakerjaans` (
  `id` int(10) UNSIGNED NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashbonds`
--

CREATE TABLE `cashbonds` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `payment_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashbond_installments`
--

CREATE TABLE `cashbond_installments` (
  `id` int(10) UNSIGNED NOT NULL,
  `cashbond_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `installment_schedule` date DEFAULT NULL,
  `status` enum('paid','unpaid') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashbond_sites`
--

CREATE TABLE `cashbond_sites` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','checked','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_date` date DEFAULT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `cash_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashes`
--

CREATE TABLE `cashes` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('cash','bank') COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cashes`
--

INSERT INTO `cashes` (`id`, `type`, `name`, `account_number`, `description`, `amount`, `created_at`, `updated_at`, `enabled`) VALUES
(1, 'bank', 'Bank 1', '129', 'Cash bank', '1344000.00', '2020-04-23 07:52:11', '2020-07-27 02:01:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competency_allowances`
--

CREATE TABLE `competency_allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(7, 'estimated-cost-margin-limit', '15', NULL, NULL),
(8, 'prefix-invoice-customer', 'INVC', NULL, NULL),
(9, 'company-logo', 'http://localhost/img/logo-sbt.jpeg', NULL, NULL),
(10, 'company-office', 'Jl. Raya Ciangsana, Ruko SA 1 No.24\nVilla Nusa Indah 5, Ciangsana, Gunung Putri, Kab. Bogor\nJawa Barat 16968 - Indonesia\r\n                        ', NULL, NULL),
(11, 'company-worskhop', 'Jl. Raya Ciangsana, Ruko SA 1 No.24\nVilla Nusa Indah 5, Ciangsana, Gunung Putri, Kab. Bogor\nJawa Barat 16968 - Indonesia', NULL, NULL),
(12, 'company-bank-account', 'Bank Syariah Mandiri Cabang Jatibening\n(IDR) Acc. No. 7891113336 : PT. Sedulang Bintang Teknik', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `contact_number`, `address`, `created_at`, `updated_at`) VALUES
(11, 'PT Spirax Sarco Indonesia', '021 83797233 ', 'Dr. Saharjo No. 45, Kawasan Infinia Park. Blok. C99 \r\nManggarai Tebet, Jakarta Selatan DKI Jakarta 12850', '2020-08-11 03:10:51', '2020-09-11 23:59:10'),
(12, 'PT Harbison Walker International', '022 54398750, Fax. 022 54398749', 'Jl. Australia II Kav. N-1KIEC Complex, Cilegon Banten Indonesia', '2020-08-11 03:19:28', '2020-09-11 23:53:01'),
(13, 'PT Shinryo Indonesia', '-', 'PT Procter & Gamble Indonesia\r\nKawasan KIIC Lot KK-7A-7B Karawang \r\nJawa Barat', '2020-08-11 03:29:15', '2020-09-11 23:25:15'),
(14, 'PT Tirta Investama ', '-', 'Jl. Pulo Lentut No. 3\r\nKawasan Industri Pulo Gadung\r\n13920 Jakarta\r\n\r\nEmail : id.ext.ap@danone.com', '2020-08-12 03:10:19', '2020-09-11 23:58:46'),
(15, 'PT Mahakam Beta Farma', '021-4603543, fax 021-4603667', 'Jl. Pulo Kambing II No. 20, KIP, Rawa Terate\r\nJatinegara Cakung\r\nJakarta Timur 13930\r\n', '2020-08-19 03:23:33', '2020-08-19 03:23:33'),
(16, 'PT Nutrifood Indonesia', '-', 'Jl. Raya Ciawi No. 280 A\r\nSindang Sari, Bogor Timur\r\nBogor - Jawa Barat\r\n\r\nEmail :\r\nnurzaman@nutrifood.co.id', '2020-09-01 22:28:10', '2020-09-01 22:28:10'),
(17, 'PT Erlangga Edi Laboratories', '024 8310 650, fax. 024 8313998', 'Jl. Erlangga Raya 26 Semarang', '2020-09-01 23:27:44', '2020-09-01 23:27:44'),
(18, 'PT Industri Susu Alam Murni', '-', 'Jl. Rumah Sakit No. 114 Rt. 005 Rw, 005\r\nPakemitan Cinambo, Bandung\r\n', '2020-09-02 00:49:29', '2020-09-02 00:49:29'),
(19, 'PT Shinryo Indonesia', '-', 'Jl. MT. Haryono Kav. 15 Graha Pratama Lt. 10\r\nTebet Barat, Jakarta Selatan \r\nDki Jakarta', '2020-09-02 01:14:04', '2020-09-02 01:14:04'),
(20, 'PT  Royal Teknik Industri', '021 22479072', 'Jln. Raya Perumnas Blok A No. 89, Jakarta Timur, Indonesia', '2020-10-06 03:33:02', '2020-10-06 03:33:02'),
(21, 'PT Lucas Djaja', ' +62 22 7564032, +62 81312214898', 'Jl. Ciwastra RT.07 / RW.06, Kel.Margasari, Kec.Buah Batu, Bandung, West Java, Indonesia', '2020-10-26 05:00:41', '2020-10-26 05:00:41'),
(22, 'PT Johnson Home Hygiene  Products', '-', 'ALLIANZ TOWER LANTAI 26\r\nJI HR RASUNA SAID SUPERBLOK 2\r\nJAKARTA 12980\r\n\r\nJHHP Pulogadung MFG Plant\r\nPT Johnson Home Hygiene Products\r\nJl. Rawa Sumur No. 12\r\nKawasan Industri Pulogadung\r\nJakarta 13930', '2020-10-27 03:37:12', '2020-10-27 03:37:12'),
(23, 'PT Kalbe Farma Tbk.', 'Tel. (021)89907333-37, Fax. (021) 8973471-8974211', 'Jl. LetJend Soeprapto Kav. 4 No. 1, Cempaka Putih, Jakarta Pusat 10510, PO BOX 3105 JAK, Jakarta, Indonesia. (NPWP : 01.001.836.4-092.000)\r\nPurchasing GI : Kawasan Industri Delta Silicon, Jl. M.H. Thamrin Blok A3-1, Lippo Cikarang, Bekasi 17550', '2020-10-27 04:41:46', '2020-10-27 04:41:46'),
(24, 'PT. Bintang Toedjoe', '(021)4605533, Fax. (021)4605535', '\r\nHead Office : JL. Jend. A. Yani No. 2, Pulomas, Pulogadung, Jakarta Timur 13210, , Jakarta, Indonesia. (NPWP : 01.002.036.0-092.000)\r\nPlant : Jl. Rawa Sumur Barat II K-9 Kawasan Industri Pulogadung Jakarta 13930 - Indonesia, Tel. ', '2020-10-27 06:23:26', '2020-10-27 06:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_orders`
--

CREATE TABLE `delivery_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Creator',
  `sender_id` int(11) NOT NULL,
  `status` enum('draft','delivered','received') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `receiver` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ets`
--

CREATE TABLE `ets` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'total cost per project per day for the user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extra_payroll_payments`
--

CREATE TABLE `extra_payroll_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `type` enum('adder','substractor') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'adder',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incentive_week_days`
--

CREATE TABLE `incentive_week_days` (
  `id` int(10) UNSIGNED NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incentive_week_ends`
--

CREATE TABLE `incentive_week_ends` (
  `id` int(10) UNSIGNED NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_requests`
--

CREATE TABLE `internal_requests` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `bank_target_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `internal_requests`
--

INSERT INTO `internal_requests` (`id`, `code`, `description`, `amount`, `remitter_bank_id`, `beneficiary_bank_id`, `project_id`, `requester_id`, `status`, `approver_id`, `transaction_date`, `settled`, `accounted`, `created_at`, `updated_at`, `is_petty_cash`, `type`, `accounted_approval`, `vendor_id`, `bank_target_id`) VALUES
(1, 'IR-00001', 'test ', '5000.00', 1, 0, 1, 3, 'approved', NULL, '2020-07-27', 1, 1, '2020-07-27 00:47:08', '2020-07-27 01:01:03', 0, 'operational', 'approved', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_customers`
--

CREATE TABLE `invoice_customers` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `submitted_date` date NOT NULL DEFAULT '2019-11-22',
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
  `claimed_by_salesman` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Define if invoice is already claimed by the salesman'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice_customers`
--

INSERT INTO `invoice_customers` (`id`, `project_id`, `code`, `tax_number`, `sub_amount`, `vat`, `wht`, `amount`, `due_date`, `description`, `status`, `submitted_date`, `accounted`, `created_at`, `updated_at`, `prepared_by`, `file`, `discount`, `discount_value`, `after_discount`, `down_payment`, `down_payment_value`, `vat_value`, `type`, `posting_date`, `tax_date`, `cash_id`, `claimed_by_salesman`) VALUES
(1, 1, 'INV-20-07-001', '00000', '500000.00', 0, '0.00', '250000.00', '2020-07-29', NULL, 'paid', '2019-11-22', 1, '2020-07-27 01:26:12', '2020-07-27 01:26:51', NULL, NULL, '0.00', '0.00', '500000.00', '50.00', '250000.00', '0.00', 'dp', '2020-07-01', '2020-07-04', 1, 0),
(2, 2, 'INV-20-07-002', '-', '1000.00', 0, '0.00', '1000.00', '2020-07-31', NULL, 'paid', '2019-11-22', 1, '2020-07-27 01:46:56', '2020-07-27 01:51:36', NULL, NULL, '0.00', '0.00', '1000.00', '0.00', '0.00', '0.00', 'pelunasan', '2020-07-22', '2020-07-23', 1, 0),
(3, 2, 'INV-20-07-003', '-', '99000.00', 0, '0.00', '99000.00', '2020-07-31', NULL, 'paid', '2019-11-22', 1, '2020-07-27 02:00:31', '2020-07-27 02:01:04', NULL, NULL, '0.00', '0.00', '99000.00', '0.00', '0.00', '0.00', 'pelunasan', '2020-07-24', '2020-07-25', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_customer_taxes`
--

CREATE TABLE `invoice_customer_taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_customer_id` int(11) NOT NULL,
  `source` enum('vat','wht') COLLATE utf8_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(20,2) NOT NULL,
  `status` enum('pending','paid') COLLATE utf8_unicode_ci NOT NULL,
  `approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cash_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_vendors`
--

CREATE TABLE `invoice_vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Invoice vendor number',
  `tax_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `project_id` int(11) NOT NULL,
  `purchase_order_vendor_id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','paid') COLLATE utf8_unicode_ci NOT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `received_date` date NOT NULL DEFAULT '2019-11-22',
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
  `bill_amount` decimal(20,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice_vendors`
--

INSERT INTO `invoice_vendors` (`id`, `code`, `tax_number`, `amount`, `project_id`, `purchase_order_vendor_id`, `due_date`, `status`, `accounted`, `received_date`, `created_at`, `updated_at`, `cash_id`, `accounted_approval`, `sub_total`, `discount`, `after_discount`, `vat`, `vat_amount`, `wht_amount`, `type`, `amount_before_type`, `type_percent`, `amount_from_type`, `tax_date`, `bill_amount`) VALUES
(1, '001(TEST)', '00000', '1000.00', 1, 1, '2020-07-09', 'paid', 1, '2020-07-01', '2020-07-27 01:05:44', '2020-07-27 01:10:37', 1, 'approved', '1000.00', 0, '1000.00', 0, '0.00', '0.00', 'pelunasan', '1000.00', 0, '0.00', '2020-07-22', '0.00'),
(2, '003(test)', '-', '100000.00', 1, 2, '2020-07-31', 'pending', 0, '2020-07-23', '2020-07-27 02:16:38', '2020-07-27 02:16:38', NULL, 'pending', '100000.00', 0, '100000.00', 0, '0.00', '0.00', 'pelunasan', '100000.00', 0, '0.00', '2020-07-04', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_vendor_taxes`
--

CREATE TABLE `invoice_vendor_taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_vendor_id` int(11) NOT NULL,
  `source` enum('vat','wht') COLLATE utf8_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(20,2) NOT NULL,
  `status` enum('pending','paid') COLLATE utf8_unicode_ci NOT NULL,
  `approval` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cash_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_delivery_order`
--

CREATE TABLE `item_delivery_order` (
  `delivery_order_id` int(11) NOT NULL,
  `item_purchase_request_id` int(11) NOT NULL,
  `quantity` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_invoice_customer`
--

CREATE TABLE `item_invoice_customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_customer_id` text COLLATE utf8_unicode_ci NOT NULL,
  `item` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_invoice_customer`
--

INSERT INTO `item_invoice_customer` (`id`, `invoice_customer_id`, `item`, `quantity`, `unit`, `price`, `sub_amount`) VALUES
(1, '1', '1', '1', '1', '500000.00', '500000.00'),
(2, '2', 'pipa', '1', 'pcs', '1000.00', '1000.00'),
(3, '3', 'pipa', '1', 'pcs', '99000.00', '99000.00');

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase_order_vendor`
--

CREATE TABLE `item_purchase_order_vendor` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_order_vendor_id` text COLLATE utf8_unicode_ci NOT NULL,
  `item` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase_request`
--

CREATE TABLE `item_purchase_request` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_request_id` text COLLATE utf8_unicode_ci NOT NULL,
  `item` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `sub_amount` decimal(20,2) NOT NULL,
  `is_received` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_purchase_request`
--

INSERT INTO `item_purchase_request` (`id`, `purchase_request_id`, `item`, `quantity`, `unit`, `price`, `sub_amount`, `is_received`, `created_at`, `updated_at`) VALUES
(1, '1', 'baut 1', '1', 'pcs', '1000.00', '1000.00', 0, NULL, NULL),
(2, '2', 'ELBOW', '5', 'pcs', '20000.00', '100000.00', 0, NULL, NULL),
(3, '3', 'ghghghg', '1', '', '14000000.00', '14000000.00', 0, NULL, NULL),
(5, '4', 'Assembly Header & Frame MFP14-PPU PACKAGED\r\nPUMP UNIT 50MM PN16 SIMPLEX + Wood Full\r\nPacking', '1', '', '14000000.00', '14000000.00', 0, NULL, NULL),
(6, '5', 'Assembly Header & Frame MFP14-PPU PACKAGED PUMP UNIT 80x50MM PN16 TRIPLEX', '1', '1', '17000000.00', '17000000.00', 0, NULL, NULL),
(56, '7', '\"Assembly MFP14-PPU PACKAGED PUMP UNIT\r\n40MM PN16 SIMPLEX\"	\r\n	\r\n', '2', 'Unit', '14000000.00', '28000000.00', 0, NULL, NULL),
(59, '8', 'MINOX 1\" ROTARY SPRAY BALL - BSPT, SS316L', '2', 'PCS', '2200000.00', '4400000.00', 0, NULL, NULL),
(60, '8', 'MINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L', '2', 'PCS', '1050000.00', '2100000.00', 0, NULL, NULL),
(61, '8', 'MINOX 1.5\" FERRULE 12.7MM, SS316L', '12', 'PCS', '47000.00', '564000.00', 0, NULL, NULL),
(62, '8', 'MINOX 0.5\" FERRULE 12.7MM, SS316L', '4', '', '0.00', '0.00', 0, NULL, NULL),
(63, '6', 'MINOX 1\" ROTARY SPRAY BALL - BSPT, SS316L', '2', 'PCS', '2200000.00', '4400000.00', 0, NULL, NULL),
(64, '6', 'MINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L', '2', 'pcs', '1050000.00', '2100000.00', 0, NULL, NULL),
(65, '6', 'MINOX 1.5\" FERRULE 12.7MM, SS316L', '12', 'pcs', '47000.00', '564000.00', 0, NULL, NULL),
(66, '6', 'MINOX 0.5\" FERRULE 12.7MM, SS316L', '4', 'pcs', '44000.00', '176000.00', 0, NULL, NULL),
(67, '6', 'MINOX 4\" FERRULE 15.9MM, SS316L', '5', 'pcs', '120000.00', '600000.00', 0, NULL, NULL),
(68, '6', 'MINOX 4\" / DN100 FERRULE BLANK, SS316L', '1', 'pcs', '220000.00', '220000.00', 0, NULL, NULL),
(69, '6', 'MINOX 0.5\" FERRULE GASKET <EPDM>', '4', 'pcs', '27000.00', '108000.00', 0, NULL, NULL),
(70, '6', 'MINOX 1.5\" FERRULE GASKET <EPDM>', '8', 'pcs', '25000.00', '200000.00', 0, NULL, NULL),
(71, '6', 'MINOX 4\" FERRULE GASKET <EPDM>', '3', 'pcs', '49000.00', '147000.00', 0, NULL, NULL),
(72, '6', 'MINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304', '8', 'pcs', '66000.00', '528000.00', 0, NULL, NULL),
(73, '6', 'MINOX 4\" / DN100 CLAMP RING, SS304', '3', 'pcs', '140000.00', '420000.00', 0, NULL, NULL),
(74, '6', 'MINOX 4\" X 1.5\" REDUCING TEE, WELD END, SS316L', '1', 'pcs', '650000.00', '650000.00', 0, NULL, NULL),
(75, '6', 'MINOX 4\" X 1.5\" CON REDUCER, WELD END SS316L', '1', 'pcs', '460000.00', '460000.00', 0, NULL, NULL),
(76, '6', 'MINOX 1\" 90 DEG ELBOW, WELD END, SS316L (R=1.5)', '10', 'pcs', '58000.00', '580000.00', 0, NULL, NULL),
(77, '6', 'MINOX 1.5\" 90 DEG ELBOW, WELD END, SS316L (R=1.5)', '10', 'pcs', '85000.00', '850000.00', 0, NULL, NULL),
(78, '6', 'MINOX 4\" X 2.00MM X 6.0M SANITARY TUBE - EN10357, SS316L', '1', 'pcs', '4800000.00', '4800000.00', 0, NULL, NULL),
(82, '9', 'MINOX 1.0\" FERRULE 12.7MM, SS316L', '16', 'pcs', '47000.00', '752000.00', 0, NULL, NULL),
(83, '9', 'MINOX 1\" FERRULE GASKET <EPDM>', '10', 'pcs', '27000.00', '270000.00', 0, NULL, NULL),
(84, '9', 'MINOX 1\" PIPE HANGER TYPE C, SS304', '15', 'pcs', '65000.00', '975000.00', 0, NULL, NULL),
(97, '10', 'MINOX 4\" FERRULE 15.9MM, SS316L', '4', 'pcs', '120000.00', '480000.00', 0, NULL, NULL),
(98, '10', 'MINOX 4\" FERRULE GASKET <EPDM>', '4', 'pcs', '49000.00', '196000.00', 0, NULL, NULL),
(99, '10', 'MINOX 4\" / DN100 CLAMP RING, SS304', '4', 'pcs', '140000.00', '560000.00', 0, NULL, NULL),
(100, '10', 'MINOX 4\" X 2\" CON REDUCER, WELD END SS316L', '4', 'pcs', '460000.00', '1840000.00', 0, NULL, NULL),
(101, '10', 'MINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L', '1', 'pcs', '1700000.00', '1700000.00', 0, NULL, NULL),
(102, '10', 'MINOX 2\" 90 DEG ELBOW, WELD END, SS304L (R=1.5)', '4', 'pcs', '88000.00', '352000.00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'NULL if this location is the MASTER parent location, example : office, warehouse building, ... etc',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Can be used to describe about the material to store in this location',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lock_configurations`
--

CREATE TABLE `lock_configurations` (
  `id` int(10) UNSIGNED NOT NULL,
  `facility_name` enum('create_internal_request','create_project','create_cashbond') COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_allowances`
--

CREATE TABLE `medical_allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `period_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migos`
--

CREATE TABLE `migos` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_request_id` int(11) DEFAULT NULL,
  `creator_id` int(11) NOT NULL COMMENT 'The user id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2017_03_25_175938_create_permissions_table', 1),
('2017_03_25_180028_create_roles_table', 1),
('2017_03_25_180446_create_permission_role_table', 1),
('2017_03_25_180549_create_role_user_table', 1),
('2017_03_25_191644_create_bank_accounts_table', 1),
('2017_03_26_082742_create_customers_table', 1),
('2017_03_26_101217_create_vendors_table', 1),
('2017_04_05_155019_create_purchase_order_customers_table', 1),
('2017_04_14_143528_create_projects_table', 1),
('2017_04_20_053902_create_purchase_requests_table', 1),
('2017_04_22_172048_create_invoice_customers_table', 1),
('2017_04_24_093720_create_purchase_order_vendors_table', 1),
('2017_04_26_075934_create_invoice_vendors_table', 1),
('2017_04_27_050032_create_internal_requests_table', 1),
('2017_05_05_073108_create_categories_table', 1),
('2017_05_05_095128_create_sub_categories_table', 1),
('2017_05_09_084626_create_settlements_table', 1),
('2017_05_10_063625_create_quotation_customers_table', 1),
('2017_05_10_100742_create_quotation_vendors_table', 1),
('2017_05_16_094746_create_cashbonds_table', 1),
('2017_05_16_125614_create_cashes_table', 1),
('2017_05_16_135614_create_transactions_table', 1),
('2017_05_22_053902_add quotation_vendor_id to purchase order vendor', 1),
('2017_05_22_100504_create_bank_administrations_table', 1),
('2017_05_23_101624_create_lock_configuration_table', 1),
('2017_05_28_194409_create_periods_table', 1),
('2017_05_28_200001_create_time_reports_table', 1),
('2017_05_30_163703_create_user_time_period_table', 1),
('2017_06_14_120440_add_column_is_petty_cash_to_internal_requests_table', 1),
('2017_06_16_095357_create_item_invoice_customer_table', 1),
('2017_06_19_070454_add_column_prepared_by_to_table_invoice_customers', 1),
('2017_06_19_152254_add_incentive_to_users_table', 1),
('2017_07_13_092406_create_the_logs_table', 1),
('2017_07_14_073640_add_file_column_to_table_quotation_customers', 1),
('2017_07_14_094632_add_column_file_to_table_purchase_order_customers', 1),
('2017_07_17_064456_add_column_file_to_table_invoice_customers', 1),
('2017_07_17_094814_create_item_purchase_order_vendor_table', 1),
('2017_07_17_122602_add_additional_coloumns_to_table_purchase_order_vendor', 1),
('2017_07_18_071139_add_column_address_and_telphone_to_table_vendors', 1),
('2017_07_18_084223_add_column_user_id_to_table_purchase_requests', 1),
('2017_07_18_113526_add_additional_columns_to_table_invoice_customers', 1),
('2017_07_24_120548_add_column_type_to_table_internal_requests', 1),
('2017_07_28_195947_add_column_accounted_approval_to_table_internal_Request', 1),
('2017_07_29_060806_add_column_position to_table_users', 1),
('2017_07_29_083621_create_invoice_customer_taxes_table', 1),
('2017_07_29_151420_add_column_vendor_id_to_table_internal_requests', 1),
('2017_07_29_160614_add_column_quotation_vendor_id_to_table_purchase_requests', 1),
('2017_07_30_115753_add_column_tax_number_to_invoice_customer_taxes_table', 1),
('2017_07_30_122734_add_column_cash_id_to_table_invoice_customer_taxes', 1),
('2017_07_31_095925_add_column_type_to_table_invoice_customers', 1),
('2017_08_02_011521_add_column_posting_date_to_table_invoice_customers', 1),
('2017_08_16_073524_add_column_cash_id_and_acconted_approval_status_to_table_invoice_vendors', 1),
('2017_08_16_111859_add_column_bank_target_id_to_table_internal_requests', 1),
('2017_08_21_044947_add_column_notes_to_table_transactions', 1),
('2017_08_22_093413_add_terms_to_purchase_order_vendors_table', 1),
('2017_08_23_044105_add_column_reference_amount_to_table_transactions', 1),
('2017_08_24_043208_add_column_accounted_approval_to_table_settlements', 1),
('2017_08_29_072600_create_item_purchase_request_table', 1),
('2017_08_29_075414_add_additional_columns_to_purchase_requests_table', 1),
('2017_08_30_033330_add_column_remitter_bank_id_to_table_settlements', 1),
('2017_08_31_083910_add_additional_column_to_table_cashbonds', 1),
('2017_09_02_080621_add_tax_date_to_invoice_customer', 1),
('2017_09_04_064249_add_transaction_date_to_transaction', 1),
('2017_09_06_041048_create_invoice_vendor_taxes_table', 1),
('2017_09_06_095649_add_tax_parameter_columns_to_invoice_vendors_table', 1),
('2017_09_08_091318_add_wht_and_type_to_invoice_vendors', 1),
('2017_09_11_060647_add_tax_number_to_invoice_vendor_taxes_table', 1),
('2017_09_11_103145_add_cash_id_to_table_invoice_vendor_taxes', 1),
('2017_09_14_173805_add_column_status_to_purchase_order_vendors_table', 1),
('2017_09_15_065010_add_type_percent_and_amount_from_type_to_invoice_vendors_table', 1),
('2017_09_27_064025_add_column_cash_id_to_invoice_customers', 1),
('2017_09_29_044609_add_column_enabled_to_table_cashes', 1),
('2017_10_02_122127_create_cashbond_sites_table', 1),
('2017_10_05_113317_add_column_cut_from_salary_to_table_cashonds', 1),
('2017_10_10_091903_add_column_term_to_table_cashbonds', 1),
('2017_10_12_055433_add tax_date_to_invoice_vendors_table', 1),
('2017_10_23_051328_add_user_id_to_quotation_vendor', 1),
('2017_10_26_082638_create_ets_table', 1),
('2017_11_27_154618_add_bill_amount_to_invoice_vendor', 1),
('2017_12_22_095130_add_column_is_received_to_item_purchase_request_table', 1),
('2018_02_19_041008_create_configurations_table', 1),
('2019_04_04_140443_create_assets_table', 1),
('2019_04_04_141735_create_asset_categories_table', 1),
('2019_04_24_123103_add_work_activation_date_to_users_table', 1),
('2019_04_26_122619_create_delivery_orders_table', 1),
('2019_04_27_091013_create_accounting_expenses', 1),
('2019_04_27_091359_create_allowances', 1),
('2019_04_27_092341_create_allowance_items_table', 1),
('2019_04_27_092957_cashbond_installments', 1),
('2019_04_27_095819_create_medical_allowances_table', 1),
('2019_04_27_100740_create_payrolls_table', 1),
('2019_04_27_101458_add_column_accounting_expense_id_to_transactions_table', 1),
('2019_05_02_075730_create_products_table', 1),
('2019_05_06_133844_add_is_completed_to_table_projects', 1),
('2019_05_13_155443_create_leaves_table', 1),
('2019_05_16_165535_item_delivery_order', 1),
('2019_05_29_122917_add_location_to_ets', 1),
('2019_05_29_123409_add_type_to_ets', 1),
('2019_06_14_031012_add_has_incentive_weekday_and_has_incentive_week_end_to_table_ets', 1),
('2019_06_14_032100_add_checker_notes_to_ets', 1),
('2019_06_17_051225_add_has_workshop_alloacne_and_workshop_allowance_amount_to_users', 1),
('2019_06_20_081335_add_additional_allowance_to_table_users', 1),
('2019_06_21_065208_create_workshop_allowances_table', 1),
('2019_06_21_094845_add_competency_allowance_to_users_table', 1),
('2019_06_21_144155_create_competency_allowances_table', 1),
('2019_06_22_204614_create_extra_payroll_payments_table', 1),
('2019_06_23_065727_create_incentive_week_days_table', 1),
('2019_06_23_073403_create_incentive_week_ends_table', 1),
('2019_06_23_092235_create_bpjs_kesehatans_table', 1),
('2019_06_23_093243_create_bpjs_ketenagakerjaans_table', 1),
('2019_06_24_072214_add_status_to_payolls_table', 1),
('2019_06_24_085634_Add related accounting columns to table payrolls', 1),
('2019_07_01_135504_create_settlement_payrolls_table', 1),
('2019_07_02_075521_add_gross_amount_to_payrolls_table', 1),
('2019_07_03_084159_add_timestamps_field_to_item_purchase_request_table', 1),
('2019_07_16_100835_add_price_to_products_table', 1),
('2019_07_17_034048_create_locations_table', 1),
('2019_07_17_065010_add_brand_and_part_number_to_products_table', 1),
('2019_07_17_065254_add_product_category_id_to_products_table', 1),
('2019_07_17_070447_create_product_categories_table', 1),
('2019_08_15_031618_create_tasks_table', 1),
('2019_08_26_082649_create_migos_table', 1),
('2019_09_04_041934_add_claimed_by_salesman_to_invoice_customers_table', 1),
('2019_09_16_014137_create_task_assignees_table', 1),
('2019_09_17_021506_add_additional_manhour_parameters_to_ets_table', 1),
('2019_09_20_085857_add_payment_term_days_to_vendors_table', 1),
('2019_09_26_082249_add_eat_allowance_and_transportation_allowance_non_local_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int(10) UNSIGNED NOT NULL,
  `period_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `thp_amount` decimal(20,2) NOT NULL,
  `gross_amount` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Payroll amount without the settlements',
  `is_printed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','checked','approved') COLLATE utf8_unicode_ci DEFAULT NULL,
  `accounted` tinyint(1) NOT NULL DEFAULT 0,
  `remitter_bank_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE `periods` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `the_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `the_month` enum('january','february','march','april','may','june','july','august','september','october','november','december') COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'view-quotation-customer', 'View Quotation Customer', NULL, NULL),
(2, 'create-quotation-customer', 'Create Quotation Customer ', NULL, NULL),
(3, 'edit-quotation-customer', 'Edit Quotation Customer', NULL, NULL),
(4, 'delete-quotation-customer', 'Delete Quotation Customer', NULL, NULL),
(5, 'change-quotation-customer-status', 'Change quotation customer status', NULL, NULL),
(6, 'pending-quotation-customer', 'Change quotation customer to pending', NULL, NULL),
(7, 'submit-quotation-customer', 'Change quotation customer to submitted', NULL, NULL),
(8, 'reject-quotation-customer', 'Change quotation customer to rejected', NULL, NULL),
(9, 'view-quotation-vendor', 'View Quotation Vendor', NULL, NULL),
(10, 'create-quotation-vendor', 'Access Quotation Vendor Create method', NULL, NULL),
(11, 'edit-quotation-vendor', 'Access Quotation Vendor Edit method', NULL, NULL),
(12, 'delete-quotation-vendor', 'Access Quotation Vendor Delete method', NULL, NULL),
(13, 'view-purchase-order-customer', 'View Purchase Order Customer', NULL, NULL),
(14, 'create-purchase-order-customer', 'Access Purchase Order Customer Create method', NULL, NULL),
(15, 'edit-purchase-order-customer', 'Access Purchase Order Customer Edit method', NULL, NULL),
(16, 'delete-purchase-order-customer', 'Access Purchase Order Customer Delete method', NULL, NULL),
(17, 'view-purchase-order-vendor', 'View Purchase Order Vendor', NULL, NULL),
(18, 'create-purchase-order-vendor', 'Access Purchase Order Vendor Create method', NULL, NULL),
(19, 'edit-purchase-order-vendor', 'Access Purchase Order Vendor Edit method', NULL, NULL),
(20, 'delete-purchase-order-vendor', 'Access Purchase Order Vendor Delete method', NULL, NULL),
(21, 'view-purchase-request', 'View Purchase Request', NULL, NULL),
(22, 'create-purchase-request', 'Access Purchase Request Create method', NULL, NULL),
(23, 'edit-purchase-request', 'Access Purchase Request Edit method', NULL, NULL),
(24, 'delete-purchase-request', 'Access Purchase Request Delete method', NULL, NULL),
(25, 'view-internal-request', 'View Internal request', NULL, NULL),
(26, 'create-internal-request', 'Create internal request', NULL, NULL),
(27, 'edit-internal-request', 'Edit internal request', NULL, NULL),
(28, 'delete-internal-request', 'Delete internal request', NULL, NULL),
(29, 'create-internal-request-to-other', 'Create internal request for other member', NULL, NULL),
(30, 'change-status-internal-request', 'Change status internal request', NULL, NULL),
(31, 'check-internal-request', 'Change internal request status to Checked', NULL, NULL),
(32, 'approve-internal-request', 'Change internal request status to Approved', NULL, NULL),
(33, 'reject-internal-request', 'Change internal request status to Rejected', NULL, NULL),
(34, 'view-settlement', 'View settlement', NULL, NULL),
(35, 'create-settlement', 'Create settlement', NULL, NULL),
(36, 'edit-settlement', 'Edit settlement', NULL, NULL),
(37, 'delete-settlement', 'Delete settlement', NULL, NULL),
(38, 'view-project', 'View project', NULL, NULL),
(39, 'create-project', 'Access Project Create method', NULL, NULL),
(40, 'edit-project', 'Access Project Edit method', NULL, NULL),
(41, 'delete-project', 'Access Project Delete method', NULL, NULL),
(42, 'transfer-task', 'Access Transfer Task Module', NULL, NULL),
(43, 'transfer-task-internal-request', 'Access Transfer Task Internal Request Module', NULL, NULL),
(44, 'transfer-task-invoice-vendor', 'Access Transfer Task Invoice Vendor', NULL, NULL),
(45, 'transfer-task-settlement', 'Access Transfer Task Settlement module', NULL, NULL),
(46, 'view-invoice-customer', 'View Invoice Customer', NULL, NULL),
(47, 'create-invoice-customer', 'Access invoice-customer Create method', NULL, NULL),
(48, 'edit-invoice-customer', 'Access invoice-customer Edit method', NULL, NULL),
(49, 'delete-invoice-customer', 'Access invoice-customer Delete method', NULL, NULL),
(50, 'view-invoice-vendor', 'View Invoice Vendor', NULL, NULL),
(51, 'create-invoice-vendor', 'Access invoice-vendor Create method', NULL, NULL),
(52, 'edit-invoice-vendor', 'Access invoice-vendor Edit method', NULL, NULL),
(53, 'delete-invoice-vendor', 'Access invoice-vendor Delete method', NULL, NULL),
(54, 'view-cash', 'View cash', NULL, NULL),
(55, 'create-cash', 'Create cash', NULL, NULL),
(56, 'edit-cash', 'Edit Cash', NULL, NULL),
(57, 'delete-cash', 'Delete Cash', NULL, NULL),
(58, 'view-customer', 'View customer', NULL, NULL),
(59, 'create-customer', 'Create customer', NULL, NULL),
(60, 'edit-customer', 'Edit customer', NULL, NULL),
(61, 'delete-customer', 'Delete customer', NULL, NULL),
(62, 'view-the-vendor', 'View Vendor', NULL, NULL),
(63, 'create-the-vendor', 'Create the-vendor', NULL, NULL),
(64, 'edit-the-vendor', 'Edit the-vendor', NULL, NULL),
(65, 'delete-the-vendor', 'Delete the-vendor', NULL, NULL),
(66, 'access-master-data', 'View Master Data Menu', NULL, NULL),
(67, 'view-bank-account', 'View Member Bank Account', NULL, NULL),
(68, 'create-bank-account', 'Create Member Bank Account', NULL, NULL),
(69, 'edit-bank-account', 'Edit Member Bank Account', NULL, NULL),
(70, 'delete-bank-account', 'Delete Member Bank Account', NULL, NULL),
(71, 'view-user', 'View User', NULL, NULL),
(72, 'create-user', 'Create user', NULL, NULL),
(73, 'edit-user', 'Edit user', NULL, NULL),
(74, 'delete-user', 'Delete user', NULL, NULL),
(75, 'view-role', 'View Role', NULL, NULL),
(76, 'create-role', 'Create role', NULL, NULL),
(77, 'edit-role', 'Edit role', NULL, NULL),
(78, 'delete-role', 'Delete role', NULL, NULL),
(79, 'view-permission', 'View Permission', NULL, NULL),
(80, 'create-permission', 'Create permission', NULL, NULL),
(81, 'edit-permission', 'Edit permission', NULL, NULL),
(82, 'delete-permission', 'Delete permission', NULL, NULL),
(83, 'view-cash-bond', 'View Cashbonnd', NULL, NULL),
(84, 'create-cash-bond', 'Create cash-bond', NULL, NULL),
(85, 'edit-cash-bond', 'Edit cash-bond', NULL, NULL),
(86, 'delete-cash-bond', 'Delete cash-bond', NULL, NULL),
(87, 'change-cash-bond-status', 'Change cashbond status', NULL, NULL),
(93, 'access-finance-statistic', 'View Master Finance Statistic menu', NULL, NULL),
(94, 'reset-user-password', 'Reset User Password', NULL, NULL),
(95, 'view-all-quotation-customer', 'view-all-quotation-customer', '2020-07-27 00:14:49', '2020-07-27 00:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(93, 2),
(94, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `product_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` enum('internal','external') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'external' COMMENT 'Internal project means this project is made by company it self',
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The project number',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_order_customer_id` int(11) DEFAULT NULL COMMENT 'Related to the purchase_order_customers table, required if the project is external project',
  `sales_id` int(11) DEFAULT NULL COMMENT 'relate to the user with the role of sales, null if the project category is internal',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'if this value is TRUE, then ignore the invoice customer due and pending attribute'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `category`, `code`, `name`, `purchase_order_customer_id`, `sales_id`, `enabled`, `created_at`, `updated_at`, `is_completed`) VALUES
(4, 'external', 'SBT.2020.001', 'Packaged pump DN50', 26, 17, 1, '2020-01-13 17:00:00', '2021-03-01 23:36:43', 0),
(5, 'external', 'SBT.2020.002', 'upgrading tanki cst LT', 33, 17, 1, '2020-01-16 17:00:00', '2021-03-01 23:37:51', 0),
(6, 'external', 'SBT.2020.003', 'PN40 SLIP ON FLANGES 80MM 2PCS', 27, 17, 1, '2020-01-13 17:00:00', '2021-03-02 00:14:08', 0),
(7, 'external', 'SBT.2020.004', 'ELBOW CONNECTION DN25XDN25', 28, 17, 1, '2019-01-13 17:00:00', '2021-03-02 00:15:37', 0),
(8, 'external', 'SBT.2020.005', 'MFP14-PPU PACKAGED PUMP UNIT 80x50MM PN16 TRIPLEX', 29, 17, 1, '2020-01-26 17:00:00', '2021-03-05 00:02:26', 0),
(9, 'external', 'SBT.2020.006', 'PN40 SLIP ON & ANSI#300 FLANGES 25MM', 43, 17, 1, '2020-01-28 17:00:00', '2021-03-05 00:03:47', 0),
(10, 'external', 'SBT.2020.007', 'ELBOW CONNECTION DN40XDN40', 30, 17, 1, '2020-01-30 17:00:00', '2021-03-05 00:08:14', 0),
(11, 'external', 'SBT.2020.008', 'MODIFICATION OINTMENT MIXING TANK CAPACITY 80L', 18, 17, 1, '2020-02-05 17:00:00', '2021-03-05 00:09:39', 0),
(12, 'external', 'SBT.2020.009', 'Name Plate fro Separator 1808', 7, 17, 1, '2020-02-25 17:00:00', '2021-03-05 00:10:56', 0),
(13, 'external', 'SBT.2020.010', 'printer cartridge recorder KRN100', 19, 17, 1, '2020-03-01 17:00:00', '2021-03-05 00:12:24', 0),
(14, 'external', 'SBT.2021.011', 'WT-PU-UV-UV INSTALATION', 10, 17, 1, '2020-03-02 17:00:00', '2021-03-05 00:31:02', 0),
(15, 'external', 'SBT.2020.012', 'Connecting POU', 36, 17, 1, '2020-03-05 17:00:00', '2021-03-05 00:32:47', 0),
(16, 'external', 'SBT.2020.013', 'WT-WS-FTN-Add Work Poseidon Gap', 9, 17, 1, '2020-03-14 17:00:00', '2021-03-05 00:34:08', 0),
(17, 'external', 'SBT.2020.014', 'GASKET EPDM FOR PHE M6-MFG', 34, 17, 1, '2020-03-19 17:00:00', '2021-03-05 00:35:42', 0),
(18, 'external', 'SBT.2020.015', 'WT-WD-WLP-UPGRADE POSEIDON GAP', 11, 17, 1, '2020-03-25 17:00:00', '2021-03-05 00:40:29', 0),
(19, 'external', 'SBT.2020.016', 'batch reporting system for CIP & mixing fasber', 20, 17, 1, '2020-03-26 17:00:00', '2021-03-05 01:07:45', 0),
(20, 'external', 'SBT.2020.017', 'WT-WD-WLP-INTERLOCK UV LAMP', 13, 17, 1, '2020-03-30 17:00:00', '2021-03-05 01:09:33', 0),
(21, 'external', 'SBT.2020.018', 'WT-WD-WLP-UV Lamp WT-B WT-WD-WLP-UV Lamp WT-D', 12, 17, 1, '2020-03-30 17:00:00', '2021-03-05 01:11:04', 0),
(22, 'external', 'SBT.2020.019', 'SS Ducting', 6, 17, 1, '2020-04-07 17:00:00', '2021-03-05 01:26:02', 0),
(23, 'external', 'SBT.2020.020', 'CIP Filling Line', 37, 17, 1, '2020-04-19 17:00:00', '2021-03-05 01:27:27', 0),
(24, 'external', 'SBT.2020.021', 'Drain Arjunior m/c', 41, 17, 1, '2020-06-28 17:00:00', '2021-03-05 01:28:58', 0),
(25, 'external', 'SBT.2020.021-1', 'Drain Arjunior m/c', 40, 17, 1, '2020-06-28 17:00:00', '2021-03-05 01:30:07', 0),
(26, 'external', 'SBT.2020.022', 'Desk & Table Arjunior', 39, 17, 1, '2020-06-28 17:00:00', '2021-03-05 01:31:48', 0),
(27, 'external', 'SBT.2020.022-1', 'Desk & Table Arjunior', 38, 17, 1, '2020-06-28 17:00:00', '2021-03-05 01:32:51', 0),
(28, 'external', 'SBT.2020.023', 'BONGKAR PASANG BOILER (NDE WORK FOR HOKKEN BOILER 8TON)', 32, 17, 1, '2020-04-26 17:00:00', '2021-03-05 01:34:17', 0),
(29, 'external', 'SBT.2020.024', 'check PLC program at CIP & Mixing System', 17, 17, 1, '2020-02-16 17:00:00', '2021-03-05 01:36:01', 0),
(30, 'external', 'SBT.2020.025', 'WT-WD-WLP-UV Lamp WT-5', 14, 17, 1, '2020-04-29 17:00:00', '2021-03-05 01:38:40', 0),
(31, 'external', 'SBT.2020.026', 'Poseidon plant MKS HOD Line 6', 15, 17, 1, '2021-04-19 17:00:00', '2021-03-05 01:39:58', 0),
(32, 'external', 'SBT.2020.027', 'Modification CA & N2 Line', 44, 17, 1, '2020-05-13 17:00:00', '2021-03-05 01:41:38', 0),
(33, 'external', 'SBT.2020.028', 'Cleaning Agent Pro A++ & B++', 23, 17, 1, '2020-06-09 17:00:00', '2021-03-05 01:43:11', 0),
(34, 'external', 'SBT.2020.029', 'Interlock UV Lamp WT-1 until 5 TIV KBC', 16, 17, 1, '2020-07-02 17:00:00', '2021-03-05 01:44:34', 0),
(35, 'external', 'SBT.2020.030', 'Chain Munson RS80-3R Chain', 4, 17, 1, '2020-06-24 17:00:00', '2021-03-05 01:45:35', 0),
(36, 'external', 'SBT.2020.031', 'Spare part Flow Transmitter CIP Unit Fasber', 21, 17, 1, '2020-07-05 17:00:00', '2021-03-05 01:46:37', 0),
(37, 'external', 'SBT.2020.032', 'JASA PERBAIKAN TANGKI KAP. 15.000L', 35, 17, 1, '2020-07-05 17:00:00', '2021-03-05 01:47:46', 0),
(38, 'external', 'SBT.2020.033', 'Name Plate for Separator 1808', 3, 17, 1, '2020-07-05 17:00:00', '2021-03-05 01:53:05', 0),
(39, 'external', 'SBT.2020.034', 'Cleaning Agent Pro A++', 24, 17, 1, '2020-07-15 17:00:00', '2021-03-05 01:54:04', 0),
(40, 'external', 'SBT.2020.035', 'chemical micro kill (prodes)', 25, 17, 1, '2020-07-15 17:00:00', '2021-03-05 01:55:11', 0),
(41, 'external', 'SBT.2020.036', 'WT-WS-PSI-Percabangan Vent Filter FT S', 42, 17, 1, '2020-07-02 17:00:00', '2021-03-05 01:56:49', 0),
(42, 'external', 'SBT.2020.037', 'PENGGANTIAN SLING CHIMNEY', 31, 17, 1, '2020-07-22 17:00:00', '2021-03-05 01:57:51', 0),
(43, 'external', 'SBT.2020.038', 'Flexible Hose', 22, 17, 1, '2020-07-28 17:00:00', '2021-03-05 01:58:58', 0),
(44, 'external', 'SBT.2019.001', 'Mesin boiling tank line 5: Leakage Repair & Re-Insulated at Utility Line Boiling Tank 300L  Mesin boiling tank line 5: Leakage Repair & Re-Insulated at Utility Line Boiling Tank 600L', 94, 17, 1, '2019-05-07 17:00:00', '2021-02-24 00:53:26', 0),
(45, 'external', 'SBT.2019.002', 'Boroscope 8mtr for Autan Product Line', 90, 17, 1, '2020-10-30 05:12:27', '2021-02-24 00:46:54', 0),
(46, 'external', 'SBT.2019.003', 'SQT Ext. Elbows - SS316L', 95, 17, 1, '2019-05-20 17:00:00', '2021-02-24 00:56:27', 0),
(47, 'external', 'SBT.2019.004-1', 'Jasa instalasi - Change Strainer Filter 80mesh Mixing Aweco', 96, 17, 1, '2019-05-20 17:00:00', '2021-02-24 01:02:39', 0),
(48, 'external', 'SBT.2019.005-1', 'Jasa instalasi - Perbaikan dedleg di jalur PW Supply dari PW Gen', 97, 17, 1, '2019-05-22 17:00:00', '2021-02-24 22:55:45', 0),
(49, 'external', 'SBT.2019.006', 'MFP14-PPU PACKAGED PUMP UNIT 40MM PN16 SIMPLEX - 2UNITS', 82, 17, 1, '2019-05-23 17:00:00', '2021-02-24 23:01:05', 0),
(50, 'external', 'SBT.2019.007', 'Re-dialing Agitator Mixing Tank & Storage Tank Cap. 15,000L', 85, 17, 1, '2019-05-22 17:00:00', '2021-02-24 23:03:37', 0),
(51, 'external', 'SBT.2019.008', 'Spare Part EDI Units + Rectifier', 57, 17, 1, '2019-05-28 17:00:00', '2021-02-24 23:08:08', 0),
(52, 'external', 'SBT.2019.009', 'Drain CIP Return Pump Betsol', 100, 17, 1, '2019-06-16 17:00:00', '2021-02-24 23:10:55', 0),
(53, 'external', 'SBT.2019.010', 'Drain CIP Return Pump GS', 58, 17, 1, '2019-06-16 17:00:00', '2021-02-24 23:12:52', 0),
(54, 'external', 'P-20-00051', 'ELEMENT P-SRF C 05/30', 59, 17, 1, '2020-11-11 03:08:09', '2020-11-11 03:08:09', 0),
(55, 'external', 'SBT.2019.012', 'ISOLATED VALVE FILLING HOPPER BS & GS', 60, 17, 1, '2019-06-16 17:00:00', '2021-02-24 23:17:06', 0),
(56, 'external', 'SBT.2019.013', 'Chain Muson Mixer & connecting chain 80-3 L=4800mm, ex japan', 49, 17, 1, '2019-06-16 17:00:00', '2021-02-24 23:18:45', 0),
(57, 'external', 'SBT.2019.014', 'SS316L Ferrule, Clamp Seal Ring EPDM Set for DN40mm', 46, 17, 1, '2019-06-19 17:00:00', '2021-02-24 23:56:54', 0),
(58, 'external', 'SBT.2019.015', 'DN40XDN20 : P/N: 9625 10M1-1/N', 61, 17, 1, '2019-06-19 17:00:00', '2021-02-24 23:59:48', 0),
(59, 'external', 'SBT.2019.016', 'Chemical for CIP & Sanitation Fasber', 62, 17, 1, '2019-06-23 17:00:00', '2021-02-25 00:01:39', 0),
(60, 'external', 'SBT.2019.017', 'Support Commisioining & Chemical for CIP & Sanitation PW Gen & PW Loop', 63, 17, 1, '2021-02-24 17:00:00', '2021-02-25 00:04:24', 0),
(61, 'external', 'SBT.2019.018', 'Flange SORF PN16 Turflow', 83, 17, 1, '2019-06-23 17:00:00', '2021-02-25 00:07:07', 0),
(62, 'external', 'SBT.2019.019', 'SL 316 rotary sprayball 1 inch BSP - minox (incl sertificate material)', 101, 17, 1, '2019-06-23 17:00:00', '2021-02-25 00:09:02', 0),
(63, 'external', 'SBT.2019.020', 'Add. Chemical for CIP & Sanitation Fasber', 64, 17, 1, '2019-06-25 17:00:00', '2021-02-25 00:12:39', 0),
(64, 'external', 'SBT.2019.021', 'Tank Levellling (9Tank) at PT Jotun Indonesia', 89, 17, 1, '2019-06-27 17:00:00', '2021-02-26 03:15:51', 0),
(65, 'external', 'SBT.2019.022', 'Kalibrasi SVP Mixing System PT Lucas Djaja', 87, 17, 1, '2019-06-27 17:00:00', '2021-02-26 03:17:11', 0),
(66, 'external', 'SBT.2019.023', 'Flow Transmitter CIP System Mixing Fasber', 66, 17, 1, '2019-07-08 17:00:00', '2021-02-26 03:27:08', 0),
(67, 'external', 'SBT.2019.024', 'Add. Chemical Micro Kill (Prodes) - 2pail', 65, 17, 1, '2019-07-07 17:00:00', '2021-02-26 03:28:49', 0),
(68, 'external', 'SBT.2019.025', '3unit RO Membrane merk DOW FILMTEC HSRO 4040', 67, 17, 1, '2019-07-15 17:00:00', '2021-02-26 03:33:41', 0),
(69, 'external', 'SBT.2019.026', '1unit RO Membrane merk DOW FILMTEC HSRO 4040', 68, 17, 1, '2019-07-15 17:00:00', '2021-02-26 03:40:21', 0),
(70, 'external', 'SBT.2019.027', 'Service kits viton/ FPM manhole LKDC D450mm ex Alfa Lafal : reff Q-19.VII.0019 - Rev.0', 98, 17, 1, '2019-07-17 17:00:00', '2021-02-26 05:10:36', 0),
(71, 'external', 'SBT.2019.028', 'Proses CIP hot & chemical looping Austar Lt4, Projek Mundi Pharma', 72, 17, 1, '2019-09-03 17:00:00', '2021-02-26 05:21:06', 0),
(72, 'external', 'SBT.2019.029', 'Element SRF V 10/3 P7', 69, 17, 1, '2019-07-22 17:00:00', '2021-02-26 05:48:27', 0),
(73, 'external', 'SBT.2019.030', 'Chemical for Sanitation - part 01', 70, 17, 1, '2019-07-22 17:00:00', '2021-02-26 05:49:59', 0),
(74, 'external', 'SBT.2019.031', 'Chemical for Sanitation - part 02', 79, 17, 1, '2019-07-23 17:00:00', '2021-02-26 05:51:53', 0),
(75, 'external', 'SBT.2019.032', 'Additional Work for Tank Levelling Works at PT Jotun Indonesia', 88, 17, 1, '2019-06-27 17:00:00', '2021-03-01 21:41:07', 0),
(76, 'external', 'SBT.2019.033', 'Flange Raise Face (RF) PN16 - Material SS304L', 48, 17, 1, '2019-07-24 17:00:00', '2021-03-01 21:44:57', 0),
(77, 'external', 'SBT.2019.034', 'Platform Yenchen, Mixing Tank Dan Fitzmill', 93, 17, 1, '2019-08-26 17:00:00', '2021-03-01 21:46:06', 0),
(78, 'external', 'SBT.2019.035', 'Modifikasi jalur return pipe CIP dengan menambahkan sampling valve', 71, 17, 1, '2019-09-02 17:00:00', '2021-03-01 21:47:10', 0),
(79, 'external', 'SBT.2019.036', 'Pemindahan TOc inline dari system Lt 2 ke syst Lt3 PW Loop', 73, 17, 1, '2019-09-03 17:00:00', '2021-03-01 21:49:20', 0),
(80, 'external', 'SBT.2019.037', 'PERBAIKAN FLOW TRANSMITTER CIP', 74, 17, 1, '2019-09-03 17:00:00', '2021-03-01 21:57:20', 0),
(81, 'external', 'SBT.2019.038', 'PERBAIKAN FLOW TRANSMITTER CIP', 75, 17, 1, '2019-09-03 17:00:00', '2021-03-01 21:59:19', 0),
(82, 'external', 'SBT.2019.039', 'MF-MG-DPS-PHISICAL BREAK GIANT TANK', 99, 17, 1, '2019-09-03 17:00:00', '2021-03-01 22:06:16', 0),
(83, 'external', 'SBT.2019.040', 'Cutting Silo Tank', 91, 17, 1, '2019-09-11 17:00:00', '2021-03-01 22:09:05', 0),
(84, 'external', 'SBT.2019.041', 'PN40 Slip On Flange ', 45, 17, 1, '2019-09-01 17:00:00', '2021-03-01 22:31:05', 0),
(85, 'external', 'SBT.2019.042', 'Additional II Work for Tank Leveling Works', 47, 17, 1, '2019-09-16 17:00:00', '2021-03-01 22:34:46', 0),
(86, 'external', 'SBT.2019.043', 'WT-PU-UV-PHYSICAL BREAK', 52, 17, 1, '2019-09-17 17:00:00', '2021-03-01 22:43:50', 0),
(87, 'external', 'SBT.2019.044', 'WT-PU-WTF-POSEIDON UPGRADE', 51, 17, 1, '2019-09-17 17:00:00', '2021-03-01 22:47:51', 0),
(88, 'external', 'SBT.2019.045', '1off MEK Measuriing Tank Header 2off REACTION Tank Header', 81, 17, 1, '2019-10-02 17:00:00', '2021-03-01 22:54:47', 0),
(89, 'external', 'SBT.2019.046', 'PW loop to POU (RND & QC) ', 76, 17, 1, '2019-10-06 17:00:00', '2021-03-01 23:01:23', 0),
(90, 'external', 'SBT.2019.047', 'WT-PU-WTF-POSEIDON UPGRADE', 102, 17, 1, '2019-10-16 17:00:00', '2021-03-01 23:03:16', 0),
(91, 'external', 'SBT.2019.048', 'Flange Slip On Raise Face (RF) - Material MS', 103, 17, 1, '2019-10-17 17:00:00', '2021-03-01 23:04:47', 0),
(92, 'external', 'SBT.2019.049', 'Flange Slip On Raise Face (RF) - Material MS', 104, 17, 1, '2019-11-05 17:00:00', '2021-03-01 23:06:02', 0),
(93, 'external', 'SBT.2019.051', 'Additional New Mixing Tank (Line 2)', 92, 17, 1, '2019-11-07 17:00:00', '2021-03-01 23:13:11', 0),
(94, 'external', 'SBT.2019.052', 'INNER BOTTOM BEARING BUSHING SK4282 (FOR YOBASE RM TANK)', 86, 17, 1, '2019-11-12 17:00:00', '2021-03-01 23:14:09', 0),
(95, 'external', 'SBT.2019.053', 'WT-PU-WTF-POSEIDON UPGRADE', 53, 17, 1, '2019-11-14 17:00:00', '2021-03-01 23:19:23', 0),
(96, 'external', 'SBT.2019.054', 'WT-PU-WTF-POSEIDON UPG', 54, 17, 1, '2019-11-14 17:00:00', '2021-03-01 23:20:38', 0),
(97, 'external', 'SBT.2019.055', 'Flange Slip On Raise Face (RF) - Material MS', 106, 17, 1, '2019-11-26 17:00:00', '2021-03-01 23:21:44', 0),
(98, 'external', 'SBT.2019.056', 're-dial up agitator mixing gargle 2500 L', 77, 17, 1, '2019-11-26 17:00:00', '2021-03-01 23:22:51', 0),
(99, 'external', 'SBT.2019.057', 'WT-WS-FTN ', 55, 17, 1, '2019-12-04 17:00:00', '2021-03-01 23:23:48', 0),
(100, 'external', 'SBT.2019.058', 'Flange Slip On Raise Face (RF) - Material MS', 50, 17, 1, '2019-12-09 17:00:00', '2021-03-01 23:25:02', 0),
(101, 'external', 'SBT.2019.059', 'ADDITIONAL WORK FOR MODIFICATION EXTENDED PW LOOPING 2 FLOOR TO QC', 78, 17, 1, '2019-12-10 17:00:00', '2021-03-01 23:26:22', 0),
(102, 'external', 'SBT.2019.060', 'Flange Slip On Raise Face (RF) - Material MS', 84, 17, 1, '2019-12-16 17:00:00', '2021-03-01 23:27:51', 0),
(103, 'external', 'SBT.2019.061', 'Chemical for Sanitation  ', 80, 17, 1, '2019-12-19 17:00:00', '2021-03-01 23:29:47', 0),
(104, 'external', 'SBT.2019.004', 'Material - Change Strainer Filter 80mesh Mixing Aweco', 107, 17, 1, '2019-06-13 17:00:00', '2021-02-24 01:00:17', 0),
(105, 'external', 'SBT.2019.005', 'Material - Perbaikan dedleg di jalur PW Supply dari PW Gen', 108, 17, 1, '2019-06-13 17:00:00', '2021-02-24 22:52:42', 0),
(107, 'external', 'SBT.2019.050', 'PN16 SLIP ON FLANGES 25MM SET C/W BOLT&NUT', 105, 17, 1, '2019-11-10 17:00:00', '2021-03-01 23:11:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_customers`
--

CREATE TABLE `purchase_order_customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `quotation_customer_id` int(11) DEFAULT NULL,
  `status` enum('received','on-process','cancelled') COLLATE utf8_unicode_ci NOT NULL,
  `received_date` date NOT NULL DEFAULT '2019-11-22',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_order_customers`
--

INSERT INTO `purchase_order_customers` (`id`, `code`, `customer_id`, `description`, `amount`, `quotation_customer_id`, `status`, `received_date`, `created_at`, `updated_at`, `file`) VALUES
(3, '047/XSX/VII/2020', 11, '2pcs  Name Plate For Separator 1808 @ 500.000', '1100000.00', 3, 'received', '2020-08-10', '2020-08-11 23:50:38', '2020-09-30 21:33:29', NULL),
(4, 'PO/HWI/20/000394', 12, '1 lot Chain Munson RS80-3R Chain', '20000000.00', 4, 'received', '2020-07-02', '2020-08-12 01:45:10', '2020-08-12 01:45:10', '1597221910_HWR_PO 394 CHAIN MUNSON 20 - SBT 20.030.pdf'),
(5, '5002700229-0002', 13, '1 Lot Labour Cost For Instal SS Ducting', '16170000.00', 5, 'received', '2020-04-03', '2020-08-12 02:15:57', '2020-08-12 02:15:57', '1597223757_img-408110035-0001 - SBT 20.019.pdf'),
(6, '5002700229-0001', 13, '1 Lot Supply Of Material For SS Ducting', '30030000.00', 6, 'received', '2020-04-03', '2020-08-12 02:23:17', '2020-08-12 02:23:17', '1597224197_img-408110035-0001 - SBT 20.019.pdf'),
(7, '014/SXS/II/2020', 11, '3 Pcs Name Plate Separator 1808', '1650000.00', 7, 'received', '2020-02-26', '2020-08-12 02:28:00', '2020-08-12 02:28:00', '1597224480_nameplate - SBT 20.009.pdf'),
(9, 'ZINV 4503015540', 14, '1 Unit WT-WS-FTN-Add Work Poseidon Gap', '49500000.00', 9, 'received', '2020-03-15', '2020-08-12 03:27:00', '2020-08-12 03:27:00', '1597228020_PO 4503015540 - Sedulang Bintang Teknik - SBT20.013.pdf'),
(10, 'ZINV 4502991190', 14, '1 Unit WT-PU-UV-UV Instalation', '100000000.00', 10, 'received', '2020-02-27', '2020-08-12 03:34:09', '2020-09-12 01:15:55', '1597228449_PO 4502991190 - Sedulang Bintang Teknik - SBT 20.011.pdf'),
(11, 'ZINV 4503028158', 14, '1 UN WT-WD-WLP-UPGRADE POSEIDON GAP', '1150000000.00', 11, 'received', '2020-03-24', '2020-08-12 03:57:02', '2020-08-12 03:57:02', '1597229822_PO 4503028158 - Sedulang Bintang - SBT 20.015.pdf'),
(12, 'ZINV 4503030208', 14, '1 UN WT-WD-WLP-UV Lamp WT-B @ 15.000.000\r\n1 UN WT-WD-WLP-UV Lamp WT-D @ 15.000.000\r\n\r\n', '30000000.00', 12, 'received', '2020-03-26', '2020-08-12 04:19:41', '2020-08-12 04:20:28', NULL),
(13, 'ZINV 4503030239', 14, '1 UN WT-WD-WLP-INTERLOCK UV LAMP', '12000000.00', 13, 'received', '2020-03-26', '2020-08-12 04:29:00', '2020-08-12 04:29:00', '1597231740_PO 4503030239 - Sedulang Bintang Teknik - SBT20.017.pdf'),
(14, 'ZINV 4503076175', 14, '1 Unit WT-WD-WLP-INTERLOCK UV ', '15000000.00', 14, 'received', '2020-04-30', '2020-08-18 21:04:19', '2020-08-18 21:04:19', '1597809859_PO 4503076175 - Sedulang - SBT 20.025.pdf'),
(15, 'ZINV 4503081327', 14, '1 UN WT-WS-CIP-MATERIAL COST @ 155.397.250\r\n1 UN WT-WS-CIP-SERVICE COST  @ 102.602.750\r\n', '258000000.00', 15, 'received', '2020-05-05', '2020-08-18 21:20:29', '2020-08-18 21:20:29', '1597810829_PO 4503081327 - Sedulang Bintang Teknik - SBT 20.026.pdf'),
(16, 'ZINV 4503144775', 14, '1 UN WT-WD-WLP-INTERLOCK WT 1 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 2 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 3 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 4 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 5 @18.000.000', '82000000.00', 16, 'received', '2020-07-03', '2020-08-19 03:16:24', '2020-08-19 03:16:24', '1597832184_PO 4503144775 - Sedulang Bintang Teknik - SBT 20.029.pdf'),
(17, 'MBF/2002/0427', 15, '1 Unit check PLC program at CIP & Mixing Syste  @2.970.000\r\n', '2970000.00', 17, 'received', '2020-02-17', '2020-08-19 04:11:31', '2020-08-19 04:11:31', '1597835491_PO MBF 2001 0427 (SEDULANG BINTANG TEKNIK) - SBT 20.024.pdf'),
(18, ' MBF/2002/0170', 15, '1 Unit MAIN MIXING TANK @ 40,517,085\r\n1 Unit UTILITY LINE FOR NEW JACKETING AT M @ 10,594,454\r\n1 Unit INSTRUMENTATION @ 7,267,537\r\n1 Lot INSTALLATION @ 14,133,158\r\n1 Lot MOB DEMOB @ 7,487,766\r\n', '88000000.00', 18, 'received', '2020-02-06', '2020-08-19 04:55:55', '2020-08-19 04:55:55', '1597838155_PO MBF 2002 0170  (SEDULANG BINTANG TEKNIK) - SBT 20.008.pdf'),
(19, ' MBF/2002/0710', 15, '1 Unit printer cartridge recorder KRN100 @ 3,000,000\r\nDisc 15% + Ppn 10%\r\n', '2805000.00', 19, 'received', '2020-02-28', '2020-08-19 05:15:41', '2020-08-19 05:15:41', '1597839341_PO MBF 2002 0710 (SEDULANG BINTANG TEKNIK) - SBT 20.010.pdf'),
(20, ' MBF/2003/0662', 15, '1 Unit batch reporting system for CIP & mixing fa @ 40.000.000\r\nppn 10% ', '44000000.00', 20, 'received', '2020-03-27', '2020-09-01 19:54:41', '2020-09-01 19:54:41', '1599015281_PO MBF 2003 0662 (SEDULANG BINTANG TEKNIK) - SBT 20.16.pdf'),
(21, ' MBF/2007/0072', 15, '1 Unit burkert flow controller type 8025 panel mo @ 14.000.000\r\n1 Unit burkert high temp Peddle Type S030 @ 11.000.000\r\n\r\nPPN 10%', '27500000.00', 21, 'received', '2020-07-06', '2020-09-01 20:02:49', '2020-09-01 20:02:49', '1599015769_PO MBF 2007 0072 (SEDULANG BINTANG TEKNIK) - SBT20.031.pdf'),
(22, ' MBF/2007/0404', 15, '1 Unit Minox MX-SV platinum cured silicone braid reinforced hose id:25.4 mm od: 35.81 mm L=2,000mm @ 10.000.000\r\n\r\n\r\nUser Mas Sulis\r\nPRO/PBJ/2006/0131\r\nPermintaan Selang CIP SIP\r\nDisc 10% + PPN 10%\r\n\r\n\r\n\r\n\r\n', '9900000.00', 22, 'received', '2020-07-28', '2020-09-01 20:14:12', '2020-09-01 20:14:12', '1599016452_PO MBF 2007 04040  (SEDULANG BINTANG TEKNIK) - SBT20.038.pdf'),
(23, ' MBF/2006/0099', 15, '2 Jerigen Cleaning Agent Pro A++ @ 775.500 \r\n2 Jerigen Cleaning Agent Pro B++ @ 621.666\r\n\r\nUser : Imas (Prod Liquid)\r\n\r\nPPN 10%', '3073765.20', 23, 'received', '2020-06-09', '2020-09-01 20:24:18', '2020-09-01 20:24:18', '1599017057_PO mbf.2006.0099 (sedulang) - SBT 20.028.pdf'),
(24, ' MBF/2007/0247', 15, '1 Jerigen  Cleaning Agent Pro A++ @ 775.500\r\n\r\nUser : imas (Prod Liquid)\r\n\r\nPPN 10%', '853050.00', 24, 'received', '2020-07-16', '2020-09-01 20:32:11', '2020-09-01 20:32:11', '1599017531_PO Mbf.2007.0247 (sedulang bintang) - SBT 20.034.pdf'),
(25, ' MBF/2007/0255', 15, '1 Jerigen chemical micro kill (prodes) @ 660.000\r\n\r\nchemical micro kill (prodes) \r\n\r\nPPN 10%', '726000.00', 25, 'received', '2020-07-16', '2020-09-01 20:41:55', '2020-09-01 20:41:55', '1599018115_PO mbf.2007.0255 (Sedulang bintang) - SBT 20.035.pdf'),
(26, '20350004 OO', 11, '1 Unit MFP14-PPU SIMPLEX 50MM c/w PRV PACKAGED PUMP UNIT @ 27.000.000\r\n\r\nUser : Riris Dawati Nababan', '27000000.00', 26, 'received', '2020-01-14', '2020-09-01 20:56:43', '2020-09-12 01:08:27', '1599019003_PO no. 20350004 - MFP14 50MM PRV - SEDULANG - SBT 20.001.pdf'),
(27, '20350011 O1', 11, '2 pcs PN40 SLIP ON FLANGES 80MM @ 300.000\r\n\r\nUser : Eka Asmaralda Stya Nazar \r\n', '600000.00', 27, 'received', '2020-01-20', '2020-09-01 21:01:38', '2020-09-12 01:09:51', '1599019298_PO no. 20350011 - Flange - SBT 20.003.pdf'),
(28, '20350013 O1', 11, '1 Pcs ELBOW CONNECTION DN25XDN25 @ 2.500.000\r\n\r\nUser: Eka Asmaralda Stya Nazar \r\n', '2500000.00', 28, 'received', '2020-01-22', '2020-09-01 21:44:22', '2020-09-12 01:11:15', '1599021862_PO no. 20350013 - Elbow - SBT 20.004.pdf'),
(29, '20350017OO', 11, '1 Unit MFP14 80MM PACKAGED TRIPLEX PACKAGE 80X50MM @ 46.800.000\r\n\r\nUser :\r\nRiris Dawati Nababan \r\n\r\n', '46800000.00', 29, 'received', '2020-01-27', '2020-09-01 22:09:38', '2021-03-05 00:00:22', '1599023378_PO no. 20350017 - Sedulang MFP14 80MM Triplex - SBT 20.005.pdf'),
(30, '20350022O1', 11, '1 Pcs ELBOW CONNECTION DN40XDN40 @3.500.000\r\n\r\n', '3500000.00', 30, 'received', '2020-01-30', '2020-09-01 22:21:21', '2021-03-05 00:06:55', '1599024081_PO no. 20350022 - Elbow - SBT 20.007.pdf'),
(31, '153670', 16, '1 Set SLINK  D12MMXP15M MILD STEEL (90m) @ 4.500.000\r\n1 Set Jasa Penggantian Sling Chimney (Man Power, Accomodation, Tools & Supporting  @7.000.000\r\n\r\n', '11500000.00', 32, 'received', '2020-07-22', '2020-09-01 22:46:28', '2020-09-01 22:46:28', '1599025588_PO_81_153670_0_US - SBT20.037.pdf'),
(32, '151439', 16, '1 Set Jasa Bongkar Pasang Boiler (NDE Work For Hokken Boiler 8 ton) @ 10.000.000\r\n1 Set Material ( 2 Lbr Packing Gasket Klingerit C200 Tebal 3-5mm) @ 7.500.000\r\n\r\n', '17500000.00', 31, 'received', '2020-04-23', '2020-09-01 22:48:23', '2020-09-01 22:48:23', '1599025703_PO_81_151439_Sedulang - SBT 20.023.pdf'),
(33, '145805', 16, '1 set As Mesin Upgrading Tangki Cst Level Transmitter\r\n\r\n\r\n\r\nRefer To Quotation: 19.IX.009-Rev.4 (17 Jan 2020)', '72000000.00', 33, 'received', '2020-01-17', '2020-09-01 22:55:30', '2020-09-01 22:55:30', '1599026130_PO-145805-Sedulang - SBT 20.002.pdf'),
(34, '149808', 16, '12 Pcs Gasket EPDM For PHE M6-MFG @ 650.000\r\n\r\n\r\nRefer To Quotation: 20.II.008 - Rev.0 - 13 Feb 2020', '7800000.00', 34, 'received', '2020-03-20', '2020-09-01 23:00:31', '2020-09-01 23:00:31', '1599026431_PO-149808-Sedulang - SBT 20.014.pdf'),
(35, '153069', 16, '1 Set Jasa Perbaikan Tangki KAP 15.000L2 @ 3.500.000\r\n\r\nUser:\r\nAmalia Utari, Ms', '3500000.00', 35, 'received', '2020-07-16', '2020-09-01 23:07:57', '2020-09-01 23:07:57', '1599026877_PO-153069-Sedulang - SBT 20.032.pdf'),
(36, 'PO2003024', 17, '1 Lot Material Orbital Welding (POU Connecting) @ 5.166.667\r\n1 Lot Instalasi (Mechanical Installation) @ 1.500.000\r\n1 Lot Material Pendukung @ 8.333.333\r\nPro : Project Syrup\r\n\r\n', '14850000.00', 36, 'received', '2020-03-03', '2020-09-01 23:40:38', '2020-09-01 23:40:38', NULL),
(37, '150/PO/PT.ISAM/IV/2020', 18, '1 Lot New CIP. Filling Line (Material & Installation) @ 120.983.743\r\n1 Lot Swing Bend Pane (Material & Installation) @ 49.443.200\r\n1 Lot U Bend Panel 2 set ( Material & Installation) @ 8.778.994\r\n1 Lot Other (Material & Installation) @ 20.794.063\r\n\r\nDisc 20% \r\nPPN 10%', '176000000.00', 37, 'received', '2020-04-20', '2020-09-02 01:02:50', '2020-09-02 01:02:50', '1599033770_PT_Sedulang Bintang Teknik - SBT 20.020.pdf'),
(38, '5002700219-0022', 19, '1 Lot Labour Cost For Mechanical Arjunior Desk and Table @ 12.712.329\r\n\r\nDisc : Rp. 1.712.329\r\nPPN 10%', '12100000.00', 38, 'received', '2020-06-29', '2020-09-02 01:40:07', '2020-09-02 01:40:07', '1599036007_Sedulang - SBT 20.021-022.pdf'),
(39, '5002700219-0021', 19, '1 Lot Supply Of Material For Material Work Arjunior Desk and Table @ 20.020.548\r\n\r\nDisc. 20.548\r\nPPN 10%\r\n', '22000000.00', 39, 'received', '2020-06-29', '2020-09-02 01:47:54', '2020-09-02 01:47:54', '1599036474_Sedulang - SBT 20.021-022.pdf'),
(40, '5002700219-0020', 19, '1 Lot Labour Cost For Meechanical Work Install SS Drain Pipe @ 5.000.000\r\n\r\nPPN 10%', '5500000.00', 40, 'received', '2020-06-29', '2020-09-02 01:53:42', '2020-09-02 01:53:42', '1599036822_Sedulang - SBT 20.021-022.pdf'),
(41, '5002700219-0019', 19, '1 Lot Supply Material for Mechanical Work SS Drain Pipe @ 7.000.000\r\n\r\nPPN 10%', '7700000.00', 41, 'received', '2020-06-29', '2020-09-02 01:57:27', '2020-09-02 01:57:27', '1599037047_Sedulang - SBT 20.021-022.pdf'),
(42, 'ZINV  4503166053', 14, '1 Unit WT-WS-PSI-Percabangan Vent Filter FT S @ 28.000.000', '28000000.00', 42, 'received', '2020-07-21', '2020-09-02 02:02:09', '2020-09-02 02:02:09', '1599037329_ZINV 4503166053 - SBT20.036.pdf'),
(43, '20350016O1', 11, '8 Pcs PN16 Slip On Flanges 25MM @162.588 \r\n16Pcs Bolt & Nut M16 X 70MM @ 54.717\r\n4 Pcs SWG Gasket SS304 For PN16 @93.801\r\n4 Pcs ANSI 250 Slip On Flanges 25MM @234.501\r\n8 Pcs Bolt & Nut M16 x 70MM @54.717\r\n2 Pcs SWG Gasket ss304 For ANSI250 25MM @93.801\r\n', '4114722.00', 43, 'received', '2020-01-24', '2020-09-12 00:59:01', '2020-09-12 00:59:01', '1599897541_29012020141455 - SBT 20.006.pdf'),
(44, 'QC-20-10-001', 16, 'Modification CA & N2 line', '12500000.00', 44, 'received', '2020-05-14', '2020-09-30 21:08:19', '2020-09-30 21:08:19', NULL),
(45, '19350173O1', 11, '6 Pcs PN40 SLIP ON FLANGES 250MM @2.284.286\r\n2 Pcs PN40 SLIP ON FLANGES 200MM @900.000\r\n2 Pcs PN40 SLIP ON FLANGES 150MM @751.429\r\n\r\n\r\n', '17800574.00', 45, 'received', '2019-06-20', '2020-10-06 02:51:22', '2020-10-06 03:14:48', '1601977882_19350173 flanged.pdf'),
(46, '19350109O1', 11, '2 Pcs Ferrule, Clamp, & Sel Ring Set  @ 215.000\r\nStainless Steel For 40 mm', '430000.00', 46, 'received', '2019-06-20', '2020-10-06 03:23:04', '2020-10-06 03:23:04', '1601979784_21062019090322.pdf'),
(47, '001-ADD 2-PO-RTI-IX-2019', 20, 'Additional II Work for Tank Leveling Works \r\nMaterial \r\nInstallation', '104996417.00', 47, 'received', '2019-09-17', '2020-10-06 04:30:20', '2020-10-06 04:30:20', '1601983820_PO  No.  001-ADD 2-PO-RTI-IX-2019.pdf'),
(48, '056/SXS/VII/2019', 11, '1 Set Flange Raise Face (RF) PN 16 @ 1.700.000\r\n- Material SS304L\r\n\r\n+Pph 23 170.000', '1870000.00', 48, 'received', '2019-07-25', '2020-10-06 04:40:22', '2020-10-06 04:40:22', '1601984422_PO 056.pdf'),
(49, 'PO/HWI/19/000296', 12, '1 Set Chain Munson Mixer & Connecting Chain 80-3, L 480 MM Ex Japan @ 26.500.000', '26235000.00', 49, 'received', '2019-06-17', '2020-10-06 04:47:57', '2020-10-06 04:47:57', '1601984877_PO 296 CHAIN MIXER001.pdf'),
(50, '19350272O1', 11, '- 2 Pcs ANSI 250 Slip On Flanges 80 MM @ 211.051\r\n- 2 Pcs PN40 Slip On FLanges 80 MM @ 203.204\r\n- 2 Pcs ANSI 250 slip On Flanges 20 MM @ 62.534\r\n- 2 Pcs PN16 Slip On Flanges 80MM @164.151\r\n- 4 Pcs PN25 Slip On Flanges 100 MM @ 351.752\r\n- 8 Pcs PN25 Slip On Flanges 15 MM @ 75.040\r\n- 6 Pcs PN25 Slip On Flanges 40 MM @ 171.968\r\n- 12 Pcs PN25 Slip On Flanges 50 MM @ 211.051 \r\n- 2 Pcs PN25 Slip On Flanges 80 MM @ 297.035\r\n- 2 Pcs PN40  Slip On Flanges 40 MM @109.434', '7666626.00', 50, 'received', '2019-09-12', '2020-10-06 05:05:49', '2020-10-06 05:05:49', '1601985949_PO 19350272.pdf'),
(51, 'ZINV 4502781195', 14, '1 Unit WT-PU-WTF-POSEIDON UPGRADE ', '400000000.00', 51, 'received', '2019-09-18', '2020-10-18 21:32:50', '2020-10-18 21:32:50', '1603081970_PO 4502781195 - Sedulang Bintang.pdf'),
(52, 'ZINV 4502781246', 14, '1 AU WT-PU-UV-PHYSICAL BREAK', '140000000.00', 52, 'received', '2019-09-18', '2020-10-18 21:47:15', '2020-10-18 21:47:15', '1603082835_PO 4502781246 - Sedulang Bintang.pdf'),
(53, 'ZINV 4502854028', 14, '1 UN WT-PU-WTF-POSEIDON UPGRADE', '88000000.00', 53, 'received', '2019-11-13', '2020-10-18 22:30:50', '2020-10-18 22:30:50', '1603085450_PO 4502854028 - Sedulang Bintang.pdf'),
(54, 'ZINV 4502854176', 14, '1 un WT-PU-WTF-MATERIAL POSEIDON UPG @ 27.000.000\r\n1 au WT-PU-WTF-INSTALATION POSEIDON U @ 21.000.000', '48000000.00', 54, 'received', '2019-09-13', '2020-10-18 23:05:51', '2020-10-18 23:05:51', '1603087551_PO 4502854176 - Sedulang Bintang.pdf'),
(55, 'ZINV 4502884716', 14, '- 1 AU WT-WS-FTN-MAT PARTS @ 78.196.230\r\n- 1 AU WT-WS-FTN-INSTALATION COST @ 81.803.770\r\n', '160000000.00', 55, 'received', '2019-12-05', '2020-10-18 23:36:58', '2020-10-18 23:36:58', '1603089418_PO 4502884716 - Sedulang Bintang Teknik.pdf'),
(57, 'MBF/1905/0510', 15, '- 1 Unit EDI module MK3 Mini HT Brand SUEZ (GE E-C ) @ 116.000.000\r\n- 1 Unit  DC Power Canpure @ 14.000.000', '143000000.00', 57, 'received', '2019-05-28', '2020-10-19 00:28:05', '2020-10-19 00:28:05', '1603092485_PO MBF 1905 0510 (SEDULANG BINTANG TEKNIK).pdf'),
(58, ' MBF/1906/0236', 15, '- 1 Pcs VALVE BUTTERFLY DN25 PNEUMATIC ACTUAT @ 4.284.702\r\n- 1 Lot PIPE, FITTINGS & SUPPORT SANITARY ISO20 @ 2.587.473\r\n- 1 Lot TUBING PUN 6 MM INSTALLASI @ 391.511\r\n- 1 Lot MECHANICAL INSTALLATION @ 1.437.630\r\n- 1 Lot ACCOMODATION @ 798.683', '8882498.90', 58, 'received', '2019-06-17', '2020-10-19 00:37:48', '2020-10-19 00:40:45', '1603093068_PO MBF 1906 0236 (SEDULANG BINTANG TEKNIK).pdf'),
(59, 'MBF/1906/0260', 15, '1 Pcs  ELEMENT P-SRF C 05/30  @ 6.500.000 Disc 10% =  5.850.000\r\n+ PPN 10% ', '6435000.00', 59, 'received', '2019-06-18', '2020-10-19 00:49:41', '2020-10-19 00:49:41', '1603093781_PO MBF 1906 0260 (SEDULANG BINTANG TEKNIK).pdf'),
(60, 'MBF/1906/0263', 15, '- 4 Pcs VALVE BUTTERFLY DN25 MANUAL @ 1.275.398,5\r\n- 1 Lot  PIPE, FITTINGS & SUPPORT SANITARY ISO20 (Installasi)   @ 1.400.438\r\n- 1 Lot MECHANICAL INSTALLATION @ 2.700.844\r\n- 1 Lot ACCOMODATION @v 797.124\r\n\r\nDisc 10% + PPN 10%\r\n', '9900001.10', 60, 'received', '2019-06-18', '2020-10-19 01:00:38', '2020-10-19 01:00:38', '1603094438_PO MBF 1906 0263 (SEDULANG BINTANG TEKNIK).pdf'),
(61, ' MBF/1906/0297', 15, '1 Pc DN40XDN20 : P/N: 9625 10M1-1/N @ 5.500.000 - Disc 10% = 4.950.000\r\n(PPOU AUTOCLAVE NBL BUILDING)\r\n+ PPN 10% ', '5445000.00', 61, 'received', '2019-06-20', '2020-10-19 01:09:12', '2020-10-19 01:09:12', '1603094952_PO MBF 1906 0297 (SEDULANG BINTANG TEKNIK).pdf'),
(62, ' MBF/1906/0343', 15, '- 2 Pail Chemical Micro Kill (Prodes) @ 660.000\r\n- 12 Pail  Chemical High pH (ProCIP B++) @ 621.666,67\r\n-  8 Pail Chemical Low pH (ProCIP A++) @ 777.500\r\n\r\n+ PPN 10%', '16500000.00', 62, 'received', '2019-06-24', '2020-10-19 01:39:48', '2020-10-19 01:39:48', '1603096788_PO MBF 1906 0343 (SEDULANG BINTANG TEKNIK).pdf'),
(63, ' MBF/1906/0344', 15, '-1 Lot CHEMICAL SUPPLY FOR LOW pH, HIGH pH ( MICRO KILL @ 1 PAIL) @ 3.650.000\r\n- 1 Lot SANITATION & CIP SUPPORT @ 10.000.000\r\n\r\nDisc 10%\r\nDan PPN 10%', '13513500.00', 63, 'received', '2019-06-24', '2020-10-19 01:57:00', '2020-10-19 01:57:00', '1603097820_PO MBF 1906 0344 (SEDULANG BINTANG TEKNIK).pdf'),
(64, 'MBF/1906/0438', 15, '7 Pail Chemical Pro A++  @ 777.500\r\n\r\n+PPN 10%', '5986750.00', 64, 'received', '2019-06-26', '2020-10-19 02:01:06', '2020-10-19 02:01:06', '1603098066_PO MBF 1906 0438 (SEDULANG BINTANG TEKNIK).pdf'),
(65, 'MBF/1907/0216', 15, '2 Unit chemical micro kill (prodes) @ 660.000\r\n+PPN 10%', '1452000.00', 65, 'received', '2019-07-08', '2020-10-19 02:05:38', '2020-10-19 02:05:38', '1603098338_PO MBF 1907 0216 (SEDULANG BINTANG TEKNIK).pdf'),
(66, 'MBF/1907/0225', 15, '1 Unit Burkert Flow Hall Sensor type SE 30 @ 4.500.000 -disc 10% = 4.050.000\r\n\r\n+PPN 10%', '4455000.00', 66, 'received', '2019-07-09', '2020-10-19 02:30:24', '2020-10-19 02:30:24', '1603099824_PO MBF 1907 0225 (SEDULANG BINTANG TEKNIK).pdf'),
(67, ' MBF/1907/0319', 15, '3 Unit RO Membrane merk DOW FILMTEC HSRO 404 @ 10.500.000\r\n+ PPN 10%\r\n', '34650000.00', 67, 'received', '2019-07-16', '2020-10-19 02:57:31', '2020-10-19 02:57:31', '1603101451_PO MBF 1907 0319  (SEDULANG).pdf'),
(68, 'MBF/1907/0326', 15, '1 Unit RO Membrane merk DOW FILMTEC HSRO 404 @10.500.000\r\n\r\n+ PPN 10%', '11550000.00', 68, 'received', '2019-07-16', '2020-10-19 03:06:13', '2020-10-19 03:06:13', '1603101973_PO MBF 1907 0326  (SEDULANG).pdf'),
(69, ' MBF/1907/0485', 15, '1 Unit Vent filter 10\" element SRV V 10/3 P7, Donald @ 9.000.000 disc 10% = 8.100.000\r\n+ PPN 10%', '8910000.00', 69, 'received', '2019-07-23', '2020-10-19 03:09:45', '2020-10-19 03:10:04', NULL),
(70, ' MBF/1907/0540', 15, '-  chemical pro a++\r\n-  chemical pro b++\r\n\r\n+10 PPN', '17958416.30', 71, 'received', '2019-07-24', '2020-10-25 21:17:19', '2020-10-25 21:17:19', '1603685839_PO MBF 1907 0540 (SEDULANG BINTANG TEKNIK).pdf'),
(71, ' MBF/1909/0043', 15, '- 1 Unit Modifikasi jalur return CIP : Sampling Valve  @ 2.403.572\r\n- 1 Unit Pipe, fitting & support @ 977.429\r\n-  1 Unit Installation cost\r\n\r\n+ PPN 10%', '4082619.20', 72, 'received', '2019-09-03', '2020-10-25 21:32:23', '2020-10-25 21:32:23', '1603686743_PO MBF 1909 0043  (SEDULANG).pdf'),
(72, ' MBF/1909/0082', 15, '- 1 Unit S UV CONNECTOR PW LOOP 3rd & 4rd FLOOR M @ 8.055.085\r\n- 1 Lot  A INSTALLASI COST UV CONNECTOR PW LOOP @ 6.129.731\r\n- 1 Lot INSTALLASI REPAIR DEALEG AT TT PW TANK @ 704.577\r\n- 1 Unit REPAIR DIALEG AT PW GEN @ 614.994\r\n- 1 Lot INSTALLASI REPAIR DEALEG AT PW GEN @2.113.730\r\n- 1 Lot ACCOMODATION  @ 1,129,129\r\n- 1 Lot PASSIVATING @ 752,753\r\n\r\nDisc 10% = 17,549,999.00\r\n + PPN 10% ', '19304998.90', 73, 'received', '2019-09-04', '2020-10-25 21:45:55', '2020-10-25 21:45:55', '1603687555_PO MBF 1909 0082  (SEDULANG).pdf'),
(73, ' MBF/1909/0085', 15, '- 1 Lot  TOC Meter support @ 1,257,143\r\n- 1  Unit Electrical panel Recorder KRN100-600-4 @ 25,000,000 \r\n- 1 Unit Hardware panel @ 357,143\r\n- 1 Lot Cabling, tubing & Conduit support @ 142,857\r\n- 1 Lot Instalation cost TOC relocated  @ 1,028,571\r\n\r\nDisc 10% = 25,007,143.00\r\n+ PPN 10%', '27507857.30', 74, 'received', '2019-09-04', '2020-10-25 22:06:29', '2020-10-25 22:06:29', '1603688789_PO MBF 1909 0085  (SEDULANG).pdf'),
(74, ' MBF/1909/0273', 15, '1 Unit burkert high temp. fitting type s030 temp range 0-125 C @ 16,000,000\r\n Disc 10% =14,400,000.00\r\n\r\n+PPN 10%', '15840000.00', 75, 'received', '2019-09-12', '2020-10-25 22:15:59', '2020-10-25 22:15:59', '1603689359_PO MBF 1909 0273  (SEDULANG).pdf'),
(75, ' MBF/1909/0274', 15, '- 1 Unit burkert se30 for high temp @ 4,500,000\r\n- 1 Unit burkert flow controller type 8025 panel mounti @ 14,500,000\r\n\r\nDisc 10% = 17,100,000.00\r\n\r\n+PPN  10%', '18810000.00', 76, 'received', '2019-09-12', '2020-10-25 22:26:50', '2020-10-25 22:26:50', '1603690010_PO MBF 1909 0274  (SEDULANG).pdf'),
(76, ' MBF/1910/0111', 15, '- 3 Unit S Material Short Cut PW Loop To POU  & Spool Pieces\r\n @ 2,242,350 \r\n- 3 Jasa Installasi Short Cut PW loop to POU  & Spool Pieces @ 1,207,170\r\n- 3 Unit PW Loop to Qc @ 23,998,343.11\r\n- 3 JASA EXP-JAMA Instalasi PW Loo @ 12,942,300\r\n- 3 Unit Uv Lamp Relocated Form PW Return Line  To Pw Supply @ 2,423,350\r\n- 3 Jasa Uv Lamp Relocated Form PW Return Line  To Pw Supply @ 1,652,400\r\n- 3 Lot Other Installation Cost For Qc RND @ 8,459,306.2\r\n- 2 Unit Material Short Cut Pw loop to POU & Spool Pieces @ 2,242,350\r\n- 2 Jasa Installasi Short Cut Pw Loop to POU & Spool Pieces @ 1,207,170 \r\n- 2 Unit  Pw Loop To RND @ 30,964,944.83 \r\n- 2 Jasa Instalalasi Pw Loop To RND @ 16,162,650\r\n- 2 Unit Uv Lamp Relocated Form Pw Return Line  to PW Supply @ 2,423,350\r\n- 2 Jasa Uv Lamp Relocated Form Pw Return Line to PW Supply @ 1,652,400\r\n- 2 Lot Other Installation Cost For RND @ 8,459,306.2\r\n\r\n+ PPN 10%\r\n\r\n', '313500000.00', 77, 'received', '2019-10-04', '2020-10-25 23:06:13', '2020-10-27 03:49:02', '1603692373_PO MBF 1910 0111  (SEDULANG)1.pdf'),
(77, ' MBF/1911/0667', 15, '1 Lot re-dial up agitator mixing gargle 2500 L @ 9.000.000\r\n + PPN 10%', '9900000.00', 78, 'received', '2019-11-27', '2020-10-26 02:14:38', '2020-10-26 02:14:38', '1603703678_PO MBF 1911 0667 (SEDULANG BINTANG TEKNIK).pdf'),
(78, 'MBF/1912/0232', 15, '- 1 Pcs PIPE ASME BPE SF 1 (ADD MATERIAL) FO @ 3,000,000\r\n- 1 Pcs PIPE ASME BPE SF 1 (ADD MATERIAL) FO @ 3,000,000\r\n- 1 Jasa INSTAL PIPE ASME BPE SF 1 (LAYOUT RE @ 7.000.000\r\n- 1 Jasa INSTAL PIPE ASME BPE SF 1 (LAYOUT RE @ 7.000.000\r\n- 1 Jasa EXS INSTAL MATERIAL ELBOW 90o ASME  @ 3.000.000\r\n- 1 Jasa EXS INSTAL MATERIAL ELBOW 90o ASME @ 3.000.000\r\n- 1 Pcs MATERIAL ELBOW 90o ASME BPE SF1 FO  @ 550,000\r\n- 1 Pcs MATERIAL ELBOW 90o ASME BPE SF1 FO @ 550.000\r\n- 1 Pcs INSTAL MATERIAL ELBOW 90o ASME BPE  @ 1.000.000\r\n- 1 Pcs INSTAL MATERIAL ELBOW 90o ASME BPE @ 1.000.000\r\n- 1 Jasa EXT INSTAL DIAGPHRAM VALVE FOR QC @ 200.000\r\n- 1  Jasa EXT INSTAL DIAGPHRAM VALVE FOR RND @ 200.000\r\n- 1 Pcs PIPE HOLDER FOR QC @ 100.000\r\n- 1 Pcs PIPE HOLDER FOR RND @ 100.000\r\n- 1 Pcs INSTAL PIPE HOLDER FOR QC @ 150.000\r\n- 1 Pcs INSTAL PIPE HOLDER FOR RND  @ 150.000\r\n\r\n+ PPN 10%', '33000000.00', 79, 'received', '2019-12-11', '2020-10-26 02:37:32', '2020-10-26 02:37:32', '1603705052_PO MBF 1912 0232 (SEDULANG BINTANG TEKNIK)2.pdf'),
(79, 'MBF/1907/0508', 15, '- 1 Pail Chemical Low pH (ProCIP A++) @ 777.500\r\n- 1 Pail Chemical High pH (ProCIP B++) @ 621.666,67\r\n- 1 Pail  Chemical micro kill (prodes) @ 660.000\r\n\r\n+ PPN 10%', '2265083.70', 80, 'received', '2019-07-23', '2020-10-26 02:58:39', '2020-10-26 02:58:39', '1603706319_po mbf.1907.0508 (sedulang).pdf'),
(80, ' MBF/1912/0648', 15, '- 4 Jerigen Cleaning Agent PRO A++ @ 777.500\r\n- 2 Jerigen Cleaning Agent PRO B ++ @ 621.666\r\n \r\n+PPN 10 %', '4788665.20', 81, 'received', '2019-12-20', '2020-10-26 03:04:12', '2020-10-26 03:04:12', '1603706652_po mbf.1912.0648 (sedulang).pdf'),
(81, ' 002-C007-2019', 20, 'MEK Measuriing Tank Header\r\n- 1 Unit  Fabrication @ 9,199,578\r\n- 1 Unit Material @ 4,431,124\r\n Assy Drawing No. 2BPO-HD2310-001-R0\r\n\r\nREACTION Tank Header\r\n- 2 Unit  Material @ 5,427,189\r\n- 2 Unit  Fabrication @ 4,355,676\r\n Assy Drawing No. 2BPO-HD2301AB-001-R0\r\n\r\n+ PPN 10%\r\n', '36516075.00', 82, 'received', '2019-10-03', '2020-10-26 03:17:45', '2020-10-26 03:17:45', '1603707465_PO No. 002-C007-2019 Rev1.pdf'),
(82, '19350097OO', 11, '2 Unit MFP14-PPU PACKAGED PUMP UNIT 40MM PN16 SIMPLEX @ 22.000.000\r\n\r\nExcld PPN 10%\r\n', '44000000.00', 83, 'received', '2019-05-24', '2020-10-26 03:25:17', '2020-10-26 03:25:17', '1603707917_PO No. 19350097 - MFP14 40MM 2 unit (CENTRINDO) - SEDULANG.pdf'),
(83, '19350112 O1', 11, '- 4 Pcs PN16 SLIP ON FLANGES 100MM @ 875.000\r\n- 4 Pcs PN16 SLIP ON FLANGES 80MM  @ 800.000\r\n\r\n', '6700000.00', 84, 'received', '2019-06-24', '2020-10-26 03:37:55', '2020-10-26 03:37:55', '1603708675_PO No. 19350112 - Flange turflow.pdf'),
(84, '19350283O1', 11, '2 Unit PN40 SLIP ON FLANGES 250MM @ 2.700.000 \r\n', '5400000.00', 85, 'received', '2019-12-17', '2020-10-26 03:42:22', '2020-10-26 03:42:22', '1603708942_PO No. 19350283 - FLANGE.pdf'),
(85, '134786', 16, '- 1 Unit MATERIAL REPAIR BUSHING BOTTOM BEARING STORAGE TANK 15000L @ 6,580,709\r\n- 1 Unit MATERIAL REPAIR BUSHING BOTTOM BEARING MIXING TANK 15000L @ 7,429,832\r\n- 1 Unit JASA INSTALASI RE-ALIGNMENT AGITATOR STORAGE TANK 15000L @ 7,216,382\r\n- 1 Unit JASA INSTALASI RE-ALIGNMENT AGITATOR STORAGE TANK 15000L @ 7,216,382\r\n- 1 Unit JASA INSTALASI POLESHING AND WOOD STAGING INSIDE TANK @ 4,871,058\r\n- 1 DOCUMENTATION @ 2,179,949\r\n- 1 MOBILISASI @ 2,505,688\r\n\r\n\r\n\r\n\r\n', '38000000.00', 86, 'received', '2019-05-23', '2020-10-26 04:51:40', '2020-10-26 04:51:40', '1603713100_PO-134786-Sedulang Bintang.pdf'),
(86, '142279', 16, '1 Unit INNER BOTTOM BEARING BUSHING SK4282 (FOR YOBASE RM TANK) @ 1,800,000', '1800000.00', 87, 'received', '2019-11-13', '2020-10-26 04:55:23', '2020-10-26 04:55:23', '1603713323_PO-142279-Sedulang Bintang.pdf'),
(87, '19065854', 21, '- 3 Pcs Kalibrasi Temperature Transmitter Holding Tank @ 1.600.000\r\n- 1 Pcs Kalibrasi Process Presure Switchess Holding Tank @ 1.600.000\r\n- 3 Pcs Kalibrasi Temperature Transmitter Mixing Tank B @ 1.600.000\r\n- 1 Pcs  Kalibrasi Process Presure Switchess Holding Tank B @ 1.600.000\r\n-  3 Pcs Kalibrasi Temperature Transmitter Mixing Tank  C @ 1.600.000\r\n-  1 Pcs Kalibrasi Process Presure Switchess Mixing Tank C @ 1.600.000\r\n- 1 Pcs Kalibrasi Temprerature Transmitter Utility CIP B @ 1.600.000\r\n- 1  Pcs Kalibrasi Temprerature Transmitter Utility CIP C @ 1.600.000\r\n-  Biaya Akomodasi @ 2.000.000\r\n\r\n', '26840000.00', 88, 'received', '2020-06-28', '2020-10-26 05:16:13', '2020-10-26 05:16:13', '1603714573_PO19065854.pdf'),
(88, '001-ADD-PO-RTI-VI-2019', 20, '1 Lot Additional Work for Tank Levelling Works  @\r\n- Material Supply @ 25,968,329\r\n- Site Inatallation @ 17,830,588', '48178809.00', 89, 'received', '2019-07-25', '2020-10-27 03:27:16', '2021-03-01 21:38:03', '1603794436_Purchase Order No. 001-ADD-PO-RTI-VI-2019.pdf'),
(89, '001-PO-RTI-VI-2019', 20, '1 Lot Tank Levelling (9 Units) Jotun Indonesia includes : @ 350.909.966\r\n-  Material Supply\r\n-  Pre-fabrication\r\n-  Delivery to site\r\n-  Site installation & Test\r\n-  Necessary manpowers, Tools / Equipments & Consumables\r\n-  Transportation,mob-demob, accomodation,Safety\r\n\r\n+PPN 10%', '386000963.00', 90, 'received', '2019-06-27', '2020-10-27 03:33:28', '2020-10-27 03:33:28', '1603794808_Purchase Order No. 001-PO-RTI-VI-2019.pdf'),
(90, '5201165617', 22, '1 Lot MECHANICAL DEVICES @ 12.000.000\r\n1day Boroscope in Autan Line, used\r\nOlympus 6mm probe and length 8mtr\r\n +PPN 10%', '13200000.00', 91, 'received', '2019-07-12', '2020-10-27 03:44:57', '2020-10-27 03:44:57', '1603795497_Purchase order SC Johnson 5201165617.pdf'),
(91, '5002600268-0001', 13, 'Labour Cost For Cutting Silo Tank\r\n- 1 Lot Plasma Cutting Rent @ 25.000.000\r\n- 1 Lot Marpower @ 22.000.000\r\n- 1 Lot Transportation @ 3.000.000\r\n\r\n \r\n', '55000000.00', 92, 'received', '2019-09-12', '2020-10-27 04:32:12', '2020-10-27 04:32:12', '1603798332_Sedulang 5002600268-0001.pdf'),
(92, 'LAK190060', 23, '-  1 Lot Material untuk New Mixing Tank (Line 2) @ 17.000.000\r\n- 1 Lot Jasa untuk New Mixing Tank (Line 2) @ 3.000.000\r\n\r\n+PPN 10%', '22000000.00', 93, 'received', '2019-11-07', '2020-10-27 04:54:44', '2020-10-27 04:54:44', '1603799684_SEDULANG BINTANG TEKNIK, PT LAK190060.pdf'),
(93, 'LCK190027-C', 23, '1 Lot Platform Yenchen, Mixing Tank Dan Fitzmill Cakupan Pekerjaan : @ 144.000.000\r\n- Premix Tank platform new design\r\n- Yenchen Turbo mixer platform new design\r\n- Modification Fitzmill platform and move the existing\r\nplatform\r\nQuotation No. : Q-19.V.005-Rev.2\r\n\r\n+PPN10%', '158400000.00', 94, 'received', '2019-08-26', '2020-10-27 05:13:36', '2020-10-27 05:13:36', '1603800816_SEDULANG BINTANG TEKNIK, PT LCK190027-C.pdf'),
(94, 'LTK190400-C', 23, '- 1 Lot Mesin boiling tank line 5: Leakage Repair & \r\nRe-Insulated at Utility Line Boiling Tank 300L @ 25.000.000\r\n\r\n- 1 Lot Mesin boiling tank line 5: Leakage Repair &\r\nRe-Insulated at Utility Line Boiling Tank 600L @ 25.000.000\r\n\r\n+ppn 10%', '55000000.00', 95, 'received', '2019-05-06', '2020-10-27 05:19:14', '2020-10-27 05:19:14', '1603801154_SEDULANG BINTANG TEKNIK, PT LTK190400-C.pdf'),
(95, '034/SXS/V/2019', 11, ' 1 Unit SQT Ext. Elbow (Drawing Attached) @ 2.000.000\r\n- Material SUS316L\r\n\r\n+PPN 10%', '2200000.00', 96, 'received', '2019-05-20', '2020-10-27 05:24:16', '2020-10-27 05:24:16', '1603801456_SQT PIPE-0001.pdf'),
(96, 'POG/NT/1GT01/1905401', 24, '- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nJasa Filter di Mixing Tank Aweco @ 1,674,971\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS @ 3,538,448\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS @ 736,410\r\n\r\n+PPN 10%\r\n', '6544811.90', 97, 'received', '2019-05-21', '2020-10-27 06:31:44', '2020-10-27 06:31:44', '1603805504_XXPO_LOKAL_GI_26252672_1.PDF'),
(97, 'POG/NT/1GT01/1905423', 24, '- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS \r\nJasa perbaikan PW supply dari PW gen ke PW tank lantai 2  @ 7,846,674\r\n\r\n- 1 Lot  REPAIRS AND MAINTENANCEMACHINERY AND EQUIPMENTS\r\n Electrical Installation @ 2,461,702\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nEngineering  @ 3,371,164\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nCommisioning  @ 2,528,373\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nDocumentation @ 2,528,373\r\n\r\n-1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\n Accomodation  @ 2,179,632\r\n\r\n- 1 Lot  REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS \r\nChemical NaOH @ 871,853\r\n\r\n-1  Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nChemical HNO3  @ 653,889\r\n\r\n- 1 Lot  REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nPassivating Tools  @ 2,179,632.\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nManpower Passivating @ 836,979.\r\n\r\n+PPN 10%', '28004098.10', 98, 'received', '2019-05-23', '2020-10-27 08:29:00', '2020-10-27 08:29:00', '1603812540_XXPO_LOKAL_GI_27133168_1.PDF'),
(98, 'POG/NT/1GT01/1907092', 24, '1 Ea MATERIAL PROYEK MESIN DAN UTILITY @ 6,750,000.\r\n Service kits viton/ FPM manhole LKDC D450mm ex Alfa Lafal : reff\r\nQ-19.VII.0019 - Rev.0 \r\n\r\n+PPN 10%', '7425000.00', 99, 'received', '2019-07-17', '2020-10-27 08:33:49', '2020-10-27 08:33:49', '1603812829_XXPO_LOKAL_GI_27788903_1.PDF'),
(99, 'ZGS 4502770985', 14, '1 Unit FILL-PACK MAINT SE MF-MG-DPS-PHISICAL BREAK GIANT TANK\r\nThis item covers the following services:\r\nFor Physical Break Giant @ 14.000.000', '14000000.00', 100, 'received', '2019-09-12', '2020-10-27 08:38:19', '2020-10-27 08:38:19', '1603813099_ZGS 4502770985 - PHISICAL BREAK GIANT TANK.pdf'),
(100, 'MBF/1906/0237', 15, 'Drain CIP Return Pump Betsol', '8882499.00', 101, 'received', '2019-06-17', '2020-11-11 02:38:38', '2020-11-11 02:38:38', NULL),
(101, 'POG/NT/1GT01/1906016', 24, 'SL 316 rotary sprayball 1 inch BSP - minox (incl sertificate material)', '5400000.00', 102, 'received', '2019-06-24', '2020-11-12 04:46:05', '2020-11-12 04:46:05', NULL),
(102, 'ZINV 4502817099', 14, 'WT-PU-WTF-POSEIDON UPGRADE', '88000000.00', 103, 'received', '2019-10-17', '2020-11-16 04:58:36', '2020-11-16 04:58:36', NULL),
(103, '19350224 O1', 11, 'Flange Slip On Raise Face (RF)\r\n- Material MS', '5295714.00', 104, 'received', '2019-10-18', '2020-11-16 05:15:02', '2020-11-16 05:15:02', NULL),
(104, '111/SXS/XI/2019', 11, 'Flange Slip On Raise Face (RF)\r\n- Material MS', '770000.00', 105, 'received', '2019-11-06', '2020-11-16 05:21:09', '2020-11-16 05:21:09', NULL),
(105, '19350238 O1', 11, 'PN16 SLIP ON FLANGES 25MM\r\nSET C/W BOLT&NUT', '905142.00', 106, 'received', '2019-11-11', '2020-11-16 05:27:04', '2021-03-01 23:09:10', NULL),
(106, 'LCK190056-C', 23, 'Mesin Turbomixer Binder Upgrade Agitator', '60500000.00', 107, 'received', '2019-11-27', '2020-11-16 06:36:20', '2020-11-16 06:36:20', NULL),
(107, 'POG/NT/1GT01/1906002', 24, 'Material - Change Strainer Filter 80mesh Mixing Aweco', '26455189.00', 108, 'received', '2019-06-14', '2020-11-16 06:52:11', '2020-11-16 06:52:11', NULL),
(108, 'POG/NT/1GT01/1906001', 24, 'Material - Perbaikan dedleg di jalur PW Supply dari PW Gen', '25895902.00', 109, 'received', '2019-06-14', '2020-11-16 06:56:05', '2020-11-16 06:56:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_vendors`
--

CREATE TABLE `purchase_order_vendors` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `status` enum('uncompleted','completed','unresolved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'uncompleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_order_vendors`
--

INSERT INTO `purchase_order_vendors` (`id`, `vendor_id`, `code`, `purchase_request_id`, `description`, `amount`, `created_at`, `updated_at`, `quotation_vendor_id`, `sub_amount`, `vat`, `wht`, `discount`, `after_discount`, `terms`, `status`) VALUES
(1, 9, 'POV-20-07-001', 1, 'tytyty', '800.00', '2020-07-27 00:38:57', '2020-07-27 01:10:37', 1, '1000.00', 0, '0.00', 20, '800.00', '', 'completed'),
(3, 11, 'POV-20-11-001', 4, 'MFP14-PPU PACKAGED PUMP UNIT\r\n50MM PN16 SIMPLEX  c/w PRV Set Units', '14000000.00', '2020-11-16 07:43:48', '2021-03-01 23:47:13', 3, '14000000.00', 0, '0.00', 0, '14000000.00', '', 'uncompleted'),
(4, 12, 'POV-21-03-001', 6, 'MINOX 1\" ROTARY SPRAY BALL - BSPT, SS316L, MINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, MINOX 1.5\" FERRULE 12.7MM, SS316L, MINOX 0.5\" FERRULE 12.7MM, SS316L, MINOX 4\" FERRULE 15.9MM, SS316L, MINOX 4\" / DN100 FERRULE BLANK, SS316L, MINOX 0.5\" FERRULE GASKET <EPDM>, MINOX 1.5\" FERRULE GASKET <EPDM>, MINOX 4\" FERRULE GASKET <EPDM>,  ect.', '14786640.00', '2021-03-05 03:48:45', '2021-03-05 04:30:15', 14, '13442400.00', 10, '0.00', 20, '13442400.00', '', 'uncompleted'),
(5, 11, 'POV-21-03-002', 7, 'Assembly Header & Frame MFP14-PPU PACKAGED\r\nPUMP UNIT 50MM PN16 SIMPLEX + Wood Full\r\nPacking', '28000000.00', '2021-03-09 00:52:33', '2021-03-09 00:52:33', 3, '28000000.00', 0, '0.00', 0, '28000000.00', '', 'uncompleted'),
(6, 12, 'POV-21-03-003', 9, 'Jasa instalasi - Perbaikan dedleg di jalur PW Supply dari PW Gen', '2031260.00', '2021-03-09 01:17:47', '2021-03-09 21:36:26', 15, '1846600.00', 10, '0.00', 20, '1846600.00', '', 'uncompleted');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `terms` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_requests`
--

INSERT INTO `purchase_requests` (`id`, `code`, `project_id`, `description`, `amount`, `status`, `created_at`, `updated_at`, `user_id`, `quotation_vendor_id`, `sub_amount`, `vat`, `wht`, `discount`, `after_discount`, `terms`) VALUES
(4, 'PR-00004', 4, 'MFP14-PPU PACKAGED PUMP UNIT\r\n50MM PN16 SIMPLEX  c/w PRV Set Units', '14000000.00', 'approved', '2020-11-16 07:38:01', '2020-11-16 07:43:16', 16, 3, '14000000.00', 0, '0.00', 0, '14000000.00', ''),
(5, 'PR-00005', 4, 'Assembly Header & Frame MFP14-PPU PACKAGED PUMP UNIT 80x50MM PN16 TRIPLEX', '17000000.00', 'pending', '2020-11-18 21:23:20', '2020-11-18 21:23:20', 16, 13, '17000000.00', 0, '0.00', 0, '17000000.00', ''),
(6, 'PR-00006', 105, 'Material - Perbaikan dedleg di jalur PW Supply dari PW Gen', '14786640.00', 'approved', '2021-03-05 03:46:17', '2021-03-09 01:09:34', 16, 14, '13442400.00', 10, '0.00', 20, '13442400.00', ''),
(7, 'PR-00007', 49, 'Assembly Header & Frame MFP14-PPU PACKAGED\r\nPUMP UNIT 50MM PN16 SIMPLEX + Wood Full\r\nPacking', '28000000.00', 'approved', '2021-03-09 00:50:34', '2021-03-09 00:51:31', 16, 3, '28000000.00', 0, '0.00', 0, '28000000.00', ''),
(9, 'PR-00008', 48, 'Jasa instalasi - Perbaikan dedleg di jalur PW Supply dari PW Gen', '2031260.00', 'approved', '2021-03-09 01:16:17', '2021-03-09 01:17:25', 16, 15, '1846600.00', 10, '0.00', 20, '1846600.00', ''),
(10, 'PR-00009', 71, 'MINOX 4\" FERRULE 15.9MM, SS316L, MINOX 4\" FERRULE GASKET <EPDM>, MINOX 4\" / DN100 CLAMP RING, SS304, MINOX 4\" X 2\" CON REDUCER, WELD END SS316L, MINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L, MINOX 2\" 90 DEG ELBOW, WELD END, SS304L (R=1.5), ', '5535200.00', 'pending', '2021-03-09 03:29:18', '2021-03-09 03:32:53', 16, 16, '5032000.00', 10, '0.00', 20, '5032000.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_customers`
--

CREATE TABLE `quotation_customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `amount` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','submitted','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `submitted_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `quotation_customers`
--

INSERT INTO `quotation_customers` (`id`, `code`, `customer_id`, `sales_id`, `amount`, `description`, `status`, `submitted_date`, `created_at`, `updated_at`, `file`) VALUES
(3, 'QC-20-08-001', 11, 17, '1000000', '2pcs  Name Plate For Separator 1808', 'submitted', '2020-08-12', '2020-08-11 23:46:11', '2020-09-15 23:47:07', '1597214771_20072020150820 - SBT 20.033.pdf'),
(4, 'QC-20-08-002', 12, 17, '20000000', '1 lot Chain Munson RS80-3R Chain', 'submitted', '2020-09-16', '2020-08-12 01:42:00', '2020-09-15 23:51:36', '1597221720_HWR_PO 394 CHAIN MUNSON 20 - SBT 20.030.pdf'),
(5, 'QC-20-08-003', 13, 17, '16170000', '1 Lot Labour Cost For Instal SS Ducting', 'submitted', '2020-08-12', '2020-08-12 02:07:56', '2020-09-15 23:48:28', '1597223276_img-408110035-0001 - SBT 20.019.pdf'),
(6, 'QC-20-08-004', 13, 17, '30030000', '1 Lot Supply Of Material For SS Ducting', 'submitted', '2020-08-12', '2020-08-12 02:20:01', '2020-09-15 23:49:14', '1597224001_img-408110035-0001 - SBT 20.019.pdf'),
(7, 'QC-20-08-005', 11, 17, '1650000', '3 Pcs Name Plate Separator 1808', 'submitted', '2020-08-12', '2020-08-12 02:25:39', '2020-09-15 23:50:23', '1597224339_nameplate - SBT 20.009.pdf'),
(9, 'QC-20-08-007', 14, 17, '49500000', '1 Unit WT-WS-FTN-Add Work Poseidon Gap', 'submitted', '2020-08-12', '2020-08-12 03:23:49', '2020-09-15 23:50:53', '1597227829_PO 4503015540 - Sedulang Bintang Teknik - SBT20.013.pdf'),
(10, 'QC-20-08-008', 14, 17, '100000000', '1 Unit WT-PU-UV-UV Instalation', 'submitted', '2020-08-12', '2020-08-12 03:32:54', '2020-09-15 23:52:27', '1597228374_PO 4502991190 - Sedulang Bintang Teknik - SBT 20.011.pdf'),
(11, 'QC-20-08-009', 14, 17, '1150000000', '1 UN WT-WD-WLP-UPGRADE POSEIDON GAP', 'submitted', '2020-08-12', '2020-08-12 03:55:15', '2020-09-15 23:53:55', '1597229715_PO 4503028158 - Sedulang Bintang - SBT 20.015.pdf'),
(12, 'QC-20-08-010', 14, 17, '30000000', '1 UN WT-WD-WLP-UV Lamp WT-B @ 15.000.000\r\n1 UN WT-WD-WLP-UV Lamp WT-D @ 15.000.000\r\n\r\n', 'submitted', '2020-08-12', '2020-08-12 04:13:30', '2020-09-15 23:49:54', '1597230810_PO 4503030208 - Sedulang Bintang Teknik  - SBT20.018.pdf'),
(13, 'QC-20-08-011', 14, 17, '12000000', '1 UN WT-WD-WLP-INTERLOCK UV LAMP', 'submitted', '2020-08-12', '2020-08-12 04:26:32', '2020-08-12 04:26:58', '1597231592_PO 4503030239 - Sedulang Bintang Teknik - SBT20.017.pdf'),
(14, 'QC-20-08-012', 14, 17, '15000000', '1 Unit WT-WD-WLP-INTERLOCK UV ', 'submitted', '2020-08-19', '2020-08-18 20:34:36', '2020-09-15 23:45:33', '1597808076_PO 4503076175 - Sedulang - SBT 20.025.pdf'),
(15, 'QC-20-08-013', 14, 17, '258000000', '1 UN WT-WS-CIP-MATERIAL COST @ 155.397.250\r\n1 UN WT-WS-CIP-SERVICE COST  @ 102.602.750\r\n', 'submitted', '2020-08-19', '2020-08-18 21:10:30', '2020-08-18 21:10:35', '1597810230_PO 4503081327 - Sedulang Bintang Teknik - SBT 20.026.pdf'),
(16, 'QC-20-08-014', 14, 17, '82000000', '1 UN WT-WD-WLP-INTERLOCK WT 1 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 2 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 3 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 4 @16.000.000\r\n1 UN WT-WD-WLP-INTERLOCK WT 5 @18.000.000', 'submitted', '2020-08-19', '2020-08-19 03:13:05', '2020-08-19 03:13:13', '1597831985_PO 4503144775 - Sedulang Bintang Teknik - SBT 20.029.pdf'),
(17, 'QC-20-08-015', 15, 17, '2970000', '1 Unit check PLC program at CIP & Mixing Syste  @2.970.000\r\n', 'submitted', '2020-08-19', '2020-08-19 03:52:04', '2020-08-19 03:52:15', '1597834324_PO MBF 2001 0427 (SEDULANG BINTANG TEKNIK) - SBT 20.024.pdf'),
(18, 'QC-20-08-016', 15, 17, '88000000', '1 Unit MAIN MIXING TANK @ 40,517,085\r\n1 Unit UTILITY LINE FOR NEW JACKETING AT M @ 10,594,454\r\n1 Unit INSTRUMENTATION @ 7,267,537\r\n1 Lot INSTALLATION @ 14,133,158\r\n1 Lot MOB DEMOB @ 7,487,766\r\n', 'submitted', '2020-08-19', '2020-08-19 04:54:08', '2020-08-19 04:54:21', '1597838048_PO MBF 2002 0170  (SEDULANG BINTANG TEKNIK) - SBT 20.008.pdf'),
(19, 'QC-20-08-017', 15, 17, '2805000', '1 Unit printer cartridge recorder KRN100 @ 3,000,000\r\nDisc 15% + Ppn 10%\r\n', 'submitted', '2020-08-19', '2020-08-19 05:10:56', '2020-08-19 05:11:04', '1597839056_PO MBF 2002 0710 (SEDULANG BINTANG TEKNIK) - SBT 20.010.pdf'),
(20, 'QC-20-09-001', 15, 17, '44000000', '1 Unit batch reporting system for CIP & mixing fa @ 40.000.000\r\nppn 10% ', 'submitted', '2020-09-02', '2020-09-01 19:53:22', '2020-09-01 19:53:28', '1599015202_PO MBF 2003 0662 (SEDULANG BINTANG TEKNIK) - SBT 20.16.pdf'),
(21, 'QC-20-09-002', 15, 17, '27500000', '1 Unit burkert flow controller type 8025 panel mo @ 14.000.000\r\n1 Unit burkert high temp Peddle Type S030 @ 11.000.000\r\n\r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-01 20:00:27', '2020-09-01 20:00:37', '1599015627_PO MBF 2007 0072 (SEDULANG BINTANG TEKNIK) - SBT20.031.pdf'),
(22, 'QC-20-09-003', 15, 17, '9900000', '1 Unit Minox MX-SV platinum cured silicone braid reinforced hose id:25.4 mm od: 35.81 mm L=2,000mm @ 10.000.000\r\n\r\n\r\nUser Mas Sulis\r\nPRO/PBJ/2006/0131\r\nPermintaan Selang CIP SIP\r\nDisc 10% + PPN 10%\r\n\r\n\r\n\r\n\r\n', 'submitted', '2020-09-02', '2020-09-01 20:07:41', '2020-09-01 20:09:13', '1599016061_PO MBF 2007 04040  (SEDULANG BINTANG TEKNIK) - SBT20.038.pdf'),
(23, 'QC-20-09-004', 15, 17, '3073765.2', '2 Jerigen Cleaning Agent Pro A++ @ 775.500 \r\n2 Jerigen Cleaning Agent Pro B++ @ 621.666\r\n\r\nUser : Imas (Prod Liquid)\r\n\r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-01 20:22:53', '2020-09-01 20:23:03', '1599016973_PO mbf.2006.0099 (sedulang) - SBT 20.028.pdf'),
(24, 'QC-20-09-005', 15, 17, '853050', '1 Jerigen  Cleaning Agent Pro A++ @ 775.500\r\n\r\nUser : imas (Prod Liquid)\r\n\r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-01 20:27:48', '2020-09-01 20:29:51', '1599017268_PO Mbf.2007.0247 (sedulang bintang) - SBT 20.034.pdf'),
(25, 'QC-20-09-006', 15, 17, '726000', '1 Jerigen chemical micro kill (prodes) @ 660.000\r\n\r\nchemical micro kill (prodes) \r\n\r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-01 20:39:49', '2020-09-01 20:39:56', '1599017989_PO mbf.2007.0255 (Sedulang bintang) - SBT 20.035.pdf'),
(26, 'QC-20-09-007', 11, 17, '27000000', '1 Unit MFP14-PPU SIMPLEX 50MM c/w PRV PACKAGED PUMP UNIT @ 27.000.000\r\n\r\nUser : Riris Dawati Nababan', 'submitted', '2020-09-02', '2020-09-01 20:54:06', '2020-09-01 20:54:18', '1599018846_PO no. 20350004 - MFP14 50MM PRV - SEDULANG - SBT 20.001.pdf'),
(27, 'QC-20-09-008', 11, 17, '600000', '2 pcs PN40 SLIP ON FLANGES 80MM @ 300.000\r\n\r\nUser : Eka Asmaralda Stya Nazar \r\n', 'submitted', '2020-09-02', '2020-09-01 21:00:07', '2020-09-01 21:00:12', '1599019207_PO no. 20350011 - Flange - SBT 20.003.pdf'),
(28, 'QC-20-09-009', 11, 17, '2500000', '1 Pcs ELBOW CONNECTION DN25XDN25 @ 2.500.000\r\n\r\nUser: Eka Asmaralda Stya Nazar \r\n', 'submitted', '2020-09-02', '2020-09-01 21:05:14', '2020-09-01 21:05:20', '1599019514_PO no. 20350013 - Elbow - SBT 20.004.pdf'),
(29, 'QC-20-09-010', 11, 17, '46800000', '1 Unit MFP14 80MM PACKAGED TRIPLEX PACKAGE 80X50MM @ 46.800.000\r\n\r\nUser :\r\nRiris Dawati Nababan \r\n\r\n', 'submitted', '2020-09-02', '2020-09-01 22:03:51', '2020-09-01 22:04:23', '1599023031_PO no. 20350017 - Sedulang MFP14 80MM Triplex - SBT 20.005.pdf'),
(30, 'QC-20-09-011', 11, 17, '3500000', '1 Pcs ELBOW CONNECTION DN40XDN40 @3.500.000\r\n\r\n', 'submitted', '2020-09-02', '2020-09-01 22:17:31', '2020-09-01 22:17:37', '1599023851_PO no. 20350022 - Elbow - SBT 20.007.pdf'),
(31, 'QC-20-09-012', 16, 17, '17500000', '1 Set Jasa Bongkar Pasang Boiler (NDE Work For Hokken Boiler 8 ton) @ 10.000.000\r\n1 Set Material ( 2 Lbr Packing Gasket Klingerit C200 Tebal 3-5mm) @ 7.500.000\r\n\r\n', 'submitted', '2020-09-02', '2020-09-01 22:37:03', '2020-09-01 22:37:09', '1599025023_PO_81_151439_Sedulang - SBT 20.023.pdf'),
(32, 'QC-20-09-013', 16, 17, '11500000', '1 Set SLINK  D12MMXP15M MILD STEEL (90m) @ 4.500.000\r\n1 Set Jasa Penggantian Sling Chimney (Man Power, Accomodation, Tools & Supporting  @7.000.000\r\n\r\n', 'submitted', '2020-09-02', '2020-09-01 22:43:53', '2020-09-01 22:43:59', '1599025433_PO_81_153670_0_US - SBT20.037.pdf'),
(33, 'QC-20-09-014', 16, 17, '72000000', '1 set As Mesin Upgrading Tangki Cst Level Transmitter\r\n\r\n\r\n\r\nRefer To Quotation: 19.IX.009-Rev.4 (17 Jan 2020)', 'submitted', '2020-09-02', '2020-09-01 22:51:40', '2020-09-01 22:54:09', '1599025900_PO-145805-Sedulang - SBT 20.002.pdf'),
(34, 'QC-20-09-015', 16, 17, '7800000', '12 Pcs Gasket EPDM For PHE M6-MFG @ 650.000\r\n\r\n\r\nRefer To Quotation: 20.II.008 - Rev.0 - 13 Feb 2020', 'submitted', '2020-09-02', '2020-09-01 22:59:19', '2020-09-01 22:59:27', '1599026359_PO-149808-Sedulang - SBT 20.014.pdf'),
(35, 'QC-20-09-016', 16, 17, '3500000', '1 Set Jasa Perbaikan Tangki KAP 15.000L2 @ 3.500.000\r\n\r\nUser:\r\nAmalia Utari, Ms', 'submitted', '2020-09-02', '2020-09-01 23:05:49', '2020-09-01 23:05:54', '1599026749_PO-153069-Sedulang - SBT 20.032.pdf'),
(36, 'QC-20-09-017', 17, 17, '14850000', '1 Lot Material Orbital Welding (POU Connecting) @ 5.166.667\r\n1 Lot Instalasi (Mechanical Installation) @ 1.500.000\r\n1 Lot Material Pendukung @ 8.333.333\r\nPro : Project Syrup\r\n\r\n', 'submitted', '2020-09-02', '2020-09-01 23:38:22', '2020-09-01 23:38:28', NULL),
(37, 'QC-20-09-018', 18, 17, '176000000', '1 Lot New CIP. Filling Line (Material & Installation) @ 120.983.743\r\n1 Lot Swing Bend Pane (Material & Installation) @ 49.443.200\r\n1 Lot U Bend Panel 2 set ( Material & Installation) @ 8.778.994\r\n1 Lot Other (Material & Installation) @ 20.794.063\r\n\r\nDisc 20% \r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-02 01:00:54', '2020-09-02 01:01:15', '1599033654_PT_Sedulang Bintang Teknik - SBT 20.020.pdf'),
(38, 'QC-20-09-019', 19, 17, '12100000', '1 Lot Labour Cost For Mechanical Arjunior Desk and Table @ 12.712.329\r\n\r\nDisc : Rp. 1.712.329\r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-02 01:36:26', '2020-09-02 01:36:30', '1599035786_Sedulang - SBT 20.021-022.pdf'),
(39, 'QC-20-09-020', 19, 17, '22000000', '1 Lot Supply Of Material For Material Work Arjunior Desk and Table @ 20.020.548\r\n\r\nDisc. 20.548\r\nPPN 10%\r\n', 'submitted', '2020-09-02', '2020-09-02 01:46:05', '2020-09-02 01:46:09', '1599036365_Sedulang - SBT 20.021-022.pdf'),
(40, 'QC-20-09-021', 19, 17, '5500000', '1 Lot Labour Cost For Meechanical Work Install SS Drain Pipe @ 5.000.000\r\n\r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-02 01:51:23', '2020-09-02 01:52:55', '1599036683_Sedulang - SBT 20.021-022.pdf'),
(41, 'QC-20-09-022', 19, 17, '7700000', '1 Lot Supply Material for Mechanical Work SS Drain Pipe @ 7.000.000\r\n\r\nPPN 10%', 'submitted', '2020-09-02', '2020-09-02 01:56:21', '2020-09-02 01:56:26', '1599036981_Sedulang - SBT 20.021-022.pdf'),
(42, 'QC-20-09-023', 14, 17, '28000000', '1 Unit WT-WS-PSI-Percabangan Vent Filter FT S @ 28.000.000', 'submitted', '2020-09-02', '2020-09-02 02:00:40', '2020-09-02 02:00:45', '1599037240_ZINV 4503166053 - SBT20.036.pdf'),
(43, 'QC-20-09-024', 11, 17, '4114722', '8 Pcs PN16 Slip On Flanges 25MM @162.588 \r\n16Pcs Bolt & Nut M16 X 70MM @ 54.717\r\n4 Pcs SWG Gasket SS304 For PN16 @93.801\r\n4 Pcs ANSI 250 Slip On Flanges 25MM @234.501\r\n8 Pcs Bolt & Nut M16 x 70MM @54.717\r\n2 Pcs SWG Gasket ss304 For ANSI250 25MM @93.801\r\n', 'submitted', '2020-09-12', '2020-09-12 00:52:51', '2020-09-12 00:52:57', '1599897171_29012020141455 - SBT 20.006.pdf'),
(44, 'QC-20-10-001', 16, 17, '12500000', 'Modification CA & N2 line', 'submitted', '2020-10-01', '2020-09-30 21:06:38', '2020-09-30 21:06:45', NULL),
(45, 'QC-20-10-002', 11, 17, '17800574', '6 Pcs PN40 SLIP ON FLANGES 250MM @2.284.286\r\n2 Pcs PN40 SLIP ON FLANGES 200MM @900.000\r\n2 Pcs PN40 SLIP ON FLANGES 150MM @751.429\r\n\r\n\r\n', 'submitted', '2020-10-06', '2020-10-06 02:47:04', '2020-10-06 02:47:11', '1601977624_19350173 flanged.pdf'),
(46, 'QC-20-10-003', 11, 17, '430000', '2 Pcs Ferrule, Clamp, & Sel Ring Set  @ 215.000\r\nStainless Steel For 40 mm', 'submitted', '2020-10-06', '2020-10-06 02:55:19', '2020-10-06 02:58:53', '1601978119_21062019090322.pdf'),
(47, 'QC-20-10-004', 20, 17, '104996417', 'Additional II Work for Tank Leveling Works \r\nMaterial \r\nInstallation', 'submitted', '2020-10-06', '2020-10-06 04:27:49', '2020-10-06 04:29:23', '1601983669_PO  No.  001-ADD 2-PO-RTI-IX-2019.pdf'),
(48, 'QC-20-10-005', 11, 17, '1870000', '1 Set Flange Raise Face (RF) PN 16 @ 1.700.000\r\n- Material SS304L\r\n\r\n+Pph 23 170.000', 'submitted', '2020-10-06', '2020-10-06 04:38:08', '2020-10-06 04:39:42', '1601984288_PO 056.pdf'),
(49, 'QC-20-10-006', 12, 17, '26235000', '1 Set Chain Munson Mixer & Connecting Chain 80-3, L 480 MM Ex Japan @ 26.500.000', 'submitted', '2020-10-06', '2020-10-06 04:45:35', '2020-10-06 04:46:43', '1601984735_PO 296 CHAIN MIXER001.pdf'),
(50, 'QC-20-10-007', 11, 17, '7666626', '- 2 Pcs ANSI 250 Slip On Flanges 80 MM @ 211.051\r\n- 2 Pcs PN40 Slip On FLanges 80 MM @ 203.204\r\n- 2 Pcs ANSI 250 slip On Flanges 20 MM @ 62.534\r\n- 2 Pcs PN16 Slip On Flanges 80MM @164.151\r\n- 4 Pcs PN25 Slip On Flanges 100 MM @ 351.752\r\n- 8 Pcs PN25 Slip On Flanges 15 MM @ 75.040\r\n- 6 Pcs PN25 Slip On Flanges 40 MM @ 171.968\r\n- 12 Pcs PN25 Slip On Flanges 50 MM @ 211.051 \r\n- 2 Pcs PN25 Slip On Flanges 80 MM @ 297.035\r\n- 2 Pcs PN40  Slip On Flanges 40 MM @109.434', 'submitted', '2020-10-06', '2020-10-06 05:03:19', '2020-10-06 05:03:25', '1601985799_PO 19350272.pdf'),
(51, 'QC-20-10-008', 14, 17, '400000000', '1 Unit WT-PU-WTF-POSEIDON UPGRADE ', 'submitted', '2020-10-19', '2020-10-18 21:16:11', '2020-10-18 21:16:24', '1603080971_PO 4502781195 - Sedulang Bintang.pdf'),
(52, 'QC-20-10-009', 14, 17, '140000000', '1 AU WT-PU-UV-PHYSICAL BREAK', 'submitted', '2020-10-19', '2020-10-18 21:44:08', '2020-10-18 21:44:17', '1603082648_PO 4502781246 - Sedulang Bintang.pdf'),
(53, 'QC-20-10-010', 14, 17, '88000000', '1 UN WT-PU-WTF-POSEIDON UPGRADE', 'submitted', '2020-10-19', '2020-10-18 22:24:52', '2020-10-18 22:25:11', '1603085092_PO 4502854028 - Sedulang Bintang.pdf'),
(54, 'QC-20-10-011', 14, 17, '48000000', '1 un WT-PU-WTF-MATERIAL POSEIDON UPG @ 27.000.000\r\n1 au WT-PU-WTF-INSTALATION POSEIDON U @ 21.000.000', 'submitted', '2020-10-19', '2020-10-18 23:03:47', '2020-10-18 23:03:54', '1603087427_PO 4502854176 - Sedulang Bintang.pdf'),
(55, 'QC-20-10-012', 14, 17, '160000000', '- 1 AU WT-WS-FTN-MAT PARTS @ 78.196.230\r\n- 1 AU WT-WS-FTN-INSTALATION COST @ 81.803.770\r\n', 'submitted', '2020-10-19', '2020-10-18 23:34:20', '2020-10-18 23:34:32', '1603089260_PO 4502884716 - Sedulang Bintang Teknik.pdf'),
(57, 'QC-20-10-013', 15, 17, '143000000', '- 1 Unit EDI module MK3 Mini HT Brand SUEZ (GE E-C ) @ 116.000.000\r\n- 1 Unit  DC Power Canpure @ 14.000.000', 'submitted', '2020-10-19', '2020-10-19 00:25:31', '2020-10-19 00:26:56', '1603092331_PO MBF 1905 0510 (SEDULANG BINTANG TEKNIK).pdf'),
(58, 'QC-20-10-014', 15, 17, '8882498.9', '- 1 Pcs VALVE BUTTERFLY DN25 PNEUMATIC ACTUAT @ 4.284.702\r\n- 1 Lot PIPE, FITTINGS & SUPPORT SANITARY ISO20 @ 2.587.473\r\n- 1 Lot TUBING PUN 6 MM INSTALLASI @ 391.511\r\n- 1 Lot MECHANICAL INSTALLATION @ 1.437.630\r\n- 1 Lot ACCOMODATION @ 798.683', 'submitted', '2020-10-19', '2020-10-19 00:36:26', '2020-10-19 00:36:33', '1603092986_PO MBF 1906 0236 (SEDULANG BINTANG TEKNIK).pdf'),
(59, 'QC-20-10-015', 15, 17, '6435000', '1 Pcs  ELEMENT P-SRF C 05/30  @ 6.500.000 Disc 10% =  5.850.000\r\n+ PPN 10% ', 'submitted', '2020-10-19', '2020-10-19 00:48:22', '2020-10-19 00:48:27', '1603093702_PO MBF 1906 0260 (SEDULANG BINTANG TEKNIK).pdf'),
(60, 'QC-20-10-016', 15, 17, '9900001.1', '- 4 Pcs VALVE BUTTERFLY DN25 MANUAL @ 1.275.398,5\r\n- 1 Lot  PIPE, FITTINGS & SUPPORT SANITARY ISO20 (Installasi)   @ 1.400.438\r\n- 1 Lot MECHANICAL INSTALLATION @ 2.700.844\r\n- 1 Lot ACCOMODATION @v 797.124\r\n\r\nDisc 10% + PPN 10%\r\n', 'submitted', '2020-10-19', '2020-10-19 00:58:48', '2020-10-19 00:58:55', '1603094328_PO MBF 1906 0263 (SEDULANG BINTANG TEKNIK).pdf'),
(61, 'QC-20-10-017', 15, 17, '5445000', '1 Pc DN40XDN20 : P/N: 9625 10M1-1/N @ 5.500.000 - Disc 10% = 4.950.000\r\n(PPOU AUTOCLAVE NBL BUILDING)\r\n+ PPN 10% ', 'submitted', '2020-10-19', '2020-10-19 01:07:01', '2020-10-19 01:07:06', '1603094821_PO MBF 1906 0297 (SEDULANG BINTANG TEKNIK).pdf'),
(62, 'QC-20-10-018', 15, 17, '16500000', '- 2 Pail Chemical Micro Kill (Prodes) @ 660.000\r\n- 12 Pail  Chemical High pH (ProCIP B++) @ 621.666,67\r\n-  8 Pail Chemical Low pH (ProCIP A++) @ 777.500\r\n\r\n+ PPN 10%', 'submitted', '2020-10-19', '2020-10-19 01:37:20', '2020-10-19 01:37:26', '1603096640_PO MBF 1906 0343 (SEDULANG BINTANG TEKNIK).pdf'),
(63, 'QC-20-10-019', 15, 17, '13513500', '-1 Lot CHEMICAL SUPPLY FOR LOW pH, HIGH pH ( MICRO KILL @ 1 PAIL) @ 3.650.000\r\n- 1 Lot SANITATION & CIP SUPPORT @ 10.000.000\r\n\r\nDisc 10%\r\nDan PPN 10%', 'submitted', '2020-10-19', '2020-10-19 01:55:50', '2020-10-19 01:56:04', '1603097750_PO MBF 1906 0344 (SEDULANG BINTANG TEKNIK).pdf'),
(64, 'QC-20-10-020', 15, 17, '5986750', '7 Pail Chemical Pro A++  @ 777.500\r\n\r\n+PPN 10%', 'submitted', '2020-10-19', '2020-10-19 01:59:57', '2020-10-19 02:00:06', '1603097997_PO MBF 1906 0438 (SEDULANG BINTANG TEKNIK).pdf'),
(65, 'QC-20-10-021', 15, 17, '1452000', '2 Unit chemical micro kill (prodes) @ 660.000\r\n+PPN 10%', 'submitted', '2020-10-19', '2020-10-19 02:04:12', '2020-10-19 02:04:22', '1603098252_PO MBF 1907 0216 (SEDULANG BINTANG TEKNIK).pdf'),
(66, 'QC-20-10-022', 15, 17, '4455000', '1 Unit Burkert Flow Hall Sensor type SE 30 @ 4.500.000 -disc 10% = 4.050.000\r\n\r\n+PPN 10%', 'submitted', '2020-10-19', '2020-10-19 02:28:04', '2020-10-19 02:28:10', '1603099684_PO MBF 1907 0225 (SEDULANG BINTANG TEKNIK).pdf'),
(67, 'QC-20-10-023', 15, 17, '34650000', '3 Unit RO Membrane merk DOW FILMTEC HSRO 404 @ 10.500.000\r\n+ PPN 10%\r\n', 'submitted', '2020-10-19', '2020-10-19 02:56:02', '2020-10-19 02:56:06', '1603101362_PO MBF 1907 0319  (SEDULANG).pdf'),
(68, 'QC-20-10-024', 15, 17, '11550000', '1 Unit RO Membrane merk DOW FILMTEC HSRO 404 @10.500.000\r\n\r\n+ PPN 10%', 'submitted', '2020-10-19', '2020-10-19 03:02:51', '2020-10-19 03:02:55', '1603101771_PO MBF 1907 0326  (SEDULANG).pdf'),
(69, 'QC-20-10-025', 15, 17, '8910000', '1 Unit Vent filter 10\" element SRV V 10/3 P7, Donald @ 9.000.000 disc 10% = 8.100.000\r\n+ PPN 10%', 'submitted', '2020-10-19', '2020-10-19 03:08:54', '2020-10-19 03:08:58', '1603102134_PO MBF 1907 0485  (SEDULANG).pdf'),
(71, 'QC-20-10-026', 15, 17, '17958416.3', '-  chemical pro a++\r\n-  chemical pro b++\r\n\r\n+10 PPN', 'submitted', '2020-10-26', '2020-10-25 21:14:59', '2020-10-25 21:15:03', '1603685699_PO MBF 1907 0540 (SEDULANG BINTANG TEKNIK).pdf'),
(72, 'QC-20-10-027', 15, 17, '4082619.2', '- 1 Unit Modifikasi jalur return CIP : Sampling Valve  @ 2.403.572\r\n- 1 Unit Pipe, fitting & support @ 977.429\r\n-  1 Unit Installation cost\r\n\r\n+ PPN 10%', 'submitted', '2020-10-26', '2020-10-25 21:26:45', '2020-10-25 21:26:51', '1603686405_PO MBF 1909 0043  (SEDULANG).pdf'),
(73, 'QC-20-10-028', 15, 17, '19304998.9', '- 1 Unit S UV CONNECTOR PW LOOP 3rd & 4rd FLOOR M @ 8.055.085\r\n- 1 Lot  A INSTALLASI COST UV CONNECTOR PW LOOP @ 6.129.731\r\n- 1 Lot INSTALLASI REPAIR DEALEG AT TT PW TANK @ 704.577\r\n- 1 Unit REPAIR DIALEG AT PW GEN @ 614.994\r\n- 1 Lot INSTALLASI REPAIR DEALEG AT PW GEN @2.113.730\r\n- 1 Lot ACCOMODATION  @ 1,129,129\r\n- 1 Lot PASSIVATING @ 752,753\r\n\r\nDisc 10% = 17,549,999.00\r\n + PPN 10% ', 'submitted', '2020-10-26', '2020-10-25 21:43:34', '2020-10-25 21:43:40', '1603687414_PO MBF 1909 0082  (SEDULANG).pdf'),
(74, 'QC-20-10-029', 15, 17, '27507857.3', '- 1 Lot  TOC Meter support @ 1,257,143\r\n- 1  Unit Electrical panel Recorder KRN100-600-4 @ 25,000,000 \r\n- 1 Unit Hardware panel @ 357,143\r\n- 1 Lot Cabling, tubing & Conduit support @ 142,857\r\n- 1 Lot Instalation cost TOC relocated  @ 1,028,571\r\n\r\nDisc 10% = 25,007,143.00\r\n+ PPN !0%', 'submitted', '2020-10-26', '2020-10-25 22:03:46', '2020-10-25 22:03:53', '1603688626_PO MBF 1909 0085  (SEDULANG).pdf'),
(75, 'QC-20-10-030', 15, 17, '15840000', '1 Unit burkert high temp. fitting type s030 temp range 0-125 C @ 16,000,000\r\n Disc 10% =14,400,000.00\r\n\r\n+PPN 10%', 'submitted', '2020-10-26', '2020-10-25 22:13:53', '2020-10-25 22:13:59', '1603689233_PO MBF 1909 0273  (SEDULANG).pdf'),
(76, 'QC-20-10-031', 15, 17, '18810000', '- 1 Unit burkert se30 for high temp @ 4,500,000\r\n- 1 Unit burkert flow controller type 8025 panel mounti @ 14,500,000\r\n\r\nDisc 10% = 17,100,000.00\r\n\r\n+PPN  10%', 'submitted', '2020-10-26', '2020-10-25 22:24:53', '2020-10-25 22:24:59', '1603689893_PO MBF 1909 0274  (SEDULANG).pdf'),
(77, 'QC-20-10-032', 15, 17, '313500000', '- 3 Unit S Material Short Cut PW Loop To POU  & Spool Pieces\r\n @ 2,242,350 \r\n- 3 Jasa Installasi Short Cut PW loop to POU  & Spool Pieces @ 1,207,170\r\n- 3 Unit PW Loop to Qc @ 23,998,343.11\r\n- 3 JASA EXP-JAMA Instalasi PW Loo @ 12,942,300\r\n- 3 Unit Uv Lamp Relocated Form PW Return Line  To Pw Supply @ 2,423,350\r\n- 3 Jasa Uv Lamp Relocated Form PW Return Line  To Pw Supply @ 1,652,400\r\n- 3 Lot Other Installation Cost For Qc RND @ 8,459,306.2\r\n- 2 Unit Material Short Cut Pw loop to POU & Spool Pieces @ 2,242,350\r\n- 2 Jasa Installasi Short Cut Pw Loop to POU & Spool Pieces @ 1,207,170 \r\n- 2 Unit  Pw Loop To RND @ 30,964,944.83 \r\n- 2 Jasa Instalalasi Pw Loop To RND @ 16,162,650\r\n- 2 Unit Uv Lamp Relocated Form Pw Return Line  to PW Supply @ 2,423,350\r\n- 2 Jasa Uv Lamp Relocated Form Pw Return Line to PW Supply @ 1,652,400\r\n- 2 Lot Other Installation Cost For RND @ 8,459,306.2\r\n\r\n+ PPN 10%\r\n\r\n', 'submitted', '2020-10-26', '2020-10-25 23:03:46', '2020-10-25 23:03:56', '1603692226_PO MBF 1910 0111  (SEDULANG)1.pdf'),
(78, 'QC-20-10-033', 15, 17, '9900000', '1 Lot re-dial up agitator mixing gargle 2500 L @ 9.000.000\r\n + PPN 10%', 'submitted', '2020-10-26', '2020-10-26 02:07:57', '2020-10-26 02:08:02', '1603703277_PO MBF 1911 0667 (SEDULANG BINTANG TEKNIK).pdf'),
(79, 'QC-20-10-034', 15, 17, '33000000', '- 1 Pcs PIPE ASME BPE SF 1 (ADD MATERIAL) FO @ 3,000,000\r\n- 1 Pcs PIPE ASME BPE SF 1 (ADD MATERIAL) FO @ 3,000,000\r\n- 1 Jasa INSTAL PIPE ASME BPE SF 1 (LAYOUT RE @ 7.000.000\r\n- 1 Jasa INSTAL PIPE ASME BPE SF 1 (LAYOUT RE @ 7.000.000\r\n- 1 Jasa EXS INSTAL MATERIAL ELBOW 90o ASME  @ 3.000.000\r\n- 1 Jasa EXS INSTAL MATERIAL ELBOW 90o ASME @ 3.000.000\r\n- 1 Pcs MATERIAL ELBOW 90o ASME BPE SF1 FO  @ 550,000\r\n- 1 Pcs MATERIAL ELBOW 90o ASME BPE SF1 FO @ 550.000\r\n- 1 Pcs INSTAL MATERIAL ELBOW 90o ASME BPE  @ 1.000.000\r\n- 1 Pcs INSTAL MATERIAL ELBOW 90o ASME BPE @ 1.000.000\r\n- 1 Jasa EXT INSTAL DIAGPHRAM VALVE FOR QC @ 200.000\r\n- 1  Jasa EXT INSTAL DIAGPHRAM VALVE FOR RND @ 200.000\r\n- 1 Pcs PIPE HOLDER FOR QC @ 100.000\r\n- 1 Pcs PIPE HOLDER FOR RND @ 100.000\r\n- 1 Pcs INSTAL PIPE HOLDER FOR QC @ 150.000\r\n- 1 Pcs INSTAL PIPE HOLDER FOR RND  @ 150.000\r\n\r\n+ PPN 10%', 'submitted', '2020-10-26', '2020-10-26 02:35:52', '2020-10-26 02:35:59', '1603704952_PO MBF 1912 0232 (SEDULANG BINTANG TEKNIK)2.pdf'),
(80, 'QC-20-10-035', 15, 17, '2265083.7', '- 1 Pail Chemical Low pH (ProCIP A++) @ 777.500\r\n- 1 Pail Chemical High pH (ProCIP B++) @ 621.666,67\r\n- 1 Pail  Chemical micro kill (prodes) @ 660.000\r\n\r\n+ PPN 10%', 'submitted', '2020-10-26', '2020-10-26 02:56:07', '2020-10-26 02:56:11', '1603706167_po mbf.1907.0508 (sedulang).pdf'),
(81, 'QC-20-10-036', 15, 17, '4788665.2', '- 4 Jerigen Cleaning Agent PRO A++ @ 777.500\r\n- 2 Jerigen Cleaning Agent PRO B ++ @ 621.666\r\n \r\n+PPN 10 %', 'submitted', '2020-10-26', '2020-10-26 03:02:50', '2020-10-26 03:02:57', '1603706570_po mbf.1912.0648 (sedulang).pdf'),
(82, 'QC-20-10-037', 20, 17, '36516075', 'MEK Measuriing Tank Header\r\n- 1 Unit  Fabrication @ 9,199,578\r\n- 1 Unit Material @ 4,431,124\r\n Assy Drawing No. 2BPO-HD2310-001-R0\r\n\r\nREACTION Tank Header\r\n- 2 Unit  Material @ 5,427,189\r\n- 2 Unit  Fabrication @ 4,355,676\r\n Assy Drawing No. 2BPO-HD2301AB-001-R0\r\n\r\n+ PPN 10%\r\n', 'submitted', '2020-10-26', '2020-10-26 03:15:53', '2020-10-26 03:16:01', '1603707353_PO No. 002-C007-2019 Rev1.pdf'),
(83, 'QC-20-10-038', 11, 17, '44000000', '2 Unit MFP14-PPU PACKAGED PUMP UNIT 40MM PN16 SIMPLEX @ 22.000.000\r\n\r\nExcld PPN 10%\r\n', 'submitted', '2020-10-26', '2020-10-26 03:23:20', '2020-10-26 03:23:24', '1603707800_PO No. 19350097 - MFP14 40MM 2 unit (CENTRINDO) - SEDULANG.pdf'),
(84, 'QC-20-10-039', 11, 17, '6700000', '- 4 Pcs PN16 SLIP ON FLANGES 100MM @ 875.000\r\n- 4 Pcs PN16 SLIP ON FLANGES 80MM  @ 800.000\r\n\r\n', 'submitted', '2020-10-26', '2020-10-26 03:36:58', '2020-10-26 03:37:03', '1603708618_PO No. 19350112 - Flange turflow.pdf'),
(85, 'QC-20-10-040', 11, 17, '5400000', '2 Unit PN40 SLIP ON FLANGES 250MM @ 2.700.000 \r\n', 'submitted', '2020-10-26', '2020-10-26 03:39:52', '2020-10-26 03:39:58', '1603708792_PO No. 19350283 - FLANGE.pdf'),
(86, 'QC-20-10-041', 16, 17, '38000000', '- 1 Unit MATERIAL REPAIR BUSHING BOTTOM BEARING STORAGE TANK 15000L @ 6,580,709\r\n- 1 Unit MATERIAL REPAIR BUSHING BOTTOM BEARING MIXING TANK 15000L @ 7,429,832\r\n- 1 Unit JASA INSTALASI RE-ALIGNMENT AGITATOR STORAGE TANK 15000L @ 7,216,382\r\n- 1 Unit JASA INSTALASI RE-ALIGNMENT AGITATOR STORAGE TANK 15000L @ 7,216,382\r\n- 1 Unit JASA INSTALASI POLESHING AND WOOD STAGING INSIDE TANK @ 4,871,058\r\n- 1 DOCUMENTATION @ 2,179,949\r\n- 1 MOBILISASI @ 2,505,688\r\n\r\n\r\n\r\n\r\n', 'submitted', '2020-10-26', '2020-10-26 04:50:22', '2020-10-26 04:50:29', '1603713022_PO-134786-Sedulang Bintang.pdf'),
(87, 'QC-20-10-042', 16, 17, '1800000', '1 Unit INNER BOTTOM BEARING BUSHING SK4282 (FOR YOBASE RM TANK) @ 1,800,000', 'submitted', '2020-10-26', '2020-10-26 04:54:08', '2020-10-26 04:54:13', '1603713248_PO-142279-Sedulang Bintang.pdf'),
(88, 'QC-20-10-043', 21, 17, '26840000', '- 3 Pcs Kalibrasi Temperature Transmitter Holding Tank @ 1.600.000\r\n- 1 Pcs Kalibrasi Process Presure Switchess Holding Tank @ 1.600.000\r\n- 3 Pcs Kalibrasi Temperature Transmitter Mixing Tank B @ 1.600.000\r\n- 1 Pcs  Kalibrasi Process Presure Switchess Holding Tank B @ 1.600.000\r\n-  3 Pcs Kalibrasi Temperature Transmitter Mixing Tank  C @ 1.600.000\r\n-  1 Pcs Kalibrasi Process Presure Switchess Mixing Tank C @ 1.600.000\r\n- 1 Pcs Kalibrasi Temprerature Transmitter Utility CIP B @ 1.600.000\r\n- 1  Pcs Kalibrasi Temprerature Transmitter Utility CIP C @ 1.600.000\r\n-  Biaya Akomodasi @ 2.000.000\r\n\r\n', 'submitted', '2020-10-26', '2020-10-26 05:15:11', '2020-10-26 05:15:17', '1603714511_PO19065854.pdf'),
(89, 'QC-20-10-044', 20, 17, '48178809', '1 Lot Additional Work for Tank Levelling Works  @\r\n- Material Supply @ 25,968,329\r\n- Site Inatallation @ 17,830,588', 'submitted', '2020-10-27', '2020-10-27 03:26:04', '2020-10-27 03:26:10', '1603794364_Purchase Order No. 001-ADD-PO-RTI-VI-2019.pdf'),
(90, 'QC-20-10-045', 20, 17, '386000963', '1 Lot Tank Levelling (9 Units) Jotun Indonesia includes : @ 350.909.966\r\n-  Material Supply\r\n-  Pre-fabrication\r\n-  Delivery to site\r\n-  Site installation & Test\r\n-  Necessary manpowers, Tools / Equipments & Consumables\r\n-  Transportation,mob-demob, accomodation,Safety\r\n\r\n+PPN 10%', 'submitted', '2020-10-27', '2020-10-27 03:31:58', '2020-10-27 03:32:17', '1603794718_Purchase Order No. 001-PO-RTI-VI-2019.pdf'),
(91, 'QC-20-10-046', 22, 17, '13200000', '1 Lot MECHANICAL DEVICES @ 12.000.000\r\n1day Boroscope in Autan Line, used\r\nOlympus 6mm probe and length 8mtr\r\n +PPN 10%', 'submitted', '2020-10-27', '2020-10-27 03:42:20', '2020-10-27 03:42:25', '1603795340_Purchase order SC Johnson 5201165617.pdf'),
(92, 'QC-20-10-047', 13, 17, '55000000', 'Labour Cost For Cutting Silo Tank\r\n- 1 Lot Plasma Cutting Rent @ 25.000.000\r\n- 1 Lot Marpower @ 22.000.000\r\n- 1 Lot Transportation @ 3.000.000\r\n\r\n \r\n', 'submitted', '2020-10-27', '2020-10-27 04:26:49', '2020-10-27 04:26:54', '1603798009_Sedulang 5002600268-0001.pdf'),
(93, 'QC-20-10-048', 23, 17, '22000000', '-  1 Lot Material untuk New Mixing Tank (Line 2) @ 17.000.000\r\n- 1 Lot Jasa untuk New Mixing Tank (Line 2) @ 3.000.000\r\n\r\n+PPN 10%', 'submitted', '2020-10-27', '2020-10-27 04:48:43', '2020-10-27 04:48:49', '1603799323_SEDULANG BINTANG TEKNIK, PT LAK190060.pdf'),
(94, 'QC-20-10-049', 23, 17, '158400000', '1 Lot Platform Yenchen, Mixing Tank Dan Fitzmill Cakupan Pekerjaan : @ 144.000.000\r\n- Premix Tank platform new design\r\n- Yenchen Turbo mixer platform new design\r\n- Modification Fitzmill platform and move the existing\r\nplatform\r\nQuotation No. : Q-19.V.005-Rev.2\r\n\r\n+PPN10%', 'submitted', '2020-10-27', '2020-10-27 05:12:12', '2020-10-27 05:12:17', '1603800732_SEDULANG BINTANG TEKNIK, PT LCK190027-C.pdf'),
(95, 'QC-20-10-050', 23, 17, '55000000', '- 1 Lot Mesin boiling tank line 5: Leakage Repair & \r\nRe-Insulated at Utility Line Boiling Tank 300L @ 25.000.000\r\n\r\n- 1 Lot Mesin boiling tank line 5: Leakage Repair &\r\nRe-Insulated at Utility Line Boiling Tank 600L @ 25.000.000\r\n\r\n+ppn 10%', 'submitted', '2020-10-27', '2020-10-27 05:17:40', '2020-10-27 05:17:45', '1603801060_SEDULANG BINTANG TEKNIK, PT LTK190400-C.pdf'),
(96, 'QC-20-10-051', 11, 17, '2200000', ' 1 Unit SQT Ext. Elbow (Drawing Attached) @ 2.000.000\r\n- Material SUS316L\r\n\r\n+PPN 10%', 'submitted', '2020-10-27', '2020-10-27 05:22:43', '2020-10-27 05:22:52', '1603801363_SQT PIPE-0001.pdf'),
(97, 'QC-20-10-052', 24, 17, '6544811.9', '- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nJasa Filter di Mixing Tank Aweco @ 1,674,971\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS @ 3,538,448\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS @ 736,410\r\n\r\n+PPN 10%\r\n', 'submitted', '2020-10-27', '2020-10-27 06:27:56', '2020-10-27 06:28:03', '1603805276_XXPO_LOKAL_GI_26252672_1.PDF'),
(98, 'QC-20-10-053', 24, 17, '28004098.1', '- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS \r\nJasa perbaikan PW supply dari PW gen ke PW tank lantai 2  @ 7,846,674\r\n\r\n- 1 Lot  REPAIRS AND MAINTENANCEMACHINERY AND EQUIPMENTS\r\n Electrical Installation @ 2,461,702\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nEngineering  @ 3,371,164\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nCommisioning  @ 2,528,373\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nDocumentation @ 2,528,373\r\n\r\n-1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\n Accomodation  @ 2,179,632\r\n\r\n- 1 Lot  REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS \r\nChemical NaOH @ 871,853\r\n\r\n-1  Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nChemical HNO3  @ 653,889\r\n\r\n- 1 Lot  REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nPassivating Tools  @ 2,179,632.\r\n\r\n- 1 Lot REPAIRS AND MAINTENANCE MACHINERY AND EQUIPMENTS\r\nManpower Passivating @ 836,979.\r\n\r\n+PPN 10%', 'submitted', '2020-10-27', '2020-10-27 08:27:37', '2020-10-27 08:27:47', '1603812457_XXPO_LOKAL_GI_27133168_1.PDF'),
(99, 'QC-20-10-054', 24, 17, '7425000', '1 Ea MATERIAL PROYEK MESIN DAN UTILITY @ 6,750,000.\r\n Service kits viton/ FPM manhole LKDC D450mm ex Alfa Lafal : reff\r\nQ-19.VII.0019 - Rev.0 \r\n\r\n+PPN 10%', 'submitted', '2020-10-27', '2020-10-27 08:32:25', '2020-10-27 08:32:29', '1603812745_XXPO_LOKAL_GI_27788903_1.PDF'),
(100, 'QC-20-10-055', 14, 17, '14000000', '1 Unit FILL-PACK MAINT SE MF-MG-DPS-PHISICAL BREAK GIANT TANK\r\nThis item covers the following services:\r\nFor Physical Break Giant @ 14.000.000', 'submitted', '2020-10-27', '2020-10-27 08:36:50', '2020-10-27 08:37:18', '1603813010_ZGS 4502770985 - PHISICAL BREAK GIANT TANK.pdf'),
(101, 'QC-20-11-001', 15, 17, '8882499', 'Drain CIP Return Pump Betsol', 'submitted', '2020-11-11', '2020-11-11 02:36:56', '2020-11-11 02:37:02', NULL),
(102, 'QC-20-11-002', 24, 17, '5400000', 'SL 316 rotary sprayball 1 inch BSP - minox (incl sertificate material)', 'submitted', '2020-11-12', '2020-11-12 04:41:49', '2020-11-12 04:41:54', NULL),
(103, 'QC-20-11-003', 14, 17, '88000000', 'WT-PU-WTF-POSEIDON UPGRADE', 'submitted', '2020-11-16', '2020-11-16 04:57:42', '2020-11-16 04:57:47', NULL),
(104, 'QC-20-11-004', 11, 17, '5295714', 'Flange Slip On Raise Face (RF)\r\n- Material MS', 'submitted', '2020-11-16', '2020-11-16 05:13:47', '2020-11-16 05:13:51', NULL),
(105, 'QC-20-11-005', 11, 17, '770000', 'Flange Slip On Raise Face (RF)\r\n- Material MS', 'submitted', '2020-11-16', '2020-11-16 05:20:11', '2020-11-16 05:20:15', NULL),
(106, 'QC-20-11-006', 11, 17, '905142', 'PN16 SLIP ON FLANGES 25MM\r\nSET C/W BOLT&NUT', 'submitted', '2020-11-16', '2020-11-16 05:24:06', '2020-11-16 05:24:11', NULL),
(107, 'QC-20-11-007', 23, 17, '60500000', 'Mesin Turbomixer Binder Upgrade Agitator', 'submitted', '2020-11-16', '2020-11-16 06:34:09', '2020-11-16 06:34:14', NULL),
(108, 'QC-20-11-008', 24, 17, '26455189', 'Material - Change Strainer Filter 80mesh Mixing Aweco', 'submitted', '2020-11-16', '2020-11-16 06:51:27', '2020-11-16 06:51:31', NULL),
(109, 'QC-20-11-009', 24, 17, '25895902', 'Material - Perbaikan dedleg di jalur PW Supply dari PW Gen', 'submitted', '2020-11-16', '2020-11-16 06:54:56', '2020-11-16 06:54:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_vendors`
--

CREATE TABLE `quotation_vendors` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `quotation_vendors`
--

INSERT INTO `quotation_vendors` (`id`, `code`, `purchase_request_id`, `vendor_id`, `amount`, `description`, `status`, `received_date`, `purchase_order_vendored`, `created_at`, `updated_at`, `user_id`) VALUES
(3, 'P001/Q6-2019/006', 0, 11, '14000000', 'Assembly Header & Frame MFP14-PPU PACKAGED\r\nPUMP UNIT 50MM PN16 SIMPLEX + Wood Full\r\nPacking', 'received', '2019-10-06', 1, '2020-10-02 21:30:32', '2021-03-09 00:52:33', 16),
(4, 'P-040', 0, 27, '248000', '2 Pcs MS/CS/CI Flange PN40 Slip On Raise Face (RF)\r\ndia. 80mm (3\") @ 124.000', 'received', '2020-01-23', 0, '2020-10-02 21:41:41', '2020-10-02 21:41:41', 16),
(5, 'P-040-001', 0, 27, '312000', '1 Pcs SS316 Socket BSP #150 3/8\" @ 19.000\r\n1 Pcs SS316 Elbow Sch40 Welded 1/2\" @ 33.000\r\n2 Pcs SS316 Flange PN40 Slip On RF 1/2\" @ 130.000', 'received', '2020-01-27', 0, '2020-10-02 23:10:51', '2020-10-02 23:10:51', 16),
(6, 'P-040-002', 0, 27, '2523000', '- 2 pcs CS Flange PN16 Slip On RF 6\" @ 150.000 \r\n- 1 pcs  CS Flange PN16 Slip On RF 2.5\"  @ 66.000\r\n- 6 Pcs CS Flange PN16 Slip On RF 2\" @ 64.000\r\n- 5 Pcs CS Elbow Sch40 Seamless 2\" @ 18.000\r\n- 2 Pcs CS Elbow Sch40 Seamless 1\"@ 7.000\r\n- 8 Pcs CS Elbow Sch40 Seamless 1/2\" @ 4.000\r\n- 2 Pcs CS Tee Equal Sch40 Seamless 1/2\" @ 12.000\r\n- 2 Pcs SS304 Watermoer/ Union #3000 1\" NPT @ 253.000\r\n- 4 Pcs SS304 Watermoer/ Union #3000 1/2\" NPT @ 171.000\r\n- 4 Pcs CS Pipe Nipple sch40 L=100mm 1\"  @ 14.000\r\n- 8 Pcs CS Pipe Nipple sch40 L=100mm 1/2\" @ 11.000\r\n- 3 Pcs CS Double Nipple #3000 NPT 1\" @ 33.000\r\n- 10 Pcs CS Double Nipple #3000 NPT 1/2\" @ 18.000\r\n', 'received', '2020-01-27', 0, '2020-10-03 00:38:04', '2020-10-03 00:38:04', 16),
(7, 'P-051', 0, 30, '23000000', '1 Unit FMB70-1FR3/0\r\nFMB70-ACR1F1200CAA Deltapilot S FMB70 @ 23.000.000', 'received', '2020-01-27', 0, '2020-10-03 02:36:02', '2020-10-03 02:36:02', 16),
(8, 'P-007', 0, 13, '240000', '4 Pcs CS SWG Gasket PN16 2\" @ 60.000', 'received', '2020-01-27', 0, '2020-10-03 02:40:19', '2020-10-03 02:40:19', 16),
(9, 'P-007-001', 0, 13, '342000', '- 4 Pcs SS304 SWG Gasket PN16 1\" @ 57.000\r\n- 2 Pcs SS304 SWG Gasket ANSI#300 1\" @ 57.000\r\n', 'received', '2020-01-29', 0, '2020-10-03 03:15:51', '2020-10-03 03:15:51', 16),
(10, 'P-040-003', 0, 27, '1652000', '- 8 Pcs SS304 Flange PN16 Slip On RF 1\" @ 96.000\r\n- 4 Pcs SS304 Flange ANSI#300 RF 1\" @ 221.000', 'received', '2020-01-29', 0, '2020-10-03 03:19:06', '2020-10-03 03:19:06', 16),
(11, 'P-040-004', 0, 27, '4174000', '- 1 Pcs CS Flange PN16 Slip On RF 12\" @ 452.000\r\n- 2 Pcs CS Flange PN16 Slip On RF 4\" @ 86.500\r\n- 12 Pcs CS Flange PN16 Slip On RF 3\" @ 43.000\r\n- 2 Pcs CS Flange PN16 Slip On RF 1.5\" @ 32.500\r\n- 2 Pcs CS Flange PN16 Slip On RF 1\" @ 32.500\r\n- 7 Pcs CS Elbow Sch40 Seamless 3\" @ 49.000\r\n- 1 Pcs CS Elbow Sch40 Seamless 1.5\"  @ 12.000\r\n- 8 Pcs CS Elbow Sch40 Seamless 1\" @ 7.000\r\n- 10 Pcs CS Elbow Sch40 Seamless 1/2\" @ 4.000\r\n- 1 Pcs CS Tee Equal Sch40 Seamless 1.5\" @29.000\r\n- 2 Pcs CS Tee Equal Sch40 Seamless 1\" @ 18.000\r\n- 1 Pcs CS Tee Equal Sch40 Seamless 1/2\" @ 12.000\r\n- 2 Pcs CS Ecc. Reducer Sch40 Seamless 1.5\" x 1\" @ 23.500\r\n- 2 Pcs CS Ecc. Reducer Sch40 Seamless 1\" x 1/2\" @ 16.500\r\n- 4 Pcs SS304 Watermoer/ Union #3000 1\" NPT  @ 253.000\r\n- 4 Pcs SS304 Watermoer/ Union #3000 1/2\" NPT @ 171.000\r\n- 11 Pcs CS Pipe Nipple sch40 L=100mm 1\" @ 14.000\r\n- 11 Pcs CS Pipe Nipple sch40 L=100mm 1/2\" @ 11.000\r\n- 6 Pcs CS Double Nipple #3000 NPT 1\" @ 33.000\r\n- 7 Pcs CS Double Nipple #3000 NPT 1/2\"  @ 18.000', 'received', '2020-01-29', 0, '2020-10-03 03:37:32', '2020-10-03 03:37:32', 16),
(13, 'P-001-012', 0, 11, '17000000', 'Assembly Header & Frame MFP14-PPU PACKAGED PUMP UNIT 80x50MM PN16 TRIPLEX', 'received', '2020-02-14', 0, '2020-11-16 07:10:48', '2020-11-16 07:10:48', 16),
(14, 'P002/Q12-2019/005', 0, 12, '14786640', 'MINOX 1\" ROTARY SPRAY BALL - BSPT, SS316L, MINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, MINOX 1.5\" FERRULE 12.7MM, SS316L, MINOX 0.5\" FERRULE 12.7MM, SS316L, MINOX 4\" FERRULE 15.9MM, SS316L, MINOX 4\" / DN100 FERRULE BLANK, SS316L, MINOX 0.5\" FERRULE GASKET <EPDM>, MINOX 1.5\" FERRULE GASKET <EPDM>, MINOX 4\" FERRULE GASKET <EPDM>,  ect.', 'received', '2019-06-27', 1, '2020-11-23 19:57:32', '2021-03-05 03:48:45', 16),
(15, 'P002/Q17-2019/005', 0, 12, '1757360', 'MINOX 1.0\" FERRULE 12.7MM, SS316L, MINOX 1\" FERRULE GASKET <EPDM>, MINOX 1\" PIPE HANGER TYPE C, SS304', 'received', '2019-04-17', 1, '2020-11-23 20:03:56', '2021-03-09 01:17:47', 16),
(16, 'P002/Q29-2019/028', 0, 12, '4512640', 'MINOX 4\" FERRULE 15.9MM, SS316L, MINOX 4\" FERRULE GASKET <EPDM>, MINOX 4\" / DN100 CLAMP RING, SS304, MINOX 4\" X 2\" CON REDUCER, WELD END SS316L, MINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L, MINOX 2\" 90 DEG ELBOW, WELD END, SS304L (R=1.5), ', 'received', '2019-07-23', 0, '2020-11-23 21:02:51', '2021-03-05 03:07:01', 16),
(17, 'P002/Q47-2019/035', 0, 12, '572000', 'MINOX 1\" STATIC SPRAY BALL - FV 2.0mm, SS316L', 'received', '2019-10-09', 0, '2020-11-23 21:05:03', '2021-03-05 03:09:41', 16),
(18, 'P002/Q50-2019/004', 0, 12, '2756160', 'MINOX 4\" FERRULE 15.9MM, SS316L, MINOX 4\" X 1.5\" ECC REDUCER, WELD END SS316L, MINOX 0.5\" X 1.50MM X 6.0M SANITARY TUBE - A270, SS316L, MINOX 0.5\" FERRULE 12.7MM, SS316L, MINOX 0.5\" FERRULE GASKET <EPDM>, MINOX 0.5\"-0.75\" CLAMP RING, SS304, MINOX 2\" FERRULE 12.7MM, SS316L, MINOX 2\" FERRULE GASKET <EPDM>, MINOX 2\" CLAMP RING, SS304', 'received', '2019-09-17', 0, '2020-11-23 21:09:13', '2021-03-05 03:11:50', 16),
(19, 'P002/Q52-2019/004', 0, 12, '211200', 'MINOX 4\" PIPE HANGER TYPE C, SS304', 'received', '2019-09-17', 0, '2020-11-23 21:11:11', '2021-03-05 03:13:18', 16),
(20, 'P002/Q56-2019/043', 0, 12, '1716000', 'MINOX 4\" X 1.5\" REDUCING TEE, WELD END, SS316L', 'received', '2019-09-10', 0, '2020-11-23 21:13:08', '2021-03-05 03:14:29', 16),
(21, 'P002/Q64-2019/057', 0, 12, '5407600', 'MINOX 1.5\" PIPE HANGER TYPE C, SS304, MINOX 1\" - 1.5\" / DN25 - DN40 FERRULE BLANK, SS316L, MINOX 1.5\" FERRULE 12.7MM, SS316L, MINOX 1.5\" FERRULE GASKET <EPDM>, MINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304', 'received', '2020-01-16', 0, '2020-11-23 22:47:26', '2021-03-05 03:15:48', 16),
(22, 'P002/Q69-2019/057', 0, 12, '5224560', 'MINOX 1.5\" PIPE HANGER TYPE C, SS304, MINOX 2\" PIPE HANGER TYPE C, SS304, MINOX 4\" PIPE HANGER TYPE C, SS304, MINOX 4\" TEE EQUAL, WELD END, SS316L, MINOX 1.5\" X 1.25MM X 6M SANITARY TUBE - EN10357, SS316L, MINOX 1\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L,\r\nMINOX 1.5\" FERRULE 12.7MM, SS316L ', 'received', '2020-01-16', 0, '2020-11-23 22:51:42', '2021-03-05 03:17:02', 16),
(23, 'P002/Q74-2019/057', 0, 12, '24763200', 'MINOX 1.5 X 1.65MM X 6.1M BPE ANNEALED SANITARY, \r\nPIPE, SURFACE ID/OD SFT1 RA≤0.5μm SS316L', 'received', '2020-01-16', 0, '2020-11-23 22:54:08', '2021-03-05 03:18:07', 16),
(24, 'P002/Q77-2019/057', 0, 12, '492800', 'MINOX 2\"x1.5\" ECC REDUCER, WELD END SS316L', 'received', '2020-01-16', 0, '2020-11-23 23:01:27', '2021-03-05 03:19:31', 16),
(25, 'P002/Q081-2019/057', 0, 12, '11682000', 'MINOX PNEUMATIC ACTUATOR FOR 1\"-2.5\" BUTTERFLY VALVE - A63/SR, SS304, \r\nMINOX 1\" PNEUMATIC BUTTERFLY VALVE C/W EPDM GASKET, WELD END SS316L, \r\nMINOX 2\" X 1\" REDUCING TEE, WELD END, SS316L, \r\nMINOX 2\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 1.5\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 1\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 1\" 90 DEG ELBOW, WELD END, SS304L (R=1.5), \r\nMINOX 3\" X 2\" REDUCING TEE, WELD END, SS316L, \r\nMINOX 3\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX 1.5\" EQUAL TEE, WELD END, SS316L, \r\nMINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304, \r\nMINOX 1.5\" FERRULE GASKET <EPDM>, \r\nMINOX 1\" - 1.5\" / DN25 - DN40 FERRULE BLANK, SS316L, \r\nMINOX PULL HANDLE FOR 1\" - 2.5\" BUTTERFLY VALVE, SS304', 'received', '2020-01-16', 0, '2020-11-23 23:07:47', '2021-03-05 03:22:25', 16),
(26, 'P002/Q082-2019/057', 0, 12, '17812960', 'MINOX 1.5\" PNEUMATIC BUTTERFLY VALVE C/W EPDM GASKET, WELD END SS316L, \r\nMINOX 1\" PNEUMATIC BUTTERFLY VALVE C/W EPDM GASKET, WELD END SS316L, \r\nMINOX 8\" FERRULE 28.6MM, SS316L, \r\nMINOX 8\" FERRULE BLANK, SS316L, \r\nMINOX 8\" CLAMP RING, SS304, \r\nMINOX 8\" FERRULE GASKET - FLANGED TYPE <EPDM>, \r\nMINOX 0.5\" FERRULE 12.7MM, SS316L, \r\nMINOX 0.5\"-0.75\" CLAMP RING, SS304, \r\nMINOX 0.5\" FERRULE GASKET <EPDM>, \r\nMINOX 1.5\" X 1\" REDUCING TEE, WELD END, SS316L, \r\nMINOX 1\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 1\" 90 DEG ELBOW, WELD END, SS304L (R=1.5), \r\nMINOX 2\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 1.5\" LEVEL GAUGE - LOWER, CLAMP END, SS316 C/W EPDM GASKET, \r\nMINOX 1.5\" LEVEL GAUGE - UPPER, CLAMP END, SS316 C/W EPDM GASKET, \r\nMINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L, \r\nMINOX 2\" PIPE HANGER TYPE C, SS304', 'received', '2020-01-16', 0, '2020-11-23 23:13:14', '2021-03-05 03:23:20', 16),
(27, 'P002/Q083-2019/057', 0, 12, '12510960', 'MINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX 1.5\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 1.0\" FERRULE 12.7MM, SS316L, \r\nMINOX 1\" FERRULE GASKET <EPDM>, \r\nMINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304, \r\nMINOX 3\" X 1\" CON REDUCER, WELD END, SS304L,\r\nMINOX PNEUMATIC ACTUATOR FOR 1\"-4\" BUTTERFLY VALVE - D85/SR, SS304 c/w bracket, \r\nMINOX 1.5\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 0.5\" FERRULE 12.7MM, SS316L, \r\nMINOX 0.5\"-0.75\" CLAMP RING, SS304, \r\nMINOX 0.5\" FERRULE GASKET <EPDM>', 'received', '2020-01-16', 0, '2020-11-23 23:17:55', '2021-03-05 03:24:31', 16),
(28, 'P002/Q6-2019/057', 0, 12, '19354720', 'MINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX PNEUMATIC ACTUATOR FOR 1\"-4\" BUTTERFLY VALVE - D85/SR, SS304 c/w bracket, \r\nMINOX PULL HANDLE FOR 1\" - 2.5\" BUTTERFLY VALVE, SS304, \r\nMINOX 1.5\" FERRULE 12.7MM, SS316L, \r\nMINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304, \r\nMINOX 1.5\" FERRULE GASKET <EPDM>, \r\nMINOX 1\" 90 DEG ELBOW, WELD END, SS304L (R=1.5), \r\nMINOX 1.5\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 0.5\" FERRULE 12.7MM, SS316L,\r\nMINOX 8\" FERRULE 28.6MM, SS316L, \r\nMINOX 8\" FERRULE BLANK, SS316L, \r\nMINOX 8\" CLAMP RING, SS304, \r\nMINOX 8\" FERRULE GASKET - FLANGED TYPE <EPDM>, \r\nMINOX 6\" FERRULE BLANK, SS316L,\r\nMINOX 1.5\" 90 DEG ELBOW, WELD END, SS316L (R=1.5)\r\nMINOX 2\" 90 DEG ELBOW, WELD END, SS316L (R=1.5),\r\nMINOX 2\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 4\" FERRULE GASKET <EPDM>, \r\nMINOX 4\" / DN100 CLAMP RING, SS304, \r\nMINOX 4\" / DN100 FERRULE BLANK, SS316L, \r\nMINOX 2\" SMS UNION C/W EPDM GASKET SS316L\r\nMINOX 4\" X 1.5\" REDUCING TEE, WELD END, SS316L, \r\nMINOX 4\" FERRULE 15.9MM, SS316L, \r\n', 'received', '2020-01-16', 0, '2020-11-24 03:24:52', '2021-03-05 03:26:02', 16),
(29, 'P-002-013-2020', 0, 12, '7764240', 'MINOX 1.5\" FERRULE 12.7MM, SS316L,\r\nMINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304,\r\nMINOX 1.5\" FERRULE GASKET <EPDM>,\r\nETC', 'received', '2020-02-14', 0, '2020-11-24 03:32:35', '2020-11-24 03:32:35', 16),
(30, 'P-002-019-2020', 0, 12, '27252720', 'MINOX 1.5\" FERRULE 12.7MM, SS316L, \r\nMINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304,\r\nMINOX 1.5\" FERRULE GASKET <EPDM>, \r\nMINOX 1\" ROTARY SPRAY BALL - BSPT, SS316L,\r\nMINOX 3\" FERRULE 12.7MM, SS316L, \r\nMINOX 3\" / DN65 FERRULE BLANK, SS316L, \r\nMINOX 3\" FERRULE GASKET <EPDM>, \r\nMINOX 3\" / DN65 CLAMP RING, SS304, \r\nETC ', 'received', '2020-03-06', 0, '2020-11-24 03:49:18', '2020-11-24 03:49:18', 16),
(31, 'P-002-022-2020', 0, 12, '26069120', 'MINOX DN150 X 2.0MM X 6.0M SANITARY TUBE - EN10357, SS316L (OD154/ID150), \r\nMINOX DN150 90 DEG ELBOW, WELD END, SS304L\r\n(OD154/ID150), \r\nMINOX 3\" FERRULE 12.7MM, SS304L, \r\nMINOX 3\" / DN65 CLAMP RING, SS304, MINOX 3\" FERRULE GASKET <EPDM>, MINOX 6\" FERRULE 12.7MM, SS304L,\r\nETC', 'received', '2020-04-08', 0, '2020-11-24 04:12:20', '2020-11-24 04:12:20', 16),
(32, 'P-002-023-2020', 0, 12, '1364000', 'MINOX DN200 X DN150 CON REDUCER, WELD END SS304L', 'received', '2020-04-14', 0, '2020-11-24 04:25:38', '2020-11-24 04:25:38', 16),
(33, 'P-002-031-2020', 0, 12, '51899760', 'MINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L,\r\nMINOX 2\" 90 DEG ELBOW, WELD END, SS316L (R=1.5),\r\nMINOX 2\" SMS UNION C/W EPDM GASKET SS316L,\r\nMINOX 2\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 2\" SMS BLANK NUT C/W CHAIN, SS316L, MINOX 2\" / DN50 PIPE HANGER TYPE B, SS304', 'received', '2020-04-24', 0, '2020-11-24 04:31:47', '2020-11-24 04:31:47', 16),
(34, 'P-002-033-2020', 0, 12, '7587360', 'MINOX 4\" M6300 NITRILE FOOD & BEVERAGE SUCTION AND DISCHARGE HOSE; L=500mm\r\nEnd to End, w/o connection\r\nMINOX 4\" FERRULE ADAPTOR, SS316L, \r\nMINOX 4\" / DN100 CLAMP RING, SS304,\r\nMINOX 4\" FERRULE GASKET <EPDM>,\r\nMINOX 4\" FERRULE 15.9MM, SS304L,\r\nMINOX 4\" X 2.00MM X 6.0M SANITARY TUBE - EN10357,\r\nSS316L', 'received', '2020-04-27', 0, '2020-11-24 04:34:32', '2020-11-24 04:34:32', 16),
(35, 'P-002-043-2020', 0, 12, '11776160', 'MINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L\r\n(delivery to PT ISAM - Bandung),\r\nMINOX 1.5\" FERRULE 12.7MM, SS316L, \r\nMINOX 1.5\" FERRULE GASKET <EPDM>, \r\nMINOX 1.0\" FERRULE 12.7MM, SS316L, \r\nMINOX 1\" FERRULE GASKET <EPDM>,\r\nMINOX 1\"-1.5\" / DN25-DN40 CLAMP RING, SS304, \r\nMINOX 0.5\" FERRULE 12.7MM, SS316L, \r\nMINOX 0.5\"-0.75\" CLAMP RING, SS304, \r\nMINOX 0.5\" FERRULE GASKET <EPDM>, \r\nMINOX 3\" FERRULE GASKET <EPDM>,\r\nMINOX PULL HANDLE FOR 1\" - 2.5\" BUTTERFLY VALVE, SS304,\r\nMINOX 1\" - 1.5\" / DN25 - DN40 FERRULE BLANK, SS316L', 'received', '2020-05-07', 0, '2020-11-24 04:39:47', '2020-11-24 04:39:47', 16),
(36, 'P-002-047-2020', 0, 12, '3864960', 'MINOX 2.5\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 2.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L', 'received', '2020-05-12', 0, '2020-11-24 04:42:04', '2020-11-24 04:42:04', 16),
(37, 'P-002-055-2020', 0, 12, '68575760', 'MINOX 4\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX 3\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 2\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 1\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L,\r\nMINOX PNEUMATIC ACTUATOR FOR 1\"-4\" BUTTERFLY VALVE - D85/SR, SS304 c/w bracket, \r\nMINOX 4\" X 2.00MM X 6.0M SANITARY TUBE - EN10357, SS316L, \r\nMINOX 3\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L, \r\nMINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L, \r\nMINOX 1\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L, \r\nMINOX 4\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 3\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 2\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 1\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX DN150 X 4\" CON REDUCER, WELD END SS316L, \r\nMINOX 4\" X 3\" CON REDUCER, WELD END SS316L, \r\nMINOX 3\" X 1.5\" REDUCING TEE, WELD END, SS316L\r\nMINOX 3\" EQUAL TEE, WELD END, SS316L\r\nMINOX 4\" FERRULE 15.9MM, SS316L, \r\nMINOX 4\" FERRULE GASKET <EPDM>, \r\nMINOX 4\" / DN100 CLAMP RING, SS304, \r\nMINOX 4\" / DN100 FERRULE BLANK, SS316L,\r\nMINOX 1\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 4\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 4\" PIPE HANGER TYPE C, SS304, \r\nMINOX 2\" PIPE HANGER TYPE C, SS304, \r\nMINOX 1\" PIPE HANGER TYPE C, SS304, \r\n', 'received', '2020-05-18', 0, '2020-11-25 00:15:48', '2020-11-25 00:15:48', 16),
(38, 'P-002-058-2020', 0, 12, '11827200', 'MINOX 3\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 2\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 3\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 2\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 1\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 3\" FERRULE 12.7MM, SS304L, \r\nMINOX 3\" / DN65 CLAMP RING, SS304, \r\nMINOX 3\" FERRULE GASKET <EPDM>, \r\nMINOX 2\" FERRULE 12.7MM, SS316L, \r\nMINOX 2\" FERRULE GASKET <EPDM>, \r\nMINOX 2\" CLAMP RING, SS304, \r\nMINOX 1.5\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 3\" SMS UNION C/W EPDM GASKET SS316L, \r\nMINOX 2\"x1.5\" ECC REDUCER, WELD END SS316L, \r\nMINOX 3\" X 1.5\" REDUCING TEE, WELD END, SS316L, \r\n', 'received', '2020-05-29', 0, '2020-11-25 00:22:50', '2020-11-25 00:22:50', 16),
(39, 'P-002-059-2020', 0, 12, '3416160', 'MINOX 3\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 1\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 3\" FERRULE 12.7MM, SS304L, \r\nMINOX 3\" / DN65 CLAMP RING, SS304, \r\nMINOX 3\" FERRULE GASKET <EPDM>', 'received', '2020-05-29', 0, '2020-11-25 00:44:28', '2020-11-25 00:44:28', 16),
(40, 'P-002-070-2020', 0, 12, '139907625', 'MINOX OD456 x H100 ROUND MANHOLE - A450, SS316L, C/W SILICONE GASKET & S/S KNOBS, \r\nMINOX 3\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX 4\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX 2.5\" BUTTERFLY VALVE C/W EPDM GASKET, PULL HANDLE, WELD END SS316L, \r\nMINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX 1\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX PNEUMATIC ACTUATOR FOR 1\"-4\" BUTTERFLY VALVE - D85/SR, SS304, \r\nETC\r\n', 'received', '2020-06-26', 0, '2020-11-25 02:26:16', '2020-11-25 02:26:16', 16),
(41, 'P-002-072-2020', 0, 12, '9826960', 'MINOX 4\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L\r\nMINOX 2\" X 1.25MM X 6.0M SANITARY TUBE - EN10357, SS316L\r\nMINOX 4\" EQUAL TEE, WELD END, SS316L, \r\nMINOX 4\" X 2.5\" ECC REDUCER, WELD END, SS316L, \r\nMINOX 6\" FERRULE 28.6MM, SS316L, \r\nMINOX 6\" FERRULE GASKET -  FLANGED TYPE <EPDM>, \r\nMINOX 1.5\" FERRULE 12.7MM, SS316L, \r\nMINOX 4\" PIPE HANGER TYPE C, SS304', 'received', '2020-07-01', 0, '2020-11-25 18:14:44', '2020-11-25 18:14:44', 16),
(42, 'P-002-077-2020 REV', 0, 12, '25913360', 'MINOX 1\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX 1.5\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L, \r\nMINOX PNEUMATIC ACTUATOR FOR 1\"-4\" BUTTERFLY VALVE - D85/SR, SS304 c/w bracket\r\n(for Butterfly Valve 1\"), \r\nMINOX 3\" X 1.65MM X 6.0M SANITARY TUBE - EN10357, SS316L, \r\nMINOX 1.5\" X 1.25MM X 6M SANITARY TUBE - EN10357, SS316L, \r\nMINOX 2\" 90 DEG ELBOW, WELD END, SS316L (R=1.5), \r\nMINOX 2\" EQUAL TEE, WELD END, SS316L, \r\nMINOX 2\" FERRULE 12.7MM, SS316L, \r\nMINOX 2\" FERRULE GASKET <EPDM>, \r\nMINOX 2\" CLAMP RING, SS304, \r\nETC', 'received', '2020-07-23', 0, '2020-11-25 18:19:12', '2020-11-25 18:19:12', 16),
(43, 'P-007-006', 0, 13, '240000', 'CS SWG Gasket PN16 2\", \r\n', 'received', '2020-01-27', 0, '2020-11-25 18:22:46', '2020-11-25 18:22:46', 16),
(44, 'P-007-007', 0, 13, '342000', 'SS304 SWG Gasket PN16 1\", \r\nSS304 SWG Gasket ANSI#300 1\"', 'received', '2020-01-29', 0, '2020-11-25 18:35:40', '2020-11-25 18:35:40', 16),
(45, 'P-007-015', 0, 13, '1275000', 'CS SWG Gasket PN16 3\", \r\nCS SWG Gasket PN16 1\", \r\nCS SWG Gasket PN16 1.5\", \r\n', 'received', '2020-02-14', 0, '2020-11-25 18:39:15', '2020-11-25 18:39:15', 16),
(46, 'P-007-021-2020', 0, 13, '3500000', 'Pressure gauge WIKA\r\nDial size     : 100mm/4”\r\nRange        : 0 – 10 Bar ( Single Range )\r\nMaterial     : Full Stainless\r\nConection  : With Diagram Sanitary 1,5” + Clamping\r\nMounting   : Bottom, \r\nKalibrasi KAN (Included)', 'received', '2020-03-17', 0, '2020-11-25 18:42:40', '2020-11-25 18:42:40', 16),
(47, 'P-007-032-2020', 0, 12, '3500000', 'Pressure gauge WIKA\r\nDial size     : 100mm/4”\r\nRange        : 0 – 10 Bar ( Single Range )\r\nMaterial     : Full Stainless\r\nConection  : With Diagram Sanitary 1,5” + Clamping\r\nMounting   : Bottom, \r\n\r\nKalibrasi KAN (Included)', 'received', '2020-04-24', 0, '2020-11-25 18:46:58', '2020-11-25 18:46:58', 16),
(48, 'P-007-067-2020', 0, 12, '14000000', 'Pressure gauge WIKA\r\nDial size     : 100mm/4”\r\nRange        : 0 – 10 Bar ( Single Range )\r\nMaterial     : Full Stainless\r\nConection  : With Diagram Sanitary 1,5” + Clamping\r\nMounting   : Bottom\r\nKalibrasi KAN (Included)', 'received', '2020-06-22', 0, '2020-11-25 21:17:08', '2020-11-25 21:17:08', 16),
(49, 'P-063-072', 0, 15, '36676156', 'FTL33-1369/0\r\nFTL33-AA4M2AB3CJ\r\nLiquiphant FTL33', 'received', '2020-06-26', 0, '2020-11-25 21:22:14', '2020-11-25 21:22:14', 16),
(50, 'P-063-073', 0, 14, '104610000', 'FMB50-KDT6/0\r\nFMB50-AA22IA1HGBUNJB3U\r\nDeltapilot M FMB50', 'received', '2020-06-30', 0, '2020-11-25 21:24:29', '2020-11-25 21:24:29', 16),
(51, 'P-012-005', 0, 16, '984500', 'Ink Catridge D33006B-66X-01', 'received', '2020-03-03', 0, '2020-11-25 23:45:45', '2020-11-25 23:45:45', 16),
(52, 'P-012-025', 0, 16, '2618000', 'Temp control TK4S-14RN', 'received', '2020-04-15', 0, '2020-11-25 23:47:15', '2020-11-25 23:47:15', 16),
(53, 'P-012-068', 0, 16, '10473300', 'Temp control TK4S-14RN, \r\nCounter CT6S-1P4 100-240VAC, \r\nProximity Switch prd12-8dp w/ cable 2mtr, \r\nTower Light PMEP-302-RYG 24VDC \"Menics\", \r\nBuzzer B2NB-B1D-R 24VDC Red', 'received', '2020-06-22', 0, '2020-11-25 23:49:54', '2020-11-25 23:49:54', 16),
(54, 'P-013-046', 0, 17, '3190000', 'Supply Box\r\nDim ; 400 (W) x 600 (H) x 300 (D)\r\nStainless SS.304 (Hairline)', 'received', '2020-05-12', 0, '2020-11-26 02:27:29', '2020-11-26 02:27:29', 16),
(55, 'P-013-063', 0, 17, '6380000', 'Supply Box, \r\nDim ; 600 (W) x 800 (H) x 300 (D)\r\nStainless SS.304 (Hairline)', 'received', '2020-06-22', 0, '2020-11-26 02:31:06', '2020-11-26 02:31:06', 16),
(56, 'P-021-030', 0, 18, '10850000', 'DC Inverter Pulse TIG Welding Machine Merk WEIRO \r\nType TIG-200P,\r\nAssesories:\r\nTig Torch, Base Metal Side Cable,  Argon Hose, Argon Regulator\r\nWaranty 1years, included service\r\nConsumable excluded\r\n\r\nTig Torch WP26 - 4mtr for Weiro\r\nIncluded PPn 10%', 'received', '2020-04-20', 0, '2020-11-26 02:35:47', '2020-11-26 02:35:47', 16),
(57, 'P024/Q36-2020/0', 0, 19, '3445090', 'Kaca Face shield\r\nMajun Putih Katun\r\nMesin Bor Bosch GSB550\r\nBatu Cutting WD 4\" x 1.2mm\r\nScoth Brite 3M 7447 (isi 10pcs)', 'received', '2020-04-27', 0, '2020-11-26 02:39:35', '2021-03-08 22:05:13', 16),
(58, 'P024/Q66-2020/015', 0, 19, '2753850', 'Kaca Face shield\r\nMajun Putih Katun\r\nFiller SS 308 2mm\r\nFlexible Ultraflex 4\" x 1.2mm \r\nFiller SS 316L 1.6mm\r\nFiller SS 316L 2.4mm \"Techweld\"\r\nBan Poles Kain 4\"\r\nEar Plug Max\r\nBatu Gerinda Tebel 4\" Resibon\r\n', 'received', '2020-06-22', 0, '2020-11-26 02:49:52', '2021-03-08 21:50:28', 16),
(59, 'P027/Q20-2020/011', 0, 20, '4356000', 'RECTANGULAR TUBE SS304 @6mtr\r\n\r\n80mm x 40mm x 2mm\r\n40mm x 40mm x 2mm\r\n40mm x 3mm', 'received', '2020-03-16', 0, '2020-11-26 03:44:34', '2021-03-08 22:19:29', 16),
(60, 'P027/Q34-2020/022', 0, 20, '12595000', 'SS304 plate 1mm- 4\"x8\" 2B Finished\r\nSS304 plate 2mm- 4\"x8\" 2B Finished\r\nMS plate 1mm- 4\"x8\"\r\nSS304 Square Tube 40x40x2mm @6mtr\r\nSS304 Square Tube 50x50x2mm @6mtr\r\nMS Square Tube 20x20mm @6mtr', 'received', '2020-04-27', 0, '2020-11-26 03:48:09', '2021-03-08 22:21:24', 16),
(61, 'P027/Q35-2020/020', 0, 20, '8580000', 'SS304 Square Tube 40x40x2mm @6mtr\r\n40mm x 3mm', 'received', '2020-04-27', 0, '2020-11-26 03:54:56', '2021-03-08 22:26:07', 16),
(62, 'P027/Q42-2020/022', 0, 20, '880000', 'Aluminium Plat Bordes 4\' x 8\' t=3mm', 'received', '2020-05-06', 0, '2020-11-26 03:56:24', '2021-03-08 22:28:35', 16),
(63, 'P027/Q048-2020/027', 0, 20, '2860000', 'SS304 Pipe Sch40 Welded dia. 2\" @6mtr\r\nSS304 Elbow Sch40 Welded dia. 2\"', 'received', '2020-05-14', 0, '2020-11-26 03:58:09', '2021-03-08 22:29:52', 16),
(64, 'P027/Q50-2020/027', 0, 20, '1100000', 'SS304 Flange Jis10K dia. 2\"', 'received', '2020-05-15', 0, '2020-11-26 03:59:39', '2021-03-08 22:32:36', 16),
(65, 'P027/Q69-2020/015', 0, 20, '6270000', 'SS304 Square Tube 40x40x2mm @6mtr\r\nPlate bar 40mm x 3mm @6mtr', 'received', '2020-06-22', 0, '2020-11-26 04:01:10', '2021-03-08 22:33:35', 16),
(66, 'P027/Q10-2020/001', 0, 20, '1413500', 'Pipa CS Seamless Sch40 x 6 MTR dia. 1/2\" ex Cina\r\nPipa CS Seamless Sch40 x 6 MTR dia. 1\" ex Cina\r\nPipa SS304 Welded Sch10 x 6 MTR dia. 1/2\" ex Cina', 'received', '2020-01-29', 0, '2020-11-26 04:03:37', '2021-03-08 22:37:23', 16),
(67, 'P-028-045', 0, 21, '1785300', 'HITACHI GLOBE VALVE ECONOMICAL\r\nMATERIAL : MALLEABLE IRON\r\nTYPE : HM10KSG\r\nCONNECTION : SCREW JIS 10K\r\nSIZE : 1/2 INCH', 'received', '2020-05-09', 0, '2020-11-26 21:44:56', '2020-11-26 21:44:56', 16),
(68, 'P-029-056', 0, 22, '5885000', 'Kabel SMI YSLY 3 X 1.5mm\r\nKabel SMI YSLY 3 X 0.75mm\r\nKabel SMI LIYCY 3 X 0.75mm\r\nKabel Ethernet Cat6 - Belden', 'received', '2020-05-20', 0, '2020-11-26 22:53:10', '2020-11-26 22:53:10', 16),
(69, 'P-031-024', 0, 23, '9452300', 'Merk : Dinflo Pump\r\nType : DFCS 240/30\r\nKapasitas : 7,8 – 14,4 M3/H\r\nHead : 26 Meter (2,6 Bar) – 21 Meter (2,1 Bar)\r\nMaterial : SS304\r\nPower : 2,2 Kw, 3 phase, 380V, 50Hz, 2900 Rpm\r\n\r\n', 'received', '2020-04-14', 0, '2020-11-26 22:56:06', '2020-11-26 22:56:06', 16),
(70, 'P-036-014', 0, 24, '4433000', 'Elbow ASME BPE SFT 1 GHWA SS 316L Ø 1.0\"\r\nElbow ASME BPFerrule ASME BPE SFT 1 GHWA SS 316L Ø 1.5\"\r\nE SFT 1 GHWA SS 316L Ø 1.5\"\r\nFerrule ASME BPE SFT 1 GHWA SS 316L Ø 2\"\r\nFerrule ASME BPE SFT 1 GHWA SS 316L Ø 1/2\"\r\nFerrule ASME BPE SFT 1 GHWA SS 316L Ø 1.0\"', 'received', '2020-02-14', 0, '2020-11-26 22:58:51', '2020-11-26 22:58:51', 16),
(72, 'P-037-053-2020', 0, 25, '21000000', 'Hot Insulation Piping Line 2 PT Kalbe Farma Delta Silicon Cikarang', 'received', '2020-05-18', 0, '2020-11-27 03:07:19', '2020-11-27 03:07:19', 16),
(73, 'P-039-061', 0, 26, '2145000', 'Procip A++\r\nConcentrated cleaner based on phosphoric\r\nacid and nitric acid with wetting agents and\r\ncorrosion inhibitors for Cleaning and CIP process\r\n\r\nProcip B++\r\nHighly alkaline cleaner, containig sequestering and\r\ncleaning agents. Suitable for use in hard water', 'received', '2020-06-10', 0, '2020-11-27 03:21:22', '2020-11-27 03:21:22', 16),
(74, 'P-040-008', 0, 27, '1652000', 'SS304 Flange PN16 Slip On RF 1\"\r\nSS304 Flange ANSI#300 RF 1\"', 'received', '2020-01-29', 0, '2020-11-27 03:29:56', '2020-11-27 03:29:56', 16),
(75, 'P-040-009', 0, 27, '4174000', 'CS Flange PN16 Slip On RF 12\"\r\nCS Flange PN16 Slip On RF 4\"\r\nCS Flange PN16 Slip On RF 3\"\r\nCS Flange PN16 Slip On RF 1.5\"\r\nCS Flange PN16 Slip On RF 1\"\r\nCS Elbow Sch40 Seamless 3\"\r\nCS Elbow Sch40 Seamless 1.5\"\r\nCS Elbow Sch40 Seamless 1\"\r\nCS Elbow Sch40 Seamless 1/2\"\r\nCS Tee Equal Sch40 Seamless 1.5\"\r\nCS Tee Equal Sch40 Seamless 1\"\r\nCS Tee Equal Sch40 Seamless 1/2\"\r\nCS Ecc. Reducer Sch40 Seamless 1.5\" x 1\"\r\nCS Ecc. Reducer Sch40 Seamless 1\" x 1/2\"\r\nSS304 Watermoer/ Union #3000 1\" NPT\r\nSS304 Watermoer/ Union #3000 1/2\" NPT\r\nCS Pipe Nipple sch40 L=100mm 1\"\r\nCS Pipe Nipple sch40 L=100mm 1/2\"\r\nCS Double Nipple #3000 NPT 1\"\r\nCS Double Nipple #3000 NPT 1/2\"\r\n', 'received', '2020-01-29', 0, '2020-11-27 03:32:04', '2020-11-27 03:32:04', 16),
(76, 'P-040-011', 0, 27, '1379000', 'SS316L Flange PN40 Slip On RF 1\"\r\nSS316L Flange PN40 Slip On RF 1.5\"\r\nSS316 Elbow Sch40 Welded 1\"\r\nSS316 Elbow Sch40 Welded 1.5\"\r\nSS316 Socket BSP #150 3/8\"\r\n', 'received', '2020-01-30', 0, '2020-11-27 03:33:16', '2020-11-27 03:33:16', 16),
(77, 'P-040-016', 0, 27, '1157000', 'SS304 Blind Flange ANSI#150 1.5\"\r\nSS304 Flange ANSI#150 1.5\"\r\nSS304 Socket BSP #150 3/8\"\r\nCS Concentric Reducer Sch40 Seamless 2\"x1.5\"\r\nCS Tee Equal Sch40 Seamless 1/2\"\r\nSS316 Concentric Reducer sch40 Welded 3\"x2.5\"\r\nSS316 Concentric Reducer sch40 Welded 2\"x1-1/4\"\r\nSS316 Concentric Reducer sch40 Welded 1-1/2\"x3/4\"\r\nSS316 Concentric Reducer sch40 Welded 2.5\"x2\"\r\n', 'received', '2020-02-19', 0, '2020-11-27 03:34:28', '2020-11-27 03:34:28', 16),
(78, 'P-040-002-01', 0, 27, '248000', 'MS/CS/CI Flange PN40 Slip On Raise Face (RF) \r\ndia. 80mm (3\")', 'received', '2020-01-23', 0, '2020-11-27 03:39:26', '2020-11-27 03:39:26', 16),
(79, 'P-040-003-01', 0, 27, '312000', 'SS316 Socket BSP #150 3/8\"\r\nSS316 Elbow Sch40 Welded 1/2\"\r\nSS316 Flange PN40 Slip On RF 1/2\"\r\n', 'received', '2020-01-27', 0, '2020-11-27 03:40:37', '2020-11-27 03:40:37', 16),
(80, 'P-040-004-01', 0, 27, '2523000', 'CS Flange PN16 Slip On RF 6\"\r\nCS Flange PN16 Slip On RF 2.5\"\r\nCS Flange PN16 Slip On RF 2\"\r\nCS Elbow Sch40 Seamless 2\"\r\nCS Elbow Sch40 Seamless 1\"\r\nCS Elbow Sch40 Seamless 1/2\"\r\nCS Tee Equal Sch40 Seamless 1/2\"\r\nSS304 Watermoer/ Union #3000 1\" NPT\r\nSS304 Watermoer/ Union #3000 1/2\" NPT\r\nCS Pipe Nipple sch40 L=100mm 1\"\r\nCS Pipe Nipple sch40 L=100mm 1/2\"\r\nCS Double Nipple #3000 NPT 1\"\r\nCS Double Nipple #3000 NPT 1/2\"\r\n', 'received', '2020-01-27', 0, '2020-11-27 03:42:06', '2020-11-27 03:42:06', 16),
(81, 'P-043-075', 0, 28, '3850000', 'Rental MX4 Ventis :	\r\nVentis MX4, CO, O2, Lithium-ion Extended Range, Desktop Charger, Softcase, With Pump, Black, ATEX/IECEx, English	\r\nStart from: 08/07/2020 to  07/08/2020	\r\n', 'received', '2020-07-07', 0, '2020-11-27 03:43:53', '2020-11-27 03:43:53', 16),
(82, 'P-049-049', 0, 29, '6281844', 'HAFNER  SOLENOID VALVE\r\nTYPE :MH 310 701\r\nManifold 6 valves\r\nCoil : 24VDC \r\n', 'received', '2020-05-14', 0, '2020-11-27 03:45:41', '2020-11-27 03:45:41', 16),
(83, 'P-049-064', 0, 29, '15760126', 'HAFNER  SOLENOID VALVE\r\nTYPE :MH 310 701\r\nManifold 6 valves\r\nCoil : 24VDC \r\n\r\nHAFNER  SOLENOID VALVE\r\nTYPE :MH 310 701\r\nManifold 3 valves\r\nCoil : 24VDC \r\n', 'received', '2020-06-22', 0, '2020-11-27 03:48:16', '2020-11-27 03:48:16', 16),
(84, 'P-049-065', 0, 29, '3196438', 'HAFNER  SOLENOID VALVE\r\nTYPE :MH 310 701\r\nManifold 3 valves\r\nCoil : 24VDC \r\n', 'received', '2020-06-22', 0, '2020-11-27 03:49:50', '2020-11-27 03:49:50', 16),
(85, 'P-049-076', 0, 29, '19225250', 'Burkert Flow Controller Type 8025\r\n8025-0000-0000-00-C-F4-E-BDN/DC-A\r\nInput power : 12-30 Volts\r\nOutput Signal : Current 4-20MA + Pulse OUT PUT\r\n\r\nBurkert High Temp Fittings SE 30 (Paddle Wheel only)\r\nID :  551763\r\nMaterial : SS316 Paddle,Ligidur Axis &bearing\r\n', 'received', '2020-07-07', 0, '2020-11-27 03:52:44', '2020-11-27 03:52:44', 16),
(86, 'P-051-005', 0, 30, '25300000', 'FMB70-1FR3/0\r\nFMB70-ACR1F1200CAA Deltapilot S FMB70\r\n\r\n\"SPK : PED\r\nDigital pressure transmitter\r\nhydrostatic. Sensor: CONTITE, flush mounted. High-Performance. Typ. Linear. +/-0.1%, (max TD 100:1). Modular transmitter. High long term stability. :: Safe humidity protect.,climate proof. :High reliability through process monitoring. \r\nA Approval: Non-hazardous area \r\nC Output; Operating: 4-20mA HART; inside \r\nR Housing; Cover Sealing; Cable Entry: T17 316L hygiene IP66/68 NEMA6P;EPDM;M20 gland, T17 = side cover \r\n1F Sensor Range; Sensor Overload Limit: 400mbar/40kPa/6psi/4mH2O/160inH2O 8bar/800kPa/120psi/80mH2O/3200inH2O \r\n1 Calibration; Unit: Sensor range; mbar/bar \r\n2 Membrane Material; Seal: AlloyC276; welded \r\n00 Process Connection: Universal adapter 44mm 316L, 3A, incl. silicone shape seal \r\nC Fill Fluid: Synthetic oil (FDA) \r\nA Additional Option 1: Not selected \r\nA Additional Option 2: Not selected\"	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n', 'received', '2020-01-27', 0, '2020-11-27 03:54:34', '2020-11-27 03:54:34', 16),
(87, 'P-052-018', 0, 31, '1263295', 'TMASD1\r\nmemory card for M2xx controller\r\n\r\n\r\nTMAHOL02\r\nspare part - Modicon M221 battery holder\r\n', 'received', '2020-03-06', 0, '2020-11-27 03:57:02', '2020-11-27 03:57:02', 16),
(88, 'P-052-0062', 0, 31, '3765762', 'M221CE24R\r\n', 'received', '2020-03-06', 0, '2020-11-27 03:59:12', '2020-11-27 03:59:12', 16),
(89, 'P-053-025', 0, 32, '4950000', 'PMI Testing for Mixing Tank Cap. 100L\r\nLine2 - PT Kalbe Farma\r\nScope of Inspection:\r\nPMI Equipment Niton XL3t 800/ XL2 980\r\n1 PMI Inspector\r\nDocumentation & Reporting\r\nMaximum point of testing 20 spot\r\n', 'received', '2020-04-20', 0, '2020-11-27 04:01:29', '2020-11-27 04:01:29', 16),
(90, 'P-054-027', 0, 33, '7000000', 'Programming & Support Commisioning WT TIV Cianjur', 'received', '2020-04-20', 0, '2020-11-27 04:02:57', '2020-11-27 04:02:57', 16),
(91, 'P-054-028', 0, 33, '7000000', 'Programming & Support Commisioning WT TIV Wonosobo', 'received', '2020-04-20', 0, '2020-11-27 04:04:24', '2020-11-27 04:04:24', 16),
(92, 'P-054-029', 0, 33, '15000000', 'Programming & Support Commisioning Mixing Tank 100L Line2 - PT Kalbe Farma', 'received', '2020-04-20', 0, '2020-11-27 04:05:44', '2020-11-27 04:05:44', 16),
(93, 'P-007-006-01', 0, 13, '240000', 'CS SWG Gasket PN16 2\"', 'received', '2020-01-27', 0, '2020-11-27 04:07:48', '2020-11-27 04:07:48', 16),
(94, 'P-007-007-01', 0, 13, '342000', 'SS304 SWG Gasket PN16 1\"\r\n\r\nSS304 SWG Gasket ANSI#300 1\"\r\n', 'received', '2020-01-29', 0, '2020-11-27 04:08:50', '2020-11-27 04:08:50', 16),
(95, 'P-007-015-02', 0, 13, '1275000', 'CS SWG Gasket PN16 3\"	\r\n	\r\nCS SWG Gasket PN16 1\"	\r\n	\r\nCS SWG Gasket PN16 1.5\"	\r\n', 'received', '2020-02-14', 0, '2020-11-27 04:10:18', '2020-11-27 04:10:18', 16),
(96, 'P-007-021-2020-03', 0, 13, '3500000', '\"Pressure gauge WIKA\r\nDial size     : 100mm/4”\r\nRange        : 0 – 10 Bar ( Single Range )\r\nMaterial     : Full Stainless\r\nConection  : With Diagram Sanitary 1,5” + Clamping\r\nMounting   : Bottom\"	\r\nKalibrasi KAN (Included)	\r\n	\r\nNoted:	\r\nCustomer: PT TIV - Cianjur	\r\nTag No: PI-001	\r\n', 'received', '2020-03-17', 0, '2020-11-27 04:11:50', '2020-11-27 04:11:50', 16),
(97, 'P-055-037', 0, 34, '15000000', '\"Pengadaan Packing Dan Consumable\r\nJasa dan Manpower\r\nScope pekerjaan:\r\n1. Membuka/ Menutup Manhole support NDE inspeksi\r\n2. Penggantian semua packing manhole yang dibuka\"	\r\n	\r\n	\r\nNoted:	\r\nPekerjaan dilakukan di tanggal 29-04-2020	\r\ndi PT Nutrifood Indonesia - MM2100 - Cibitung	\r\n', 'received', '2020-04-28', 0, '2020-11-27 04:14:27', '2020-11-27 04:14:27', 16),
(98, 'P-056-038-04', 0, 35, '5565000', 'SS316L Plate dia. 200mm x 2mm	\r\nSS316L Plate dia. 200mm x 11mm	\r\nSS316L Plate dia. 160mm x 12mm	\r\nSS304 Roundbar dia.20mm x 35mm	\r\nSS304 Roundbar dia.10mm x 20mm	\r\nSS316L Roundbar dia.20mm x 35mm	\r\nSS304 Roundbar dia.10mm x 25mm	\r\nSS316L Roundbar dia.15mm x 255mm	\r\nSS304 Roundbar dia.3\" x 150mm	\r\nSS316L Plate 649mm x 100mm x 1.5mm	\r\nSS316L Plate dia. 370mm x 1.5mm	\r\nSS316L Plate 650mm x 74mm x 3mm	\r\n', 'received', '2020-04-28', 0, '2020-11-29 22:38:50', '2020-11-29 22:38:50', 16),
(99, 'P-056-044-05', 0, 35, '1672000', 'SS316L Roundbar dia.35mm x 1200mm	\r\nSS304 Roundbar dia.1\"  x 250mm	\r\nSS304 Roundbar dia.1.5\"  x 250mm	\r\nTransport Cost	\r\n', 'received', '2020-05-07', 0, '2020-11-29 22:41:22', '2020-11-29 22:41:22', 16),
(100, 'P-056-051-05', 0, 35, '1855000', 'SS304 Roundbar dia.3\" x 150mm	\r\nSS316L Plate dia. 160mm x 12mm	\r\nSS304 Roundbar dia.1/2\" x 1,000mm	\r\nSS316L Plate dia. 65mm x 5mm	\r\nSS316L Plate 20x20x3mm	\r\nSS316L Roundbar dia.1.5\" x 1,000mm	\r\nSS316L Plate dia. 100mm x 3mm	\r\nSS316L Roundbar dia.2.5\" x 30mm	\r\nSS304 Roundbar dia.2.5\" x 40mm	\r\n', 'received', '2020-05-15', 0, '2020-11-29 22:45:21', '2020-11-29 22:45:21', 16),
(101, 'P-057-039-05', 0, 36, '405000', 'SS316L Ferrule Sanitary dia. 1\"	\r\nSS316L Tee Equal Sanitary dia. 1\"	\r\n	\r\n', 'received', '2020-05-04', 0, '2020-11-29 22:47:40', '2020-11-29 22:47:40', 16),
(102, 'P-057-041-05', 0, 36, '368000', 'SS316L Ferrule Sanitary dia. 1\"	\r\nClamp Single Pin Sanitary 1\" - 1.5\"	\r\n', 'received', '2020-05-06', 0, '2020-11-29 22:49:32', '2020-11-29 22:49:32', 16),
(103, 'P-058-040-05', 0, 37, '1100000', 'Rental roughness tools for 1 day	\r\n', 'received', '2020-05-04', 0, '2020-11-29 22:53:17', '2020-11-29 22:53:17', 16),
(104, 'P-059-052', 0, 38, '2552000', 'Shaft OD34x960	\r\nDistance bar OD25.4x246	\r\nDusct Cover OD62x27	\r\nRotor Disk OD50x5	\r\nRotor Sleve OD27.4x70	\r\nRotor Blade t3x18x18	\r\nFinish Machining Rotor	\r\nDrain Plate (Bor OD7-4x)	\r\n', 'received', '2020-05-18', 0, '2020-11-29 23:03:11', '2020-11-29 23:03:11', 16),
(105, 'P-060-054', 0, 39, '16000000', 'Licence Software Batch Report	\r\nEngineering	\r\n', 'received', '2020-05-18', 0, '2020-11-29 23:04:37', '2020-11-29 23:04:37', 16),
(106, 'P-061-057', 0, 40, '22198747', '6ES7215-1AG40-0XB0	\r\nSIMATIC S7-1200, CPU 1215C, compact CPU, DC/DC/DC, 2 PROFINET ports, onboard I/O: 14 DI 24 V DC; 10 DO 24 V DC; 0.5A; 2 AI 0-10 V DC, 2 AO 0-20 mA DC, Power supply: DC 20.4-28.8V DC, Program/data memory 125 KB	\r\n	\r\n6AV2124-0GC01-0AX0	\r\nSIMATIC HMI TP700 Comfort, Comfort Panel, Touch operation, 7\" widescreen TFT display, 16 million colors, PROFINET interface, MPI/PROFIBUS DP interface, 12 MB configuration memory, Windows CE 6.0 (Microsoft Support included Security updates discontinued) configurable from WinCC Comfort V11	\r\n	\r\n	\r\n	\r\n	\r\n', 'received', '2020-05-20', 0, '2020-11-29 23:06:51', '2020-11-29 23:06:51', 16),
(107, 'P-062-071', 0, 41, '132000000', 'Centrifugal Pump LKH 25/198 mm/11 kW/SSS, Union SMS connection	\r\nCapacity : 65 m³/hr @ 42 m head	\r\nDetail specification attached	\r\n', 'received', '2020-06-26', 0, '2020-11-29 23:09:37', '2020-11-29 23:09:37', 16),
(108, 'P-063-073-06', 0, 14, '11918500', 'Motor Circuit Breaker 3P 380 VAC 32A - GV2ME25	Motor Circuit Breaker 3P 380 VAC 32A\r\nAuxalary breaker 1NO 1NC - GVAE11	Auxalary breaker 1NO 1NC\r\nMCB Schneider IC60N 2Pole 4A	MCB Schneider IC60N 2Pole 4A\r\nMCB IC60N 1pole 4 A 	MCB IC60N 1pole 4 A \r\nRelay + socket 24 VDC , 2 co - RXM4AB2BD	Relay + socket 24 VDC , 2 co\r\nTimer, power 24vdc - H3CR	Timer, power 24vdc\r\nRelay + socket 220 VAC, 2 co - RXM4AB1P7	Relay + socket 220 VAC, 2 co\r\nPower Supply 100-240VAC/24VDC, 5A - EDR-120-24	Power Supply 100-240VAC/24VDC, 5A\r\nWarning Light - Red - LTD-1101	Warning Light - Red\r\nSelector Switch 2 posisi + 1 contac NO - XB5D21	Selector Switch 2 posisi + 1 contac NO\r\nFan and Filter 4\"	\r\n	\r\nSMI Kabel YSLY 4x0.75	\r\nSMI Kabel LiYcY 3x0.75	\r\n', 'received', '2020-06-30', 0, '2020-11-29 23:12:59', '2020-11-29 23:12:59', 16),
(109, 'P-064-078', 0, 42, '216098960', 'Liquiphant FTL33	\r\n\"Model no.: FTL33-6PC6/0\r\n(FTL33-AA4U3AB3CJ+L3)\"	\r\n	\r\n	\r\nDeltapilot M FMB50	\r\n\"Model no.: FMB50-KDT6/0\r\n(FMB50-AA22IA1HGBUNJB3U)\"	\r\n	\r\n	\r\nPromag 10H22, DN25 1” ODT,SMS,ANSI,ISO	\r\n\"Model no.: 10H22-1056/125\r\n(10H22-5F0A1AA0A4AA)\"	\r\n	\r\nElectromagnetic flowmeter with PFA liner	\r\n', 'received', '2020-07-23', 0, '2020-11-29 23:15:23', '2020-11-29 23:15:23', 16),
(110, 'P-001-006', 0, 11, '28000000', 'Assembly MFP14-PPU PACKAGED PUMP UNIT\r\n40MM PN16 SIMPLEX', 'received', '2019-10-06', 0, '2020-11-30 01:08:55', '2020-11-30 01:08:55', 16),
(111, 'P002/Q88-2019/057', 0, 12, '1865600', 'MINOX 2\" BUTTERFLY VALVE C/W EPDM GASKET AND PULL HANDLE, WELD END SS316L	\r\nMINOX 2\" SMS BLANK NUT C/W CHAIN, SS316L	\r\n', 'received', '2020-01-27', 0, '2020-11-30 21:08:08', '2021-03-05 03:27:57', 16),
(112, 'P004/Q3-2019/003', 0, 44, '217800', 'SMS/3A Blank Ferrule SS 316L dia. 1\"-1.5\"	\r\nSocket SS 316 dia. 1/4\" BSPT	\r\n', 'received', '2019-05-21', 0, '2020-11-30 21:11:48', '2021-03-07 22:17:55', 16),
(113, 'P004/Q22-2019/021', 0, 44, '6543900', 'Pipa CS Sch. 40 Seamless dia. 3\" x 6 meter	\r\nPipa CS Sch. 80 Seamless dia. 3\" x 6 meter	\r\nEqual Tee CS Sch. 40 Seamless dia. 3\"	\r\nFlange CS JIS 10K STD dia. 3\"	\r\nBlind Flange CS JIS 10K STD dia. 4\"	\r\n', 'received', '2019-07-15', 0, '2020-11-30 21:13:55', '2021-03-07 22:22:26', 16),
(114, 'P004/Q63-2019/044', 0, 44, '62257360', 'Actuator for Butterfly Valve 1\"-3\" SS 304 Single Effect type S1 - Taiwan	\r\nPipa Sanitary Heat Treated SS 304L NFA-49249 dia. 1\" x 1.20mm x 6 Meter	\r\nPipa Sanitary Heat Treated SS 304L NFA-49249 dia. 1.5\" x 1.20mm x 6 Meter	\r\nPipa Sanitary Heat Treated SS 316L NFA-49249 dia. 2\" x 1.20mm x 6 Meter	\r\nPipa Sanitary Heat Treated SS 316L NFA-49249 dia. 2.5\" x 1.20mm x 6 Meter	\r\nPipa Sanitary Heat Treated SS 316L NFA-49249 dia. 3\" x 1.60mm x 6 Meter	\r\nSMS Elbow Sanitary 90\' SS 316L (R=1.5D) dia. 2.5\"	\r\nSMS Reducing Tee Sanitary Extruded (Short) SS 316L dia. 2\"x1\"	\r\nSMS Reducing Tee Sanitary Extruded (Short) SS 316L dia. 2.5\"x1\"	\r\n3A Reducing Tee Sanitary Expanding (Long) SS 316L dia. 4\"x1.5\"	\r\nSMS Reducing Tee Sanitary Extruded (Short) SS 316L dia. 4\"x2.5\"	\r\n3A Reducing Tee Sanitary Expanding (Long) SS 316L dia. 3\"x1\"	\r\nUnion Complete SMS SS 304L (EPDM) dia. 1\"	\r\nUnion Complete SMS SS 304L (EPDM) dia. 1,5\"	\r\nUnion Complete SMS SS 304L (EPDM) dia. 2\"	\r\nUnion Complete SMS SS 316L (EPDM) dia. 2.5\"	\r\nUnion Complete SMS SS 316L (EPDM) dia. 3\"	\r\nUnion Complete SMS SS 316L (EPDM) dia. 4\"	\r\nSMS/3A Blank Ferrule SS 316L dia. 6\"	\r\nSMS Ferrule W elding SS 316L dia. 6\" x 28.6mm	\r\nSMS/3A EPDM Gasket for Ferrule dia. 6\"	\r\nHeavy Clamp for Ferrule (Single Pin) SS 304 dia. 6\"	\r\nSMS Ferrule W elding SS 316L dia. 1/2\" x 12.70mm	\r\nSMS/3A EPDM Gasket for Ferrule dia. 1/2\"	\r\nHeavy Clamp for Ferrule (Single Pin) SS 304 dia. 1/2\"-3/4\"	\r\nSMS/3A Blank Ferrule SS 316L dia. 1/2\"-3/4\"	\r\nSMS Ferrule W elding SS 316L dia. 3\" x 21.5mm	\r\nSMS/3A EPDM Gasket for Ferrule dia. 3\"	\r\nHeavy Clamp for Ferrule (Single Pin) SS 304 dia. 3\"	\r\nSMS Con.Reducer SS 304L dia. 2\"x1\"	\r\nSMS Con.Reducer SS 304L dia. 2\"x1.5\"	\r\nSMS Con.Reducer SS 304L dia. 3\"x2\"	\r\nSMS Con.Reducer SS 304L dia. 3\"x2.5\"	\r\n', 'received', '2019-10-18', 0, '2020-11-30 21:17:11', '2021-03-07 23:34:01', 16),
(115, 'P004/Q76-2019/046', 0, 44, '20872500', 'Actuator for Butterfly Valve 1\"-3\" SS 304 Single Effect type S1 - Taiwan	\r\nOperator	\r\n	\r\n(Work doing from 23-25 November 2019 Located at PT Mahakam Beta Farma)	\r\n	\r\n', 'received', '2019-11-22', 0, '2020-11-30 21:19:40', '2021-03-07 23:38:10', 16),
(116, 'P-004/Q79-2019/046-rev', 0, 44, '22165000', 'Rental MC Orbitalatum Complete Set 	\r\nOperator	\r\nBoroscope (included reporting Hardcopy & softcopy)	\r\n	\r\n(Work doing for Orbital  from 30 Nov - 1Des 2019 Located at PT Mahakam Beta Farma)	\r\n(Work doing for Boroscope at 2 Desember 2019 Located at PT Mahakam Beta Farma)	\r\n', 'received', '2019-11-28', 0, '2020-11-30 21:22:20', '2021-03-07 23:39:31', 16),
(117, 'P006/Q9-2019/011', 0, 46, '4740450', 'Element P-SRF C 05/30	\r\n', 'received', '2019-06-19', 0, '2020-11-30 21:32:10', '2021-03-08 00:29:32', 16),
(118, 'P006/Q30-2019/029', 0, 46, '6142950', 'Element SRF V 10/3 P7	\r\n', 'received', '2020-07-23', 0, '2020-11-30 21:45:19', '2021-03-08 00:30:52', 16),
(119, 'P007/Q5-2019/006', 0, 13, '1171800', 'Gasket SWG SS304 Flange PN16	\r\n2\"	\r\n1.5\"	\r\n1\"	\r\n1/2\"	\r\n', 'received', '2019-10-06', 0, '2020-11-30 21:49:13', '2021-03-08 00:54:27', 16),
(120, 'P007/Q27-2019/021', 0, 13, '1300000', 'Gasket SWG SS304 Flange Jis10K	\r\n2\"	\r\n3\"	\r\n', 'received', '2019-07-18', 0, '2020-11-30 21:52:09', '2021-03-08 00:56:16', 16),
(121, 'P008/Q14-2019/021', 0, 15, '20680000', 'Calibration Pressure Transmitter	\r\nEndress+Hauser PTP35-A1C17P1DB4C	\r\n	\r\nCalibration Temperature Transmitter	\r\nEndress+Hauser TMT180-A113ACA	\r\n	\r\nCalibration Temperature Transmitter	\r\nEndress+Hauser TMR35-A1BADBAA3D	\r\n	\r\nAccommodation and Transportation	\r\n', 'received', '2019-01-07', 0, '2020-11-30 22:06:44', '2021-03-08 01:01:10', 16),
(122, 'P009/Q49-2019/040', 0, 47, '25000000', 'Cutting Silo Tank Cap. 60m3 at PnG Indonesia	\r\nPlant Karawang	\r\n', 'received', '2019-09-14', 0, '2020-11-30 22:09:27', '2021-03-08 01:06:43', 16),
(123, 'P009/Q68-2019/046', 0, 47, '30000000', 'Installation Cost for Extended PW Loop	\r\nto RnD & QC - MBF	\r\n', 'received', '2019-10-25', 0, '2020-11-30 22:11:19', '2021-03-08 01:08:07', 16),
(124, 'P010/Q65-2019/048', 0, 48, '50600000', 'PEMS060111000E\r\nPEMS DN06/EPDM MicroCL. Dr./x1Lisse\r\nPEMS type manual sampling valve\r\nInstantaneous dismantling of head and diaphragm\r\nDiameter : DN06\r\nOperating temperature: +1°C to 120°C\r\nOperating pressure: from 0.1 to 6.0 bar\r\nIntake connection : Micro-Clamp (Ø25 mm)\r\nOutlet connection : Smooth nozzle to weld\r\nFlame sterilization\r\n1.4404 stainless steel – EPDM membrane compliant with FDA CFR 21.177.2600 and 1935/2004/CE regulation.\r\nAncienne référence PES06206E', 'received', '2019-10-22', 0, '2020-11-30 22:13:24', '2021-03-08 01:52:25', 16),
(125, 'P002/Q66-2019/057', 0, 12, '13721400', 'Recoder KRN100-06000-00-0S	\r\n	\r\nPresure sensor PSQ-C1CU-R1/8	\r\n	\r\n', 'received', '2020-01-16', 0, '2020-11-30 22:16:53', '2021-03-08 02:15:28', 16),
(126, 'P013/Q75-2019/044-rev', 0, 17, '2585000', 'Supply Box Stainless (Hairline), (Indoor Type)	\r\nDim : H=400 x W=300 x D=220	\r\n', 'received', '2019-11-20', 0, '2020-12-01 01:09:01', '2021-03-08 02:17:48', 16),
(127, 'P014/Q19-2019/055', 0, 50, '3078075', 'ATV310HU22N4E 2.2kW 3 Phase 380V\r\n', 'received', '2020-03-19', 0, '2020-12-01 01:19:25', '2021-03-08 02:19:35', 16),
(128, 'P016/Q4-2019/008', 0, 52, '5370', 'DI, E-Cell Stack, MK3-MiniHT	\r\nSingle Phase DC Power Suppluy	\r\nIP-CY200PVB (Transformer Required)	\r\nInput 220Vac, Max. Output 200VDC @10A	\r\n	\r\n', 'received', '2020-05-31', 0, '2020-12-01 01:31:19', '2021-03-08 02:22:03', 16),
(129, 'P016/Q19-2019/008', 0, 52, '430', 'Single Channel Display Board	\r\nModel: IP-CYDSP1 - 220Vac	\r\n', 'received', '2019-08-07', 0, '2020-12-01 01:39:33', '2021-03-08 02:24:33', 16),
(130, 'P16/Q28-2019/026', 0, 52, '420', 'Filmtec RO Membrane 	\r\nModel: HSRO-4040-FF	\r\n', 'received', '2020-07-20', 0, '2020-12-01 01:44:59', '2021-03-08 02:25:40', 16),
(131, 'P18/Q15-2019/024', 0, 54, '11165000', 'Burkert Flow controller Type 8025 panel mounting	\r\nType	8025-0000-0000-00-C-F4-E-BCV/DC-A\r\nInput power 	12-30 VOLTS\r\noutput signal 	 CURRENT 4-20MA  +  PULSE OUT PUT\r\nID Number	00419 538\r\n', 'received', '2019-04-07', 0, '2020-12-01 02:30:05', '2021-03-08 02:28:06', 16),
(132, 'PAT/Q16-2019/023', 0, 59, '2910000', 'Burkert Flow Hall Sensor type SE 30	\r\nType	SE30-0000-PC00-R3-B-F3-L-BDN/DC-Z\r\nbody material 	POLYPHENYLENSULFID\r\nElectrical	IP65, PLUG, DIN 436 50, PG9\r\nVoltage 	12-36 VOLTS DC\r\noutput signal 	OPEN COLLECTOR PNP/NPN\r\nId Number	00423913\r\n	\r\n', 'received', '2019-03-07', 0, '2020-12-01 03:10:28', '2021-03-08 02:35:03', 16),
(133, 'PAT/Q73-2019/044', 0, 59, '8924000', 'Burkert Solenoid valve 3/2 way  (1 block 5 valve) 	\r\nType	5470-C04,0-FM07-TA22-B0-024/DC-01  *\r\nBody Material	POLYAMIDE & Aluminium Sub Base\r\nInput Air	G 1/4\"\r\nOut Put Air	G1/8\r\nIn put Power	24 VDC\r\nPressure Range	0 to 10 bar\r\nId Number	135203 x 5, 132517 x1, 132516 x1   + Left (132512) & Right Module (132514)\r\n	\r\n', 'received', '2019-11-20', 0, '2020-12-01 03:12:21', '2021-03-08 02:36:09', 16),
(134, 'P019/Q13-2019/017', 0, 55, '1760000', 'Engineering	\r\nScope of Work:	\r\nPenambahan Program CIP	\r\nPenambahan Step Program CIP dengan detergen	\r\nMerubah setting mode recipe CIP	\r\nNote: Jumlah hari berdasarkan time sheet	\r\n	\r\nTransportation	\r\n', 'received', '2019-06-29', 0, '2020-12-01 03:31:32', '2021-03-08 02:44:23', 16),
(135, 'P020/Q033-2019/021', 0, 56, '55000000', 'Preparation Material for 9 Tank Lead down PT Jotun Indonesia	\r\n', 'received', '2019-07-24', 0, '2020-12-01 03:33:05', '2021-03-08 03:20:38', 16),
(136, 'P021/Q018-2019/021', 0, 18, '13750000', 'DC Inverter Pulse TIG Welding Machine	\r\nMerk WEIRO Type Super TIG-250P	\r\nAssesories:	\r\nTig Torch, Base Metal Side Cable,  Argon Hose, Argon Regulator	\r\nWaranty 1years, included service	\r\n	\r\n', 'received', '2019-08-07', 0, '2020-12-01 03:35:08', '2021-03-08 05:20:07', 16),
(137, 'P-021-058', 0, 18, '13750000', '\"DC Inverter Pulse TIG Welding Machine\r\nMerk OGHIAMA NT-200.IPH , heavy duty\r\nAssesories:\r\nTig Torch, Base Metal Side Cable, Argon Hose\r\nArgon Regulator, quick plug\"	\r\n	\r\n	\r\n	\r\n	\r\nWaranty 1years, included service	\r\n	\r\n', 'received', '2019-11-10', 0, '2020-12-01 03:36:59', '2020-12-01 03:36:59', 16),
(138, 'P031/Q18-2019/055', 0, 23, '3291200', 'Merk : CMG motor.	\r\nProduct manufacture Australia.	\r\nM32002205SGAT	\r\n2.2kW, 50Hz, 3000rpm, IP55, Mounted Flange B5 - 90L	\r\n', 'received', '2020-03-17', 0, '2020-12-01 03:38:55', '2021-03-09 04:08:22', 16),
(139, 'P033/Q84-2019/051', 0, 60, '1329900', 'Manual Globe Valve Arita	\r\nMaterial	Bronze\r\nConnection	Screw NPT/BSP\r\nClass	150\r\nCode	ARGBPN16\r\nSize	1/2\"\r\n	\r\nSwing Check Valve Arita	\r\nMaterial	Bronze\r\nConnection	Screw NPT/BSP\r\nCode 	ARSCK150\r\nSize	1/2\"\r\n	\r\nManual Ball Valve	\r\nMaterial	SS304\r\nConnection	Female Screw NPT/BSP\r\nSize	1/2\"\r\n', 'received', '2019-12-12', 0, '2020-12-01 03:42:15', '2021-03-09 04:10:06', 16),
(140, 'P033/Q7-2019/006', 0, 60, '1507220', 'Solenoid Valve for Steam/ Water	\r\nMax pressure: 16bar	\r\nConenction: BSP 3/4\"	\r\nBrand: Arita	\r\nVoltage: 220Vac - 50Hz	\r\nProtection Class: IP54/IP65	\r\nCode: Sol.ps	\r\n', 'received', '2019-12-06', 0, '2020-12-01 03:44:34', '2021-03-09 04:11:53', 16),
(141, 'P-034-045', 0, 61, '14063060', 'Burkert SE30 For High Temp	\r\nType: SE30-0000-PS00-R6-B-F3-L-BDN/DC-Z	\r\nSuply: 12..36VDC	\r\nID: 449694	\r\n	\r\nBurkert High Temp Fittings Type S030	\r\nType: S030-SA46-VAFF-P6-0-00-0-000/00-0  *	\r\nMaterial: SS316 Body & Paddle, Ligidur Axis & Bearing	\r\nPort Size: Welded ISO 4200 DN40 (48,2 X 2mm)	\r\nTemp Range: 0..125 Deg C	\r\nID: 561761	\r\n	\r\n', 'received', '2019-09-09', 0, '2020-12-01 03:52:22', '2020-12-01 03:52:22', 16),
(142, 'P-037-001', 0, 25, '45000000', 'Insulation Pipe Area 600ltr & 300ltr Line 5 PT Kalbe Farma', 'received', '2019-05-15', 0, '2020-12-04 02:41:36', '2020-12-04 02:41:36', 16);
INSERT INTO `quotation_vendors` (`id`, `code`, `purchase_request_id`, `vendor_id`, `amount`, `description`, `status`, `received_date`, `purchase_order_vendored`, `created_at`, `updated_at`, `user_id`) VALUES
(143, 'P-038-002', 0, 62, '10450000', 'Boroscope Olympus Iplex Diameter Probe Camera 6 mm, Length 8 meter + Operator (1day trip)', 'received', '2019-05-15', 0, '2020-12-04 02:44:37', '2020-12-04 02:44:37', 16),
(144, 'P-039-008', 0, 26, '11811250', '\"Acid Sanitizer based on stabilized\r\nCombination of Paracetic Acid and Hydrogenperoxide\"	\r\n	\r\n\"Concentrated cleaner based on phosphoric\r\nacid and nitric acid with wetting agents and\r\ncorrosion inhibitors for Cleaning and CIP process\"	\r\n	\r\n\"Highly alkaline cleaner, containig sequestering and\r\ncleaning agents. Suitable for use in hard water\"	\r\n	\r\n', 'received', '2019-06-17', 0, '2020-12-04 02:46:25', '2020-12-04 02:46:25', 16),
(145, 'P-039-011', 0, 26, '4186875', 'Procip A++\r\nConcentrated cleaner based on phosphoric\r\nacid and nitric acid with wetting agents and\r\ncorrosion inhibitors for Cleaning and CIP process', 'received', '2019-06-26', 0, '2020-12-04 02:48:00', '2020-12-04 02:48:00', 16),
(146, 'P-039-020', 0, 26, '1333750', 'Prodes\r\nAcid Sanitizer based on stabilized\r\nCombination of Paracetic Acid and Hydrogenperoxide', 'received', '2019-08-07', 0, '2020-12-04 02:50:10', '2020-12-04 02:50:10', 16),
(147, 'P-039-031', 0, 26, '12540000', 'Procip A++\r\n\"Concentrated cleaner based on phosphoric\r\nacid and nitric acid with wetting agents and\r\ncorrosion inhibitors for Cleaning and CIP process\"	\r\n\r\nProcip B++\r\n\"Highly alkaline cleaner, containig sequestering and\r\ncleaning agents. Suitable for use in hard water\"	\r\n', 'received', '2019-07-24', 0, '2020-12-04 02:52:21', '2020-12-04 02:52:45', 16),
(148, 'P-039-035 Rev Num. 2905/SPC/AS/287-286', 0, 26, '1739375', 'Procip A++\r\n\"Concentrated cleaner based on phosphoric\r\nacid and nitric acid with wetting agents and\r\ncorrosion inhibitors for Cleaning and CIP process\"	\r\n	\r\nProcip B++\r\n\"Highly alkaline cleaner, containig sequestering and\r\ncleaning agents. Suitable for use in hard water\"	\r\n	\r\nProdes\r\n\"Acid Sanitizer based on stabilized\r\nCombination of Paracetic Acid and Hydrogenperoxide\"	\r\n', 'received', '2019-07-25', 0, '2020-12-04 02:57:22', '2020-12-04 02:57:22', 16),
(149, 'P-039-078', 0, 26, '4743750', 'Procip A FRX\r\nLiquid Acid Cleaner	\r\n	\r\nProcip B++\r\n\"Highly alkaline cleaner, containig sequestering and\r\ncleaning agents. Suitable for use in hard water\"	\r\n', 'received', '2019-11-28', 0, '2020-12-04 03:00:02', '2020-12-04 03:00:02', 16),
(150, 'P-039-086', 0, 26, '3341250', 'Procip A++\r\n\"Concentrated cleaner based on phosphoric\r\nacid and nitric acid with wetting agents and\r\ncorrosion inhibitors for Cleaning and CIP process\"	\r\n	\r\nProcip B++\r\n\"Highly alkaline cleaner, containig sequestering and\r\ncleaning agents. Suitable for use in hard water\"	\r\n', 'received', '2019-12-20', 0, '2020-12-04 03:02:28', '2020-12-04 03:02:48', 16),
(151, 'P-040-010', 0, 27, '4764000', 'SS316 Flaneg SORF PN16 dia. 3\"	\r\nSS316 Flaneg SORF PN16 dia. 4\"	\r\n', 'received', '2019-06-25', 0, '2020-12-04 03:12:29', '2020-12-04 03:12:29', 16),
(152, 'P-040-026', 0, 27, '2610000', 'MS Flange Jis10K dia. 2\"	\r\nSS304 Flange Jis10K dia. 2\"	\r\nSS304 Flange Jis10K dia.3\"	\r\n', 'received', '2019-07-18', 0, '2020-12-04 03:14:09', '2020-12-04 03:14:09', 16),
(153, 'P-040-040', 0, 27, '6571500', 'SS304 Flange Jis10K dia. 2\"	\r\nSS304 Flange Jis10K dia.3\"	\r\nSS304 Tee Equal Sch10 Welded dia. 3\"	\r\nSS304 Elbow45degree Sch10 Welded dia. 3\"	\r\n	\r\n', 'received', '2019-07-16', 0, '2020-12-04 03:16:56', '2020-12-04 03:16:56', 16),
(154, 'P-040-048', 0, 27, '1364000', 'SS304 Flange Jis10K dia. 2\"	\r\nSS304 Flange Jis10K dia.3\"	\r\nMS Flange Jis10K dia. 2\"	\r\n	\r\n', 'received', '2019-10-09', 0, '2020-12-04 03:20:08', '2020-12-04 03:20:08', 16),
(155, 'P-040-051', 0, 27, '6068000', 'MS Flange PN40 Slip On Raised Face (RF) dia. 250mm (10\")	\r\nMS Flange PN40 Slip On Raised Face (RF) dia. 200mm (8\")	\r\nMS Flange PN40 Slip On Raised Face (RF) dia. 150mm (6\")	\r\n', 'received', '2019-09-18', 0, '2020-12-04 03:24:00', '2020-12-04 03:24:00', 16),
(156, 'P-040-055', 0, 27, '4913000', 'SS304 Flange Jis10K dia. 1/2\"	\r\nSS304 Flange Jis10K dia. 1\"	\r\nSS304 Flange Jis10K dia. 2\"	\r\nSS304 Blind Flange Jis10K dia. 2\"	\r\nSS304 Flange Jis10K dia. 3\"	\r\nSS304 Blind Flange Jis10K dia. 3\"	\r\n	\r\n', 'received', '2020-09-10', 0, '2020-12-04 03:28:02', '2020-12-04 03:28:02', 16),
(157, 'P-040-062', 0, 27, '2887000', 'MS/CS/CI Flange PN16 Slip On Raise Face (RF) \r\ndia. 32mm (1-1/4\")\r\ndia. 80mm (3\")\r\nMS/CS/CI Flange PN40 Slip On Raise Face (RF) \r\ndia. 15mm (1/2\")\r\ndia. 20mm (3/4\")\r\ndia. 40mm (1-1/2\")\r\ndia. 50mm (2\")\r\ndia. 80mm (3\")\r\ndia. 100mm (4\")\r\nMS/CS/CI Flange ANSI#300 Slip On Raise Face (RF) \r\ndia.20mm (3/4\")\r\ndia.80mm (3\")\r\n', 'received', '2019-10-18', 0, '2020-12-04 03:30:55', '2020-12-04 03:30:55', 16),
(158, 'P-040-067', 0, 27, '780000', 'MS/CS/CI Flange PN40 Slip On Raise Face (RF) \r\ndia. 20mm (3/4\")\r\ndia. 50mm (2\")\r\n', 'received', '2020-10-25', 0, '2020-12-04 03:49:46', '2020-12-04 03:49:46', 16),
(159, 'P-040-070', 0, 27, '344000', 'MS/CS/CI Flange PN40 Slip On Raise Face (RF) \r\nMS/CS/CI Flange PN40 Welding neck DN65 (2-1/2\")\r\nMS/CS/CI Flange PN16 Welding neck DN65 (2-1/2\")\r\n', 'received', '2019-06-11', 0, '2020-12-04 03:53:04', '2020-12-04 03:53:04', 16),
(160, 'P-040-072', 0, 27, '384000', 'SS304 Flange PN16 RF DN25 (1\")\r\n', 'received', '2019-11-13', 0, '2020-12-04 03:58:47', '2020-12-04 03:58:47', 16),
(161, 'P-040-085', 0, 27, '5248000', 'MS/CS/CI Flange PN16 Slip On Raise Face (RF) \r\ndia. 80mm (3\")\r\nMS/CS/CI Flange PN40 Slip On Raise Face (RF) \r\ndia. 15mm (1/2\")	\r\ndia. 40mm (1-1/2\")	\r\ndia. 50mm (2\")	\r\ndia. 80mm (3\")	\r\ndia. 100mm (4\")	\r\ndia. 250mm (10\")	\r\nMS/CS/CI Flange ANSI#300 Slip On Raise Face (RF) \r\ndia.20mm (3/4\")\r\ndia.80mm (3\")\r\n', 'received', '2019-12-18', 0, '2020-12-04 04:02:04', '2020-12-04 04:02:04', 16),
(162, 'P-041-024', 0, 63, '28050000', 'Membrane Hot Water Sanitizable	\r\nMerk: DOW-Filmtec	\r\nModel: HSRO 4040FF	\r\n', 'received', '2019-07-17', 0, '2020-12-04 04:07:10', '2020-12-04 04:07:10', 16),
(163, 'P042/Q034-2019/027', 0, 64, '5643000', 'SEAL FPM LKDC -LP 450	\r\n', 'received', '2019-07-24', 0, '2020-12-04 04:11:00', '2021-03-08 05:16:41', 16),
(164, 'P-043-044', 0, 28, '3850000', 'Rental MX4 Ventis (1month) - extended	\r\nFrom 1/9/2019 - 1/10/2019	\r\n', 'received', '2019-01-09', 0, '2020-12-04 04:12:43', '2020-12-04 04:12:43', 16),
(165, 'P-043-036', 0, 28, '3850000', 'Rental MX4 Ventis (1month)	\r\n', 'received', '2019-07-30', 0, '2020-12-04 04:14:20', '2020-12-04 04:14:20', 16),
(166, 'P-044-037', 0, 65, '8000000', 'Rent of Gantry	\r\n- Height : 3m	\r\n- Width : 2m	\r\n- Capacity : 2-5 Ton	\r\n', 'received', '2019-07-30', 0, '2020-12-04 04:16:41', '2020-12-04 04:16:41', 16),
(167, 'P-045-043', 0, 66, '4070000', '\"Pneumatic Spare Actuator Diagphram GEMU Valve DN10-20mm.\r\n(9625 10M1 1/N)\"	\r\n', 'received', '2019-08-27', 0, '2020-12-04 04:19:04', '2020-12-04 04:19:04', 16),
(168, 'P-045-060', 0, 66, '7975000', '\"Gemu Diaphargm valve model 612, 625 PTFE/EPDM, size 20 mm\r\n(DN 10-20 mm (Seat Size 10), Type 612, 625)\"	\r\n', 'received', '2019-10-16', 0, '2020-12-04 04:20:08', '2020-12-04 04:20:08', 16),
(169, 'P-002-0802019 REV1', 0, 12, '4950000', '\"Pneumatic Spare Actuator Diagphram GEMU Valve DN10-20mm.\r\n(9625 10M1 1/N)\"	\r\n', 'received', '2020-01-16', 0, '2020-12-04 04:22:01', '2020-12-04 04:22:01', 16),
(170, 'P-045-080-2', 0, 66, '9350000', '\"Pneumatic Spare Actuator 687 Diagphram GEMU Valve DN10-25mm.\r\n(9687 25Z 1 1/N +1300)\"	\r\n', 'received', '2020-02-03', 0, '2020-12-04 04:23:24', '2020-12-04 04:23:24', 16),
(171, 'P-002-0662019', 0, 12, '27500000', 'Accounting Software and Manpower installation	\r\nSoftware Contain of:	\r\n1. Dashboard	\r\n2. Project Control	\r\n3. Quotation & PO Customer control	\r\n4. PR & PO Control	\r\n5. IR & Settlements Control	\r\n6. Cash Control (Bank Account, Petty Cash, etc)	\r\n7. Transfer Task (Approval payment)	\r\n	\r\n', 'received', '2020-01-16', 0, '2020-12-04 04:26:38', '2020-12-04 04:26:38', 16),
(172, 'P-049-003', 0, 29, '790075', '\"HAFNER  SOLENOID VALVE\r\nTYPE :MH 310 701 - 1pc\r\nManifold 1valves\r\nCoil : 24VDC\"	\r\n', 'received', '2020-01-13', 0, '2020-12-04 04:28:35', '2020-12-04 04:28:35', 16),
(173, 'P-049-001', 0, 29, '7928800', '\"HAFNER  SOLENOID VALVE\r\nTYPE :MH 310 701 - 3pcs\r\nManifold 3 valves\r\nCoil : 230VAC\"	\r\n	\r\n\"HAFNER  SOLENOID VALVE\r\nTYPE :MH 310 701 - 5pcs\r\nManifold 5 valves\r\nCoil : 24VDC\"	\r\n', 'received', '2020-07-01', 0, '2020-12-04 04:29:40', '2020-12-04 04:29:40', 16),
(174, 'P-050-004', 0, 67, '2805000', 'Ball Feet SS304 dia.3\" (complete set)	\r\n', 'received', '2020-01-15', 0, '2020-12-04 04:31:54', '2020-12-04 04:31:54', 16),
(176, 'P-051-020', 0, 35, '2260000', 'SS316L Plate 100x100x3mm (dengan certificate material)	\r\nSS316L Roundbar (RB) 1-1/4” x 80mm (dengan certificate material)	\r\nSS316L Roundbar (RB) 1-1/2” x 1,000mm (dengan certificate material)	\r\nSS304L Roundbar (RB) 2-1/2” x 50mm (dengan certificate material)	\r\nSS304 Plate dia. 250mm, t=20mm (dengan certificate material)	\r\nSS304L Roundbar (RB) 1” x 150mm = 4pcs (dengan certificate material)	\r\n', 'received', '2020-01-04', 0, '2020-12-04 04:36:12', '2020-12-04 04:36:12', 16),
(177, 'P024/Q23-2019/021', 0, 19, '9599480', 'Head Gear c/w Face Shield Windos FC48 Blue Eagle	\r\nTang Buaya 10\" Tekiro	\r\nPalu Konde 1 Kg Merk AT	\r\nPalu Karet Dia.70mm RRC	\r\nPalu Plastik Dia.60mm RRC	\r\nMesin Gerinda 4\" Hitachi G10SS	\r\nObeng ( + ) 8\" Tekiro	\r\nObeng ( - ) 8\" Tekiro	\r\nTang Kombinasi 8\" Tekiro	\r\nKunci pas set 6 - 32 Tekiro	\r\nKunci Pipa 12\" Tekiro	\r\nKedok Las Blue Eagle	\r\nSarun Tangan Katun	\r\nMajun Putih	\r\nScotch Brite 3M - 7447	\r\nPickling Nikko Steel	\r\nSafety Glass	\r\nGela Ukur 1000mL (1L)	\r\npH meter Digital ex Hanna Instrument	\r\nKertas Lakmus - Johnson England	\r\nKunci Inggris 24\" Tekiro	\r\nKikir bulat 8mm	\r\nKunci L Set mm Long Ball Tekiro	\r\nTools Box 3tingkat	\r\nGerinda Tangan Makita GA-5020	\r\n', 'received', '2019-07-24', 0, '2021-03-08 21:52:38', '2021-03-08 21:52:38', 16),
(178, 'P024/Q25-2019/021', 0, 19, '832260', 'Fire Blanket 1.8mtr x 1.8mtr	\r\nBatu Cutting Metabo 5\" x 2.5mm	\r\nBatu Cutting WD 4\" x 2mm	\r\n', 'received', '2019-07-18', 0, '2021-03-08 21:54:34', '2021-03-08 21:54:34', 16),
(179, 'P024/Q32-2019/021', 0, 19, '1555840', 'APAR 6kg	\r\nRompy Safety Orange	\r\nBatu Cutting WD 4\" x 1.2mm	\r\nEar Plug	\r\nPickling Nikko Steel	\r\nSarun Tangan Katun	\r\n', 'received', '2019-07-24', 0, '2021-03-08 21:56:30', '2021-03-08 21:56:30', 16),
(180, 'P024/Q38-2019/021', 0, 19, '2335740', 'Filler SS304 3.2mm	\r\nFiller SS 308 2mm	\r\nBatu Cutting WD 4\" x 1.2mm	\r\nFiller MS 2mm	\r\n', 'received', '2019-07-31', 0, '2021-03-08 22:02:52', '2021-03-08 22:02:52', 16),
(181, 'P024/Q39-2019/021', 0, 19, '8907030', 'Sarun Tangan Katun	\r\nGasket Teflon 3mm x 1mtr x 1mtr	\r\nTungten 2.4mm (10pcs)	\r\nScotch Brite 3M - 7447	\r\nBatu Cutting WD 4\" x 2mm	\r\nSS304 Stud Bolt Full Drat M16	\r\nSS304 Flat Washer M16	\r\nSS304 Nut M16	\r\nFiller SS304 3.2mm	\r\n', 'received', '2019-08-13', 0, '2021-03-08 22:08:03', '2021-03-08 22:08:03', 16),
(182, 'P024/Q41-2019/021', 0, 19, '4092000', 'Filler SS304 3.2mm	\r\nBatu Cutting WD 4\" x 1.2mm	\r\nBatu Gerinda Tebel 4\" Resibon	\r\n', 'received', '2019-08-22', 0, '2021-03-08 22:09:50', '2021-03-08 22:09:50', 16),
(183, 'P024/Q46-2019/021', 0, 19, '3493270', 'Filler SS 308 2mm	\r\nBatu Cutting WD 4\" x 1.2mm	\r\nSS304 Stud Bolt Full Drat M16	\r\nTungten 2.4mm (10pcs)	\r\nSarun Tangan Katun	\r\n', 'received', '2019-10-09', 0, '2021-03-08 22:11:27', '2021-03-08 22:11:27', 16),
(184, 'P024/Q5-2019/034', 0, 19, '10008680', 'Filler SS 308 2mm	\r\nMesin Poles 5\" (Straight Grinder MAKITA GS 5000)	\r\nBan Poles Kain 4\"	\r\nMajun Putih Katun	\r\nScoth Brite 3M 7447 (isi 10pcs)	\r\nEar Plug Max	\r\n', 'received', '2020-01-16', 0, '2021-03-08 22:13:34', '2021-03-08 22:14:05', 16),
(185, 'P027/Q20-2019/021', 0, 20, '99213400', 'PLAT SS304 4\' X 8\'		\r\n	2MM F.2B	\r\n	3MM F.2B	\r\n	6MM F.1B	\r\n		\r\nPLAT SS304 5\' X 20\'		\r\n	10MM F.1B	\r\n		\r\n	HOLLOW SS304 6 METER 40 X 40 X 2MM	\r\n', 'received', '2019-07-14', 0, '2021-03-08 22:46:40', '2021-03-08 22:46:40', 16),
(186, 'P027/Q42-2019/021-rev 1', 0, 20, '22778250', 'PLAT SS304 4\' X 8\'		\r\n	2MM F.2B	\r\n	3MM F.2B	\r\n		\r\nPLAT BAR SS304 @6mtr		\r\n	60mm x 4mm	\r\n		\r\n', 'received', '2019-08-27', 0, '2021-03-08 22:49:20', '2021-03-08 22:49:20', 16),
(187, 'P027/Q53-2019/045', 0, 20, '5082000', 'Angle Bar SS304  @6mtr		\r\n	50x50x5mm @6mtr	\r\n', 'received', '2019-09-10', 0, '2021-03-08 22:51:26', '2021-03-08 22:51:26', 16),
(188, 'P027/Q54-2019/046', 0, 20, '7502000', 'PLAT BAR SS304 @6mtr		\r\n	40mm x 3mm	\r\n		\r\nSQUARE TUBE SS304 @6mtr		\r\n	40mm x 40mm x 2mm	\r\n		\r\n', 'received', '2019-09-10', 0, '2021-03-08 22:53:20', '2021-03-08 22:53:20', 16),
(189, 'P027/Q57-2019/042', 0, 20, '6776000', 'SS304 Pipe Sch10 Welded @6mtr		\r\n	dia. 1/2\"	\r\n	dia. 1\"	\r\n	dia. 2\"	\r\n	dia. 3\"	\r\n', 'received', '2019-10-10', 0, '2021-03-08 22:54:46', '2021-03-08 22:54:46', 16),
(190, 'P027/Q59-2019/045', 0, 20, '1270500', 'Angle Bar SS304  @6mtr		\r\n	50x50x5mm @6mtr	\r\n		\r\n', 'received', '2019-10-16', 0, '2021-03-08 22:56:17', '2021-03-08 22:56:17', 16),
(191, 'P027/Q87-2019/034', 0, 20, '27324000', 'PLAT SS304 4\' X 8\'		\r\n	3mm F.2B	\r\n	4mm F.1B	\r\n		\r\nSQUARE TUBE SS304 @6mtr		\r\n	80mm x 80mm x 3mm	\r\n		\r\nRECTANGULAR TUBE SS304 @6mtr		\r\n	80mm x 40mm x 2mm	\r\n', 'received', '2020-07-01', 0, '2021-03-08 22:58:13', '2021-03-08 22:58:13', 16),
(192, 'P027/Q88-2019/034', 0, 20, '27716700', '		\r\n	SS201 Ordinary Pipe dia. 1,5\" x t=1.5mm @6mtr	\r\n	SS201 Ordinary Elbow dia. 1.5\"	\r\n		\r\nPLAT SS304 4\' X 8\'		\r\n	8mm F.1B	\r\n	4mm F.1B	\r\n		\r\nRECTANGULAR TUBE SS304 @6mtr		\r\n	80mm x 40mm x 2mm	\r\n		\r\n', 'received', '2020-07-01', 0, '2021-03-09 00:46:12', '2021-03-09 00:46:12', 16);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `code`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'SUP', 'Super Admin', 'User with this role will have full access to apllication', NULL, NULL),
(2, 'ADM', 'Administrator', 'User with this role will have semi-full access to apllication', NULL, NULL),
(3, 'HRD', 'Human Resource Development', 'User with this role will have full access to HRD modules', NULL, NULL),
(4, 'WRH', 'Warehouse', 'User with this role will have full access to warehouse modules', NULL, NULL),
(5, 'MKT', 'Marketing', 'User with this role will have full access to marketing modules', NULL, NULL),
(6, 'SAL', 'Sales', 'User with this role will have full access to sales modules', NULL, NULL),
(7, 'ENG', 'Engineer', 'User with this role will have full access to engineer modules', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(7, 8),
(7, 9),
(7, 10),
(7, 11),
(7, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `settlements`
--

CREATE TABLE `settlements` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `remitter_bank_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settlements`
--

INSERT INTO `settlements` (`id`, `code`, `internal_request_id`, `transaction_date`, `description`, `category_id`, `sub_category_id`, `amount`, `result`, `status`, `last_updater_id`, `accounted`, `created_at`, `updated_at`, `accounted_approval`, `remitter_bank_id`) VALUES
(1, 'SET-IR-00001', 1, '2020-07-01', 'test', 0, 0, '5000.00', 'clear', 'approved', 13, 1, '2020-07-27 00:52:58', '2020-07-27 01:12:26', 'approved', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settlement_payrolls`
--

CREATE TABLE `settlement_payrolls` (
  `id` int(10) UNSIGNED NOT NULL,
  `settlement_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'the creator of the task',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date_schedule` date DEFAULT NULL,
  `finish_date_schedule` date DEFAULT NULL,
  `status` enum('draft','ongoing','completed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_assignees`
--

CREATE TABLE `task_assignees` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `working_hour` decimal(20,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `the_logs`
--

CREATE TABLE `the_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `source` enum('internal_request','cashbond','settlement','invoice_vendor','invoice_customer','quotation_customer','quotation_vendor') COLLATE utf8_unicode_ci DEFAULT NULL,
  `mode` enum('create','update','delete','approve','reject') COLLATE utf8_unicode_ci DEFAULT NULL,
  `refference_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `the_logs`
--

INSERT INTO `the_logs` (`id`, `source`, `mode`, `refference_id`, `user_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'internal_request', 'create', 1, 13, NULL, '2020-07-27 00:47:08', '2020-07-27 00:47:08'),
(2, 'internal_request', 'update', 1, 13, 'Change status from pending to approved', '2020-07-27 00:47:54', '2020-07-27 00:47:54'),
(3, 'settlement', 'create', 1, 13, NULL, '2020-07-27 00:52:58', '2020-07-27 00:52:58'),
(4, 'settlement', 'update', 1, 13, 'Change status from pending to approved', '2020-07-27 00:53:20', '2020-07-27 00:53:20'),
(5, 'internal_request', 'update', 1, 13, 'Transfered to requester', '2020-07-27 01:01:03', '2020-07-27 01:01:03'),
(6, 'invoice_vendor', 'create', 1, 13, '&nbsp;', '2020-07-27 01:05:44', '2020-07-27 01:05:44'),
(7, 'invoice_vendor', 'update', 1, 13, 'approved invoice vendor to be registered to transfer task', '2020-07-27 01:09:52', '2020-07-27 01:09:52'),
(8, 'invoice_vendor', 'update', 1, 13, 'Transfered to vendor', '2020-07-27 01:10:37', '2020-07-27 01:10:37'),
(9, 'settlement', 'update', 1, 13, 'approved to be registered to transfer task', '2020-07-27 01:12:20', '2020-07-27 01:12:20'),
(10, 'settlement', 'update', 1, 13, 'Transfered', '2020-07-27 01:12:26', '2020-07-27 01:12:26'),
(11, 'invoice_vendor', 'create', 2, 16, '&nbsp;', '2020-07-27 02:16:38', '2020-07-27 02:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `time_reports`
--

CREATE TABLE `time_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `period_id` int(11) NOT NULL,
  `the_date` date NOT NULL,
  `type` enum('usual','week_end','day_off') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_report_user`
--

CREATE TABLE `time_report_user` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `accounting_expense_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `cash_id`, `refference`, `refference_id`, `refference_number`, `type`, `amount`, `created_at`, `updated_at`, `notes`, `reference_amount`, `transaction_date`, `accounting_expense_id`) VALUES
(1, 1, 'internal_request', 1, 'IR-00001', 'debet', '5000.00', '2020-07-27 01:01:03', '2020-07-27 01:01:03', 'test ', '995000.00', '2020-07-27', NULL),
(2, 1, 'invoice_vendor', 1, '001(TEST)', 'debet', '1000.00', '2020-07-27 01:10:37', '2020-07-27 01:10:37', '', '994000.00', '2020-07-27', 4),
(3, 1, 'settlement', 1, 'SET-IR-00001', 'debet', '0.00', '2020-07-27 01:12:26', '2020-07-27 01:12:26', 'test', '994000.00', '2020-07-27', NULL),
(4, 1, 'invoice_customer', 1, 'INV-20-07-001', 'credit', '250000.00', '2020-07-27 01:26:51', '2020-07-27 01:26:51', NULL, '1244000.00', NULL, NULL),
(5, 1, 'invoice_customer', 2, 'INV-20-07-002', 'credit', '1000.00', '2020-07-27 01:51:36', '2020-07-27 01:51:36', NULL, '1245000.00', NULL, NULL),
(6, 1, 'invoice_customer', 3, 'INV-20-07-003', 'credit', '99000.00', '2020-07-27 02:01:04', '2020-07-27 02:01:04', NULL, '1344000.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `competency_allowance` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `nik`, `type`, `salary`, `man_hour_rate`, `status`, `profile_picture`, `eat_allowance`, `eat_allowance_non_local`, `transportation_allowance`, `transportation_allowance_non_local`, `medical_allowance`, `bpjs_tk`, `bpjs_ke`, `remember_token`, `created_at`, `updated_at`, `incentive_week_day`, `incentive_week_end`, `position`, `work_activation_date`, `has_workshop_allowance`, `workshop_allowance_amount`, `additional_allowance`, `competency_allowance`) VALUES
(5, 'Juan Mata', 'mata@email.com', '$2y$10$gGH0GSoCpoDZ8Fb9TIkqZuO5eIRvkG10852UYVsNCX25xLspAkanS', 'A-0005', 'office', '5000000.00', '10000.00', 'active', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, 0, '0.00', '0.00', '0.00'),
(14, 'Admin', 'id.nurrohman@gmail.com', '$2y$10$xO0I9cju26.QSyHI9txxl.a4c8XMpsMk7sthXjYr9TzRTqyrtx1fa', '370110307960003', 'office', '10000.00', '0.00', 'active', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'XM80LYpffQfoFooaijLvOzMjWb0YQJpM848ZIClvScss9NLfHiSWvKDjmFo5', '2020-06-08 21:56:12', '2021-03-07 20:16:01', '0.00', '0.00', 'Electrical Engineer', '2020-01-01', 0, '0.00', '0.00', '0.00'),
(15, 'Farid Ramadhan', 'faridramadhan3611@gmail.com', '$2y$10$bgaKCKgiTlBbtnHm3KYr4efwdcRvovuPoC82C8Pt9dmpogXHNE6QG', '3671030301000002', 'office', '3000000.00', '15000.00', 'active', NULL, '50000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, '2020-06-24 02:54:53', '2020-06-24 03:00:44', '0.00', '0.00', 'admin', '2019-03-01', 0, '0.00', '0.00', '0.00'),
(16, 'Nena', 'admin01@sb-tech.id', '$2y$10$BGNLpiQfvy0hnOgOSHe5K.I0Z3NgHSZl9XlzgIugA7S2t2H6WydnK', '002', 'office', '1.00', NULL, 'active', '1614660812.jpeg', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'AiD3ccMuE9pmvHTermy8kWvPaT6VAI6A60FTz3YoBiBefBWzqMRIQ75kZq0F', '2020-07-27 01:16:09', '2021-03-09 19:41:21', '0.00', '0.00', 'Admin', '0000-00-00', 0, '0.00', '0.00', '0.00'),
(17, 'Andryansyah', 'andryansyah@sb-tech.id', '$2y$10$.ZsM/DF4hxrbnVs/fDaqcO97dxzdn75iYbngbqKUgKLCbdNtjJrDC', '003', 'office', '1.00', NULL, 'active', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '1q8VVs5biN3Y1HxyOhB2sor6fz6r8jUDDhR3vqPA5hvUbt0MKQNoDRyQ7UAx', '2020-07-27 01:17:30', '2020-07-27 01:19:10', '0.00', '0.00', 'Admin', '0000-00-00', 0, '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_term_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `product_name`, `bank_account`, `created_at`, `updated_at`, `phone`, `address`, `payment_term_days`) VALUES
(11, 'Agus Cahyana', 'Assembly Header & Frame MFP14-PPU PACKAGED PUMP UNIT 80x50MM PN16 TRIPLEX', 'Belum Ada', '2020-08-05 20:53:30', '2020-09-12 00:09:59', '081380550164', 'Jl. Sokamerah 3 No. 26  Harapan Baru Regency Bekasi Barat', 0),
(12, 'PT Minox Indonesia', 'Sanitary stainless steel valves, Tubes & Fittings', 'Belum Ada', '2020-08-06 00:47:26', '2020-08-06 00:51:28', '021 87953901 - 3902', 'Kp. Leuwi Jambe Rt. 006 Rw. 003 Desa Kadumanggu  Babakan Madang Kab. Bogor  16811', 0),
(13, 'Hermanto', 'CS SWG Gasket, Pressure gauge WIKA', 'Belum Ada', '2020-08-06 01:01:22', '2020-08-06 01:03:26', '081316227025', 'Lindeteves Trade Center Jl. Hayam Wuruk No. 127 Jakarta', 0),
(14, 'PT Dua Putera Indo Sejahtera', 'FMB50-KDT6/0, Motor Circuit Breaker 3P 380 VAC 32A - GV2ME25, Auxalary breaker 1NO 1NC - GVAE11, MCB Schneider IC60N 2Pole 4A, MCB IC60N 1pole 4 A , Relay + socket 24 VDC , 2 co - RXM4AB2BD, Timer, power 24vdc - H3CR, Relay + socket 220 VAC, 2 co - RXM4AB', 'Belum Ada', '2020-08-06 01:06:10', '2020-08-10 23:40:28', '082125843834', 'Plaza Kenari mas LTF2 Blok G. 27 Jl. Kramat Raya No. 101 Paseban, Senen, Jakarta Pusat DKI Jakarta', 0),
(15, 'PT Endress Hauser Indonesia', 'FTL33-1369/0  ', 'Belum Ada', '2020-08-06 01:22:51', '2020-08-06 01:25:21', '021 7975083', 'Multika Building Lt. 3 Ruang #300 Jl. Mampang Prapatan Raya No. 71-73 Tegal Parang', 0),
(16, 'PT Sahabat Jaya Bersama', 'Temp control TK4S-14RN, Ink Catridge D33006B-66X-01, ', 'Belum Ada', '2020-08-06 01:30:02', '2020-08-06 01:33:24', '021 89970805, 806, 807', 'Ruko Palais de Paris Blok C No. 7 Kota Delta Mas, Cikarang Pusat', 0),
(17, 'CV Anugrah Multi Solusi Teknik', 'Supply Box', 'Belum Ada', '2020-08-06 01:35:45', '2020-08-06 01:37:54', '021 86862730, 86863038', 'Jl. Raya Narogong, Klapanunggal Km. 7 No. 86', 0),
(18, 'CV Entariomy Enterprise', 'DC Inverter Pulse TIG Welding Machine Merk WEIRO', 'Belum Ada', '2020-08-06 01:39:45', '2020-08-06 01:43:17', '021 5404652', 'Citra Garden 2 Blok C2 No. 3 Kalideres, Jakarta Barat Indonesia', 30),
(19, 'Karya Maju Manggala', 'Kaca Face Shield, Majun Putih Katun, Filler, Flexible Ultraflex, Ban Poles, Ear Plug Max, Batu Gerinda', 'Belum Ada', '2020-08-06 01:47:07', '2020-08-06 01:51:27', '021 6264589, 6249708, 6248719 fax. 6264589', 'Komp. Glodok Jaya Lt. IV - A8-9 Jalan Hayam Wuruk Jakarta 11180', 14),
(20, 'PT Gatra Mapan Mandiri', 'SS304 Square Tube, Aluminium Plat Bordes, RECTANGULAR TUBE SS304', 'Belum Ada', '2020-08-06 21:21:06', '2020-08-06 21:27:07', '021 5603426, 5668354, 5689507 Fax 021 5640467', 'Jalan P. Jayakarta 66/A-9 Jakarta 10730, Indonesia', 0),
(21, 'PT Gamako Eka Karsa', 'HITACHI GLOBE VALVE ECONOMICAL', 'Belum Ada', '2020-08-06 21:53:22', '2020-08-06 21:57:10', '021 6900591, 6902761, 6902756 fax 021 6900720', 'Jl. Pinangsia Timur No. 44 Rt. 004 Rw. 005 Taman Sari Jakarta Barat, DKI Jakarta 11110', 0),
(22, 'PT Permata Anugerah Elektrindo', 'Kabel SMI YSLY, Kabel Ethernet Cat6 - Belden', 'Belum Ada', '2020-08-06 22:00:08', '2020-08-06 22:03:14', '081319284215, 0878808087009', 'LTC Glodok, Jl. Hayam Wuruk Lt. 1 C1 No. 7 Jakarta Barat 11180\r\n\r\nAttn. Bram Wihardja', 0),
(23, 'PT Dinamika Selaras Engineering', ' Dinflo Pump', 'Belum Ada', '2020-08-06 22:05:27', '2020-08-06 22:10:23', '021 8747877, fax 021 8743885', 'Jl. Apel Raya Blok B.III No. 15 Sukamaju Baru  Depok 16455\r\n\r\nAttn. Nalis Gunawan ', 0),
(24, 'PT Cipta Multi Bersama', 'Elbow ASME BPE SFT 1 GHWA SS 316L, Ferrule ASME BPE SFT 1 GHWA SS 316L ', 'Belum Ada', '2020-08-06 22:19:07', '2020-09-12 00:03:01', '021 9448932, 33 Fax 29518914 ', 'Jl. Pesing Polgar, Blok C No. 6 Jakarta Barat\r\n\r\nemail. \r\nputri.cmbsanitary@gmail.com', 0),
(25, 'Rudi Rosali', 'Hot Insulation Piping Line 2 PT Kalbe Farma Delta Silicon Cikarang', 'Belum Ada', '2020-08-06 22:23:22', '2020-08-06 22:24:07', '081380550164', 'NA', 0),
(26, 'PT Protekindo Sanita', 'Concentrated cleaner based on phosphoric acid and nitric acid with wetting agents and corrosion inhibitors for Cleaning and CIP process, Highly alkaline cleaner, containig sequestering and cleaning agents. Suitable for use in hard water', 'Belum Ada', '2020-08-06 23:05:40', '2020-08-06 23:12:58', '021 3106767, Fax. 021 3102256 Attn. Enggus', 'Jl. Teuku Cik Ditiro No. 16 Jakarta 10350', 0),
(27, 'PT Asia Sarana Katup', 'SS304 Blind Flange ANSI, SS304 Flange ANSI, SS304 Socket BSP, CS Concentric Reducer Sch40 Seamless,  CS Tee Equal Sch40 Seamless 1/2\", SS316 Concentric Reducer sch40 Welded', 'Belum Ada', '2020-08-06 23:28:25', '2020-08-06 23:34:59', '021 62200650, fax 021 62200649 Attn Wawan Mr', 'LLTC Glodok Blok GF2 A3 No. 7&8, Jalan Hayam Wuruk No. 127 Jakarta 11180', 0),
(28, 'PT Teknokraftindo Asia', 'Rental MX4 Ventis ', 'Belum Ada', '2020-08-06 23:40:17', '2020-08-06 23:49:39', '021 7805402 fax. 021 7808016 attn. Sandy Rizki', 'The Garden Center Building Suite #5-11, Cilandak Commercial Estate, Jl. Raya Cilandak KKO , Jakarta 12560, Indonesia\r\n\r\nEmail \r\ntekno111@radnet.id', 0),
(29, 'PT Karya Tengahan Selaras', 'Burkert Flow Controller Type 8025, Burkert High Temp Fittings SE 30 (Paddle Wheel only), HAFNER , HAFNER  SOLENOID VALVE, SOLENOID VALVE', 'Belum Ada', '2020-08-06 23:53:37', '2020-08-07 00:15:06', '021 29379612, Fax. 021 66690771 attn. Manise Udiwihardjo (Anis)', 'Lindeteves Trade Center, Lantai UG, Blok B19/6 Jakarta Barat 11180 - Indonesia\r\n\r\nemail:\r\nkaryatengahselaras78@gmail.com', 0),
(30, 'PT Berkah Mulia Teknik', 'FMB70-1FR3/0, FMB70-ACR1F1200CAA Deltapilot S FMB70', 'Belum Ada', '2020-08-07 00:17:21', '2020-09-12 00:02:02', '021 85909215, fax. 021 85909215 ', 'Jl. Basuki Rahmat No. 33, Jatinegara, Jakarta Timur 13310 Indonesia\r\n\r\nEmail. \r\nalfie@pt-bmt.co.id', 0),
(31, 'PT Trimitra Mandiri Sentosa', 'M221CE24R, memory card for M2xx controller, spare part - Modicon M221 battery holder', 'Belum Ada', '2020-08-07 00:23:00', '2020-09-12 00:01:05', '021 29986306 fax. 021 29986306 ', 'Jl. Mangga Dua Raya No. 08, Jakarta Barat- Indonesia\r\n\r\nEmail \r\ntrimitramandirisentosa@gmail.com', 0),
(32, 'PT Solus Infiniti Prima', 'PMI Testing for Mixing Tank Cap. 100L, ', 'Belum Ada', '2020-08-07 00:28:13', '2020-08-07 00:33:25', '021 8810724/ 021 Fax. 021 88341386 attn. Andrian Willantoro', 'Jl. Cut Mutia Margahayu, Bekasi Timur, Bekasi 17113\r\n\r\nEmail:\r\nandrian.willantoro@solus.co.id', 0),
(33, 'PT Xyena Total Solusindo', 'Programming & Support Commisioning WT TIV Cianjur, Programming & Support Commisioning WT TIV Wonosobo, Programming & Support Commisioning Mixing Tank 100L Line2 - PT Kalbe Farma', 'Belum Ada', '2020-08-07 00:36:04', '2020-08-07 00:41:58', '021 52900250, fax. 021 85219869051 attn. Juliun Antomi', 'Patra Jasa Officer Tower, Lantai 17 Kav. 32-34, Jalan Gatot Subroto Rt. 6 Rw. 3 Kuningan Kota Jakarta Selatan, Jakarta 12950\r\n\r\nEmail. \r\nJuliun.antomi@gmail.com', 0),
(34, 'PT Hedatech Kaesha Sukses', 'Pengadaan Packing Dan Consumable Jasa dan Manpower Scope pekerjaan: 1. Membuka/ Menutup Manhole support NDE inspeksi 2. Penggantian semua packing manhole yang dibuka', 'Belum Ada', '2020-08-07 00:47:52', '2020-08-07 00:51:28', '0251 8563255 attn. Hendi Hidayat', 'Vila Mutiara Lido Blok E2 No. 27, Cigombong- Bogor', 0),
(35, 'Toko Trimakmur Teknik', 'SS304 Roundbar dia.3\" x 150mm, SS316L Plate dia. 160mm x 12mm, SS304 Roundbar dia.1/2\" x 1,000mm,  SS316L Roundbar dia.20mm x 35mm', 'Belum Ada', '2020-08-07 00:55:37', '2020-08-07 00:58:57', '021 22874868 Fax. 021 46828725 attn. Yenny', 'Pergudangan Bizpark1, Commercial Estate, Pulo Gadung, Jakarta Timur\r\n\r\nEmail.\r\nyennyaldiyanto@gmail.com', 0),
(36, 'PT Buana Logam Perkasa', 'SS316L Ferrule Sanitary dia. 1\", Clamp Single Pin Sanitary 1\" - 1.5\"', 'Belum Ada', '2020-08-07 01:00:05', '2020-08-07 01:03:38', '021 62307170 Fax. Na ', 'LTC. Glodok Jalan Raya Hayam Wuruk No. 127 Lantai SB Blok C1, No. 15 Rt. 1/Rw. 6 Mangga Besar Kec. Taman Sari Kota Jakarta Barat, Jakarta 11180\r\n\r\n', 0),
(37, 'PT Trigori Mitra Asasta', 'Rental roughness tools for 1 day', 'Belum Ada', '2020-08-07 01:05:01', '2020-08-07 01:08:49', '08118253069 attn. Fit S Ansharullah', 'Ruko Metroboulevard Blok B No. 12B Jl. Niaga Raya, Jababeka Pasirsari Cikarang, Kab. Bekasi\r\n\r\nEmail \r\nansharullah@trigori-asata.co.id', 0),
(38, 'PT Murni Mandiri Lestari Jaya', 'Shaft OD34x960, Distance bar OD25.4x246, Dusct Cover OD62x27, Rotor Disk OD50x5, Rotor Sleve OD27.4x70, Rotor Blade t3x18x18, Finish Machining Rotor, Drain Plate (Bor OD7-4x)', 'Belum Ada', '2020-08-07 01:31:19', '2020-08-07 01:33:46', '021 48703918, fax. 021 48703918 Attn. Rukman Rohandi', 'Jl. Kp. Rawa Bebek No. 105/73 Kota Baru Bekasi Barat\r\n\r\nemail.\r\nmm.lestarijaya@gmail.com', 0),
(39, 'Iqrom', 'Licence Software Batch Report, Engineering', 'Belum Ada', '2020-08-10 23:16:57', '2020-08-10 23:18:41', '-', 'email \r\niqrommullah@gmail.com', 0),
(40, 'PT Tiga Fasa Komponen', 'SIMATIC S7-1200, CPU 1215C, compact CPU, DC/DC/DC, 2 PROFINET ports, onboard I/O: 14 DI 24 V DC; 10 DO 24 V DC; 0.5A; 2 AI 0-10 V DC, 2 AO 0-20 mA DC, Power supply: DC 20.4-28.8V DC, Program/data memory 125 KB,  6AV2124-0GC01-0AX0, SIMATIC HMI TP700 Comfo', 'Belum Ada', '2020-08-10 23:21:33', '2020-08-10 23:25:35', '021 62320755, fax. 021 623202901 attn. Wilda', 'LTC Glodok, Lantai GF2 Blok B1 No. 21 Jalan Hayam Wuruk No. 127 Mangga Besar, Taman Sari Jakarta Barat DKI Jakarta\r\n\r\nEmail.\r\nab3jkt@gmail.com', 0),
(41, 'PT Bintang Mas Karya Nusantara', 'Centrifugal Pump LKH 25/198 mm/11 kW/SSS, Union SMS connection', 'Belum Ada', '2020-08-10 23:27:05', '2020-08-10 23:31:06', '021 82732142 Attn. M. Kaisar', 'Perkantoran Grand Galaxy City, Blok RSN 3 No. 50, Bekasi Selatan Jawa Barat Indonesia 17147\r\n\r\nEmail.\r\nmuhammad.kaisar@bintangmas-engineering.com', 0),
(42, 'PT Alta Global Mandiri', 'Liquiphant FTL33, Deltapilot M FMB50, Promag 10H22, DN25 1” ODT,SMS,ANSI,ISO', 'Belum Ada', '2020-08-10 23:51:09', '2020-08-10 23:54:32', '081296945007 attn. Ismail Prayitno', 'Ruko Grand Galaxy City, RSN 7 No. 18 Kel. Jaka Setia, Kec. Bekasi Selatan 17147\r\n\r\nEmail. \r\nismail.prayitno@altaglobal.co.id', 0),
(43, 'PT Cryogas', '-', 'Belum Ada', '2020-08-11 00:14:08', '2020-08-11 00:44:46', '021 5566 1019 attn. Rey Leev', 'Pergudangan Sentra Prima TeknoPark , Blok A5\r\nJl Palem Manis Raya, Gandasari, Jatiuwung\r\nTangerang- Banten 15137\r\n\r\nemail:\r\nrey@cryogastech.com', 0),
(44, 'PT Tata Sentosa Prasetya', '-', 'Belum Ada', '2020-08-11 00:47:44', '2020-08-11 00:59:39', '0 21 54 3535 55; 54 3535 66', 'Mutiara Taman Palem Blok C10 No.33\r\nCengkareng, Jakarta Barat\r\n\r\nemail\r\nmarketing@grandscm.com', 0),
(45, 'AERRE INOX S.R.L.', '-', 'Belum Ada', '2020-08-11 01:39:41', '2020-08-11 01:41:53', '+39 0374 370828 fax. +39 0374 370833 Pic. Paolo Urgesi', 'SEDE LEGALE: 26010 FIESCO - CREMONA - ITALY\r\nVia GEROLA n. 4\r\n\r\nEmail.\r\nurgesi@aerreinox.it', 0),
(46, 'PT. Donaldson Filtration Indonesia', '-', 'Belum Ada', '2020-08-11 01:42:45', '2020-08-11 01:44:41', '021 7827008 Fax. 021 7827009 Pic. Riza Ramsey', 'South Quater Tower B 16th Floor Unit E\r\nJl. R.A. Kartini Kav 8 Cilandak\r\nJakarta 12430 Indonesia\r\n\r\nEmail.\r\nriza.ramsey@donaldson.com', 0),
(47, 'Sutejo', '-', 'Belum Ada', '2020-08-11 01:45:53', '2020-08-11 01:48:09', '0812 1817 9509', ' Jl. H.Saiman, Ganda Sari, Cikarang Barat, RT.002/RW.03, Bekasi\r\n\r\nEmail.\r\nstj2604@gmail.com', 0),
(48, 'PT Sanitaria Uttama', '-', 'Belum Ada', '2020-08-11 01:53:35', '2020-08-11 01:56:06', '021-53161010, Fax. 021-53161011 Pic. Ronny Tan', 'Jl. Matraman Raya 67\r\nJakarta Timur - 13140\r\n\r\nEmail.\r\nronny@sanitaria-uttama.com', 0),
(49, 'PT Fanah Jaya Maindo', '-', 'Belum Ada', '2020-08-11 01:57:10', '2020-08-11 02:20:27', '021 6220 2439,  fax. 021 6220 2437', 'Kawasan Industri Delta Silicon 3, Lippo Cikarang\r\nJl. Pinang Blok F16 No. 11A - 11B, Bekasi 17550\r\nIndonesia\r\n\r\nEmail. \r\nawan.effendi@gmail.com', 0),
(50, 'PT Izzati Hasanah', '-', 'Belum Ada', '2020-08-11 02:24:16', '2020-08-11 02:29:56', '021 - 2246 3900 Fax. 021 - 2246 2655 Pic Aries Mardianto', 'Pergudangan Green Sedayu BizPark Cakung\r\nBlok GS 5 No. 68\r\nJl. Cakung Cilincing Timur Raya Km. 2\r\n\r\nEmail.\r\ninfo@izzati.co.id', 0),
(51, 'PT Mettler Toledo Indonesia', '-', 'Belum Ada', '2020-08-11 02:30:31', '2020-08-11 02:32:13', '021 294 53919, Fax. 021 29453915 Pic. Diyah Handayani K', 'GRHA PERSADA 3rd Floor\r\nJl. KH. Noer Ali No.3A, Kayuringin Jaya\r\nBekasi Selatan 17144\r\n\r\nEmail.\r\nDiyah.Handayani@mt.com', 0),
(52, 'Evoqua Water Technologies Pte Ltd', '-', 'Belum Ada', '2020-08-11 02:33:35', '2020-08-11 02:39:56', '+65 6559-2593, Fax. +65 6861-3853 Pic. Lee Yew Lin', '28 Tuas Avenue 8\r\nSingapore 639243\r\n\r\nEmail.\r\n\'yewlin.lee@evoqua.com', 0),
(53, 'PT. Winston Indonesia', '-', 'Belum Ada', '2020-08-11 02:40:43', '2020-08-11 02:43:39', '\'021-2903 1022, Fax. \'021-2903 1024 Pic. Hendi', 'Pergudangan Prima Center 2 Blok D No. 5\r\nJl. Pool PPD Pesing Poglar, Jakarta 11710\r\n\r\nEmail. \r\n\'winston-sales@winstonindonesia.co.id', 0),
(54, 'PT.Sinergy Tehnik Utama', '-', 'Belum Ada', '2020-08-11 02:44:27', '2020-08-11 02:46:35', '\'62-21-29379611,  Fax.\'62-21-29379610 Pic. Edi Handoko', 'Ruko L’ Agricola Blok A no.51 Paramount Serpong.Desa Curug Sangereng,Kec Kelapa Dua-Kab Tangerang\r\n\r\nEmail.\r\n\'edy_handoko@sinergytama.com', 0),
(55, 'Jakarta Process Automation', '-', 'Belum Ada', '2020-08-11 02:47:19', '2020-08-11 02:49:20', '\'021 4707038, Fax. \'021 47860587 Pic. Idham Mashar', 'Jl. Rawamangun Muka Raya 1A Jakarta 13220\r\n\r\nEmail. \r\n\'idham.mashar@jpa-automation.com', 0),
(56, 'PT. Bintang Mahakam Jaya', '-', 'Belum Ada', '2020-08-11 02:49:39', '2020-08-11 02:51:10', '\'0857 7407 2381, Pic. Abdul Hakam Adi', 'Kp. Kamur ang RT.001/001 Kel./Desa Cikedokan Kecamatan Cikarang Barat Kabupaten Bekasi 17530\r\n\r\nEmail. \r\n\'bintangmahakamjaya@gmail.com', 0),
(57, 'PT Festo', '-', 'Belum Ada', '2020-08-11 02:52:04', '2020-08-11 02:53:28', '\'0804-1-2-FESTO (33786), \'0804-1-4-FESTO (33786)', 'Jl. Tekno V blok A/1 Sektor XI\r\nKawasan Industri BSD – Serpong\r\n15314 Tangerang – Banten\r\n\r\nEmail \r\n\'sales_id@festo.com', 0),
(58, 'PT  ALIATEKNIK', '-', 'Belum Ada', '2020-08-11 02:55:17', '2020-08-11 02:56:57', '\'021-5316-5566, Fax. \'021-5316-5568 Pic. Rasno Aji', 'Villa Melati Mas Blok I-10 No.18, Serpong, Tangerang 15323, Indonesia\r\n\r\nEmail. \r\n\'rasno@alia-inc.net', 0),
(59, 'PD Artha Teknik', 'Burkert Flow Hall Sensor type SE 30', '-', '2020-12-01 03:07:40', '2020-12-01 03:07:40', NULL, NULL, NULL),
(60, 'PT Aritha Prima Indonesia Tbk.', 'Manual Globe Valve Arita, Swing Check Valve Arita, Manual Ball Valve', '-', '2020-12-01 03:40:53', '2020-12-01 03:40:53', NULL, NULL, NULL),
(61, 'PT Multi Sukses Pratama', 'Burkert SE30 For High Temp, Burkert High Temp Fittings Type S030, ', '-', '2020-12-01 03:49:28', '2020-12-01 03:49:28', NULL, NULL, NULL),
(62, 'DEF Tripratama Indonesia', 'Boroscope Olympus Iplex Diameter Probe Camera 6 mm, Length 8 meter + Operator (1day trip)', '-', '2020-12-04 02:43:28', '2020-12-04 02:43:28', NULL, NULL, NULL),
(63, 'PT Cipta Aneka Air', 'Membrane Hot Water Sanitizable	Merk: DOW-Filmtec	Model: HSRO 4040FF	', '-', '2020-12-04 04:04:56', '2020-12-04 04:04:56', NULL, NULL, NULL),
(64, 'Ragam Adi Catur Esajaya', 'SEAL FPM LKDC -LP 450	', '-', '2020-12-04 04:08:51', '2020-12-04 04:08:51', NULL, NULL, NULL),
(65, 'PT Forta Inovasi  Tekhnik', 'Rent of Gantry	 - Height : 3m	 - Width : 2m	 - Capacity : 2-5 Ton	', '-', '2020-12-04 04:15:30', '2020-12-04 04:15:30', NULL, NULL, NULL),
(66, 'PT Krisna Dwi Mitra ', '\"Pneumatic Spare Actuator 687 Diagphram GEMU Valve DN10-25mm. (9687 25Z 1 1/N +1300)\"	', '-', '2020-12-04 04:17:51', '2020-12-04 04:17:51', NULL, NULL, NULL),
(67, 'Trieka Aimex', 'Ball Feet SS304 dia.3\" (complete set)	', '-', '2020-12-04 04:30:56', '2020-12-04 04:30:56', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workshop_allowances`
--

CREATE TABLE `workshop_allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `multiplier` int(11) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounting_expenses`
--
ALTER TABLE `accounting_expenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounting_expenses_code_unique` (`code`),
  ADD UNIQUE KEY `accounting_expenses_name_unique` (`name`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowance_items`
--
ALTER TABLE `allowance_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_code_unique` (`code`);

--
-- Indexes for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_categories_name_unique` (`name`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_administrations`
--
ALTER TABLE `bank_administrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bank_administrations_code_unique` (`code`);

--
-- Indexes for table `bpjs_kesehatans`
--
ALTER TABLE `bpjs_kesehatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bpjs_ketenagakerjaans`
--
ALTER TABLE `bpjs_ketenagakerjaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashbonds`
--
ALTER TABLE `cashbonds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cashbonds_code_unique` (`code`);

--
-- Indexes for table `cashbond_installments`
--
ALTER TABLE `cashbond_installments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashbond_sites`
--
ALTER TABLE `cashbond_sites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cashbond_sites_code_unique` (`code`);

--
-- Indexes for table `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cashes_name_unique` (`name`),
  ADD UNIQUE KEY `cashes_account_number_unique` (`account_number`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `competency_allowances`
--
ALTER TABLE `competency_allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configurations_name_unique` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `delivery_orders_code_unique` (`code`);

--
-- Indexes for table `ets`
--
ALTER TABLE `ets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_payroll_payments`
--
ALTER TABLE `extra_payroll_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incentive_week_days`
--
ALTER TABLE `incentive_week_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incentive_week_ends`
--
ALTER TABLE `incentive_week_ends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_requests`
--
ALTER TABLE `internal_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `internal_requests_code_unique` (`code`);

--
-- Indexes for table `invoice_customers`
--
ALTER TABLE `invoice_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_customers_code_unique` (`code`);

--
-- Indexes for table `invoice_customer_taxes`
--
ALTER TABLE `invoice_customer_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_vendors`
--
ALTER TABLE `invoice_vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_vendors_code_unique` (`code`);

--
-- Indexes for table `invoice_vendor_taxes`
--
ALTER TABLE `invoice_vendor_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_invoice_customer`
--
ALTER TABLE `item_invoice_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_purchase_order_vendor`
--
ALTER TABLE `item_purchase_order_vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_purchase_request`
--
ALTER TABLE `item_purchase_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_code_unique` (`code`);

--
-- Indexes for table `lock_configurations`
--
ALTER TABLE `lock_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_allowances`
--
ALTER TABLE `medical_allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migos`
--
ALTER TABLE `migos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `migos_code_unique` (`code`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periods_code_unique` (`code`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD UNIQUE KEY `products_name_unique` (`name`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_categories_code_unique` (`code`),
  ADD UNIQUE KEY `product_categories_name_unique` (`name`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_code_unique` (`code`);

--
-- Indexes for table `purchase_order_customers`
--
ALTER TABLE `purchase_order_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_order_customers_code_unique` (`code`);

--
-- Indexes for table `purchase_order_vendors`
--
ALTER TABLE `purchase_order_vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_order_vendors_code_unique` (`code`);

--
-- Indexes for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_requests_code_unique` (`code`);

--
-- Indexes for table `quotation_customers`
--
ALTER TABLE `quotation_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotation_customers_code_unique` (`code`);

--
-- Indexes for table `quotation_vendors`
--
ALTER TABLE `quotation_vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotation_vendors_code_unique` (`code`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_code_unique` (`code`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `settlements`
--
ALTER TABLE `settlements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settlements_code_unique` (`code`);

--
-- Indexes for table `settlement_payrolls`
--
ALTER TABLE `settlement_payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_assignees`
--
ALTER TABLE `task_assignees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `the_logs`
--
ALTER TABLE `the_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_reports`
--
ALTER TABLE `time_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_report_user`
--
ALTER TABLE `time_report_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_name_unique` (`name`);

--
-- Indexes for table `workshop_allowances`
--
ALTER TABLE `workshop_allowances`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounting_expenses`
--
ALTER TABLE `accounting_expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allowance_items`
--
ALTER TABLE `allowance_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_categories`
--
ALTER TABLE `asset_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_administrations`
--
ALTER TABLE `bank_administrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_kesehatans`
--
ALTER TABLE `bpjs_kesehatans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_ketenagakerjaans`
--
ALTER TABLE `bpjs_ketenagakerjaans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashbonds`
--
ALTER TABLE `cashbonds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashbond_installments`
--
ALTER TABLE `cashbond_installments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashbond_sites`
--
ALTER TABLE `cashbond_sites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competency_allowances`
--
ALTER TABLE `competency_allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ets`
--
ALTER TABLE `ets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extra_payroll_payments`
--
ALTER TABLE `extra_payroll_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incentive_week_days`
--
ALTER TABLE `incentive_week_days`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incentive_week_ends`
--
ALTER TABLE `incentive_week_ends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internal_requests`
--
ALTER TABLE `internal_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_customers`
--
ALTER TABLE `invoice_customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_customer_taxes`
--
ALTER TABLE `invoice_customer_taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_vendors`
--
ALTER TABLE `invoice_vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice_vendor_taxes`
--
ALTER TABLE `invoice_vendor_taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_invoice_customer`
--
ALTER TABLE `item_invoice_customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item_purchase_order_vendor`
--
ALTER TABLE `item_purchase_order_vendor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_purchase_request`
--
ALTER TABLE `item_purchase_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lock_configurations`
--
ALTER TABLE `lock_configurations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medical_allowances`
--
ALTER TABLE `medical_allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migos`
--
ALTER TABLE `migos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `purchase_order_customers`
--
ALTER TABLE `purchase_order_customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `purchase_order_vendors`
--
ALTER TABLE `purchase_order_vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quotation_customers`
--
ALTER TABLE `quotation_customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `quotation_vendors`
--
ALTER TABLE `quotation_vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settlements`
--
ALTER TABLE `settlements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settlement_payrolls`
--
ALTER TABLE `settlement_payrolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_assignees`
--
ALTER TABLE `task_assignees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `the_logs`
--
ALTER TABLE `the_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `time_reports`
--
ALTER TABLE `time_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_report_user`
--
ALTER TABLE `time_report_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `workshop_allowances`
--
ALTER TABLE `workshop_allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
