-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for admin
CREATE DATABASE IF NOT EXISTS `admin` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `admin`;

-- Dumping structure for table admin.admin_system
CREATE TABLE IF NOT EXISTS `admin_system` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(50) DEFAULT NULL,
  `first_page_url` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT 'used in html checkbox',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.admin_system: ~5 rows (approximately)
/*!40000 ALTER TABLE `admin_system` DISABLE KEYS */;
INSERT INTO `admin_system` (`sid`, `sname`, `first_page_url`, `icon`, `name`) VALUES
	(1, 'Vehicle', 'vehicle/vehicle.php', 'fas fa-taxi fa-10x', 'vehicle'),
	(2, 'Stationary', 'stationary/report_stock_summary.php', 'fas fa-pen-alt fa-10x', 'stationary'),
	(3, 'Fire Extinguisher', 'fire_extinguisher/listing.php', 'fas fa-fire-extinguisher fa-10x', 'fire_extinguisher'),
	(4, 'Add User', 'manage_user/add_new_user.php', 'fas fa-user-plus fa-10x', 'add_user'),
	(5, 'Bill', 'bill/add_new_bill.php', 'fas fa-file-invoice fa-10x', 'billing'),
	(6, 'Office Management', 'office_management/request_list.php', 'fas fa-briefcase fa-10x', 'office_management');
/*!40000 ALTER TABLE `admin_system` ENABLE KEYS */;

-- Dumping structure for table admin.bill_account_setup
CREATE TABLE IF NOT EXISTS `bill_account_setup` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_type` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `tariff` varchar(50) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `serial_no` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `property_type` int(11) DEFAULT NULL COMMENT '1-shoplot, 2 -house',
  `hp_no` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `celcom_limit` double DEFAULT NULL,
  `package` varchar(50) DEFAULT NULL,
  `latest_package` varchar(50) DEFAULT NULL,
  `limit_rm` double DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `owner_ref` text DEFAULT NULL,
  `unit_no` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`acc_id`),
  KEY `Index 2` (`company_id`,`location_id`,`bill_type`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_account_setup: ~15 rows (approximately)
/*!40000 ALTER TABLE `bill_account_setup` DISABLE KEYS */;
INSERT INTO `bill_account_setup` (`acc_id`, `bill_type`, `company_id`, `location_id`, `account_no`, `deposit`, `tariff`, `owner`, `serial_no`, `user`, `property_type`, `hp_no`, `position`, `reference`, `celcom_limit`, `package`, `latest_package`, `limit_rm`, `data`, `remark`, `owner_ref`, `unit_no`) VALUES
	(1, 1, 1, 5, '07881469/10373462', 38500, 'CM1(PERDAGANGAN VOLTAN RENDAH)', '', '', '', NULL, '', '', '', 0, '', '', 0, '', '', '', ''),
	(2, 2, 1, 5, '010254921900017', 3000, '', 'ENG PENG COLD STORAGE SDN BHD', '', '', NULL, '', '', '', 0, '', '', 0, '', '', '', ''),
	(3, 3, 1, 5, 'S45329-538-0106', 0, '', '', '', '', NULL, '', '', '088-491245', 0, '', '', 0, '', '', '', ''),
	(4, 4, 6, 0, '90744360', 0, '', '', '', 'ALICE YONG KHYUN YING', NULL, '', 'PURCHASING EXECUTIVE', '', 500, 'FIRST GOLD 80', 'FIRST GOLD B', 90, '10GB + 10 GB', 'COMPH H/P J4', '', ''),
	(5, 5, 6, 1, '', 0, '', '', '477847', '', NULL, '', '', '', 0, '', '', 0, '', '', '', ''),
	(6, 5, 4, 1, '', 0, '', '', '477855', '', NULL, '', '', '', 0, '', '', 0, '', '', '', ''),
	(7, 5, 3, 1, '', 0, '', '', '426968', '', NULL, '', '', '', 0, '', '', 0, '', '', '', ''),
	(8, 5, 3, 2, '', 0, '', '', '528508', '', NULL, '', '', '', 0, '', '', 0, '', '', '', ''),
	(9, 6, 1, 5, '', 0, '', '', '', '', NULL, '', '', '', 0, '', '', 0, '', '', 'C21-0', ''),
	(10, 6, 1, 5, '', 0, '', '', '', '', NULL, '', '', '', 0, '', '', 0, '', '', 'C21-1', ''),
	(11, 6, 19, 1, '', 0, '', '', '', '', NULL, '', '', '', 0, '', '', 0, '', '', '', 'C3-04-01'),
	(12, 6, 1, 2, '', 0, '', '', '', '', 2, '', '', '', 0, '', '', 0, '', '', '', 'C3-04-01'),
	(13, 4, 7, 0, '968646673', 0, '', '', '', 'MOHD FIRDAUS BIN RAHIM', 0, '', 'PRODUCTION EXECUTIVE', '', 500, 'FIRST GOLD 80', 'FIRST GOLD B', 100, '10GB + 10 GB', 'VIVO', '', ''),
	(14, 4, 6, 0, '73628205', 0, '', '', '', 'CHAI KIN FATT', 0, '', 'FARM MANAGER', '', 500, 'FIRST GOLD 80', 'FIRST GOLD B', 100, '10GB + 10 GB', '', '', ''),
	(15, 4, 6, 0, '90380608', 0, '', '', '', 'CHANG VUI LOI', 0, '', 'FARM MANAGER', '', 500, 'FIRST GOLD 80', 'FIRST GOLD B', 100, '10GB + 10 GB', '', '', '');
/*!40000 ALTER TABLE `bill_account_setup` ENABLE KEYS */;

-- Dumping structure for table admin.bill_billing
CREATE TABLE IF NOT EXISTS `bill_billing` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_type` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `period_from` date DEFAULT NULL,
  `period_to` date DEFAULT NULL,
  `cheque_no` varchar(50) DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`bill_id`),
  KEY `index` (`bill_type`,`company_id`,`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_billing: ~9 rows (approximately)
/*!40000 ALTER TABLE `bill_billing` DISABLE KEYS */;
INSERT INTO `bill_billing` (`bill_id`, `bill_type`, `company_id`, `location_id`, `account_no`, `deposit`, `period_from`, `period_to`, `cheque_no`, `paid_date`, `due_date`) VALUES
	(1, 1, 1, 5, '07881469/10373462', 38500, '0000-00-00', '0000-00-00', 'HLBB700029', '0000-00-00', '0000-00-00'),
	(2, 1, 1, 5, '07881469/10373462', 38500, '0000-00-00', '0000-00-00', 'HLBB700029', '0000-00-00', '0000-00-00'),
	(3, 2, 1, 5, '01025492190017', 3000, '0000-00-00', '0000-00-00', 'HLBB100013', '0000-00-00', '0000-00-00'),
	(4, 3, 1, 5, 'S45329-538-0106', 0, '0000-00-00', '0000-00-00', 'HLBB700014', '0000-00-00', '0000-00-00'),
	(8, 3, 1, 5, 'S45329-538-0106', 0, '0000-00-00', '0000-00-00', 'HLBB703483', '0000-00-00', '0000-00-00'),
	(9, 3, 1, 5, 'S45329-538-01006', 0, '0000-00-00', '0000-00-00', 'HLBB703483', '0000-00-00', '0000-00-00'),
	(10, 3, 0, 0, '', 0, '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00'),
	(11, 1, 0, 0, '', 0, '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00'),
	(12, 2, 0, 0, '', 0, '0000-00-00', '0000-00-00', 'HLBB700029', '0000-00-00', '0000-00-00');
/*!40000 ALTER TABLE `bill_billing` ENABLE KEYS */;

-- Dumping structure for table admin.bill_billtype
CREATE TABLE IF NOT EXISTS `bill_billtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_billtype: ~6 rows (approximately)
/*!40000 ALTER TABLE `bill_billtype` DISABLE KEYS */;
INSERT INTO `bill_billtype` (`id`, `name`) VALUES
	(1, 'SESB'),
	(2, 'JABATAN AIR'),
	(3, 'TELEKOM'),
	(4, 'CELCOM'),
	(5, 'PHOTOCOPY MACHINE'),
	(6, 'MANAGEMENT FEE');
/*!40000 ALTER TABLE `bill_billtype` ENABLE KEYS */;

-- Dumping structure for table admin.bill_celcom
CREATE TABLE IF NOT EXISTS `bill_celcom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) DEFAULT NULL,
  `bill_amount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acc_id` (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_celcom: ~24 rows (approximately)
/*!40000 ALTER TABLE `bill_celcom` DISABLE KEYS */;
INSERT INTO `bill_celcom` (`id`, `acc_id`, `bill_amount`, `date`) VALUES
	(1, 4, 76.95, '2020-01-10'),
	(2, 4, 77.15, '2020-02-10'),
	(3, 4, 77.15, '2020-03-10'),
	(4, 4, 76.3, '2020-04-01'),
	(5, 4, 77.4, '2020-05-01'),
	(6, 4, 76.3, '2020-06-01'),
	(7, 4, 76.75, '2020-07-01'),
	(8, 4, 76.3, '2020-08-01'),
	(9, 4, 76.3, '2020-09-01'),
	(10, 4, 76.3, '2020-10-01'),
	(11, 4, 76.55, '2020-11-01'),
	(12, 4, 78.45, '2020-12-01'),
	(13, 13, 75.45, '2020-01-01'),
	(14, 13, 75.7, '2020-02-01'),
	(15, 13, 76.3, '2020-03-01'),
	(16, 13, 153.7, '2020-04-01'),
	(17, 13, 81.2, '2020-05-01'),
	(18, 13, 75.45, '2020-06-01'),
	(19, 13, 75.25, '2020-07-01'),
	(20, 13, 75.25, '2020-08-01'),
	(21, 13, 80.9, '2020-09-01'),
	(22, 13, 78.65, '2020-10-01'),
	(23, 13, 86.3, '2020-11-01'),
	(24, 13, 88, '2020-12-01');
/*!40000 ALTER TABLE `bill_celcom` ENABLE KEYS */;

-- Dumping structure for table admin.bill_insurance_premium
CREATE TABLE IF NOT EXISTS `bill_insurance_premium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `payment` double DEFAULT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `or_no` double DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_insurance_premium: ~0 rows (approximately)
/*!40000 ALTER TABLE `bill_insurance_premium` DISABLE KEYS */;
INSERT INTO `bill_insurance_premium` (`id`, `invoice_no`, `description`, `payment`, `payment_mode`, `or_no`, `date_paid`, `date_from`, `date_to`) VALUES
	(1, '123456789', 'testest fdhfj fgjghkgh,', 250, 'cash', 321654897, '2020-03-18', '2020-03-18', '2020-03-18');
/*!40000 ALTER TABLE `bill_insurance_premium` ENABLE KEYS */;

-- Dumping structure for table admin.bill_jabatan_air
CREATE TABLE IF NOT EXISTS `bill_jabatan_air` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) DEFAULT NULL,
  `meter_reading_from` double DEFAULT NULL,
  `meter_reading_to` double DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `cheque_no` varchar(50) DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `rate_70` double DEFAULT NULL,
  `rate_71` double DEFAULT NULL,
  `usage_70` double DEFAULT NULL,
  `usage_71` double DEFAULT NULL,
  `credit_adjustment` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `adjustment` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_jabatan_air: ~5 rows (approximately)
/*!40000 ALTER TABLE `bill_jabatan_air` DISABLE KEYS */;
INSERT INTO `bill_jabatan_air` (`id`, `acc_id`, `meter_reading_from`, `meter_reading_to`, `date_start`, `date_end`, `cheque_no`, `paid_date`, `due_date`, `rate_70`, `rate_71`, `usage_70`, `usage_71`, `credit_adjustment`, `amount`, `adjustment`) VALUES
	(1, 2, 1755668, 1774585, '2018-12-03', '2019-01-11', 'HLBB100013', '2019-01-22', '1970-01-01', 140.8, 37658, 88, 18829, 0, 37798.8, 0),
	(2, 2, 1774585, 1788333, '2019-01-11', '2019-02-11', 'HLBB699878', '2019-02-20', '1970-01-01', 112, 27356, 70, 13678, 0, 27468, 0),
	(3, 2, 1788333, 1801694, '2019-02-11', '2019-03-12', 'HLBB401158', '2019-03-25', '1970-01-01', 105.6, 26590, 66, 13295, 0, 26695.6, 0),
	(4, 2, 1801694, 1811757, '2019-03-12', '2019-04-03', 'HLBB701195', '2019-04-12', '1970-01-01', 80, 20026, 50, 10013, 0, 20106, 0),
	(5, 2, 1811757, 1825658, '2019-04-03', '2019-05-01', 'HLBB699970', '2019-05-15', '1970-01-01', 100.8, 27676, 63, 13838, 0, 27776.8, 0);
/*!40000 ALTER TABLE `bill_jabatan_air` ENABLE KEYS */;

-- Dumping structure for table admin.bill_late_interest_charge
CREATE TABLE IF NOT EXISTS `bill_late_interest_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_date` date DEFAULT NULL,
  `inv_no` varchar(50) DEFAULT NULL,
  `payment_due_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `payment_mode` varchar(10) DEFAULT NULL,
  `or_no` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_late_interest_charge: ~3 rows (approximately)
/*!40000 ALTER TABLE `bill_late_interest_charge` DISABLE KEYS */;
INSERT INTO `bill_late_interest_charge` (`id`, `bill_date`, `inv_no`, `payment_due_date`, `description`, `amount`, `payment_mode`, `or_no`) VALUES
	(1, '2020-03-17', '123456789', '0000-00-00', 'test dafjpopa afjkfafjpoajg', 500, 'cash', '321654987'),
	(2, '2020-03-17', '123456789', '2020-03-17', 'test dafjpopa afjkfafjpoajg', 500, 'cash', '321654987'),
	(3, '2020-03-18', '321564789', '2020-03-18', 'loiknjuyghfgxdsewg fghfh gh gfstrsyiku', 120, 'cash', '321547846');
/*!40000 ALTER TABLE `bill_late_interest_charge` ENABLE KEYS */;

-- Dumping structure for table admin.bill_management_fee
CREATE TABLE IF NOT EXISTS `bill_management_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `payment_amount` double DEFAULT NULL,
  `payment_mode` varchar(10) DEFAULT NULL,
  `insurance_premium` double DEFAULT NULL,
  `interest_charge` double DEFAULT NULL,
  `official_receipt_no` varchar(50) DEFAULT NULL,
  `bill_inv_no` varchar(50) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acc_id` (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_management_fee: ~4 rows (approximately)
/*!40000 ALTER TABLE `bill_management_fee` DISABLE KEYS */;
INSERT INTO `bill_management_fee` (`id`, `acc_id`, `description`, `payment_amount`, `payment_mode`, `insurance_premium`, `interest_charge`, `official_receipt_no`, `bill_inv_no`, `payment_date`, `received_date`) VALUES
	(1, 9, 'Maintenance Fee Grd Floor', 265, 'ibg', 0, 0, 'SOOOOO145', 'SC-0/2019/01/00021', '2019-01-17', '2019-01-07'),
	(2, 9, 'MAINTENANCE FEE GRD FLOOR', 265, 'ibg', 0, 0, 'SCC/HR0059', 'SC-0/2019/02/00021', '2019-02-19', '2019-02-07'),
	(3, 10, 'MAINTENANCE FEE GRD FLOOR', 175, 'ibg', 0, 0, 'SOOOOO145', 'SC-1/2019/01/00021', '2019-01-17', '2020-03-13'),
	(4, 12, 'SERVICE CHARGE', 255, 'ibg', 0, 0, 'BS-BLOR00003980', 'BS-BLS00002218', '2019-01-19', '2019-01-10');
/*!40000 ALTER TABLE `bill_management_fee` ENABLE KEYS */;

-- Dumping structure for table admin.bill_photocopy_machine
CREATE TABLE IF NOT EXISTS `bill_photocopy_machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `full_color` bigint(20) DEFAULT NULL,
  `black_white` bigint(20) DEFAULT NULL,
  `color_a3` bigint(20) DEFAULT NULL,
  `copy` bigint(20) DEFAULT NULL,
  `print` bigint(20) DEFAULT NULL,
  `fax` bigint(20) DEFAULT NULL,
  `total` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acc_id` (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_photocopy_machine: ~13 rows (approximately)
/*!40000 ALTER TABLE `bill_photocopy_machine` DISABLE KEYS */;
INSERT INTO `bill_photocopy_machine` (`id`, `acc_id`, `date`, `full_color`, `black_white`, `color_a3`, `copy`, `print`, `fax`, `total`) VALUES
	(1, 5, '2019-01-23', 354, 331595, 3, 0, 0, 0, 331949),
	(2, 5, '2019-02-23', 354, 357139, 3, 0, 0, 0, 357493),
	(3, 5, '2019-03-23', 354, 382566, 3, 0, 0, 0, 382920),
	(4, 5, '2019-04-23', 378, 407701, 3, 0, 0, 0, 408079),
	(5, 5, '2019-05-23', 378, 433439, 3, 0, 0, 0, 433817),
	(6, 5, '2019-06-23', 381, 453573, 3, 0, 0, 0, 453954),
	(7, 5, '2019-07-23', 392, 480051, 6, 0, 0, 0, 480443),
	(8, 5, '2019-08-23', 399, 502068, 6, 0, 0, 0, 502467),
	(9, 5, '2019-09-23', 400, 522496, 6, 0, 0, 0, 522896),
	(10, 5, '2019-10-23', 422, 545899, 11, 0, 0, 0, 546321),
	(11, 5, '2019-11-23', 477, 566272, 11, 0, 0, 0, 566749),
	(12, 5, '2019-12-23', 481, 587497, 11, 0, 0, 0, 587978),
	(13, 8, '2019-01-23', 0, 0, 0, 261951, 198890, 24493, 485334);
/*!40000 ALTER TABLE `bill_photocopy_machine` ENABLE KEYS */;

-- Dumping structure for table admin.bill_quit_rent_billing
CREATE TABLE IF NOT EXISTS `bill_quit_rent_billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_no` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `payment` double DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `or_no` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `date_received` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_quit_rent_billing: ~2 rows (approximately)
/*!40000 ALTER TABLE `bill_quit_rent_billing` DISABLE KEYS */;
INSERT INTO `bill_quit_rent_billing` (`id`, `inv_no`, `invoice_date`, `payment`, `date_paid`, `payment_mode`, `or_no`, `due_date`, `date_received`, `remarks`) VALUES
	(1, '123456789', '2020-03-17', 123, '2020-03-17', 'ibg', '321547896', '2020-03-18', '2020-03-17', 'test saja'),
	(2, '', '1970-01-01', 0, '1970-01-01', '', '', '1970-01-01', '1970-01-01', '');
/*!40000 ALTER TABLE `bill_quit_rent_billing` ENABLE KEYS */;

-- Dumping structure for table admin.bill_sesb
CREATE TABLE IF NOT EXISTS `bill_sesb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `cheque_no` varchar(50) DEFAULT NULL,
  `meter_reading_from` double DEFAULT NULL,
  `meter_reading_to` double DEFAULT NULL,
  `total_usage` double DEFAULT NULL,
  `current_usage` double DEFAULT NULL,
  `kwtbb` double DEFAULT NULL,
  `penalty` double DEFAULT NULL,
  `power_factor` double DEFAULT NULL,
  `additional_deposit` double DEFAULT NULL,
  `other_charges` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `adjustment` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_sesb: ~6 rows (approximately)
/*!40000 ALTER TABLE `bill_sesb` DISABLE KEYS */;
INSERT INTO `bill_sesb` (`id`, `acc_id`, `date_start`, `date_end`, `paid_date`, `due_date`, `cheque_no`, `meter_reading_from`, `meter_reading_to`, `total_usage`, `current_usage`, `kwtbb`, `penalty`, `power_factor`, `additional_deposit`, `other_charges`, `amount`, `adjustment`) VALUES
	(1, 1, '2018-12-02', '2019-01-02', '2019-02-02', '2019-02-08', 'HLBB700029', 410095, 414945, 4850, 19155.44, 306.49, 0, 0, 0, 0, 19461.95, 0.02),
	(2, 1, '2019-01-02', '2019-02-01', '2019-03-11', '2019-03-10', 'HLBB699895', 414945, 420615, 5670, 22394.5, 358.31, 0, 0, 0, 0, 22752.8, -0.01),
	(3, 1, '2019-02-01', '2019-03-01', '2019-03-27', '2019-04-07', 'HLBB7401159', 420615, 423169, 2554, 10086.3, 161.38, 0, 0, 0, 0, 10247.7, 0.02),
	(4, 1, '2019-03-01', '2019-04-01', '2019-05-02', '2019-05-09', 'HLBB699946', 423169, 428477, 5308, 20964.54, 335.43, 0, 0, 0, 0, 22094.35, 0),
	(5, 1, '2019-04-01', '2019-05-01', '2019-05-25', '2019-06-05', 'HLBB699991', 428477, 432778, 4301, 16986.95, 271.79, 0, 0, 0, 0, 17258.75, 0.01),
	(6, 1, '2019-05-01', '2019-06-01', '2019-07-03', '2019-07-14', 'HLBB701131', 432778, 440763, 7985, 31538.69, 504.62, 0, 0, 0, -794.38, 31248.95, 0.02);
/*!40000 ALTER TABLE `bill_sesb` ENABLE KEYS */;

-- Dumping structure for table admin.bill_telefon_list
CREATE TABLE IF NOT EXISTS `bill_telefon_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bt_id` int(11) DEFAULT NULL,
  `tel_no` varchar(50) DEFAULT NULL,
  `usage_amt` double DEFAULT NULL,
  `phone_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`bt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_telefon_list: ~6 rows (approximately)
/*!40000 ALTER TABLE `bill_telefon_list` DISABLE KEYS */;
INSERT INTO `bill_telefon_list` (`id`, `bt_id`, `tel_no`, `usage_amt`, `phone_type`) VALUES
	(1, 1, '088-491245', 2.13, 'FAX'),
	(2, 1, '088-494033', 0.68, 'TELEPHONE'),
	(3, 1, '088-498935', 10.31, 'FAX'),
	(4, 2, '088-491245', 3.12, 'FAX'),
	(5, 2, '088-494033', 1.02, 'TELEPHONE'),
	(6, 2, '088-498935', 5.2, 'FAX');
/*!40000 ALTER TABLE `bill_telefon_list` ENABLE KEYS */;

-- Dumping structure for table admin.bill_telekom
CREATE TABLE IF NOT EXISTS `bill_telekom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) DEFAULT NULL,
  `bill_no` varchar(50) DEFAULT NULL,
  `cheque_no` varchar(50) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `monthly_bill` double DEFAULT NULL,
  `rebate` double DEFAULT NULL,
  `credit_adjustment` double DEFAULT NULL,
  `gst_sst` double DEFAULT NULL,
  `adjustment` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_telekom: ~2 rows (approximately)
/*!40000 ALTER TABLE `bill_telekom` DISABLE KEYS */;
INSERT INTO `bill_telekom` (`id`, `acc_id`, `bill_no`, `cheque_no`, `date_start`, `date_end`, `paid_date`, `due_date`, `monthly_bill`, `rebate`, `credit_adjustment`, `gst_sst`, `adjustment`, `amount`) VALUES
	(1, 3, '007482394710', 'HLBB700029', '2020-01-01', '2020-02-01', '2020-02-01', '2020-02-10', 411.5, -30, 0, 25.4772, 0, 420.0972),
	(2, 3, 'test', 'HLBB700030', '2020-03-01', '2020-04-01', '2020-04-08', '2020-04-10', 411.5, 0, 0, 25.2504, 0.01, 446.1004);
/*!40000 ALTER TABLE `bill_telekom` ENABLE KEYS */;

-- Dumping structure for table admin.bill_water
CREATE TABLE IF NOT EXISTS `bill_water` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `previous_mr` double DEFAULT NULL,
  `current_mr` double DEFAULT NULL,
  `total_consume` double DEFAULT NULL,
  `charged_amount` double DEFAULT NULL,
  `surcharge` double DEFAULT NULL,
  `adjustment` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `payment_mode` varchar(10) DEFAULT NULL,
  `or_no` varchar(50) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.bill_water: ~4 rows (approximately)
/*!40000 ALTER TABLE `bill_water` DISABLE KEYS */;
INSERT INTO `bill_water` (`id`, `date_from`, `date_to`, `invoice_no`, `invoice_date`, `due_date`, `description`, `previous_mr`, `current_mr`, `total_consume`, `charged_amount`, `surcharge`, `adjustment`, `total`, `paid_date`, `payment_mode`, `or_no`, `received_date`) VALUES
	(1, '2018-10-24', '2018-11-24', '7', '2018-12-11', '2019-01-10', 'WATER BILL', 1.25, 1.46, 0.21, 0.21, 2, -0.01, 2.21, '0000-00-00', 'IBG', '', '0000-00-00'),
	(2, '2018-10-24', '2018-11-24', '7', '2018-12-11', '2019-01-10', 'WATER BILL', 1.25, 1.46, 0.21, 0.21, 2, -0.01, 2.21, '0000-00-00', 'IBG', '', '0000-00-00'),
	(3, '2018-10-24', '2018-11-24', 'BS-BLWC00006539', '2018-12-11', '2019-01-10', 'WATER BILL', 1.25, 1.46, 0.21, 0.21, 2, -0.01, 2.21, '0000-00-00', 'IBG', '', '0000-00-00'),
	(4, '2018-10-24', '2018-11-24', 'BS-BLWC00006539', '2018-12-11', '2019-01-10', 'WATER BILL', 1.25, 1.46, 0.21, 0.21, 2, -0.01, 2.21, '0000-00-00', 'IBG', 'BS-BLWC00006539', '0000-00-00');
/*!40000 ALTER TABLE `bill_water` ENABLE KEYS */;

-- Dumping structure for table admin.company
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(25) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `registration_no` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.company: ~19 rows (approximately)
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` (`id`, `code`, `name`, `registration_no`, `status`) VALUES
	(1, 'EPCS', 'ENG PENG COLD STORAGE SDN BHD', '671699-H', 1),
	(2, 'KFSB', 'KOBOS FARM SDN BHD', '90890-U', 1),
	(3, 'EPPF', 'ENG PENG POULTRY FARM SDN BHD', '272243-H', 1),
	(4, 'SMESB', 'SALAM MARKETING ENTERPRISE SDN BHD', '733136-X', 1),
	(5, 'AI', 'LADANG TERNAKAN AYAM INDUK KOTA KINABALU SDN BHD', NULL, 0),
	(6, 'JDSB', 'JADIMA SDN BHD', '189788-U', 1),
	(7, 'JNSB', 'JUA NIKMAT SDN BHD', '851777-P', 1),
	(8, 'PDUSB', 'PERUSAHAAN DAYA USAHA SDN BHD', '835668-U', 1),
	(9, 'BN', 'BUMI NIAN SDN BHD', NULL, 0),
	(10, 'EPSB', 'EDEN PERFECT SDN BHD', NULL, 0),
	(11, 'TP', 'TIASA PASIFIK SDN BHD', NULL, 0),
	(12, 'EPSB', 'EP FEEDMILL SDN BHD', NULL, 1),
	(13, 'IISB', 'IMPIAN INTERAKTIF SDN BHD', '879886-M', 1),
	(14, 'RB', 'RAJIN BUDAYA', NULL, 0),
	(15, 'SST', 'SST BREEDING FARMS SDN BHD', NULL, 0),
	(16, 'LASB', 'LAGENDA AMANJAYA SDN BHD', '967788-H', 1),
	(17, 'SGSB', 'SALAM GLOBAL TRADING SDN BHD', NULL, 0),
	(18, 'EPG', 'Eng Peng Group', NULL, 0),
	(19, 'OTHERS', 'OTHERS', NULL, 0),
	(20, 'Jenneffer', 'Jenneffer', 'Jenneffer', 1),
	(21, 'Jenneffer2', 'Jenneffer', 'Jenneffer', 1);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;

-- Dumping structure for table admin.credential
CREATE TABLE IF NOT EXISTS `credential` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_name` varchar(50) NOT NULL,
  `cr_username` varchar(50) NOT NULL,
  `cr_email` varchar(50) NOT NULL DEFAULT '',
  `cr_password` varchar(50) NOT NULL,
  `cr_addUser` int(11) NOT NULL,
  `cr_vehicle` int(11) NOT NULL COMMENT 'MODULE. ''1'' FOR ABLE AND ''0'' FOR NOT ABLE',
  `cr_safety` int(11) NOT NULL COMMENT 'MODULE. ''1'' FOR ABLE AND ''0'' FOR NOT ABLE',
  `cr_telekomANDinternet` int(11) NOT NULL COMMENT 'MODULE. ''1'' FOR ABLE AND ''0'' FOR NOT ABLE',
  `cr_security` int(11) NOT NULL COMMENT 'MODULE. ''1'' FOR ABLE AND ''0'' FOR NOT ABLE',
  `cr_farmMaintenance` int(11) NOT NULL COMMENT 'MODULE. ''1'' FOR ABLE AND ''0'' FOR NOT ABLE',
  `cr_assetManagement` int(11) NOT NULL COMMENT 'MODULE. ''1'' FOR ABLE AND ''0'' FOR NOT ABLE',
  `cr_access_module` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`cr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.credential: ~4 rows (approximately)
/*!40000 ALTER TABLE `credential` DISABLE KEYS */;
INSERT INTO `credential` (`cr_id`, `cr_name`, `cr_username`, `cr_email`, `cr_password`, `cr_addUser`, `cr_vehicle`, `cr_safety`, `cr_telekomANDinternet`, `cr_security`, `cr_farmMaintenance`, `cr_assetManagement`, `cr_access_module`) VALUES
	(2, 'admin', 'admin', 'j.jennefferj@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 1, 1, 1, 1, 1, '1,2,3,4,5,6'),
	(8, 'Melisah', 'melisa', 'melisa@engpeng.com', '7856b9b6c1f68bd2cdac0b7439621fd4', 0, 1, 0, 0, 0, 0, 0, NULL),
	(10, 'Jenneffer Jiminit', 'jenneffer', 'j.jennefferj@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, 0, 0, 0, 0, '1,2,3'),
	(11, 'Rohana', 'rohana', 'rohana@engpeng.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, 0, 0, 0, 0, '1,2,3,4,5');
/*!40000 ALTER TABLE `credential` ENABLE KEYS */;

-- Dumping structure for table admin.fireextinguisher_listing
CREATE TABLE IF NOT EXISTS `fireextinguisher_listing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(50) DEFAULT NULL,
  `serial_no` varchar(50) DEFAULT NULL,
  `location` int(11) DEFAULT 0,
  `company_id` int(11) DEFAULT 0,
  `person_incharge` int(11) DEFAULT 0,
  `expiry_date` date DEFAULT '0000-00-00',
  `date_added` date DEFAULT '0000-00-00',
  `added_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT ' 0-deleted',
  `fe_status` int(11) DEFAULT 2 COMMENT '1-pending, 2-Active, 3-reject, 4-hold',
  PRIMARY KEY (`id`),
  KEY `Index 2` (`company_id`,`person_incharge`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.fireextinguisher_listing: ~4 rows (approximately)
/*!40000 ALTER TABLE `fireextinguisher_listing` DISABLE KEYS */;
INSERT INTO `fireextinguisher_listing` (`id`, `model`, `serial_no`, `location`, `company_id`, `person_incharge`, `expiry_date`, `date_added`, `added_by`, `approved_by`, `remark`, `status`, `fe_status`) VALUES
	(1, 'ABC', 'SN123456789', 5, 1, 2, '2020-03-24', '2020-02-24', 2, 0, 'testing', 1, 1),
	(2, 'ABC', 'UFO12014Y923249', 5, 1, 2, '2020-12-11', '2020-02-25', 2, 0, '', 1, 2),
	(3, 'ABC', 'UFO12014Y9232662', 5, 1, 2, '2020-12-11', '2020-02-25', 2, 0, '', 1, 2),
	(4, 'ABC', 'UFO123564894', 1, 3, 4, '2020-03-18', '2020-02-25', 2, 0, 'test', 1, 4);
/*!40000 ALTER TABLE `fireextinguisher_listing` ENABLE KEYS */;

-- Dumping structure for table admin.fireextinguisher_location
CREATE TABLE IF NOT EXISTS `fireextinguisher_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(50) DEFAULT NULL,
  `location_name` varchar(50) NOT NULL DEFAULT '0',
  `date_added` date DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.fireextinguisher_location: ~5 rows (approximately)
/*!40000 ALTER TABLE `fireextinguisher_location` DISABLE KEYS */;
INSERT INTO `fireextinguisher_location` (`location_id`, `location_code`, `location_name`, `date_added`, `added_by`) VALUES
	(1, 'TUA', 'TUARAN', '2020-02-24', 2),
	(2, 'TEL', 'TELIPOK', '2020-02-24', 2),
	(3, 'HAT', 'HATCHERY', '2020-02-24', 2),
	(4, 'BBB', 'BELURAN', '2020-02-24', 2),
	(5, 'SAL', 'SALUT', '2020-02-24', 2);
/*!40000 ALTER TABLE `fireextinguisher_location` ENABLE KEYS */;

-- Dumping structure for table admin.fireextinguisher_person_incharge
CREATE TABLE IF NOT EXISTS `fireextinguisher_person_incharge` (
  `pic_id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_name` varchar(50) DEFAULT NULL,
  `pic_contactNo` varchar(50) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.fireextinguisher_person_incharge: ~4 rows (approximately)
/*!40000 ALTER TABLE `fireextinguisher_person_incharge` DISABLE KEYS */;
INSERT INTO `fireextinguisher_person_incharge` (`pic_id`, `pic_name`, `pic_contactNo`, `date_added`, `added_by`) VALUES
	(1, 'Aaron', '0123456789', '2020-02-24', 2),
	(2, 'Safarina', '0198608756', '2020-02-24', 2),
	(3, 'Nicholas Wa', '0128008068', '2020-02-24', 2),
	(4, 'Chong San Ling', '0198600359', '2020-02-24', 2);
/*!40000 ALTER TABLE `fireextinguisher_person_incharge` ENABLE KEYS */;

-- Dumping structure for table admin.fireextinguisher_requisition_form
CREATE TABLE IF NOT EXISTS `fireextinguisher_requisition_form` (
  `rq_id` int(11) NOT NULL AUTO_INCREMENT,
  `rq_no` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`rq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table admin.fireextinguisher_requisition_form: ~0 rows (approximately)
/*!40000 ALTER TABLE `fireextinguisher_requisition_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `fireextinguisher_requisition_form` ENABLE KEYS */;

-- Dumping structure for table admin.fireextinguisher_supplier
CREATE TABLE IF NOT EXISTS `fireextinguisher_supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_contact_person` varchar(50) DEFAULT NULL,
  `supplier_contact_no` varchar(50) DEFAULT NULL,
  `supplier_address` varchar(50) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table admin.fireextinguisher_supplier: ~0 rows (approximately)
/*!40000 ALTER TABLE `fireextinguisher_supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `fireextinguisher_supplier` ENABLE KEYS */;

-- Dumping structure for table admin.main_menu
CREATE TABLE IF NOT EXISTS `main_menu` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL DEFAULT 0 COMMENT 'to identify title belong to which system',
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`mid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.main_menu: ~12 rows (approximately)
/*!40000 ALTER TABLE `main_menu` DISABLE KEYS */;
INSERT INTO `main_menu` (`mid`, `sid`, `title`, `url`, `position`, `icon`) VALUES
	(1, 1, 'Setup', NULL, 1, 'fa fa-cogs'),
	(2, 1, 'Listing', NULL, 2, 'fas fa-list-ul'),
	(3, 1, 'Reports', NULL, 3, 'fas fa-file-alt'),
	(4, 3, 'Setup', NULL, 1, 'fa fa-cogs'),
	(5, 3, 'Listing', NULL, 2, 'fas fa-list-ul'),
	(6, 2, 'Listing', NULL, 1, 'fas fa-list-ul'),
	(7, 2, 'Report', NULL, 2, 'fas fa-file-alt'),
	(8, 5, 'Setup', NULL, 1, 'fa fa-cogs'),
	(9, 5, 'Listing', NULL, 2, 'fas fa-list-ul'),
	(10, 5, 'Report', NULL, 3, 'fas fa-file-alt'),
	(11, 4, 'Setup', NULL, 1, 'fa fa-cogs'),
	(12, 4, 'Listing', NULL, 2, 'fas fa-list-ul'),
	(13, 6, 'Stock', NULL, 1, 'fas fa-cubes'),
	(14, 6, 'Petty Cash', NULL, 2, 'fas fa-cash-register');
/*!40000 ALTER TABLE `main_menu` ENABLE KEYS */;

-- Dumping structure for table admin.om_pcash_deposit
CREATE TABLE IF NOT EXISTS `om_pcash_deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pv_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.om_pcash_deposit: 2 rows
/*!40000 ALTER TABLE `om_pcash_deposit` DISABLE KEYS */;
INSERT INTO `om_pcash_deposit` (`id`, `pv_no`, `date`, `amount`, `remark`, `user_id`, `date_added`, `date_updated`) VALUES
	(1, 'PD1609/067', '2020-04-01', 150, 'testing deposit', 2, '2020-04-01 14:00:24', '2020-04-01 14:00:24'),
	(2, 'PD1675343', '2020-04-01', 5000, 'Initial balance', 2, '2020-04-01 14:00:44', '2020-04-01 14:00:44');
/*!40000 ALTER TABLE `om_pcash_deposit` ENABLE KEYS */;

-- Dumping structure for table admin.om_pcash_request
CREATE TABLE IF NOT EXISTS `om_pcash_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_date` date DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_per_unit` double NOT NULL,
  `total_cost` double NOT NULL,
  `workflow_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `cr_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table admin.om_pcash_request: ~2 rows (approximately)
/*!40000 ALTER TABLE `om_pcash_request` DISABLE KEYS */;
INSERT INTO `om_pcash_request` (`id`, `request_date`, `title`, `details`, `quantity`, `cost_per_unit`, `total_cost`, `workflow_status`, `user_id`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, '2020-03-30', 'Testing', 'testest', 1, 2.5, 2.5, 'Confirm', 2, 1, '2020-03-30 15:41:57', '2020-03-31 11:30:10'),
	(2, '2020-03-31', 'Chair', 'new chair for new staff at account department', 2, 50, 100, 'Confirm', 2, 3, '2020-03-31 08:26:53', '2020-04-01 14:01:30'),
	(3, '2020-03-31', 'Tissue', 'Tissue tandas untuk semua staff untuk bulan April', 20, 11, 220, 'Confirm', 2, 1, '2020-03-31 08:33:18', '2020-04-01 14:01:33');
/*!40000 ALTER TABLE `om_pcash_request` ENABLE KEYS */;

-- Dumping structure for table admin.om_requisition
CREATE TABLE IF NOT EXISTS `om_requisition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0-pending, 1-confirm, 3- rejected',
  `serial_no` varchar(50) DEFAULT NULL,
  `pv_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.om_requisition: 1 rows
/*!40000 ALTER TABLE `om_requisition` DISABLE KEYS */;
INSERT INTO `om_requisition` (`id`, `company_id`, `recipient`, `user_id`, `status`, `serial_no`, `pv_no`, `date`, `payment_date`) VALUES
	(1, 2, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-02', '2020-04-06'),
	(2, 10, 'Denis Liew', 2, 0, 'UFO123564894', NULL, '2020-04-03', '2020-04-10'),
	(3, 5, 'Denis Liew', 2, 0, 'SN123456790', NULL, '2020-04-03', '2020-04-09'),
	(4, 2, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-09'),
	(5, 4, 'Denis Liew', 2, 0, 'aq1232435466', NULL, '2020-04-03', '2020-04-15'),
	(6, 3, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(7, 1, 'Denis Liew', 2, 0, 'UFO123564894', NULL, '2020-04-03', '2020-04-03'),
	(8, 2, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(9, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(10, 4, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(11, 2, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(12, 3, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(13, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-04'),
	(14, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-04'),
	(15, 2, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(16, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(17, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(18, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(19, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(20, 1, 'Denis Liew', 2, 0, 'SN123456789', NULL, '2020-04-03', '2020-04-03'),
	(21, 2, 'Jenneffer Jiminit', 2, 0, 'SN123456789', NULL, '2020-04-04', '2020-04-04'),
	(22, 2, 'Jenneffer Jiminit', 2, 0, 'SN123456789', NULL, '2020-04-04', '2020-04-04'),
	(23, 2, 'Jenneffer Jiminit', 2, 0, 'SN123456789', NULL, '2020-04-04', '2020-04-04');
/*!40000 ALTER TABLE `om_requisition` ENABLE KEYS */;

-- Dumping structure for table admin.om_requisition_item
CREATE TABLE IF NOT EXISTS `om_requisition_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rq_id` int(11) DEFAULT NULL,
  `particular` text DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rq_id` (`rq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.om_requisition_item: 3 rows
/*!40000 ALTER TABLE `om_requisition_item` DISABLE KEYS */;
INSERT INTO `om_requisition_item` (`id`, `rq_id`, `particular`, `total`, `remark`) VALUES
	(1, 1, 'test1', 10, 'test saja'),
	(2, 1, 'test2', 10, 'test saja sy bilang tu'),
	(3, 1, 'test3', 10, 'test saja'),
	(4, 2, 'test1', 10, 'COMPH H/P J4'),
	(5, 3, 'test', 10, 'test saja'),
	(6, 4, 'test', 10, 'COMPH H/P J4'),
	(7, 5, 'test1', 10, 'COMPH H/P J4'),
	(8, 6, 'test1', 10, 'COMPH H/P J4'),
	(9, 7, 'test1', 10, 'test saja'),
	(10, 8, 'test', 10, 'COMPH H/P J4'),
	(11, 9, 'test1', 10, 'COMPH H/P J4'),
	(12, 10, 'test1', 10, 'COMPH H/P J4'),
	(13, 11, 'test', 10, 'COMPH H/P J4'),
	(14, 12, 'test', 10, 'COMPH H/P J4'),
	(15, 13, 'test', 10, 'COMPH H/P J4'),
	(16, 14, 'test', 10, 'COMPH H/P J4'),
	(17, 15, 'test', 10, 'COMPH H/P J4'),
	(18, 16, 'test', 10, 'COMPH H/P J4'),
	(19, 17, 'test', 10, 'COMPH H/P J4'),
	(20, 18, 'test', 10, 'COMPH H/P J4'),
	(21, 19, 'test', 10, 'COMPH H/P J4'),
	(22, 20, 'test', 10, 'COMPH H/P J4'),
	(23, 20, 'test1', 10, 'VIVO'),
	(24, 22, 'Chair for marketing department', 120, 'urgently needed'),
	(25, 23, 'Chair for marketing department', 120, 'urgently needed');
/*!40000 ALTER TABLE `om_requisition_item` ENABLE KEYS */;

-- Dumping structure for table admin.stationary_department
CREATE TABLE IF NOT EXISTS `stationary_department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.stationary_department: ~19 rows (approximately)
/*!40000 ALTER TABLE `stationary_department` DISABLE KEYS */;
INSERT INTO `stationary_department` (`department_id`, `department_code`, `status`) VALUES
	(1, 'ADMIN', 1),
	(2, 'IT HARDWARE	', 1),
	(3, 'ACCOUNTS', 1),
	(4, 'BILLING', 1),
	(5, 'CREDIT CONTROL', 1),
	(6, 'JUA NIKMAT', 1),
	(7, 'LOGISTIC', 1),
	(8, 'FEEDMIL', 1),
	(9, 'INVENTORY', 1),
	(10, 'FARM', 1),
	(11, 'PROCESSING PLANT', 1),
	(12, 'HR', 1),
	(13, 'MARKETING', 1),
	(14, 'BROILER', 1),
	(15, 'COLLECTIONS', 1),
	(16, 'LOGISTIC', 1),
	(17, 'LOADING', 1),
	(18, 'PURCHASING', 1),
	(19, 'HATCHERY', 1);
/*!40000 ALTER TABLE `stationary_department` ENABLE KEYS */;

-- Dumping structure for table admin.stationary_item
CREATE TABLE IF NOT EXISTS `stationary_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) DEFAULT NULL,
  `unit` varchar(25) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table admin.stationary_item: ~83 rows (approximately)
/*!40000 ALTER TABLE `stationary_item` DISABLE KEYS */;
INSERT INTO `stationary_item` (`id`, `item_name`, `unit`, `status`) VALUES
	(1, 'L-FOLDER A4 TRANSPARENTS', NULL, 1),
	(2, 'U-FOLDER A4 TRANSPARENTS', NULL, 1),
	(3, 'L-FOLDER COLOURFUL', NULL, 1),
	(4, 'ENVELOPE BROWN-HALF', NULL, 1),
	(5, 'ENVELOPE WHITE-WINDOW', NULL, 1),
	(6, 'ENVELOPE A3', NULL, 1),
	(7, 'ENVELOPE A4', NULL, 1),
	(8, 'ENVELOPE A5', NULL, 1),
	(9, 'INDEX DIVIDER-NUMBER', NULL, 0),
	(10, 'COLOURFUL PAPER-GREEN', NULL, 1),
	(11, 'COLOURFUL PAPER-PINK', NULL, 1),
	(12, 'WHITE STIKER', NULL, 1),
	(13, 'ASTAR PENGUIN PAPER CLIP(SMALL)', NULL, 1),
	(14, 'JUMBO GEM/ASTAR CLIPS(BIG)', NULL, 1),
	(15, 'DOUBLE CLIP-19MM', NULL, 1),
	(16, 'DOUBLE CLIP-25MM', NULL, 1),
	(17, 'DOUBLE CLIP-32MM', NULL, 1),
	(18, 'DOUBLE CLIP-41MM', NULL, 1),
	(19, 'DOUBLE CLIP-51MM', NULL, 1),
	(20, 'PERMANENT MARKER-BLUE', NULL, 1),
	(21, 'PERMANENT MARKER-BLACK', NULL, 1),
	(22, 'PERMANENT MARKER-RED', NULL, 1),
	(23, 'MULTIPURPOSE MARKER-BLUE', NULL, 1),
	(24, 'MULTIPURPOSE MARKER-BLACK', NULL, 1),
	(25, 'MULTIPURPOSE MARKER-RED', NULL, 1),
	(26, 'WHITEBOARD MARKER-BLUE', NULL, 1),
	(27, 'WHITEBOARD MARKER-BLACK', NULL, 1),
	(28, 'WHITEBOARD MARKER-RED', NULL, 1),
	(29, 'STAMPAD INK-BLUE', NULL, 1),
	(30, 'STAMPAD INK-BLACK', NULL, 1),
	(31, 'STAMPAD INK-RED', NULL, 1),
	(32, 'STAMPAD-BLUE', NULL, 1),
	(33, 'STAMPAD-BLACK', NULL, 1),
	(34, 'STAMPAD-RED', NULL, 1),
	(35, 'PAPER PUNCH', NULL, 1),
	(36, 'HP LASERJET 126A (CE310A) BLACK', NULL, 1),
	(37, 'HP LASERJET 126A (CE312A) YELLOW', NULL, 1),
	(38, 'HP LASERJET 126A (CE311A) CYAN', NULL, 1),
	(39, 'HP LASERJET 126A (CE313A) MAGENTA', NULL, 1),
	(40, 'HP OFFICEJET 901 TRI-COLOUR', NULL, 1),
	(41, 'HP OFFICEJET 901 BLACK', NULL, 1),
	(42, 'EPSON ERC-38B', NULL, 1),
	(43, 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON', NULL, 1),
	(44, 'AMANO CE-315250 TWO COLOUR', NULL, 1),
	(45, 'EPSON RIBBON CARTRIDGE-S015506/#7753', NULL, 1),
	(46, 'EPSON RIBBON CARTRIDGE-S015586/S015336', NULL, 1),
	(47, 'EPSON RIBBON CARTRIDGE-S015531/S015086', NULL, 1),
	(48, 'DELL 113X', NULL, 1),
	(49, 'BROTHER TN-2150', NULL, 1),
	(50, 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON', NULL, 1),
	(51, 'EXERCISE BOOK 76PAGES', NULL, 1),
	(52, 'EXERCISE BOOK 116PAGES', NULL, 1),
	(53, 'PURCHASE ORDER', NULL, 1),
	(54, 'BUKU BILL-SMALL', NULL, 1),
	(55, 'BUKU BILL-BIG', NULL, 1),
	(56, 'RECEIPT VOUCHER', NULL, 1),
	(57, 'MARKING INK- BLUE', NULL, 1),
	(58, 'MARKING INK-BLACK', NULL, 1),
	(59, 'EPSON T0873 MAGENTA', NULL, 1),
	(60, 'EPSON T0879 ORANGE', NULL, 1),
	(61, 'EPSON T0872 CYAN', NULL, 1),
	(62, 'EPSON T0878 MATTE BLACK', NULL, 1),
	(63, 'EPSON T0877 RED', NULL, 1),
	(64, 'EPSON T0874 YELLOW', NULL, 1),
	(65, 'SEIKO PRECISION #FB-60051', NULL, 0),
	(66, 'HP LASERJET 53A (Q7553A) BLACK', NULL, 1),
	(67, 'HP LASERJET 36A (C436A) BLACK', NULL, 1),
	(68, 'HP LASERJET 125A (CB542A) YELLOW', NULL, 1),
	(69, 'HP LASERJET 125A (CB540A) BLACK', NULL, 1),
	(70, 'HP LASERJET 125A (CB543A) MAGENTA', NULL, 1),
	(71, 'HP LASERJET 125A (CB541A) CYAN', NULL, 1),
	(72, 'SAMSUNG ML 2010 D3', NULL, 1),
	(128, 'EXERCISE BOOK 80PAGES', NULL, 1),
	(129, 'EXERCISE BOOK 120PAGES', NULL, 1),
	(130, 'COLOURFUL PAPER-BLUE', NULL, 1),
	(131, 'LASERJET TONER CATRIDGE (CC 388A)', NULL, 1),
	(132, 'HP LASERJET 125A BLACK', NULL, 1),
	(133, 'HP LASERJET 125A MAGENTA', NULL, 1),
	(134, 'HP LASERJET 125A CYAN', NULL, 1),
	(135, 'HP LASERJET 53 BLACK', NULL, 1),
	(136, 'SEIKO PRECISION (FB60051)', NULL, 1),
	(137, 'SEIKO PRECISION (FB 60051)', NULL, 0),
	(138, 'LASERJET TONER CATRIDGE (CC388A)', NULL, 1);
/*!40000 ALTER TABLE `stationary_item` ENABLE KEYS */;

-- Dumping structure for table admin.stationary_item_ori
CREATE TABLE IF NOT EXISTS `stationary_item_ori` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(40) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.stationary_item_ori: ~58 rows (approximately)
/*!40000 ALTER TABLE `stationary_item_ori` DISABLE KEYS */;
INSERT INTO `stationary_item_ori` (`id`, `item_name`, `unit`, `status`) VALUES
	(1, 'L-FOLDER A4 TRANSPARENTS', 'pieces', 1),
	(2, 'U-FOLDER A4 TRANSPARENTS', 'pieces', 1),
	(3, 'L-FOLDER COLOURFUL', 'pieces', 1),
	(4, 'EXERCISE BOOK 80PAGES', NULL, 1),
	(5, 'EXERCISE BOOK 120PAGES', NULL, 1),
	(6, 'ENVELOPE BROWN-HALF', NULL, 1),
	(7, 'ENVELOPE WHITE-WINDOW', NULL, 1),
	(8, 'ENVELOPE A3', NULL, 1),
	(9, 'ENVELOPE A4', NULL, 1),
	(10, 'ENVELOPE A5', NULL, 1),
	(11, 'INDEX DIVIDER-NUMBER', NULL, 1),
	(12, 'COLOURFULL PAPER-PINK', NULL, 1),
	(13, 'COLOURFUL PAPER-GREEN', NULL, 1),
	(14, 'COLOURFUL PAPER-BLUE', NULL, 1),
	(15, 'WHITE STIKER', NULL, 1),
	(16, 'ASTAR PENGUIN PAPER CLIP(SMALL)', NULL, 1),
	(17, 'JUMBO GEM/ASTAR CLIPS(BIG)', NULL, 1),
	(18, 'DOUBLE CLIP-19MM', NULL, 1),
	(19, 'DOUBLE CLIP-25MM', NULL, 1),
	(20, 'DOUBLE CLIP-32MM', NULL, 1),
	(21, 'DOUBLE CLIP-41MM', NULL, 1),
	(22, 'DOUBLE CLIP-51MM', NULL, 1),
	(23, 'PERMANENT MARKER-BLUE', NULL, 1),
	(24, 'PERMANENT MARKER-BLACK', NULL, 1),
	(25, 'PERMANENT MARKER-RED', NULL, 1),
	(26, 'MULTIPURPOSE MARKER-BLUE', NULL, 1),
	(27, 'MULTIPURPOSE MARKER-BLACK', NULL, 1),
	(28, 'MULTIPURPOSE MARKER-RED', NULL, 1),
	(29, 'WHITEBOARD MARKER-BLUE', NULL, 1),
	(30, 'WHITEBOARD MARKER-BLACK', NULL, 1),
	(31, 'WHITEBOARD MARKER-RED', NULL, 1),
	(32, 'STAMPAD INK-BLUE', NULL, 1),
	(33, 'STAMPAD INK-BLACK', NULL, 1),
	(34, 'STAMPAD INK-RED', NULL, 1),
	(35, 'STAMPAD-BLUE', NULL, 1),
	(36, 'STAMPAD-BLACK', NULL, 1),
	(37, 'STAMPAD-RED', NULL, 1),
	(38, 'PAPER PUNCH', NULL, 1),
	(39, 'HP LASERJET 126A (CE310A) BLACK', NULL, 1),
	(40, 'HP LASERJET 126A (CE312A) YELLOW', NULL, 1),
	(41, 'HP LASERJET 126A (CE311A) CYAN', NULL, 1),
	(42, 'HP LASERJET 126A (CE313A) MAGENTA', NULL, 1),
	(43, 'HP OFFICEJET 901 TRI-COLOUR', NULL, 1),
	(44, 'HP OFFICEJET 901 BLACK', NULL, 1),
	(45, 'EPSON ERC-38B', NULL, 1),
	(46, 'PRINTONIX P7000 ULTRA CAPACITY PRINTER R', NULL, 1),
	(47, 'AMANO CE-315250 TWO COLOUR', NULL, 1),
	(48, 'EPSON RIBBON CARTRIDGE-S015506/#7753', NULL, 1),
	(49, 'EPSON RIBBON CARTRIDGE-S015586/S015336', NULL, 1),
	(50, 'EPSON RIBBON CARTRIDGE-S015531/S015086', NULL, 1),
	(51, 'DELL 113X', NULL, 1),
	(52, 'BROTHER TN-2150', NULL, 1),
	(53, 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON', NULL, 1),
	(54, 'HP LASERJET 125A BLACK', NULL, 1),
	(55, 'HP LASERJET 125A MAGENTA', NULL, 1),
	(56, 'HP LASERJET 125A CYAN', NULL, 1),
	(57, 'HP LASERJET 125A YELLOW', NULL, 1),
	(58, 'test', NULL, 1);
/*!40000 ALTER TABLE `stationary_item_ori` ENABLE KEYS */;

-- Dumping structure for table admin.stationary_stock
CREATE TABLE IF NOT EXISTS `stationary_stock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `stock_in` int(11) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.stationary_stock: ~4 rows (approximately)
/*!40000 ALTER TABLE `stationary_stock` DISABLE KEYS */;
INSERT INTO `stationary_stock` (`id`, `item_id`, `stock_in`, `date_added`, `status`) VALUES
	(1, 2, 49, '2020-02-27', 1),
	(2, 2, 7, '2020-02-27', 0),
	(3, 4, 15, '2020-02-27', 1),
	(4, 14, 15, '2020-02-27', 1);
/*!40000 ALTER TABLE `stationary_stock` ENABLE KEYS */;

-- Dumping structure for table admin.stationary_stock_balance
CREATE TABLE IF NOT EXISTS `stationary_stock_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `stock_balance` int(11) DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.stationary_stock_balance: ~3 rows (approximately)
/*!40000 ALTER TABLE `stationary_stock_balance` DISABLE KEYS */;
INSERT INTO `stationary_stock_balance` (`id`, `item_id`, `stock_balance`, `last_updated`, `updated_by`) VALUES
	(1, 2, 44, '2020-03-12', 2),
	(2, 4, 14, '2020-02-29', 2),
	(3, 14, 14, '2020-02-29', 2);
/*!40000 ALTER TABLE `stationary_stock_balance` ENABLE KEYS */;

-- Dumping structure for table admin.stationary_stock_take
CREATE TABLE IF NOT EXISTS `stationary_stock_take` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `date_taken` date DEFAULT NULL,
  `department_code` varchar(50) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=944 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table admin.stationary_stock_take: ~680 rows (approximately)
/*!40000 ALTER TABLE `stationary_stock_take` DISABLE KEYS */;
INSERT INTO `stationary_stock_take` (`id`, `department_id`, `item_id`, `quantity`, `date_added`, `date_taken`, `department_code`, `item_name`) VALUES
	(1, 1, 3, 1, NULL, '2019-02-28', 'ADMIN', 'L-FOLDER COLOURFUL'),
	(2, 1, 5, 1, NULL, '2019-02-28', 'ADMIN', 'ENVELOPE WHITE-WINDOW'),
	(3, 1, 17, 1, NULL, '2019-02-28', 'ADMIN', 'DOUBLE CLIP-32MM'),
	(4, 1, 18, 1, NULL, '2019-02-28', 'ADMIN', 'DOUBLE CLIP-41MM'),
	(5, 1, 20, 1, NULL, '2019-02-28', 'ADMIN', 'PERMANENT MARKER-BLUE'),
	(8, 1, 1, 5, NULL, '2019-01-31', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(9, 1, 2, 7, NULL, '2019-01-31', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(10, 1, 51, 3, NULL, '2019-01-31', 'ADMIN', 'EXERCISE BOOK 76PAGES'),
	(11, 1, 52, 2, NULL, '2019-01-31', 'ADMIN', 'EXERCISE BOOK 116PAGES'),
	(12, 1, 11, 32, NULL, '2019-01-31', 'ADMIN', 'COLOURFUL PAPER-PINK'),
	(13, 1, 15, 1, NULL, '2019-01-31', 'ADMIN', 'DOUBLE CLIP-19MM'),
	(14, 1, 18, 1, NULL, '2019-01-31', 'ADMIN', 'DOUBLE CLIP-41MM'),
	(15, 1, 27, 2, NULL, '2019-01-31', 'ADMIN', 'WHITEBOARD MARKER-BLACK'),
	(23, 1, 2, 3, NULL, '2019-03-31', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(24, 1, 51, 3, NULL, '2019-03-31', 'ADMIN', 'EXERCISE BOOK 76PAGES'),
	(25, 1, 52, 1, NULL, '2019-03-31', 'ADMIN', 'EXERCISE BOOK 116PAGES'),
	(26, 1, 9, 1, NULL, '2019-03-31', 'ADMIN', 'INDEX DIVIDER-NUMBER'),
	(27, 1, 11, 40, NULL, '2019-03-31', 'ADMIN', 'COLOURFUL PAPER-PINK'),
	(30, 1, 1, 5, NULL, '2019-04-30', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(31, 1, 128, 1, NULL, '2019-04-30', 'ADMIN', 'EXERCISE BOOK 80PAGES'),
	(32, 1, 6, 3, NULL, '2019-04-30', 'ADMIN', 'ENVELOPE A3'),
	(33, 1, 7, 7, NULL, '2019-04-30', 'ADMIN', 'ENVELOPE A4'),
	(34, 1, 11, 20, NULL, '2019-04-30', 'ADMIN', 'COLOURFUL PAPER-PINK'),
	(35, 1, 26, 1, NULL, '2019-04-30', 'ADMIN', 'WHITEBOARD MARKER-BLUE'),
	(36, 1, 27, 1, NULL, '2019-04-30', 'ADMIN', 'WHITEBOARD MARKER-BLACK'),
	(37, 1, 28, 1, NULL, '2019-04-30', 'ADMIN', 'WHITEBOARD MARKER-RED'),
	(45, 1, 1, 6, NULL, '2019-05-31', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(46, 1, 2, 4, NULL, '2019-05-31', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(47, 1, 129, 1, NULL, '2019-05-31', 'ADMIN', 'EXERCISE BOOK 120PAGES'),
	(48, 1, 7, 4, NULL, '2019-05-31', 'ADMIN', 'ENVELOPE A4'),
	(49, 1, 11, 2, NULL, '2019-05-31', 'ADMIN', 'COLOURFUL PAPER-PINK'),
	(50, 1, 19, 2, NULL, '2019-05-31', 'ADMIN', 'DOUBLE CLIP-51MM'),
	(51, 1, 30, 1, NULL, '2019-05-31', 'ADMIN', 'STAMPAD INK-BLACK'),
	(52, 1, 32, 1, NULL, '2019-05-31', 'ADMIN', 'STAMPAD-BLUE'),
	(60, 1, 1, 7, NULL, '2019-06-30', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(61, 1, 2, 5, NULL, '2019-06-30', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(62, 1, 128, 1, NULL, '2019-06-30', 'ADMIN', 'EXERCISE BOOK 80PAGES'),
	(63, 1, 7, 5, NULL, '2019-06-30', 'ADMIN', 'ENVELOPE A4'),
	(67, 1, 2, 2, NULL, '2019-07-31', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(68, 1, 129, 1, NULL, '2019-07-31', 'ADMIN', 'EXERCISE BOOK 120PAGES'),
	(69, 1, 7, 10, NULL, '2019-07-31', 'ADMIN', 'ENVELOPE A4'),
	(70, 1, 16, 2, NULL, '2019-07-31', 'ADMIN', 'DOUBLE CLIP-25MM'),
	(71, 1, 27, 1, NULL, '2019-07-31', 'ADMIN', 'WHITEBOARD MARKER-BLACK'),
	(74, 1, 1, 1, NULL, '2019-08-31', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(75, 1, 2, 16, NULL, '2019-08-31', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(76, 1, 3, 16, NULL, '2019-08-31', 'ADMIN', 'L-FOLDER COLOURFUL'),
	(77, 1, 128, 1, NULL, '2019-08-31', 'ADMIN', 'EXERCISE BOOK 80PAGES'),
	(78, 1, 129, 4, NULL, '2019-08-31', 'ADMIN', 'EXERCISE BOOK 120PAGES'),
	(79, 1, 4, 5, NULL, '2019-08-31', 'ADMIN', 'ENVELOPE BROWN-HALF'),
	(80, 1, 5, 5, NULL, '2019-08-31', 'ADMIN', 'ENVELOPE WHITE-WINDOW'),
	(81, 1, 7, 15, NULL, '2019-08-31', 'ADMIN', 'ENVELOPE A4'),
	(82, 1, 8, 5, NULL, '2019-08-31', 'ADMIN', 'ENVELOPE A5'),
	(89, 1, 1, 4, NULL, '2019-09-30', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(90, 1, 2, 1, NULL, '2019-09-30', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(91, 1, 128, 2, NULL, '2019-09-30', 'ADMIN', 'EXERCISE BOOK 80PAGES'),
	(92, 1, 7, 1, NULL, '2019-09-30', 'ADMIN', 'ENVELOPE A4'),
	(93, 1, 130, 5, NULL, '2019-09-30', 'ADMIN', 'COLOURFUL PAPER-BLUE'),
	(94, 1, 18, 2, NULL, '2019-09-30', 'ADMIN', 'DOUBLE CLIP-41MM'),
	(95, 1, 19, 2, NULL, '2019-09-30', 'ADMIN', 'DOUBLE CLIP-51MM'),
	(96, 1, 27, 1, NULL, '2019-09-30', 'ADMIN', 'WHITEBOARD MARKER-BLACK'),
	(104, 1, 1, 12, NULL, '2019-10-31', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(105, 1, 2, 7, NULL, '2019-10-31', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(106, 1, 128, 1, NULL, '2019-10-31', 'ADMIN', 'EXERCISE BOOK 80PAGES'),
	(107, 1, 7, 6, NULL, '2019-10-31', 'ADMIN', 'ENVELOPE A4'),
	(108, 1, 28, 1, NULL, '2019-10-31', 'ADMIN', 'WHITEBOARD MARKER-RED'),
	(111, 1, 2, 1, NULL, '2019-11-30', 'ADMIN', 'U-FOLDER A4 TRANSPARENTS'),
	(112, 1, 3, 2, NULL, '2019-11-30', 'ADMIN', 'L-FOLDER COLOURFUL'),
	(113, 1, 129, 1, NULL, '2019-11-30', 'ADMIN', 'EXERCISE BOOK 120PAGES'),
	(114, 1, 5, 10, NULL, '2019-11-30', 'ADMIN', 'ENVELOPE WHITE-WINDOW'),
	(118, 1, 1, 5, NULL, '2019-12-31', 'ADMIN', 'L-FOLDER A4 TRANSPARENTS'),
	(119, 1, 7, 2, NULL, '2019-12-31', 'ADMIN', 'ENVELOPE A4'),
	(121, 2, 19, 1, NULL, '2019-01-31', 'IT HARDWARE', 'DOUBLE CLIP-51MM'),
	(122, 2, 21, 1, NULL, '2019-02-28', 'IT HARDWARE', 'PERMANENT MARKER-BLACK'),
	(123, 2, 1, 1, NULL, '2019-04-30', 'IT HARDWARE', 'L-FOLDER A4 TRANSPARENTS'),
	(124, 2, 4, 1, NULL, '2019-04-30', 'IT HARDWARE', 'ENVELOPE BROWN-HALF'),
	(126, 2, 4, 1, NULL, '2019-05-31', 'IT HARDWARE', 'ENVELOPE BROWN-HALF'),
	(127, 2, 13, 2, NULL, '2019-06-30', 'IT HARDWARE', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(128, 2, 19, 3, NULL, '2019-06-30', 'IT HARDWARE', 'DOUBLE CLIP-51MM'),
	(130, 2, 2, 11, NULL, '2019-07-31', 'IT HARDWARE', 'U-FOLDER A4 TRANSPARENTS'),
	(131, 2, 7, 1, NULL, '2019-07-31', 'IT HARDWARE', 'ENVELOPE A4'),
	(132, 2, 18, 1, NULL, '2019-07-31', 'IT HARDWARE', 'DOUBLE CLIP-41MM'),
	(133, 2, 13, 1, NULL, '2019-08-31', 'IT HARDWARE', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(134, 2, 47, 1, NULL, '2019-09-30', 'IT HARDWARE', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(135, 2, 26, 2, NULL, '2019-11-30', 'IT HARDWARE', 'WHITEBOARD MARKER-BLUE'),
	(136, 2, 27, 3, NULL, '2019-11-30', 'IT HARDWARE', 'WHITEBOARD MARKER-BLACK'),
	(137, 2, 28, 3, NULL, '2019-11-30', 'IT HARDWARE', 'WHITEBOARD MARKER-RED'),
	(138, 2, 7, 5, NULL, '2019-12-31', 'IT HARDWARE', 'ENVELOPE A4'),
	(139, 3, 1, 10, NULL, '2019-01-31', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(140, 3, 3, 5, NULL, '2019-01-31', 'ACCOUNTS', 'L-FOLDER COLOURFUL'),
	(141, 3, 52, 1, NULL, '2019-01-31', 'ACCOUNTS', 'EXERCISE BOOK 116PAGES'),
	(142, 3, 7, 7, NULL, '2019-01-31', 'ACCOUNTS', 'ENVELOPE A4'),
	(143, 3, 46, 1, NULL, '2019-01-31', 'ACCOUNTS', 'EPSON RIBBON CARTRIDGE-S015586/S015336'),
	(146, 3, 1, 20, NULL, '2019-02-28', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(147, 3, 10, 5, NULL, '2019-02-28', 'ACCOUNTS', 'COLOURFUL PAPER-GREEN'),
	(148, 3, 13, 3, NULL, '2019-02-28', 'ACCOUNTS', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(149, 3, 14, 1, NULL, '2019-02-28', 'ACCOUNTS', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(150, 3, 15, 2, NULL, '2019-02-28', 'ACCOUNTS', 'DOUBLE CLIP-19MM'),
	(151, 3, 18, 1, NULL, '2019-02-28', 'ACCOUNTS', 'DOUBLE CLIP-41MM'),
	(153, 3, 7, 1, NULL, '2019-03-31', 'ACCOUNTS', 'ENVELOPE A4'),
	(154, 3, 11, 40, NULL, '2019-03-31', 'ACCOUNTS', 'COLOURFUL PAPER-PINK'),
	(155, 3, 32, 1, NULL, '2019-03-31', 'ACCOUNTS', 'STAMPAD-BLUE'),
	(156, 3, 7, 5, NULL, '2019-04-30', 'ACCOUNTS', 'ENVELOPE A4'),
	(157, 3, 15, 12, NULL, '2019-04-30', 'ACCOUNTS', 'DOUBLE CLIP-19MM'),
	(159, 3, 1, 10, NULL, '2019-05-31', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(160, 3, 2, 1, NULL, '2019-05-31', 'ACCOUNTS', 'U-FOLDER A4 TRANSPARENTS'),
	(161, 3, 129, 2, NULL, '2019-05-31', 'ACCOUNTS', 'EXERCISE BOOK 120PAGES'),
	(162, 3, 7, 32, NULL, '2019-05-31', 'ACCOUNTS', 'ENVELOPE A4'),
	(163, 3, 15, 2, NULL, '2019-05-31', 'ACCOUNTS', 'DOUBLE CLIP-19MM'),
	(164, 3, 16, 2, NULL, '2019-05-31', 'ACCOUNTS', 'DOUBLE CLIP-25MM'),
	(166, 3, 1, 15, NULL, '2019-06-30', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(167, 3, 3, 15, NULL, '2019-06-30', 'ACCOUNTS', 'L-FOLDER COLOURFUL'),
	(168, 3, 7, 2, NULL, '2019-06-30', 'ACCOUNTS', 'ENVELOPE A4'),
	(169, 3, 20, 2, NULL, '2019-06-30', 'ACCOUNTS', 'PERMANENT MARKER-BLUE'),
	(170, 3, 29, 1, NULL, '2019-06-30', 'ACCOUNTS', 'STAMPAD INK-BLUE'),
	(173, 3, 1, 2, NULL, '2019-07-31', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(174, 3, 2, 2, NULL, '2019-07-31', 'ACCOUNTS', 'U-FOLDER A4 TRANSPARENTS'),
	(175, 3, 129, 3, NULL, '2019-07-31', 'ACCOUNTS', 'EXERCISE BOOK 120PAGES'),
	(176, 3, 7, 10, NULL, '2019-07-31', 'ACCOUNTS', 'ENVELOPE A4'),
	(177, 3, 15, 2, NULL, '2019-07-31', 'ACCOUNTS', 'DOUBLE CLIP-19MM'),
	(178, 3, 17, 1, NULL, '2019-07-31', 'ACCOUNTS', 'DOUBLE CLIP-32MM'),
	(179, 3, 20, 1, NULL, '2019-07-31', 'ACCOUNTS', 'PERMANENT MARKER-BLUE'),
	(180, 3, 7, 5, NULL, '2019-08-31', 'ACCOUNTS', 'ENVELOPE A4'),
	(181, 3, 11, 20, NULL, '2019-08-31', 'ACCOUNTS', 'COLOURFUL PAPER-PINK'),
	(182, 3, 13, 1, NULL, '2019-08-31', 'ACCOUNTS', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(183, 3, 15, 1, NULL, '2019-08-31', 'ACCOUNTS', 'DOUBLE CLIP-19MM'),
	(184, 3, 19, 10, NULL, '2019-08-31', 'ACCOUNTS', 'DOUBLE CLIP-51MM'),
	(185, 3, 20, 1, NULL, '2019-08-31', 'ACCOUNTS', 'PERMANENT MARKER-BLUE'),
	(186, 3, 43, 1, NULL, '2019-08-31', 'ACCOUNTS', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(187, 3, 47, 1, NULL, '2019-08-31', 'ACCOUNTS', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(188, 3, 50, 1, NULL, '2019-08-31', 'ACCOUNTS', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(195, 3, 1, 16, NULL, '2019-09-30', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(196, 3, 3, 3, NULL, '2019-09-30', 'ACCOUNTS', 'L-FOLDER COLOURFUL'),
	(197, 3, 7, 16, NULL, '2019-09-30', 'ACCOUNTS', 'ENVELOPE A4'),
	(198, 3, 15, 5, NULL, '2019-09-30', 'ACCOUNTS', 'DOUBLE CLIP-19MM'),
	(199, 3, 17, 1, NULL, '2019-09-30', 'ACCOUNTS', 'DOUBLE CLIP-32MM'),
	(200, 3, 19, 5, NULL, '2019-09-30', 'ACCOUNTS', 'DOUBLE CLIP-51MM'),
	(201, 3, 29, 1, NULL, '2019-09-30', 'ACCOUNTS', 'STAMPAD INK-BLUE'),
	(202, 3, 1, 2, NULL, '2019-10-31', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(203, 3, 129, 1, NULL, '2019-10-31', 'ACCOUNTS', 'EXERCISE BOOK 120PAGES'),
	(204, 3, 4, 1, NULL, '2019-10-31', 'ACCOUNTS', 'ENVELOPE BROWN-HALF'),
	(205, 3, 7, 1, NULL, '2019-10-31', 'ACCOUNTS', 'ENVELOPE A4'),
	(206, 3, 13, 1, NULL, '2019-10-31', 'ACCOUNTS', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(207, 3, 15, 1, NULL, '2019-10-31', 'ACCOUNTS', 'DOUBLE CLIP-19MM'),
	(208, 3, 17, 1, NULL, '2019-10-31', 'ACCOUNTS', 'DOUBLE CLIP-32MM'),
	(209, 3, 19, 12, NULL, '2019-10-31', 'ACCOUNTS', 'DOUBLE CLIP-51MM'),
	(210, 3, 29, 1, NULL, '2019-10-31', 'ACCOUNTS', 'STAMPAD INK-BLUE'),
	(217, 3, 1, 33, NULL, '2019-11-30', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(218, 3, 129, 1, NULL, '2019-11-30', 'ACCOUNTS', 'EXERCISE BOOK 120PAGES'),
	(219, 3, 7, 23, NULL, '2019-11-30', 'ACCOUNTS', 'ENVELOPE A4'),
	(220, 3, 13, 2, NULL, '2019-11-30', 'ACCOUNTS', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(221, 3, 16, 1, NULL, '2019-11-30', 'ACCOUNTS', 'DOUBLE CLIP-25MM'),
	(222, 3, 17, 1, NULL, '2019-11-30', 'ACCOUNTS', 'DOUBLE CLIP-32MM'),
	(224, 3, 1, 2, NULL, '2019-12-31', 'ACCOUNTS', 'L-FOLDER A4 TRANSPARENTS'),
	(225, 3, 129, 2, NULL, '2019-12-31', 'ACCOUNTS', 'EXERCISE BOOK 120PAGES'),
	(226, 3, 6, 1, NULL, '2019-12-31', 'ACCOUNTS', 'ENVELOPE A3'),
	(227, 3, 7, 13, NULL, '2019-12-31', 'ACCOUNTS', 'ENVELOPE A4'),
	(228, 3, 13, 1, NULL, '2019-12-31', 'ACCOUNTS', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(231, 4, 5, 5, NULL, '2019-01-31', 'BILLING', 'ENVELOPE WHITE-WINDOW'),
	(232, 4, 14, 1, NULL, '2019-01-31', 'BILLING', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(233, 4, 43, 4, NULL, '2019-01-31', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(234, 4, 50, 3, NULL, '2019-01-31', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(238, 4, 4, 10, NULL, '2019-02-28', 'BILLING', 'ENVELOPE BROWN-HALF'),
	(239, 4, 7, 2, NULL, '2019-02-28', 'BILLING', 'ENVELOPE A4'),
	(240, 4, 42, 1, NULL, '2019-02-28', 'BILLING', 'EPSON ERC-38B'),
	(241, 4, 43, 1, NULL, '2019-02-28', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(242, 4, 50, 1, NULL, '2019-02-28', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(245, 4, 51, 1, NULL, '2019-03-31', 'BILLING', 'EXERCISE BOOK 76PAGES'),
	(246, 4, 52, 5, NULL, '2019-03-31', 'BILLING', 'EXERCISE BOOK 116PAGES'),
	(247, 4, 43, 2, NULL, '2019-03-31', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(248, 4, 50, 2, NULL, '2019-03-31', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(252, 4, 20, 1, NULL, '2019-04-30', 'BILLING', 'PERMANENT MARKER-BLUE'),
	(253, 4, 29, 1, NULL, '2019-04-30', 'BILLING', 'STAMPAD INK-BLUE'),
	(254, 4, 50, 3, NULL, '2019-04-30', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(255, 4, 129, 1, NULL, '2019-05-31', 'BILLING', 'EXERCISE BOOK 120PAGES'),
	(256, 4, 13, 2, NULL, '2019-05-31', 'BILLING', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(257, 4, 43, 2, NULL, '2019-05-31', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(258, 4, 50, 2, NULL, '2019-05-31', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(262, 4, 29, 1, NULL, '2019-06-30', 'BILLING', 'STAMPAD INK-BLUE'),
	(263, 4, 1, 7, NULL, '2019-07-31', 'BILLING', 'L-FOLDER A4 TRANSPARENTS'),
	(264, 4, 22, 1, NULL, '2019-07-31', 'BILLING', 'PERMANENT MARKER-RED'),
	(265, 4, 43, 3, NULL, '2019-07-31', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(266, 4, 4, 1, NULL, '2019-08-31', 'BILLING', 'ENVELOPE BROWN-HALF'),
	(267, 4, 43, 2, NULL, '2019-08-31', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(268, 4, 47, 1, NULL, '2019-08-31', 'BILLING', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(269, 4, 50, 3, NULL, '2019-08-31', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(273, 4, 29, 2, NULL, '2019-09-30', 'BILLING', 'STAMPAD INK-BLUE'),
	(274, 4, 30, 1, NULL, '2019-09-30', 'BILLING', 'STAMPAD INK-BLACK'),
	(275, 4, 50, 4, NULL, '2019-09-30', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(276, 4, 30, 1, NULL, '2019-10-31', 'BILLING', 'STAMPAD INK-BLACK'),
	(277, 4, 43, 2, NULL, '2019-10-31', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(279, 4, 43, 2, NULL, '2019-11-30', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(280, 4, 47, 1, NULL, '2019-11-30', 'BILLING', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(281, 4, 50, 4, NULL, '2019-11-30', 'BILLING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(282, 4, 7, 1, NULL, '2019-12-31', 'BILLING', 'ENVELOPE A4'),
	(283, 4, 43, 1, NULL, '2019-12-31', 'BILLING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(284, 4, 49, 1, NULL, '2019-12-31', 'BILLING', 'BROTHER TN-2150'),
	(285, 5, 1, 4, NULL, '2019-01-31', 'CREDIT CONTROL', 'L-FOLDER A4 TRANSPARENTS'),
	(286, 5, 1, 24, NULL, '2019-02-28', 'CREDIT CONTROL', 'L-FOLDER A4 TRANSPARENTS'),
	(287, 5, 7, 21, NULL, '2019-02-28', 'CREDIT CONTROL', 'ENVELOPE A4'),
	(289, 5, 1, 5, NULL, '2019-03-31', 'CREDIT CONTROL', 'L-FOLDER A4 TRANSPARENTS'),
	(290, 5, 5, 20, NULL, '2019-03-31', 'CREDIT CONTROL', 'ENVELOPE WHITE-WINDOW'),
	(291, 5, 7, 1, NULL, '2019-03-31', 'CREDIT CONTROL', 'ENVELOPE A4'),
	(292, 5, 14, 2, NULL, '2019-03-31', 'CREDIT CONTROL', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(293, 5, 32, 1, NULL, '2019-03-31', 'CREDIT CONTROL', 'STAMPAD-BLUE'),
	(296, 5, 129, 1, NULL, '2019-04-30', 'CREDIT CONTROL', 'EXERCISE BOOK 120PAGES'),
	(297, 5, 5, 20, NULL, '2019-04-30', 'CREDIT CONTROL', 'ENVELOPE WHITE-WINDOW'),
	(298, 5, 7, 20, NULL, '2019-04-30', 'CREDIT CONTROL', 'ENVELOPE A4'),
	(299, 5, 15, 4, NULL, '2019-05-31', 'CREDIT CONTROL', 'DOUBLE CLIP-19MM'),
	(300, 5, 3, 18, NULL, '2019-06-30', 'CREDIT CONTROL', 'L-FOLDER COLOURFUL'),
	(301, 5, 15, 2, NULL, '2019-06-30', 'CREDIT CONTROL', 'DOUBLE CLIP-19MM'),
	(303, 5, 30, 1, NULL, '2019-07-31', 'CREDIT CONTROL', 'STAMPAD INK-BLACK'),
	(304, 5, 2, 20, NULL, '2019-08-31', 'CREDIT CONTROL', 'U-FOLDER A4 TRANSPARENTS'),
	(305, 5, 7, 10, NULL, '2019-09-30', 'CREDIT CONTROL', 'ENVELOPE A4'),
	(306, 5, 7, 10, NULL, '2019-10-31', 'CREDIT CONTROL', 'ENVELOPE A4'),
	(307, 5, 1, 20, NULL, '2019-11-30', 'CREDIT CONTROL', 'L-FOLDER A4 TRANSPARENTS'),
	(308, 5, 2, 20, NULL, '2019-11-30', 'CREDIT CONTROL', 'U-FOLDER A4 TRANSPARENTS'),
	(309, 5, 9, 2, NULL, '2019-11-30', 'CREDIT CONTROL', 'INDEX DIVIDER-NUMBER'),
	(310, 5, 5, 50, NULL, '2019-12-31', 'CREDIT CONTROL', 'ENVELOPE WHITE-WINDOW'),
	(311, 5, 7, 20, NULL, '2019-12-31', 'CREDIT CONTROL', 'ENVELOPE A4'),
	(312, 5, 13, 2, NULL, '2019-12-31', 'CREDIT CONTROL', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(313, 5, 15, 4, NULL, '2019-12-31', 'CREDIT CONTROL', 'DOUBLE CLIP-19MM'),
	(317, 6, 1, 15, NULL, '2019-02-01', 'JUA NIKMAT', 'L-FOLDER A4 TRANSPARENTS'),
	(318, 6, 51, 10, NULL, '2019-02-01', 'JUA NIKMAT', 'EXERCISE BOOK 76PAGES'),
	(319, 6, 13, 1, NULL, '2019-02-01', 'JUA NIKMAT', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(320, 6, 29, 2, NULL, '2019-02-01', 'JUA NIKMAT', 'STAMPAD INK-BLUE'),
	(324, 6, 20, 5, NULL, '2019-03-01', 'JUA NIKMAT', 'PERMANENT MARKER-BLUE'),
	(325, 6, 21, 5, NULL, '2019-03-01', 'JUA NIKMAT', 'PERMANENT MARKER-BLACK'),
	(326, 6, 29, 1, NULL, '2019-03-01', 'JUA NIKMAT', 'STAMPAD INK-BLUE'),
	(327, 6, 32, 1, NULL, '2019-03-01', 'JUA NIKMAT', 'STAMPAD-BLUE'),
	(331, 6, 20, 12, NULL, '2019-10-01', 'JUA NIKMAT', 'PERMANENT MARKER-BLUE'),
	(332, 6, 21, 12, NULL, '2019-10-01', 'JUA NIKMAT', 'PERMANENT MARKER-BLACK'),
	(334, 20, 52, 2, NULL, '2019-02-01', 'STORE', 'EXERCISE BOOK 116PAGES'),
	(335, 20, 20, 12, NULL, '2019-02-01', 'STORE', 'PERMANENT MARKER-BLUE'),
	(337, 20, 4, 1, NULL, '2019-03-01', 'STORE', 'ENVELOPE BROWN-HALF'),
	(338, 20, 20, 1, NULL, '2019-03-01', 'STORE', 'PERMANENT MARKER-BLUE'),
	(339, 20, 21, 1, NULL, '2019-03-01', 'STORE', 'PERMANENT MARKER-BLACK'),
	(340, 8, 52, 2, NULL, '2019-01-01', 'FEEDMIL', 'EXERCISE BOOK 116PAGES'),
	(341, 8, 20, 2, NULL, '2019-01-01', 'FEEDMIL', 'PERMANENT MARKER-BLUE'),
	(342, 8, 21, 1, NULL, '2019-01-01', 'FEEDMIL', 'PERMANENT MARKER-BLACK'),
	(343, 8, 32, 1, NULL, '2019-01-01', 'FEEDMIL', 'STAMPAD-BLUE'),
	(347, 8, 13, 2, NULL, '2019-02-01', 'FEEDMIL', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(348, 8, 17, 1, NULL, '2019-02-01', 'FEEDMIL', 'DOUBLE CLIP-32MM'),
	(349, 8, 20, 1, NULL, '2019-02-01', 'FEEDMIL', 'PERMANENT MARKER-BLUE'),
	(350, 8, 21, 1, NULL, '2019-02-01', 'FEEDMIL', 'PERMANENT MARKER-BLACK'),
	(354, 8, 14, 1, NULL, '2019-03-01', 'FEEDMIL', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(355, 8, 17, 1, NULL, '2019-03-01', 'FEEDMIL', 'DOUBLE CLIP-32MM'),
	(357, 8, 7, 15, NULL, '2019-04-01', 'FEEDMIL', 'ENVELOPE A4'),
	(358, 8, 20, 21, NULL, '2019-05-01', 'FEEDMIL', 'PERMANENT MARKER-BLUE'),
	(359, 8, 21, 1, NULL, '2019-05-01', 'FEEDMIL', 'PERMANENT MARKER-BLACK'),
	(360, 8, 22, 3, NULL, '2019-05-01', 'FEEDMIL', 'PERMANENT MARKER-RED'),
	(361, 8, 26, 2, NULL, '2019-05-01', 'FEEDMIL', 'WHITEBOARD MARKER-BLUE'),
	(362, 8, 27, 1, NULL, '2019-05-01', 'FEEDMIL', 'WHITEBOARD MARKER-BLACK'),
	(365, 8, 9, 3, NULL, '2019-06-01', 'FEEDMIL', 'INDEX DIVIDER-NUMBER'),
	(366, 8, 12, 2, NULL, '2019-07-01', 'FEEDMIL', 'WHITE STIKER'),
	(367, 8, 20, 22, NULL, '2019-08-01', 'FEEDMIL', 'PERMANENT MARKER-BLUE'),
	(368, 8, 21, 24, NULL, '2019-08-01', 'FEEDMIL', 'PERMANENT MARKER-BLACK'),
	(369, 8, 22, 5, NULL, '2019-08-01', 'FEEDMIL', 'PERMANENT MARKER-RED'),
	(370, 8, 27, 1, NULL, '2019-08-01', 'FEEDMIL', 'WHITEBOARD MARKER-BLACK'),
	(371, 8, 29, 1, NULL, '2019-08-01', 'FEEDMIL', 'STAMPAD INK-BLUE'),
	(374, 8, 14, 1, NULL, '2019-09-01', 'FEEDMIL', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(375, 8, 15, 1, NULL, '2019-09-01', 'FEEDMIL', 'DOUBLE CLIP-19MM'),
	(376, 8, 16, 1, NULL, '2019-09-01', 'FEEDMIL', 'DOUBLE CLIP-25MM'),
	(377, 8, 17, 2, NULL, '2019-09-01', 'FEEDMIL', 'DOUBLE CLIP-32MM'),
	(378, 8, 20, 12, NULL, '2019-09-01', 'FEEDMIL', 'PERMANENT MARKER-BLUE'),
	(379, 8, 32, 1, NULL, '2019-09-01', 'FEEDMIL', 'STAMPAD-BLUE'),
	(380, 8, 131, 1, NULL, '2019-09-01', 'FEEDMIL', 'LASERJET TONER CATRIDGE (CC 388A)'),
	(381, 8, 20, 16, NULL, '2019-10-01', 'FEEDMIL', 'PERMANENT MARKER-BLUE'),
	(382, 8, 21, 1, NULL, '2019-10-01', 'FEEDMIL', 'PERMANENT MARKER-BLACK'),
	(383, 8, 22, 1, NULL, '2019-10-01', 'FEEDMIL', 'PERMANENT MARKER-RED'),
	(384, 8, 20, 8, NULL, '2019-12-01', 'FEEDMIL', 'PERMANENT MARKER-BLUE'),
	(385, 8, 21, 1, NULL, '2019-12-01', 'FEEDMIL', 'PERMANENT MARKER-BLACK'),
	(386, 8, 22, 5, NULL, '2019-12-01', 'FEEDMIL', 'PERMANENT MARKER-RED'),
	(387, 8, 28, 2, NULL, '2019-12-01', 'FEEDMIL', 'WHITEBOARD MARKER-RED'),
	(391, 9, 52, 1, NULL, '2019-01-01', 'INVENTORY', 'EXERCISE BOOK 116PAGES'),
	(392, 9, 128, 2, NULL, '2019-05-01', 'INVENTORY', 'EXERCISE BOOK 80PAGES'),
	(393, 9, 129, 1, NULL, '2019-06-01', 'INVENTORY', 'EXERCISE BOOK 120PAGES'),
	(394, 9, 44, 1, NULL, '2019-11-01', 'INVENTORY', 'AMANO CE-315250 TWO COLOUR'),
	(395, 10, 52, 7, NULL, '2019-01-01', 'FARM', 'EXERCISE BOOK 116PAGES'),
	(396, 10, 20, 5, NULL, '2019-01-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(397, 10, 21, 7, NULL, '2019-01-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(398, 10, 22, 3, NULL, '2019-01-01', 'FARM', 'PERMANENT MARKER-RED'),
	(399, 10, 26, 1, NULL, '2019-01-01', 'FARM', 'WHITEBOARD MARKER-BLUE'),
	(400, 10, 27, 3, NULL, '2019-01-01', 'FARM', 'WHITEBOARD MARKER-BLACK'),
	(401, 10, 28, 3, NULL, '2019-01-01', 'FARM', 'WHITEBOARD MARKER-RED'),
	(402, 10, 32, 1, NULL, '2019-01-01', 'FARM', 'STAMPAD-BLUE'),
	(403, 10, 41, 2, NULL, '2019-01-01', 'FARM', 'HP OFFICEJET 901 BLACK'),
	(404, 10, 70, 1, NULL, '2019-01-01', 'FARM', 'HP LASERJET 125A (CB543A) MAGENTA'),
	(410, 10, 128, 3, NULL, '2019-04-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(411, 10, 129, 8, NULL, '2019-04-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(412, 10, 20, 5, NULL, '2019-04-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(413, 10, 21, 7, NULL, '2019-04-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(414, 10, 22, 3, NULL, '2019-04-01', 'FARM', 'PERMANENT MARKER-RED'),
	(415, 10, 29, 1, NULL, '2019-04-01', 'FARM', 'STAMPAD INK-BLUE'),
	(416, 10, 32, 1, NULL, '2019-04-01', 'FARM', 'STAMPAD-BLUE'),
	(417, 10, 3, 3, NULL, '2019-05-01', 'FARM', 'L-FOLDER COLOURFUL'),
	(418, 10, 128, 5, NULL, '2019-05-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(419, 10, 21, 1, NULL, '2019-05-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(420, 10, 29, 1, NULL, '2019-05-01', 'FARM', 'STAMPAD INK-BLUE'),
	(424, 10, 1, 1, NULL, '2019-06-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(425, 10, 2, 10, NULL, '2019-06-01', 'FARM', 'U-FOLDER A4 TRANSPARENTS'),
	(426, 10, 128, 3, NULL, '2019-06-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(427, 10, 16, 12, NULL, '2019-06-01', 'FARM', 'DOUBLE CLIP-25MM'),
	(428, 10, 20, 12, NULL, '2019-06-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(429, 10, 21, 12, NULL, '2019-06-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(430, 10, 132, 1, NULL, '2019-06-01', 'FARM', 'HP LASERJET 125A BLACK'),
	(431, 10, 133, 1, NULL, '2019-06-01', 'FARM', 'HP LASERJET 125A MAGENTA'),
	(432, 10, 134, 1, NULL, '2019-06-01', 'FARM', 'HP LASERJET 125A CYAN'),
	(433, 10, 41, 2, NULL, '2019-06-01', 'FARM', 'HP OFFICEJET 901 BLACK'),
	(439, 10, 2, 20, NULL, '2019-07-01', 'FARM', 'U-FOLDER A4 TRANSPARENTS'),
	(440, 10, 3, 5, NULL, '2019-07-01', 'FARM', 'L-FOLDER COLOURFUL'),
	(441, 10, 128, 2, NULL, '2019-07-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(442, 10, 7, 1, NULL, '2019-07-01', 'FARM', 'ENVELOPE A4'),
	(443, 10, 18, 1, NULL, '2019-07-01', 'FARM', 'DOUBLE CLIP-41MM'),
	(444, 10, 21, 1, NULL, '2019-07-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(446, 10, 2, 2, NULL, '2019-08-01', 'FARM', 'U-FOLDER A4 TRANSPARENTS'),
	(447, 10, 128, 1, NULL, '2019-08-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(448, 10, 20, 6, NULL, '2019-08-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(449, 10, 26, 1, NULL, '2019-08-01', 'FARM', 'WHITEBOARD MARKER-BLUE'),
	(450, 10, 27, 1, NULL, '2019-08-01', 'FARM', 'WHITEBOARD MARKER-BLACK'),
	(451, 10, 28, 1, NULL, '2019-08-01', 'FARM', 'WHITEBOARD MARKER-RED'),
	(452, 10, 29, 2, NULL, '2019-08-01', 'FARM', 'STAMPAD INK-BLUE'),
	(453, 10, 1, 1, NULL, '2019-09-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(454, 10, 129, 3, NULL, '2019-09-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(455, 10, 130, 5, NULL, '2019-09-01', 'FARM', 'COLOURFUL PAPER-BLUE'),
	(456, 10, 18, 1, NULL, '2019-09-01', 'FARM', 'DOUBLE CLIP-41MM'),
	(460, 10, 1, 10, NULL, '2019-10-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(461, 10, 2, 6, NULL, '2019-10-01', 'FARM', 'U-FOLDER A4 TRANSPARENTS'),
	(462, 10, 3, 7, NULL, '2019-10-01', 'FARM', 'L-FOLDER COLOURFUL'),
	(463, 10, 128, 6, NULL, '2019-10-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(464, 10, 129, 6, NULL, '2019-10-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(465, 10, 4, 6, NULL, '2019-10-01', 'FARM', 'ENVELOPE BROWN-HALF'),
	(466, 10, 5, 6, NULL, '2019-10-01', 'FARM', 'ENVELOPE WHITE-WINDOW'),
	(467, 10, 7, 6, NULL, '2019-10-01', 'FARM', 'ENVELOPE A4'),
	(468, 10, 9, 1, NULL, '2019-10-01', 'FARM', 'INDEX DIVIDER-NUMBER'),
	(469, 10, 15, 5, NULL, '2019-10-01', 'FARM', 'DOUBLE CLIP-19MM'),
	(470, 10, 21, 2, NULL, '2019-10-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(475, 10, 2, 10, NULL, '2019-11-01', 'FARM', 'U-FOLDER A4 TRANSPARENTS'),
	(476, 10, 19, 1, NULL, '2019-11-01', 'FARM', 'DOUBLE CLIP-51MM'),
	(477, 10, 20, 1, NULL, '2019-11-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(478, 10, 22, 1, NULL, '2019-11-01', 'FARM', 'PERMANENT MARKER-RED'),
	(479, 10, 26, 1, NULL, '2019-11-01', 'FARM', 'WHITEBOARD MARKER-BLUE'),
	(480, 10, 28, 1, NULL, '2019-11-01', 'FARM', 'WHITEBOARD MARKER-RED'),
	(482, 10, 1, 20, NULL, '2019-12-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(483, 10, 129, 1, NULL, '2019-12-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(484, 10, 14, 1, NULL, '2019-12-01', 'FARM', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(485, 10, 21, 12, NULL, '2019-12-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(486, 10, 28, 5, NULL, '2019-12-01', 'FARM', 'WHITEBOARD MARKER-RED'),
	(489, 10, 1, 1, NULL, '2019-01-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(490, 10, 11, 13, NULL, '2019-01-01', 'FARM', 'COLOURFUL PAPER-PINK'),
	(491, 10, 20, 16, NULL, '2019-01-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(492, 10, 21, 11, NULL, '2019-01-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(493, 10, 22, 8, NULL, '2019-01-01', 'FARM', 'PERMANENT MARKER-RED'),
	(494, 10, 27, 3, NULL, '2019-01-01', 'FARM', 'WHITEBOARD MARKER-BLACK'),
	(495, 10, 44, 1, NULL, '2019-01-01', 'FARM', 'AMANO CE-315250 TWO COLOUR'),
	(496, 10, 1, 1, NULL, '2019-02-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(497, 10, 3, 5, NULL, '2019-02-01', 'FARM', 'L-FOLDER COLOURFUL'),
	(498, 10, 52, 7, NULL, '2019-02-01', 'FARM', 'EXERCISE BOOK 116PAGES'),
	(499, 10, 17, 1, NULL, '2019-02-01', 'FARM', 'DOUBLE CLIP-32MM'),
	(500, 10, 20, 14, NULL, '2019-02-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(501, 10, 21, 4, NULL, '2019-02-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(502, 10, 22, 6, NULL, '2019-02-01', 'FARM', 'PERMANENT MARKER-RED'),
	(503, 10, 26, 1, NULL, '2019-02-01', 'FARM', 'WHITEBOARD MARKER-BLUE'),
	(511, 10, 52, 1, NULL, '2019-03-01', 'FARM', 'EXERCISE BOOK 116PAGES'),
	(512, 10, 11, 12, NULL, '2019-03-01', 'FARM', 'COLOURFUL PAPER-PINK'),
	(513, 10, 17, 1, NULL, '2019-03-01', 'FARM', 'DOUBLE CLIP-32MM'),
	(514, 10, 20, 1, NULL, '2019-03-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(515, 10, 21, 4, NULL, '2019-03-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(518, 10, 1, 3, NULL, '2019-04-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(519, 10, 7, 1, NULL, '2019-04-01', 'FARM', 'ENVELOPE A4'),
	(520, 10, 10, 20, NULL, '2019-04-01', 'FARM', 'COLOURFUL PAPER-GREEN'),
	(521, 10, 26, 1, NULL, '2019-04-01', 'FARM', 'WHITEBOARD MARKER-BLUE'),
	(522, 10, 27, 1, NULL, '2019-04-01', 'FARM', 'WHITEBOARD MARKER-BLACK'),
	(523, 10, 28, 1, NULL, '2019-04-01', 'FARM', 'WHITEBOARD MARKER-RED'),
	(525, 10, 1, 1, NULL, '2019-05-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(526, 10, 128, 1, NULL, '2019-05-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(527, 10, 129, 10, NULL, '2019-05-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(528, 10, 19, 12, NULL, '2019-05-01', 'FARM', 'DOUBLE CLIP-51MM'),
	(529, 10, 21, 9, NULL, '2019-05-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(530, 10, 22, 4, NULL, '2019-05-01', 'FARM', 'PERMANENT MARKER-RED'),
	(531, 10, 44, 1, NULL, '2019-05-01', 'FARM', 'AMANO CE-315250 TWO COLOUR'),
	(532, 10, 1, 1, NULL, '2019-06-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(533, 10, 128, 1, NULL, '2019-06-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(534, 10, 129, 2, NULL, '2019-06-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(535, 10, 11, 60, NULL, '2019-06-01', 'FARM', 'COLOURFUL PAPER-PINK'),
	(536, 10, 17, 1, NULL, '2019-06-01', 'FARM', 'DOUBLE CLIP-32MM'),
	(537, 10, 20, 4, NULL, '2019-06-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(538, 10, 21, 6, NULL, '2019-06-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(539, 10, 22, 5, NULL, '2019-06-01', 'FARM', 'PERMANENT MARKER-RED'),
	(540, 10, 23, 3, NULL, '2019-06-01', 'FARM', 'MULTIPURPOSE MARKER-BLUE'),
	(547, 10, 3, 6, NULL, '2019-07-01', 'FARM', 'L-FOLDER COLOURFUL'),
	(548, 10, 129, 4, NULL, '2019-07-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(549, 10, 13, 1, NULL, '2019-07-01', 'FARM', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(550, 10, 20, 6, NULL, '2019-07-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(551, 10, 21, 6, NULL, '2019-07-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(552, 10, 22, 4, NULL, '2019-07-01', 'FARM', 'PERMANENT MARKER-RED'),
	(554, 10, 3, 5, NULL, '2019-08-01', 'FARM', 'L-FOLDER COLOURFUL'),
	(555, 10, 128, 3, NULL, '2019-08-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(556, 10, 129, 1, NULL, '2019-08-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(557, 10, 20, 5, NULL, '2019-08-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(558, 10, 21, 4, NULL, '2019-08-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(559, 10, 22, 4, NULL, '2019-08-01', 'FARM', 'PERMANENT MARKER-RED'),
	(560, 10, 44, 1, NULL, '2019-08-01', 'FARM', 'AMANO CE-315250 TWO COLOUR'),
	(561, 10, 1, 10, NULL, '2019-09-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(562, 10, 128, 2, NULL, '2019-09-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(563, 10, 129, 4, NULL, '2019-09-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(564, 10, 7, 1, NULL, '2019-09-01', 'FARM', 'ENVELOPE A4'),
	(565, 10, 17, 1, NULL, '2019-09-01', 'FARM', 'DOUBLE CLIP-32MM'),
	(566, 10, 20, 6, NULL, '2019-09-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(567, 10, 21, 9, NULL, '2019-09-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(568, 10, 22, 5, NULL, '2019-09-01', 'FARM', 'PERMANENT MARKER-RED'),
	(576, 10, 2, 2, NULL, '2019-10-01', 'FARM', 'U-FOLDER A4 TRANSPARENTS'),
	(577, 10, 128, 2, NULL, '2019-10-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(578, 10, 129, 3, NULL, '2019-10-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(579, 10, 20, 11, NULL, '2019-10-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(580, 10, 21, 6, NULL, '2019-10-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(581, 10, 22, 5, NULL, '2019-10-01', 'FARM', 'PERMANENT MARKER-RED'),
	(582, 10, 35, 1, NULL, '2019-10-01', 'FARM', 'PAPER PUNCH'),
	(583, 10, 135, 1, NULL, '2019-10-01', 'FARM', 'HP LASERJET 53 BLACK'),
	(591, 10, 1, 2, NULL, '2019-11-01', 'FARM', 'L-FOLDER A4 TRANSPARENTS'),
	(592, 10, 2, 3, NULL, '2019-11-01', 'FARM', 'U-FOLDER A4 TRANSPARENTS'),
	(593, 10, 128, 1, NULL, '2019-11-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(594, 10, 129, 6, NULL, '2019-11-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(595, 10, 7, 2, NULL, '2019-11-01', 'FARM', 'ENVELOPE A4'),
	(596, 10, 20, 10, NULL, '2019-11-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(597, 10, 21, 4, NULL, '2019-11-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(598, 10, 22, 4, NULL, '2019-11-01', 'FARM', 'PERMANENT MARKER-RED'),
	(599, 10, 44, 1, NULL, '2019-11-01', 'FARM', 'AMANO CE-315250 TWO COLOUR'),
	(606, 10, 128, 3, NULL, '2019-12-01', 'FARM', 'EXERCISE BOOK 80PAGES'),
	(607, 10, 129, 7, NULL, '2019-12-01', 'FARM', 'EXERCISE BOOK 120PAGES'),
	(608, 10, 6, 1, NULL, '2019-12-01', 'FARM', 'ENVELOPE A3'),
	(609, 10, 7, 3, NULL, '2019-12-01', 'FARM', 'ENVELOPE A4'),
	(610, 10, 20, 10, NULL, '2019-12-01', 'FARM', 'PERMANENT MARKER-BLUE'),
	(611, 10, 21, 9, NULL, '2019-12-01', 'FARM', 'PERMANENT MARKER-BLACK'),
	(612, 10, 22, 7, NULL, '2019-12-01', 'FARM', 'PERMANENT MARKER-RED'),
	(613, 10, 35, 1, NULL, '2019-12-01', 'FARM', 'PAPER PUNCH'),
	(621, 12, 3, 13, NULL, '2019-01-01', 'HR', 'L-FOLDER COLOURFUL'),
	(622, 12, 3, 5, NULL, '2019-02-01', 'HR', 'L-FOLDER COLOURFUL'),
	(623, 12, 12, 20, NULL, '2019-02-01', 'HR', 'WHITE STIKER'),
	(624, 12, 13, 1, NULL, '2019-02-01', 'HR', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(625, 12, 14, 1, NULL, '2019-02-01', 'HR', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(626, 12, 18, 1, NULL, '2019-02-01', 'HR', 'DOUBLE CLIP-41MM'),
	(629, 12, 1, 5, NULL, '2019-03-01', 'HR', 'L-FOLDER A4 TRANSPARENTS'),
	(630, 12, 3, 6, NULL, '2019-03-01', 'HR', 'L-FOLDER COLOURFUL'),
	(632, 12, 128, 1, NULL, '2019-05-01', 'HR', 'EXERCISE BOOK 80PAGES'),
	(633, 12, 7, 3, NULL, '2019-05-01', 'HR', 'ENVELOPE A4'),
	(635, 12, 13, 1, NULL, '2019-06-01', 'HR', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(636, 12, 1, 5, NULL, '2019-07-01', 'HR', 'L-FOLDER A4 TRANSPARENTS'),
	(637, 12, 7, 3, NULL, '2019-07-01', 'HR', 'ENVELOPE A4'),
	(638, 12, 16, 2, NULL, '2019-07-01', 'HR', 'DOUBLE CLIP-25MM'),
	(639, 12, 17, 2, NULL, '2019-07-01', 'HR', 'DOUBLE CLIP-32MM'),
	(643, 12, 2, 5, NULL, '2019-08-01', 'HR', 'U-FOLDER A4 TRANSPARENTS'),
	(644, 12, 1, 11, NULL, '2019-09-01', 'HR', 'L-FOLDER A4 TRANSPARENTS'),
	(645, 12, 7, 8, NULL, '2019-09-01', 'HR', 'ENVELOPE A4'),
	(646, 12, 13, 4, NULL, '2019-09-01', 'HR', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(647, 12, 14, 3, NULL, '2019-09-01', 'HR', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(648, 12, 15, 2, NULL, '2019-09-01', 'HR', 'DOUBLE CLIP-19MM'),
	(649, 12, 16, 2, NULL, '2019-09-01', 'HR', 'DOUBLE CLIP-25MM'),
	(650, 12, 17, 2, NULL, '2019-09-01', 'HR', 'DOUBLE CLIP-32MM'),
	(651, 12, 18, 7, NULL, '2019-12-01', 'HR', 'DOUBLE CLIP-41MM'),
	(652, 13, 1, 1, NULL, '2019-01-01', 'MARKETING', 'L-FOLDER A4 TRANSPARENTS'),
	(653, 13, 2, 2, NULL, '2019-01-01', 'MARKETING', 'U-FOLDER A4 TRANSPARENTS'),
	(654, 13, 52, 1, NULL, '2019-01-01', 'MARKETING', 'EXERCISE BOOK 116PAGES'),
	(655, 13, 20, 1, NULL, '2019-01-01', 'MARKETING', 'PERMANENT MARKER-BLUE'),
	(656, 13, 46, 1, NULL, '2019-01-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015586/S015336'),
	(659, 13, 2, 2, NULL, '2019-02-01', 'MARKETING', 'U-FOLDER A4 TRANSPARENTS'),
	(660, 13, 3, 2, NULL, '2019-02-01', 'MARKETING', 'L-FOLDER COLOURFUL'),
	(661, 13, 7, 3, NULL, '2019-02-01', 'MARKETING', 'ENVELOPE A4'),
	(662, 13, 14, 1, NULL, '2019-02-01', 'MARKETING', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(663, 13, 15, 1, NULL, '2019-02-01', 'MARKETING', 'DOUBLE CLIP-19MM'),
	(664, 13, 18, 1, NULL, '2019-02-01', 'MARKETING', 'DOUBLE CLIP-41MM'),
	(665, 13, 19, 3, NULL, '2019-02-01', 'MARKETING', 'DOUBLE CLIP-51MM'),
	(666, 13, 21, 1, NULL, '2019-02-01', 'MARKETING', 'PERMANENT MARKER-BLACK'),
	(667, 13, 22, 1, NULL, '2019-02-01', 'MARKETING', 'PERMANENT MARKER-RED'),
	(674, 13, 3, 1, NULL, '2019-03-01', 'MARKETING', 'L-FOLDER COLOURFUL'),
	(675, 13, 7, 1, NULL, '2019-03-01', 'MARKETING', 'ENVELOPE A4'),
	(676, 13, 37, 1, NULL, '2019-03-01', 'MARKETING', 'HP LASERJET 126A (CE312A) YELLOW'),
	(677, 13, 38, 1, NULL, '2019-03-01', 'MARKETING', 'HP LASERJET 126A (CE311A) CYAN'),
	(678, 13, 39, 1, NULL, '2019-03-01', 'MARKETING', 'HP LASERJET 126A (CE313A) MAGENTA'),
	(679, 13, 50, 3, NULL, '2019-03-01', 'MARKETING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(681, 13, 7, 1, NULL, '2019-04-01', 'MARKETING', 'ENVELOPE A4'),
	(682, 13, 33, 1, NULL, '2019-04-01', 'MARKETING', 'STAMPAD-BLACK'),
	(683, 13, 46, 4, NULL, '2019-04-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015586/S015336'),
	(684, 13, 47, 2, NULL, '2019-04-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(688, 13, 1, 2, NULL, '2019-05-01', 'MARKETING', 'L-FOLDER A4 TRANSPARENTS'),
	(689, 13, 129, 1, NULL, '2019-05-01', 'MARKETING', 'EXERCISE BOOK 120PAGES'),
	(690, 13, 7, 2, NULL, '2019-05-01', 'MARKETING', 'ENVELOPE A4'),
	(691, 13, 26, 1, NULL, '2019-05-01', 'MARKETING', 'WHITEBOARD MARKER-BLUE'),
	(692, 13, 27, 1, NULL, '2019-05-01', 'MARKETING', 'WHITEBOARD MARKER-BLACK'),
	(693, 13, 47, 2, NULL, '2019-05-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(695, 13, 3, 4, NULL, '2019-06-01', 'MARKETING', 'L-FOLDER COLOURFUL'),
	(696, 13, 7, 7, NULL, '2019-06-01', 'MARKETING', 'ENVELOPE A4'),
	(697, 13, 46, 2, NULL, '2019-06-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015586/S015336'),
	(698, 13, 1, 7, NULL, '2019-07-01', 'MARKETING', 'L-FOLDER A4 TRANSPARENTS'),
	(699, 13, 3, 5, NULL, '2019-07-01', 'MARKETING', 'L-FOLDER COLOURFUL'),
	(700, 13, 7, 1, NULL, '2019-07-01', 'MARKETING', 'ENVELOPE A4'),
	(701, 13, 21, 1, NULL, '2019-07-01', 'MARKETING', 'PERMANENT MARKER-BLACK'),
	(702, 13, 43, 3, NULL, '2019-07-01', 'MARKETING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(703, 13, 47, 1, NULL, '2019-07-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(705, 13, 1, 5, NULL, '2019-08-01', 'MARKETING', 'L-FOLDER A4 TRANSPARENTS'),
	(706, 13, 7, 1, NULL, '2019-08-01', 'MARKETING', 'ENVELOPE A4'),
	(707, 13, 20, 2, NULL, '2019-08-01', 'MARKETING', 'PERMANENT MARKER-BLUE'),
	(708, 13, 21, 4, NULL, '2019-08-01', 'MARKETING', 'PERMANENT MARKER-BLACK'),
	(709, 13, 43, 2, NULL, '2019-08-01', 'MARKETING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(712, 13, 1, 2, NULL, '2019-09-01', 'MARKETING', 'L-FOLDER A4 TRANSPARENTS'),
	(713, 13, 4, 1, NULL, '2019-09-01', 'MARKETING', 'ENVELOPE BROWN-HALF'),
	(714, 13, 7, 5, NULL, '2019-09-01', 'MARKETING', 'ENVELOPE A4'),
	(715, 13, 36, 1, NULL, '2019-09-01', 'MARKETING', 'HP LASERJET 126A (CE310A) BLACK'),
	(716, 13, 37, 1, NULL, '2019-09-01', 'MARKETING', 'HP LASERJET 126A (CE312A) YELLOW'),
	(717, 13, 38, 1, NULL, '2019-09-01', 'MARKETING', 'HP LASERJET 126A (CE311A) CYAN'),
	(718, 13, 39, 1, NULL, '2019-09-01', 'MARKETING', 'HP LASERJET 126A (CE313A) MAGENTA'),
	(719, 13, 47, 1, NULL, '2019-09-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(720, 13, 50, 2, NULL, '2019-09-01', 'MARKETING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(721, 13, 136, 2, NULL, '2019-09-01', 'MARKETING', 'SEIKO PRECISION (FB60051)'),
	(727, 13, 1, 11, NULL, '2019-10-01', 'MARKETING', 'L-FOLDER A4 TRANSPARENTS'),
	(728, 13, 2, 1, NULL, '2019-10-01', 'MARKETING', 'U-FOLDER A4 TRANSPARENTS'),
	(729, 13, 7, 5, NULL, '2019-10-01', 'MARKETING', 'ENVELOPE A4'),
	(730, 13, 21, 1, NULL, '2019-10-01', 'MARKETING', 'PERMANENT MARKER-BLACK'),
	(731, 13, 43, 3, NULL, '2019-10-01', 'MARKETING', 'PRINTONIX P7000 ULTRA CAPACITY PRINTER RIBBON'),
	(732, 13, 136, 1, NULL, '2019-10-01', 'MARKETING', 'SEIKO PRECISION (FB60051)'),
	(734, 13, 1, 2, NULL, '2019-11-01', 'MARKETING', 'L-FOLDER A4 TRANSPARENTS'),
	(735, 13, 3, 2, NULL, '2019-11-01', 'MARKETING', 'L-FOLDER COLOURFUL'),
	(736, 13, 128, 1, NULL, '2019-11-01', 'MARKETING', 'EXERCISE BOOK 80PAGES'),
	(737, 13, 129, 2, NULL, '2019-11-01', 'MARKETING', 'EXERCISE BOOK 120PAGES'),
	(738, 13, 4, 2, NULL, '2019-11-01', 'MARKETING', 'ENVELOPE BROWN-HALF'),
	(739, 13, 7, 6, NULL, '2019-11-01', 'MARKETING', 'ENVELOPE A4'),
	(740, 13, 10, 4, NULL, '2019-11-01', 'MARKETING', 'COLOURFUL PAPER-GREEN'),
	(741, 13, 130, 4, NULL, '2019-11-01', 'MARKETING', 'COLOURFUL PAPER-BLUE'),
	(742, 13, 14, 1, NULL, '2019-11-01', 'MARKETING', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(743, 13, 16, 1, NULL, '2019-11-01', 'MARKETING', 'DOUBLE CLIP-25MM'),
	(744, 13, 35, 1, NULL, '2019-11-01', 'MARKETING', 'PAPER PUNCH'),
	(745, 13, 46, 2, NULL, '2019-11-01', 'MARKETING', 'EPSON RIBBON CARTRIDGE-S015586/S015336'),
	(749, 13, 129, 2, NULL, '2019-12-01', 'MARKETING', 'EXERCISE BOOK 120PAGES'),
	(750, 13, 7, 6, NULL, '2019-12-01', 'MARKETING', 'ENVELOPE A4'),
	(751, 13, 15, 1, NULL, '2019-12-01', 'MARKETING', 'DOUBLE CLIP-19MM'),
	(752, 13, 50, 2, NULL, '2019-12-01', 'MARKETING', 'PRINTONIX P8000/P7000 CARTRIDGE RIBBON'),
	(756, 14, 3, 6, NULL, '2019-01-01', 'BROILER', 'L-FOLDER COLOURFUL'),
	(757, 14, 13, 1, NULL, '2019-01-01', 'BROILER', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(758, 14, 15, 1, NULL, '2019-01-01', 'BROILER', 'DOUBLE CLIP-19MM'),
	(759, 14, 16, 7, NULL, '2019-01-01', 'BROILER', 'DOUBLE CLIP-25MM'),
	(760, 14, 17, 1, NULL, '2019-01-01', 'BROILER', 'DOUBLE CLIP-32MM'),
	(761, 14, 18, 10, NULL, '2019-01-01', 'BROILER', 'DOUBLE CLIP-41MM'),
	(762, 14, 47, 3, NULL, '2019-01-01', 'BROILER', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(763, 14, 14, 1, NULL, '2019-04-01', 'BROILER', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(764, 14, 16, 12, NULL, '2019-04-01', 'BROILER', 'DOUBLE CLIP-25MM'),
	(766, 14, 130, 40, NULL, '2019-05-01', 'BROILER', 'COLOURFUL PAPER-BLUE'),
	(767, 14, 11, 20, NULL, '2019-05-01', 'BROILER', 'COLOURFUL PAPER-PINK'),
	(768, 14, 15, 1, NULL, '2019-05-01', 'BROILER', 'DOUBLE CLIP-19MM'),
	(769, 14, 16, 1, NULL, '2019-05-01', 'BROILER', 'DOUBLE CLIP-25MM'),
	(770, 14, 17, 1, NULL, '2019-05-01', 'BROILER', 'DOUBLE CLIP-32MM'),
	(771, 14, 18, 1, NULL, '2019-05-01', 'BROILER', 'DOUBLE CLIP-41MM'),
	(772, 14, 19, 3, NULL, '2019-05-01', 'BROILER', 'DOUBLE CLIP-51MM'),
	(773, 14, 1, 1, NULL, '2019-06-01', 'BROILER', 'L-FOLDER A4 TRANSPARENTS'),
	(774, 14, 3, 1, NULL, '2019-06-01', 'BROILER', 'L-FOLDER COLOURFUL'),
	(776, 14, 48, 1, NULL, '2019-07-01', 'BROILER', 'DELL 113X'),
	(777, 14, 1, 1, NULL, '2019-09-01', 'BROILER', 'L-FOLDER A4 TRANSPARENTS'),
	(778, 14, 1, 1, NULL, '2019-10-01', 'BROILER', 'L-FOLDER A4 TRANSPARENTS'),
	(779, 15, 52, 1, NULL, '2019-01-01', 'COLLECTIONS', 'EXERCISE BOOK 116PAGES'),
	(780, 15, 5, 21, NULL, '2019-01-01', 'COLLECTIONS', 'ENVELOPE WHITE-WINDOW'),
	(781, 15, 14, 1, NULL, '2019-01-01', 'COLLECTIONS', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(782, 15, 45, 2, NULL, '2019-01-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015506/#7753'),
	(783, 15, 47, 2, NULL, '2019-01-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(786, 15, 45, 2, NULL, '2019-02-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015506/#7753'),
	(787, 15, 47, 2, NULL, '2019-02-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(789, 15, 45, 3, NULL, '2019-04-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015506/#7753'),
	(790, 15, 5, 40, NULL, '2019-05-01', 'COLLECTIONS', 'ENVELOPE WHITE-WINDOW'),
	(791, 15, 47, 3, NULL, '2019-05-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(793, 15, 5, 30, NULL, '2019-06-01', 'COLLECTIONS', 'ENVELOPE WHITE-WINDOW'),
	(794, 15, 4, 4, NULL, '2019-07-01', 'COLLECTIONS', 'ENVELOPE BROWN-HALF'),
	(795, 15, 5, 20, NULL, '2019-07-01', 'COLLECTIONS', 'ENVELOPE WHITE-WINDOW'),
	(796, 15, 47, 3, NULL, '2019-07-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(797, 15, 5, 40, NULL, '2019-08-01', 'COLLECTIONS', 'ENVELOPE WHITE-WINDOW'),
	(798, 15, 7, 20, NULL, '2019-09-01', 'COLLECTIONS', 'ENVELOPE A4'),
	(799, 15, 26, 1, NULL, '2019-09-01', 'COLLECTIONS', 'WHITEBOARD MARKER-BLUE'),
	(800, 15, 29, 1, NULL, '2019-09-01', 'COLLECTIONS', 'STAMPAD INK-BLUE'),
	(801, 15, 30, 1, NULL, '2019-09-01', 'COLLECTIONS', 'STAMPAD INK-BLACK'),
	(802, 15, 45, 4, NULL, '2019-09-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015506/#7753'),
	(805, 15, 1, 5, NULL, '2019-10-01', 'COLLECTIONS', 'L-FOLDER A4 TRANSPARENTS'),
	(806, 15, 5, 30, NULL, '2019-10-01', 'COLLECTIONS', 'ENVELOPE WHITE-WINDOW'),
	(807, 15, 13, 3, NULL, '2019-10-01', 'COLLECTIONS', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(808, 15, 22, 2, NULL, '2019-10-01', 'COLLECTIONS', 'PERMANENT MARKER-RED'),
	(812, 15, 1, 3, NULL, '2019-11-01', 'COLLECTIONS', 'L-FOLDER A4 TRANSPARENTS'),
	(813, 15, 128, 1, NULL, '2019-11-01', 'COLLECTIONS', 'EXERCISE BOOK 80PAGES'),
	(814, 15, 28, 1, NULL, '2019-11-01', 'COLLECTIONS', 'WHITEBOARD MARKER-RED'),
	(815, 15, 47, 1, NULL, '2019-11-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(819, 15, 28, 1, NULL, '2019-12-01', 'COLLECTIONS', 'WHITEBOARD MARKER-RED'),
	(820, 15, 47, 1, NULL, '2019-12-01', 'COLLECTIONS', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(822, 7, 52, 2, NULL, '2019-01-01', 'LOGISTIC', 'EXERCISE BOOK 116PAGES'),
	(823, 7, 2, 1, NULL, '2019-02-01', 'LOGISTIC', 'U-FOLDER A4 TRANSPARENTS'),
	(824, 7, 52, 2, NULL, '2019-02-01', 'LOGISTIC', 'EXERCISE BOOK 116PAGES'),
	(826, 7, 3, 6, NULL, '2019-03-01', 'LOGISTIC', 'L-FOLDER COLOURFUL'),
	(827, 7, 52, 1, NULL, '2019-03-01', 'LOGISTIC', 'EXERCISE BOOK 116PAGES'),
	(828, 7, 13, 2, NULL, '2019-03-01', 'LOGISTIC', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(829, 7, 1, 5, NULL, '2019-04-01', 'LOGISTIC', 'L-FOLDER A4 TRANSPARENTS'),
	(830, 7, 128, 1, NULL, '2019-04-01', 'LOGISTIC', 'EXERCISE BOOK 80PAGES'),
	(831, 7, 129, 1, NULL, '2019-04-01', 'LOGISTIC', 'EXERCISE BOOK 120PAGES'),
	(832, 7, 1, 1, NULL, '2019-05-01', 'LOGISTIC', 'L-FOLDER A4 TRANSPARENTS'),
	(833, 7, 3, 3, NULL, '2019-05-01', 'LOGISTIC', 'L-FOLDER COLOURFUL'),
	(834, 7, 128, 1, NULL, '2019-05-01', 'LOGISTIC', 'EXERCISE BOOK 80PAGES'),
	(835, 7, 20, 1, NULL, '2019-05-01', 'LOGISTIC', 'PERMANENT MARKER-BLUE'),
	(836, 7, 21, 4, NULL, '2019-05-01', 'LOGISTIC', 'PERMANENT MARKER-BLACK'),
	(837, 7, 47, 4, NULL, '2019-05-01', 'LOGISTIC', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(839, 7, 129, 2, NULL, '2019-06-01', 'LOGISTIC', 'EXERCISE BOOK 120PAGES'),
	(840, 7, 48, 1, NULL, '2019-06-01', 'LOGISTIC', 'DELL 113X'),
	(842, 7, 3, 6, NULL, '2019-07-01', 'LOGISTIC', 'L-FOLDER COLOURFUL'),
	(843, 7, 7, 2, NULL, '2019-07-01', 'LOGISTIC', 'ENVELOPE A4'),
	(845, 7, 129, 1, NULL, '2019-08-01', 'LOGISTIC', 'EXERCISE BOOK 120PAGES'),
	(846, 7, 47, 2, NULL, '2019-08-01', 'LOGISTIC', 'EPSON RIBBON CARTRIDGE-S015531/S015086'),
	(848, 7, 1, 6, NULL, '2019-10-01', 'LOGISTIC', 'L-FOLDER A4 TRANSPARENTS'),
	(849, 7, 2, 2, NULL, '2019-10-01', 'LOGISTIC', 'U-FOLDER A4 TRANSPARENTS'),
	(850, 7, 129, 1, NULL, '2019-10-01', 'LOGISTIC', 'EXERCISE BOOK 120PAGES'),
	(851, 7, 20, 1, NULL, '2019-10-01', 'LOGISTIC', 'PERMANENT MARKER-BLUE'),
	(852, 7, 21, 2, NULL, '2019-10-01', 'LOGISTIC', 'PERMANENT MARKER-BLACK'),
	(853, 7, 42, 2, NULL, '2019-10-01', 'LOGISTIC', 'EPSON ERC-38B'),
	(855, 7, 129, 1, NULL, '2019-11-01', 'LOGISTIC', 'EXERCISE BOOK 120PAGES'),
	(856, 7, 6, 2, NULL, '2019-11-01', 'LOGISTIC', 'ENVELOPE A3'),
	(858, 7, 129, 2, NULL, '2019-12-01', 'LOGISTIC', 'EXERCISE BOOK 120PAGES'),
	(859, 7, 32, 1, NULL, '2019-12-01', 'LOGISTIC', 'STAMPAD-BLUE'),
	(861, 17, 20, 4, NULL, '2019-01-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(862, 17, 26, 1, NULL, '2019-01-01', 'LOADING', 'WHITEBOARD MARKER-BLUE'),
	(864, 17, 1, 21, NULL, '2019-02-01', 'LOADING', 'L-FOLDER A4 TRANSPARENTS'),
	(865, 17, 3, 10, NULL, '2019-02-01', 'LOADING', 'L-FOLDER COLOURFUL'),
	(866, 17, 20, 3, NULL, '2019-02-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(867, 17, 17, 2, NULL, '2019-03-01', 'LOADING', 'DOUBLE CLIP-32MM'),
	(868, 17, 20, 2, NULL, '2019-03-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(869, 17, 21, 1, NULL, '2019-03-01', 'LOADING', 'PERMANENT MARKER-BLACK'),
	(870, 17, 22, 1, NULL, '2019-03-01', 'LOADING', 'PERMANENT MARKER-RED'),
	(874, 17, 20, 3, NULL, '2019-04-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(875, 17, 21, 4, NULL, '2019-04-01', 'LOADING', 'PERMANENT MARKER-BLACK'),
	(877, 17, 20, 1, NULL, '2019-05-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(878, 17, 20, 1, NULL, '2019-06-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(879, 17, 21, 2, NULL, '2019-06-01', 'LOADING', 'PERMANENT MARKER-BLACK'),
	(881, 17, 20, 1, NULL, '2019-07-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(882, 17, 130, 40, NULL, '2019-08-01', 'LOADING', 'COLOURFUL PAPER-BLUE'),
	(883, 17, 20, 1, NULL, '2019-08-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(885, 17, 20, 2, NULL, '2019-09-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(886, 17, 21, 2, NULL, '2019-09-01', 'LOADING', 'PERMANENT MARKER-BLACK'),
	(888, 17, 129, 1, NULL, '2019-10-01', 'LOADING', 'EXERCISE BOOK 120PAGES'),
	(889, 17, 20, 2, NULL, '2019-10-01', 'LOADING', 'PERMANENT MARKER-BLUE'),
	(890, 17, 21, 2, NULL, '2019-10-01', 'LOADING', 'PERMANENT MARKER-BLACK'),
	(891, 17, 1, 2, NULL, '2019-11-01', 'LOADING', 'L-FOLDER A4 TRANSPARENTS'),
	(892, 17, 10, 5, NULL, '2019-11-01', 'LOADING', 'COLOURFUL PAPER-GREEN'),
	(893, 17, 130, 5, NULL, '2019-11-01', 'LOADING', 'COLOURFUL PAPER-BLUE'),
	(894, 17, 11, 5, NULL, '2019-11-01', 'LOADING', 'COLOURFUL PAPER-PINK'),
	(898, 17, 1, 5, NULL, '2019-12-01', 'LOADING', 'L-FOLDER A4 TRANSPARENTS'),
	(899, 21, 1, 5, NULL, '2019-02-01', 'PRODUCTION', 'L-FOLDER A4 TRANSPARENTS'),
	(900, 21, 7, 2, NULL, '2019-02-01', 'PRODUCTION', 'ENVELOPE A4'),
	(902, 21, 52, 1, NULL, '2019-03-01', 'PRODUCTION', 'EXERCISE BOOK 116PAGES'),
	(903, 18, 29, 1, NULL, '2019-04-01', 'PURCHASING', 'STAMPAD INK-BLUE'),
	(904, 18, 10, 5, NULL, '2019-05-01', 'PURCHASING', 'COLOURFUL PAPER-GREEN'),
	(905, 18, 13, 1, NULL, '2019-05-01', 'PURCHASING', 'ASTAR PENGUIN PAPER CLIP(SMALL)'),
	(906, 18, 14, 1, NULL, '2019-05-01', 'PURCHASING', 'JUMBO GEM/ASTAR CLIPS(BIG)'),
	(907, 18, 3, 3, NULL, '2019-06-01', 'PURCHASING', 'L-FOLDER COLOURFUL'),
	(908, 18, 20, 7, NULL, '2019-06-01', 'PURCHASING', 'PERMANENT MARKER-BLUE'),
	(910, 18, 21, 1, NULL, '2019-07-01', 'PURCHASING', 'PERMANENT MARKER-BLACK'),
	(911, 18, 21, 1, NULL, '2019-08-01', 'PURCHASING', 'PERMANENT MARKER-BLACK'),
	(912, 18, 7, 1, NULL, '2019-09-01', 'PURCHASING', 'ENVELOPE A4'),
	(913, 18, 1, 1, NULL, '2019-10-01', 'PURCHASING', 'L-FOLDER A4 TRANSPARENTS'),
	(914, 18, 15, 1, NULL, '2019-10-01', 'PURCHASING', 'DOUBLE CLIP-19MM'),
	(915, 18, 17, 1, NULL, '2019-10-01', 'PURCHASING', 'DOUBLE CLIP-32MM'),
	(916, 18, 29, 1, NULL, '2019-10-01', 'PURCHASING', 'STAMPAD INK-BLUE'),
	(920, 18, 1, 3, NULL, '2019-11-01', 'PURCHASING', 'L-FOLDER A4 TRANSPARENTS'),
	(921, 18, 3, 13, NULL, '2019-11-01', 'PURCHASING', 'L-FOLDER COLOURFUL'),
	(922, 18, 22, 1, NULL, '2019-11-01', 'PURCHASING', 'PERMANENT MARKER-RED'),
	(923, 18, 1, 2, NULL, '2019-12-01', 'PURCHASING', 'L-FOLDER A4 TRANSPARENTS'),
	(924, 19, 41, 2, NULL, '2019-04-01', 'HATCHERY', 'HP OFFICEJET 901 BLACK'),
	(925, 19, 129, 1, NULL, '2019-05-01', 'HATCHERY', 'EXERCISE BOOK 120PAGES'),
	(926, 19, 20, 1, NULL, '2019-05-01', 'HATCHERY', 'PERMANENT MARKER-BLUE'),
	(927, 19, 21, 1, NULL, '2019-05-01', 'HATCHERY', 'PERMANENT MARKER-BLACK'),
	(928, 19, 22, 1, NULL, '2019-05-01', 'HATCHERY', 'PERMANENT MARKER-RED'),
	(929, 19, 29, 1, NULL, '2019-05-01', 'HATCHERY', 'STAMPAD INK-BLUE'),
	(932, 19, 20, 3, NULL, '2019-06-01', 'HATCHERY', 'PERMANENT MARKER-BLUE'),
	(933, 19, 21, 1, NULL, '2019-06-01', 'HATCHERY', 'PERMANENT MARKER-BLACK'),
	(935, 19, 23, 2, NULL, '2019-07-01', 'HATCHERY', 'MULTIPURPOSE MARKER-BLUE'),
	(936, 19, 3, 7, NULL, '2019-08-01', 'HATCHERY', 'L-FOLDER COLOURFUL'),
	(937, 19, 20, 5, NULL, '2019-09-01', 'HATCHERY', 'PERMANENT MARKER-BLUE'),
	(938, 19, 21, 5, NULL, '2019-09-01', 'HATCHERY', 'PERMANENT MARKER-BLACK'),
	(940, 19, 132, 1, NULL, '2019-10-01', 'HATCHERY', 'HP LASERJET 125A BLACK'),
	(941, 19, 133, 1, NULL, '2019-10-01', 'HATCHERY', 'HP LASERJET 125A MAGENTA'),
	(942, 19, 134, 1, NULL, '2019-10-01', 'HATCHERY', 'HP LASERJET 125A CYAN'),
	(943, 19, 138, 1, NULL, '2019-10-01', 'HATCHERY', 'LASERJET TONER CATRIDGE (CC388A)');
/*!40000 ALTER TABLE `stationary_stock_take` ENABLE KEYS */;

-- Dumping structure for table admin.stationary_stock_take_ori
CREATE TABLE IF NOT EXISTS `stationary_stock_take_ori` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `date_taken` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.stationary_stock_take_ori: ~8 rows (approximately)
/*!40000 ALTER TABLE `stationary_stock_take_ori` DISABLE KEYS */;
INSERT INTO `stationary_stock_take_ori` (`id`, `department_id`, `item_id`, `quantity`, `date_added`, `date_taken`) VALUES
	(1, 3, 2, 5, '2020-02-27', '2020-02-27'),
	(2, 4, 2, 2, '2020-02-27', '2020-02-27'),
	(3, 2, 14, 1, '2020-01-29', '2020-01-29'),
	(4, 2, 2, 2, '2020-02-29', '2020-02-29'),
	(5, 16, 2, 1, '2020-02-29', '2020-02-29'),
	(6, 4, 4, 1, '2020-02-29', '2020-02-29'),
	(7, 2, 2, 1, '2020-01-29', '2020-01-29'),
	(8, 2, 2, 2, '2020-03-12', '2020-03-12');
/*!40000 ALTER TABLE `stationary_stock_take_ori` ENABLE KEYS */;

-- Dumping structure for table admin.sub_menu
CREATE TABLE IF NOT EXISTS `sub_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL DEFAULT 0 COMMENT 'to identify which submenu belong to a mnu',
  `menu_title` varchar(50) NOT NULL DEFAULT '0',
  `menu_url` varchar(50) NOT NULL DEFAULT '0',
  `system_id` int(11) NOT NULL DEFAULT 0,
  `position` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-active, 0-inactive',
  `menu_icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `system_id` (`system_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.sub_menu: ~43 rows (approximately)
/*!40000 ALTER TABLE `sub_menu` DISABLE KEYS */;
INSERT INTO `sub_menu` (`id`, `mid`, `menu_title`, `menu_url`, `system_id`, `position`, `status`, `menu_icon`) VALUES
	(0, 4, 'Add Location', 'location_add_new.php', 3, 2, 1, 'fas fa-map-marker-alt'),
	(1, 1, 'Add Vehicle', 'vehicle_add_new.php', 1, 1, 1, 'fa fa-id-badge'),
	(2, 1, 'Add New Entry', 'all_add_new.php', 1, 2, 1, 'fas fa-plus-circle'),
	(3, 1, 'Add Summons', 'summon_add_new.php', 1, 3, 1, 'fa fa-exclamation-triangle'),
	(4, 2, 'Vehicle List', 'vehicle.php', 1, 1, 1, 'fa fa-truck'),
	(5, 2, 'Puspakom', 'puspakom.php', 1, 2, 1, 'fa fa-book'),
	(6, 2, 'Roadtax', 'roadtax.php', 1, 3, 1, 'fa fa-road'),
	(7, 2, 'Summons', 'summons.php', 1, 4, 1, 'fa fa-print'),
	(8, 3, 'Vehicle Summons', 'summons_vehicle_report.php', 1, 1, 1, 'fas fa-file-alt'),
	(9, 3, 'Road Tax Summary', 'roadtax_summary_report.php', 1, 2, 1, 'fas fa-book'),
	(10, 3, 'Renewing Schedule', 'renewing_vehicle_schedule_report.php', 1, 3, 1, 'fa fa-list-alt'),
	(11, 3, 'General Table', 'general_table_report.php', 1, 4, 1, 'fa fa-table'),
	(12, 4, 'Add Person Incharge', 'pic_add_new.php', 3, 1, 1, 'fas fa-user-secret'),
	(14, 4, 'Add Fire Extinguisher', 'listing_add_new.php', 3, 3, 1, 'fas fa-plus-circle'),
	(15, 5, 'Master Listing', 'listing.php', 3, 1, 1, 'fas fa-list-ul'),
	(16, 6, 'Department', 'department.php', 2, 1, 1, 'fas fa-user-secret'),
	(17, 6, 'Item', 'item.php', 2, 2, 1, 'fa fa-table'),
	(19, 6, 'Stock', 'stock.php', 2, 3, 1, 'fa fa-list-alt'),
	(20, 6, 'Stock Out', 'stock_out.php', 2, 4, 1, 'fas fa-list-ul'),
	(21, 1, 'Add Company', 'company_add_new.php', 1, 1, 1, 'fa fa-id-badge'),
	(22, 2, 'Company List', 'company.php', 1, 1, 1, 'fas fa-file-alt'),
	(23, 7, 'By Deparment', 'report_department_usage.php', 2, 1, 1, 'fa fa-book'),
	(24, 7, 'Stock Summary', 'report_stock_summary.php', 2, 1, 1, 'fa fa-print'),
	(25, 1, 'Add Vehicle Total Loss', 'vehicle_total_loss_add_new.php', 1, 1, 1, 'fa fa-list-alt'),
	(26, 2, 'Vehicle Total Lost', 'vehicle_total_loss.php', 1, 1, 1, 'fas fa-file-alt'),
	(27, 8, 'Add New Bill', 'add_new_bill.php', 5, 1, 1, 'fas fa-plus-circle'),
	(28, 8, 'Add New Account', 'account_setup.php', 5, 2, 1, 'fa fa-book'),
	(29, 10, 'SESB', 'report_sesb.php', 5, 1, 1, 'fas fa-list-ul'),
	(30, 10, 'Jabatan Air', 'report_jabatan_air.php', 5, 2, 1, 'fas fa-tint'),
	(31, 10, 'Telekom', 'report_telekom.php', 5, 3, 1, 'fas fa-file-alt'),
	(32, 10, 'Celcom Mobile', 'report_celcom.php', 5, 4, 1, 'fa fa-table'),
	(33, 10, 'Photocopy Machine', 'report_photocopy.php', 5, 5, 1, 'fas fa-copy'),
	(34, 10, 'Management Fee', 'report_management_fee.php', 5, 6, 1, 'fas fa-building'),
	(35, 10, 'Housing Water Bill', 'report_water_bill.php', 5, 7, 1, 'fas fa-water'),
	(36, 8, 'Add New Water Bill (Housing)', 'add_new_water_bill.php', 5, 3, 1, 'fas fa-tint'),
	(37, 8, 'Add New Premium Insurance', 'add_premium_insurance.php', 5, 4, 1, 'fas fa-file-invoice-dollar'),
	(38, 8, 'Add New Quit Rent', 'add_quit_rent_billing.php', 5, 5, 1, 'fas fa-file-invoice'),
	(39, 8, 'Add New Late Interest Charges', 'add_late_interest_charge.php', 5, 6, 1, 'fas fa-folder-plus'),
	(40, 11, 'Add User', 'add_new_user.php', 4, 1, 1, 'fas fa-plus-circle'),
	(41, 12, 'User List', 'user_list.php', 4, 2, 1, 'fas fa-list-ul'),
	(42, 13, 'Stock List', 'stock_list.php', 6, 1, 1, 'fa fa-list-alt'),
	(43, 14, 'Request', 'request_list.php', 6, 2, 1, 'fas fa-book'),
	(44, 14, 'Deposit', 'deposit.php', 6, 3, 1, 'fas fa-cart-plus');
/*!40000 ALTER TABLE `sub_menu` ENABLE KEYS */;

-- Dumping structure for table admin.test
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.test: ~0 rows (approximately)
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` (`id`, `name`, `department`, `phone`) VALUES
	(1, 'Jenneffer Jiminit', 'IT(Hardware)', '(503) 016-4897');
/*!40000 ALTER TABLE `test` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_category
CREATE TABLE IF NOT EXISTS `vehicle_category` (
  `vc_id` int(11) NOT NULL AUTO_INCREMENT,
  `vc_type` varchar(50) NOT NULL,
  PRIMARY KEY (`vc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_category: ~5 rows (approximately)
/*!40000 ALTER TABLE `vehicle_category` DISABLE KEYS */;
INSERT INTO `vehicle_category` (`vc_id`, `vc_type`) VALUES
	(1, 'Motor'),
	(2, 'Lorry'),
	(3, 'Vehicle'),
	(4, 'Hitachi'),
	(5, 'Forklift');
/*!40000 ALTER TABLE `vehicle_category` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_driver
CREATE TABLE IF NOT EXISTS `vehicle_driver` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_name` varchar(255) DEFAULT NULL,
  `d_status` int(11) DEFAULT NULL COMMENT '1-active 0-inactive',
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_driver: ~0 rows (approximately)
/*!40000 ALTER TABLE `vehicle_driver` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_driver` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_insurance
CREATE TABLE IF NOT EXISTS `vehicle_insurance` (
  `vi_id` int(11) NOT NULL AUTO_INCREMENT,
  `vv_id` int(11) DEFAULT NULL,
  `vi_vrt_id` int(11) DEFAULT NULL,
  `vi_insurance_fromDate` date DEFAULT NULL,
  `vi_insurance_dueDate` date DEFAULT NULL,
  `vi_next_dueDate` date DEFAULT NULL,
  `vi_insuranceStatus` int(11) DEFAULT NULL,
  `vi_premium_amount` double DEFAULT NULL,
  `vi_ncd` double DEFAULT NULL,
  `vi_sum_insured` double DEFAULT NULL,
  `vi_excess_paid` double DEFAULT NULL,
  `vi_lastUpdated` date DEFAULT NULL,
  `vi_updatedBy` int(11) DEFAULT NULL,
  `vi_status` int(11) DEFAULT 1 COMMENT '1-active , 0- inactive',
  `vi_amount` double DEFAULT NULL,
  PRIMARY KEY (`vi_id`),
  KEY `vv_id` (`vv_id`),
  KEY `vrt_id` (`vi_vrt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_insurance: ~2 rows (approximately)
/*!40000 ALTER TABLE `vehicle_insurance` DISABLE KEYS */;
INSERT INTO `vehicle_insurance` (`vi_id`, `vv_id`, `vi_vrt_id`, `vi_insurance_fromDate`, `vi_insurance_dueDate`, `vi_next_dueDate`, `vi_insuranceStatus`, `vi_premium_amount`, `vi_ncd`, `vi_sum_insured`, `vi_excess_paid`, `vi_lastUpdated`, `vi_updatedBy`, `vi_status`, `vi_amount`) VALUES
	(2, 14, 2, '2020-02-01', '2021-02-01', NULL, 1, 1000, 25, 750, 600, '2020-02-17', 2, 0, 150),
	(3, 17, 3, '2020-02-25', '2020-02-29', NULL, 1, 1000, 25, 750, 600, '2020-02-25', 2, 0, 150);
/*!40000 ALTER TABLE `vehicle_insurance` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_permit
CREATE TABLE IF NOT EXISTS `vehicle_permit` (
  `vpr_id` int(11) NOT NULL AUTO_INCREMENT,
  `vv_id` int(11) NOT NULL DEFAULT 0,
  `vpr_type` varchar(50) NOT NULL DEFAULT '0',
  `vpr_no` varchar(50) NOT NULL DEFAULT '0',
  `vpr_license_ref_no` varchar(50) NOT NULL DEFAULT '0',
  `vpr_due_date` date NOT NULL DEFAULT '0000-00-00',
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`vpr_id`),
  KEY `vv_id` (`vv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_permit: ~128 rows (approximately)
/*!40000 ALTER TABLE `vehicle_permit` DISABLE KEYS */;
INSERT INTO `vehicle_permit` (`vpr_id`, `vv_id`, `vpr_type`, `vpr_no`, `vpr_license_ref_no`, `vpr_due_date`, `status`) VALUES
	(1, 16, '', '', '', '1970-01-01', 1),
	(2, 17, 'C', '81787', 'A50014893-X/13', '2019-01-12', 1),
	(3, 18, '-', '', '-', '2020-02-28', 1),
	(4, 19, 'A', '88429', 'AB0001559-9/04', '2020-04-03', 1),
	(5, 20, '', '', '', '1970-01-01', 1),
	(6, 21, 'A', '115483', 'LA/SA/4147', '2020-06-07', 1),
	(7, 22, 'A', '88428', 'LA/SA/4774', '2020-04-07', 1),
	(8, 23, '', '', '', '1970-01-01', 1),
	(9, 24, '', '', '', '1970-01-01', 1),
	(10, 25, '-', '', '-', '1970-01-01', 1),
	(11, 26, 'A', '114843', 'LA/SA/4251', '2022-02-13', 1),
	(12, 27, '-', '', '-', '1970-01-01', 1),
	(13, 28, '-', '', '-', '1970-01-01', 1),
	(14, 29, '', '', '', '1970-01-01', 1),
	(15, 30, '-', '', '-', '1970-01-01', 1),
	(16, 31, 'A', '40343', 'LA/SA/5316', '2022-06-10', 1),
	(17, 32, '-', '', '-', '1970-01-01', 1),
	(18, 33, '-', '', '-', '1970-01-01', 1),
	(19, 34, 'A', '98982', 'AB0004117-6/06', '2021-12-12', 1),
	(20, 35, '-', '', '-', '2020-02-28', 1),
	(21, 36, '-', '', '-', '1970-01-01', 1),
	(22, 37, '-', '', '-', '1970-01-01', 1),
	(23, 38, '-', '', '-', '1970-01-01', 1),
	(24, 39, '-', '', '-', '1970-01-01', 1),
	(25, 40, '-', '', '-', '1970-01-01', 1),
	(26, 41, '-', '', '-', '1970-01-01', 1),
	(27, 42, '-', '', '-', '1970-01-01', 1),
	(28, 43, '-', '', '-', '1970-01-01', 1),
	(29, 44, '-', '', '-', '1970-01-01', 1),
	(30, 45, '-', '', '-', '1970-01-01', 1),
	(31, 46, '-', '', '-', '1970-01-01', 1),
	(32, 47, '-', '', '-', '1970-01-01', 1),
	(33, 48, '-', '', '-', '1970-01-01', 1),
	(34, 49, '-', '', '-', '2020-02-28', 1),
	(35, 50, '-', '', '-', '1970-01-01', 1),
	(36, 51, '-', '', '-', '1970-01-01', 1),
	(37, 52, '-', '', '-', '1970-01-01', 1),
	(38, 53, '-', '', '-', '1970-01-01', 1),
	(39, 54, '-', '', '-', '1970-01-01', 1),
	(40, 55, '-', '', '-', '1970-01-01', 1),
	(41, 56, '-', '', '-', '1970-01-01', 1),
	(42, 57, '-', '', '-', '1970-01-01', 1),
	(43, 58, '-', '', '-', '1970-01-01', 1),
	(44, 59, '', '', '', '1970-01-01', 1),
	(45, 60, '-', '', '-', '1970-01-01', 1),
	(46, 61, '-', '', '-', '1970-01-01', 1),
	(47, 62, '-', '', '-', '1970-01-01', 1),
	(48, 63, '-', '', '-', '1970-01-01', 1),
	(49, 64, '-', '', '-', '1970-01-01', 1),
	(50, 65, '-', '', '-', '1970-01-01', 1),
	(51, 66, '-', '', '-', '1970-01-01', 1),
	(52, 67, '-', '', '-', '1970-01-01', 1),
	(53, 68, '-', '', '-', '1970-01-01', 1),
	(54, 69, '-', '', '-', '1970-01-01', 1),
	(55, 70, '-', '', '-', '1970-01-01', 1),
	(56, 71, '-', '', '-', '1970-01-01', 1),
	(57, 72, '-', '', '-', '2020-02-28', 1),
	(58, 73, '-', '', '-', '1970-01-01', 1),
	(59, 74, '-', '', '-', '2020-02-28', 1),
	(60, 75, '-', '', '-', '1970-01-01', 1),
	(61, 76, '-', '', '-', '1970-01-01', 1),
	(62, 77, '-', '', '-', '1970-01-01', 1),
	(63, 78, '-', '', '-', '1970-01-01', 1),
	(64, 79, '', '', '', '1970-01-01', 1),
	(65, 80, '-', '', '-', '1970-01-01', 1),
	(66, 81, '-', '', '-', '1970-01-01', 1),
	(67, 82, '-', '', '-', '1970-01-01', 1),
	(68, 83, '-', '', '-', '1970-01-01', 1),
	(69, 84, '-', '', '-', '1970-01-01', 1),
	(70, 85, '-', '', '-', '1970-01-01', 1),
	(71, 86, '-', '', '-', '1970-01-01', 1),
	(72, 87, '-', '', '-', '1970-01-01', 1),
	(73, 88, '-', '', '-', '1970-01-01', 1),
	(74, 89, '-', '', '-', '1970-01-01', 1),
	(75, 90, '-', '', '-', '1970-01-01', 1),
	(76, 91, '', '', '', '1970-01-01', 1),
	(77, 92, '-', '', '-', '1970-01-01', 1),
	(78, 93, '-', '', '-', '1970-01-01', 1),
	(79, 94, '-', '', '-', '1970-01-01', 1),
	(80, 95, '-', '', '-', '1970-01-01', 1),
	(81, 96, '-', '', '-', '1970-01-01', 1),
	(82, 97, '-', '', '-', '1970-01-01', 1),
	(83, 98, '-', '', '-', '1970-01-01', 1),
	(84, 99, '-', '', '-', '1970-01-01', 1),
	(85, 100, '-', '', '-', '1970-01-01', 1),
	(86, 101, '-', '', '-', '1970-01-01', 1),
	(87, 102, '-', '', '-', '1970-01-01', 1),
	(88, 103, '-', '', '-', '1970-01-01', 1),
	(89, 104, '-', '', '-', '1970-01-01', 1),
	(90, 105, '-', '', '-', '1970-01-01', 1),
	(91, 106, 'A', '', 'A50014747-6/12', '2021-12-05', 1),
	(92, 107, '-', '', '-', '1970-01-01', 1),
	(93, 108, '-', '', '-', '1970-01-01', 1),
	(94, 109, '-', '', '-', '1970-01-01', 1),
	(95, 0, '', '', '', '1970-01-01', 1),
	(96, 110, 'A', '104886', 'A50012663-8/12', '2022-07-02', 1),
	(97, 111, 'A', '109609', 'A50014186-1/12', '2021-07-29', 1),
	(98, 112, '', '', '', '1970-01-01', 1),
	(99, 113, '', '', '', '1970-01-01', 1),
	(100, 114, '', '', '', '1970-01-01', 1),
	(101, 115, '', '', '', '1970-01-01', 1),
	(102, 116, '', '', '', '1970-01-01', 1),
	(103, 117, '', '', '', '1970-01-01', 1),
	(104, 118, '', '', '', '1970-01-01', 1),
	(105, 119, '', '', '', '1970-01-01', 1),
	(106, 120, '', '', '', '1970-01-01', 1),
	(107, 121, 'A', '115100', 'A50014969-9/13', '2022-05-06', 1),
	(108, 122, 'A', '86090', 'A50009777-4/08', '2020-03-17', 1),
	(109, 123, 'A', '73982', 'A50013069-5/12', '2020-10-11', 1),
	(110, 124, '', '', '', '1970-01-01', 1),
	(111, 125, 'A', '104887', 'A50012563-0/12', '2020-06-05', 1),
	(112, 126, '', '', '', '1970-01-01', 1),
	(113, 127, 'A', '96323', 'A50011417-9/11', '2021-06-20', 1),
	(114, 128, 'A', '86096', 'A50009771-X/08', '2020-03-16', 1),
	(115, 129, 'A', '101960', 'A50012329-4/11', '2020-03-18', 1),
	(116, 130, 'A', '72800', 'A50012795-7/12', '2020-07-29', 1),
	(117, 131, '', '', '', '1970-01-01', 1),
	(118, 132, '', '', '', '1970-01-01', 1),
	(119, 133, '', '', '', '1970-01-01', 1),
	(120, 134, '', '', '', '1970-01-01', 1),
	(121, 135, '', '', '', '1970-01-01', 1),
	(122, 136, '', '', '', '1970-01-01', 1),
	(123, 137, '', '', '', '1970-01-01', 1),
	(124, 138, 'A', '100807', 'LPKP/SBH/2016/L/LA/00363', '2021-11-20', 1),
	(125, 139, '', '', '', '1970-01-01', 1),
	(126, 140, 'A', '119498', 'A50009401-4/08', '2022-12-23', 1),
	(127, 141, 'A', '96329', 'A50011507-2/11', '2021-07-17', 1),
	(128, 142, 'A', '72888', 'A50012796-2/12', '2022-07-29', 1);
/*!40000 ALTER TABLE `vehicle_permit` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_puspakom
CREATE TABLE IF NOT EXISTS `vehicle_puspakom` (
  `vp_id` int(11) NOT NULL AUTO_INCREMENT,
  `vv_id` int(11) DEFAULT NULL,
  `vp_vrt_id` int(11) DEFAULT NULL,
  `vp_fitnessDate` date DEFAULT NULL,
  `vp_roadtaxDueDate` date DEFAULT NULL,
  `vp_next_dueDate` date DEFAULT NULL,
  `vp_runner` varchar(100) DEFAULT '',
  `vp_lastUpdated` datetime NOT NULL,
  `vp_updatedBy` int(11) NOT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1-active, 0-inactive',
  PRIMARY KEY (`vp_id`),
  KEY `vv_id` (`vv_id`),
  KEY `vp_vrt_id` (`vp_vrt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.vehicle_puspakom: ~2 rows (approximately)
/*!40000 ALTER TABLE `vehicle_puspakom` DISABLE KEYS */;
INSERT INTO `vehicle_puspakom` (`vp_id`, `vv_id`, `vp_vrt_id`, `vp_fitnessDate`, `vp_roadtaxDueDate`, `vp_next_dueDate`, `vp_runner`, `vp_lastUpdated`, `vp_updatedBy`, `status`) VALUES
	(2, 14, 2, '2020-02-25', '2021-02-01', '2020-02-18', 'Jenneffer', '2020-02-17 16:40:06', 2, 0),
	(3, 17, 3, '2020-02-25', '2020-02-29', NULL, 'Test jennn', '2020-02-25 15:53:45', 2, 0);
/*!40000 ALTER TABLE `vehicle_puspakom` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_roadtax
CREATE TABLE IF NOT EXISTS `vehicle_roadtax` (
  `vrt_id` int(11) NOT NULL AUTO_INCREMENT,
  `vv_id` int(11) NOT NULL,
  `vrt_lpkpPermit_dueDate` date DEFAULT NULL,
  `vrt_roadTax_fromDate` date NOT NULL,
  `vrt_roadTax_dueDate` date NOT NULL,
  `vrt_next_dueDate` date DEFAULT NULL,
  `vrt_roadtaxPeriodYear` double NOT NULL,
  `vrt_roadtaxPeriodMonth` double NOT NULL,
  `vrt_roadtaxPeriodDay` double NOT NULL,
  `vrt_amount` double NOT NULL,
  `vrt_lastUpdated` datetime NOT NULL,
  `vrt_updatedBy` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '1-active, 0-inactive',
  PRIMARY KEY (`vrt_id`),
  KEY `vv_id` (`vv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.vehicle_roadtax: ~2 rows (approximately)
/*!40000 ALTER TABLE `vehicle_roadtax` DISABLE KEYS */;
INSERT INTO `vehicle_roadtax` (`vrt_id`, `vv_id`, `vrt_lpkpPermit_dueDate`, `vrt_roadTax_fromDate`, `vrt_roadTax_dueDate`, `vrt_next_dueDate`, `vrt_roadtaxPeriodYear`, `vrt_roadtaxPeriodMonth`, `vrt_roadtaxPeriodDay`, `vrt_amount`, `vrt_lastUpdated`, `vrt_updatedBy`, `status`) VALUES
	(2, 14, '2020-02-22', '2020-02-01', '2021-02-01', NULL, 1, 0, 1, 56, '2020-02-17 16:54:17', 2, 0),
	(3, 17, NULL, '2020-02-25', '2020-02-29', NULL, 0, 0, 4, 56, '2020-02-25 15:53:45', 2, 0);
/*!40000 ALTER TABLE `vehicle_roadtax` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_runner
CREATE TABLE IF NOT EXISTS `vehicle_runner` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_runner: ~0 rows (approximately)
/*!40000 ALTER TABLE `vehicle_runner` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_runner` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_summons
CREATE TABLE IF NOT EXISTS `vehicle_summons` (
  `vs_id` int(11) NOT NULL AUTO_INCREMENT,
  `vv_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `vs_summon_no` varchar(50) DEFAULT NULL,
  `vs_pv_no` varchar(50) DEFAULT NULL,
  `vs_reimbursement_amt` double DEFAULT NULL,
  `vs_balance` double DEFAULT NULL,
  `vs_remarks` varchar(255) DEFAULT NULL,
  `vs_summon_type` int(11) DEFAULT NULL COMMENT '1- pdrm, 2- jpj, 3-others',
  `vs_summon_type_desc` varchar(255) DEFAULT NULL COMMENT 'summon description if type is others',
  `vs_driver_name` varchar(100) DEFAULT NULL,
  `vs_summon_date` date DEFAULT NULL,
  `vs_description` varchar(255) DEFAULT NULL COMMENT 'offence details',
  `vs_date_added` date DEFAULT NULL,
  `status` int(1) DEFAULT 1 COMMENT '1-active, 0-inactive',
  PRIMARY KEY (`vs_id`),
  KEY `vv_id` (`vv_id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_summons: ~0 rows (approximately)
/*!40000 ALTER TABLE `vehicle_summons` DISABLE KEYS */;
INSERT INTO `vehicle_summons` (`vs_id`, `vv_id`, `driver_id`, `vs_summon_no`, `vs_pv_no`, `vs_reimbursement_amt`, `vs_balance`, `vs_remarks`, `vs_summon_type`, `vs_summon_type_desc`, `vs_driver_name`, `vs_summon_date`, `vs_description`, `vs_date_added`, `status`) VALUES
	(2, 14, NULL, 'A102776', 'PD1675343', 550, 0, NULL, 1, '', 'BABUi', '2020-02-17', 'menghalang lalu lintas', '2020-02-17', 0);
/*!40000 ALTER TABLE `vehicle_summons` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_summon_payment
CREATE TABLE IF NOT EXISTS `vehicle_summon_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summon_id` int(11) DEFAULT 0,
  `payment_amount` double DEFAULT NULL,
  `bankin_amount` double DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `bankin_date` date DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `summon_id` (`summon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_summon_payment: ~3 rows (approximately)
/*!40000 ALTER TABLE `vehicle_summon_payment` DISABLE KEYS */;
INSERT INTO `vehicle_summon_payment` (`id`, `summon_id`, `payment_amount`, `bankin_amount`, `payment_date`, `bankin_date`, `date_added`) VALUES
	(2, 0, 0, 0, '1970-01-01', '1970-01-01', '2020-02-17'),
	(3, 2, 500, 500, '2020-02-17', '2020-02-17', '2020-02-17'),
	(4, 2, 50, 50, '2020-02-17', '2020-02-17', '2020-02-17');
/*!40000 ALTER TABLE `vehicle_summon_payment` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_summon_type
CREATE TABLE IF NOT EXISTS `vehicle_summon_type` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_summon_type: ~3 rows (approximately)
/*!40000 ALTER TABLE `vehicle_summon_type` DISABLE KEYS */;
INSERT INTO `vehicle_summon_type` (`st_id`, `st_name`) VALUES
	(1, 'JPJ'),
	(2, 'PDRM'),
	(3, 'OTHER');
/*!40000 ALTER TABLE `vehicle_summon_type` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_total_loss
CREATE TABLE IF NOT EXISTS `vehicle_total_loss` (
  `vt_id` int(11) NOT NULL AUTO_INCREMENT,
  `vt_insurance` varchar(50) DEFAULT NULL,
  `vt_offer_letter_date` date DEFAULT NULL,
  `vt_payment_advice_date` date DEFAULT NULL,
  `vt_vv_id` int(11) DEFAULT NULL,
  `vt_amount` double DEFAULT NULL,
  `vt_beneficiary_bank` varchar(50) DEFAULT NULL,
  `vt_trans_ref_no` varchar(50) DEFAULT NULL,
  `vt_driver` varchar(50) DEFAULT NULL,
  `vt_remark` text DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1-active, 0-deleted',
  PRIMARY KEY (`vt_id`),
  KEY `vv_id` (`vt_vv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table admin.vehicle_total_loss: ~27 rows (approximately)
/*!40000 ALTER TABLE `vehicle_total_loss` DISABLE KEYS */;
INSERT INTO `vehicle_total_loss` (`vt_id`, `vt_insurance`, `vt_offer_letter_date`, `vt_payment_advice_date`, `vt_vv_id`, `vt_amount`, `vt_beneficiary_bank`, `vt_trans_ref_no`, `vt_driver`, `vt_remark`, `date_added`, `status`) VALUES
	(1, 'tst', '2020-03-02', '2020-03-02', 18, 50000, 'test', 'test', 'test', 'teat', '2020-03-02', 0),
	(2, 'tst', '2020-03-02', '2020-03-02', 18, 50000, 'test', 'test', 'test', 'teat', '2020-03-02', 0),
	(3, '', '1970-01-01', '1970-01-01', 18, 0, '', '', '', '', '2020-03-02', 0),
	(4, '', '1970-01-01', '1970-01-01', 0, 0, '', '', '', '', '2020-03-02', 1),
	(5, 'qwerty', '2020-03-02', '2020-03-02', 27, 1200, 'bsn', '123456kj', 'SULTAN', 'tet', '2020-03-02', 0),
	(6, 'ALLIANZ GENERAL INSURANCE', '2019-10-24', '2019-10-18', 112, 27.3, 'HONG LEONG BANK BERHAD', '518334640100092', 'WALTER EDIP', 'TOTAL LOSS', '2020-03-04', 0),
	(7, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 112, 6, '', '', '', '', '2020-03-04', 0),
	(8, 'ALLIANZ GENERAL INSURANCE', '2019-10-24', '2019-12-18', 112, 27.3, 'HONG LEONG', '518334640100092', 'WALTER EDIP', 'TOTAL LOSS', '2020-03-04', 0),
	(9, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 113, 36, '', '', '', '', '2020-03-04', 0),
	(10, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 113, 36000, '', '', '', '', '2020-03-04', 0),
	(11, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 112, 27300, '', '', '', '', '2020-03-04', 0),
	(12, 'ALLIANZ GENERAL INSURANCE', '2019-10-24', '2019-12-18', 112, 273000, 'HONG LEONG', '518334640100092', 'WALTER EDIP', 'TOTAL LOSS\r\n', '2020-03-04', 0),
	(13, 'ALLIANZ GENERAL INSURANCE', '2019-10-24', '2019-12-18', 112, 27300, 'HONG LEONG', '518334640100092', 'WALTER EDIP', 'TOTAL LOSS', '2020-03-04', 1),
	(14, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 113, 3600, '', '', '', '', '2020-03-04', 0),
	(15, '', '1970-01-01', '1970-01-01', 0, 36000, '', '', '', '', '2020-03-04', 1),
	(16, 'ALLIANZ GENERAL INSURANCE', '2019-04-09', '2019-06-26', 113, 36000, 'HONG LEONG', '516741150100197', 'LO CHEE LEONG', 'TOTAL LOSS', '2020-03-04', 1),
	(17, 'ALLIANZ GENERAL INSURANCE', '2018-07-26', '2018-09-24', 114, 165000, 'HONG LEONG', '514172200100283', 'MANSUR LATJAMA', 'TOTAL LOSS', '2020-03-04', 1),
	(18, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 115, 224400, '', '', '', '', '2020-03-04', 0),
	(19, 'ALLIANZ', '2018-04-05', '2018-11-29', 115, 224400, 'HONG LEONG', '514810850100353', 'JOSEPH A/L DUYA', 'TOTAL LOSS', '2020-03-04', 0),
	(20, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 115, 224400, '', '', '', '', '2020-03-04', 0),
	(21, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 115, 224400000, '', '', '', '', '2020-03-04', 0),
	(22, '', '1970-01-01', '1970-01-01', 115, 22440, '', '', '', '', '2020-03-04', 0),
	(23, 'ALLIANZ GENERAL INSURANCE', '2018-04-05', '2018-11-29', 115, 22440, 'HONG LEONG', '514810850100353', 'JOSEPH A/L DUYA', 'TOTAL LOSS', '2020-03-04', 1),
	(24, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 116, 3400, '', '', '', '', '2020-03-04', 0),
	(25, 'ALLIANZ GENERAL INSURANCE', '2018-11-04', '2018-11-29', 116, 34000, 'HONG LEONG', '514810850100349', 'JEFFRY P.RATU ARAN', 'TOTAL LOSS', '2020-03-04', 1),
	(26, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '1970-01-01', 117, 31100, '', '', '', '', '2020-03-04', 0),
	(27, 'ALLIANZ GENERAL INSURANCE', '1970-01-01', '2018-11-15', 117, 31100, 'HONG LEONG', '514676020100516', 'ALIMUDDIN BIN LAPAWELA', 'TOTAL LOSS', '2020-03-04', 1);
/*!40000 ALTER TABLE `vehicle_total_loss` ENABLE KEYS */;

-- Dumping structure for table admin.vehicle_vehicle
CREATE TABLE IF NOT EXISTS `vehicle_vehicle` (
  `vv_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `vv_category` int(11) NOT NULL DEFAULT 0,
  `vv_vehicleNo` varchar(25) NOT NULL,
  `vv_brand` varchar(25) NOT NULL,
  `vv_model` varchar(50) NOT NULL,
  `vv_engine_no` varchar(50) NOT NULL,
  `vv_chasis_no` varchar(50) NOT NULL,
  `vv_driver` varchar(50) NOT NULL,
  `vv_bdm` double NOT NULL DEFAULT 0,
  `vv_btm` double NOT NULL DEFAULT 0,
  `vv_yearPurchased` varchar(25) NOT NULL,
  `vv_yearMade` varchar(25) NOT NULL,
  `vv_finance` varchar(50) NOT NULL,
  `vv_disposed` varchar(50) NOT NULL,
  `vv_capacity` double NOT NULL DEFAULT 0,
  `vv_remark` text NOT NULL,
  `vv_status` varchar(50) NOT NULL DEFAULT '' COMMENT 'active, inactive, not sure, total loss',
  `date_added` datetime DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1-active , 0- deleted',
  PRIMARY KEY (`vv_id`),
  KEY `company_id` (`company_id`),
  KEY `vehicle_category` (`vv_category`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

-- Dumping data for table admin.vehicle_vehicle: ~129 rows (approximately)
/*!40000 ALTER TABLE `vehicle_vehicle` DISABLE KEYS */;
INSERT INTO `vehicle_vehicle` (`vv_id`, `company_id`, `vv_category`, `vv_vehicleNo`, `vv_brand`, `vv_model`, `vv_engine_no`, `vv_chasis_no`, `vv_driver`, `vv_bdm`, `vv_btm`, `vv_yearPurchased`, `vv_yearMade`, `vv_finance`, `vv_disposed`, `vv_capacity`, `vv_remark`, `vv_status`, `date_added`, `status`) VALUES
	(14, 18, 3, 'SB1413C', 'MITSUBISHI', 'CITY', '', '', '', 0, 0, '2010 12', '', '', '', 2000, '', '', '2020-02-18 16:55:59', 0),
	(15, 18, 3, 'ss4337n', 'Perodua', 'MyVi', '', '', '', 0, 0, '2011', '', '', '', 1500, '', '', '2020-02-18 08:42:48', 0),
	(16, 0, 0, '', '', '', '', '', '', 0, 0, '', '', '', '', 0, '', '', '2020-02-25 15:05:35', 1),
	(17, 9, 1, 'SAA2935R', 'ISUZU', 'NPR70(RB/HS L1)', '4HG1-392649', 'NPR70L-7401321', 'SULTAN', 7000, 3950, '', '2007', 'PBB', '-', 1840, 'MY OWN REMARK', '', '2020-02-25 15:11:54', 0),
	(18, 8, 2, 'SA1121N', 'ISUZU', 'NPR58L CHASSIS CAB', '4BE1-973634', 'JAANPR58LM-7104482', '-', 6000, 2720, '', '1992', '-', '-', 3280, 'Not sure if this lorry currently is active of not', '', '2020-02-28 10:24:28', 1),
	(19, 8, 2, 'SA2558X', 'ISUZU', 'FSR11H', '6BG1-707075', 'JALFSR11HP3601496', 'WORKSHOP PDU', 11000, 5440, '', '1998', '-', '-', 5560, '', '', '2020-02-28 10:26:45', 1),
	(20, 8, 2, 'SA2623J', 'ISUZU', 'NPR596 TRUCK', '944340', '7101126', '', 7000, 3560, '', '1988', '-', '-', 3440, 'Not sure if this lorry currently is active or not', '', '2020-02-28 10:36:45', 1),
	(21, 8, 2, 'SA2709V', 'NISSAN', 'CPB15NE', 'MD92-001418', 'CPB15NE-01015', 'RASHID BIN SAID', 16000, 6510, '', '1997', '-', '-', 9490, '', '', '2020-02-28 10:43:04', 1),
	(22, 8, 2, 'SA3230N', 'NISSAN', 'DUMP TRUCK', 'RD3-025169', 'CW51H-11543', 'LOGISTICS STANDBY LORRY', 21000, 10500, '', '1988', '-', '-', 10500, '', '', '2020-02-28 10:56:34', 1),
	(23, 8, 2, 'SA3529N', 'NISSAN', 'CPB15N-C/W RAILING CANVAS', 'NE6-009022T', 'CPB15N-01346', '', 16000, 9040, '', '1991', '-', '-', 6960, 'Not sure if lorry currently active or not', '', '2020-02-28 11:06:06', 1),
	(24, 8, 2, 'SA4043R', 'NISSAN', 'FEED BULK TANK', 'RE8-000367', 'CW53H-00334', '', 20000, 10140, '', '1991', '-', '-', 9860, 'Not sure if lorry currently is active or not', '', '2020-02-28 11:08:30', 1),
	(25, 0, 3, 'SA4383P', 'ISUZU', 'PICK UP CREW CAB', '947498', 'JAATFS55HR7102710', '-', 0, 0, '', '1995', '-', '-', 0, 'Not sure if this vehicle currently is active or not', '', '2020-02-28 11:16:38', 1),
	(26, 8, 2, 'SA5935V', 'NISSAN', 'CPB15NE-01127', 'FE6-209072C', 'CPB15NE-01127', 'BASRI BIN NUR', 16000, 6480, '', '1997', '-', '-', 9520, '', '', '2020-02-28 11:26:05', 1),
	(27, 8, 2, 'SD7289', 'ISUZU', 'ISUZU', '4BD1-133182', '4603198', '-', 7000, 3110, '', '1986', '-', '-', 3890, 'Not sure if this lorry currently is active or not', '', '2020-02-28 11:29:40', 1),
	(28, 8, 2, 'ST7360C', 'NISSAN', 'CPB15N', 'NE6-006853T', 'CPB15N-00837', '-', 16000, 7170, '', '1990', '-', '-', 8830, 'Not sure if this lorry currently active of not', '', '2020-02-28 11:31:48', 1),
	(29, 0, 0, 'SA778B', '', '', '', '', '', 0, 0, '', '', '', '', 0, '', '', '2020-02-28 11:32:06', 1),
	(30, 8, 2, 'SA778B', 'MAZDA', 'LIGHT TRUCK', 'TF-122785', 'EXC-82582', '-', 5000, 3110, '', '1978', '-', '-', 1890, 'Not sure if this lorry currently is active or not', '', '2020-02-28 11:40:07', 1),
	(31, 8, 2, 'SB8202', 'NISSAN', 'CM87K-TRUCK', 'FE6-301837D', 'CM87K-05758', 'ALIMUDIN MADA', 9950, 4410, '', '1993', '-', '', 5540, '', '', '2020-02-28 11:45:25', 1),
	(32, 8, 2, 'SAA8935K', 'DAIHATSU', 'DELTA V116-HA', '14B1783632', 'JDA00V11600A06585', 'TUDIKI', 5000, 2980, '', '2005', '-', '-', 2020, '', '', '2020-02-28 11:49:52', 1),
	(33, 8, 2, 'ST9055C', 'ISUZU', 'NPR596-03A', '309530', '7101448', '-', 7000, 3790, '', '1991', '-', '-', 3210, 'Not sure if this lorry currently is active or not', '', '2020-02-28 11:52:21', 1),
	(34, 8, 2, 'ST9199C', 'NISSAN', 'CMF88H', 'FE6-009680A', 'CMF88H-01977', 'IBNO', 10000, 5210, '', '1991', '-', '-', 4790, '', '', '2020-02-28 12:04:19', 1),
	(35, 8, 2, 'ST9228C', 'NISSAN', 'CPB15N-01382', 'NE6-009504 T', 'CPB15N', '-', 16000, 9490, '', '1991', '-', '-', 6510, '', '', '2020-02-28 13:21:04', 1),
	(36, 8, 2, 'SA938L', 'ISUZU', 'NPR596-03A TRUCK', '4BD1-134782', '7100293', 'HAZLAN', 7000, 3540, '', '1991', '-', '-', 3460, '', '', '2020-02-28 13:28:25', 1),
	(37, 1, 1, 'SU1279B', 'HONDA', 'C100', 'HA13E-4032970', 'PMKHA13209B032932', 'TONY LAMAR (MR.LING)', 0, 0, '', '2009', '-', '-', 0, '', '', '2020-02-28 13:36:39', 1),
	(38, 1, 2, 'SA1313J', 'TOYOTA', 'DYNA HIACE PICK UP', '2L-2897152', 'LH80-0019675', 'REJOS DARIUS', 2400, 1660, '', '1988', '-', '-', 740, '', '', '2020-02-28 14:00:40', 1),
	(39, 1, 1, 'SD1632L', 'DNC ASIATIC HOLDING SDN B', 'DEMAK EX 90', 'PMDD147FMFE507142', 'PMDDLMPF0FE507289', 'LERYSAM JAINUS', 0, 0, '', '2014', '-', '-', 0, '', '', '2020-02-28 14:11:01', 1),
	(40, 1, 3, 'SA1682K', 'DAIHATSU', 'DELTA V57A', '536410', 'V57A-99122', 'FARM TAMPARULI (CHAI KIN FATT)', 2500, 12600, '', '1990', '-', '', 1240, 'OFF ROAD', '', '2020-02-28 14:14:34', 1),
	(41, 1, 3, 'SAA223T', 'TOYOTA', 'LAND CRUISER KR-HDJ101K', '1HD0240691', 'HDJ101-0025449', 'PATRICK SHU', 0, 0, '', '2003', '-', '-', 0, '', '', '2020-02-28 14:16:51', 1),
	(42, 1, 2, 'SAA2240A', 'DAIHATSU', 'V58R-HS DELTA', '639270', 'V58B53386', 'STANDBY AT KILANG', 4500, 1830, '', '2000', '-', '-', 2670, '', '', '2020-02-28 14:21:24', 1),
	(43, 1, 2, 'SAA2288Y', 'ISUZU', 'NPR71L (RB/BK-MOD)', '4HG1693517', 'NPR71L-7422466', 'WILLIAM (SANDAKAN)', 5000, 3310, '', '2009', '-', '-', 1690, 'Puspakom & road tax William (contract farm) claim dengan company', '', '2020-02-28 14:56:00', 1),
	(44, 1, 3, 'QMH2303', 'FORD', 'RANGER UVIM FM1 D/CABIN 4X4', 'WLAT499311', 'PR8CACBAL4LZ02110', 'NICHOLAS WA', 0, 0, '', '2004', '-', '-', 0, '', '', '2020-02-28 15:00:34', 1),
	(45, 1, 2, 'SA2638U', 'ISUZU', 'NPR596-06H', '4BD1-570176', 'JAANPR59PM7110485', '-', 5000, 3250, '', '1996', '-', '-', 1750, 'Not sure if this lorry currently is active or not', '', '2020-02-28 15:04:10', 1),
	(46, 1, 3, 'SAA2848K', 'MAZDA', 'B2500 DOUBLE CAB 4X4', 'WL100245', 'PMZUNYOW2MM101736', 'WORKSHOP (ARTHUR)', 0, 0, '', '2005', '-', '-', 0, '', '', '2020-02-28 15:10:32', 1),
	(47, 1, 3, 'SA285R', 'NISSAN', 'VPC22EFU', 'A15-C004666', 'VPC22-859494', 'RICHMOND (CATCHING TEAM)', 0, 0, '', '1995', '-', '-', 0, '', '', '2020-02-28 15:13:57', 1),
	(48, 1, 3, 'SWA2816', 'NISSAN', 'X-TRAIL 2.0L CVT MID', 'MR20502116C', 'PN8JAAT32TCA49298', 'WONG HUE FEN', 0, 0, '', '2019', 'HONG LEONG BANK', '-', 0, '', '', '2020-02-28 15:23:33', 1),
	(49, 1, 3, 'QMD3303', 'NISSAN', 'SERENA 2.0L EDAARFBC24EX7', 'QR20-571330A', 'PN8EAAC24TCA06125', 'WONG HUE FEN', 0, 0, '', '2005', '-', '-', 0, '', '', '2020-02-28 15:26:23', 1),
	(50, 1, 3, 'SA3398M', 'TOYOTA', 'HILUX SURF', '1KZ-0161794', 'LN130-0095797', 'STANDBY ADMIN', 0, 0, '', '1992', '-', '-', 0, '', '', '2020-02-28 15:29:44', 1),
	(51, 1, 3, 'SAA356V', 'PROTON', 'SAGA 1.3 MANUAL', 'S4PEPD6437', 'PL1BT3SNR8B027593', 'UNCLE CHONG', 0, 0, '', '2008', '-', '-', 0, '', '', '2020-02-28 15:32:26', 1),
	(52, 1, 3, 'SAA3741P', 'KIA', 'PREGIO FPGDH55', 'J2455005', 'PNAKF5S036N003190', 'RICHMOND (CATCHING TEAM)', 0, 0, '', '2006', '-', '-', 0, '', '', '2020-02-28 15:36:56', 1),
	(53, 3, 3, 'SYE3880', 'PROTON', 'X70 1.8 TGDI PREMIUM 2WD', '4G18TDBK4CB0506451', 'L6T7742Z6KU049486', 'WONG WAH PENG', 0, 0, '', '2019', '', '-', 0, '', '', '2020-02-28 15:44:01', 1),
	(54, 1, 3, 'JKL3809', 'TOYOTA', 'HILUX DOUBLE CAB 2.5 MT', '2KD9902310', 'PN133JV2508010632', 'STANDBY ADMIN', 0, 0, '', '2007', '-', '-', 0, '', '', '2020-02-28 15:48:30', 1),
	(55, 1, 3, 'SA3935U', 'TOYOTA', 'L/CRUISER HDJ81V', '1HD-0134771', 'HDJ81-0073105', 'WONG KOK PING', 0, 0, '', '1997', '-', '-', 0, 'Repair cost under IISB', '', '2020-02-28 15:51:07', 1),
	(56, 1, 0, 'SAC4108B', 'TOYOTA', '7FBR18', 'RC28276', '7FBR18-53376', 'KILANG POTONG', 0, 0, '', '2016', 'ORIX CREDIT (M) SDN BHD', '-', 0, '', '', '2020-02-28 15:53:39', 1),
	(57, 1, 1, 'SAB4325X', 'DNC ASIATIC HOLDING SDN B', 'DEMAK EX 90', 'PMDD147FMFE713215', 'PMDDLMPF8FE713251', 'WIDAYAT (FARM SALUT  C & CA)', 0, 0, '', '2014', '-', '-', 0, '', '', '2020-02-28 15:57:37', 1),
	(58, 1, 3, 'SS4465C', 'TOYOTA', 'LITE ACE WINDOW VAN', '5K-9048892', 'KM36-9020352', 'JIMMY (FARM)', 0, 0, '', '1991', '-', '-', 0, '', '', '2020-02-28 16:01:46', 1),
	(59, 1, 2, 'SA4510T', '', '', '', '', '', 0, 0, '', '', '', '', 0, '', '', '2020-02-28 16:02:37', 1),
	(60, 1, 3, 'SAA4832X', 'KIA', 'PREGIO', 'J2-3G2207', 'KNHTR731247139650', 'HAZLAN', 0, 0, '', '2003', '-', '-', 0, 'Angkat budak sekolah', '', '2020-02-28 16:05:57', 1),
	(61, 1, 0, 'BLH5494', 'TOYOTA', '62-8FD25', '1DZ0223590', '608FD25-35279', 'KILANG POTONG', 0, 0, '', '2011', '-', '-', 0, '', '', '2020-02-28 16:11:44', 1),
	(62, 1, 3, 'SA5010M', 'TOYOTA', 'LH113R-RRMS HIACE WINDOW VAN', '3L-2776717', 'LH113-8002764', 'DAIM GANIS', 0, 0, '', '1991', '-', '-', 0, '', '', '2020-02-28 16:13:32', 1),
	(63, 1, 2, 'SA5369M', 'TOYOTA', 'LY50 HIACE PICK UP', '2L-1977857', 'LY50-0020390', 'HUMPHERY @ AH FUI', 2850, 1590, '', '1989', '-', '1260', 0, 'Lori ada di IISB Timbok Farm exchange with ST1311B (Peter Wong-Ulu Kimanis)', '', '2020-02-28 16:18:57', 1),
	(64, 1, 3, 'SA5755Y', 'FORD', 'UT2G FM1 COURIER CREW CAB', 'WL173584', 'SZCWYC24456', 'HIEW KIM SING', 0, 0, '', '2000', '-', '-', 0, '', '', '2020-02-28 16:22:32', 1),
	(65, 1, 3, 'SAB5935J', 'ISUZU', 'TFR54HD1', '4JA1-186621', 'JAATFR54HB7111066', 'JIMMY KOH', 0, 0, '', '2012', '-', '-', 0, 'Repair cost under IISB', '', '2020-02-28 16:24:37', 1),
	(66, 1, 2, 'SAA6173T', 'ISUZU', 'NPR66 (RB/AA/P-MOD)', '4HF1-171419', 'NPR66P-7400126', 'SAFARINA (SALUT AB)', 5000, 2780, '', '2008', '-', '-', 2220, '', '', '2020-02-28 16:27:59', 1),
	(67, 1, 3, 'SA6383A', 'TOYOTA', 'CROWN', '2L-3229609', 'LS110-000219', 'STANDBY ADMIN', 0, 0, '', '1979', '-', '-', 0, '', '', '2020-02-28 16:29:45', 1),
	(68, 1, 0, 'SS7166V', 'HITACHI', 'ZX33U-5A', 'N7215', 'HCMADB90H00032497', 'FARM PENIANG', 0, 0, '', '2014', 'ORIX CREDIT (M) SDN BHD', '-', 0, '', '', '2020-02-28 16:40:21', 1),
	(69, 1, 2, 'ST7999D', 'TOYOTA', 'LY100R-0001703', '2L-9296849', 'LY100-0001703', 'CHAI KIN FATT', 2400, 1530, '', '1995', '-', '-', 870, 'Parking di workshop', '', '2020-02-28 16:54:38', 1),
	(70, 1, 0, 'SAB7033M', 'TOYOTA', '7FBR18-50352', 'RC02804', '7FBR18-50352', 'STOR EP', 0, 0, '', '2012', '-', '', 0, '', '', '2020-02-28 16:57:20', 1),
	(71, 1, 3, 'SA8201T', 'ISUZU', 'TFR54H', '4JA1-280062', 'JAATFR54HT7110199', 'ANTON ABDUL RAHMAN', 0, 0, '', '1996', '-', '-', 0, '', '', '2020-02-28 17:02:22', 1),
	(72, 1, 2, 'ST8225D', 'TOYOTA', 'L/TRUCK', '3L-3133862', 'LY100-0001811', 'AIDIL', 2400, 1670, '', '1995', '-', '-', 730, '', '', '2020-02-28 17:05:53', 1),
	(73, 1, 2, 'SA8393H', 'TOYOTA', 'LIGHT TRUCK', '2L-3654993', 'LH80-0015855', 'HENDRY GABRIEL', 2400, 1530, '', '', '-', '-', 870, '', '', '2020-02-28 17:10:45', 1),
	(74, 1, 3, 'SS8700N', 'TOYOTA', 'HDJ101 LAND CRUISER', '1HD-0195627', 'HDJ101-0019087', 'WONG HUE SUAN', 0, 0, '', '1998', '', '-', 0, '', '', '2020-02-28 17:13:38', 1),
	(75, 1, 3, 'SB8885C', 'AUDI', 'Q7', 'CCF008225', 'WAUZZZ4L0DD004079', 'WONG KOK PING', 0, 0, '', '2012', '-', '-', 0, '', '', '2020-02-28 17:18:28', 1),
	(76, 1, 2, 'SAA8935H', 'DAIHATSU', 'DELTA V58R-HS', 'DL652647', 'V58B63411', '-', 4500, 2580, '', '2004', '-', '-', 1920, '', '', '2020-02-28 17:20:40', 1),
	(77, 1, 3, 'SAB8935J', 'ISUZU', 'TFR54HD1', '4JA1-182601', 'JAATFR54HB7111018', '-', 0, 0, '', '2012', '-', '-', 0, '', '', '2020-02-28 17:24:32', 1),
	(78, 1, 3, 'ST8920C', 'TOYOTA', 'HIACE W/VAN', '2L-2230970', 'LH113-8002483', 'TUDIKI', 0, 0, '', '1991', '', '-', 0, 'Angkat budak sekolah', '', '2020-02-29 11:28:07', 1),
	(79, 0, 0, 'SA935T', '', '', '', '', '', 0, 0, '', '', '', '', 0, '', '', '2020-02-29 11:29:54', 1),
	(80, 1, 2, 'SA935T', 'ISUZU', 'NHR55E', '4JB1-244178', 'JAANHR55EP7108628', 'HJ. KURONG', 2500, 1750, '', '1996', '-', '-', 750, '', '', '2020-02-29 11:34:34', 1),
	(81, 1, 3, 'SAA935A', 'TOYOTA', 'LN166 HILUX DOUBLE CAB 4X4', '3L-4992399', 'LN166-0048879', 'WILLIAM CHONG', 0, 0, '', '2000', '-', '-', 0, '', '', '2020-02-29 11:36:42', 1),
	(82, 1, 3, 'SAA935F', 'TOYOTA', 'HILUX DOUBLE CAB (M)', '2KD-9150794', '2KDN165-0024437', 'HENDRY GABRIEL', 0, 0, '', '2003', '-', '-', 0, '', '', '2020-02-29 11:39:01', 1),
	(83, 1, 3, 'SAA935J', 'TOYOTA', 'HILUX DOUBLE CAB 2.5L', '2KD-9378113', 'PN133JV2508000175', 'CHEE YUN CHOI @ AH CHI', 0, 0, '', '2005', '', '-', 0, 'Contract farm at Kota Belud', '', '2020-02-29 11:41:24', 1),
	(84, 1, 1, 'SAB935B', 'HONDA', 'C100', 'HA13E-4077378', 'PMKHA13209B077542', 'RIDWAN', 0, 0, '', '2009', '', '-', 0, 'Office boy', '', '2020-02-29 11:44:26', 1),
	(85, 1, 3, 'SD9935L', 'ISUZU', 'UCS86GFT001681', '4JK1NG3207', 'MPAUCS86GFT001681', 'LING HENG CHIONG', 0, 0, '', '2015', 'PUBLIC BANK BERHAD', '-', 0, '', '', '2020-02-29 11:46:58', 1),
	(86, 1, 3, 'SAA9935T', 'TOYOTA', 'HILUX DOUBLE CAB 2.5 AT', '1JZ-6071842', 'PN133JV2508510015', 'JAPAR KURONG', 0, 0, '', '2008', '-', '-', 0, 'Repair cost under IISB', '', '2020-02-29 11:51:41', 1),
	(87, 1, 3, 'SAB9935P', 'TOYOTA', 'HILUX DOUBLE CAB 2.5', '2KDU31751', 'PN133JV2508277532', 'ANDY CHONG', 0, 0, '', '2013', '', '-', 0, '', '', '2020-02-29 11:53:31', 1),
	(88, 3, 0, 'SAC351B', 'TOYOTA', '62-8FD30', '1DZ0317595', '608FDJ35-64089', 'FEEDMILL', 0, 0, '', '2015', 'ORIX CREDIT (M) SDN BHD', '-', 0, '', '', '2020-02-29 11:56:20', 1),
	(89, 3, 0, 'SAC349B', 'TOYOTA', '62-8FD30', '1DZ0314510', '608FDJ35-63348', 'FEEDMILL', 0, 0, '', '2015', 'ORIX CREDIT (M) SDN BHD', '-', 0, '', '', '2020-02-29 11:58:33', 1),
	(90, 3, 0, 'SAC348B', 'TOYOTA', '62-8FD30', '1DZ0316897', '608FDJ35-64038', 'FEEDMILL', 0, 0, '', '2015', 'ORIX CREDIT (M) SDN BHD', '-', 0, '', '', '2020-02-29 12:00:50', 1),
	(91, 0, 0, 'WDK528', '', '', '', '', '', 0, 0, '', '', '', '', 0, 'Lorry is currently active but not sure which farm used this lorry ', '', '2020-02-29 12:02:47', 1),
	(92, 3, 3, 'SB618A', 'TOYOTA', 'HZJ80R-GCPNS', '1HZ-0210036', 'HZJ80-0032474', 'DR. SAFIUL', 0, 0, '', '1997', '-', '-', 0, 'Repair cost under IISB', '', '2020-02-29 12:05:37', 1),
	(93, 3, 3, 'ST6322J', 'HYUNDAI', 'ACCENT 1.5L', 'G4EB3706786', 'MHC03G706755', 'STANDBY ADMIN', 0, 0, '', '2005', '-', '-', 0, '', '', '2020-02-29 12:07:48', 1),
	(94, 3, 3, 'SAA6668G', 'TOYOTA', 'KG-HDJ101K LAND CRUISER', '1HD-0260409', 'HDJ101-0026518', 'WONG WAH PENG', 0, 0, '', '2004', '-', '-', 0, '', '', '2020-02-29 12:10:32', 1),
	(95, 3, 3, 'SAB9706A', 'ISUZU', 'TFS85HD1', '4JJ1-GV4211', 'JAATFS85H77106338', 'ALEX LO', 0, 0, '', '2010', '', '-', 0, 'Mr. Wong brother in-law', '', '2020-02-29 12:13:33', 1),
	(96, 3, 3, 'SA9855N', 'TOYOTA', 'L/CRUISER HDJ81', '1HD-001894', 'HDJ81-0000489', 'WORKSHOP (ARTHUR)', 0, 0, '', '1991', '', '-', 0, '', '', '2020-02-29 12:16:18', 1),
	(97, 3, 3, 'SAA9935E', 'TOYOTA', 'HILUX DOUBLE CAB (M)', '2L1982576', 'KDN165-0022803', 'WORKSHOP PDU', 0, 0, '', '2003', '', '-', 0, 'Breakdown', '', '2020-02-29 12:18:17', 1),
	(98, 3, 3, 'SM9935', 'TOYOTA', 'FORTUNER 2.4 AT 4X2', '2GD0491387', 'PN1GB3GS302400124', 'ANTHONY ASTRAL', 0, 0, '', '2018', '', '-', 0, 'Feedmill manager', '', '2020-02-29 12:20:34', 1),
	(99, 3, 3, 'SA6288X', 'TOYOTA', 'LAND CRUISER PICK UP', '1HZ-0302846', 'HZJ75-0054077', '', 0, 0, '', '1999', '', '-', 0, 'Not sure if this lorry currently is active or not', '', '2020-02-29 12:27:43', 1),
	(100, 3, 3, 'SA6315U', '1997', 'INVADER CREW CAB', '4JB1T-288062', 'JAATFS55HT7101054', '', 0, 0, '', '1997', '-', '-', 0, 'Not sure if this lorry currently is active or not', '', '2020-02-29 12:30:05', 1),
	(101, 3, 2, 'SA3879L', 'DAIHATSU', 'DELTA V57A', 'DL51-532738', 'V57A-75240', '', 2500, 1770, '', '1991', '', '-', 730, 'Not sure if this lorry currently is active or not', '', '2020-02-29 12:32:24', 1),
	(102, 3, 3, 'SS4299C', '1991', 'NISSAN', 'TD27-456305', 'VJGE24-A00799', '', 2500, 1640, '', '1990', '-', '-', 860, 'Not sure if this lorry currently is active or not', '', '2020-02-29 12:34:39', 1),
	(103, 3, 3, 'SA6315U', 'ISUZU', 'INVADER CREW CAB', '4JB1T-288062', 'JAATFS55HT7101054', '', 0, 0, '', '1997', '-', '-', 0, 'Not sure if this lorry currently is active or not', '', '2020-02-29 12:36:16', 1),
	(104, 3, 2, 'SS1606E', 'FORD', 'PICK-UP', '644218', 'SZMWTY-83654', '', 2450, 1120, '', '1996', '-', '-', 1330, 'Not sure if this lorry currently is active or not', '', '2020-02-29 12:38:24', 1),
	(105, 8, 1, 'SU1280B', 'YAMAHA', 'EGO S', 'E3A8EE046805', 'PMYKE108090046805', 'ROY (LOGISTICS)', 0, 0, '', '2009', '-', '-', 0, '', '', '2020-03-03 10:41:30', 1),
	(106, 8, 2, 'SA1450L', 'ISUZU', 'NPR596', '4BE1-289362', '7103398', 'WORKSHOP PDU', 7000, 3530, '', '1990', '-', '-', 3470, '', '', '2020-03-03 10:48:31', 1),
	(107, 8, 2, 'WVT1605', 'ISUZU', 'NKR55UEE', '4JB1110313', 'JAANNKR55EA7108899', 'LOGISTICS STANDBY LORRY', 4500, 2600, '', '2011', '-', '-', 1900, '', '', '2020-03-03 10:52:48', 1),
	(108, 8, 2, 'SAA1676L', 'TUAH', 'KM188 HFC1048KL', 'CY4102BZL005077542', 'PMMTH381040500161', '', 5000, 2560, '', '2005', '', '', 2440, 'Not sure if this lorry currently is active or not', '', '2020-03-03 11:07:39', 1),
	(109, 8, 2, 'QAV1766', 'ISUZU', 'NKR66 (RB/NEK N01)', '4HF1601362', 'NKR66E-7532984', 'SOON SHUEN VUI', 5000, 2910, '', '2010', '-', '-', 2090, '', '', '2020-03-03 11:21:55', 1),
	(110, 8, 2, 'SAB1935K', 'HINO', 'XZU423R-HKMRD3', 'N04CTT26288', 'JHFYT20H807002085', 'RAMLI', 8300, 3660, '', '2011', '-', '-', 0, '', '', '2020-03-03 11:50:16', 1),
	(111, 8, 2, 'SAA1935U', 'TOYOTA', 'XZU 412 (RB/FP BD1)', 'S05CA13801', 'XZU412-0001336', 'RAHIM KURONG', 7000, 3420, '', '2007', '-', '-', 3580, '', '', '2020-03-03 16:14:08', 1),
	(112, 6, 2, 'SB8366', 'NISSAN', 'CM87KA C/W BASIN', 'FE6-017518B', 'CM87KA-07274', 'WALTER EDIP', 9950, 4510, '', '1993', '-', '-', 5440, '', '', '2020-03-04 14:46:14', 1),
	(113, 19, 3, 'SK7223', 'TOYOTA', 'TOYOTA HILUX DOUBLE CAB ', '2KD6146121', 'PN133JV2508016215', 'LO CHEE LEONG', 0, 0, '', '2008', '', '-', 0, '', '', '2020-03-04 15:17:32', 1),
	(114, 8, 2, 'SAB6935K', 'NISSAN', 'CD45C (RB/AA VM1)', 'PF6-307412B', 'CD45CV-11667', 'MANSUR LADJAMA', 21000, 11580, '', '2012', '-', '-', 9420, '', '', '2020-03-04 15:56:18', 1),
	(115, 8, 2, 'SAA1223B', 'HICOM', 'HICOM PERKASA 150DX', '4HF17858302', 'PML60CL2R1P003368', 'JOSEPH A/L DUYA', 5000, 3510, '', '2001', '-', '-', 1490, '', '', '2020-03-04 16:04:06', 1),
	(116, 6, 2, 'SAA9935K', 'NISSAN ', 'NU41H5', 'FD46-025184', 'NU41H5-051256', 'JEFFRY P.RATU ARAN', 7500, 3470, '', '2004', '-', '-', 4030, '', '', '2020-03-04 16:19:57', 1),
	(117, 8, 2, 'SA3937M', 'NISSAN ', 'CPB15N', 'NE6-010893T', 'CPB15N-01757', 'ALIMUDDIN BIN LAPAWELA', 16000, 7800, '', '1991', '-', '-', 8200, '', '', '2020-03-04 16:32:15', 1),
	(118, 8, 2, 'SAA2335A', 'DAIHATSU', 'DELTA V58R', '638544', 'V58B53376', 'Standby driver (Logistics)', 4500, 2200, '', '2000', '-', '-', 2300, '', '', '2020-03-05 13:30:25', 1),
	(119, 8, 2, 'JGK2378', 'DAIH', 'DELTA V116-HA', '', '', '', 0, 0, '', '2002', '', '', 0, '', '', '2020-03-05 13:33:24', 0),
	(120, 8, 2, 'JGK2378', 'DAIHATSU', 'DELTA V116-HA', '1686099', 'JDA00V11600097426', 'Standby driver (Logistics)', 5000, 2770, '', '2002', '-', '-', 2230, '', '', '2020-03-05 13:37:32', 1),
	(121, 8, 2, 'SAA2674T', 'SERI ZENITH ENG.SDN.BHD', 'SZESTR-40', '-', 'E7STR20251', 'Standby Trailer', 32000, 3920, '', '2007', '-', '-', 28080, '', '', '2020-03-05 13:43:36', 1),
	(122, 8, 2, 'SAA2935U', 'NISSAN', 'CD53 (RB/AA VM)', 'RG8-102482', 'CD53BVF-00002', 'JAINAL BIN BIDIN', 21000, 12120, '', '2008', '-', '-', 8880, '', '', '2020-03-05 13:48:29', 1),
	(123, 8, 2, 'SAB2935L', 'HINO', 'XZU423R-HKMRD3', '', 'JHFYT20H107002087', 'MEDI', 8300, 4160, '', '2011', 'ORIX CREDIT MALAYSIA SDN BHD', '-', 4140, '', '', '2020-03-05 14:01:35', 1),
	(124, 8, 2, 'SAA3150A', 'HICOM', 'PERKASA MTB150DX', '736298', 'PML60CL2R1P002451', 'RAHIM', 5000, 3510, '', '2000', '-', '-', 1490, '', '', '2020-03-05 14:21:36', 1),
	(125, 8, 2, 'SA3286W', 'NISSAN', 'CPB15NE', 'FE6-202962C', 'CPB15NE-01172', 'JIROM BIN RIMPUN', 16000, 7460, '', '1997', '-', '-', 8540, '', '', '2020-03-05 14:25:55', 1),
	(126, 8, 2, 'ST3453E', 'ISUZU', 'NHR 55 E', '4JB1-339260', 'JAANHR55E', 'IMPIAN SEWA-HATCHERY', 4100, 2160, '', '1997', '-', '-', 1940, '', '', '2020-03-05 14:33:31', 1),
	(127, 8, 2, 'SA389H', 'ISUZU', 'TRUCK', '4BD1-100720', '4622836', 'STANDBY LOGISTIC', 7000, 3250, '', '1986', '-', '-', 3750, '', '', '2020-03-05 14:53:44', 1),
	(128, 8, 2, 'SAA3935U', 'NISSAN', 'CD45 (RB/AA VM1)', 'PF6-404338B', 'CD45CV-21336', 'MUHIDIN BIN HARIS', 21000, 10050, '', '2008', '', '-', 10559, '', '', '2020-03-05 14:57:41', 1),
	(129, 8, 2, 'SAB3935J', 'HINO', 'XZU423R-HKMRD3 (UBS)', 'N04CTT24999', 'JHFYT20H307001846', 'SUHAIMI', 8300, 3880, '', '2011', 'ORIX CREDIT MALAYSIA SDN BHD', '-', 4420, '', '', '2020-03-05 15:03:52', 1),
	(130, 8, 2, 'SAB3935K', 'NISSAN', 'CWM272 (RB/AA)', 'MD92-505433B', 'CWM272HT-00001', 'MASRAN BIN LANABA', 21000, 9550, '', '2012', 'ORIX CREDIT MALAYSIA SDN BHD', '', 11450, '', '', '2020-03-05 15:08:04', 1),
	(131, 8, 2, 'SAA3980J', 'ISUZU', 'NKR66L (RB/AA)', '4HF1-138945', 'NKR66L-7100696', 'VITALIS', 5000, 3610, '', '2005', '-', '-', 1390, '', '', '2020-03-05 15:13:39', 1),
	(132, 8, 2, 'SAB3685W', 'HINO', 'WU720R-HKMQL3', 'W04DTN31366', 'JHHYJL1H101911211', 'JEFRIN GANIS', 5000, 3430, '', '2014', 'ORIX CREDIT MALAYSIA SDN BHD', '-', 1570, '', '', '2020-03-05 15:17:34', 1),
	(133, 8, 2, 'SAB4135K', 'HINO', 'WU300R-HBLMS3', 'W04DJ48914', 'JHFAF04H206005920', 'REAY DEONT', 4800, 2870, '', '2011', '-', '-', 1930, '', '', '2020-03-05 15:22:09', 1),
	(134, 8, 2, 'SU4596A', 'ISUZU', 'NPR71L CHASSIS CAB', '4HG1469233', 'NPR71L-7413527', 'STANDBY DRIVER (LOGISTICS)', 5000, 3420, '', '2004', '-', '-', 1580, '', '', '2020-03-05 15:26:25', 1),
	(135, 8, 2, 'SA5073M', 'ISUZU', 'NPR596-03A TRUCK', '4BD1-121102', '7101767', 'STANDBY DRIVER (LOGISTICS)', 7000, 3150, '', '1991', '', '', 3850, '', '', '2020-03-05 15:29:29', 1),
	(136, 8, 2, 'SS5166D', 'ISUZU', 'NHR55E PICK UP', '986137', 'JAANHR55EP', 'FOO SIU VAN', 4100, 2100, '', '1995', '-', '-', 2000, '', '', '2020-03-05 16:51:56', 1),
	(137, 8, 2, 'SAA5279F', 'DAIHATSU', 'DELTA V116-HA CHASSIS CAB', '14B1731184', 'JDA00V11600A01280', 'RAHIM KURONG', 5000, 2820, '', '2003', '-', '-', 2180, '', '', '2020-03-05 16:55:11', 1),
	(138, 8, 2, 'SAC5408C', 'NISSAN', 'MK211 (RB/BC 053)', 'FE6-117684E', 'MK211K-13034', 'IBNU PORING', 12000, 5170, '', '2016', '-', '-', 6830, '', '', '2020-03-05 17:01:40', 1),
	(139, 8, 3, 'SA5863M', 'DAIHATSU', 'DELTA V57A', '568572', 'V57A-80939', 'FARM TOPOKON', 2500, 1890, '', '1992', '-', '-', 610, '', '', '2020-03-05 17:05:07', 1),
	(140, 8, 2, 'SAB5935A', 'NISSAN', 'CD53 (RB/EMS V)', 'RG8-200390', 'CD53CW-20065', 'MOHD NAWI', 21000, 11770, '', '2009', 'ORIX CREDIT MALAYSIA SDN BHD', '-', 9230, '', '', '2020-03-05 17:08:43', 1),
	(141, 8, 2, 'SAB5935F', 'HINO', 'XZU423R-HKMRD3', 'NO4CTT24181', 'JHFYT20H507001699', 'ZUNIDY', 8300, 3990, '', '2011', 'ORIX CREDIT MALAYSIA SDN BHD', '-', 4310, '', '', '2020-03-05 17:14:07', 1),
	(142, 8, 2, 'SAB5935K', 'NISSAN', 'CD45 (RB/AA VM1)', 'PF6-307444C', 'CD45CV-11692', 'MADRA BIN ARIS', 21000, 11540, '', '2012', 'ORIX CREDIT MALAYSIA SDN BHD', '-', 9460, '', '', '2020-03-05 17:18:17', 1);
/*!40000 ALTER TABLE `vehicle_vehicle` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
