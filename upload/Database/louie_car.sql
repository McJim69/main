SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS louie_car;
USE louie_car;

--
-- Database: `louie_car`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE IF NOT EXISTS `about` (
  `asid` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`asid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`asid`, `icon`, `title`, `description`) VALUES
(1, 'fa fa-users-cog', 'Expert Workers', 'Technicians are will-trained and updated on new technology.'),
(2, 'fa fa-certificate', 'Quality Servicing', 'We ensure genuine and high-quality spare parts replacements.'),
(3, 'fa fa-tools', 'Modern Equipment', 'Our shop has acquired high-end equipment to suit today’s technology.');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `fonticon` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `description`, `fonticon`) VALUES
(1, 'Car Aircon', 'Car Airconditioning', 'fa fa-car'),
(2, 'Home Aircon', 'Home Airconditioning', 'fa fa-home'),
(3, 'Office Aircon', 'Office Airconditioning', 'fa fa-building'),
(4, 'Other Services', 'Other Home and Office', 'fa fa-cog');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `cid` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `testimony` varchar(200) DEFAULT NULL,
  `photo` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `fullname` (`fullname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cid`, `fullname`, `position`, `address`, `phone`, `testimony`, `photo`) VALUES
(1, 'Juan Dela Cruz', 'Bank Manager', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(2, 'Alejandro Bagwis', 'Sales Manager', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(3, 'Ligaya Bahaghari123', 'Public Accountant', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(4, 'Angelo Lumpayao', 'Building Contractor', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(5, 'Juan Dela Cruza', 'Bank Manager', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(6, 'Alejandro Bagwisa', 'Sales Manager', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(7, 'Ligaya Bahagharia', 'Public Accountant', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(8, 'Angelo Lumpayaoa', 'Building Contractor', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(9, 'Juan Dela Cruzi', 'Bank Manager', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(10, 'Alejandro Bagwisi', 'Sales Manager', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(11, 'Ligaya Bahagharii', 'Public Accountant', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0),
(12, 'Angelo Lumpayaoi', 'Building Contractor', 'Cotabato City', '9776848642', 'Best Refrigeration and Airconditioning Services.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

DROP TABLE IF EXISTS `dashboard`;
CREATE TABLE IF NOT EXISTS `dashboard` (
  `dash_id` int(11) NOT NULL AUTO_INCREMENT,
  `dash_title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `dash_link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`dash_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`dash_id`, `dash_title`, `description`, `dash_link`) VALUES
(1, 'Products', 'List of Products', 'products'),
(2, 'Galleries', 'Photo Galleries', 'pictures'),
(3, 'Customers', 'List of Customers', 'customers'),
(4, 'Manufacturer', 'List of Manufacturer', 'manufacturer'),
(5, 'Settings', 'System Settings', 'settings'),
(6, 'Transactions', 'List of Transactions', 'transactions'),
(7, 'Reports', 'Report Summary', 'reports'),
(8, 'Backup', 'Backup and Restore', 'backup'),
(9, 'Website', 'Website Settings', 'siteinfo'),
(10, 'Technicians', 'List of Technicians', 'technicians'),
(11, 'Users', 'List of System Users', 'users'),
(12, 'Downloads', 'Downloadables', 'downloads');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

DROP TABLE IF EXISTS `downloads`;
CREATE TABLE IF NOT EXISTS `downloads` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `mfid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `logo` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mfid`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`mfid`, `name`, `logo`) VALUES
(1, 'Kia', 1),
(2, 'Ford', 1),
(3, 'Isuzu', 1),
(4, 'Honda', 1),
(5, 'Mazda', 1),
(6, 'Nissan', 1),
(7, 'Residential', 1),
(8, 'Commercial', 1),
(9, 'Susuki', 1),
(10, 'Toyota', 1),
(11, 'Subaru', 1),
(12, 'Hyundai', 1),
(13, 'Mitsubishi', 1),
(14, 'Chevrolet', 1);

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

DROP TABLE IF EXISTS `months`;
CREATE TABLE IF NOT EXISTS `months` (
  `mosid` varchar(2) NOT NULL,
  `mcode` varchar(3) DEFAULT NULL,
  `mname` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`mosid`, `mcode`, `mname`) VALUES
('1', 'JAN', 'January'),
('2', 'FEB', 'February'),
('3', 'MAR', 'March'),
('4', 'APR', 'April'),
('5', 'MAY', 'May'),
('6', 'JUN', 'Jun'),
('7', 'JUL', 'July'),
('8', 'AUG', 'August'),
('9', 'SEP', 'September'),
('10', 'OCT', 'October'),
('11', 'NOV', 'November'),
('12', 'DEC', 'December');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `picid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `photo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`picid`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`picid`, `title`, `description`, `photo`) VALUES
(1, 'Title', 'Description', 1),
(2, 'Picture', 'Description', 1),
(3, 'Picture', 'Description', 1),
(4, 'Picture', 'Description', 1),
(5, 'Picture', 'Description', 1),
(6, 'Picture', 'Description', 1),
(7, 'Picture', 'Description', 1),
(8, 'Picture', 'Description', 1),
(9, 'Picture', 'Description', 1),
(10, 'Picture', 'Description', 1),
(11, 'Picture', 'Description', 1),
(12, 'Picture', 'Description', 1),
(13, 'Picture', 'Description', 1),
(14, 'Picture', 'Description', 1),
(15, 'Picture', 'Description', 1),
(16, 'Picture', 'Description', 1),
(17, 'Picture', 'Description', 1),
(18, 'Picture', 'Description', 1),
(19, 'Picture', 'Description', 1),
(20, 'Picture', 'Description', 1),
(21, 'Picture', 'Description', 1),
(22, 'Picture', 'Description', 1),
(23, 'Picture', 'Description', 1),
(24, 'Picture', 'Description', 1),
(25, 'Picture', 'Description', 1),
(26, 'Picture', 'Description', 1),
(27, 'Picture', 'Description', 1),
(28, 'Picture', 'Description', 1),
(29, 'Picture', 'Description', 1),
(30, 'Picture', 'Description', 1),
(31, 'Picture', 'Description', 1),
(32, 'Picture', 'Description', 1),
(33, 'Picture', 'Description', 1),
(34, 'Picture', 'Description', 1),
(35, 'Picture', 'Description', 1),
(36, 'Picture', 'Description', 1),
(37, 'Picture', 'Description', 1),
(38, 'Picture', 'Description', 1),
(39, 'Picture', 'Description', 1),
(40, 'Picture', 'Description', 1),
(41, 'Picture', 'Description', 1),
(42, 'Picture', 'Description', 1),
(43, 'Picture', 'Description', 1),
(44, 'Picture', 'Description', 1),
(45, 'Picture', 'Description', 1),
(46, 'Picture', 'Description', 1),
(47, 'Picture', 'Description', 1),
(48, 'Picture', 'Description', 1),
(49, 'Picture', 'Description', 1),
(50, 'Picture', 'Description', 1),
(51, 'Picture', 'Description', 1),
(52, 'Picture', 'Description', 1),
(53, 'Picture', 'Description', 1),
(54, 'Picture', 'Description', 1),
(55, 'Picture', 'Description', 1),
(56, 'Picture', 'Description', 1),
(57, 'Picture', 'Description', 1),
(58, 'Picture', 'Description', 1),
(59, 'Picture', 'Description', 1),
(60, 'Picture', 'Description', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_stock` int(11) DEFAULT NULL,
  `product_unit` varchar(10) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_category` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `product_price` int(11) NOT NULL DEFAULT '0',
  `prod_min_stock` int(11) NOT NULL DEFAULT '0',
  `product_img` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=153 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_stock`, `product_unit`, `product_name`, `product_category`, `description`, `product_price`, `prod_min_stock`, `product_img`) VALUES
(1, 3, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Isuzu MU-X/DMax/Chevlolet Trailblazer', 3850, 0, 1),
(2, 3, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Ford Ranger/Mazda BT50', 3850, 0, 1),
(4, 3, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Mitsubishi Triton 08-15', 3300, 0, 1),
(5, 3, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Mitsubishi Triton -montero 16up', 3850, 0, 0),
(6, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Nissan Almera 13-15', 3300, 0, 0),
(7, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Nissan NV350 Front', 3580, 0, 0),
(8, 5, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hilux/Fortuner/Innova 08-15 Front ', 3300, 0, 0),
(9, 5, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hilux/Fortuner/Innova 08-15 Rear', 3300, 0, 0),
(10, 5, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hilux/Furtuner/Innova 16 Front', 3560, 0, 0),
(11, 5, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Vios 08 Batman ', 3300, 0, 0),
(12, 5, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Vios 14', 3560, 0, 0),
(13, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Hyundai Eon', 3300, 0, 0),
(14, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Hyundai H-100 07-15 Front', 3890, 0, 0),
(15, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Hyundai H-100 17 Front', 3890, 0, 0),
(16, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Isuzu DMax 08-10 ', 3300, 0, 0),
(17, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hi-Ace front 20model', 3890, 0, 0),
(18, 0, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Nissan Navara 06-10', 3300, 0, 0),
(19, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Subaru Forester 09-15', 3800, 0, 0),
(20, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Suzuki Celerio 16up', 3300, 0, 0),
(21, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Avanza 07-11 Front', 3300, 0, 0),
(22, 5, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hilux/Furtuner/Innova 16 Rear', 3300, 0, 0),
(23, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Subaru Forester 20', 3800, 0, 0),
(24, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Isuzu Crosswind/Sportivo front', 3300, 0, 0),
(25, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Mitsubishi Adventure Front', 3300, 0, 0),
(26, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Ford Everest/Ranger 08 Front', 3300, 0, 0),
(27, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Ford Everest 08 Rear', 3300, 0, 0),
(28, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Wigo  20 small', 3850, 0, 0),
(29, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Ford Ecosports 15', 3850, 0, 0),
(30, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hi-Ace 20 Front', 3850, 0, 0),
(31, 4, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hi-Ace 08 Rear', 3800, 0, 0),
(32, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Altis  03', 3300, 0, 0),
(33, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Honda CRV 08', 3300, 0, 0),
(34, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Honda City/Jazz 09', 3300, 0, 0),
(35, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Honda CRV 18', 3800, 0, 0),
(36, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Mitsubishi Mirage', 3300, 0, 0),
(37, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Honda CRV/Civic 97', 3300, 0, 0),
(38, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Avanza 14', 3300, 0, 0),
(39, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Corolla Serp', 3300, 0, 0),
(40, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Hyundai Tucson 12', 3300, 0, 0),
(41, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Isuzu Crosswind Rear', 3300, 0, 0),
(42, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Corolla Lam', 3300, 0, 0),
(43, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Hi-Ace 2020 Rear', 3850, 0, 0),
(44, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Mitsubishi Expander', 3800, 0, 0),
(45, 3, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Land Cruiser 100', 3300, 0, 0),
(46, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Revo Sanden', 3300, 0, 0),
(47, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Revo Denso', 3300, 0, 0),
(48, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Rush', 3800, 0, 0),
(49, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Kia Rio 12', 3300, 0, 0),
(50, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Hyundai Accent 14', 3300, 0, 0),
(51, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Ford Everest Rear 16', 3300, 0, 0),
(52, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Toyota Vios 03', 3300, 0, 0),
(53, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Honda CRV 03', 3300, 0, 0),
(54, 1, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Honda Civic 08', 3300, 0, 0),
(55, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Honda City 97', 3300, 0, 0),
(56, 2, 'Pc', 'Evaporator', 'Car Aircon', 'Evaporator Suzuki Ertiga/Ciaz 19', 3800, 0, 0),
(150, 2, 'assy', 'evaporator', 'Car Aircon', 'TOYOTA WIGO 12 BIG', 3850, 0, 0),
(62, 2, 'Pc', 'evaporator', 'Car Aircon', 'NISSAN CALIBRE 17', 3850, 0, 0),
(63, 2, 'Pc', 'EVAPORATOR', 'Car Aircon', 'HONDA MOBILIO 14', 3850, 0, 0),
(64, 1, 'Pc', 'EVAPORATOR', 'Car Aircon', 'HONDA HRV 14', 3850, 0, 0),
(65, 1, 'Pc', 'EVAPORATOR', 'Car Aircon', 'TOYOTA CAMRY 03', 3850, 0, 0),
(66, 1, 'Pc', 'EVAPORATOR', 'Car Aircon', 'NISSAN JUKE', 3850, 0, 0),
(67, 1, 'Pc', 'EVAPORATOR', 'Car Aircon', 'HONDA CIVIC 17', 3850, 0, 0),
(68, 2, 'Pc', 'EVAPORATOR', 'Car Aircon', 'ISUZU MUX REAR', 3300, 0, 0),
(69, 1, 'Pc', 'Condenser', 'Car Aircon', 'MITSUBISHI STRADAMONTERO 16', 4850, 0, 0),
(70, 1, 'Pc', 'Condenser', 'Car Aircon', 'TOYOTA HILUXFORTUNER 16', 4850, 0, 0),
(71, 2, 'Pc', 'CONDENSER', 'Car Aircon', 'TOYOTA FORTUNER DSL 08-15', 4850, 0, 0),
(72, 3, 'Pc', 'CONDENSER', 'Car Aircon', 'TOYOTA VIOS 14 UP', 4550, 0, 0),
(73, 2, 'Pc', 'CONDENSER', 'Car Aircon', 'TOYOTA HILUX 06-15', 4850, 0, 0),
(74, 1, 'Pc', 'CONDENSER', 'Car Aircon', 'MONTERO 08-15', 4850, 0, 0),
(75, 2, 'Pc', 'CONDENSER', 'Car Aircon', 'MITSUBISHI STRADA 08-15 SMALL', 4500, 0, 0),
(76, 1, 'Pc', 'CONDENSER', 'Car Aircon', 'HONDA CIVIC 97', 3800, 0, 0),
(77, 2, 'Pc', 'Compressor', 'Car Aircon', 'Compressor Mitsubishi Strada/Montero 2.5', 11800, 0, 0),
(78, 1, 'Pc', 'Compressor', 'Car Aircon', 'MITSUBISHI MONTERO 16', 14800, 0, 0),
(79, 1, 'Pc', 'Compressor', 'Car Aircon', 'Compressor Honda Civic/CRV/City 97', 3300, 0, 0),
(80, 1, 'Pc', 'Compressor', 'Car Aircon', 'Compressor Suzuki Minivan/Multicab DA63', 3300, 0, 0),
(81, 1, 'Pc', 'Compressor', 'Car Aircon', 'Compressor Suzuki Multicab DA64', 3300, 0, 0),
(82, 1, 'Pc', 'Compressor', 'Car Aircon', 'Compressor Mitsubishi Strada 16', 3300, 0, 0),
(83, 1, 'Pc', 'Compressor', 'Car Aircon', 'Compressor Mitsubishi Mirage 12', 3300, 0, 0),
(84, 1, 'Pc', 'Compressor', 'Car Aircon', 'Compressor Toyota Hi-Ace D4D 08', 3300, 0, 0),
(85, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Toyota Vios 16-17', 3300, 0, 0),
(86, 3, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Toyota HI-LUX D4D', 3300, 0, 0),
(87, 3, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Toyota Hi-Ace D4D 08', 3300, 0, 0),
(88, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Toyota Innova/Furtuner 08-15', 3300, 0, 0),
(89, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Nissan Navara/Terra', 3300, 0, 0),
(90, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Toyota Vios 08', 3300, 0, 0),
(91, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Strada 08 2.5', 3300, 0, 0),
(92, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Strada 08 3.2', 3300, 0, 0),
(93, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Suzuki Ertiga', 3300, 0, 0),
(94, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Ford Ecosports', 3300, 0, 0),
(95, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Crosswind', 3300, 0, 0),
(96, 1, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Ford Ranger 12', 2311, 0, 0),
(97, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Ford Ranger 17', 3300, 0, 0),
(98, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Toyota Vios 14-16', 3300, 0, 0),
(99, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Mitsubishi Mirage 12  ', 3300, 0, 0),
(100, 2, 'Pc', 'Pulley Assy', 'Car Aircon', 'Pulley Assy Innova Sanden 08', 3300, 0, 0),
(101, 9, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Toyota HI-LUX Front/Innova/Furtuner/Mirage', 1154, 0, 0),
(102, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Ford Ecosports/Chevlolet Spark/Duramax Rear', 3300, 0, 0),
(103, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Ford Ranger/Mazda BT50', 3300, 0, 0),
(104, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Hyundai Tucson/Accent/Eon 2010-2015', 3300, 0, 0),
(105, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Mitsubishi Adventure Rear/Lancer 00-07', 3300, 0, 0),
(106, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Subaru Forester/Hyundai Tucson', 3300, 0, 0),
(107, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Mitsubishi Pajero/Ford Ranger/Ford Everest R12', 3300, 0, 0),
(108, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Mitsubishi Montero/Strada Thin Front/Rear', 3300, 0, 0),
(109, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Nissan Navara 07-2017', 3300, 0, 0),
(110, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Nissan X-TRAIL/Trailblazer Front/Serena', 3300, 0, 0),
(111, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Honda Oring 5/8 X 3/8', 3300, 0, 0),
(112, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve 1/2 X 3/8 Oring', 3300, 0, 0),
(113, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve 1/2 X 5/16 Oring', 3300, 0, 0),
(114, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Toyota FX Revo/Crosswind Oring 5/8 X 3/8', 3300, 0, 0),
(115, 4, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve DMax/Suzuki Celerio Eagle', 3300, 0, 0),
(116, 5, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Mitsubishi Pajero/Toyota Corolla COOL GEAR', 3300, 0, 0),
(117, 3, 'Pc', 'Expansion Valve', 'Car Aircon', 'Expansion Valve Nissan/Kia Dual Capillary', 3300, 0, 0),
(118, 10, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier 3/8 Oring Holes', 3300, 0, 0),
(119, 3, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier Isuzu Hilander', 3300, 0, 0),
(120, 3, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier Honda VTEC 8038', 3300, 0, 0),
(121, 3, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier Mitsubishi Lancer/Adventure/L2OO Small 8015', 3300, 0, 0),
(122, 3, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier Toyota Corolla/Mitsubishi Strada/Isuzu DMax', 3300, 0, 0),
(123, 5, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier Almera/Trailblazer/Strada/DMax 2014/Navara 2017', 3300, 0, 0),
(124, 3, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier Nissan Navara 2008', 3300, 0, 0),
(125, 3, 'Pc', 'Filter Drier', 'Car Aircon', 'Filter Drier IsuzuCrosswind/CAMRY', 3300, 0, 0),
(126, 2, 'Pc', 'Contol Valve', 'Car Aircon', 'Contol Valve Hyundai Accent/Kia Rio Original', 3300, 0, 0),
(127, 3, 'Pc', 'Contol Valve', 'Car Aircon', 'Contol Valve Hyundai/Ford', 3300, 0, 0),
(128, 2, 'Pc', 'Contol Valve', 'Car Aircon', 'Contol Valve Hyundai Santafe', 3300, 0, 0),
(129, 2, 'Pc', 'Contol Valve', 'Car Aircon', 'Contol Valve Toyota Altis', 3300, 0, 0),
(130, 2, 'Pc', 'Contol Valve', 'Car Aircon', 'Contol Valve Hyundai Kona/Kia Rio/Tucson Original', 3300, 0, 0),
(131, 2, 'Pc', 'Pressure Switch', 'Car Aircon', 'Pressure Switch Hyundai Accent/Kia Original', 3300, 0, 0),
(132, 1, 'Pc', 'Pressure Switch', 'Car Aircon', 'Pressure Switch Toyota Hi-Ace/Vios/Mirage Original', 3300, 0, 0),
(133, 1, 'Pc', 'Pressure Switch', 'Car Aircon', 'Pressure Switch Toyota Vios 4Pins Original', 3300, 0, 0),
(134, 1, 'Pc', 'Pressure Switch', 'Car Aircon', 'Pressure Switch Toyota HI-LUX/Furtuner/Innova', 3300, 0, 0),
(135, 1, 'Pc', 'Pressure Switch', 'Car Aircon', 'Pressure Switch Nissan Navara/Terra', 3300, 0, 0),
(136, 2, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Toyota Avanza 06-10', 3300, 0, 0),
(137, 2, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Mitsubishi Mirage', 3300, 0, 0),
(138, 4, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Honda CRV/Fit 07-10', 3300, 0, 0),
(139, 10, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Mitsubishi Montero Gen2', 3300, 0, 0),
(140, 2, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Toyota Altis 14-19', 3300, 0, 0),
(141, 1, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Honda CRV Gen2', 3300, 0, 0),
(142, 6, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Toyota Vios 2014 Superman', 3300, 0, 0),
(143, 5, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Universal NEK 12V', 3300, 0, 0),
(144, 3, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Nissan NU350', 3300, 0, 0),
(145, 2, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Toyota Vios 03-07', 3300, 0, 0),
(146, 5, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Assy NEK 24V', 3300, 0, 0),
(147, 2, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Montero/Strada 08-22', 3300, 0, 0),
(148, 3, 'Pc', 'AUX Fan Motor', 'Car Aircon', 'AUX Fan Motor Ford Ranger BT50 3.2/2.2', 3300, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `service_idno` int(11) NOT NULL AUTO_INCREMENT,
  `service_font` varchar(100) DEFAULT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `service_qlty` varchar(100) DEFAULT NULL,
  `service_expt` varchar(100) DEFAULT NULL,
  `service_mdrn` varchar(100) DEFAULT NULL,
  `service_pics` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`service_idno`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_idno`, `service_font`, `service_name`, `service_qlty`, `service_expt`, `service_mdrn`, `service_pics`) VALUES
(1, 'fa fa-car', 'Car Airconditioning', 'Quality Servicing', 'Expert Workers', 'Modern Equipment', 1),
(2, 'fa fa-building', 'Office Airconditioning', 'Quality Servicing', 'Expert Workers', 'Modern Equipment', 1),
(3, 'fa fa-home', 'Home Airconditioning', 'Quality Servicing', 'Expert Workers', 'Modern Equipment', 1),
(4, 'fa fa-cog', 'Other Home and Office', 'Quality Servicing', 'Expert Workers', 'Modern Equipment', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `set_id` int(11) NOT NULL AUTO_INCREMENT,
  `set_title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `set_link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`set_id`, `set_title`, `description`, `set_link`) VALUES
(1, 'About', 'About Us', 'about'),
(2, 'Services', 'Services Offered', 'services'),
(3, 'Category', 'Services Category', 'categories'),
(4, 'Units', 'Measurement Unit', 'units'),
(5, 'WebMode', 'Website Mode or Status', 'webmode'),
(6, 'Website', 'Website Information', 'siteinfo');

-- --------------------------------------------------------

--
-- Table structure for table `siteinfo`
--

DROP TABLE IF EXISTS `siteinfo`;
CREATE TABLE IF NOT EXISTS `siteinfo` (
  `site_id` int(11) NOT NULL,
  `site_mode` varchar(100) DEFAULT NULL,
  `year_found` int(11) NOT NULL,
  `site_name` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `site_domain` varchar(200) DEFAULT NULL,
  `postal_add` varchar(200) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `youtube` varchar(200) DEFAULT NULL,
  `email_info` varchar(200) DEFAULT NULL,
  `email_book` varchar(200) DEFAULT NULL,
  `email_tech` varchar(200) DEFAULT NULL,
  `email_admin` varchar(200) DEFAULT NULL,
  `phone_globe` varchar(200) DEFAULT NULL,
  `phone_smart` varchar(200) DEFAULT NULL,
  `cert_permit1` varchar(200) DEFAULT NULL,
  `cert_permit2` varchar(200) DEFAULT NULL,
  `cert_permit3` varchar(200) DEFAULT NULL,
  `cert_permit4` varchar(200) DEFAULT NULL,
  `opening_hr1` varchar(200) DEFAULT NULL,
  `opening_hr2` varchar(200) DEFAULT NULL,
  `page_about` varchar(20) DEFAULT 'Yes',
  `page_facts` varchar(20) DEFAULT 'Yes',
  `page_services` varchar(20) DEFAULT 'Yes',
  `page_booking` varchar(20) DEFAULT 'Yes',
  `page_technicians` varchar(20) DEFAULT 'Yes',
  `page_pictorials` varchar(20) DEFAULT 'Yes',
  `page_testimonials` varchar(20) DEFAULT 'Yes',
  `page_contact` varchar(20) DEFAULT 'Yes',
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siteinfo`
--

INSERT INTO `siteinfo` (`site_id`, `site_mode`, `year_found`, `site_name`, `description`, `site_domain`, `postal_add`, `facebook`, `youtube`, `email_info`, `email_book`, `email_tech`, `email_admin`, `phone_globe`, `phone_smart`, `cert_permit1`, `cert_permit2`, `cert_permit3`, `cert_permit4`, `opening_hr1`, `opening_hr2`, `page_about`, `page_facts`, `page_services`, `page_booking`, `page_technicians`, `page_pictorials`, `page_testimonials`, `page_contact`) VALUES
(1, 'Production', 2016, 'Louie CarAircon', 'Refrigeration and Airconditioning Services', 'louiecaraircon.com', 'Sero St, RH4, Cotabato City, PH', 'https://www.facebook.com/profile.php?id=61555871301295', 'https://www.youtube.com/channel/UCYU8wB-l_P2qkRxE57iVaFw', 'info@louiecaraircon.com', 'book@louiecaraircon.com', 'tech@louiecaraircon.com', 'admin@louiecaraircon.com', '+639972483602', '+639125302968', 'PhilGEPS', 'Business Permit', 'Trade and Industry', 'Environmental Compliance', '08:00 AM - 08:00 PM', '08:00 AM - 12:00 PM', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `site_mode`
--

DROP TABLE IF EXISTS `site_mode`;
CREATE TABLE IF NOT EXISTS `site_mode` (
  `mode_id` int(11) NOT NULL,
  `mode_name` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `fonticon` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`mode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_mode`
--

INSERT INTO `site_mode` (`mode_id`, `mode_name`, `description`, `fonticon`) VALUES
(1, 'Disabled', 'Wesite Disabled for Licensing.', 'fa fa-times'),
(2, 'Production', 'Website Production Ready.', 'fa fa-thumbs-up'),
(3, 'Maintenance', 'Website Under Maintenance.', 'fa fa-tools'),
(4, 'Development', 'Wesite Under Construction.', 'fa fa-paint-roller');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `tabid` int(4) NOT NULL AUTO_INCREMENT,
  `tabname` varchar(20) DEFAULT NULL,
  `tabquery` varchar(20) NOT NULL,
  PRIMARY KEY (`tabid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tabid`, `tabname`, `tabquery`) VALUES
(1, 'Videos', 'videos'),
(2, 'Uploads', 'downloads'),
(3, 'Pictures', 'pictures'),
(4, 'Categories', 'categories'),
(5, 'Products', 'products'),
(6, 'Todos', 'todo'),
(7, 'Customers', 'customers'),
(8, 'Technicians', 'technicians'),
(9, 'Transactions', 'transactions'),
(10, 'Manufacturers', 'manufacturer'),
(11, 'Units', 'units'),
(12, 'Months', 'months');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

DROP TABLE IF EXISTS `technicians`;
CREATE TABLE IF NOT EXISTS `technicians` (
  `tech_id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `mobphone` varchar(100) DEFAULT NULL,
  `photo_id` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tech_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`tech_id`, `fullname`, `position`, `facebook`, `mobphone`, `photo_id`) VALUES
(1, 'Arnel Roquero', 'Aircon Technician', 'https://www.facebook.com/jcmcyberworks', '9125302968', 1),
(2, 'James John', 'Aircon Technician', 'https://www.facebook.com/jcmcyberworks', '9125302968', 1),
(3, 'Julius Ramo', 'Aircon Technician', 'https://www.facebook.com/jcmcyberworks', '9125302968', 1);

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `todo_idn` int(4) NOT NULL AUTO_INCREMENT,
  `todo_uid` int(4) NOT NULL,
  `todo_txt` varchar(300) NOT NULL,
  PRIMARY KEY (`todo_idn`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`todo_idn`, `todo_uid`, `todo_txt`) VALUES
(12, 1, 'This is to-do list sample text 4'),
(11, 1, 'This is to-do list sample text 3'),
(9, 1, 'This is to-do list sample text 1'),
(10, 1, 'This is to-do list sample text 2'),
(13, 1, 'This is to-do list sample text 5'),
(14, 1, 'This is to-do list sample text 6'),
(15, 1, 'This is to-do list sample text 7'),
(16, 1, 'This is to-do list sample text 8'),
(17, 1, 'This is to-do list sample text 9'),
(54, 4, 'Well, it seems to be working now.'),
(53, 4, 'Well, it seems to be working now.'),
(49, 4, 'Well, it seems to be working now.'),
(50, 4, 'Well, it seems to be working now.'),
(51, 4, 'Well, it seems to be working now.'),
(52, 4, 'Well, it seems to be working now.'),
(55, 4, 'Well, it seems to be working now.'),
(56, 4, 'Well, it seems to be working now.');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `serv_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `serv_date` date NOT NULL,
  `serv_categ` varchar(100) DEFAULT NULL,
  `serv_client` varchar(100) DEFAULT NULL,
  `cust_id` int(11) NOT NULL,
  `unit_make` varchar(100) DEFAULT NULL,
  `unit_model` varchar(100) DEFAULT NULL,
  `serv_desc` varchar(200) DEFAULT NULL,
  `technician` varchar(50) NOT NULL,
  `labor_cost` int(11) DEFAULT NULL,
  `payment` varchar(50) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `photo` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`serv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`serv_id`, `user_id`, `serv_date`, `serv_categ`, `serv_client`, `cust_id`, `unit_make`, `unit_model`, `serv_desc`, `technician`, `labor_cost`, `payment`, `remarks`, `photo`) VALUES
(10, 1, '2024-09-09', 'Car Airconditioning', 'Juan Dela Cruz', 1, 'Hyundai', 'Ranger', 'Description', 'James John', 8555, 'Pending', 'Replace Radio & Switch', 0),
(11, 1, '2024-10-10', 'Car Airconditioning', 'Alejandro Bagwis', 2, 'Mitsubishi', 'Pajero', 'Description', 'James John', 25011, 'Paid', 'Replace Radio & Switch', 0),
(12, 1, '2024-12-01', 'Car Airconditioning', 'Ligaya Bahaghari', 3, 'Chevrolet', 'Navara', 'Description', 'Arnel Roquero', 5000, 'Pending', 'Replace Power System', 0),
(2, 1, '2024-02-22', 'Car Airconditioning', 'Alejandro Bagwis', 4, 'Ford', 'Ranger', 'Description', 'James John', 5432, 'Collectable', 'Replace Radio & Switch', 0),
(3, 1, '2024-03-20', 'Car Airconditioning', 'Ligaya Bahaghari', 5, 'Isuzu', 'DMax', 'Description', 'Julius Ramo', 33421, 'Pending', 'Reconfigure', 0),
(4, 1, '2024-11-11', 'Car Airconditioning', 'Angelo Lumpayao', 6, 'Honda', 'Civic', 'Description', 'Wilmar Canonalas', 6323, 'Collectable', 'Replace Radio & Switch', 0),
(5, 1, '2024-04-04', 'Car Airconditioning', 'Juan Dela Cruz', 7, 'Mazda', 'Navara', 'Description', 'Arnel Roquero', 5221, 'Paid', 'Replace Power System', 0),
(6, 1, '2024-05-05', 'Car Airconditioning', 'Alejandro Bagwis', 8, 'Nissan', 'Navara', 'Description', 'James John', 9555, 'Collectable', 'Replace Radio & Switch', 0),
(7, 1, '2024-06-06', 'Car Airconditioning', 'Ligaya Bahaghari', 9, 'Susuki', 'Hilux', 'Description', 'Julius Ramo', 12444, 'Pending', 'Replace Radio & Switch', 0),
(8, 1, '2024-07-07', 'Car Airconditioning', 'Angelo Lumpayao', 10, 'Toyota', 'Hilux', 'Description', 'Wilmar Canonalas', 5000, 'Paid', 'Replace Radio & Switch', 0),
(1, 1, '2024-01-01', 'Car Airconditioning', 'Juan Dela Cruz', 11, 'Kia', 'Pride', 'Description', 'Arnel Roquero', 23421, 'Paid', 'Replace Power System', 0),
(9, 1, '2024-08-08', 'Car Airconditioning', 'Juan Dela Cruz', 12, 'Subaru', 'Civic', 'Description', 'Arnel Roquero', 4566, 'Collectable', 'Replace Radio & Switch', 0),
(13, 1, '2024-12-02', 'Car Airconditioning', 'Angelo Lumpayaoi', 12, 'Isuzu', 'Ranger', 'Description', 'James John', 23421, 'Pending', 'Replace Radio & Switch', 0),
(14, 1, '2024-12-02', 'Home Airconditioning', 'Ligaya Bahaghari123', 3, 'Honda', 'Ranger', 'Job Description', 'Arnel Roquero', 23421, 'Paid', 'Service Remarks', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trans_details`
--

DROP TABLE IF EXISTS `trans_details`;
CREATE TABLE IF NOT EXISTS `trans_details` (
  `dets_idno` int(11) NOT NULL AUTO_INCREMENT,
  `serv_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_qnty` int(11) NOT NULL,
  `product_unit` varchar(50) DEFAULT NULL,
  `product_price` int(11) NOT NULL,
  `serv_date` date NOT NULL,
  `payment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`dets_idno`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_details`
--

INSERT INTO `trans_details` (`dets_idno`, `serv_id`, `product_id`, `product_name`, `product_stock`, `product_qnty`, `product_unit`, `product_price`, `serv_date`, `payment`) VALUES
(114, 11, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-10-10', 'Paid'),
(112, 9, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-08-08', 'Collectable'),
(113, 11, 13, 'Evaporator', 0, 1, 'Pc', 3300, '2024-10-10', 'Paid'),
(110, 9, 7, 'Evaporator', 0, 1, 'Pc', 3580, '2024-08-08', 'Collectable'),
(111, 9, 18, 'Evaporator', 0, 1, 'Pc', 3300, '2024-08-08', 'Collectable'),
(109, 8, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-07-07', 'Paid'),
(92, 1, 10, 'Evaporator', 0, 1, 'Pc', 3560, '2024-01-01', 'Paid'),
(93, 1, 14, 'Evaporator', 0, 1, 'Pc', 3890, '2024-01-01', 'Paid'),
(94, 2, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-02-22', 'Collectable'),
(95, 2, 8, 'Evaporator', 0, 1, 'Pc', 3300, '2024-02-22', 'Collectable'),
(96, 3, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-03-20', 'Pending'),
(97, 3, 19, 'Evaporator', 1, 1, 'Pc', 3800, '2024-03-20', 'Pending'),
(98, 4, 13, 'Evaporator', 0, 1, 'Pc', 3300, '2024-11-11', 'Collectable'),
(99, 4, 7, 'Evaporator', 0, 1, 'Pc', 3580, '2024-11-11', 'Collectable'),
(100, 5, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-04-04', 'Paid'),
(101, 5, 19, 'Evaporator', 0, 1, 'Pc', 3800, '2024-04-04', 'Paid'),
(102, 6, 14, 'Evaporator', 0, 1, 'Pc', 3890, '2024-05-05', 'Collectable'),
(103, 6, 19, 'Evaporator', 0, 1, 'Pc', 3800, '2024-05-05', 'Collectable'),
(104, 7, 10, 'Evaporator', 0, 1, 'Pc', 3560, '2024-06-06', 'Pending'),
(105, 7, 14, 'Evaporator', 0, 1, 'Pc', 3890, '2024-06-06', 'Pending'),
(106, 8, 13, 'Evaporator', 0, 1, 'Pc', 3300, '2024-07-07', 'Paid'),
(107, 8, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-07-07', 'Paid'),
(108, 8, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-07-07', 'Paid'),
(115, 11, 14, 'Evaporator', 0, 1, 'Pc', 3890, '2024-10-10', 'Paid'),
(116, 12, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-12-01', 'Pending'),
(117, 12, 18, 'Evaporator', 0, 1, 'Pc', 3300, '2024-12-01', 'Pending'),
(118, 12, 14, 'Evaporator', 0, 1, 'Pc', 3890, '2024-12-01', 'Pending'),
(119, 12, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-12-01', 'Pending'),
(120, 12, 7, 'Evaporator', 0, 1, 'Pc', 3580, '2024-12-01', 'Pending'),
(121, 13, 14, 'Evaporator', 0, 1, 'Pc', 3890, '2024-12-02', 'Pending'),
(122, 13, 17, 'Evaporator', 0, 1, 'Pc', 3890, '2024-12-02', 'Pending'),
(123, 14, 9, 'Evaporator', 2, 1, 'Pc', 3300, '2024-12-02', 'Paid'),
(124, 14, 14, 'Evaporator', 0, 1, 'Pc', 3890, '2024-12-02', 'Paid'),
(125, 10, 7, 'Evaporator', 0, 1, 'Pc', 3580, '2024-09-09', 'Pending'),
(126, 10, 9, 'Evaporator', 1, 1, 'Pc', 3300, '2024-09-09', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `description`) VALUES
(1, 'roll', 'Roll'),
(2, 'pc', 'Piece'),
(3, 'box', 'Box'),
(4, 'sht', 'Sheet'),
(5, 'lngt', 'Lenght'),
(6, 'mtr', 'Meter'),
(7, 'pck', 'Package'),
(8, 'assy', 'Assembly'),
(9, 'lb', 'Pound'),
(10, 'kg', 'Kilogram'),
(11, 'ton', 'Tonage'),
(12, 'ltr', 'Liter');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usrid` int(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `account` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `photo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usrid`),
  UNIQUE KEY `emailadd` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usrid`, `fname`, `lname`, `email`, `username`, `password`, `account`, `status`, `photo`) VALUES
(1, 'Webmaster', 'Account', 'info@louiecaraircon.com', 'McJim', 'McJim654123', 'Webmaster', 1, 1),
(2, 'Proprietor', 'Account', 'code@louiecaraircon.com', 'Encoder', 'Proprietor', 'Proprietor', 1, 1),
(3, 'Encoder', 'Account', 'book@louiecaraircon.com', 'Bookeeper', 'Bookeeper', 'Encoder', 1, 1),
(6, 'Janeth', 'Suson', 'admin@victoryfreewifi.site', 'Sanji', 'Sanji', 'Encoder', 0, 1),
(5, 'Jessa', 'Billiones', 'jessa@gmail.com', 'ubnt', 'ubnt', 'Encoder', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `validity`
--

DROP TABLE IF EXISTS `validity`;
CREATE TABLE IF NOT EXISTS `validity` (
  `validity` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `validity`
--

INSERT INTO `validity` (`validity`) VALUES
('2030-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `vid` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `source` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`vid`, `title`, `source`) VALUES
(3, 'Test Video 2', 'https://www.youtube.com/watch?v=XoYu7K6Ywkg'),
(2, 'Test Video 1', 'https://www.youtube.com/watch?v=MsRz39o6fE8'),
(4, 'Test Video 3', 'https://www.youtube.com/watch?v=TP1xs1hF2ZE'),
(5, 'Test Video 4', 'https://www.youtube.com/watch?v=RQcMqHA8VPk');
