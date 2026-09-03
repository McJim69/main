CREATE DATABASE IF NOT EXISTS salon;
USE salon;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";

--
-- Database: `salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

DROP TABLE IF EXISTS `tbladmin`;
CREATE TABLE IF NOT EXISTS `tbladmin` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `AdminName` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UserName` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'McJim Maata', 'admin', 9776848642, 'jcmcyberworks@gmail.com', 'admin', '2022-07-24 22:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `tblappointment`
--

DROP TABLE IF EXISTS `tblappointment`;
CREATE TABLE IF NOT EXISTS `tblappointment` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `AptNumber` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Name` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PhoneNumber` bigint(11) DEFAULT NULL,
  `AptDate` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AptTime` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Services` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ApplyDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Remark` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `RemarkDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblappointment`
--

INSERT INTO `tblappointment` (`ID`, `AptNumber`, `Name`, `Email`, `PhoneNumber`, `AptDate`, `AptTime`, `Services`, `ApplyDate`, `Remark`, `Status`, `RemarkDate`) VALUES
(1, '261064124', 'Komal', 'komal@gmail.com', 7798797897, '7/27/2019', '4:00pm', '1', '2019-07-25 20:48:25', 'Accepted', '1', '2019-07-25 22:41:16'),
(2, '985645887', 'Kashish', 'Kash@gmail.com', 4654654654, '7/29/2019', '4:30pm', 'Deluxe Pedicure', '2019-07-25 21:04:38', 'Rejected', '2', '2019-07-25 22:47:04'),
(3, '965887988', 'Sanjeeta Jain', 'sna@gmail.com', 5646464646, '8/20/2019', '2:30pm', 'Loreal Hair Color(Full)', '2019-08-19 04:35:30', 'we will wait', '1', '2019-08-19 05:37:39'),
(4, '578797544', 'Anuj Kumar', 'phpgurukulofficial@gmail.com', 123456789, '8/30/2019', '1:30am', 'Test', '2019-08-21 08:13:13', '', '', '0000-00-00 00:00:00'),
(5, '899118550', 'bb', 'bgfdh@fdfdsf.com', 4234235423, '8/27/2019', '1:30am', 'Loreal Hair Color(Full)', '2019-08-21 08:14:14', '', '', '0000-00-00 00:00:00'),
(6, '621107928', 'ABC', 'abc@gmail.com', 1234567890, '8/27/2019', '1:30am', 'Rebonding', '2019-08-21 08:22:25', 'Testing', '2', '2019-08-21 08:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomers`
--

DROP TABLE IF EXISTS `tblcustomers`;
CREATE TABLE IF NOT EXISTS `tblcustomers` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Gender` enum('Female','Male','Transgender') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Details` mediumtext COLLATE utf8_unicode_ci,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblcustomers`
--

INSERT INTO `tblcustomers` (`ID`, `Name`, `Email`, `MobileNumber`, `Gender`, `Details`, `CreationDate`, `UpdationDate`) VALUES
(1, 'Sunita Verma', 'verma@gmail.com', 5546464646, 'Transgender', 'Taking Hair Spa', '2019-07-26 03:09:10', '2019-07-31 07:15:54'),
(2, 'Rahul Singh', 'singh@gmail.com', 5565565656, 'Male', 'Taken haircut by him', '2019-07-26 03:10:02', NULL),
(3, 'Khusbu', 'saini@gmail.com', 4646445464, 'Transgender', 'khjhhkjkjkuhj', '2019-07-26 03:10:28', NULL),
(4, 'Sanjeeta Jain', 'san@gmail.com', 5646464646, 'Female', 'Taking Body Spa', '2019-08-19 05:38:58', NULL),
(5, 'Test user', 'testuser@gmail.com', 1234567890, 'Female', 'Test', '2019-08-21 08:24:53', '2019-08-21 08:25:11');

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoice`
--

DROP TABLE IF EXISTS `tblinvoice`;
CREATE TABLE IF NOT EXISTS `tblinvoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Userid` int(11) DEFAULT NULL,
  `ServiceId` int(11) DEFAULT NULL,
  `BillingId` int(11) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblinvoice`
--

INSERT INTO `tblinvoice` (`id`, `Userid`, `ServiceId`, `BillingId`, `PostingDate`) VALUES
(1, 2, 2, 621839533, '2018-07-30 07:33:22'),
(2, 2, 5, 621839533, '2019-06-04 07:33:22'),
(3, 2, 6, 621839533, '2019-07-30 07:33:22'),
(4, 2, 7, 621839533, '2019-07-30 07:33:22'),
(5, 1, 1, 904156433, '2019-07-30 07:40:42'),
(6, 1, 2, 904156433, '2019-07-30 07:40:42'),
(7, 1, 3, 904156433, '2019-07-30 07:40:42'),
(8, 1, 4, 904156433, '2019-07-30 07:40:42'),
(9, 3, 1, 225057023, '2019-07-30 08:03:32'),
(10, 3, 8, 225057023, '2019-07-30 08:03:32'),
(11, 3, 1, 970548035, '2019-07-30 20:42:45'),
(12, 3, 6, 970548035, '2019-07-30 20:42:45'),
(13, 3, 9, 970548035, '2019-07-30 20:42:45'),
(14, 4, 2, 942476283, '2019-08-19 05:39:13'),
(15, 4, 12, 942476283, '2019-08-19 05:39:13'),
(16, 5, 3, 297018570, '2019-08-21 08:25:27'),
(17, 5, 4, 297018570, '2019-08-21 08:25:27'),
(18, 5, 8, 297018570, '2019-08-21 08:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

DROP TABLE IF EXISTS `tblpage`;
CREATE TABLE IF NOT EXISTS `tblpage` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `PageType` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PageTitle` mediumtext COLLATE utf8_unicode_ci,
  `PageDescription` mediumtext COLLATE utf8_unicode_ci,
  `Email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL,
  `Timing` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`, `Timing`) VALUES
(1, 'aboutus', 'About Us', '        Our main focus is on quality and hygiene. Our Parlour is well equipped with advanced technology equipments and provides best quality services. Our staff is well trained and experienced, offering advanced services in Skin, Hair and Body Shaping that will provide you with a luxurious experience that leave you feeling relaxed and stress free. The specialities in the parlour are, apart from regular bleachings and Facials, many types of hairstyles, Bridal and cine make-up and different types of Facials &amp; fashion hair colourings.', NULL, NULL, NULL, ''),
(2, 'contactus', 'Contact Us', 'Capitol Compound, Pagadian City', 'info@mcjim-server.com', 639776848642, NULL, '10:30 am to 7:30 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblservices`
--

DROP TABLE IF EXISTS `tblservices`;
CREATE TABLE IF NOT EXISTS `tblservices` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ServiceName` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cost` int(10) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblservices`
--

INSERT INTO `tblservices` (`ID`, `ServiceName`, `Cost`, `CreationDate`) VALUES
(1, 'O3 Facial', 1200, '2019-07-25 03:22:38'),
(2, 'Fruit Facial', 500, '2019-07-25 03:22:53'),
(3, 'Charcol Facial', 1000, '2019-07-25 03:23:10'),
(4, 'Deluxe Menicure', 500, '2019-07-25 03:23:34'),
(5, 'Deluxe Pedicure', 600, '2019-07-25 03:23:47'),
(6, 'Normal Menicure', 300, '2019-07-25 03:24:01'),
(7, 'Normal Pedicure', 400, '2019-07-25 03:24:19'),
(8, 'U-Shape Hair Cut', 250, '2019-07-25 03:24:38'),
(9, 'Layer Haircut', 550, '2019-07-25 03:24:53'),
(10, 'Rebonding', 3999, '2019-07-25 03:25:08'),
(11, 'Loreal Hair Color(Full)', 1200, '2019-07-25 03:25:35'),
(12, 'Body Spa', 1500, '2019-08-19 05:36:27'),
(14, 'Test', 100, '2019-08-21 07:45:50'),
(15, 'ABC', 200, '2019-08-21 08:23:23');
