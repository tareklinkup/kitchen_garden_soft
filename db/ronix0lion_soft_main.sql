-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 25, 2019 at 11:07 PM
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
(1, 'General Customer', '', '', 1),
(2, 'General Customer', '', '', 1),
(3, 'General Customer', '', '', 2),
(4, 'General Customer', '', '', 5),
(5, 'General Customer', '', '', 8),
(6, 'General Customer', '', '', 9),
(7, 'General Customer', '', '', 11),
(8, 'General Customer', '01720208244', '', 1),
(9, 'General Customer', '', '', 11);

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

--
-- Dumping data for table `genaral_supplier_info`
--

INSERT INTO `genaral_supplier_info` (`supplier_sl_no`, `S_Name`, `S_Mobile`, `S_Address`, `S_Purchase_Mastar_SiNO`) VALUES
(1, 'Artizan', '0', '0', 1),
(2, 'Artizan', '0', '0', 2),
(3, 'General Supplier', '', '', 3),
(4, 'General Supplier', '', '', 4),
(5, 'General Supplier', '', '', 5),
(6, 'General Supplier', '', '', 7),
(7, 'General Supplier', '01909914396', '', 1),
(8, 'General Supplier', '01909914396', '', 2),
(9, 'General Supplier', '', '', 6),
(10, 'General Supplier', '', '', 7);

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
(1, 1, 'A1000', '', 'Demo', 'Official', '', 'a', 'Admin', '2018-12-01 10:19:09', NULL, NULL),
(2, 1, 'A1001', '', 'Demo 2', 'Official', 'dsfsdf', 'a', 'Admin', '2019-01-10 10:22:56', NULL, NULL),
(3, 1, 'A1002', '', 'Demo 3', 'Official', '', 'a', 'Admin', '2019-01-10 10:23:05', NULL, NULL);

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

--
-- Dumping data for table `tbl_bill_entry`
--

INSERT INTO `tbl_bill_entry` (`id`, `date`, `exp_head`, `amount`, `remarks`, `status`, `addby`) VALUES
(1, '2019-02-19', 1, '1000.00', 'Cash', 'a', 1),
(2, '2019-02-19', 1, '1900.00', 'january 2019 ', 'a', 1);

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
(1, 0, 'Ken', 'd', 2),
(2, 0, 'POWER TOOLS', 'a', 2),
(3, 0, 'ALLEN KEY SET', 'd', 2),
(4, 0, 'ACETYLENE METER', 'd', 2),
(5, 0, 'OXYGEN METER', 'd', 2),
(6, 0, 'HAND TOOLS', 'a', 2),
(7, 0, 'Ronix', 'a', 1),
(8, 0, 'Lion', 'a', 1),
(9, 0, 'Shuvo', 'a', 1),
(10, 0, 'SS BOLT 10x50mm', 'a', 1),
(11, 0, 'SS NUT 10mm', 'a', 1),
(12, 0, 'SS FLAT WASHER 10mm', 'a', 1),
(13, 0, 'SS NUT', 'a', 1),
(14, 0, 'SS BOLT ', 'a', 1),
(15, 0, 'SS FLAT WASHER ', 'a', 1),
(16, 0, 'GRADE', 'a', 1);

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
(1, 'Lion Welding', 'Lion Welding', 'Lion Welding', '2', '0000-00-00', '0000-00-00 00:00:00', '', '', 'a'),
(2, 'New Shovo Hardware ', 'New Shovo', '95/1, Rahima Plaza, Nawabpur, Dhaka.', '2', '0000-00-00', '0000-00-00 00:00:00', '', '', 'a'),
(3, 'CTG', 'fgfg', 'cvv', '2', '0000-00-00', '0000-00-00 00:00:00', '', '', 'd'),
(4, 'new ', 'sdf', 'sfs', '2', '0000-00-00', '0000-00-00 00:00:00', '', '', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashregister`
--

CREATE TABLE `tbl_cashregister` (
  `Transaction_ID` int(11) NOT NULL,
  `Transaction_Date` varchar(20) NOT NULL,
  `IdentityNo` varchar(50) DEFAULT NULL,
  `Narration` varchar(100) NOT NULL,
  `InAmount` varchar(20) NOT NULL,
  `OutAmount` varchar(20) NOT NULL,
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
  `In_Amount` varchar(20) NOT NULL,
  `Out_Amount` varchar(20) NOT NULL,
  `ChequeNumber` int(11) NOT NULL,
  `Tr_Bank_Id` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(100) NOT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Tr_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cashtransaction`
--

INSERT INTO `tbl_cashtransaction` (`Tr_SlNo`, `Tr_Id`, `Tr_date`, `Tr_Type`, `Tr_account_Type`, `Supplier_SlID`, `Customer_SlID`, `Acc_SlID`, `Acc_Code`, `Tr_Description`, `In_Amount`, `Out_Amount`, `ChequeNumber`, `Tr_Bank_Id`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Tr_branchid`) VALUES
(1, 'T1000', '2018-12-03', 'Out Cash', 'Official', 0, 0, 1, NULL, 'okkk', '0', '50000', 0, 0, 'a', '', NULL, 'Admin', '2018-12-03 10:48:30', 1),
(2, 'T1001', '2019-01-10', 'In Cash', 'Official', 0, 0, 1, NULL, 'dfdsf', '10000', '0', 0, 0, 'a', 'Admin', '2019-01-10 10:23:20', NULL, NULL, 1),
(3, 'T1002', '2019-01-10', 'In Cash', 'Official', 0, 0, 2, NULL, 'dsfsdf', '15000', '0', 0, 0, 'a', 'Admin', '2019-01-10 10:23:48', NULL, NULL, 1),
(4, 'T1003', '2019-01-10', 'Out Cash', 'Official', 0, 0, 3, NULL, '', '0', '20000', 0, 0, 'a', '', NULL, 'Admin', '2019-01-10 10:24:00', 1),
(5, 'T1004', '2019-01-10', 'In Cash', 'Official', 0, 0, 3, NULL, '', '150000', '0', 0, 0, 'a', 'Admin', '2019-01-10 10:24:13', NULL, NULL, 1),
(6, 'T1005', '2019-01-10', 'Out Cash', 'Official', 0, 0, 2, NULL, '', '0', '5000', 0, 0, 'a', '', NULL, 'Admin', '2019-01-10 10:24:27', 1),
(7, 'T1006', '2019-02-06', 'Out Cash', 'Official', 0, 0, 2, NULL, '', '0', '555', 0, 0, 'a', '', NULL, 'Admin', '2019-02-06 07:39:25', 1),
(8, 'T1007', '2019-02-06', 'Out Cash', 'Official', 0, 0, 2, NULL, '', '0', '500', 0, 0, 'a', '', NULL, 'Admin', '2019-02-06 07:39:42', 1),
(9, 'T1008', '2019-02-06', 'Deposit To Bank', 'Official', 0, 0, 1, NULL, '', '0', '500', 0, 0, 'a', 'Admin', '2019-02-06 07:39:56', NULL, NULL, 1);

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
  `check_amount` int(10) DEFAULT NULL,
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

--
-- Dumping data for table `tbl_checks`
--

INSERT INTO `tbl_checks` (`id`, `cus_id`, `SM_id`, `bank_name`, `branch_name`, `check_no`, `check_amount`, `date`, `check_date`, `remid_date`, `sub_date`, `note`, `check_status`, `status`, `created_by`, `created_at`, `branch_id`) VALUES
(4, 4, 15, 'DBBL', 'Mirpur', '123466578', 5000, '2019-01-09 18:00:00', '2019-01-23 18:00:00', '2019-01-21 18:00:00', '2019-01-22 18:00:00', 'cheque', 'Pe', 'a', NULL, '2019-01-10 01:02:33', 1),
(5, 6, 16, 'sdfsdf', 'dsfsdf', 'dsf', 650, '2019-01-09 18:00:00', '2019-01-29 18:00:00', '2019-01-27 18:00:00', '2019-01-09 18:00:00', 'fgfdgfd', 'Pe', 'a', 'Admin', '2019-01-10 01:11:36', 1),
(6, 2, 17, 'sdsd', 'sd', 'dwe', 5000, '2019-01-09 18:00:00', '2019-01-09 18:00:00', '2019-01-09 18:00:00', '2019-01-09 18:00:00', 'dsfsdf', 'Pe', 'a', 'Admin', '2019-01-10 01:14:13', 1),
(7, 2, 18, 'fdgdfg', 'fdg', '45454', 454545, '2019-01-09 18:00:00', '2019-01-09 18:00:00', '2019-01-09 18:00:00', '2019-01-09 18:00:00', 'fdgfdg', 'Pa', 'a', 'Admin', '2019-01-10 01:15:33', 1),
(19, 7, 30, 'Dbbl', 'Nawabpur', 'Cl-3456', 5000, '2019-01-31 05:00:00', '2019-02-01 05:00:00', '2019-02-03 05:00:00', '2019-02-03 05:00:00', 'Qwee', 'Pa', 'a', 'Admin', '2019-01-31 06:06:07', 1),
(22, 7, NULL, 'AB', 'NB', 'SFDFDSFfdde', 5000, '2019-01-31 05:00:00', '2019-01-31 05:00:00', '2019-01-31 05:00:00', '2019-01-31 05:00:00', '', 'Pa', 'a', 'Admin', '2019-01-31 05:00:00', 1),
(23, 8, NULL, 'AB', 'NB', 'SFDFDSFfdde', 5000, '2019-01-31 05:00:00', '2019-01-31 05:00:00', '2019-01-31 05:00:00', '2019-01-31 05:00:00', 'S K KHULNA', 'Pa', 'a', 'Admin', '2019-01-31 05:00:00', 1),
(26, 10, 35, 'qqqqqqqqqqqq', 'fgfg', 'fgf', 5000, '2019-02-06 05:00:00', '2019-02-06 05:00:00', '2019-02-06 05:00:00', '2019-02-06 05:00:00', '', 'Pe', 'a', 'Admin', '2019-02-06 12:38:15', 1),
(27, 12, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pe', 'a', 'Admin', '2019-02-06 13:15:08', 1),
(28, 12, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pe', 'a', 'Admin', '2019-02-06 13:15:47', 1),
(29, 12, 38, 'Dbbl ', 'Nawabpur', '232423', 10000, '2019-02-06 05:00:00', '2019-02-08 05:00:00', '2019-02-08 05:00:00', '2019-02-08 05:00:00', 'Roton', 'Pe', 'a', 'Admin', '2019-02-06 13:18:50', 1),
(30, 12, 39, 'asad', 'dadad', '54545', 5000, '2019-02-10 05:00:00', '2019-02-10 05:00:00', '2019-02-10 05:00:00', '2019-02-10 05:00:00', '', 'Pa', 'a', 'Admin', '2019-02-06 13:34:40', 1),
(31, 13, 41, 'Alfha', 'adad', '2244', 4000, '2019-02-10 05:00:00', '2019-02-12 05:00:00', '2019-02-12 05:00:00', '2019-02-12 05:00:00', '', 'Pe', 'a', 'Admin', '2019-02-10 21:24:49', 1);

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
(3, 'Artizan Fashion', ' Faridpur', 'Shuov_(1).jpg', 'Shuov_(1).jpg', 0, NULL, NULL, NULL, 2, 4),
(4, 'Test', '', 'No_available_image6.gif', 'No_available_image6.gif', 0, NULL, NULL, NULL, 1, 6),
(5, 'Shovo Hardware', 'Shovo Hardware', 'RND_DFDS.jpg', 'RND_DFDS.jpg', 0, NULL, NULL, NULL, 1, 2);

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
  `Customer_Credit_Limit` varchar(20) NOT NULL,
  `previous_due` int(11) NOT NULL,
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
(1, 'C01', 'General Customer', 'G', '', '0188888888', '', '', 'Dhaka', 0, 2, '', '', 0, 'a', 'Admin', '2018-09-05 05:02:57', NULL, NULL, 0),
(2, 'C02', 'Pankaj', 'Local', '', '1670884096', '', '', 'Dhaka', 0, 2, '', '10000', 5000, 'a', 'Admin', '2018-09-12 07:48:55', NULL, NULL, 1),
(3, 'C03', 'admin1 customer', 'Local', '', 'retretert', '', '', 'gdf', 0, 2, '', '', 0, 'a', 'admin1', '2018-09-26 06:38:57', NULL, NULL, 4),
(4, 'C04', 'Arup', 'Local', '', '0000111111', '', '1111110000', 'mirpur', 0, 2, '', '10000000', 0, 'a', 'Admin', '2018-11-20 12:22:45', 'Admin', '2018-11-20 12:24:36', 1),
(5, 'C05', 'SHOVO HARDWARE ', 'Local', '', '01778006977', '', '029558930', '95/1, RAHIMA PLAZA, NAWABPUR ROAD, DHAKA.', 0, 1, '', '500000', 0, 'a', 'Admin', '2018-11-26 01:13:50', 'Admin', '2018-12-04 12:46:55', 2),
(6, 'C06', 'joy Bose', 'Local', '', '4343', '', '34343', 'sdfsdfsdf', 0, 1, '', '34434343434', 10000, 'a', 'Admin', '2018-11-29 10:52:36', 'Admin', '2018-11-29 10:53:34', 1),
(7, 'C07', 'Asad', 'Local', '', '76767', '', '', 'fhfhfh', 0, 1, '', '60000', 10000, 'a', 'Admin', '2019-01-31 01:04:17', NULL, NULL, 1),
(8, 'C08', 'new', 'Local', '', '555', '', '55', 'dsfd', 0, 1, '', '5000000', 0, 'a', 'Admin', '2019-01-31 01:24:50', NULL, NULL, 1),
(9, 'C09', 'Amir', 'Local', '', '019875565654', '', '0', 'fgfgfg', 0, 1, '', '500000', 500, 'a', 'Admin', '2019-02-04 12:24:46', 'Admin', '2019-02-06 07:37:01', 1),
(10, 'C010', 'Adnan', 'Local', '', '5555', '', '', 'hfhsd', 0, 1, '', '5000000000', 5000, 'a', 'Admin', '2019-02-06 07:24:04', 'Admin', '2019-02-06 07:37:16', 1),
(11, 'C11', 'qqqq', 'Local', '', '434', '', '', 'rerer', 0, 1, '', '5000', 500, 'a', 'Admin', '2019-02-06 07:46:00', NULL, NULL, 1),
(12, 'C12', 'Serman', 'Local', '', '565656', '', '', 'dfdfdf', 0, 1, '', '50000', 5000, 'a', 'Admin', '2019-02-06 08:13:12', NULL, NULL, 1),
(13, 'C13', 'Asad', 'Local', '', '01987548478', '', '', 'gfgfg', 0, 1, '', '50000', 20000, 'a', 'Admin', '2019-02-10 04:23:07', NULL, NULL, 1),
(14, 'C14', 'Razzak Traders', 'Local', '', '32121212', '', 'm', 'khjhjhj', 0, 1, '', '50000', 5000, 'a', 'Admin', '2019-02-23 03:44:40', NULL, NULL, 1);

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
  `CPayment_amount` double DEFAULT NULL,
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
(1, '2018-11-26', 'CS-001', '1', NULL, 4698, NULL, '', 2, 'Admin', NULL, NULL, NULL),
(2, '2018-11-26', 'CS-002', '1', NULL, 9396, NULL, '', 2, 'Admin', NULL, NULL, NULL),
(3, '2018-11-26', 'CS-003', '5', NULL, 0, NULL, '', 2, 'Admin', NULL, NULL, NULL),
(4, '2018-11-29', 'TR-004', '2', 'CR', 500, 'By Cash', 'cash', 1, 'Admin', '2018-11-29', 'a', '2018-11-29'),
(5, '2018-11-29', 'TR-005', '2', 'CR', 1000, 'By Cash', 'cash', 1, 'Admin', '2018-11-29', 'a', NULL),
(6, '2018-12-01', 'CS-004', '5', NULL, 7023.66, NULL, '', 2, 'Admin', NULL, NULL, NULL),
(7, '2018-12-01', 'CS-005', '4', NULL, 133000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(8, '2018-12-01', 'TR-006', '5', 'CR', 1000, 'By Cash', '1000', 2, 'Admin', '2018-12-01', 'a', NULL),
(9, '2018-12-04', 'CS-006', '6', NULL, 33250, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(10, '2018-12-04', 'CS-007', '5', NULL, 7723.14, NULL, '', 2, 'Admin', NULL, NULL, NULL),
(11, '2018-12-06', 'CS-008', '4', NULL, 33250, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(12, '2018-12-06', 'CS-009', '5', NULL, 2627.46, NULL, '', 2, 'Admin', NULL, NULL, NULL),
(13, '2019-01-08', 'CS-0010', '6', NULL, 70600, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(14, '2019-01-08', 'CS-011', '1', NULL, 650, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(15, '2019-01-08', 'CS-012', '4', NULL, 40617.5, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(16, '2019-01-10', 'CS-013', '4', NULL, 26000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(17, '2019-01-10', 'CS-014', '4', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(18, '2019-01-10', 'CS-015', '4', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(19, '2019-01-10', 'CS-016', '6', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(20, '2019-01-10', 'CS-017', '2', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(21, '2019-01-10', 'CS-018', '2', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(22, '2019-01-15', 'TR-019', '2', 'CR', 454545, 'By Cheque', 'Cheque payment', 1, 'Admin', '2019-01-15', 'a', NULL),
(23, '2019-01-24', 'CS-019', '4', NULL, 30003, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(24, '2019-01-24', 'CS-020', '2', NULL, 260, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(25, '2019-01-24', 'CS-021', '4', NULL, 10, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(26, '2019-01-24', 'CS-022', '2', NULL, 117, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(27, '2019-01-24', 'TR-023', '6', 'CR', 11000, 'By Cash', 'payment ', 1, 'Admin', '2019-01-24', 'a', NULL),
(28, '2019-01-24', 'TR-024', '4', 'CR', 2131, 'By Cash', 'full paid ', 1, 'Admin', '2019-01-24', 'a', NULL),
(29, '2019-01-24', 'CS-023', '4', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(30, '2019-01-24', 'CS-024', '6', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(31, '2019-01-26', 'CS-025', '6', NULL, 3000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(32, '2019-01-26', 'TR-026', '4', 'CR', 500, 'By Cash', 'payment ', 1, 'Admin', '2019-01-26', 'a', NULL),
(33, '2019-01-28', 'TR-027', '4', 'CR', 100, 'By Cash', 'fff', 1, 'Admin', '2019-01-28', 'a', NULL),
(34, '2019-01-30', 'CS-026', '4', NULL, 7000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(35, '2019-01-31', 'CS-027', '4', NULL, 35000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(36, '2019-01-31', 'CS-028', '4', NULL, 6860, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(37, '2019-01-31', 'CS-029', '6', NULL, 7000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(38, '2019-01-31', 'CS-030', '7', NULL, 5000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(39, '2019-01-31', 'TR-031', '7', 'CR', 5000, 'By Cheque', 'Cheque payment', 1, 'Admin', '2019-01-31', 'a', NULL),
(40, '2019-01-31', 'CS-031', '7', NULL, 500, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(41, '2019-01-31', 'CS-032', '7', NULL, 5000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(42, '2019-01-31', 'TR-033', '7', 'CR', 5000, 'By Cash', 'payment ', 1, 'Admin', '2019-01-31', 'a', NULL),
(43, '2019-01-31', 'TR-034', '7', 'CR', 3000, 'By Cash', 'payment ', 1, 'Admin', '2019-01-31', 'a', NULL),
(44, '2019-01-31', 'TR-035', '7', 'CR', 7100, 'By Cash', 'payment ', 1, 'Admin', '2019-01-31', 'a', NULL),
(45, '2019-01-31', 'CS-033', '7', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(46, '2019-02-04', 'CS-034', '9', NULL, 6860, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(47, '2019-02-06', 'TR-035', '7', 'CR', 500, 'By Cash', 'oo', 1, 'Admin', '2019-02-06', 'a', NULL),
(48, '2019-02-06', 'TR-036', '9', 'CR', NULL, 'By Cheque', 'Cheque payment', 1, 'Admin', '2019-02-06', 'a', NULL),
(49, '2019-02-06', 'TR-037', '8', 'CR', 5000, 'By Cheque', 'Cheque payment', 1, 'Admin', '2019-02-06', 'a', NULL),
(50, '2019-02-06', 'CS-035', '10', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(51, '2019-02-06', 'CS-036', '12', NULL, 500, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(52, '2019-02-06', 'CS-037', '12', NULL, 5000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(53, '2019-02-06', 'CS-038', '12', NULL, 0, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(54, '2019-02-06', 'CS-039', '12', NULL, 5000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(55, '2019-02-06', 'TR-040', '12', 'CR', 2000, 'By Cash', 'rtyrt', 1, 'Admin', '2019-02-06', 'a', NULL),
(56, '2019-02-10', 'CS-040', '10', NULL, 200, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(57, '2019-02-10', 'CS-041', '13', NULL, 800, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(58, '2019-02-10', 'CS-042', '13', NULL, 50000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(59, '2019-02-10', 'TR-043', '13', 'CR', 5000, 'By Cash', 'Xash', 1, 'Admin', '2019-02-10', 'a', NULL),
(60, '2019-02-12', 'CS-043', '12', NULL, 245, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(61, '2019-02-19', 'CS-044', '10', NULL, 5880, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(62, '2019-02-23', 'CS-045', '14', NULL, 2493, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(63, '2019-02-23', 'CS-046', '14', NULL, 2000, NULL, '', 1, 'Admin', NULL, NULL, NULL),
(64, '2019-02-23', 'TR-047', '14', 'CR', 5000, 'By Cash', 'cash', 1, 'Admin', '2019-02-23', 'a', NULL),
(65, '2019-02-24', 'CS-047', '14', NULL, 5000, NULL, '', 1, 'Admin', NULL, NULL, NULL);

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

--
-- Dumping data for table `tbl_damage`
--

INSERT INTO `tbl_damage` (`Damage_SlNo`, `Damage_InvoiceNo`, `Damage_Date`, `Damage_Description`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Damage_brunchid`) VALUES
(1, 'D1000', '2018-12-04', 'gg', 'a', 'Admin', '2018-12-04 04:16:19', NULL, NULL, 2),
(2, 'D1001', '2018-12-04', '', 'a', 'Admin', '2018-12-04 05:13:09', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damagedetails`
--

CREATE TABLE `tbl_damagedetails` (
  `DamageDetails_SlNo` int(11) NOT NULL,
  `Damage_SlNo` int(11) NOT NULL,
  `Product_SlNo` int(11) NOT NULL,
  `DamageDetails_DamageQuantity` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_damagedetails`
--

INSERT INTO `tbl_damagedetails` (`DamageDetails_SlNo`, `Damage_SlNo`, `Product_SlNo`, `DamageDetails_DamageQuantity`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 1, 4, '4', 'a', 'Admin', '2018-12-04 04:16:20', NULL, NULL),
(2, 2, 4, '10', 'a', 'Admin', '2018-12-04 05:13:09', NULL, NULL);

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
(1, 'Developer', 'a', 'Admin', '2018-12-04 05:29:21', NULL, NULL);

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
(1, 'Js. Software Developer', 'a', 'Admin', '2018-12-04 05:29:08', NULL, NULL);

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
(1, 'DHAKA.', 'a', 'Admin', '2018-11-26 12:11:32', NULL, NULL);

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
(1, 1, 1, 'E1001', 'Arup', '2018-12-04', 'Male', '2018-12-04', '', '3433', 'arup@gmail.com', 'unmarried', 'ff', 'sadfsdf', 'dfsaf', 'asfsf', '', '', 10, 'a', 'Admin', '2018-12-04 05:30:03', '', '', 1),
(2, 1, 1, 'E1002', 'mamun', '2019-02-01', 'Male', '2019-02-07', '', 'asasas', 'asas', 'married', 'aa', 'ssa', 'asa', 'asa', '', '', 10000, 'a', 'Admin', '2019-02-07 12:11:38', '', '', 1),
(3, 1, 1, 'E1003', 'raj ', '2019-02-07', 'Male', '2019-02-07', '', 'dsf', 'sdf', 'unmarried', 'sdf', 'sdf', 'df', 'dsf', '', '', 8000, 'a', 'Admin', '2019-02-07 12:12:11', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_payment`
--

CREATE TABLE `tbl_employee_payment` (
  `employee_payment_id` int(11) NOT NULL,
  `Employee_SlNo` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `payment_amount` int(11) NOT NULL,
  `deduction_amount` int(11) NOT NULL,
  `save_by` char(30) NOT NULL,
  `paymentBranch_id` int(11) NOT NULL,
  `update_date` varchar(12) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee_payment`
--

INSERT INTO `tbl_employee_payment` (`employee_payment_id`, `Employee_SlNo`, `month_id`, `payment_amount`, `deduction_amount`, `save_by`, `paymentBranch_id`, `update_date`, `date`) VALUES
(1, 1, 1, 9, 0, 'Admin', 1, '', '2018-12-03 18:00:00'),
(2, 1, 0, 8, 0, 'Admin', 1, '', '2019-01-08 18:00:00'),
(3, 1, 0, 2, 0, 'Admin', 1, '', '2019-01-08 18:00:00'),
(4, 3, 2, 3000, 0, 'Admin', 1, '', '2019-02-07 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_head`
--

CREATE TABLE `tbl_expense_head` (
  `id` int(11) NOT NULL,
  `head_name` varchar(100) DEFAULT NULL,
  `status` enum('a','d') DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_expense_head`
--

INSERT INTO `tbl_expense_head` (`id`, `head_name`, `status`) VALUES
(1, 'Net bill', 'a');

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
(1, 'November-2018'),
(2, 'January 2019'),
(3, 'February 2019'),
(4, 'March 2019'),
(5, 'April 2019');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package`
--

CREATE TABLE `tbl_package` (
  `package_ID` int(11) NOT NULL,
  `package_name` varchar(250) CHARACTER SET latin1 NOT NULL,
  `package_categoryid` int(11) NOT NULL,
  `package_purchPrice` varchar(20) CHARACTER SET latin1 NOT NULL,
  `package_sellPrice` varchar(20) CHARACTER SET latin1 NOT NULL,
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
  `create_purch_price` varchar(20) CHARACTER SET latin1 NOT NULL,
  `create_sell_price` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cteate_qty` varchar(20) NOT NULL,
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
  `body_rate` int(11) NOT NULL,
  `Product_type` varchar(15) NOT NULL,
  `Product_BarCode` varchar(100) NOT NULL,
  `ProductCategory_ID` int(11) NOT NULL,
  `color` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `size` varchar(11) NOT NULL,
  `gross_Weight` double DEFAULT NULL,
  `net_Weight` double DEFAULT NULL,
  `Product_IsRawMaterial` varchar(100) NOT NULL,
  `Product_IsFinishedGoods` varchar(100) NOT NULL,
  `Product_ReOrederLevel` int(11) NOT NULL,
  `Product_Purchase_Rate` float NOT NULL,
  `Product_SellingPrice` float NOT NULL,
  `Product_MinimumSellingPrice` int(11) NOT NULL,
  `Product_WholesaleRate` float NOT NULL,
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
(1, 'P01', '9917B ANGLE GRINDER 100MM 670W', '', 0, 'undefined', '', 1, 0, 1, 1, '', 0, 0, '', '', 0, 2349, 2349, 0, 0, '1', 0, 'd', 'Admin', '2018-11-26 12:18:10', '', '', 0, 0, 2),
(2, 'P02', '9913B ANGLE GRINDER 100MM (4\") 670W', '', 0, 'undefined', '', 1, 0, 1, 1, '', 0, 0, '', '', 0, 2388.25, 2389, 0, 0, '1', 0, 'd', 'Admin', '2018-11-26 12:22:29', '', '', 0, 0, 2),
(3, 'P03', 'BX1 500', '', 0, 'undefined', '', 1, 0, 1, 1, '', 0, 0, '', '', 1, 5000, 7000, 0, 0, '1', 0, 'd', 'Admin', '2018-11-26 12:34:09', '', '', 0, 0, 1),
(4, 'P04', '9913B ANGLE GRINDER 100MM (4\") 670W', '', 0, 'undefined', '', 1, 0, 2, 1, '', 0, 0, '', '', 0, 2388.25, 2389, 0, 0, '1', 1, 'a', 'Admin', '2018-11-26 01:03:46', '', '', 0, 0, 2),
(5, 'P05', '9917B ANGLE GRINDER 100MM (4\") 670W', '', 0, 'undefined', '', 1, 0, 2, 1, '', 0, 0, '', '', 0, 2349, 2349, 0, 0, '1', 1, 'a', 'Admin', '2018-11-26 01:04:42', '', '', 0, 0, 2),
(6, 'P06', '9310C ANGLE GRINDER 100MM(4\") 720W', '', 0, 'undefined', '', 1, 0, 2, 1, '', 0, 0, '', '', 0, 2654, 2654, 0, 0, '1', 1, 'a', 'Admin', '2018-11-26 01:06:12', '', '', 0, 0, 2),
(7, 'P00007', 'New Product', '', 0, 'undefined', '', 9, 0, 8, 1, '', 0, 0, '', '', 5, 100, 130, 0, 0, '1', 1, 'a', 'Admin', '2019-01-08 09:37:03', '', '', 0, 0, 1),
(8, 'P00008', 'Product 3', '', 0, 'undefined', '', 9, 0, 8, 1, '', 0, 0, '', '', 5, 600, 1000, 0, 0, '1', 1, 'd', 'Admin', '2019-01-08 09:49:15', '', '', 0, 0, 1),
(9, 'P00009', 'Tx Hammer 8\"', '', 0, 'undefined', '', 10, 0, 8, 1, '', 0, 0, '', '', 10, 120, 150, 0, 0, '1', 1, 'd', 'Admin', '2019-01-31 01:08:39', '', '', 0, 0, 1),
(10, 'P00010', 'We tools ', '', 0, 'undefined', '', 11, 0, 9, 1, '', 0, 0, '', '', 10, 150, 250, 0, 0, '1', 1, 'a', 'Admin', '2019-02-06 08:06:44', '', '', 0, 0, 1),
(11, 'P00011', 'As Tools', '', 0, 'undefined', '', 11, 0, 9, 1, '', 0, 0, '', '', 20, 250, 500, 0, 11, '1', 1, 'a', 'Admin', '2019-02-06 08:07:04', 'Admin', '2019-02-06 08:14:24', 0, 0, 1),
(12, 'P00012', 'SS BOLT 10X50mm', '', 0, 'undefined', '', 12, 0, 10, 1, '', 0, 0, '', '', 100, 5, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 12:45:29', '', '', 0, 0, 1),
(13, 'P00013', 'SS NUT 10mm', '', 0, 'undefined', '', 12, 0, 11, 1, '', 0, 0, '', '', 0, 0, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:00:29', '', '', 0, 0, 1),
(15, 'P00014', 'SS FLAT WASHER 10mm', '', 0, 'undefined', '', 14, 0, 15, 1, '', 0, 0, '', '', 1001, 0, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:02:41', '', '', 0, 0, 1),
(19, 'P00015', 'SS BOLT 8x25mm', '', 0, 'undefined', '', 12, 0, 16, 1, '', 0, 0, '', '', 0, 3.25, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:05:16', '', '', 0, 0, 1),
(20, 'P00016', 'SS NUT 8mm', '', 0, 'undefined', '', 17, 0, 13, 1, '', 0, 0, '', '', 0, 2, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:08:41', '', '', 0, 0, 1),
(21, 'P00017', 'SS FLAT WASHER 8mm', '', 0, 'undefined', '', 14, 0, 15, 1, '', 0, 0, '', '', 0, 0.5, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:09:12', '', '', 0, 0, 1),
(22, 'P00018', 'SS NUT BOLT WITH WASHER 8x25mm', '', 0, 'undefined', '', 18, 0, 16, 1, '', 0, 0, '', '', 0, 0, 12, 0, 22, '1', 1, 'a', 'Admin', '2019-02-19 01:16:40', 'Admin', '2019-02-19 01:39:14', 0, 0, 1),
(23, 'P00019', 'SS NUT 8mm', '', 0, 'undefined', '', 18, 0, 16, 1, '', 0, 0, '', '', 0, 0, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:27:47', '', '', 0, 0, 1),
(24, 'P00020', 'SS BOLT 8x25mm', '', 0, 'undefined', '', 18, 0, 16, 1, '', 0, 0, '', '', 0, 0, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:28:12', '', '', 0, 0, 1),
(25, 'P00021', 'SS FLAT WASHER 8mm', '', 0, 'undefined', '', 18, 0, 16, 1, '', 0, 0, '', '', 0, 0, 0, 0, 0, '1', 1, 'a', 'Admin', '2019-02-19 01:28:46', '', '', 0, 0, 1),
(26, 'P00022', 'Big Hammer', '', 0, 'undefined', '', 10, 0, 8, 1, '', 0, 0, '', '', 10, 500, 700, 0, 0, '1', 1, 'a', 'Admin', '2019-02-23 03:25:38', '', '', 0, 0, 1),
(27, 'P00023', 'Toolson Hammer', '', 0, 'undefined', '', 10, 0, 8, 1, '', 0, 0, '', '', 0, 450, 550, 0, 0, '1', 1, 'a', 'Admin', '2019-02-23 03:26:47', '', '', 0, 0, 1);

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
(1, 'Ken', '', 'a', 'Admin', '2018-11-26 11:11:30', '', '', 2),
(2, 'DONGCHENG', '', 'a', 'Admin', '2018-11-26 11:49:13', '', '', 2),
(3, 'HW', '', 'a', 'Admin', '2018-11-26 11:49:22', '', '', 2),
(4, 'ALLEN KEY SET', '', 'a', 'Admin', '2018-11-26 11:49:40', '', '', 2),
(5, 'ACETYLENE METER', '', 'a', 'Admin', '2018-11-26 11:49:49', '', '', 2),
(6, 'OXYGEN METER', '', 'a', 'Admin', '2018-11-26 11:50:09', '', '', 2),
(7, 'CUTTING TORCH', '', 'a', 'Admin', '2018-11-26 11:50:23', '', '', 2),
(8, 'WELDING TORCH', '', 'a', 'Admin', '2018-11-26 11:50:31', '', '', 2),
(9, 'New Category', 'demo', 'a', 'Admin', '2018-12-03 05:40:50', '', '', 1),
(10, 'hammer', 'hammer', 'a', 'Admin', '2019-01-31 12:08:05', '', '', 1),
(11, 'Tools', '', 'a', 'Admin', '2019-02-06 07:06:03', '', '', 1),
(12, 'SS BOLT', 'SS BOLT ', 'a', 'Admin', '2019-02-19 12:44:06', '', '', 1),
(13, 'SS FLAT WASHER 10mm', 'SS FLAT WASHER 10mm', 'a', 'Admin', '2019-02-19 12:57:46', '', '', 1),
(14, 'SS FLAT WASHER', 'SS FLAT WASHER 10mm', 'a', 'Admin', '2019-02-19 12:59:54', '', '', 1),
(15, 'SS NUT 10mm', 'SS NUT 10mm', 'a', 'Admin', '2019-02-19 01:04:11', '', '', 1),
(16, 'SS NUT 12mm', '', 'a', 'Admin', '2019-02-19 01:05:09', '', '', 1),
(17, 'SS NUT ', 'SS NUT ', 'a', 'Admin', '2019-02-19 01:06:00', '', '', 1),
(18, 'SS NUT BOLT WITH WASHER ', 'SS NUT BOLT WITH WASHER', 'a', 'Admin', '2019-02-19 01:13:30', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasedetails`
--

CREATE TABLE `tbl_purchasedetails` (
  `PurchaseDetails_SlNo` int(11) NOT NULL,
  `PurchaseMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `PurchaseDetails_TotalQuantity` varchar(20) NOT NULL,
  `PurchaseDetail_ReceiveQuantity` varchar(20) NOT NULL,
  `PurchaseDetails_Rate` varchar(20) NOT NULL,
  `purchase_cost` int(11) NOT NULL,
  `PurchaseDetails_Unit` varchar(20) DEFAULT NULL,
  `Purchase_GrossWeight` int(11) DEFAULT NULL,
  `Purchase_NetWeight` int(11) DEFAULT NULL,
  `PurchaseDetails_ExpireDate` datetime NOT NULL,
  `PurchaseDetails_Discount` varchar(20) NOT NULL,
  `PurchaseDetails_Tax` varchar(20) NOT NULL,
  `PurchaseDetails_Freight` varchar(20) NOT NULL,
  `PurchaseDetails_TotalAmount` varchar(20) NOT NULL,
  `Purchasedetails_store` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseDetails_branchID` int(11) NOT NULL,
  `PackName` varchar(200) NOT NULL,
  `PackPice` varchar(20) NOT NULL,
  `Pack_qty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasedetails`
--

INSERT INTO `tbl_purchasedetails` (`PurchaseDetails_SlNo`, `PurchaseMaster_IDNo`, `Product_IDNo`, `PurchaseDetails_TotalQuantity`, `PurchaseDetail_ReceiveQuantity`, `PurchaseDetails_Rate`, `purchase_cost`, `PurchaseDetails_Unit`, `Purchase_GrossWeight`, `Purchase_NetWeight`, `PurchaseDetails_ExpireDate`, `PurchaseDetails_Discount`, `PurchaseDetails_Tax`, `PurchaseDetails_Freight`, `PurchaseDetails_TotalAmount`, `Purchasedetails_store`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseDetails_branchID`, `PackName`, `PackPice`, `Pack_qty`) VALUES
(1, 1, 1, '10', '', '2349', 0, '', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '2', '', NULL, NULL, NULL, NULL, 2, '', '', ''),
(2, 2, 1, '20', '', '2349', 0, '', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '2', '', NULL, NULL, NULL, NULL, 2, '', '', ''),
(3, 3, 6, '10', '', '2654', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '2', '', NULL, NULL, NULL, NULL, 2, '', '', ''),
(4, 3, 4, '10', '', '2388.25', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '2', '', NULL, NULL, NULL, NULL, 2, '', '', ''),
(5, 3, 5, '10', '', '2349', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '2', '', NULL, NULL, NULL, NULL, 2, '', '', ''),
(6, 4, 3, '500', '', '5000', 0, '', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(7, 5, 7, '200', '', '100', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(8, 6, 8, '500', '', '600', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(9, 7, 3, '10', '', '5000', 0, '', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(10, 8, 9, '200', '', '120', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(11, 9, 11, '200', '', '250', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(12, 9, 10, '200', '', '150', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(13, 10, 11, '10', '', '250', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(14, 11, 12, '100', '', '5', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(15, 12, 20, '5000', '', '2', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(16, 12, 19, '3000', '', '3.25', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(17, 12, 21, '10000', '', '0.5', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(18, 13, 22, '1000', '', '5.5', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(19, 14, 27, '100', '', '450', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', ''),
(20, 14, 26, '100', '', '500', 0, 'PCS', 0, 0, '0000-00-00 00:00:00', '', '', '', '', '1', '', NULL, NULL, NULL, NULL, 1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchaseinventory`
--

CREATE TABLE `tbl_purchaseinventory` (
  `PurchaseInventory_SlNo` int(11) NOT NULL,
  `purchProduct_IDNo` int(11) NOT NULL,
  `PurchaseInventory_TotalQuantity` double NOT NULL,
  `PurchaseInventory_ReceiveQuantity` double NOT NULL,
  `PurchaseInventory_ReturnQuantity` double NOT NULL,
  `PurchaseInventory_DamageQuantity` double NOT NULL,
  `PurchaseInventory_Store` varchar(50) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseInventory_packqty` varchar(20) NOT NULL,
  `PurchaseInventory_packname` varchar(200) NOT NULL,
  `PurchaseInventory_returnqty` varchar(20) NOT NULL,
  `PurchaseInventory_brunchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchaseinventory`
--

INSERT INTO `tbl_purchaseinventory` (`PurchaseInventory_SlNo`, `purchProduct_IDNo`, `PurchaseInventory_TotalQuantity`, `PurchaseInventory_ReceiveQuantity`, `PurchaseInventory_ReturnQuantity`, `PurchaseInventory_DamageQuantity`, `PurchaseInventory_Store`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseInventory_packqty`, `PurchaseInventory_packname`, `PurchaseInventory_returnqty`, `PurchaseInventory_brunchid`) VALUES
(1, 1, 30, 0, 0, 0, '2', NULL, NULL, NULL, NULL, '', '', '', 2),
(2, 6, 10, 0, 1, 0, '2', NULL, NULL, NULL, NULL, '', '', '1', 2),
(3, 4, 10, 0, 0, 14, '2', NULL, NULL, NULL, NULL, '', '', '0', 2),
(4, 5, 10, 0, 0, 0, '2', NULL, NULL, NULL, NULL, '', '', '0', 2),
(5, 3, 510, 0, 2, 0, '1', NULL, NULL, NULL, NULL, '', '', '2', 1),
(6, 7, 200, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(7, 8, 500, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(8, 9, 200, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(9, 11, 210, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(10, 10, 200, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(11, 12, 100, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(12, 20, 5000, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(13, 19, 3000, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(14, 21, 10000, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(15, 22, 1000, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(16, 27, 100, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1),
(17, 26, 100, 0, 0, 0, '1', NULL, NULL, NULL, NULL, '', '', '', 1);

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
  `PurchaseMaster_TotalAmount` varchar(20) NOT NULL,
  `PurchaseMaster_DiscountAmount` varchar(20) NOT NULL,
  `PurchaseMaster_Tax` varchar(20) NOT NULL,
  `PurchaseMaster_Freight` varchar(20) NOT NULL,
  `PurchaseMaster_SubTotalAmount` varchar(20) NOT NULL,
  `PurchaseMaster_PaidAmount` varchar(20) NOT NULL,
  `PurchaseMaster_DueAmount` varchar(20) NOT NULL,
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
(1, 1, 0, 'CP-001', '2018-11-26', '2', '', '', '23490', '0', '0', '0', '23490', '0', '23490', '0000-00-00 00:00:00', '', 'a', 'Admin', '2018-11-26 12:19:46', NULL, NULL, '', 2),
(2, 1, 0, 'CP-002', '2018-11-26', '2', '', '', '46980', '0', '0', '0', '46980', '0', '46980', '0000-00-00 00:00:00', '', 'a', 'Admin', '2018-11-26 12:23:32', NULL, NULL, '', 2),
(3, 3, 0, 'CP-003', '2018-11-26', '2', '', '', '73912.5', '0', '0', '0', '73912.5', '0', '73912.5', '0000-00-00 00:00:00', '', 'a', 'Admin', '2018-11-26 01:09:52', NULL, NULL, '', 2),
(4, 2, 0, 'CP-004', '2018-12-01', '1', '', '', '2500000', '0', '0', '0', '2500000', '2500000', '0', '0000-00-00 00:00:00', '', 'a', 'Admin', '2018-12-01 05:15:32', NULL, NULL, '', 1),
(5, 2, 0, 'CP-005', '2019-01-08', '1', '', '', '20000', '0', '0', '0', '20000', '20000', '0', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-01-08 09:37:44', NULL, NULL, '', 1),
(6, 1, 0, 'CP-006', '2019-01-08', '1', '', '', '300000', '0', '0', '0', '300000', '300000', '0', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-01-08 09:49:37', NULL, NULL, '', 1),
(7, 1, 0, 'CP-007', '2019-01-31', '1', '', '', '50000', '0', '0', '0', '50000', '50000', '0', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-01-31 12:50:47', NULL, NULL, '', 1),
(8, 2, 0, 'CP-008', '2019-01-31', '1', '', '', '24000', '0', '0', '0', '24000', '4993', '19000', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-01-31 01:09:12', NULL, NULL, '', 1),
(9, 5, 0, 'CP-009', '2019-02-06', '1', '', '', '80000', '0', '0', '0', '80000', '50000', '30000', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-02-06 08:10:09', NULL, NULL, '', 1),
(10, 5, 0, 'CP-0010', '2019-02-10', '1', '', '', '2500', '0', '0', '0', '2500', '500', '2000', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-02-10 04:31:02', NULL, NULL, '', 1),
(11, 6, 0, 'CP-011', '2019-02-19', '1', 'ALL ARE VERY HIGH QUALITY PRODUCTS...', '', '500', '0', '5', '0', '525', '0', '525', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-02-19 12:50:58', NULL, NULL, '', 1),
(12, 6, 0, 'CP-012', '2019-02-19', '1', '', '', '24750', '0', '0', '0', '24750', '0', '24750', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-02-19 01:12:00', NULL, NULL, '', 1),
(13, 6, 0, 'CP-013', '2019-02-19', '1', '', '', '5500', '0', '0', '0', '5500', '5500', '0', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-02-19 01:31:09', NULL, NULL, '', 1),
(14, 7, 0, 'CP-014', '2019-02-23', '1', '', '', '95000', '0', '0', '0', '95000', '50000', '45000', '0000-00-00 00:00:00', '', 'a', 'Admin', '2019-02-23 03:28:43', NULL, NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturn`
--

CREATE TABLE `tbl_purchasereturn` (
  `PurchaseReturn_SlNo` int(11) NOT NULL,
  `PurchaseMaster_InvoiceNo` varchar(50) NOT NULL,
  `Supplier_IDdNo` int(11) NOT NULL,
  `PurchaseReturn_ReturnDate` date NOT NULL,
  `PurchaseReturn_ReturnQuantity` varchar(20) NOT NULL,
  `PurchaseReturn_ReturnAmount` varchar(20) NOT NULL,
  `PurchaseReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturn_brunchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasereturn`
--

INSERT INTO `tbl_purchasereturn` (`PurchaseReturn_SlNo`, `PurchaseMaster_InvoiceNo`, `Supplier_IDdNo`, `PurchaseReturn_ReturnDate`, `PurchaseReturn_ReturnQuantity`, `PurchaseReturn_ReturnAmount`, `PurchaseReturn_Description`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseReturn_brunchID`) VALUES
(1, 'CP-003', 3, '2018-12-04', '1', '2654', '', '', 'Admin', '2018-12-04 06:53:00', NULL, NULL, 2),
(2, 'CP-007', 1, '2019-01-31', '2', '10000', '', '', 'Admin', '2019-01-31 01:50:11', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturndetails`
--

CREATE TABLE `tbl_purchasereturndetails` (
  `PurchaseReturnDetails_SlNo` int(11) NOT NULL,
  `PurchaseReturn_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetails_ReturnDate` date NOT NULL,
  `PurchaseReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetails_ReceiveQuantity` varchar(20) NOT NULL,
  `PurchaseReturnDetails_ReturnQuantity` varchar(20) NOT NULL,
  `PurchaseReturnDetails_ReturnAmount` varchar(19) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturnDetails_brachid` int(11) NOT NULL,
  `PurchaseReturnDetails_pacQty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasereturndetails`
--

INSERT INTO `tbl_purchasereturndetails` (`PurchaseReturnDetails_SlNo`, `PurchaseReturn_SlNo`, `PurchaseReturnDetails_ReturnDate`, `PurchaseReturnDetailsProduct_SlNo`, `PurchaseReturnDetails_ReceiveQuantity`, `PurchaseReturnDetails_ReturnQuantity`, `PurchaseReturnDetails_ReturnAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseReturnDetails_brachid`, `PurchaseReturnDetails_pacQty`) VALUES
(1, 1, '2018-12-04', 6, '', '1', '2654', '', 'Admin', '2018-12-04 06:53:00', NULL, NULL, 2, ''),
(2, 2, '2019-01-31', 3, '', '2', '10000', '', 'Admin', '2019-01-31 01:50:11', NULL, NULL, 1, '');

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

--
-- Dumping data for table `tbl_quotaion_customer`
--

INSERT INTO `tbl_quotaion_customer` (`quotation_customer_id`, `customer_name`, `contact_number`, `customer_address`, `quation_customer_branchid`) VALUES
(1, 'SHOVO HARDWARE', '01778006977', '95/1, RAHIMA PLAZA, NAWABPUR ROAD, DHAKA.', 2),
(2, 'SHOVO HARDWARE', '01778006977', '95/1, RAHIMA PLAZA, NAWABPUR ROAD, DHAKA.', 2),
(3, 'SHOVO HARDWARE', '01778006977', '95/1, RAHIMA PLAZA, NAWABPUR ROAD, DHAKA.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_details`
--

CREATE TABLE `tbl_quotation_details` (
  `SaleDetails_SlNo` int(11) NOT NULL,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` varchar(20) NOT NULL,
  `Purchase_Rate` varchar(19) DEFAULT NULL,
  `SaleDetails_Rate` varchar(19) NOT NULL,
  `SaleDetails_unit` varchar(20) NOT NULL,
  `SaleDetails_Discount` varchar(19) NOT NULL,
  `SaleDetails_Tax` varchar(19) NOT NULL,
  `SaleDetails_Freight` varchar(19) NOT NULL,
  `SaleDetails_TotalAmount` varchar(19) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `packageName` varchar(200) NOT NULL,
  `packSellPrice` varchar(20) NOT NULL,
  `SeleDetails_qty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_quotation_details`
--

INSERT INTO `tbl_quotation_details` (`SaleDetails_SlNo`, `SaleMaster_IDNo`, `Product_IDNo`, `SaleDetails_TotalQuantity`, `Purchase_Rate`, `SaleDetails_Rate`, `SaleDetails_unit`, `SaleDetails_Discount`, `SaleDetails_Tax`, `SaleDetails_Freight`, `SaleDetails_TotalAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `packageName`, `packSellPrice`, `SeleDetails_qty`) VALUES
(1, 1, 4, '5', '2388.25', '2389', 'PCS', '', '', '', '', '', NULL, NULL, NULL, NULL, '', '', ''),
(2, 2, 5, '6', '2349', '2349', 'PCS', '', '', '', '', '', NULL, NULL, NULL, NULL, '', '', ''),
(3, 3, 5, '3', '2349', '2349', 'PCS', '', '', '', '', '', NULL, NULL, NULL, NULL, '', '', '');

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
  `SaleMaster_TotalSaleAmount` varchar(20) NOT NULL,
  `SaleMaster_TotalDiscountAmount` varchar(20) NOT NULL,
  `SaleMaster_RewordDiscount` float NOT NULL,
  `SaleMaster_TaxAmount` varchar(20) NOT NULL,
  `SaleMaster_Freight` varchar(20) NOT NULL,
  `SaleMaster_SubTotalAmount` varchar(255) NOT NULL,
  `SaleMaster_PaidAmount` varchar(20) NOT NULL,
  `checkamount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `check_details` varchar(255) NOT NULL,
  `SaleMaster_DueAmount` varchar(20) NOT NULL,
  `SaleMaster_TotalDue` varchar(20) NOT NULL DEFAULT '0.00',
  `Status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleMaster_branchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_quotation_master`
--

INSERT INTO `tbl_quotation_master` (`SaleMaster_SlNo`, `SaleMaster_InvoiceNo`, `SalseCustomer_IDNo`, `SaleMaster_SaleDate`, `SaleMaster_Description`, `SaleMaster_SaleType`, `SaleMaster_TotalSaleAmount`, `SaleMaster_TotalDiscountAmount`, `SaleMaster_RewordDiscount`, `SaleMaster_TaxAmount`, `SaleMaster_Freight`, `SaleMaster_SubTotalAmount`, `SaleMaster_PaidAmount`, `checkamount`, `check_details`, `SaleMaster_DueAmount`, `SaleMaster_TotalDue`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleMaster_branchid`) VALUES
(1, 'QS-001', 1, '2018-11-29', '', '2', '11945', '0', 0, '0', '0', '11945', '11945', '0.00', '', '0', '0.00', 'a', 'Admin', '2018-11-29 12:18:27', NULL, NULL, 2),
(2, 'QS-002', 2, '2018-11-29', '', '2', '14094', '0', 0, '0', '0', '14094', '14094', '0.00', '', '0', '0.00', 'a', 'Admin', '2018-11-29 12:29:56', NULL, NULL, 2),
(3, 'QS-003', 3, '2018-11-29', '', '2', '7047', '0', 0, '0', '0', '7047', '7047', '0.00', '', '0', '0.00', 'a', 'Admin', '2018-11-29 12:40:57', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saledetails`
--

CREATE TABLE `tbl_saledetails` (
  `SaleDetails_SlNo` int(11) NOT NULL,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` varchar(20) NOT NULL,
  `Purchase_Rate` varchar(19) DEFAULT NULL,
  `SaleDetails_Rate` varchar(19) NOT NULL,
  `SaleDetails_unit` varchar(20) NOT NULL,
  `SaleDetails_Discount` varchar(19) NOT NULL,
  `Discount_amount` varchar(100) DEFAULT NULL,
  `SaleDetails_Tax` varchar(19) NOT NULL,
  `SaleDetails_Freight` varchar(19) NOT NULL,
  `SaleDetails_TotalAmount` varchar(19) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `packageName` varchar(200) NOT NULL,
  `packSellPrice` varchar(20) NOT NULL,
  `SeleDetails_qty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_saledetails`
--

INSERT INTO `tbl_saledetails` (`SaleDetails_SlNo`, `SaleMaster_IDNo`, `Product_IDNo`, `SaleDetails_TotalQuantity`, `Purchase_Rate`, `SaleDetails_Rate`, `SaleDetails_unit`, `SaleDetails_Discount`, `Discount_amount`, `SaleDetails_Tax`, `SaleDetails_Freight`, `SaleDetails_TotalAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `packageName`, `packSellPrice`, `SeleDetails_qty`) VALUES
(1, 1, 1, '2', '2349', '2349', '', '', '0', '', '', '', '', NULL, '2018-11-26 12:25:38', NULL, NULL, '', '', ''),
(2, 2, 1, '2', '2349', '2349', '', '', '0', '', '', '', '', NULL, '2018-11-26 12:26:14', NULL, NULL, '', '', ''),
(3, 3, 4, '5', '2388.25', '2389', 'PCS', '', '0', '', '', '', '', NULL, '2018-11-26 01:14:28', NULL, NULL, '', '', ''),
(4, 4, 4, '3', '2388.25', '2389', 'PCS', '2', '143.34', '', '', '', '', NULL, '2018-12-01 04:29:04', NULL, NULL, '', '', ''),
(5, 5, 3, '20', '5000', '7000', '', '5', '7000', '', '', '', '', NULL, '2018-12-01 05:15:52', NULL, NULL, '', '', ''),
(6, 6, 3, '5', '5000', '7000', '', '5', '1750', '', '', '', '', NULL, '2018-12-04 08:37:50', NULL, NULL, '', '', ''),
(7, 7, 6, '3', '2654', '2654', 'PCS', '3', '238.86', '', '', '', '', NULL, '2018-12-04 12:18:27', NULL, NULL, '', '', ''),
(8, 8, 3, '5', '5000', '7000', '', '5', '1750', '', '', '', '', NULL, '2018-12-06 04:48:07', NULL, NULL, '', '', ''),
(9, 9, 6, '1', '2654', '2654', 'PCS', '1', '26.54', '', '', '', '', NULL, '2018-12-06 05:00:32', NULL, NULL, '', '', ''),
(10, 10, 7, '5', '100', '130', 'PCS', '5', '32.5', '', '', '', '', NULL, '2019-01-08 09:38:27', NULL, NULL, '', '', ''),
(11, 10, 3, '10', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-08 09:38:27', NULL, NULL, '', '', ''),
(12, 11, 7, '5', '100', '130', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-08 09:41:32', NULL, NULL, '', '', ''),
(13, 12, 8, '5', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-08 09:50:40', NULL, NULL, '', '', ''),
(14, 12, 7, '5', '100', '130', 'PCS', '5', '32.5', '', '', '', '', NULL, '2019-01-08 09:50:40', NULL, NULL, '', '', ''),
(15, 12, 3, '5', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-08 09:50:40', NULL, NULL, '', '', ''),
(16, 13, 7, '10', '100', '130', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-10 06:25:48', NULL, NULL, '', '', ''),
(17, 13, 8, '3', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-10 06:25:48', NULL, NULL, '', '', ''),
(18, 13, 3, '3', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-10 06:25:48', NULL, NULL, '', '', ''),
(19, 14, 8, '4', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-10 06:29:21', NULL, NULL, '', '', ''),
(20, 15, 8, '5', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-10 07:02:33', NULL, NULL, '', '', ''),
(21, 16, 7, '5', '100', '130', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-10 07:11:36', NULL, NULL, '', '', ''),
(22, 17, 7, '3', '100', '130', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-10 07:14:13', NULL, NULL, '', '', ''),
(23, 18, 8, '6', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-10 07:15:33', NULL, NULL, '', '', ''),
(24, 19, 3, '1', '5000', '7000', '', '10', '700', '', '', '', '', NULL, '2019-01-24 03:20:44', NULL, NULL, '', '', ''),
(25, 19, 7, '1', '100', '130', 'PCS', '30', '39', '', '', '', '', NULL, '2019-01-24 03:20:44', NULL, NULL, '', '', ''),
(26, 19, 8, '10', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-24 03:20:44', NULL, NULL, '', '', ''),
(27, 20, 7, '2', '100', '130', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-24 03:55:47', NULL, NULL, '', '', ''),
(28, 21, 3, '1', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-24 03:56:29', NULL, NULL, '', '', ''),
(29, 22, 7, '1', '100', '130', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-24 04:40:51', NULL, NULL, '', '', ''),
(30, 23, 8, '3', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-24 05:26:42', NULL, NULL, '', '', ''),
(31, 24, 3, '5', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-24 05:27:11', NULL, NULL, '', '', ''),
(32, 25, 3, '1', '5000', '7000', '', '5', '350', '', '', '', '', NULL, '2019-01-26 11:27:18', NULL, NULL, '', '', ''),
(33, 25, 8, '10', '600', '1000', 'PCS', '10', '1000', '', '', '', '', NULL, '2019-01-26 11:27:18', NULL, NULL, '', '', ''),
(34, 26, 3, '1', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-30 11:51:25', NULL, NULL, '', '', ''),
(35, 27, 3, '5', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-31 12:44:58', NULL, NULL, '', '', ''),
(36, 28, 3, '1', '5000', '7000', '', '2', '140', '', '', '', '', NULL, '2019-01-31 12:45:06', NULL, NULL, '', '', ''),
(37, 29, 3, '1', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-01-31 12:52:02', NULL, NULL, '', '', ''),
(38, 30, 3, '1', '5000', '7000', '', '5', '350', '', '', '', '', NULL, '2019-01-31 01:06:07', NULL, NULL, '', '', ''),
(39, 31, 9, '10', '120', '150', 'PCS', '', '0', '', '', '', '', NULL, '2019-01-31 02:02:44', NULL, NULL, '', '', ''),
(40, 32, 3, '1', '5000', '7000', '', '5', '350', '', '', '', '', NULL, '2019-01-31 02:23:05', NULL, NULL, '', '', ''),
(41, 32, 9, '5', '120', '150', 'PCS', '2', '15', '', '', '', '', NULL, '2019-01-31 02:23:05', NULL, NULL, '', '', ''),
(42, 33, 8, '20', '600', '1000', 'PCS', '50', '10000', '', '', '', '', NULL, '2019-01-31 09:00:57', NULL, NULL, '', '', ''),
(43, 33, 9, '1', '120', '150', 'PCS', '0', '0', '', '', '', '', NULL, '2019-01-31 09:00:57', NULL, NULL, '', '', ''),
(44, 34, 3, '1', '5000', '7000', '', '2', '140', '', '', '', '', NULL, '2019-02-04 12:26:18', NULL, NULL, '', '', ''),
(45, 35, 8, '5', '600', '1000', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-06 07:38:15', NULL, NULL, '', '', ''),
(46, 36, 11, '10', '250', '500', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-06 08:15:08', NULL, NULL, '', '', ''),
(47, 36, 10, '5', '150', '250', 'PCS', '2', '25', '', '', '', '', NULL, '2019-02-06 08:15:08', NULL, NULL, '', '', ''),
(48, 37, 3, '1', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-02-06 08:15:47', NULL, NULL, '', '', ''),
(49, 38, 11, '10', '250', '500', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-06 08:18:50', NULL, NULL, '', '', ''),
(50, 39, 10, '10', '150', '250', 'PCS', '5', '125', '', '', '', '', NULL, '2019-02-06 08:34:40', NULL, NULL, '', '', ''),
(51, 39, 11, '10', '250', '500', 'PCS', '5', '250', '', '', '', '', NULL, '2019-02-06 08:34:40', NULL, NULL, '', '', ''),
(52, 40, 11, '1', '250', '500', 'PCS', '2', '10', '', '', '', '', NULL, '2019-02-10 04:18:32', NULL, NULL, '', '', ''),
(53, 41, 11, '10', '250', '500', 'PCS', '4', '200', '', '', '', '', NULL, '2019-02-10 04:24:49', NULL, NULL, '', '', ''),
(54, 42, 3, '10', '5000', '7000', '', '', '0', '', '', '', '', NULL, '2019-02-10 04:27:26', NULL, NULL, '', '', ''),
(55, 43, 11, '1', '250', '500', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-12 06:12:54', NULL, NULL, '', '', ''),
(56, 44, 22, '500', '0', '12', 'PCS', '2.5', '120', '', '', '', '', NULL, '2019-02-19 01:40:38', NULL, NULL, '', '', ''),
(57, 45, 26, '10', '500', '700', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-23 03:45:40', NULL, NULL, '', '', ''),
(58, 45, 27, '10', '450', '550', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-23 03:45:40', NULL, NULL, '', '', ''),
(59, 46, 11, '10', '250', '500', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-23 03:47:51', NULL, NULL, '', '', ''),
(60, 47, 26, '2', '500', '700', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-24 04:30:33', NULL, NULL, '', '', ''),
(61, 47, 11, '5', '250', '500', 'PCS', '', '0', '', '', '', '', NULL, '2019-02-24 04:30:33', NULL, NULL, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saleinventory`
--

CREATE TABLE `tbl_saleinventory` (
  `SaleInventory_SlNo` int(11) NOT NULL,
  `sellProduct_IdNo` int(11) NOT NULL,
  `SaleInventory_TotalQuantity` double NOT NULL,
  `SaleInventory_ReceiveQuantity` double NOT NULL,
  `SaleInventory_ReturnQuantity` double NOT NULL,
  `SaleInventory_DamageQuantity` double NOT NULL,
  `SaleInventory_Store` varchar(50) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleInventory_packname` varchar(200) NOT NULL,
  `SaleInventory_qty` varchar(20) NOT NULL,
  `SaleInventory_returnqty` varchar(20) NOT NULL,
  `SaleInventory_brunchid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_saleinventory`
--

INSERT INTO `tbl_saleinventory` (`SaleInventory_SlNo`, `sellProduct_IdNo`, `SaleInventory_TotalQuantity`, `SaleInventory_ReceiveQuantity`, `SaleInventory_ReturnQuantity`, `SaleInventory_DamageQuantity`, `SaleInventory_Store`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleInventory_packname`, `SaleInventory_qty`, `SaleInventory_returnqty`, `SaleInventory_brunchid`) VALUES
(1, 1, 4, 0, 0, 0, '2', 'Admin', '2018-11-26 12:25:38', 'Admin', '2018-11-26 12:26:14', '', '', '', 2),
(2, 4, 8, 0, 0, 0, '2', 'Admin', '2018-11-26 01:14:28', 'Admin', '2018-12-01 04:29:04', '', '', '', 2),
(3, 3, 78, 0, 5, 0, '1', 'Admin', '2018-12-01 05:15:52', 'Admin', '2019-02-10 04:27:26', '', '', '', 1),
(4, 6, 4, 0, 0, 0, '2', 'Admin', '2018-12-04 12:18:27', 'Admin', '2018-12-06 05:00:32', '', '', '', 2),
(5, 7, 37, 0, 0, 0, '1', 'Admin', '2019-01-08 09:38:27', 'Admin', '2019-01-24 04:40:51', '', '', '', 1),
(6, 8, 71, 0, 0, 0, '1', 'Admin', '2019-01-08 09:50:40', 'Admin', '2019-02-06 07:38:15', '', '', '', 1),
(7, 9, 16, 0, 0, 0, '1', 'Admin', '2019-01-31 02:02:44', 'Admin', '2019-01-31 09:00:57', '', '', '', 1),
(8, 11, 57, 0, 2, 0, '1', 'Admin', '2019-02-06 08:15:08', 'Admin', '2019-02-24 04:30:33', '', '', '', 1),
(9, 10, 15, 0, 0, 0, '1', 'Admin', '2019-02-06 08:15:08', 'Admin', '2019-02-06 08:34:40', '', '', '', 1),
(10, 22, 500, 0, 0, 0, '1', 'Admin', '2019-02-19 01:40:38', NULL, NULL, '', '', '', 1),
(11, 26, 12, 0, 0, 0, '1', 'Admin', '2019-02-23 03:45:40', 'Admin', '2019-02-24 04:30:33', '', '', '', 1),
(12, 27, 10, 0, 0, 0, '1', 'Admin', '2019-02-23 03:45:40', NULL, NULL, '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturn`
--

CREATE TABLE `tbl_salereturn` (
  `SaleReturn_SlNo` int(11) NOT NULL,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SaleReturn_ReturnDate` date NOT NULL,
  `SaleReturn_ReturnQuantity` varchar(20) NOT NULL,
  `SaleReturn_ReturnAmount` varchar(20) NOT NULL,
  `SaleReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturn_brunchId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salereturn`
--

INSERT INTO `tbl_salereturn` (`SaleReturn_SlNo`, `SaleMaster_InvoiceNo`, `SaleReturn_ReturnDate`, `SaleReturn_ReturnQuantity`, `SaleReturn_ReturnAmount`, `SaleReturn_Description`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleReturn_brunchId`) VALUES
(1, 'CS-005', '2018-12-04', '5', '35000', '', '', 'Admin', '2018-12-04 08:25:36', NULL, NULL, 1),
(2, 'CS-038', '2019-02-06', '2', '1000', '', '', 'Admin', '2019-02-06 08:28:05', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturndetails`
--

CREATE TABLE `tbl_salereturndetails` (
  `SaleReturnDetails_SlNo` int(11) NOT NULL,
  `SaleReturn_IdNo` int(11) NOT NULL,
  `SaleReturnDetails_ReturnDate` date NOT NULL,
  `SaleReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `SaleReturnDetails_SaleQuantity` varchar(20) NOT NULL,
  `SaleReturnDetails_ReturnQuantity` varchar(20) NOT NULL,
  `SaleReturnDetails_ReturnAmount` varchar(20) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturnDetails_brunchID` int(11) NOT NULL,
  `SaleReturnDetails_Qty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salereturndetails`
--

INSERT INTO `tbl_salereturndetails` (`SaleReturnDetails_SlNo`, `SaleReturn_IdNo`, `SaleReturnDetails_ReturnDate`, `SaleReturnDetailsProduct_SlNo`, `SaleReturnDetails_SaleQuantity`, `SaleReturnDetails_ReturnQuantity`, `SaleReturnDetails_ReturnAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleReturnDetails_brunchID`, `SaleReturnDetails_Qty`) VALUES
(1, 1, '2018-12-04', 3, '20', '5', '35000', '', 'Admin', '2018-12-04 08:25:36', NULL, NULL, 1, ''),
(2, 2, '2019-02-06', 11, '10', '2', '1000', '', 'Admin', '2019-02-06 08:28:05', NULL, NULL, 1, '');

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
  `SaleMaster_TotalSaleAmount` varchar(20) NOT NULL,
  `SaleMaster_TotalDiscountAmount` varchar(20) NOT NULL,
  `SaleMaster_RewordDiscount` float NOT NULL,
  `SaleMaster_TaxAmount` varchar(20) NOT NULL,
  `SaleMaster_Freight` varchar(20) NOT NULL,
  `SaleMaster_SubTotalAmount` varchar(20) NOT NULL,
  `SaleMaster_PaidAmount` varchar(20) NOT NULL,
  `SaleMaster_DueAmount` varchar(20) NOT NULL,
  `SaleMaster_TotalDue` varchar(20) NOT NULL DEFAULT '0.00',
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
(1, 'CS-001', 1, '2018-11-26', '', '2', 'Cash', '4698', '0', 0, '0', '0', '4698', '4698', '0', '0.00', '', 'Admin', '2018-11-26 12:25:38', NULL, NULL, 2),
(2, 'CS-002', 1, '2018-11-26', '', '2', 'Cash', '9396', '0', 0, '0', '0', '9396', '9396', '0', '0.00', '', 'Admin', '2018-11-26 12:26:14', NULL, NULL, 2),
(3, 'CS-003', 5, '2018-11-26', '', '2', 'Cash', '11945', '0', 0, '0', '0', '11945', '0', '11945', '0.00', '', 'Admin', '2018-11-26 01:14:28', NULL, NULL, 2),
(4, 'CS-004', 5, '2018-12-01', '', '2', 'Cash', '7023.66', '0', 0, '0', '0', '7023.66', '7023.66', '0', '0.00', '', 'Admin', '2018-12-01 04:29:04', NULL, NULL, 2),
(5, 'CS-005', 4, '2018-12-01', '', '1', 'Cash', '133000', '0', 0, '0', '0', '133000', '133000', '0', '0.00', '', 'Admin', '2018-12-01 05:15:52', NULL, NULL, 1),
(6, 'CS-006', 6, '2018-12-04', '', '1', 'Cash', '33250', '0', 0, '0', '0', '33250', '33250', '0', '0.00', '', 'Admin', '2018-12-04 08:37:50', NULL, NULL, 1),
(7, 'CS-007', 5, '2018-12-04', '', '2', 'Cash', '7723.14', '0', 0, '0', '0', '7723.14', '7723.14', '0', '0.00', '', 'Admin', '2018-12-04 12:18:27', NULL, NULL, 2),
(8, 'CS-008', 4, '2018-12-06', '', '1', 'Cash', '33250', '0', 0, '0', '0', '33250', '33250', '0', '0.00', '', 'Admin', '2018-12-06 04:48:07', NULL, NULL, 1),
(9, 'CS-009', 5, '2018-12-06', '', '2', 'Cash', '2627.46', '0', 0, '0', '0', '2627.46', '2627.46', '0', '0.00', '', 'Admin', '2018-12-06 05:00:32', NULL, NULL, 2),
(10, 'CS-0010', 6, '2019-01-08', '', '1', 'Cash', '70617.5', '0', 17.5, '0', '0', '70600.00', '70600.00', '0', '0.00', '', 'Admin', '2019-01-08 09:38:27', NULL, NULL, 1),
(11, 'CS-011', 1, '2019-01-08', '', '1', 'Cash', '650', '0', 0, '0', '0', '650', '650', '0', '0.00', '', 'Admin', '2019-01-08 09:41:32', NULL, NULL, 1),
(12, 'CS-012', 4, '2019-01-08', '', '1', 'Cash', '40617.5', '0', 0, '0', '0', '40617.5', '40617.5', '0', '0.00', '', 'Admin', '2019-01-08 09:50:40', NULL, NULL, 1),
(13, 'CS-013', 4, '2019-01-10', '', '1', 'Cheque', '25300', '0', 59, '3', '0', '26000.00', '26000.00', '0', '0.00', '', 'Admin', '2019-01-10 06:25:48', NULL, NULL, 1),
(14, 'CS-014', 4, '2019-01-10', '', '1', 'Cheque', '4000', '0', 0, '0', '0', '4000', '0', '4000', '0.00', '', 'Admin', '2019-01-10 06:29:21', NULL, NULL, 1),
(15, 'CS-015', 4, '2019-01-10', '', '1', 'Cheque', '5000', '0', 0, '0', '0', '5000', '0', '5000', '0.00', '', 'Admin', '2019-01-10 07:02:33', NULL, NULL, 1),
(16, 'CS-016', 6, '2019-01-10', '', '1', 'Cheque', '650', '0', 0, '0', '0', '650', '0', '650', '0.00', '', 'Admin', '2019-01-10 07:11:36', NULL, NULL, 1),
(17, 'CS-017', 2, '2019-01-10', '', '1', 'Cheque', '390', '0', 0, '0', '0', '390', '0', '390', '0.00', '', 'Admin', '2019-01-10 07:14:13', NULL, NULL, 1),
(18, 'CS-018', 2, '2019-01-10', '', '1', 'Cheque', '6000', '0', 0, '0', '0', '6000', '0', '6000', '0.00', '', 'Admin', '2019-01-10 07:15:33', NULL, NULL, 1),
(19, 'CS-019', 4, '2019-01-24', '', '1', 'Cash', '16141', '0', 0, '0', '0', '16141.00', '30003', '-13859', '0.00', '', 'Admin', '2019-01-24 03:20:44', NULL, NULL, 1),
(20, 'CS-020', 2, '2019-01-24', '', '1', 'Cash', '260', '0', 0, '0', '0', '260', '260', '0', '0.00', '', 'Admin', '2019-01-24 03:55:47', NULL, NULL, 1),
(21, 'CS-021', 4, '2019-01-24', '', '1', 'Cash', '7000', '0', 0, '0', '0', '7000', '10', '6990', '0.00', '', 'Admin', '2019-01-24 03:56:29', NULL, NULL, 1),
(22, 'CS-022', 2, '2019-01-24', '', '1', 'Cash', '130', '13', 0, '0', '0', '117.00', '117.00', '0', '0.00', '', 'Admin', '2019-01-24 04:40:51', NULL, NULL, 1),
(23, 'CS-023', 4, '2019-01-24', '', '1', 'Cash', '3000', '0', 0, '0', '0', '3000', '0', '3000', '0.00', '', 'Admin', '2019-01-24 05:26:42', NULL, NULL, 1),
(24, 'CS-024', 6, '2019-01-24', '', '1', 'Cash', '35000', '0', 0, '0', '0', '35000', '0', '35000', '0.00', '', 'Admin', '2019-01-24 05:27:11', NULL, NULL, 1),
(25, 'CS-025', 6, '2019-01-26', '', '1', 'Cash', '15650', '0', 0, '0', '0', '15650', '3000', '12650', '0.00', '', 'Admin', '2019-01-26 11:27:18', NULL, NULL, 1),
(26, 'CS-026', 4, '2019-01-30', '', '1', 'Cash', '7000', '0', 0, '0', '0', '7000', '7000', '0', '0.00', '', 'Admin', '2019-01-30 11:51:25', NULL, NULL, 1),
(27, 'CS-027', 4, '2019-01-31', '', '1', 'Cash', '35000', '0', 0, '0', '0', '35000', '35000', '0', '0.00', '', 'Admin', '2019-01-31 12:44:58', NULL, NULL, 1),
(28, 'CS-028', 4, '2019-01-31', '', '1', 'Cash', '6860', '0', 0, '0', '0', '6860', '6860', '0', '0.00', '', 'Admin', '2019-01-31 12:45:06', NULL, NULL, 1),
(29, 'CS-029', 6, '2019-01-31', '', '1', 'Cash', '7000', '0', 0, '0', '0', '7000', '7000', '0', '0.00', '', 'Admin', '2019-01-31 12:52:02', NULL, NULL, 1),
(30, 'CS-030', 7, '2019-01-31', '', '1', 'Cheque', '6650', '0', 0, '0', '0', '6650', '5000', '1650', '0.00', '', 'Admin', '2019-01-31 01:06:07', NULL, NULL, 1),
(31, 'CS-031', 7, '2019-01-31', '', '1', 'Cash', '1500', '0', 0, '0', '0', '1500', '500', '1000', '0.00', '', 'Admin', '2019-01-31 02:02:44', NULL, NULL, 1),
(32, 'CS-032', 7, '2019-01-31', '', '1', 'Cash', '7385', '0', 0, '0', '0', '7385', '5000', '2385', '0.00', '', 'Admin', '2019-01-31 02:23:05', NULL, NULL, 1),
(33, 'CS-033', 7, '2019-01-31', '', '1', 'Cash', '10150', '0', 0, '0', '0', '10150', '0', '10150', '0.00', '', 'Admin', '2019-01-31 09:00:57', NULL, NULL, 1),
(34, 'CS-034', 9, '2019-02-04', '', '1', 'Cash', '6860', '0', 0, '0', '0', '6860', '6860', '0', '0.00', '', 'Admin', '2019-02-04 12:26:18', NULL, NULL, 1),
(35, 'CS-035', 10, '2019-02-06', '', '1', 'Cheque', '5000', '0', 0, '0', '0', '5000', '0', '5000', '0.00', '', 'Admin', '2019-02-06 07:38:15', NULL, NULL, 1),
(36, 'CS-036', 12, '2019-02-06', '', '1', 'Cash', '6225', '0', 0, '0', '0', '6225', '500', '5725', '0.00', '', 'Admin', '2019-02-06 08:15:08', NULL, NULL, 1),
(37, 'CS-037', 12, '2019-02-06', '', '1', 'Cash', '7000', '0', 0, '0', '0', '7000', '5000', '2000', '0.00', '', 'Admin', '2019-02-06 08:15:47', NULL, NULL, 1),
(38, 'CS-038', 12, '2019-02-06', '', '1', 'Cheque', '5000', '0', 0, '0', '0', '5000', '00', '5000', '0.00', '', 'Admin', '2019-02-06 08:18:50', NULL, NULL, 1),
(39, 'CS-039', 12, '2019-02-06', '', '1', 'Cash', '7125', '0', 0, '0', '0', '7125', '5000', '2125', '0.00', '', 'Admin', '2019-02-06 08:34:40', NULL, NULL, 1),
(40, 'CS-040', 10, '2019-02-10', '', '1', 'Cash', '490', '0', 0, '0', '0', '490', '200', '290', '0.00', '', 'Admin', '2019-02-10 04:18:32', NULL, NULL, 1),
(41, 'CS-041', 13, '2019-02-10', '', '1', 'Cheque', '4800', '0', 0, '0', '0', '4800', '800', '4000', '0.00', '', 'Admin', '2019-02-10 04:24:49', NULL, NULL, 1),
(42, 'CS-042', 13, '2019-02-10', '', '1', 'Cash', '70000', '0', 0, '0', '0', '70000', '50000', '20000', '0.00', '', 'Admin', '2019-02-10 04:27:26', NULL, NULL, 1),
(43, 'CS-043', 12, '2019-02-12', '', '1', 'Cash', '500', '250', 0, '0', '0', '250.00', '245', '5', '0.00', '', 'Admin', '2019-02-12 06:12:54', NULL, NULL, 1),
(44, 'CS-044', 10, '2019-02-19', '', '1', 'Cash', '5880', '0', 0, '0', '0', '5880', '5880', '0', '0.00', '', 'Admin', '2019-02-19 01:40:38', NULL, NULL, 1),
(45, 'CS-045', 14, '2019-02-23', '', '1', 'Cash', '12500', '0', 0, '0', '0', '12500', '2493', '10000', '0.00', '', 'Admin', '2019-02-23 03:45:40', NULL, NULL, 1),
(46, 'CS-046', 14, '2019-02-23', '', '1', 'Cash', '5000', '0', 0, '0', '0', '5000', '2000', '3000', '0.00', '', 'Admin', '2019-02-23 03:47:51', NULL, NULL, 1),
(47, 'CS-047', 14, '2019-02-24', '', '1', 'Cash', '3900', '0', 0, '0', '0', '3900', '5000', '-1100', '0.00', '', 'Admin', '2019-02-24 04:30:33', NULL, NULL, 1);

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
  `previous_due` int(11) NOT NULL,
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
(1, 'S01', 'General Supplier', 'G', '', '0157877857', '', '', 'Dhaka', 0, 0, 'undefined', 0, 'a', 'Admin', '2018-09-05 06:11:05', NULL, NULL, 0),
(2, 'S02', 'Jamil', 'undefined', '', '1670884096', '', '', 'Dhaka', 0, 0, 'undefined', 5000, 'a', 'Admin', '2018-09-12 08:15:56', 'Admin', '2018-09-12 08:16:19', 1),
(3, 'S03', 'KEN POWER TOOLS', 'undefined', '', '01730-330992', '', '', '198-202, NAWABPUR ROAD, DHAKA-1100', 0, 0, 'undefined', 100, 'a', 'Admin', '2018-11-26 01:08:30', 'Admin', '2018-12-04 12:46:30', 2),
(4, 'S04', 'new', 'local', '', '4444', '', '', 'fd', 0, 0, 'undefined', 50, 'a', 'Admin', '2019-01-31 01:50:45', NULL, NULL, 1),
(5, 'S05', 'Faruk', 'local', '', '01987562485', '', '', 'fgfgfg', 0, 0, 'undefined', 20000, 'a', 'Admin', '2019-02-06 08:07:51', NULL, NULL, 1),
(6, 'S06', 'ABC', 'local', '', '0000', '00', '', 'Nawabpur', 0, 0, 'undefined', 0, 'a', 'Admin', '2019-02-19 12:49:36', NULL, NULL, 1),
(7, 'S07', 'Harun', 'local', '', '01979556661', 'mail@linktechbd.com', '', 'Bhoirob', 0, 0, 'undefined', 5000, 'a', 'Admin', '2019-02-23 03:27:45', NULL, NULL, 1);

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
  `SPayment_amount` varchar(20) DEFAULT NULL,
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
(1, '2018-11-26', 'CP-001', '1', NULL, '0', NULL, '', 2, NULL, 'Admin', NULL, NULL),
(2, '2018-11-26', 'CP-002', '1', NULL, '0', NULL, '', 2, NULL, 'Admin', NULL, NULL),
(3, '2018-11-26', 'CP-003', '3', NULL, '0', NULL, '', 2, NULL, 'Admin', NULL, NULL),
(4, '2018-12-01', 'CP-004', '2', NULL, '2500000', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(5, '2019-01-08', 'CP-005', '2', NULL, '20000', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(6, '2019-01-08', 'CP-006', '1', NULL, '300000', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(7, '2019-01-31', 'CP-007', '1', NULL, '50000', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(8, '2019-01-31', 'CP-008', '2', NULL, '4993', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(9, '2019-01-31', 'TR-009', '2', 'CR', '10000', 'By Cash', 'Cash', 1, 'a', 'Admin', '2019-01-31', NULL),
(10, '2019-02-06', 'CP-009', '5', NULL, '50000', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(11, '2019-02-06', 'TR-0010', '5', 'CR', '10000', 'By Cash', 'knk', 1, 'a', 'Admin', '2019-02-06', '2019-02-06'),
(12, '2019-02-10', 'CP-0010', '5', NULL, '500', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(13, '2019-02-10', 'TR-011', '5', 'CR', '5000', 'By Cash', 'cash', 1, 'a', 'Admin', '2019-02-10', NULL),
(14, '2019-02-19', 'CP-011', '6', NULL, '0', NULL, 'ALL ARE VERY HIGH QUALITY PRODUCTS...', 1, NULL, 'Admin', NULL, NULL),
(15, '2019-02-19', 'CP-012', '6', NULL, '0', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(16, '2019-02-19', 'CP-013', '6', NULL, '5500', NULL, '', 1, NULL, 'Admin', NULL, NULL),
(17, '2019-02-23', 'CP-014', '7', NULL, '50000', NULL, '', 1, NULL, 'Admin', NULL, NULL);

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
(1, 'PCS', 'a', 'Admin', '2018-11-26 12:01:42', NULL, NULL),
(2, 'KG', 'a', 'Admin', '2019-02-19 01:06:15', NULL, NULL);

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
(1, 'admin', 'Admin', 'admin', 'admin@gmail.com', 1, 'e10adc3949ba59abbe56e057f20f883e', 'm', 'a', 0, NULL, '2018-11-24 03:30:21', NULL, NULL, 1),
(14, '', 'admin1', 'admin1', 'admin@gamil.com', 4, 'c4ca4238a0b923820dcc509a6f75849b', 'a', 'a', 0, NULL, '2018-09-05 03:38:46', NULL, NULL, 4),
(15, '', 'Test', 'Test', 'admin@gmaol.com', 6, '0cbc6611f5540bd0809a388dc95a615b', 'u', 'a', 0, NULL, '2018-09-12 08:55:46', NULL, NULL, 6),
(16, '', 'Arup', 'arup', 'arup@gmail.com', 1, 'e35cf7b66449df565f93c607d5a81d09', 'a', 'a', 0, NULL, '2019-01-31 00:47:21', NULL, NULL, 1),
(17, 'admin11', 'admin11', 'admin11', 'admin11', 1, 'e020590f0e18cd6053d7ae0e0a507609', 'm', 'a', 0, NULL, NULL, NULL, NULL, 0),
(18, 'sam', 'Shahriyear', 'sam', 'sam@gmail.com', 1, 'c4ca4238a0b923820dcc509a6f75849b', 'm', 'a', 0, NULL, '2018-11-24 03:30:21', NULL, NULL, 1);

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
(1, 14, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 15, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  MODIFY `G_SiNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `genaral_supplier_info`
--
ALTER TABLE `genaral_supplier_info`
  MODIFY `supplier_sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `Acc_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_assets`
--
ALTER TABLE `tbl_assets`
  MODIFY `as_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `Bank_SiNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bill_entry`
--
ALTER TABLE `tbl_bill_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_SiNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_brunch`
--
ALTER TABLE `tbl_brunch`
  MODIFY `brunch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_cashregister`
--
ALTER TABLE `tbl_cashregister`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cashtransaction`
--
ALTER TABLE `tbl_cashtransaction`
  MODIFY `Tr_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_checks`
--
ALTER TABLE `tbl_checks`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `color_SiNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `Company_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_country`
--
ALTER TABLE `tbl_country`
  MODIFY `Country_SlNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `Customer_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_customer_payment`
--
ALTER TABLE `tbl_customer_payment`
  MODIFY `CPayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_damage`
--
ALTER TABLE `tbl_damage`
  MODIFY `Damage_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_damagedetails`
--
ALTER TABLE `tbl_damagedetails`
  MODIFY `DamageDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `Department_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `Designation_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_district`
--
ALTER TABLE `tbl_district`
  MODIFY `District_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `Employee_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_employee_payment`
--
ALTER TABLE `tbl_employee_payment`
  MODIFY `employee_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_expense_head`
--
ALTER TABLE `tbl_expense_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_month`
--
ALTER TABLE `tbl_month`
  MODIFY `month_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `Product_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_productcategory`
--
ALTER TABLE `tbl_productcategory`
  MODIFY `ProductCategory_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_purchasedetails`
--
ALTER TABLE `tbl_purchasedetails`
  MODIFY `PurchaseDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_purchaseinventory`
--
ALTER TABLE `tbl_purchaseinventory`
  MODIFY `PurchaseInventory_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_purchasemaster`
--
ALTER TABLE `tbl_purchasemaster`
  MODIFY `PurchaseMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_purchasereturn`
--
ALTER TABLE `tbl_purchasereturn`
  MODIFY `PurchaseReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_purchasereturndetails`
--
ALTER TABLE `tbl_purchasereturndetails`
  MODIFY `PurchaseReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_quotaion_customer`
--
ALTER TABLE `tbl_quotaion_customer`
  MODIFY `quotation_customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_quotation_details`
--
ALTER TABLE `tbl_quotation_details`
  MODIFY `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_quotation_master`
--
ALTER TABLE `tbl_quotation_master`
  MODIFY `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_saledetails`
--
ALTER TABLE `tbl_saledetails`
  MODIFY `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tbl_saleinventory`
--
ALTER TABLE `tbl_saleinventory`
  MODIFY `SaleInventory_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_salereturn`
--
ALTER TABLE `tbl_salereturn`
  MODIFY `SaleReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_salereturndetails`
--
ALTER TABLE `tbl_salereturndetails`
  MODIFY `SaleReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_salesmaster`
--
ALTER TABLE `tbl_salesmaster`
  MODIFY `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `Supplier_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_supplier_payment`
--
ALTER TABLE `tbl_supplier_payment`
  MODIFY `SPayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `Unit_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `User_SlNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '1 = Active, 2Deactive', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
