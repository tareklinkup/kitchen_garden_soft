-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2019 at 06:08 AM
-- Server version: 10.1.37-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ronix0lion_soft`
--

-- --------------------------------------------------------

--
-- Table structure for table `genaral_customer_info`
--

CREATE TABLE `genaral_customer_info` (
  `G_SiNo` int(11) NOT NULL,
  `G_Name` varchar(50) DEFAULT NULL,
  `G_Mobile` varchar(15) DEFAULT NULL,
  `G_Address` varchar(200) DEFAULT NULL,
  `G_Sale_Mastar_SiNO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genaral_customer_info`
--

INSERT INTO `genaral_customer_info` (`G_SiNo`, `G_Name`, `G_Mobile`, `G_Address`, `G_Sale_Mastar_SiNO`) VALUES
(1, 'General Customer', '', '', 3),
(2, 'General Customer', '', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `genaral_supplier_info`
--

CREATE TABLE `genaral_supplier_info` (
  `supplier_sl_no` int(11) NOT NULL,
  `S_Name` varchar(50) DEFAULT NULL,
  `S_Mobile` varchar(30) DEFAULT NULL,
  `S_Address` varchar(150) DEFAULT NULL,
  `S_Purchase_Mastar_SiNO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sr_transferdetails`
--

CREATE TABLE `sr_transferdetails` (
  `TransferDetails_SiNo` int(11) NOT NULL,
  `TransferMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `TransferDetails_TotalQuantity` varchar(20) NOT NULL,
  `TransferDetails_unit` varchar(20) NOT NULL,
  `Brunch_from` int(2) NOT NULL,
  `Brunch_to` int(2) NOT NULL,
  `fld_status` char(1) NOT NULL DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sr_transfermaster`
--

CREATE TABLE `sr_transfermaster` (
  `TransferMaster_SiNo` int(11) NOT NULL,
  `TransferMaster_InvoiceNo` varchar(10) NOT NULL,
  `TransferMaster_Transferfrom` int(2) DEFAULT NULL,
  `TransferMaster_Transferto` int(2) NOT NULL,
  `TransferMaster_Date` date NOT NULL,
  `TransferMaster_Description` longtext,
  `Status` char(1) NOT NULL DEFAULT 'p',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `Acc_SlNo` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `Acc_Code` varchar(50) NOT NULL,
  `Acc_Tr_Type` varchar(25) DEFAULT NULL,
  `Acc_Name` varchar(200) NOT NULL,
  `Acc_Type` varchar(50) NOT NULL,
  `Acc_Description` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`Acc_SlNo`, `branch_id`, `Acc_Code`, `Acc_Tr_Type`, `Acc_Name`, `Acc_Type`, `Acc_Description`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 3, 'A1000', '', 'Advance Godown Rent', 'Official', 'Advance Godown Rent', 'a', 'Admin', '2019-03-06 06:39:11', 'Admin', '2019-03-06 06:45:21'),
(2, 3, 'A1001', '', 'Godown Rent', 'Official', 'Godown Rent', 'a', 'Admin', '2019-03-06 06:39:31', 'Admin', '2019-03-06 06:45:41'),
(3, 3, 'A1002', '', 'Labor  ', 'Official', '', 'd', 'Admin', '2019-03-06 06:39:58', 'Admin', '2019-03-06 06:40:57'),
(4, 3, 'A1003', '', 'Security Gourd', 'Official', '', 'd', 'Admin', '2019-03-06 06:40:27', NULL, NULL),
(5, 3, 'A1004', '', 'Labour, Transport', 'Official', 'Labour, Transport', 'a', 'Admin', '2019-03-06 06:41:48', 'Admin', '2019-03-06 06:46:32'),
(6, 3, 'A1005', '', 'Salary, Bonus', 'Official', 'Salary, Bonus', 'a', 'Admin', '2019-03-06 06:43:48', 'Admin', '2019-03-06 06:48:49'),
(7, 3, 'A1006', '', 'Discount', 'Official', 'Discount', 'a', 'Admin', '2019-03-06 06:44:36', 'Admin', '2019-03-06 06:49:03'),
(8, 3, 'A1007', '', 'Comission', 'Official', 'Comission', 'a', 'Admin', '2019-03-06 06:44:55', 'Admin', '2019-03-06 06:49:15'),
(9, 3, 'A1008', '', 'Bank Interest', 'Official', 'Bank Interest', 'a', 'Admin', '2019-03-06 06:50:50', 'Admin', '2019-03-06 06:51:01'),
(10, 3, 'A1009', '', 'Samity daily basis', 'Official', 'Samity daily basis', 'a', 'Admin', '2019-03-06 06:52:05', NULL, NULL),
(11, 3, 'A1010', '', 'Capital Account.', 'Official', 'Capital Account.', 'a', 'Admin', '2019-03-06 06:57:37', NULL, NULL),
(12, 3, 'A1011', '', 'Loan Account.', 'Official', 'Loan Account.', 'a', 'Admin', '2019-03-06 06:58:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assets`
--

CREATE TABLE `tbl_assets` (
  `as_id` int(11) NOT NULL,
  `as_date` date DEFAULT NULL,
  `as_name` varchar(50) DEFAULT NULL,
  `as_qty` int(11) DEFAULT NULL,
  `as_rate` decimal(10,2) DEFAULT NULL,
  `as_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `Bank_SiNo` int(11) NOT NULL,
  `Bank_name` varchar(100) NOT NULL,
  `Branch` varchar(100) NOT NULL,
  `Account_Title` varchar(100) NOT NULL,
  `Account_No` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`Bank_SiNo`, `Bank_name`, `Branch`, `Account_Title`, `Account_No`, `status`) VALUES
(1, 'Al-Arafah Islami Bank Ltd.', '3', '', '', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill_entry`
--

CREATE TABLE `tbl_bill_entry` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `exp_head` tinyint(4) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `remarks` text,
  `status` enum('a','d') DEFAULT 'a',
  `addby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_SiNo` int(11) NOT NULL,
  `ProductCategory_SlNo` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `status` char(2) NOT NULL,
  `brand_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_SiNo`, `ProductCategory_SlNo`, `brand_name`, `status`, `brand_branchid`) VALUES
(1, 0, 'Lion ', 'a', 1),
(2, 0, 'R and D ', 'a', 1),
(3, 0, 'Dong', 'a', 3),
(4, 0, 'H/W', 'a', 3),
(5, 0, 'Ken', 'a', 3),
(6, 0, 'Megh', 'a', 3),
(7, 0, 'Jaf', 'a', 3),
(8, 0, 'H.M', 'a', 3),
(9, 0, 'A.R', 'a', 3),
(10, 0, 'Afs', 'a', 3),
(11, 0, 'Hus', 'a', 3),
(12, 0, 'Mabud', 'a', 3),
(13, 0, 'Kano', 'a', 3),
(14, 0, 'Amtech', 'a', 3),
(15, 0, 'Fukung', 'a', 3),
(16, 0, 'Yamato', 'a', 3),
(17, 0, 'Wim', 'a', 3),
(18, 0, 'Tanaka', 'a', 3),
(19, 0, 'Richu', 'a', 3),
(20, 0, 'Murex', 'a', 3),
(21, 0, 'Ridgid', 'a', 3),
(22, 0, 'Weldro', 'a', 3),
(23, 0, 'Sander', 'a', 3),
(24, 0, 'Others', 'a', 3),
(25, 0, 'DCA', 'a', 3),
(26, 0, 'Unison', 'a', 3),
(27, 0, 'OP', 'a', 3),
(28, 0, 'Horse', 'a', 3),
(29, 0, 'AIWA', 'a', 3),
(30, 0, 'Boky', 'a', 3),
(31, 0, 'Yokohama', 'a', 3),
(32, 0, 'Morris', 'a', 3),
(33, 0, 'Deson', 'a', 3),
(34, 0, 'Revo', 'a', 3),
(35, 0, 'Runner', 'a', 3),
(36, 0, 'STL', 'a', 3),
(37, 0, 'Dass', 'a', 3),
(38, 0, 'Red Horse', 'a', 3),
(39, 0, 'pipe', 'a', 3),
(40, 0, 'Nokia', 'a', 3),
(41, 0, 'Excel', 'a', 3),
(42, 0, 'Dragon', 'a', 3),
(43, 0, 'Langya', 'a', 3),
(44, 0, 'Osaka', 'a', 3),
(45, 0, 'Teka', 'a', 3),
(46, 0, 'Mira', 'a', 3),
(47, 0, 'Kyoto', 'a', 3),
(48, 0, 'Kawasaki', 'a', 3),
(49, 0, 'aaa', 'a', 2),
(50, 0, 'Sky High', 'a', 3),
(51, 0, 'SME', 'a', 3),
(52, 0, 'Silver Isuzu', 'a', 3),
(53, 0, 'Local', 'a', 3),
(54, 0, 'Aluminium', 'a', 3),
(55, 0, 'Orient', 'a', 3),
(56, 0, 'Koshan', 'a', 3),
(57, 0, 'Diamond', 'a', 3),
(58, 0, 'Mosay', 'a', 3),
(59, 0, 'Prince', 'a', 3),
(60, 0, 'Kaifeng', 'a', 3),
(61, 0, 'YETR', 'a', 3),
(62, 0, 'Ronix', 'a', 3),
(63, 0, 'Taiwan', 'a', 3),
(64, 0, 'Kings', 'a', 3),
(65, 0, 'Red Arrow', 'a', 3),
(66, 0, 'R.A-170', 'd', 3),
(67, 0, 'Kapro', 'a', 3),
(68, 0, 'HAWK', 'a', 3),
(69, 0, 'Wido', 'a', 3),
(70, 0, 'China', 'a', 3),
(71, 0, 'Pech', 'a', 3),
(72, 0, '-', 'a', 3),
(73, 0, 'Insize', 'a', 3),
(74, 0, 'HMBR', 'a', 3),
(75, 0, 'Poland', 'a', 3),
(76, 0, 'Super', 'a', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brunch`
--

CREATE TABLE `tbl_brunch` (
  `brunch_id` int(11) NOT NULL,
  `Brunch_name` varchar(250) NOT NULL,
  `Brunch_title` varchar(250) CHARACTER SET utf8mb4 NOT NULL,
  `Brunch_address` text CHARACTER SET utf8mb4 NOT NULL,
  `Brunch_sales` varchar(1) NOT NULL COMMENT 'Wholesales = 1, Retail = 2',
  `add_date` date NOT NULL,
  `add_time` datetime NOT NULL,
  `add_by` char(50) NOT NULL,
  `update_by` char(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_brunch`
--

INSERT INTO `tbl_brunch` (`brunch_id`, `Brunch_name`, `Brunch_title`, `Brunch_address`, `Brunch_sales`, `add_date`, `add_time`, `add_by`, `update_by`, `status`) VALUES
(1, 'Lion Welding', 'Lion Welding', '95/1, Rahima Plaza,(1st Floor) Nawabpur Road,Dhaka', '2', '0000-00-00', '0000-00-00 00:00:00', '', '', 'a'),
(2, 'Ronix Tools ', '95/1, Rahima Plaza ,Nawabpur Road,Dhaka-1100', '95/1, Rahima Plaza(1st Floor) ,Nawabpur Road,Dhaka-1100', '2', '0000-00-00', '0000-00-00 00:00:00', '', '', 'a'),
(3, 'New Shovo Hardware and Tools', '95/1, Rahima Plaza(1st Floor), Nawabpur Road,Dhaka', '95/1, Rahima Plaza(1st Floor), Nawabpur Road,Dhaka', '2', '0000-00-00', '0000-00-00 00:00:00', '', '', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashregister`
--

CREATE TABLE `tbl_cashregister` (
  `Transaction_ID` int(11) NOT NULL,
  `Transaction_Date` varchar(20) NOT NULL,
  `IdentityNo` varchar(50) DEFAULT NULL,
  `Narration` varchar(100) NOT NULL,
  `InAmount` decimal(18,2) NOT NULL,
  `OutAmount` decimal(18,2) NOT NULL,
  `Description` longtext NOT NULL,
  `Status` char(1) DEFAULT NULL,
  `Saved_By` varchar(50) DEFAULT NULL,
  `Saved_Time` datetime DEFAULT NULL,
  `Edited_By` varchar(50) DEFAULT NULL,
  `Edited_Time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashtransaction`
--

CREATE TABLE `tbl_cashtransaction` (
  `Tr_SlNo` int(11) NOT NULL,
  `Tr_Id` varchar(50) NOT NULL,
  `Tr_date` date NOT NULL,
  `Tr_Type` varchar(20) NOT NULL,
  `Tr_account_Type` varchar(50) NOT NULL,
  `Supplier_SlID` int(11) NOT NULL,
  `Customer_SlID` int(11) NOT NULL,
  `Acc_SlID` int(11) NOT NULL,
  `Acc_Code` varchar(50) DEFAULT NULL,
  `Tr_Description` varchar(255) NOT NULL,
  `In_Amount` decimal(18,2) NOT NULL,
  `Out_Amount` decimal(18,2) NOT NULL,
  `ChequeNumber` int(16) NOT NULL,
  `Tr_Bank_Id` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(100) NOT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Tr_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checks`
--

CREATE TABLE `tbl_checks` (
  `id` int(20) UNSIGNED NOT NULL,
  `cus_id` int(20) DEFAULT NULL,
  `SM_id` int(20) UNSIGNED DEFAULT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `check_no` varchar(250) DEFAULT NULL,
  `check_amount` decimal(18,2) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `check_date` timestamp NULL DEFAULT NULL,
  `remid_date` timestamp NULL DEFAULT NULL,
  `sub_date` timestamp NULL DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `check_status` char(5) DEFAULT 'Pe' COMMENT 'Pe =Pending, Pa = Paid',
  `status` char(5) NOT NULL DEFAULT 'a',
  `created_by` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `branch_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_color`
--

CREATE TABLE `tbl_color` (
  `color_SiNo` int(11) NOT NULL,
  `color_name` varchar(100) NOT NULL,
  `status` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

CREATE TABLE `tbl_company` (
  `Company_SlNo` int(11) NOT NULL,
  `Company_Name` varchar(150) NOT NULL,
  `Repot_Heading` text NOT NULL,
  `Company_Logo_org` varchar(250) NOT NULL,
  `Company_Logo_thum` varchar(250) NOT NULL,
  `Invoice_Type` int(11) NOT NULL,
  `Currency_Name` varchar(50) DEFAULT NULL,
  `Currency_Symbol` varchar(10) DEFAULT NULL,
  `SubCurrency_Name` varchar(50) DEFAULT NULL,
  `print_type` int(11) NOT NULL,
  `company_BrunchId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`Company_SlNo`, `Company_Name`, `Repot_Heading`, `Company_Logo_org`, `Company_Logo_thum`, `Invoice_Type`, `Currency_Name`, `Currency_Symbol`, `SubCurrency_Name`, `print_type`, `company_BrunchId`) VALUES
(1, 'Lion Welding', '95/1, Rahima Plaza(1st floor)\r\nNawabpur Road,Dhaka\r\nMobile: 01766541115', 'Shuov_(1)1.jpg', 'Shuov_(1)1.jpg', 1, NULL, NULL, NULL, 2, 1),
(6, 'Ronix Tools ', '', 'RonixTools-11.jpg', 'RonixTools-11.jpg', 0, NULL, NULL, NULL, 2, 2),
(7, 'New Hovo Hardware & Tools ', '', 'shovhhho_copy4.jpg', 'shovhhho_copy4.jpg', 0, NULL, NULL, NULL, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

CREATE TABLE `tbl_country` (
  `Country_SlNo` int(11) NOT NULL,
  `CountryName` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `Customer_SlNo` int(11) NOT NULL,
  `Customer_Code` varchar(50) NOT NULL,
  `Customer_Name` varchar(150) NOT NULL,
  `Customer_Type` varchar(50) NOT NULL,
  `Customer_Phone` varchar(50) NOT NULL,
  `Customer_Mobile` varchar(15) NOT NULL,
  `Customer_Email` varchar(50) NOT NULL,
  `Customer_OfficePhone` varchar(50) NOT NULL,
  `Customer_Address` varchar(300) NOT NULL,
  `Country_SlNo` int(11) NOT NULL,
  `area_ID` int(11) NOT NULL,
  `Customer_Web` varchar(50) NOT NULL,
  `Customer_Credit_Limit` decimal(18,2) NOT NULL,
  `previous_due` decimal(18,2) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Customer_brunchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`Customer_SlNo`, `Customer_Code`, `Customer_Name`, `Customer_Type`, `Customer_Phone`, `Customer_Mobile`, `Customer_Email`, `Customer_OfficePhone`, `Customer_Address`, `Country_SlNo`, `area_ID`, `Customer_Web`, `Customer_Credit_Limit`, `previous_due`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Customer_brunchid`) VALUES
(1, 'C01', 'General Customer', 'G', '', '-', '', '-', '-', 0, 2, '', '0.00', '0.00', 'a', 'Admin', '2018-09-05 05:02:57', NULL, NULL, 0),
(15, 'C02', 'A and J Enterprise ', 'Local', '', '01711388617', '', '01761852513', 'Bazar Road, Barishal ', 0, 12, '', '9999999999999999.99', '110885.00', 'a', 'Admin', '2019-03-06 11:34:52', 'Admin', '2019-03-12 04:06:36', 1),
(16, 'C16', 'Shovo Hardware and Tools.', 'Local', '', '01778006977', '', '029558930', '95/1, Rahima Plaza, Nawabpur Road, Dhaka-1100', 0, 14, '', '0.00', '0.00', 'a', 'Admin', '2019-03-06 04:54:09', 'Admin', '2019-03-06 07:01:13', 3),
(17, 'C17', 'D M Tools and Machineries.', 'Local', '', '01937152522', '', '', '98, Nawabpur Road, Dhaka-1100', 0, 14, '', '0.00', '0.00', 'a', 'Admin', '2019-03-06 04:56:11', 'Admin', '2019-03-06 06:59:30', 3),
(18, 'C18', 'Haq Corporation', 'Local', '', '01716861058', '', '', 'Nawabpur Road, Dhaka-1100', 0, 14, '', '0.00', '0.00', 'a', 'Admin', '2019-03-06 04:57:19', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_payment`
--

CREATE TABLE `tbl_customer_payment` (
  `CPayment_id` int(11) NOT NULL,
  `CPayment_date` date DEFAULT NULL,
  `CPayment_invoice` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_customerID` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_TransactionType` varchar(20) DEFAULT NULL,
  `CPayment_amount` decimal(18,2) DEFAULT NULL,
  `CPayment_Paymentby` varchar(50) DEFAULT NULL,
  `CPayment_notes` varchar(225) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_brunchid` int(11) DEFAULT NULL,
  `CPayment_Addby` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_AddDAte` date DEFAULT NULL,
  `CPayment_status` varchar(1) DEFAULT NULL,
  `CPayment_UpdateDAte` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_customer_payment`
--

INSERT INTO `tbl_customer_payment` (`CPayment_id`, `CPayment_date`, `CPayment_invoice`, `CPayment_customerID`, `CPayment_TransactionType`, `CPayment_amount`, `CPayment_Paymentby`, `CPayment_notes`, `CPayment_brunchid`, `CPayment_Addby`, `CPayment_AddDAte`, `CPayment_status`, `CPayment_UpdateDAte`) VALUES
(3, '2019-03-13', 'CS-001', '1', NULL, '35000.00', NULL, '', 1, 'Admin', NULL, NULL, NULL),
(4, '2019-03-13', 'CS-002', '15', NULL, '35000.00', NULL, '', 1, 'Admin', NULL, NULL, NULL),
(5, '2019-03-13', 'CS-003', '1', NULL, '35000.00', NULL, '', 1, 'Admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damage`
--

CREATE TABLE `tbl_damage` (
  `Damage_SlNo` int(11) NOT NULL,
  `Damage_InvoiceNo` varchar(50) NOT NULL,
  `Damage_Date` date NOT NULL,
  `Damage_Description` varchar(300) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Damage_brunchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damagedetails`
--

CREATE TABLE `tbl_damagedetails` (
  `DamageDetails_SlNo` int(11) NOT NULL,
  `Damage_SlNo` int(11) NOT NULL,
  `Product_SlNo` int(11) NOT NULL,
  `DamageDetails_DamageQuantity` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `Department_SlNo` int(11) NOT NULL,
  `Department_Name` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`Department_SlNo`, `Department_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'Foreign Trade, Administration, Marketing ', 'a', 'Admin', '2019-03-05 06:24:54', NULL, NULL),
(2, 'Sales', 'a', 'Admin', '2019-03-05 06:25:11', NULL, NULL),
(3, 'Conveyor', 'a', 'Admin', '2019-03-05 06:28:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

CREATE TABLE `tbl_designation` (
  `Designation_SlNo` int(11) NOT NULL,
  `Designation_Name` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`Designation_SlNo`, `Designation_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'Manager', 'a', 'Admin', '2019-03-05 06:15:13', NULL, NULL),
(2, 'Warehouse Manager ', 'a', 'Admin', '2019-03-05 06:16:08', NULL, NULL),
(3, 'Employee ', 'a', 'Admin', '2019-03-05 06:16:49', NULL, NULL),
(4, 'Admin ', 'a', 'Admin', '2019-03-05 06:18:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

CREATE TABLE `tbl_district` (
  `District_SlNo` int(11) NOT NULL,
  `District_Name` varchar(50) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_district`
--

INSERT INTO `tbl_district` (`District_SlNo`, `District_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'Nawabpur ', 'a', 'Admin', '2019-03-05 09:47:27', NULL, NULL),
(2, 'Bogura', 'a', 'Admin', '2019-03-05 09:47:34', NULL, NULL),
(3, 'Pabna', 'a', 'Admin', '2019-03-05 09:47:46', NULL, NULL),
(4, 'Tongi ', 'a', 'Admin', '2019-03-05 09:47:52', NULL, NULL),
(5, 'Ashulia', 'a', 'Admin', '2019-03-05 09:47:58', NULL, NULL),
(6, 'Jashore', 'a', 'Admin', '2019-03-05 09:48:29', NULL, NULL),
(7, 'Rajshahi ', 'a', 'Admin', '2019-03-05 09:48:35', NULL, NULL),
(8, 'Rangpur ', 'a', 'Admin', '2019-03-05 09:48:47', NULL, NULL),
(9, 'Saidpur ', 'a', 'Admin', '2019-03-05 09:49:11', NULL, NULL),
(10, 'Comilla', 'a', 'Admin', '2019-03-05 09:49:28', NULL, NULL),
(11, 'Feni ', 'a', 'Admin', '2019-03-05 09:49:35', NULL, NULL),
(12, 'Barishal ', 'a', 'Admin', '2019-03-05 09:49:47', NULL, NULL),
(13, 'Naryangonj', 'a', 'Admin', '2019-03-05 09:49:54', NULL, NULL),
(14, 'Dhaka', 'a', 'Admin', '2019-03-05 09:50:14', NULL, NULL),
(15, 'Khulna', 'a', 'Admin', '2019-03-05 09:50:32', NULL, NULL),
(16, 'Kushtia', 'a', 'Admin', '2019-03-05 09:51:06', NULL, NULL),
(17, 'Dinajpur ', 'a', 'Admin', '2019-03-05 09:51:34', NULL, NULL),
(18, 'Gopalgonj', 'a', 'Admin', '2019-03-05 09:51:52', NULL, NULL),
(19, 'Noakhali', 'a', 'Admin', '2019-03-05 09:52:08', NULL, NULL),
(20, 'Sylhet', 'a', 'Admin', '2019-03-05 09:52:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `Employee_SlNo` int(11) NOT NULL,
  `Designation_ID` int(11) NOT NULL,
  `Department_ID` int(11) NOT NULL,
  `Employee_ID` varchar(50) NOT NULL,
  `Employee_Name` varchar(150) NOT NULL,
  `Employee_JoinDate` date NOT NULL,
  `Employee_Gender` varchar(20) NOT NULL,
  `Employee_BirthDate` date NOT NULL,
  `Employee_NID` varchar(50) NOT NULL,
  `Employee_ContactNo` varchar(20) NOT NULL,
  `Employee_Email` varchar(50) NOT NULL,
  `Employee_MaritalStatus` varchar(50) NOT NULL,
  `Employee_FatherName` varchar(150) NOT NULL,
  `Employee_MotherName` varchar(150) NOT NULL,
  `Employee_PrasentAddress` text NOT NULL,
  `Employee_PermanentAddress` text NOT NULL,
  `Employee_Pic_org` varchar(250) NOT NULL,
  `Employee_Pic_thum` varchar(250) NOT NULL,
  `salary_range` int(11) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) NOT NULL,
  `AddTime` varchar(50) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(50) NOT NULL,
  `Employee_brinchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`Employee_SlNo`, `Designation_ID`, `Department_ID`, `Employee_ID`, `Employee_Name`, `Employee_JoinDate`, `Employee_Gender`, `Employee_BirthDate`, `Employee_NID`, `Employee_ContactNo`, `Employee_Email`, `Employee_MaritalStatus`, `Employee_FatherName`, `Employee_MotherName`, `Employee_PrasentAddress`, `Employee_PermanentAddress`, `Employee_Pic_org`, `Employee_Pic_thum`, `salary_range`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Employee_brinchid`) VALUES
(1, 4, 1, 'E1001', 'Roni Mazumder', '2019-03-05', 'Male', '2019-03-05', '', '01932598574', 'r', 'married', '', 'r', 's', 's', '', '', 0, 'a', 'Admin', '2019-03-13 01:13:13', '', '', 1),
(2, 1, 2, 'E1002', 'Tareque Islam', '2017-10-01', 'Male', '1980-01-17', '', '01720208244', 'tareque.islam12@gmail.com', 'married', 'Md. Jalil Miah', 'Nibaron Nesa', '283, Tushardhara R/A, Fatullah, Narayangonj.', 'Vill-Raypur, P.O-Satani, P.S-Titas, Dist-Cumilla', '', '', 0, 'a', 'Admin', '2019-03-13 02:07:35', '', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_payment`
--

CREATE TABLE `tbl_employee_payment` (
  `employee_payment_id` int(11) NOT NULL,
  `Employee_SlNo` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `payment_amount` decimal(18,2) NOT NULL,
  `deduction_amount` decimal(18,2) NOT NULL,
  `save_by` char(30) NOT NULL,
  `paymentBranch_id` int(11) NOT NULL,
  `update_date` varchar(12) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_head`
--

CREATE TABLE `tbl_expense_head` (
  `id` int(11) NOT NULL,
  `head_name` varchar(100) DEFAULT NULL,
  `status` enum('a','d') DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_month`
--

CREATE TABLE `tbl_month` (
  `month_id` int(11) NOT NULL,
  `month_name` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_month`
--

INSERT INTO `tbl_month` (`month_id`, `month_name`) VALUES
(1, 'March 2019'),
(2, 'April 2019'),
(3, 'May 2019'),
(4, 'June 2019'),
(5, 'JULY 2019'),
(6, 'AUGUST 2019'),
(7, 'SEPTEMBER 2019'),
(8, 'OCTOBER 2019'),
(9, 'NOVEMBER 2019'),
(10, 'DECEMBER 2019');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package`
--

CREATE TABLE `tbl_package` (
  `package_ID` int(11) NOT NULL,
  `package_name` varchar(250) CHARACTER SET latin1 NOT NULL,
  `package_categoryid` int(11) NOT NULL,
  `package_purchPrice` decimal(18,2) NOT NULL,
  `package_sellPrice` decimal(18,2) NOT NULL,
  `package_ProCode` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package_create`
--

CREATE TABLE `tbl_package_create` (
  `create_ID` int(11) NOT NULL,
  `create_pacageID` varchar(20) CHARACTER SET latin1 NOT NULL,
  `create_item` varchar(250) NOT NULL,
  `create_purch_price` decimal(18,2) NOT NULL,
  `create_sell_price` decimal(18,2) NOT NULL,
  `cteate_qty` int(11) NOT NULL,
  `create_proCode` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `Product_SlNo` int(11) NOT NULL,
  `Product_Code` varchar(50) NOT NULL,
  `Product_Name` varchar(150) NOT NULL,
  `body_number` varchar(30) NOT NULL,
  `body_rate` decimal(18,2) NOT NULL,
  `Product_type` varchar(15) NOT NULL,
  `Product_BarCode` varchar(100) NOT NULL,
  `ProductCategory_ID` int(11) NOT NULL,
  `color` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `size` varchar(11) NOT NULL,
  `gross_Weight` decimal(18,3) DEFAULT NULL,
  `net_Weight` decimal(18,2) DEFAULT NULL,
  `Product_IsRawMaterial` varchar(100) NOT NULL,
  `Product_IsFinishedGoods` varchar(100) NOT NULL,
  `Product_ReOrederLevel` int(11) NOT NULL,
  `Product_Purchase_Rate` decimal(18,2) NOT NULL,
  `Product_SellingPrice` decimal(18,2) NOT NULL,
  `Product_MinimumSellingPrice` decimal(18,2) NOT NULL,
  `Product_WholesaleRate` decimal(18,2) NOT NULL,
  `one_cartun_equal` varchar(20) NOT NULL,
  `Unit_ID` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(100) NOT NULL,
  `AddTime` varchar(30) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(30) NOT NULL,
  `Product_packageID` int(11) NOT NULL,
  `product_create_pack_id` int(11) NOT NULL,
  `Product_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`Product_SlNo`, `Product_Code`, `Product_Name`, `body_number`, `body_rate`, `Product_type`, `Product_BarCode`, `ProductCategory_ID`, `color`, `brand`, `country`, `size`, `gross_Weight`, `net_Weight`, `Product_IsRawMaterial`, `Product_IsFinishedGoods`, `Product_ReOrederLevel`, `Product_Purchase_Rate`, `Product_SellingPrice`, `Product_MinimumSellingPrice`, `Product_WholesaleRate`, `one_cartun_equal`, `Unit_ID`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Product_packageID`, `product_create_pack_id`, `Product_branchid`) VALUES
(1, 'P00001', 'BX1-500C (COPPER) 220/380V,50HZ,83KG ARC WELDING', '', '0.00', 'undefined', '', 1, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '15642.00', '23000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 12:13:22', '', '', 0, 0, 1),
(2, 'P00002', 'BX1-500B (COPPER) 220/380V,50HZ,93KG ARC WELDING', '', '0.00', 'undefined', '', 1, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '17820.00', '26000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 12:14:25', '', '', 0, 0, 1),
(3, 'P00003', 'BX1-630 (COPPER) 220/380V,50HZ,102KG ARC WELDING', '', '0.00', 'undefined', '', 1, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '19998.00', '29500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 12:17:23', '', '', 0, 0, 1),
(4, 'P00004', 'BX1-500A (COPPER) 220/380V,50HZ,120KG ARC WELDING', '', '0.00', 'undefined', '', 1, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '21384.00', '35000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 12:18:15', '', '', 0, 0, 1),
(5, 'P00005', 'BX6-250B 220/380V,50HZ(ALU) SS BODY ,AC ARC WELDING', '', '0.00', 'undefined', '', 1, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '4900.00', '6000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 12:20:25', '', '', 0, 0, 1),
(6, 'P00006', 'BX6-350B 220/380V,50HZ(ALU) SS BODY ,AC ARC WELDING', '', '0.00', 'undefined', '', 1, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '5247.00', '66000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 12:21:32', '', '', 0, 0, 1),
(7, 'P00007', 'BX6-500B 220/380V,50HZ(ALU) SS BODY ,AC ARC WELDING', '', '0.00', 'undefined', '', 1, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '5346.00', '7500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 12:22:40', '', '', 0, 0, 1),
(8, 'P00008', '9917B Angle Grinder 670w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '2349.00', '2349.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 07:29:43', '', '', 0, 0, 3),
(9, 'P00009', '9913B Angle Grinder 670w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '2388.00', '2388.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-06 07:31:05', '', '', 0, 0, 3),
(10, 'P00010', '9310C Angle Grinder 720w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '2654.00', '2654.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 10:31:28', '', '', 0, 0, 3),
(11, 'P00011', '9923 Angle Grinder 860w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '2958.00', '2958.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 10:32:59', '', '', 0, 0, 3),
(12, 'P00012', '9167G Angle Grinder 860w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '2828.00', '2828.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 10:34:09', '', '', 0, 0, 3),
(13, 'P00013', '9167S Angle Grinder 750w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '2740.50', '2741.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:03:29', '', '', 0, 0, 3),
(14, 'P00014', '9710 Angle Grinder 710w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '2262.00', '2262.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:04:42', '', '', 0, 0, 3),
(15, 'P00015', '9925D Angle Grinder 1240w 125mm(5\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '3915.00', '3915.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:16:45', '', '', 0, 0, 3),
(16, 'P00016', '9180B Angle Grinder 2450w 180mm(7\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '6264.00', '6264.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:18:08', '', '', 0, 0, 3),
(17, 'P00017', '7614NB Cut off Machine 2300w 355mm(14\")', '', '0.00', 'undefined', '', 22, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '7830.00', '7830.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:21:09', '', '', 0, 0, 3),
(18, 'P00018', '7214 Cut off Machine 2300w 355mm(14\")', '', '0.00', 'undefined', '', 22, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '11136.00', '11136.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:22:23', '', '', 0, 0, 3),
(19, 'P00019', '5627N Circular saw machine 1200w 180mm(7.25\")', '', '0.00', 'undefined', '', 23, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '4698.00', '4698.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:25:58', '', '', 0, 0, 3),
(20, 'P00020', '5637 Circular saw machine 1350w 190mm(7.25\")', '', '0.00', 'undefined', '', 23, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '5394.00', '5394.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:43:32', '', '', 0, 0, 3),
(21, 'P00021', '5629 Circular saw machine 1500w 235mm(9.25\")', '', '0.00', 'undefined', '', 23, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '6612.00', '6612.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:44:43', '', '', 0, 0, 3),
(22, 'P00022', '5609N Circular saw machine 2100w 235mm(9.25\")', '', '0.00', 'undefined', '', 23, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '7395.00', '7395.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:45:47', '', '', 0, 0, 3),
(23, 'P00023', '3912BS Router machine 1850w 12mm', '', '0.00', 'undefined', '', 24, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '6420.60', '6421.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:48:48', '', '', 0, 0, 3),
(24, 'P00024', '1982 Planer machine 710w 82mm', '', '0.00', 'undefined', '', 25, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '4176.00', '4176.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:50:10', '', '', 0, 0, 3),
(25, 'P00025', '9750 Vertical Grinder 950w 150mm(6\")', '', '0.00', 'undefined', '', 16, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '4567.50', '4568.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 11:52:10', '', '', 0, 0, 3),
(26, 'P00026', '9518E Polisher machine 1200w 180mm(7\")', '', '0.00', 'undefined', '', 30, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '5394.00', '5394.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 12:38:23', '', '', 0, 0, 3),
(27, 'P00027', '2625 Electric Scissor', '', '0.00', 'undefined', '', 33, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '4959.00', '4959.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 12:43:03', '', '', 0, 0, 3),
(28, 'P00028', '1260E Jig saw machine', '', '0.00', 'undefined', '', 34, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '4219.50', '4220.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 12:44:34', '', '', 0, 0, 3),
(29, 'P00029', '2810T Electric Breaker 1050w 20mm', '', '0.00', 'undefined', '', 35, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '10396.50', '10397.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 12:48:05', '', '', 0, 0, 3),
(30, 'P00030', '2865N Electric Breaker 1350w 65mm', '', '0.00', 'undefined', '', 35, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '25230.00', '25230.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 12:49:28', '', '', 0, 0, 3),
(31, 'P00031', '3806 Electric Trimmer 550w 6.35mm', '', '0.00', 'undefined', '', 21, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '3132.00', '3132.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 12:50:34', '', '', 0, 0, 3),
(32, 'P00032', '6028N Magnetic Core drill 1480w 28mm', '', '0.00', 'undefined', '', 17, 0, 5, 1, '', '0.000', '0.00', '', '', 0, '30711.00', '30711.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 12:53:09', '', '', 0, 0, 3),
(33, 'P00033', '6mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '49.00', '55.00', '0.00', '33.00', '1', 1, 'a', 'Admin', '2019-03-07 01:14:05', 'Admin', '2019-03-07 05:46:16', 0, 0, 3),
(34, 'P00034', '7mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '49.00', '55.00', '0.00', '34.00', '1', 1, 'a', 'Admin', '2019-03-07 01:14:50', 'Admin', '2019-03-07 05:46:01', 0, 0, 3),
(37, 'P00035', '8mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '49.00', '55.00', '0.00', '37.00', '1', 1, 'a', 'Admin', '2019-03-07 01:16:10', 'Admin', '2019-03-07 05:45:46', 0, 0, 3),
(40, 'P00036', '9mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '52.00', '60.00', '0.00', '40.00', '1', 1, 'a', 'Admin', '2019-03-07 01:17:17', 'Admin', '2019-03-07 05:45:25', 0, 0, 3),
(41, 'P00037', '10mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '60.00', '63.00', '0.00', '41.00', '1', 1, 'a', 'Admin', '2019-03-07 01:19:11', 'Admin', '2019-03-07 05:45:04', 0, 0, 3),
(45, 'P00038', 'MMA-200 LION (YELLOW) 220V WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '9266.00', '12500.00', '0.00', '45.00', '1', 1, 'a', 'Admin', '2019-03-07 01:35:37', 'Admin', '2019-03-07 01:43:26', 0, 0, 1),
(46, 'P00039', 'MMA-250 SUPER LION (BLACK) 220V,WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '9365.00', '15000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 01:38:32', '', '', 0, 0, 1),
(47, 'P00040', 'MMA-305 LION(YELLOW),220V,WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '10355.00', '17000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 01:40:06', '', '', 0, 0, 1),
(48, 'P00041', 'MMA-315 LION,220/380V,COMBAINED(BLACK YELLOW) WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '17325.00', '26000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 01:58:45', '', '', 0, 0, 1),
(49, 'P00042', 'MMA-350 SUPER LION 220V, (BLACK) WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '14157.00', '25500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 02:02:22', '', '', 0, 0, 1),
(50, 'P00043', 'MMA-350  LION 380V, (YELLOW) WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '14157.00', '25000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 02:12:25', '', '', 0, 0, 1),
(51, 'P00044', 'MMA-400 LION,IGBT,380V,BLACK,WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '21186.00', '36000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 02:13:40', '', '', 0, 0, 1),
(52, 'P00045', 'MMA-500 LION,IGBT,380V,BLACK,WITH ACCESSORIES', '', '0.00', 'undefined', '', 2, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '23364.00', '48000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 02:14:55', '', '', 0, 0, 1),
(53, 'P00046', '11mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '62.00', '70.00', '0.00', '53.00', '1', 1, 'a', 'Admin', '2019-03-07 02:30:11', 'Admin', '2019-03-07 05:44:49', 0, 0, 3),
(54, 'P00047', '12mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '67.00', '75.00', '0.00', '54.00', '1', 1, 'a', 'Admin', '2019-03-07 02:32:03', 'Admin', '2019-03-07 05:44:35', 0, 0, 3),
(55, 'P00048', '13mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '78.00', '70.00', '0.00', '55.00', '1', 1, 'a', 'Admin', '2019-03-07 02:34:36', 'Admin', '2019-03-07 05:44:17', 0, 0, 3),
(56, 'P00049', '14mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '75.00', '85.00', '0.00', '56.00', '1', 1, 'a', 'Admin', '2019-03-07 02:35:24', 'Admin', '2019-03-07 05:44:01', 0, 0, 3),
(57, 'P00050', '15mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '82.00', '95.00', '0.00', '57.00', '1', 1, 'a', 'Admin', '2019-03-07 02:36:16', 'Admin', '2019-03-07 05:43:44', 0, 0, 3),
(58, 'P00051', '16mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '90.00', '100.00', '0.00', '58.00', '1', 1, 'a', 'Admin', '2019-03-07 02:38:55', 'Admin', '2019-03-07 05:43:28', 0, 0, 3),
(63, 'P00052', 'TIG-300 LION (SINGLE FUNCTION) 220V,WITH ACCESSORIES', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '11930.00', '17500.00', '0.00', '63.00', '1', 1, 'a', 'Admin', '2019-03-07 02:47:03', 'Admin', '2019-03-07 02:48:31', 0, 0, 1),
(65, 'P00053', 'TIG/MMA-250 LION 220V,(WITH ACCESSORIES),YELLOW ', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '13365.00', '17500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 02:50:01', '', '', 0, 0, 1),
(68, 'P00054', '17mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '95.00', '105.00', '0.00', '68.00', '1', 1, 'a', 'Admin', '2019-03-07 02:51:42', 'Admin', '2019-03-07 05:42:54', 0, 0, 3),
(69, 'P00055', '18mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '105.00', '116.00', '0.00', '69.00', '1', 1, 'a', 'Admin', '2019-03-07 02:52:24', 'Admin', '2019-03-07 05:42:35', 0, 0, 3),
(76, 'P00056', '19mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '107.00', '118.00', '0.00', '76.00', '1', 1, 'a', 'Admin', '2019-03-07 02:53:36', 'Admin', '2019-03-07 05:41:54', 0, 0, 3),
(77, 'P00057', '20mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '116.00', '125.00', '0.00', '77.00', '1', 1, 'a', 'Admin', '2019-03-07 02:55:16', 'Admin', '2019-03-07 05:41:29', 0, 0, 3),
(82, 'P00058', '21mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '126.00', '135.00', '0.00', '82.00', '1', 1, 'a', 'Admin', '2019-03-07 02:57:05', 'Admin', '2019-03-07 05:41:09', 0, 0, 3),
(84, 'P00059', '22mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '148.00', '165.00', '0.00', '84.00', '1', 1, 'a', 'Admin', '2019-03-07 04:29:52', 'Admin', '2019-03-07 05:40:31', 0, 0, 3),
(85, 'P00060', '23mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '162.00', '185.00', '0.00', '85.00', '1', 1, 'a', 'Admin', '2019-03-07 04:30:39', 'Admin', '2019-03-07 05:40:12', 0, 0, 3),
(86, 'P00061', '24mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '184.00', '195.00', '0.00', '86.00', '1', 1, 'a', 'Admin', '2019-03-07 04:31:22', 'Admin', '2019-03-07 05:39:55', 0, 0, 3),
(87, 'P00062', '25mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '209.00', '230.00', '0.00', '87.00', '1', 1, 'a', 'Admin', '2019-03-07 04:32:14', 'Admin', '2019-03-07 05:39:29', 0, 0, 3),
(88, 'P00063', '26mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '228.00', '240.00', '0.00', '88.00', '1', 1, 'a', 'Admin', '2019-03-07 04:33:00', 'Admin', '2019-03-07 05:38:27', 0, 0, 3),
(89, 'P00064', '27mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '254.00', '265.00', '0.00', '89.00', '1', 1, 'a', 'Admin', '2019-03-07 04:33:36', 'Admin', '2019-03-07 05:37:44', 0, 0, 3),
(90, 'P00065', '28mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '274.00', '285.00', '0.00', '90.00', '1', 1, 'a', 'Admin', '2019-03-07 04:34:12', 'Admin', '2019-03-07 05:37:16', 0, 0, 3),
(115, 'P00066', '29mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '276.00', '288.00', '0.00', '115.00', '1', 1, 'a', 'Admin', '2019-03-07 04:34:52', 'Admin', '2019-03-07 05:35:26', 0, 0, 3),
(116, 'P00067', '30mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '276.00', '288.00', '0.00', '116.00', '1', 1, 'a', 'Admin', '2019-03-07 04:35:27', 'Admin', '2019-03-07 05:35:00', 0, 0, 3),
(117, 'P00068', '32mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '313.00', '320.00', '0.00', '117.00', '1', 1, 'a', 'Admin', '2019-03-07 04:36:03', 'Admin', '2019-03-07 05:34:40', 0, 0, 3),
(123, 'P00069', '34mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '389.00', '400.00', '0.00', '123.00', '1', 1, 'a', 'Admin', '2019-03-07 04:36:33', 'Admin', '2019-03-07 05:34:24', 0, 0, 3),
(126, 'P00070', '36mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '457.00', '485.00', '0.00', '126.00', '1', 1, 'a', 'Admin', '2019-03-07 04:37:06', 'Admin', '2019-03-07 05:34:12', 0, 0, 3),
(127, 'P00071', '38mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '542.00', '565.00', '0.00', '127.00', '1', 1, 'a', 'Admin', '2019-03-07 04:37:41', 'Admin', '2019-03-07 05:34:00', 0, 0, 3),
(129, 'P00072', '40mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '635.00', '675.00', '0.00', '129.00', '1', 1, 'a', 'Admin', '2019-03-07 04:38:33', 'Admin', '2019-03-07 05:33:47', 0, 0, 3),
(130, 'P00073', '42mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '697.00', '750.00', '0.00', '130.00', '1', 1, 'a', 'Admin', '2019-03-07 04:40:19', 'Admin', '2019-03-07 05:33:37', 0, 0, 3),
(131, 'P00074', '44mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '765.00', '800.00', '0.00', '131.00', '1', 1, 'a', 'Admin', '2019-03-07 04:41:55', 'Admin', '2019-03-07 05:33:26', 0, 0, 3),
(132, 'P00075', '46mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '835.00', '885.00', '0.00', '132.00', '1', 1, 'a', 'Admin', '2019-03-07 04:42:35', 'Admin', '2019-03-07 05:33:15', 0, 0, 3),
(133, 'P00076', '48mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '900.00', '980.00', '0.00', '133.00', '1', 1, 'a', 'Admin', '2019-03-07 04:43:23', 'Admin', '2019-03-07 05:33:04', 0, 0, 3),
(134, 'P00077', '50mm Combination', '', '0.00', 'undefined', '', 36, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '927.00', '1050.00', '0.00', '134.00', '1', 1, 'a', 'Admin', '2019-03-07 04:44:29', 'Admin', '2019-03-07 05:32:49', 0, 0, 3),
(135, 'P00078', 'Angle Grinder 750w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 13, 1, '', '0.000', '0.00', '', '', 0, '1633.00', '1700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:04:12', '', '', 0, 0, 3),
(136, 'P00079', 'Golden Dove Holder 500A (L)', '', '0.00', 'undefined', '', 42, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '98.00', '100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:51:07', '', '', 0, 0, 3),
(137, 'P00080', 'Golden Dove Holder 500A (D)', '', '0.00', 'undefined', '', 42, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '90.00', '95.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:52:11', '', '', 0, 0, 3),
(138, 'P00081', 'Morris Holder 600A Japan (L)', '', '0.00', 'undefined', '', 42, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '335.00', '345.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:54:04', '', '', 0, 0, 3),
(139, 'P00082', 'Morris Holder 600A Japan (d)', '', '0.00', 'undefined', '', 42, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '160.00', '180.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:54:44', '', '', 0, 0, 3),
(140, 'P00083', 'Masal Holder 500A China.', '', '0.00', 'undefined', '', 42, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '98.00', '100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:55:53', '', '', 0, 0, 3),
(141, 'P00084', 'Green Holder 500A China', '', '0.00', 'undefined', '', 42, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '148.00', '160.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:57:19', '', '', 0, 0, 3),
(142, 'P00085', 'Esab Holder 500A China', '', '0.00', 'undefined', '', 42, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '275.00', '290.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 05:59:00', '', '', 0, 0, 3),
(143, 'P00086', 'Oxygen Regulator (Box Type-03m)-D', '', '0.00', 'undefined', '', 14, 0, 16, 1, '', '0.000', '0.00', '', '', 0, '484.00', '525.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 06:06:12', '', '', 0, 0, 3),
(144, 'P00087', 'Oxygen Regulator (Star Type)-L', '', '0.00', 'undefined', '', 14, 0, 16, 1, '', '0.000', '0.00', '', '', 0, '678.00', '700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 06:07:34', '', '', 0, 0, 3),
(145, 'P00088', 'Oxygen Regulator ', '', '0.00', 'undefined', '', 14, 0, 20, 1, '', '0.000', '0.00', '', '', 0, '1237.00', '1285.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-07 06:09:07', '', '', 0, 0, 3),
(146, 'P00089', 'TIG/MMA-250 SUPER LION,220V(BLACK) WITH ACCESSORIES', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '13365.00', '19000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 01:39:15', '', '', 0, 0, 1),
(147, 'P00090', 'TIG/MMA-305 LION,220V,WITH ACCESSOORIES)', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '13662.00', '20500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 01:40:41', '', '', 0, 0, 1),
(148, 'P00091', 'TIG/MMA-350 SUPER LION 220V,BLACK,WITH ACCESSORIES', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '19602.00', '29500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 01:49:29', '', '', 0, 0, 1),
(149, 'P00092', 'DSM02-100A Angle Grinder 570w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1440.00', '1476.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:12:10', '', '', 0, 0, 3),
(150, 'P00093', 'DSM08-100 Angle Grinder 800w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1880.00', '1927.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:13:20', '', '', 0, 0, 3),
(151, 'P00094', 'DSM05-100B Angle Grinder 850w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1760.00', '1804.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:15:23', '', '', 0, 0, 3),
(152, 'P00095', 'DSM10-100 Angle Grinder 1020w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2440.00', '2500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:16:41', '', '', 0, 0, 3),
(153, 'P00096', 'DSM02-125B Angle Grinder 1200w 125mm(5\")', '', '0.00', 'undefined', '', 16, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2800.00', '2870.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:18:01', '', '', 0, 0, 3),
(154, 'P00097', 'DSM03-180 Angle Grinder 2200w 180mm(7\")', '', '0.00', 'undefined', '', 16, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '4140.00', '4244.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:20:01', '', '', 0, 0, 3),
(155, 'P00098', 'DMY-185 Circular saw machine 1100w 180mm', '', '0.00', 'undefined', '', 23, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '3060.00', '3137.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:22:03', '', '', 0, 0, 3),
(156, 'P00099', 'DMY-235 Circular saw machine 1520w 235mm', '', '0.00', 'undefined', '', 23, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '4400.00', '4510.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:23:25', '', '', 0, 0, 3),
(157, 'P00100', 'DMY-235 Circular saw machine 2000w 235mm', '', '0.00', 'undefined', '', 23, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '4640.00', '4756.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:24:39', '', '', 0, 0, 3),
(158, 'P00101', 'DJG02-355 Cut off machine 1800w (14\")', '', '0.00', 'undefined', '', 22, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '5840.00', '5986.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:27:56', '', '', 0, 0, 3),
(159, 'P00102', 'DJG04-355 Cut off machine 2000w (14\")', '', '0.00', 'undefined', '', 22, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '6240.00', '6396.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:29:33', '', '', 0, 0, 3),
(160, 'P00103', 'DJG03-355 Cut off machine 2100w (14\")', '', '0.00', 'undefined', '', 22, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '6240.00', '6396.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:30:51', '', '', 0, 0, 3),
(161, 'P00104', 'DZG-10 Demolation Hammer 1500w 10.4kgs', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '14400.00', '14760.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:35:54', '', '', 0, 0, 3),
(162, 'P00105', 'DZG-15 Electric Breaker 1240w 16kgs', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '13500.00', '13838.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:38:09', '', '', 0, 0, 3),
(163, 'P00106', 'DZG05-6 Demolation Hammer 1050w 5.5kgs', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '6000.00', '6150.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:39:34', '', '', 0, 0, 3),
(164, 'P00107', 'DQF-25 Dust Blower 480w', '', '0.00', 'undefined', '', 54, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1620.00', '1660.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:42:26', '', '', 0, 0, 3),
(165, 'P00108', 'DQF-28 Dust Blower 680w', '', '0.00', 'undefined', '', 54, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1640.00', '1680.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:43:17', '', '', 0, 0, 3),
(166, 'P00109', 'DQF-32 Dust Blower 680w', '', '0.00', 'undefined', '', 54, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1720.00', '1763.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:44:07', '', '', 0, 0, 3),
(167, 'P00110', 'DML02-405 Electric Chain Saw 1300w 6kgs', '', '0.00', 'undefined', '', 58, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '6000.00', '6150.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 02:47:08', '', '', 0, 0, 3),
(168, 'P00111', 'DJZ-10A Electric Drill Machine 300w', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1260.00', '1292.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:28:54', '', '', 0, 0, 3),
(169, 'P00112', 'DJZ02-6A Electric Drill Machine 230w', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1160.00', '1189.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:29:54', '', '', 0, 0, 3),
(170, 'P00113', 'DJZ02-13 Electric Drill Machine 500w', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1800.00', '1845.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:30:52', '', '', 0, 0, 3),
(171, 'P00114', 'DJZ03-13B Electric Drill Machine 800w', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2160.00', '2214.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:31:57', '', '', 0, 0, 3),
(172, 'P00115', 'DJZ-16A Electric Drill Machine 800w', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2400.00', '2460.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:33:03', '', '', 0, 0, 3),
(173, 'P00116', 'DSJ02-25 Die Grinder 400w 25mm(1\")', '', '0.00', 'undefined', '', 32, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1680.00', '1722.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:38:40', '', '', 0, 0, 3),
(174, 'P00117', 'DMB-82 Planer Machine 500w', '', '0.00', 'undefined', '', 25, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2400.00', '2460.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:40:26', '', '', 0, 0, 3),
(175, 'P00118', 'DMB02-82 Planer Machine 500w', '', '0.00', 'undefined', '', 25, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2560.00', '2624.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:41:32', '', '', 0, 0, 3),
(176, 'P00119', 'DMR02-12 Router Machine 1650w', '', '0.00', 'undefined', '', 24, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '4052.00', '4153.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:43:04', '', '', 0, 0, 3),
(177, 'P00120', 'DMR04-12 Router Machine 1650w', '', '0.00', 'undefined', '', 24, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '4000.00', '4100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:43:46', '', '', 0, 0, 3),
(178, 'P00121', 'DSB-100 Sander Machine 150w ', '', '0.00', 'undefined', '', 31, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1456.00', '1492.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:47:42', '', '', 0, 0, 3),
(179, 'P00122', 'DSB03-100 Sander Machine 200w', '', '0.00', 'undefined', '', 31, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1600.00', '1640.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:49:08', '', '', 0, 0, 3),
(180, 'P00123', 'DSB-234 Sander Machine 520w', '', '0.00', 'undefined', '', 31, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2520.00', '2583.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:50:18', '', '', 0, 0, 3),
(181, 'P00124', 'DQB-2000 Heat Gun 2000w', '', '0.00', 'undefined', '', 26, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '1260.00', '1292.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:51:40', '', '', 0, 0, 3),
(182, 'P00125', 'DMP03-6 Electric Trimmer 530w 6.35mm', '', '0.00', 'undefined', '', 21, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2560.00', '2624.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:52:53', '', '', 0, 0, 3),
(183, 'P00126', 'DMQ-85 Jig Saw 580w', '', '0.00', 'undefined', '', 34, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '3512.00', '3600.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:55:39', '', '', 0, 0, 3),
(184, 'P00127', 'DMQ-65 Jig Saw 600w', '', '0.00', 'undefined', '', 34, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '3352.00', '3436.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:56:33', '', '', 0, 0, 3),
(185, 'P00128', 'DJX-255 Miter Saw 1650w 255(10\")', '', '0.00', 'undefined', '', 27, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '9600.00', '9840.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 03:59:01', '', '', 0, 0, 3),
(186, 'P00129', 'DJX-355 Miter Saw 1380w (14\")', '', '0.00', 'undefined', '', 27, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '17600.00', '18040.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:00:47', '', '', 0, 0, 3),
(187, 'P00130', 'DZC02-20 Rotary Hammer Drill 500w 2.9kgs', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '3280.00', '3362.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:03:43', '', '', 0, 0, 3),
(188, 'P00131', 'DZC05-26 Rotary Hammer Drill 720w 3.3kgs', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '4000.00', '4100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:05:02', '', '', 0, 0, 3),
(189, 'P00132', 'DZC03-26 Rotary Hammer Drill 620w 5kgs', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '4080.00', '4182.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:05:58', '', '', 0, 0, 3),
(190, 'P00133', 'TIG/MMA-350 LION 380V,YELLOW, WITH ACCESSORIES', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '19602.00', '29000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:08:38', '', '', 0, 0, 1),
(192, 'P00134', 'DJC16 Magnetic Core Drill 900w 16mm', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '12800.00', '13120.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:10:08', '', '', 0, 0, 3),
(194, 'P00135', 'DJC30 Magnetic Core Drill 900w 30mm', '', '0.00', 'undefined', '', 17, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '16000.00', '16400.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:10:57', '', '', 0, 0, 3),
(198, 'P00136', 'TIG/MMA-400 LION,380V,WITH ACCESSORIES', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '28512.00', '50000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:11:59', '', '', 0, 0, 1),
(201, 'P00137', 'DZE03-110 Marble Cutter 1050w', '', '0.00', 'undefined', '', 29, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2160.00', '2214.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:14:00', '', '', 0, 0, 3),
(202, 'P00138', '9992 Angle Grinder 710w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '1080.00', '1080.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:19:09', '', '', 0, 0, 3),
(203, 'P00139', '9993 Angle Grinder 1200w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '1620.00', '1620.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:20:37', '', '', 0, 0, 3),
(204, 'P00140', '9991 Angle Grinder 900w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '1530.00', '1530.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:21:26', '', '', 0, 0, 3),
(205, 'P00141', '9994 Angle Grinder 750w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '1260.00', '1260.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:22:13', '', '', 0, 0, 3),
(206, 'P00142', '9997 Angle Grinder 3200w 180mm(7\")', '', '0.00', 'undefined', '', 16, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '4680.00', '4680.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:23:44', '', '', 0, 0, 3),
(207, 'P00143', '9613 Impact Drill 850w 13mm', '', '0.00', 'undefined', '', 17, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '1530.00', '1530.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:25:12', '', '', 0, 0, 3),
(208, 'P00144', '9610 Electric Drill 400w 10mm', '', '0.00', 'undefined', '', 17, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '900.00', '900.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:26:10', '', '', 0, 0, 3),
(209, 'P00145', '1965 Jig Saw Machine 750w 65mm', '', '0.00', 'undefined', '', 34, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '2250.00', '2250.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:27:04', '', '', 0, 0, 3),
(210, 'P00146', '1993 Planer Machine 500w ', '', '0.00', 'undefined', '', 25, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '2097.00', '2097.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:28:00', '', '', 0, 0, 3),
(211, 'P00147', '3993 Router Machine 1650w', '', '0.00', 'undefined', '', 24, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '3150.00', '3150.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:28:49', '', '', 0, 0, 3),
(212, 'P00148', '3994 Router Machine 2100w', '', '0.00', 'undefined', '', 24, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '4230.00', '4230.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:29:40', '', '', 0, 0, 3),
(213, 'P00149', '5961 Circular Saw Machine 1250w 185mm(7.25\")', '', '0.00', 'undefined', '', 23, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '2700.00', '2700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:30:51', '', '', 0, 0, 3),
(214, 'P00150', '9800 Heat Gun 1800w', '', '0.00', 'undefined', '', 26, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '1485.00', '1485.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-09 04:31:36', '', '', 0, 0, 3),
(215, 'P00151', '2905 Demolation Hammer 5kgs', '', '0.00', 'undefined', '', 17, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '5850.00', '5850.00', '0.00', '215.00', '1', 1, 'a', 'Admin', '2019-03-09 04:34:01', 'Admin', '2019-03-09 04:35:15', 0, 0, 3),
(216, 'P00152', '2910 Demolation Hammer 10kgs', '', '0.00', 'undefined', '', 17, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '10800.00', '10800.00', '0.00', '216.00', '1', 1, 'a', 'Admin', '2019-03-09 04:34:30', 'Admin', '2019-03-09 04:35:35', 0, 0, 3),
(217, 'P00153', '2915 Demolation Hammer 15kgs', '', '0.00', 'undefined', '', 17, 0, 4, 1, '', '0.000', '0.00', '', '', 0, '11970.00', '11970.00', '0.00', '217.00', '1', 1, 'a', 'Admin', '2019-03-09 04:34:54', 'Admin', '2019-03-09 04:36:08', 0, 0, 3),
(218, 'P00154', 'Bench Vice 3\"', '', '0.00', 'undefined', '', 52, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '1100.00', '1180.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:27:29', '', '', 0, 0, 3),
(219, 'P00155', 'Bench Vice 4\"', '', '0.00', 'undefined', '', 52, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '1450.00', '1550.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:28:15', '', '', 0, 0, 3),
(220, 'P00156', 'Bench Vice 5\"', '', '0.00', 'undefined', '', 52, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '2100.00', '2250.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:28:48', '', '', 0, 0, 3),
(221, 'P00157', 'Bench Vice 6\"', '', '0.00', 'undefined', '', 52, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '2800.00', '2940.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:29:27', '', '', 0, 0, 3),
(222, 'P00158', 'Bench Vice 8\"', '', '0.00', 'undefined', '', 52, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '4700.00', '5100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:30:05', '', '', 0, 0, 3),
(223, 'P00159', 'Blower 2\"', '', '0.00', 'undefined', '', 54, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '1100.00', '1700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:32:55', '', '', 0, 0, 3),
(224, 'P00160', 'Blower 2.5\"', '', '0.00', 'undefined', '', 54, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '1500.00', '2200.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:33:31', '', '', 0, 0, 3),
(225, 'P00161', 'Blower 3\"', '', '0.00', 'undefined', '', 54, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '2250.00', '2850.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:34:28', '', '', 0, 0, 3),
(226, 'P00162', 'Blower 4\"', '', '0.00', 'undefined', '', 54, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '5000.00', '5900.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:35:22', '', '', 0, 0, 3),
(227, 'P00163', 'Die Grinder 400w (DCA-03-25)', '', '0.00', 'undefined', '', 32, 0, 25, 1, '', '0.000', '0.00', '', '', 0, '1700.00', '1760.00', '0.00', '227.00', '1', 1, 'a', 'Admin', '2019-03-10 10:37:52', 'Admin', '2019-03-10 10:38:55', 0, 0, 3),
(228, 'P00164', 'Die Grinder 240w (DCA-25)', '', '0.00', 'undefined', '', 32, 0, 25, 1, '', '0.000', '0.00', '', '', 0, '1241.00', '1300.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:40:11', '', '', 0, 0, 3),
(229, 'P00165', 'Die Grinder (Unison)', '', '0.00', 'undefined', '', 32, 0, 26, 1, '', '0.000', '0.00', '', '', 0, '1100.00', '1150.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:42:11', '', '', 0, 0, 3),
(230, 'P00166', 'Die Grinder (OP)', '', '0.00', 'undefined', '', 32, 0, 27, 1, '', '0.000', '0.00', '', '', 0, '800.00', '840.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:44:20', '', '', 0, 0, 3),
(231, 'P00167', 'Die Grinder (Horse) AT-7032k', '', '0.00', 'undefined', '', 32, 0, 28, 1, '', '0.000', '0.00', '', '', 0, '825.00', '860.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 10:45:32', '', '', 0, 0, 3),
(232, 'P00168', 'Socket Set (10-32mm)24Pcs', '', '0.00', 'undefined', '', 55, 0, 15, 1, '', '0.000', '0.00', '', '', 0, '1500.00', '1600.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 10:48:46', '', '', 0, 0, 3),
(233, 'P00169', 'Socket Set (10-27mm)13Pcs', '', '0.00', 'undefined', '', 55, 0, 15, 1, '', '0.000', '0.00', '', '', 0, '980.00', '1020.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 10:49:47', '', '', 0, 0, 3),
(234, 'P00170', 'Socket Set (10-24mm)10Pcs', '', '0.00', 'undefined', '', 55, 0, 15, 1, '', '0.000', '0.00', '', '', 0, '450.00', '465.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 10:50:34', '', '', 0, 0, 3),
(235, 'P00171', 'Socket Set (10-24mm)9Pcs', '', '0.00', 'undefined', '', 55, 0, 15, 1, '', '0.000', '0.00', '', '', 0, '420.00', '440.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 10:54:01', '', '', 0, 0, 3),
(236, 'P00172', 'Socket Set (8-32mm)28Pcs', '', '0.00', 'undefined', '', 55, 0, 15, 1, '', '0.000', '0.00', '', '', 0, '1600.00', '1680.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 10:54:49', '', '', 0, 0, 3),
(237, 'P00173', 'Socket Set (10-24mm)10Pcs', '', '0.00', 'undefined', '', 55, 0, 29, 1, '', '0.000', '0.00', '', '', 0, '215.00', '225.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 10:56:06', '', '', 0, 0, 3),
(238, 'P00174', 'Socket Set Green 40Pcs', '', '0.00', 'undefined', '', 55, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '2221.00', '2325.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 10:58:26', '', '', 0, 0, 3),
(239, 'P00175', 'Socket Set (12pt) Green 24Pcs', '', '0.00', 'undefined', '', 55, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '3072.00', '3272.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 11:00:10', '', '', 0, 0, 3),
(240, 'P00176', 'Socket Set (6pt) Green 11Pcs', '', '0.00', 'undefined', '', 55, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '1116.00', '1215.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 11:01:43', '', '', 0, 0, 3),
(241, 'P00177', 'Socket Set (12pt) mm Green 24Pcs', '', '0.00', 'undefined', '', 55, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '2297.00', '2350.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 11:04:12', '', '', 0, 0, 3),
(242, 'P00178', 'Socket Set (6pt) mm Green 24Pcs', '', '0.00', 'undefined', '', 55, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '2297.00', '2350.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 11:04:47', '', '', 0, 0, 3),
(243, 'P00179', 'Socket Set (12pt) mm Red 24Pcs', '', '0.00', 'undefined', '', 55, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '2088.00', '2150.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 11:05:53', '', '', 0, 0, 3),
(244, 'P00180', 'Socket Set (6pt) mm Red 24Pcs', '', '0.00', 'undefined', '', 55, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '2088.00', '2150.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-10 11:06:17', '', '', 0, 0, 3),
(245, 'P00181', '4\" Chain Wrench', '', '0.00', 'undefined', '', 19, 0, 7, 1, '', '0.000', '0.00', '', '', 0, '2100.00', '2500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 11:12:59', '', '', 0, 0, 3),
(246, 'P00182', '6\" Chain Wrench', '', '0.00', 'undefined', '', 19, 0, 7, 1, '', '0.000', '0.00', '', '', 0, '3000.00', '3100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 11:13:33', '', '', 0, 0, 3),
(247, 'P00183', '8\" Chain Wrench', '', '0.00', 'undefined', '', 19, 0, 7, 1, '', '0.000', '0.00', '', '', 0, '3900.00', '4050.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 11:14:21', '', '', 0, 0, 3),
(248, 'P00184', 'Bench Grinder 8\"', '', '0.00', 'undefined', '', 59, 0, 30, 1, '', '0.000', '0.00', '', '', 0, '2050.00', '2150.00', '0.00', '248.00', '1', 1, 'a', 'Admin', '2019-03-10 12:13:36', 'Admin', '2019-03-10 12:14:03', 0, 0, 3),
(249, 'P00185', 'Bench Grinder 8\"', '', '0.00', 'undefined', '', 59, 0, 31, 1, '', '0.000', '0.00', '', '', 0, '4587.00', '4750.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:14:44', '', '', 0, 0, 3),
(250, 'P00186', 'Bench Grinder 6\"', '', '0.00', 'undefined', '', 59, 0, 31, 1, '', '0.000', '0.00', '', '', 0, '3553.00', '3800.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:15:18', '', '', 0, 0, 3),
(251, 'P00187', 'Water Paper 120', '', '0.00', 'undefined', '', 60, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '8.00', '9.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:20:09', '', '', 0, 0, 3),
(252, 'P00188', 'Water Paper 220', '', '0.00', 'undefined', '', 60, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '11.00', '13.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:20:37', '', '', 0, 0, 3),
(253, 'P00189', 'Water Paper 320', '', '0.00', 'undefined', '', 60, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '11.00', '13.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:21:24', '', '', 0, 0, 3),
(254, 'P00190', 'Welding Cable 35mm', '', '0.00', 'undefined', '', 56, 0, 9, 1, '', '0.000', '0.00', '', '', 0, '28.00', '35.00', '0.00', '0.00', '1', 4, 'a', 'Admin', '2019-03-10 12:23:38', '', '', 0, 0, 3),
(255, 'P00191', 'Welding Cable 50mm', '', '0.00', 'undefined', '', 56, 0, 9, 1, '', '0.000', '0.00', '', '', 0, '48.00', '52.00', '0.00', '0.00', '1', 4, 'a', 'Admin', '2019-03-10 12:24:22', '', '', 0, 0, 3),
(256, 'P00192', 'Welding Cable 70mm', '', '0.00', 'undefined', '', 56, 0, 9, 1, '', '0.000', '0.00', '', '', 0, '70.00', '74.00', '0.00', '0.00', '1', 4, 'a', 'Admin', '2019-03-10 12:24:52', '', '', 0, 0, 3),
(257, 'P00193', 'Welding Cable 95mm', '', '0.00', 'undefined', '', 56, 0, 9, 1, '', '0.000', '0.00', '', '', 0, '95.00', '105.00', '0.00', '0.00', '1', 4, 'a', 'Admin', '2019-03-10 12:25:21', '', '', 0, 0, 3),
(258, 'P00194', 'Welding Torch', '', '0.00', 'undefined', '', 41, 0, 19, 1, '', '0.000', '0.00', '', '', 0, '572.00', '600.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:29:51', '', '', 0, 0, 3),
(259, 'P00195', 'Welding Torch', '', '0.00', 'undefined', '', 41, 0, 16, 1, '', '0.000', '0.00', '', '', 0, '661.00', '700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:30:47', '', '', 0, 0, 3),
(260, 'P00196', 'Welding Torch', '', '0.00', 'undefined', '', 41, 0, 32, 1, '', '0.000', '0.00', '', '', 0, '661.00', '700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:31:25', '', '', 0, 0, 3),
(261, 'P00197', 'Welding Torch', '', '0.00', 'undefined', '', 41, 0, 18, 1, '', '0.000', '0.00', '', '', 0, '1100.00', '1230.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 12:32:00', '', '', 0, 0, 3),
(262, 'P00198', 'DSS-150 Vertical Grinder 1020w 150mm(6\")', '', '0.00', 'undefined', '', 16, 0, 3, 1, '', '0.000', '0.00', '', '', 0, '2792.00', '2862.00', '0.00', '262.00', '1', 1, 'a', 'Admin', '2019-03-10 01:25:34', 'Admin', '2019-03-10 01:25:57', 0, 0, 3),
(263, 'P00199', 'MMA-500 LION,380V,WITH ACCESSORIES', '', '0.00', 'undefined', '', 3, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '36036.00', '75000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 03:45:02', '', '', 0, 0, 1),
(264, 'P00200', 'WSME-250,AC/DC,TIG WELDING(PULSE FUNCTION) WITH ACCESSORIES', '', '0.00', 'undefined', '', 4, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '24990.00', '50000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 03:46:39', '', '', 0, 0, 1),
(265, 'P00201', 'Bag Closer ', '', '0.00', 'undefined', '', 61, 0, 33, 1, '', '0.000', '0.00', '', '', 0, '5500.00', '5800.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 03:55:01', '', '', 0, 0, 3),
(266, 'P00202', 'Bag Closer ', '', '0.00', 'undefined', '', 61, 0, 35, 1, '', '0.000', '0.00', '', '', 0, '5300.00', '5600.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 03:55:41', '', '', 0, 0, 3),
(267, 'P00203', 'Bag Closer Single', '', '0.00', 'undefined', '', 61, 0, 34, 1, '', '0.000', '0.00', '', '', 0, '7000.00', '7500.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 03:56:26', '', '', 0, 0, 3),
(268, 'P00204', 'Bag Closer Double', '', '0.00', 'undefined', '', 61, 0, 34, 1, '', '0.000', '0.00', '', '', 0, '8500.00', '9500.00', '0.00', '268.00', '1', 1, 'a', 'Admin', '2019-03-10 03:56:58', 'Admin', '2019-03-10 03:57:24', 0, 0, 3),
(269, 'P00205', 'Grease gun double piston.', '', '0.00', 'undefined', '', 46, 0, 36, 1, '', '0.000', '0.00', '', '', 0, '560.00', '625.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:07:03', '', '', 0, 0, 3),
(270, 'P00206', 'Grease gun red horse 10kgs', '', '0.00', 'undefined', '', 46, 0, 38, 1, '', '0.000', '0.00', '', '', 0, '3700.00', '4000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:07:57', '', '', 0, 0, 3),
(271, 'P00207', 'Grease gun 5kgs', '', '0.00', 'undefined', '', 46, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '3236.00', '3400.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:09:06', '', '', 0, 0, 3),
(272, 'P00208', 'Grease gun 10kgs', '', '0.00', 'undefined', '', 46, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '3895.00', '4100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:10:22', '', '', 0, 0, 3),
(273, 'P00209', 'Grease gun 15kgs', '', '0.00', 'undefined', '', 46, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '4846.00', '5000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:10:58', '', '', 0, 0, 3),
(274, 'P00210', 'Grease gun 8 oz small 20-111', '', '0.00', 'undefined', '', 46, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '309.00', '320.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:12:24', '', '', 0, 0, 3),
(275, 'P00211', 'Grease gun 10 oz medium 20-114', '', '0.00', 'undefined', '', 46, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '334.00', '345.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:13:26', '', '', 0, 0, 3),
(276, 'P00212', 'Grease gun 15 oz big 20-203', '', '0.00', 'undefined', '', 46, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '406.00', '425.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:15:00', '', '', 0, 0, 3),
(280, 'P00213', 'Hose pipe (Single)', '', '0.00', 'undefined', '', 62, 0, 39, 1, '', '0.000', '0.00', '', '', 0, '3800.00', '3950.00', '0.00', '0.00', '1', 3, 'a', 'Admin', '2019-03-10 04:21:57', '', '', 0, 0, 3),
(281, 'P00214', 'Hose pipe (Single)', '', '0.00', 'undefined', '', 62, 0, 39, 1, '', '0.000', '0.00', '', '', 0, '3800.00', '3950.00', '0.00', '0.00', '1', 3, 'a', 'Admin', '2019-03-10 04:22:25', '', '', 0, 0, 3),
(282, 'P00215', 'Ring-8x9', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '52.00', '57.00', '0.00', '282.00', '1', 1, 'a', 'Admin', '2019-03-10 04:27:11', 'Admin', '2019-03-10 04:33:26', 0, 0, 3),
(283, 'P00216', 'Ring-10x11', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '52.00', '57.00', '0.00', '283.00', '1', 1, 'a', 'Admin', '2019-03-10 04:28:03', 'Admin', '2019-03-10 04:33:13', 0, 0, 3),
(284, 'P00217', 'Ring-12x13', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '62.00', '67.00', '0.00', '284.00', '1', 1, 'a', 'Admin', '2019-03-10 04:29:00', 'Admin', '2019-03-10 04:33:01', 0, 0, 3),
(285, 'P00218', 'Ring-14x15', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '68.00', '73.00', '0.00', '285.00', '1', 1, 'a', 'Admin', '2019-03-10 04:29:45', 'Admin', '2019-03-10 04:32:45', 0, 0, 3),
(286, 'P00219', 'Ring-16x17', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '78.00', '85.00', '0.00', '286.00', '1', 1, 'a', 'Admin', '2019-03-10 04:30:22', 'Admin', '2019-03-10 04:32:32', 0, 0, 3);
INSERT INTO `tbl_product` (`Product_SlNo`, `Product_Code`, `Product_Name`, `body_number`, `body_rate`, `Product_type`, `Product_BarCode`, `ProductCategory_ID`, `color`, `brand`, `country`, `size`, `gross_Weight`, `net_Weight`, `Product_IsRawMaterial`, `Product_IsFinishedGoods`, `Product_ReOrederLevel`, `Product_Purchase_Rate`, `Product_SellingPrice`, `Product_MinimumSellingPrice`, `Product_WholesaleRate`, `one_cartun_equal`, `Unit_ID`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Product_packageID`, `product_create_pack_id`, `Product_branchid`) VALUES
(287, 'P00220', 'Ring-18x19', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '112.00', '120.00', '0.00', '287.00', '1', 1, 'a', 'Admin', '2019-03-10 04:31:02', 'Admin', '2019-03-10 04:32:22', 0, 0, 3),
(288, 'P00221', 'Ring-20x22', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '135.00', '145.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:32:05', '', '', 0, 0, 3),
(289, 'P00222', 'Ring-24x26', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '180.00', '200.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:34:13', '', '', 0, 0, 3),
(290, 'P00223', 'Ring-30x32', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '280.00', '310.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:34:55', '', '', 0, 0, 3),
(291, 'P00224', 'Ring-32x34', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '360.00', '380.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:35:30', '', '', 0, 0, 3),
(292, 'P00225', 'Ring-32x36', '', '0.00', 'undefined', '', 48, 0, 12, 1, '', '0.000', '0.00', '', '', 0, '380.00', '400.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-10 04:36:08', '', '', 0, 0, 3),
(293, 'P00226', 'Acetylene Regulator heavy', '', '0.00', 'undefined', '', 13, 0, 16, 1, '', '0.000', '0.00', '', '', 0, '678.00', '700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:33:02', '', '', 0, 0, 3),
(294, 'P00227', 'Acetylene Regulator', '', '0.00', 'undefined', '', 13, 0, 20, 1, '', '0.000', '0.00', '', '', 0, '1237.00', '1285.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:33:46', '', '', 0, 0, 3),
(295, 'P00228', 'Acetylene Regulator', '', '0.00', 'undefined', '', 13, 0, 18, 1, '', '0.000', '0.00', '', '', 0, '723.00', '745.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:34:24', '', '', 0, 0, 3),
(296, 'P00229', 'Acetylene Regulator', '', '0.00', 'undefined', '', 13, 0, 21, 1, '', '0.000', '0.00', '', '', 0, '1165.00', '1265.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:35:14', '', '', 0, 0, 3),
(297, 'P00230', 'Allen Key Set 1.5-12mm (10Pcs) Extra Long Arrow', '', '0.00', 'undefined', '', 63, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '296.00', '315.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 10:39:44', '', '', 0, 0, 3),
(298, 'P00231', 'Allen Key Set 1.5-10mm (9Pcs) Short Arrow', '', '0.00', 'undefined', '', 63, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '114.00', '125.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 10:40:44', '', '', 0, 0, 3),
(299, 'P00232', 'Allen Key Set 1.5-12mm Extra Long Kings', '', '0.00', 'undefined', '', 63, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '429.00', '450.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 10:42:30', '', '', 0, 0, 3),
(300, 'P00233', 'Allen Key Set 1/16\"-3/8\"  Long Blue', '', '0.00', 'undefined', '', 63, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '595.00', '610.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 10:44:00', '', '', 0, 0, 3),
(301, 'P00234', 'Crimping Tools Zupper YQK-300H (Black)', '', '0.00', 'undefined', '', 64, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '2700.00', '2820.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:47:53', '', '', 0, 0, 3),
(302, 'P00235', 'Crimping Tools Zupper (HY) Co-400B with CP180B Pump', '', '0.00', 'undefined', '', 64, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '12560.00', '14500.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 10:49:39', '', '', 0, 0, 3),
(303, 'P00236', 'Lony Hydro Cable Punch', '', '0.00', 'undefined', '', 64, 0, 24, 1, '', '0.000', '0.00', '', '', 0, '2150.00', '2250.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:51:53', '', '', 0, 0, 3),
(304, 'P00237', 'Carbide Tips 1/2\" \"V\" China', '', '0.00', 'undefined', '', 65, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '83.00', '86.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:56:22', '', '', 0, 0, 3),
(305, 'P00238', 'Carbide Tips 3/8\" \"V\" China', '', '0.00', 'undefined', '', 65, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '57.00', '60.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 10:57:00', '', '', 0, 0, 3),
(306, 'P00239', '7\" Diamond Cutter', '', '0.00', 'undefined', '', 50, 0, 40, 1, '', '0.000', '0.00', '', '', 0, '162.00', '175.00', '0.00', '306.00', '1', 1, 'a', 'Admin', '2019-03-11 11:07:33', 'Admin', '2019-03-11 11:19:40', 0, 0, 3),
(307, 'P00240', '4\" Diamond Cutter', '', '0.00', 'undefined', '', 50, 0, 41, 1, '', '0.000', '0.00', '', '', 0, '75.00', '80.00', '0.00', '307.00', '1', 1, 'a', 'Admin', '2019-03-11 11:08:09', 'Admin', '2019-03-11 11:19:15', 0, 0, 3),
(308, 'P00241', '4\" Diamond Cutter', '', '0.00', 'undefined', '', 50, 0, 42, 1, '', '0.000', '0.00', '', '', 0, '43.00', '48.00', '0.00', '308.00', '1', 1, 'a', 'Admin', '2019-03-11 11:08:44', 'Admin', '2019-03-11 11:18:51', 0, 0, 3),
(309, 'P00242', '36\" Bolt Cutter', '', '0.00', 'undefined', '', 47, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '900.00', '1050.00', '0.00', '309.00', '1', 1, 'a', 'Admin', '2019-03-11 11:10:05', 'Admin', '2019-03-11 11:11:18', 0, 0, 3),
(310, 'P00243', '42\" Bolt Cutter', '', '0.00', 'undefined', '', 47, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '1560.00', '1750.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 11:10:48', '', '', 0, 0, 3),
(311, 'P00244', 'Cutting Nozzle 1/16\" PNME 9G', '', '0.00', 'undefined', '', 66, 0, 20, 1, '', '0.000', '0.00', '', '', 0, '86.00', '95.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 11:14:48', '', '', 0, 0, 3),
(312, 'P00245', 'Cutting Nozzle 1/16\" PNME 18G', '', '0.00', 'undefined', '', 66, 0, 20, 1, '', '0.000', '0.00', '', '', 0, '86.00', '95.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 11:21:55', '', '', 0, 0, 3),
(313, 'P00246', 'Cutting Nozzle 1/32\" PNME 18G', '', '0.00', 'undefined', '', 66, 0, 20, 1, '', '0.000', '0.00', '', '', 0, '86.00', '95.00', '0.00', '313.00', '1', 1, 'a', 'Admin', '2019-03-11 11:22:46', 'Admin', '2019-03-11 11:25:45', 0, 0, 3),
(314, 'P00247', 'Cutting Nozzle 1/32\" PNME 9G', '', '0.00', 'undefined', '', 66, 0, 20, 1, '', '0.000', '0.00', '', '', 0, '86.00', '95.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 11:23:19', '', '', 0, 0, 3),
(315, 'P00248', 'Cutting Nozzle 3/64\" PNME 18G', '', '0.00', 'undefined', '', 66, 0, 20, 1, '', '0.000', '0.00', '', '', 0, '86.00', '95.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 11:25:01', '', '', 0, 0, 3),
(318, 'P00249', 'Drill Machine 1000w 1/2\"', '', '0.00', 'undefined', '', 17, 0, 46, 1, '', '0.000', '0.00', '', '', 0, '900.00', '950.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 11:29:25', '', '', 0, 0, 3),
(319, 'P00250', 'Drill Bit Set 1/16\"-1/2\" (29Pcs) ', '', '0.00', 'undefined', '', 67, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '554.00', '600.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 11:31:11', '', '', 0, 0, 3),
(320, 'P00251', 'Drill Bit Set 1/16\"-1/4\" (13Pcs) Plastic Box ', '', '0.00', 'undefined', '', 67, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '78.00', '85.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 11:32:20', '', '', 0, 0, 3),
(321, 'P00252', 'Drill Bit Set 1.5-6.5 (13Pcs) Plastic Box', '', '0.00', 'undefined', '', 67, 0, 6, 1, '', '0.000', '0.00', '', '', 0, '78.00', '85.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-11 11:33:41', '', '', 0, 0, 3),
(322, 'P00253', 'testProduct ', '', '0.00', 'undefined', '', 68, 0, 49, 1, '', '0.000', '0.00', '', '', 10, '15.00', '20.00', '0.00', '0.00', '1', 2, 'a', 'testProductAdmin', '2019-03-11 02:50:19', '', '', 0, 0, 2),
(323, 'P00254', 'Hammer 4Lbs', '', '0.00', 'undefined', '', 51, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '224.00', '232.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 04:50:32', '', '', 0, 0, 3),
(324, 'P00255', 'Hammer 6Lbs', '', '0.00', 'undefined', '', 51, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '336.00', '348.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 04:51:15', '', '', 0, 0, 3),
(325, 'P00256', 'Hammer 8Lbs', '', '0.00', 'undefined', '', 51, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '448.00', '464.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 04:52:11', '', '', 0, 0, 3),
(326, 'P00257', 'Hammer 10Lbs', '', '0.00', 'undefined', '', 51, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '560.00', '580.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 04:52:47', '', '', 0, 0, 3),
(327, 'P00258', 'Hammer 12Lbs', '', '0.00', 'undefined', '', 51, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '672.00', '696.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 04:53:29', '', '', 0, 0, 3),
(328, 'P00259', 'Hammer 1Lbs (Claw)', '', '0.00', 'undefined', '', 51, 0, 50, 1, '', '0.000', '0.00', '', '', 0, '286.00', '298.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 05:04:18', '', '', 0, 0, 3),
(329, 'P00260', 'Hammer (Ball Pein)', '', '0.00', 'undefined', '', 51, 0, 50, 1, '', '0.000', '0.00', '', '', 0, '256.00', '265.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 05:05:27', '', '', 0, 0, 3),
(330, 'P00261', 'Hammer .50Lbs', '', '0.00', 'undefined', '', 51, 0, 51, 1, '', '0.000', '0.00', '', '', 0, '75.00', '78.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 05:07:13', '', '', 0, 0, 3),
(331, 'P00262', '2 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 52, 1, '', '0.000', '0.00', '', '', 0, '635.00', '690.00', '0.00', '331.00', '1', 1, 'a', 'Admin', '2019-03-11 05:48:12', 'Admin', '2019-03-11 05:56:57', 0, 0, 3),
(332, 'P00263', '3 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '620.00', '650.00', '0.00', '332.00', '1', 1, 'a', 'Admin', '2019-03-11 05:50:17', 'Admin', '2019-03-11 06:05:16', 0, 0, 3),
(333, 'P00264', '5 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '710.00', '760.00', '0.00', '333.00', '1', 1, 'a', 'Admin', '2019-03-11 05:50:44', 'Admin', '2019-03-11 06:05:35', 0, 0, 3),
(334, 'P00265', '10 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '1000.00', '1100.00', '0.00', '334.00', '1', 1, 'a', 'Admin', '2019-03-11 05:51:19', 'Admin', '2019-03-11 06:07:56', 0, 0, 3),
(335, 'P00266', '12 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '1020.00', '1150.00', '0.00', '335.00', '1', 1, 'a', 'Admin', '2019-03-11 05:52:03', 'Admin', '2019-03-11 06:08:51', 0, 0, 3),
(336, 'P00267', '16 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '1120.00', '1210.00', '0.00', '336.00', '1', 1, 'a', 'Admin', '2019-03-11 05:52:25', 'Admin', '2019-03-11 06:09:17', 0, 0, 3),
(337, 'P00268', '20 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '1500.00', '1650.00', '0.00', '337.00', '1', 1, 'a', 'Admin', '2019-03-11 05:53:14', 'Admin', '2019-03-11 06:09:35', 0, 0, 3),
(338, 'P00269', '32 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '2020.00', '2250.00', '0.00', '338.00', '1', 1, 'a', 'Admin', '2019-03-11 05:53:42', 'Admin', '2019-03-11 06:10:36', 0, 0, 3),
(339, 'P00270', '50 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 53, 1, '', '0.000', '0.00', '', '', 0, '3050.00', '3250.00', '0.00', '339.00', '1', 1, 'a', 'Admin', '2019-03-11 05:54:15', 'Admin', '2019-03-11 06:10:53', 0, 0, 3),
(340, 'P00271', '3 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 52, 1, '', '0.000', '0.00', '', '', 0, '734.00', '800.00', '0.00', '0.00', '1', 0, 'a', 'Admin', '2019-03-11 06:39:03', '', '', 0, 0, 3),
(341, 'P00272', '5 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 52, 1, '', '0.000', '0.00', '', '', 0, '964.00', '1000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:39:45', '', '', 0, 0, 3),
(342, 'P00273', '10 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 52, 1, '', '0.000', '0.00', '', '', 0, '1233.00', '1350.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:40:37', '', '', 0, 0, 3),
(343, 'P00274', '20 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 52, 1, '', '0.000', '0.00', '', '', 0, '1935.00', '2100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:41:15', '', '', 0, 0, 3),
(344, 'P00275', '50 Ton Hydraulic Jack', '', '0.00', 'undefined', '', 53, 0, 52, 1, '', '0.000', '0.00', '', '', 0, '4350.00', '4153.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:41:58', '', '', 0, 0, 3),
(345, 'P00276', 'Oil can 1/2\" PINT', '', '0.00', 'undefined', '', 43, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '87.00', '95.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:44:09', '', '', 0, 0, 3),
(346, 'P00277', 'Oil can 3/4\" PINT', '', '0.00', 'undefined', '', 43, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '93.00', '98.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:44:43', '', '', 0, 0, 3),
(347, 'P00278', 'Oil pump', '', '0.00', 'undefined', '', 69, 0, 54, 1, '', '0.000', '0.00', '', '', 0, '1280.00', '1390.00', '0.00', '347.00', '1', 1, 'a', 'Admin', '2019-03-11 06:48:28', 'Admin', '2019-03-11 06:51:47', 0, 0, 3),
(348, 'P00279', 'Oil pump', '', '0.00', 'undefined', '', 69, 0, 55, 1, '', '0.000', '0.00', '', '', 0, '1100.00', '1160.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:49:06', '', '', 0, 0, 3),
(349, 'P00280', 'Oil pump', '', '0.00', 'undefined', '', 69, 0, 57, 1, '', '0.000', '0.00', '', '', 0, '1150.00', '1250.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:50:13', '', '', 0, 0, 3),
(350, 'P00281', 'Oil pump', '', '0.00', 'undefined', '', 69, 0, 56, 1, '', '0.000', '0.00', '', '', 0, '1050.00', '1150.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:50:37', '', '', 0, 0, 3),
(351, 'P00282', 'Oil pump 1\"', '', '0.00', 'undefined', '', 69, 0, 37, 1, '', '0.000', '0.00', '', '', 0, '1293.00', '1350.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:51:21', '', '', 0, 0, 3),
(352, 'P00283', 'Angle Grinder 750w 100mm(4\")', '', '0.00', 'undefined', '', 16, 0, 13, 1, '', '0.000', '0.00', '', '', 0, '1633.00', '1700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-11 06:58:34', '', '', 0, 0, 3),
(353, 'P00284', 'ghfgh ', '', '0.00', 'undefined', '', 4, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '5522.00', '0.00', '0.00', '0.00', '1', 1, 'd', 'Admin', '2019-03-12 01:36:14', '', '', 0, 0, 1),
(354, 'P00285', '7.25\" x 60 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '765.00', '825.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:15:48', '', '', 0, 0, 3),
(355, 'P00286', '7.25\" x 80 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '900.00', '980.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:16:23', '', '', 0, 0, 3),
(356, 'P00287', '9.25\" x 60 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '1152.00', '1260.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:17:01', '', '', 0, 0, 3),
(357, 'P00288', '9.25\" x 80 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '1260.00', '1390.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:17:39', '', '', 0, 0, 3),
(358, 'P00289', '12\" x 100 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '2070.00', '2280.00', '0.00', '0.00', '1', 1, 'd', 'Admin', '2019-03-12 04:18:36', '', '', 0, 0, 3),
(359, 'P00290', '12\" x 120 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '2250.00', '2350.00', '0.00', '0.00', '1', 1, 'd', 'Admin', '2019-03-12 04:19:06', '', '', 0, 0, 3),
(360, 'P00291', '10\" x 60 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '1440.00', '1600.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:20:30', '', '', 0, 0, 3),
(361, 'P00292', '10\" x 80 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '1485.00', '1660.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:21:10', '', '', 0, 0, 3),
(362, 'P00293', '12\" x 100 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '2070.00', '2280.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:21:49', '', '', 0, 0, 3),
(363, 'P00294', '12\" x 120 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '2250.00', '2350.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:22:23', '', '', 0, 0, 3),
(364, 'P00295', '14\" x 120 teeth ', '', '0.00', 'undefined', '', 49, 0, 58, 1, '', '0.000', '0.00', '', '', 0, '3240.00', '3340.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:22:58', '', '', 0, 0, 3),
(365, 'P00296', 'Packing machine', '', '0.00', 'undefined', '', 38, 0, 60, 1, '', '0.000', '0.00', '', '', 0, '680.00', '740.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:26:17', '', '', 0, 0, 3),
(366, 'P00297', 'Packing machine', '', '0.00', 'undefined', '', 38, 0, 59, 1, '', '0.000', '0.00', '', '', 0, '2600.00', '2630.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:26:48', '', '', 0, 0, 3),
(367, 'P00298', 'Pipe wrench 12\"', '', '0.00', 'undefined', '', 18, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '247.00', '270.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:58:27', '', '', 0, 0, 3),
(368, 'P00299', 'Pipe wrench 14\"', '', '0.00', 'undefined', '', 18, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '331.00', '350.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:58:56', '', '', 0, 0, 3),
(369, 'P00300', 'Pipe wrench 18\"', '', '0.00', 'undefined', '', 18, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '480.00', '510.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 04:59:29', '', '', 0, 0, 3),
(370, 'P00301', 'Pipe wrench 24\"', '', '0.00', 'undefined', '', 18, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '714.00', '810.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:00:14', '', '', 0, 0, 3),
(371, 'P00302', 'Pipe wrench 36\"', '', '0.00', 'undefined', '', 18, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '1420.00', '1610.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:00:56', '', '', 0, 0, 3),
(372, 'P00303', 'Pipe wrench 48\"', '', '0.00', 'undefined', '', 18, 0, 43, 1, '', '0.000', '0.00', '', '', 0, '2346.00', '2670.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:01:41', '', '', 0, 0, 3),
(373, 'P00304', 'Pipe wrench 12\"', '', '0.00', 'undefined', '', 18, 0, 45, 1, '', '0.000', '0.00', '', '', 0, '262.00', '276.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:07:57', '', '', 0, 0, 3),
(374, 'P00305', 'Pipe wrench 14\"', '', '0.00', 'undefined', '', 18, 0, 45, 1, '', '0.000', '0.00', '', '', 0, '314.00', '340.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:11:16', '', '', 0, 0, 3),
(375, 'P00306', 'Pipe wrench 18\"', '', '0.00', 'undefined', '', 18, 0, 45, 1, '', '0.000', '0.00', '', '', 0, '446.00', '470.00', '0.00', '375.00', '1', 1, 'a', 'Admin', '2019-03-12 05:11:54', 'Admin', '2019-03-12 05:15:08', 0, 0, 3),
(376, 'P00307', 'Pipe wrench 24\"', '', '0.00', 'undefined', '', 18, 0, 45, 1, '', '0.000', '0.00', '', '', 0, '633.00', '665.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:12:28', '', '', 0, 0, 3),
(377, 'P00308', 'Pipe wrench 36\"', '', '0.00', 'undefined', '', 18, 0, 44, 1, '', '0.000', '0.00', '', '', 0, '1219.00', '1280.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:14:07', '', '', 0, 0, 3),
(378, 'P00309', 'Pipe wrench 48\"', '', '0.00', 'undefined', '', 18, 0, 44, 1, '', '0.000', '0.00', '', '', 0, '1928.00', '2150.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:14:48', '', '', 0, 0, 3),
(379, 'P00310', 'Socket Set 24 Pcs (6PT) 1/2\"  Red', '', '0.00', 'undefined', '', 55, 0, 64, 1, '', '0.000', '0.00', '', '', 0, '1800.00', '1680.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 05:49:23', '', '', 0, 0, 3),
(380, 'P00311', 'Socket Set 24 Pcs (12PT) 1/2\"  Red', '', '0.00', 'undefined', '', 55, 0, 64, 1, '', '0.000', '0.00', '', '', 0, '1800.00', '1680.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 05:49:55', '', '', 0, 0, 3),
(381, 'P00312', 'C. Spanner set (8-24mm) 14Pcs', '', '0.00', 'undefined', '', 37, 0, 61, 1, '', '0.000', '0.00', '', '', 0, '900.00', '950.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 05:53:06', '', '', 0, 0, 3),
(382, 'P00313', 'C. Spanner set (8-24mm) 14Pcs', '', '0.00', 'undefined', '', 37, 0, 57, 1, '', '0.000', '0.00', '', '', 0, '650.00', '670.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 05:54:16', '', '', 0, 0, 3),
(383, 'P00314', 'C. Spanner set (6-24mm) 12Pcs', '', '0.00', 'undefined', '', 37, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '1151.00', '1220.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 05:55:35', '', '', 0, 0, 3),
(384, 'P00315', 'C. Spanner set (6-32mm) 12Pcs', '', '0.00', 'undefined', '', 37, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '1776.00', '1880.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 05:56:16', '', '', 0, 0, 3),
(385, 'P00316', 'C. Spanner set (6-32mm) 26Pcs', '', '0.00', 'undefined', '', 37, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '3890.00', '4150.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 05:57:01', '', '', 0, 0, 3),
(386, 'P00317', 'R. Spanner set (3/8\"-1\") 6Pcs', '', '0.00', 'undefined', '', 37, 0, 15, 1, '', '0.000', '0.00', '', '', 0, '600.00', '630.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 05:58:50', '', '', 0, 0, 3),
(389, 'P00318', 'D. Spanner set (6-32mm) 12Pcs', '', '0.00', 'undefined', '', 37, 0, 62, 1, '', '0.000', '0.00', '', '', 0, '1117.00', '1180.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 06:01:02', '', '', 0, 0, 3),
(390, 'P00319', 'D. Spanner set (6-22mm) 8Pcs', '', '0.00', 'undefined', '', 37, 0, 14, 1, '', '0.000', '0.00', '', '', 0, '555.00', '680.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-12 06:02:04', '', '', 0, 0, 3),
(391, 'P00320', 'Dally 8 x 9', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '45.00', '50.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:03:53', '', '', 0, 0, 3),
(392, 'P00321', 'Dally 10 x 11', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '51.00', '60.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:04:29', '', '', 0, 0, 3),
(393, 'P00322', 'Dally 12 x 13', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '56.00', '60.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:05:14', '', '', 0, 0, 3),
(394, 'P00323', 'Dally 14 x 15', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '71.00', '76.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:05:52', '', '', 0, 0, 3),
(395, 'P00324', 'Dally 20 x 22', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '122.00', '1150.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:06:35', '', '', 0, 0, 3),
(396, 'P00325', 'Dally 21 x 23', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '145.00', '155.00', '0.00', '0.00', '1', 0, 'a', 'Admin', '2019-03-12 06:07:08', '', '', 0, 0, 3),
(397, 'P00326', 'Dally 24 x 27', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '205.00', '215.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:07:52', '', '', 0, 0, 3),
(398, 'P00327', 'Dally 25 x 28', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '205.00', '215.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:08:41', '', '', 0, 0, 3),
(399, 'P00328', 'Dally 27 x 30', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '232.00', '240.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:09:31', '', '', 0, 0, 3),
(400, 'P00329', 'Dally 30 x 32', '', '0.00', 'undefined', '', 70, 0, 63, 1, '', '0.000', '0.00', '', '', 0, '272.00', '280.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:10:42', '', '', 0, 0, 3),
(401, 'P00330', 'WSME-350,AC/DC,TIG WELDING(PULSE FUNCTION) WITH ACCESSORIES', '', '0.00', 'undefined', '', 4, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '40964.00', '75000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:43:47', '', '', 0, 0, 1),
(402, 'P00331', 'WSME-500,AC/DC,TIG WELDING(PULSE FUNCTION) WITH ACCESSORIES', '', '0.00', 'undefined', '', 4, 0, 1, 1, '', '0.000', '0.00', '', '', 0, '41454.00', '90000.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:44:54', '', '', 0, 0, 1),
(405, 'P00332', 'Spray Gun Steel Body ', '', '0.00', 'undefined', '', 45, 0, 65, 1, '', '0.000', '0.00', '', '', 0, '2200.00', '2250.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:50:15', '', '', 0, 0, 3),
(406, 'P00333', 'Spray Gun Plastic Body 120', '', '0.00', 'undefined', '', 45, 0, 65, 1, '', '0.000', '0.00', '', '', 0, '1600.00', '1700.00', '0.00', '406.00', '1', 1, 'a', 'Admin', '2019-03-12 06:50:49', 'Admin', '2019-03-12 06:51:46', 0, 0, 3),
(407, 'P00334', 'Spray Gun Plastic Body 170', '', '0.00', 'undefined', '', 45, 0, 65, 1, '', '0.000', '0.00', '', '', 0, '1700.00', '1800.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:51:29', '', '', 0, 0, 3),
(408, 'P00335', 'Sprit Level 9\" Magnetic 227mm', '', '0.00', 'undefined', '', 71, 0, 67, 1, '', '0.000', '0.00', '', '', 0, '170.00', '190.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:55:50', '', '', 0, 0, 3),
(409, 'P00336', 'Sprit Level 12\" Magnetic 779-40mm', '', '0.00', 'undefined', '', 71, 0, 67, 1, '', '0.000', '0.00', '', '', 0, '363.00', '385.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:57:55', '', '', 0, 0, 3),
(410, 'P00337', 'Sprit Level 16\" Magnetic 779-40mm', '', '0.00', 'undefined', '', 71, 0, 67, 1, '', '0.000', '0.00', '', '', 0, '426.00', '445.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:58:46', '', '', 0, 0, 3),
(411, 'P00338', 'Sprit Level 20\" Magnetic 779-40mm', '', '0.00', 'undefined', '', 71, 0, 67, 1, '', '0.000', '0.00', '', '', 0, '463.00', '485.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 06:59:31', '', '', 0, 0, 3),
(412, 'P00339', 'Sprit Level 24\" Magnetic 779-40mm', '', '0.00', 'undefined', '', 71, 0, 67, 1, '', '0.000', '0.00', '', '', 0, '491.00', '510.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 07:00:14', '', '', 0, 0, 3),
(413, 'P00340', 'Impact Wrench APB-12', '', '0.00', 'undefined', '', 28, 0, 25, 1, '', '0.000', '0.00', '', '', 0, '3132.00', '3250.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 07:03:17', '', '', 0, 0, 3),
(414, 'P00341', 'Impact Wrench AT 5004 SG', '', '0.00', 'undefined', '', 28, 0, 25, 1, '', '0.000', '0.00', '', '', 0, '3600.00', '3700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-12 07:04:06', '', '', 0, 0, 3),
(415, 'P00342', 'L-Wrench No-10', '', '0.00', 'undefined', '', 72, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '78.00', '90.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:14:33', '', '', 0, 0, 3),
(416, 'P00343', 'L-Wrench No-12', '', '0.00', 'undefined', '', 72, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '88.00', '100.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:15:16', '', '', 0, 0, 3),
(417, 'P00344', 'L-Wrench No-21', '', '0.00', 'undefined', '', 72, 0, 11, 1, '', '0.000', '0.00', '', '', 0, '120.00', '130.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:15:56', '', '', 0, 0, 3),
(418, 'P00345', 'Cup Brush', '', '0.00', 'undefined', '', 73, 0, 68, 1, '', '0.000', '0.00', '', '', 0, '78.00', '85.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:19:20', '', '', 0, 0, 3),
(419, 'P00346', 'Breaker Machine FF-15', '', '0.00', 'undefined', '', 35, 0, 25, 1, '', '0.000', '0.00', '', '', 0, '13200.00', '16300.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:26:46', '', '', 0, 0, 3),
(420, 'P00347', 'Car Wash', '', '0.00', 'undefined', '', 74, 0, 69, 1, '', '0.000', '0.00', '', '', 0, '5000.00', '5200.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:31:02', '', '', 0, 0, 3),
(421, 'P00348', 'Drill Machine (White) JI2-SD05-13A', '', '0.00', 'undefined', '', 17, 0, 42, 1, '', '0.000', '0.00', '', '', 0, '1600.00', '1700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:36:50', '', '', 0, 0, 3),
(422, 'P00349', 'Drill Machine (Yellow) JI2-SD05-13A', '', '0.00', 'undefined', '', 17, 0, 42, 1, '', '0.000', '0.00', '', '', 0, '1600.00', '1700.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:37:22', '', '', 0, 0, 3),
(423, 'P00350', 'Chain Saw 02-405', '', '0.00', 'undefined', '', 58, 0, 25, 1, '', '0.000', '0.00', '', '', 0, '6160.00', '6800.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:40:13', '', '', 0, 0, 3),
(424, 'P00351', 'Welding Glass Black', '', '0.00', 'undefined', '', 75, 0, 70, 1, '', '0.000', '0.00', '', '', 0, '5.25', '6.50', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:43:07', '', '', 0, 0, 3),
(425, 'P00352', 'Drill Chuck 13mm', '', '0.00', 'undefined', '', 76, 0, 71, 1, '', '0.000', '0.00', '', '', 0, '105.00', '115.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:45:54', '', '', 0, 0, 3),
(426, 'P00353', 'Cup Grinding 4\" 120G', '', '0.00', 'undefined', '', 77, 0, 72, 1, '', '0.000', '0.00', '', '', 0, '175.00', '190.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:50:16', '', '', 0, 0, 3),
(427, 'P00354', '40\" Scale', '', '0.00', 'undefined', '', 78, 0, 73, 1, '', '0.000', '0.00', '', '', 0, '595.00', '541.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 02:55:21', '', '', 0, 0, 3),
(428, 'P00355', 'Nozzle Cleaner Set', '', '0.00', 'undefined', '', 79, 0, 70, 1, '', '0.000', '0.00', '', '', 0, '45.00', '55.00', '0.00', '0.00', '1', 2, 'a', 'Admin', '2019-03-13 03:50:42', '', '', 0, 0, 3),
(429, 'P00356', 'Metal Chalk', '', '0.00', 'undefined', '', 80, 0, 70, 1, '', '0.000', '0.00', '', '', 0, '7.00', '8.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 03:51:25', '', '', 0, 0, 3),
(430, 'P00357', 'Thickness Gage 0-10mm', '', '0.00', 'undefined', '', 81, 0, 73, 1, '', '0.000', '0.00', '', '', 0, '2535.00', '2800.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 03:53:22', '', '', 0, 0, 3),
(431, 'P00358', 'Steel Brush', '', '0.00', 'undefined', '', 82, 0, 74, 1, '', '0.000', '0.00', '', '', 0, '315.00', '340.00', '0.00', '431.00', '1', 1, 'a', 'Admin', '2019-03-13 03:58:39', 'Admin', '2019-03-13 04:01:17', 0, 0, 3),
(432, 'P00359', 'Steel Tape 173', '', '0.00', 'undefined', '', 83, 0, 72, 1, '', '0.000', '0.00', '', '', 0, '360.00', '380.00', '0.00', '0.00', '1', 5, 'a', 'Admin', '2019-03-13 04:01:58', '', '', 0, 0, 3),
(433, 'P00360', 'Poland Blade', '', '0.00', 'undefined', '', 49, 0, 75, 1, '', '0.000', '0.00', '', '', 0, '475.00', '485.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 04:05:31', '', '', 0, 0, 3),
(434, 'P00361', '8\" Pliers', '', '0.00', 'undefined', '', 84, 0, 76, 1, '', '0.000', '0.00', '', '', 0, '115.00', '25.00', '0.00', '0.00', '1', 1, 'a', 'Admin', '2019-03-13 04:07:12', '', '', 0, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productcategory`
--

CREATE TABLE `tbl_productcategory` (
  `ProductCategory_SlNo` int(11) NOT NULL,
  `ProductCategory_Name` varchar(150) NOT NULL,
  `ProductCategory_Description` varchar(300) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) NOT NULL,
  `AddTime` varchar(30) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(30) NOT NULL,
  `category_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_productcategory`
--

INSERT INTO `tbl_productcategory` (`ProductCategory_SlNo`, `ProductCategory_Name`, `ProductCategory_Description`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `category_branchid`) VALUES
(1, 'AC ARC WELDING (COIL TYPE) ', '', 'a', 'Admin', '2019-03-06 11:38:48', 'Admin', '2019-03-06 11:39:21', 1),
(2, 'INVERTER DC ARC WELDING ', '', 'a', 'Admin', '2019-03-06 11:40:14', '', '', 1),
(3, 'INVERTER DC TIG/ARC  WELDING ', '', 'a', 'Admin', '2019-03-06 11:40:42', '', '', 1),
(4, 'WSME AC/DC WELDING ', '', 'a', 'Admin', '2019-03-06 11:41:32', '', '', 1),
(5, 'MIG/NBC WELDING ', '', 'a', 'Admin', '2019-03-06 11:41:53', '', '', 1),
(6, 'SPOT WELDING ', '', 'a', 'Admin', '2019-03-06 11:42:04', '', '', 1),
(7, 'AIR PLASMA CUTTER', '', 'a', 'Admin', '2019-03-06 11:42:23', '', '', 1),
(8, 'BATTERY CHARGER ', '', 'a', 'Admin', '2019-03-06 11:52:47', '', '', 1),
(9, 'BENCH GRINDER', '', 'a', 'Admin', '2019-03-06 12:00:36', '', '', 1),
(10, 'MOTOR CUT OFF SAW', '', 'a', 'Admin', '2019-03-06 12:01:19', '', '', 1),
(11, 'POWER TOOLS ', '', 'a', 'Admin', '2019-03-06 12:03:26', '', '', 1),
(12, 'ABRASIVES', '', 'a', 'Admin', '2019-03-06 12:05:00', '', '', 1),
(13, 'Acetylene meter', '', 'a', 'Admin', '2019-03-06 12:22:48', '', '', 3),
(14, 'Oxygen meter', '', 'a', 'Admin', '2019-03-06 12:23:00', '', '', 3),
(15, 'Argon meter', '', 'a', 'Admin', '2019-03-06 12:23:20', '', '', 3),
(16, 'Angle grinder', '', 'a', 'Admin', '2019-03-06 12:23:54', '', '', 3),
(17, 'Drill machine', '', 'a', 'Admin', '2019-03-06 12:24:24', '', '', 3),
(18, 'Pipe wrench', '', 'a', 'Admin', '2019-03-06 12:24:45', '', '', 3),
(19, 'Chain wrench', '', 'a', 'Admin', '2019-03-06 12:24:54', '', '', 3),
(20, 'Chain block', '', 'a', 'Admin', '2019-03-06 12:25:09', '', '', 3),
(21, 'Trimmer', '', 'a', 'Admin', '2019-03-06 12:26:41', '', '', 3),
(22, 'Cut off machine', '', 'a', 'Admin', '2019-03-06 12:28:06', '', '', 3),
(23, 'Circular saw', '', 'a', 'Admin', '2019-03-06 12:28:25', '', '', 3),
(24, 'Router machine', '', 'a', 'Admin', '2019-03-06 12:28:46', '', '', 3),
(25, 'Planer machine', '', 'a', 'Admin', '2019-03-06 12:29:01', '', '', 3),
(26, 'Heat gun', '', 'a', 'Admin', '2019-03-06 12:29:35', '', '', 3),
(27, 'Miter saw', '', 'a', 'Admin', '2019-03-06 12:29:54', '', '', 3),
(28, 'Impact wrench', '', 'a', 'Admin', '2019-03-06 12:32:37', '', '', 3),
(29, 'Marble cutter', '', 'a', 'Admin', '2019-03-06 12:32:53', '', '', 3),
(30, 'Polisher machine', '', 'a', 'Admin', '2019-03-06 12:33:20', '', '', 3),
(31, 'Sander machine', '', 'a', 'Admin', '2019-03-06 12:34:02', '', '', 3),
(32, 'Die grinder', '', 'a', 'Admin', '2019-03-06 12:34:19', '', '', 3),
(33, 'Scissor', '', 'a', 'Admin', '2019-03-06 12:34:44', '', '', 3),
(34, 'Jig saw', '', 'a', 'Admin', '2019-03-06 12:34:56', '', '', 3),
(35, 'Breaker', '', 'a', 'Admin', '2019-03-06 12:35:16', '', '', 3),
(36, 'Combination', '', 'a', 'Admin', '2019-03-06 12:37:34', '', '', 3),
(37, 'Spanner set', '', 'a', 'Admin', '2019-03-06 12:37:52', '', '', 3),
(38, 'Packing machine', '', 'a', 'Admin', '2019-03-06 12:38:27', '', '', 3),
(39, 'Sly wrench', '', 'a', 'Admin', '2019-03-06 01:08:06', '', '', 3),
(40, 'Cutting torch', '', 'a', 'Admin', '2019-03-06 01:08:39', '', '', 3),
(41, 'Welding torch', '', 'a', 'Admin', '2019-03-06 01:08:54', '', '', 3),
(42, 'Holder', '', 'a', 'Admin', '2019-03-06 01:09:10', '', '', 3),
(43, 'Oil can', '', 'a', 'Admin', '2019-03-06 01:09:24', '', '', 3),
(44, 'Varnier', '', 'a', 'Admin', '2019-03-06 01:09:35', '', '', 3),
(45, 'Thinner gun', '', 'a', 'Admin', '2019-03-06 01:09:54', '', '', 3),
(46, 'Grease gun', '', 'a', 'Admin', '2019-03-06 01:10:06', '', '', 3),
(47, 'Bolt cutter', '', 'a', 'Admin', '2019-03-06 01:10:46', '', '', 3),
(48, 'Ring spanner', '', 'a', 'Admin', '2019-03-06 01:12:23', '', '', 3),
(49, 'Circular saw blade', '', 'a', 'Admin', '2019-03-06 01:13:17', '', '', 3),
(50, 'Diamond Cutter', '', 'a', 'Admin', '2019-03-06 01:14:00', 'Admin', '2019-03-11 11:18:09', 3),
(51, 'Hammer', '', 'a', 'Admin', '2019-03-06 01:14:13', '', '', 3),
(52, 'Bench vice', '', 'a', 'Admin', '2019-03-06 01:14:29', '', '', 3),
(53, 'Hydraulic Jack', '', 'a', 'Admin', '2019-03-06 01:14:43', '', '', 3),
(54, 'Blower', '', 'a', 'Admin', '2019-03-06 01:15:01', '', '', 3),
(55, 'Socket set', '', 'a', 'Admin', '2019-03-07 10:17:53', '', '', 3),
(56, 'Welding Cable', '', 'a', 'Admin', '2019-03-07 10:18:44', '', '', 3),
(57, 'Crimping (H.C.P)', '', 'a', 'Admin', '2019-03-07 10:20:16', '', '', 3),
(58, 'Chain saw', '', 'a', 'Admin', '2019-03-09 02:44:55', '', '', 3),
(59, 'Bench Grinder', '', 'a', 'Admin', '2019-03-10 12:12:47', '', '', 3),
(60, 'Water Paper', '', 'a', 'Admin', '2019-03-10 12:19:20', '', '', 3),
(61, 'Bag Closer', '', 'a', 'Admin', '2019-03-10 03:53:38', '', '', 3),
(62, 'Hose pipe', '', 'a', 'Admin', '2019-03-10 04:19:43', '', '', 3),
(63, 'Allen key set', '', 'a', 'Admin', '2019-03-11 10:37:16', '', '', 3),
(64, 'Cable Punch', '', 'a', 'Admin', '2019-03-11 10:46:27', '', '', 3),
(65, 'Carbide Tips', '', 'a', 'Admin', '2019-03-11 10:55:00', '', '', 3),
(66, 'Cutting Nozzle', '', 'a', 'Admin', '2019-03-11 11:13:18', '', '', 3),
(67, 'Drill Bit Set', '', 'a', 'Admin', '2019-03-11 11:27:34', '', '', 3),
(68, 'aaa', '', 'a', 'testProductAdmin', '2019-03-11 02:49:52', '', '', 2),
(69, 'Oil pump', '', 'a', 'Admin', '2019-03-11 06:47:36', '', '', 3),
(70, 'Dally spanner', '', 'a', 'Admin', '2019-03-12 05:19:33', 'Admin', '2019-03-12 05:22:00', 3),
(71, 'Sprit level', '', 'a', 'Admin', '2019-03-12 06:53:22', '', '', 3),
(72, 'L-Wrench', '', 'a', 'Admin', '2019-03-13 02:10:10', '', '', 3),
(73, 'Cup Brush', '', 'a', 'Admin', '2019-03-13 02:18:27', '', '', 3),
(74, 'Car Wash', '', 'a', 'Admin', '2019-03-13 02:30:10', '', '', 3),
(75, 'Welding glass', '', 'a', 'Admin', '2019-03-13 02:42:09', '', '', 3),
(76, 'Drill Chuck', '', 'a', 'Admin', '2019-03-13 02:44:41', '', '', 3),
(77, 'Cup Grinding', '', 'a', 'Admin', '2019-03-13 02:48:46', '', '', 3),
(78, '-', '', 'a', 'Admin', '2019-03-13 02:50:59', '', '', 3),
(79, 'Nozzle Cleaner', '', 'a', 'Admin', '2019-03-13 03:48:49', '', '', 3),
(80, 'Metal Chalk', '', 'a', 'Admin', '2019-03-13 03:49:04', '', '', 3),
(81, 'Thickness Gage', '', 'a', 'Admin', '2019-03-13 03:52:13', '', '', 3),
(82, 'Steel Brush', '', 'a', 'Admin', '2019-03-13 03:57:37', '', '', 3),
(83, 'Steel Tape', '', 'a', 'Admin', '2019-03-13 03:59:00', '', '', 3),
(84, 'Pliers', '', 'a', 'Admin', '2019-03-13 04:06:28', '', '', 3),
(85, 'Microw Meter', '', 'a', 'Admin', '2019-03-13 04:08:10', '', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasedetails`
--

CREATE TABLE `tbl_purchasedetails` (
  `PurchaseDetails_SlNo` int(11) NOT NULL,
  `PurchaseMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `PurchaseDetails_TotalQuantity` int(11) NOT NULL,
  `PurchaseDetail_ReceiveQuantity` int(11) NOT NULL,
  `PurchaseDetails_Rate` decimal(18,2) NOT NULL,
  `purchase_cost` decimal(18,2) NOT NULL,
  `PurchaseDetails_Unit` varchar(20) DEFAULT NULL,
  `Purchase_GrossWeight` decimal(18,3) DEFAULT NULL,
  `Purchase_NetWeight` decimal(18,3) DEFAULT NULL,
  `PurchaseDetails_ExpireDate` datetime NOT NULL,
  `PurchaseDetails_Discount` decimal(18,2) NOT NULL,
  `PurchaseDetails_Tax` decimal(18,2) NOT NULL,
  `PurchaseDetails_Freight` decimal(18,2) NOT NULL,
  `PurchaseDetails_TotalAmount` decimal(18,2) NOT NULL,
  `Purchasedetails_store` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseDetails_branchID` int(11) NOT NULL,
  `PackName` varchar(200) NOT NULL,
  `PackPice` decimal(18,2) NOT NULL,
  `Pack_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasedetails`
--

INSERT INTO `tbl_purchasedetails` (`PurchaseDetails_SlNo`, `PurchaseMaster_IDNo`, `Product_IDNo`, `PurchaseDetails_TotalQuantity`, `PurchaseDetail_ReceiveQuantity`, `PurchaseDetails_Rate`, `purchase_cost`, `PurchaseDetails_Unit`, `Purchase_GrossWeight`, `Purchase_NetWeight`, `PurchaseDetails_ExpireDate`, `PurchaseDetails_Discount`, `PurchaseDetails_Tax`, `PurchaseDetails_Freight`, `PurchaseDetails_TotalAmount`, `Purchasedetails_store`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseDetails_branchID`, `PackName`, `PackPice`, `Pack_qty`) VALUES
(5, 4, 4, 10, 0, '21384.00', '0.00', 'PCS', '0.000', '0.000', '0000-00-00 00:00:00', '0.00', '0.00', '0.00', '0.00', '1', '', NULL, NULL, NULL, NULL, 1, '', '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchaseinventory`
--

CREATE TABLE `tbl_purchaseinventory` (
  `PurchaseInventory_SlNo` int(11) NOT NULL,
  `purchProduct_IDNo` int(11) NOT NULL,
  `PurchaseInventory_TotalQuantity` int(11) NOT NULL,
  `PurchaseInventory_ReceiveQuantity` int(11) NOT NULL,
  `PurchaseInventory_ReturnQuantity` int(11) NOT NULL,
  `PurchaseInventory_DamageQuantity` int(11) NOT NULL,
  `PurchaseInventory_Store` varchar(50) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseInventory_packqty` decimal(18,2) NOT NULL,
  `PurchaseInventory_packname` varchar(200) NOT NULL,
  `PurchaseInventory_returnqty` int(11) NOT NULL,
  `PurchaseInventory_brunchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchaseinventory`
--

INSERT INTO `tbl_purchaseinventory` (`PurchaseInventory_SlNo`, `purchProduct_IDNo`, `PurchaseInventory_TotalQuantity`, `PurchaseInventory_ReceiveQuantity`, `PurchaseInventory_ReturnQuantity`, `PurchaseInventory_DamageQuantity`, `PurchaseInventory_Store`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseInventory_packqty`, `PurchaseInventory_packname`, `PurchaseInventory_returnqty`, `PurchaseInventory_brunchid`) VALUES
(4, 4, 10, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '0.00', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasemaster`
--

CREATE TABLE `tbl_purchasemaster` (
  `PurchaseMaster_SlNo` int(11) NOT NULL,
  `Supplier_SlNo` int(11) NOT NULL,
  `Employee_SlNo` int(11) NOT NULL,
  `PurchaseMaster_InvoiceNo` varchar(50) NOT NULL,
  `PurchaseMaster_OrderDate` date NOT NULL,
  `PurchaseMaster_PurchaseFor` varchar(50) NOT NULL,
  `PurchaseMaster_Description` longtext NOT NULL,
  `PurchaseMaster_PurchaseType` varchar(50) NOT NULL,
  `PurchaseMaster_TotalAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_DiscountAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_Tax` decimal(18,2) NOT NULL,
  `PurchaseMaster_Freight` decimal(18,2) NOT NULL,
  `PurchaseMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_PaidAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_DueAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_ReceiveDate` datetime NOT NULL,
  `PurchaseMaster_Status` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseMaster_GUID` varchar(64) NOT NULL,
  `PurchaseMaster_BranchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasemaster`
--

INSERT INTO `tbl_purchasemaster` (`PurchaseMaster_SlNo`, `Supplier_SlNo`, `Employee_SlNo`, `PurchaseMaster_InvoiceNo`, `PurchaseMaster_OrderDate`, `PurchaseMaster_PurchaseFor`, `PurchaseMaster_Description`, `PurchaseMaster_PurchaseType`, `PurchaseMaster_TotalAmount`, `PurchaseMaster_DiscountAmount`, `PurchaseMaster_Tax`, `PurchaseMaster_Freight`, `PurchaseMaster_SubTotalAmount`, `PurchaseMaster_PaidAmount`, `PurchaseMaster_DueAmount`, `PurchaseMaster_ReceiveDate`, `PurchaseMaster_Status`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseMaster_GUID`, `PurchaseMaster_BranchID`) VALUES
(4, 8, 0, 'CP-001', '2019-03-13', '1', '', '', '213840.00', '0.00', '0.00', '0.00', '213840.00', '213840.00', '0.00', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-03-13 01:28:23', NULL, NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturn`
--

CREATE TABLE `tbl_purchasereturn` (
  `PurchaseReturn_SlNo` int(11) NOT NULL,
  `PurchaseMaster_InvoiceNo` varchar(50) NOT NULL,
  `Supplier_IDdNo` int(11) NOT NULL,
  `PurchaseReturn_ReturnDate` date NOT NULL,
  `PurchaseReturn_ReturnQuantity` int(11) NOT NULL,
  `PurchaseReturn_ReturnAmount` decimal(18,2) NOT NULL,
  `PurchaseReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturn_brunchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturndetails`
--

CREATE TABLE `tbl_purchasereturndetails` (
  `PurchaseReturnDetails_SlNo` int(11) NOT NULL,
  `PurchaseReturn_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetails_ReturnDate` date NOT NULL,
  `PurchaseReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetails_ReceiveQuantity` int(11) NOT NULL,
  `PurchaseReturnDetails_ReturnQuantity` int(11) NOT NULL,
  `PurchaseReturnDetails_ReturnAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturnDetails_brachid` int(11) NOT NULL,
  `PurchaseReturnDetails_pacQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotaion_customer`
--

CREATE TABLE `tbl_quotaion_customer` (
  `quotation_customer_id` int(11) NOT NULL,
  `customer_name` char(50) NOT NULL,
  `contact_number` varchar(35) NOT NULL,
  `customer_address` text NOT NULL,
  `quation_customer_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_details`
--

CREATE TABLE `tbl_quotation_details` (
  `SaleDetails_SlNo` int(11) NOT NULL,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` int(11) NOT NULL,
  `Purchase_Rate` decimal(18,2) DEFAULT NULL,
  `SaleDetails_Rate` decimal(18,2) NOT NULL,
  `SaleDetails_unit` varchar(20) NOT NULL,
  `SaleDetails_Discount` decimal(18,2) NOT NULL,
  `SaleDetails_Tax` decimal(18,2) NOT NULL,
  `SaleDetails_Freight` decimal(18,2) NOT NULL,
  `SaleDetails_TotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `packageName` varchar(200) NOT NULL,
  `packSellPrice` decimal(18,2) NOT NULL,
  `SeleDetails_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_master`
--

CREATE TABLE `tbl_quotation_master` (
  `SaleMaster_SlNo` int(11) NOT NULL,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SalseCustomer_IDNo` int(11) DEFAULT NULL,
  `SaleMaster_SaleDate` date NOT NULL,
  `SaleMaster_Description` longtext,
  `SaleMaster_SaleType` varchar(50) NOT NULL,
  `SaleMaster_TotalSaleAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDiscountAmount` decimal(18,2) NOT NULL,
  `SaleMaster_RewordDiscount` decimal(18,2) NOT NULL,
  `SaleMaster_TaxAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Freight` decimal(18,2) NOT NULL,
  `SaleMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `SaleMaster_PaidAmount` decimal(18,2) NOT NULL,
  `checkamount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `check_details` varchar(255) NOT NULL,
  `SaleMaster_DueAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDue` decimal(18,2) NOT NULL DEFAULT '0.00',
  `Status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleMaster_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saledetails`
--

CREATE TABLE `tbl_saledetails` (
  `SaleDetails_SlNo` int(11) NOT NULL,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` int(11) NOT NULL,
  `Purchase_Rate` decimal(18,2) DEFAULT NULL,
  `SaleDetails_Rate` decimal(18,2) NOT NULL,
  `SaleDetails_unit` varchar(20) NOT NULL,
  `SaleDetails_Discount` decimal(18,2) NOT NULL,
  `Discount_amount` decimal(18,2) DEFAULT NULL,
  `SaleDetails_Tax` decimal(18,2) NOT NULL,
  `SaleDetails_Freight` decimal(18,2) NOT NULL,
  `SaleDetails_TotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `packageName` varchar(200) NOT NULL,
  `packSellPrice` decimal(18,2) NOT NULL,
  `SeleDetails_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saleinventory`
--

CREATE TABLE `tbl_saleinventory` (
  `SaleInventory_SlNo` int(11) NOT NULL,
  `sellProduct_IdNo` int(11) NOT NULL,
  `SaleInventory_TotalQuantity` int(11) NOT NULL,
  `SaleInventory_ReceiveQuantity` int(11) NOT NULL,
  `SaleInventory_ReturnQuantity` int(11) NOT NULL,
  `SaleInventory_DamageQuantity` int(11) NOT NULL,
  `SaleInventory_Store` varchar(50) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleInventory_packname` varchar(200) NOT NULL,
  `SaleInventory_qty` int(11) NOT NULL,
  `SaleInventory_returnqty` int(11) NOT NULL,
  `SaleInventory_brunchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_saleinventory`
--

INSERT INTO `tbl_saleinventory` (`SaleInventory_SlNo`, `sellProduct_IdNo`, `SaleInventory_TotalQuantity`, `SaleInventory_ReceiveQuantity`, `SaleInventory_ReturnQuantity`, `SaleInventory_DamageQuantity`, `SaleInventory_Store`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleInventory_packname`, `SaleInventory_qty`, `SaleInventory_returnqty`, `SaleInventory_brunchid`) VALUES
(2, 4, 0, 0, 0, 0, '1', 'Admin', '2019-03-13 01:29:15', 'Admin', '2019-03-13 01:35:02', '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturn`
--

CREATE TABLE `tbl_salereturn` (
  `SaleReturn_SlNo` int(11) NOT NULL,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SaleReturn_ReturnDate` date NOT NULL,
  `SaleReturn_ReturnQuantity` int(11) NOT NULL,
  `SaleReturn_ReturnAmount` decimal(18,2) NOT NULL,
  `SaleReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturn_brunchId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturndetails`
--

CREATE TABLE `tbl_salereturndetails` (
  `SaleReturnDetails_SlNo` int(11) NOT NULL,
  `SaleReturn_IdNo` int(11) NOT NULL,
  `SaleReturnDetails_ReturnDate` date NOT NULL,
  `SaleReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `SaleReturnDetails_SaleQuantity` int(11) NOT NULL,
  `SaleReturnDetails_ReturnQuantity` int(11) NOT NULL,
  `SaleReturnDetails_ReturnAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturnDetails_brunchID` int(11) NOT NULL,
  `SaleReturnDetails_Qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salesmaster`
--

CREATE TABLE `tbl_salesmaster` (
  `SaleMaster_SlNo` int(11) NOT NULL,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SalseCustomer_IDNo` int(11) DEFAULT NULL,
  `SaleMaster_SaleDate` date NOT NULL,
  `SaleMaster_Description` longtext,
  `SaleMaster_SaleType` varchar(50) NOT NULL,
  `payment_type` varchar(50) DEFAULT 'Cash',
  `SaleMaster_TotalSaleAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDiscountAmount` decimal(18,2) NOT NULL,
  `SaleMaster_RewordDiscount` decimal(18,2) NOT NULL,
  `SaleMaster_TaxAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Freight` decimal(18,2) NOT NULL,
  `SaleMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `SaleMaster_PaidAmount` decimal(18,2) NOT NULL,
  `SaleMaster_DueAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDue` double(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleMaster_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salesmaster`
--

INSERT INTO `tbl_salesmaster` (`SaleMaster_SlNo`, `SaleMaster_InvoiceNo`, `SalseCustomer_IDNo`, `SaleMaster_SaleDate`, `SaleMaster_Description`, `SaleMaster_SaleType`, `payment_type`, `SaleMaster_TotalSaleAmount`, `SaleMaster_TotalDiscountAmount`, `SaleMaster_RewordDiscount`, `SaleMaster_TaxAmount`, `SaleMaster_Freight`, `SaleMaster_SubTotalAmount`, `SaleMaster_PaidAmount`, `SaleMaster_DueAmount`, `SaleMaster_TotalDue`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleMaster_branchid`) VALUES
(3, 'CS-001', 1, '2019-03-13', '', '1', 'Cash', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '35000.00', '-35000.00', 0.00, '', 'Admin', '2019-03-13 01:29:15', NULL, NULL, 1),
(4, 'CS-002', 15, '2019-03-13', '', '1', 'Cash', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '35000.00', '-35000.00', 0.00, '', 'Admin', '2019-03-13 01:33:40', NULL, NULL, 1),
(5, 'CS-003', 1, '2019-03-13', '', '1', 'Cash', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '35000.00', '-35000.00', 0.00, '', 'Admin', '2019-03-13 01:35:02', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `Supplier_SlNo` int(11) NOT NULL,
  `Supplier_Code` varchar(50) NOT NULL,
  `Supplier_Name` varchar(150) NOT NULL,
  `Supplier_Type` varchar(50) NOT NULL,
  `Supplier_Phone` varchar(50) NOT NULL,
  `Supplier_Mobile` varchar(15) NOT NULL,
  `Supplier_Email` varchar(50) NOT NULL,
  `Supplier_OfficePhone` varchar(50) NOT NULL,
  `Supplier_Address` varchar(300) NOT NULL,
  `District_SlNo` int(11) NOT NULL,
  `Country_SlNo` int(11) NOT NULL,
  `Supplier_Web` varchar(150) NOT NULL,
  `previous_due` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Supplier_brinchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`Supplier_SlNo`, `Supplier_Code`, `Supplier_Name`, `Supplier_Type`, `Supplier_Phone`, `Supplier_Mobile`, `Supplier_Email`, `Supplier_OfficePhone`, `Supplier_Address`, `District_SlNo`, `Country_SlNo`, `Supplier_Web`, `previous_due`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Supplier_brinchid`) VALUES
(1, 'S01', 'General Supplier', 'G', '', '-', '', '-', '-', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2018-09-05 06:11:05', NULL, NULL, 0),
(8, 'S02', 'CASSIE', 'local', '', '.', '.', '', '', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 12:32:53', NULL, NULL, 1),
(9, 'S09', 'SANDY', 'local', '', '.', '.', '', '', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 12:33:28', NULL, NULL, 1),
(10, 'S010', 'JHON', 'local', '', '.', '', '', '', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 12:33:53', NULL, NULL, 1),
(11, 'S11', 'MR YEA', 'local', '', '.', '', '', '', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 12:34:50', NULL, NULL, 1),
(12, 'S12', 'Mabud Trading', 'local', '', '031-633153', '', '', '1465/4, Cheman Building, Asadgonj, Chittagong.', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:28:27', NULL, NULL, 3),
(13, 'S13', 'Kamrul Trading', 'local', '', '01787-928135', '', '', '198-202, Nawabpur Road, Dhaka-1100', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:31:10', NULL, NULL, 3),
(14, 'S14', 'Afsar Enterprise', 'local', '', '01710-990347', '', '', '218, Nawabpur Road (Fazlul Rahman Plaza), Dhaka-1100', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:34:35', NULL, NULL, 3),
(15, 'S15', 'Jafree Traders', 'local', '', '01711-325119', '', '', '212, Jubilee Road, Chittagong.', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:36:01', NULL, NULL, 3),
(16, 'S16', 'Shuruchi', 'local', '', ' 01712-072425', '', '', '214, Jubilee Road, Chittagong.', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:38:21', NULL, NULL, 3),
(17, 'S17', 'Ken power tools.', 'local', '', '01730-330992', '', '', '198-202, Nawabpur Road, Dhaka-1100', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:40:00', NULL, NULL, 3),
(18, 'S18', 'Dongcheng power tools.', 'local', '', '01730-330992', '', '', '198-202, Nawabpur Road, Dhaka-1100', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:41:39', NULL, NULL, 3),
(19, 'S19', 'HW power tools', 'local', '', '01730-330992', '', '', '198-202, Nawabpur Road, Dhaka-1100', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:43:11', NULL, NULL, 3),
(20, 'S20', 'Kaiser Trade International', 'local', '', '01731-467662', '', '', '198-202, Nawabpur Road, Dhaka-1100', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:47:40', NULL, NULL, 3),
(21, 'S21', 'Hussain Traders', 'local', '', '01816-282397', '', '', 'Haji Yousuf Plaza, 345 Assadgonj, Chittagong.', 0, 0, 'undefined', '0.00', 'a', 'Admin', '2019-03-06 04:49:19', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_payment`
--

CREATE TABLE `tbl_supplier_payment` (
  `SPayment_id` int(11) NOT NULL,
  `SPayment_date` date DEFAULT NULL,
  `SPayment_invoice` varchar(20) DEFAULT NULL,
  `SPayment_customerID` varchar(20) DEFAULT NULL,
  `SPayment_TransactionType` varchar(25) DEFAULT NULL,
  `SPayment_amount` decimal(18,2) DEFAULT NULL,
  `SPayment_Paymentby` varchar(20) DEFAULT NULL,
  `SPayment_notes` varchar(225) DEFAULT NULL,
  `SPayment_brunchid` int(11) DEFAULT NULL,
  `SPayment_status` varchar(2) DEFAULT NULL,
  `SPayment_Addby` varchar(100) DEFAULT NULL,
  `SPayment_AddDAte` date DEFAULT NULL,
  `SPayment_UpdateDAte` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier_payment`
--

INSERT INTO `tbl_supplier_payment` (`SPayment_id`, `SPayment_date`, `SPayment_invoice`, `SPayment_customerID`, `SPayment_TransactionType`, `SPayment_amount`, `SPayment_Paymentby`, `SPayment_notes`, `SPayment_brunchid`, `SPayment_status`, `SPayment_Addby`, `SPayment_AddDAte`, `SPayment_UpdateDAte`) VALUES
(4, '2019-03-13', 'CP-001', '8', NULL, '213840.00', NULL, '', 1, NULL, 'Admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

CREATE TABLE `tbl_unit` (
  `Unit_SlNo` int(11) NOT NULL,
  `Unit_Name` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`Unit_SlNo`, `Unit_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'PCS', 'a', 'Admin', '2019-03-06 12:11:15', NULL, NULL),
(2, 'Sets', 'a', 'Admin', '2019-03-07 02:48:29', NULL, NULL),
(3, 'Coil', 'a', 'Admin', '2019-03-07 02:48:44', NULL, NULL),
(4, 'Feets', 'a', 'Admin', '2019-03-10 12:22:28', NULL, NULL),
(5, 'DZ', 'a', 'Admin', '2019-03-13 03:59:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `User_SlNo` int(11) NOT NULL,
  `User_ID` varchar(50) NOT NULL,
  `FullName` varchar(150) NOT NULL,
  `User_Name` varchar(150) NOT NULL,
  `UserEmail` varchar(200) NOT NULL,
  `userBrunch_id` int(11) NOT NULL,
  `User_Password` varchar(50) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `verifycode` int(11) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Brunch_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`User_SlNo`, `User_ID`, `FullName`, `User_Name`, `UserEmail`, `userBrunch_id`, `User_Password`, `UserType`, `status`, `verifycode`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Brunch_ID`) VALUES
(1, 'admin', 'Admin', 'admin', 'admin@gmail.com', 1, 'c4ca4238a0b923820dcc509a6f75849b', 'm', 'a', 0, NULL, '2019-03-06 14:36:20', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_access`
--

CREATE TABLE `tbl_user_access` (
  `access_id` int(11) NOT NULL COMMENT '1 = Active, 2Deactive',
  `user_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `Accounts` int(11) DEFAULT NULL,
  `Cash_Transaction` int(11) DEFAULT NULL,
  `Create_Account` int(11) DEFAULT NULL,
  `Add_Bank` int(11) DEFAULT NULL,
  `Accounts_Report` int(11) DEFAULT NULL,
  `All_Transaction_Report` int(11) DEFAULT NULL,
  `Deposite_Report` int(11) DEFAULT NULL,
  `Withdraw_Report` int(11) DEFAULT NULL,
  `InCash_Report` int(11) DEFAULT NULL,
  `OutCash_Report` int(11) DEFAULT NULL,
  `Cash_Statement` int(11) DEFAULT NULL,
  `Balance_Sheet` int(11) DEFAULT NULL,
  `Administration` int(11) DEFAULT NULL,
  `Add_Branch` int(11) DEFAULT NULL,
  `Add_Area` int(11) DEFAULT NULL,
  `Company_Profile` int(11) DEFAULT NULL,
  `Category_Entry` int(11) DEFAULT NULL,
  `Unit_Entry` int(11) DEFAULT NULL,
  `Color_Entry` int(11) DEFAULT NULL,
  `Product` int(11) DEFAULT NULL,
  `Product_Entry` int(11) DEFAULT NULL,
  `Product_List` int(11) DEFAULT NULL,
  `Product_Transfer` int(11) DEFAULT NULL,
  `Transfer_Entry` int(11) DEFAULT NULL,
  `Recive_List` int(11) DEFAULT NULL,
  `Transfer_List` int(11) DEFAULT NULL,
  `Damage_Info` int(11) DEFAULT NULL,
  `Damage_Entry` int(11) DEFAULT NULL,
  `Damage_List` int(11) DEFAULT NULL,
  `Sales_Module` int(11) DEFAULT NULL,
  `Sales_Entry` int(11) DEFAULT NULL,
  `Sales_Return` int(11) DEFAULT NULL,
  `Customer_Entry` int(11) DEFAULT NULL,
  `Customer_Payment` int(11) DEFAULT NULL,
  `Customer_List` int(11) DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `Current_Stock` int(11) DEFAULT NULL,
  `Total_Stock` int(11) DEFAULT NULL,
  `Stock_Available` int(11) DEFAULT NULL,
  `Purchase_Module` int(11) DEFAULT NULL,
  `Purchase_Entry` int(11) DEFAULT NULL,
  `Purchase_Return` int(11) DEFAULT NULL,
  `Supplier_Entry` int(11) DEFAULT NULL,
  `Supplier_List` int(11) DEFAULT NULL,
  `Supplier_Payment` int(11) DEFAULT NULL,
  `Purchase_Report` int(11) DEFAULT NULL,
  `Purchase_Invoice` int(11) DEFAULT NULL,
  `Purchase_Record` int(11) DEFAULT NULL,
  `Supplier_Due_Report` int(11) DEFAULT NULL,
  `Supplier_Payment_Report` int(11) DEFAULT NULL,
  `Purchase_Return_List` int(11) DEFAULT NULL,
  `Sales_Reports` int(11) DEFAULT NULL,
  `Sales_Invoice` int(11) DEFAULT NULL,
  `Sales_Record` int(11) DEFAULT NULL,
  `Sales_Return_List` int(11) DEFAULT NULL,
  `Customer_Due_Report` int(11) DEFAULT NULL,
  `Customer_Payment_Report` int(11) DEFAULT NULL,
  `Productwise_Sales` int(11) DEFAULT NULL,
  `Customerwise_Sales` int(11) DEFAULT NULL,
  `Invoice_Product_Details` int(11) DEFAULT NULL,
  `Product_Price_List` int(11) DEFAULT NULL,
  `HR_Payroll` int(11) DEFAULT NULL,
  `Add_Employee` int(11) DEFAULT NULL,
  `Employee_List` int(11) DEFAULT NULL,
  `Salary_Payment` int(11) DEFAULT NULL,
  `Add_Designation` int(11) DEFAULT NULL,
  `Add_Department` int(11) DEFAULT NULL,
  `Add_Month` int(11) DEFAULT NULL,
  `HR_Payroll_Reports` int(11) DEFAULT NULL,
  `Salary_Payment_Report` int(11) DEFAULT NULL,
  `Reports_Module` int(11) DEFAULT NULL,
  `Profit_Loss_Report` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_access`
--

INSERT INTO `tbl_user_access` (`access_id`, `user_id`, `branch_id`, `Accounts`, `Cash_Transaction`, `Create_Account`, `Add_Bank`, `Accounts_Report`, `All_Transaction_Report`, `Deposite_Report`, `Withdraw_Report`, `InCash_Report`, `OutCash_Report`, `Cash_Statement`, `Balance_Sheet`, `Administration`, `Add_Branch`, `Add_Area`, `Company_Profile`, `Category_Entry`, `Unit_Entry`, `Color_Entry`, `Product`, `Product_Entry`, `Product_List`, `Product_Transfer`, `Transfer_Entry`, `Recive_List`, `Transfer_List`, `Damage_Info`, `Damage_Entry`, `Damage_List`, `Sales_Module`, `Sales_Entry`, `Sales_Return`, `Customer_Entry`, `Customer_Payment`, `Customer_List`, `Stock`, `Current_Stock`, `Total_Stock`, `Stock_Available`, `Purchase_Module`, `Purchase_Entry`, `Purchase_Return`, `Supplier_Entry`, `Supplier_List`, `Supplier_Payment`, `Purchase_Report`, `Purchase_Invoice`, `Purchase_Record`, `Supplier_Due_Report`, `Supplier_Payment_Report`, `Purchase_Return_List`, `Sales_Reports`, `Sales_Invoice`, `Sales_Record`, `Sales_Return_List`, `Customer_Due_Report`, `Customer_Payment_Report`, `Productwise_Sales`, `Customerwise_Sales`, `Invoice_Product_Details`, `Product_Price_List`, `HR_Payroll`, `Add_Employee`, `Employee_List`, `Salary_Payment`, `Add_Designation`, `Add_Department`, `Add_Month`, `HR_Payroll_Reports`, `Salary_Payment_Report`, `Reports_Module`, `Profit_Loss_Report`) VALUES
(1, 14, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genaral_customer_info`
--
ALTER TABLE `genaral_customer_info`
  ADD PRIMARY KEY (`G_SiNo`);

--
-- Indexes for table `genaral_supplier_info`
--
ALTER TABLE `genaral_supplier_info`
  ADD PRIMARY KEY (`supplier_sl_no`);

--
-- Indexes for table `sr_transferdetails`
--
ALTER TABLE `sr_transferdetails`
  ADD PRIMARY KEY (`TransferDetails_SiNo`);

--
-- Indexes for table `sr_transfermaster`
--
ALTER TABLE `sr_transfermaster`
  ADD PRIMARY KEY (`TransferMaster_SiNo`);

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`Acc_SlNo`);

--
-- Indexes for table `tbl_assets`
--
ALTER TABLE `tbl_assets`
  ADD PRIMARY KEY (`as_id`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`Bank_SiNo`);

--
-- Indexes for table `tbl_bill_entry`
--
ALTER TABLE `tbl_bill_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_SiNo`);

--
-- Indexes for table `tbl_brunch`
--
ALTER TABLE `tbl_brunch`
  ADD PRIMARY KEY (`brunch_id`);

--
-- Indexes for table `tbl_cashregister`
--
ALTER TABLE `tbl_cashregister`
  ADD PRIMARY KEY (`Transaction_ID`);

--
-- Indexes for table `tbl_cashtransaction`
--
ALTER TABLE `tbl_cashtransaction`
  ADD PRIMARY KEY (`Tr_SlNo`);

--
-- Indexes for table `tbl_checks`
--
ALTER TABLE `tbl_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `tbl_color`
--
ALTER TABLE `tbl_color`
  ADD PRIMARY KEY (`color_SiNo`);

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`Company_SlNo`);

--
-- Indexes for table `tbl_country`
--
ALTER TABLE `tbl_country`
  ADD PRIMARY KEY (`Country_SlNo`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`Customer_SlNo`);

--
-- Indexes for table `tbl_customer_payment`
--
ALTER TABLE `tbl_customer_payment`
  ADD PRIMARY KEY (`CPayment_id`);

--
-- Indexes for table `tbl_damage`
--
ALTER TABLE `tbl_damage`
  ADD PRIMARY KEY (`Damage_SlNo`);

--
-- Indexes for table `tbl_damagedetails`
--
ALTER TABLE `tbl_damagedetails`
  ADD PRIMARY KEY (`DamageDetails_SlNo`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`Department_SlNo`);

--
-- Indexes for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  ADD PRIMARY KEY (`Designation_SlNo`);

--
-- Indexes for table `tbl_district`
--
ALTER TABLE `tbl_district`
  ADD PRIMARY KEY (`District_SlNo`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`Employee_SlNo`);

--
-- Indexes for table `tbl_employee_payment`
--
ALTER TABLE `tbl_employee_payment`
  ADD PRIMARY KEY (`employee_payment_id`);

--
-- Indexes for table `tbl_expense_head`
--
ALTER TABLE `tbl_expense_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_month`
--
ALTER TABLE `tbl_month`
  ADD PRIMARY KEY (`month_id`);

--
-- Indexes for table `tbl_package`
--
ALTER TABLE `tbl_package`
  ADD PRIMARY KEY (`package_ID`);

--
-- Indexes for table `tbl_package_create`
--
ALTER TABLE `tbl_package_create`
  ADD PRIMARY KEY (`create_ID`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`Product_SlNo`),
  ADD UNIQUE KEY `Product_Code` (`Product_Code`);

--
-- Indexes for table `tbl_productcategory`
--
ALTER TABLE `tbl_productcategory`
  ADD PRIMARY KEY (`ProductCategory_SlNo`);

--
-- Indexes for table `tbl_purchasedetails`
--
ALTER TABLE `tbl_purchasedetails`
  ADD PRIMARY KEY (`PurchaseDetails_SlNo`);

--
-- Indexes for table `tbl_purchaseinventory`
--
ALTER TABLE `tbl_purchaseinventory`
  ADD PRIMARY KEY (`PurchaseInventory_SlNo`);

--
-- Indexes for table `tbl_purchasemaster`
--
ALTER TABLE `tbl_purchasemaster`
  ADD PRIMARY KEY (`PurchaseMaster_SlNo`);

--
-- Indexes for table `tbl_purchasereturn`
--
ALTER TABLE `tbl_purchasereturn`
  ADD PRIMARY KEY (`PurchaseReturn_SlNo`);

--
-- Indexes for table `tbl_purchasereturndetails`
--
ALTER TABLE `tbl_purchasereturndetails`
  ADD PRIMARY KEY (`PurchaseReturnDetails_SlNo`);

--
-- Indexes for table `tbl_quotaion_customer`
--
ALTER TABLE `tbl_quotaion_customer`
  ADD PRIMARY KEY (`quotation_customer_id`);

--
-- Indexes for table `tbl_quotation_details`
--
ALTER TABLE `tbl_quotation_details`
  ADD PRIMARY KEY (`SaleDetails_SlNo`);

--
-- Indexes for table `tbl_quotation_master`
--
ALTER TABLE `tbl_quotation_master`
  ADD PRIMARY KEY (`SaleMaster_SlNo`);

--
-- Indexes for table `tbl_saledetails`
--
ALTER TABLE `tbl_saledetails`
  ADD PRIMARY KEY (`SaleDetails_SlNo`);

--
-- Indexes for table `tbl_saleinventory`
--
ALTER TABLE `tbl_saleinventory`
  ADD PRIMARY KEY (`SaleInventory_SlNo`);

--
-- Indexes for table `tbl_salereturn`
--
ALTER TABLE `tbl_salereturn`
  ADD PRIMARY KEY (`SaleReturn_SlNo`);

--
-- Indexes for table `tbl_salereturndetails`
--
ALTER TABLE `tbl_salereturndetails`
  ADD PRIMARY KEY (`SaleReturnDetails_SlNo`);

--
-- Indexes for table `tbl_salesmaster`
--
ALTER TABLE `tbl_salesmaster`
  ADD PRIMARY KEY (`SaleMaster_SlNo`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`Supplier_SlNo`);

--
-- Indexes for table `tbl_supplier_payment`
--
ALTER TABLE `tbl_supplier_payment`
  ADD PRIMARY KEY (`SPayment_id`);

--
-- Indexes for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  ADD PRIMARY KEY (`Unit_SlNo`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`User_SlNo`);

--
-- Indexes for table `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  ADD PRIMARY KEY (`access_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genaral_customer_info`
--
ALTER TABLE `genaral_customer_info`
  MODIFY `G_SiNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `genaral_supplier_info`
--
ALTER TABLE `genaral_supplier_info`
  MODIFY `supplier_sl_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_transferdetails`
--
ALTER TABLE `sr_transferdetails`
  MODIFY `TransferDetails_SiNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_transfermaster`
--
ALTER TABLE `sr_transfermaster`
  MODIFY `TransferMaster_SiNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `Acc_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_assets`
--
ALTER TABLE `tbl_assets`
  MODIFY `as_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `Bank_SiNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_bill_entry`
--
ALTER TABLE `tbl_bill_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_SiNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `tbl_brunch`
--
ALTER TABLE `tbl_brunch`
  MODIFY `brunch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cashregister`
--
ALTER TABLE `tbl_cashregister`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cashtransaction`
--
ALTER TABLE `tbl_cashtransaction`
  MODIFY `Tr_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_checks`
--
ALTER TABLE `tbl_checks`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `color_SiNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `Company_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_country`
--
ALTER TABLE `tbl_country`
  MODIFY `Country_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `Customer_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_customer_payment`
--
ALTER TABLE `tbl_customer_payment`
  MODIFY `CPayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_damage`
--
ALTER TABLE `tbl_damage`
  MODIFY `Damage_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_damagedetails`
--
ALTER TABLE `tbl_damagedetails`
  MODIFY `DamageDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `Department_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `Designation_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_district`
--
ALTER TABLE `tbl_district`
  MODIFY `District_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `Employee_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_employee_payment`
--
ALTER TABLE `tbl_employee_payment`
  MODIFY `employee_payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_expense_head`
--
ALTER TABLE `tbl_expense_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_month`
--
ALTER TABLE `tbl_month`
  MODIFY `month_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_package`
--
ALTER TABLE `tbl_package`
  MODIFY `package_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_package_create`
--
ALTER TABLE `tbl_package_create`
  MODIFY `create_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `Product_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=435;

--
-- AUTO_INCREMENT for table `tbl_productcategory`
--
ALTER TABLE `tbl_productcategory`
  MODIFY `ProductCategory_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tbl_purchasedetails`
--
ALTER TABLE `tbl_purchasedetails`
  MODIFY `PurchaseDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_purchaseinventory`
--
ALTER TABLE `tbl_purchaseinventory`
  MODIFY `PurchaseInventory_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_purchasemaster`
--
ALTER TABLE `tbl_purchasemaster`
  MODIFY `PurchaseMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_purchasereturn`
--
ALTER TABLE `tbl_purchasereturn`
  MODIFY `PurchaseReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchasereturndetails`
--
ALTER TABLE `tbl_purchasereturndetails`
  MODIFY `PurchaseReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quotaion_customer`
--
ALTER TABLE `tbl_quotaion_customer`
  MODIFY `quotation_customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quotation_details`
--
ALTER TABLE `tbl_quotation_details`
  MODIFY `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quotation_master`
--
ALTER TABLE `tbl_quotation_master`
  MODIFY `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_saledetails`
--
ALTER TABLE `tbl_saledetails`
  MODIFY `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_saleinventory`
--
ALTER TABLE `tbl_saleinventory`
  MODIFY `SaleInventory_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_salereturn`
--
ALTER TABLE `tbl_salereturn`
  MODIFY `SaleReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_salereturndetails`
--
ALTER TABLE `tbl_salereturndetails`
  MODIFY `SaleReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_salesmaster`
--
ALTER TABLE `tbl_salesmaster`
  MODIFY `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `Supplier_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_supplier_payment`
--
ALTER TABLE `tbl_supplier_payment`
  MODIFY `SPayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `Unit_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `User_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '1 = Active, 2Deactive', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
