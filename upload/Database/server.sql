SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";

CREATE DATABASE IF NOT EXISTS server;
USE server;

--
-- Database: `server`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `pid` int(50) NOT NULL AUTO_INCREMENT,
  `pname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `plink` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pimgUrl` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=152 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`pid`, `pname`, `description`, `plink`, `pimgUrl`) VALUES
(1, 'Aircon Services System', 'Car Air Condioning Services System', 'carservices', 'img/favicon.png'),
(13, 'Enrollment System', 'School Enrollment System', 'enrollment', 'img/logo.png'),
(3, 'Online Voting System', 'Online Voting System', 'voting-system', 'images/vote0.png'),
(2, 'Event Counter System', 'Event Guest Counter System', 'eventcounter', 'images/favicon.png'),
(14, 'Family Connection', 'Family Connections/Tree System', 'familytree', 'favicon.png'),
(5, 'Inventory System', 'WiFi Installation Inventory System', 'inventory', 'img/favicon.png'),
(6, 'SB File Management', 'Municipal Legislative File Management System', 'legislativesys', 'favicon.png'),
(10, 'PLO Barangay Level', 'Precinct Level Organization Barangay Level', 'plo-bar-level', 'images/favicon.png'),
(9, 'PLO Barangay SK Level', 'Precinct Level Organization Barangay SK Level', 'plo-bsk-level', 'images/SK_logo.png'),
(11, 'PLO Municipal Level', 'Precinct Level Organization Municipal Level', 'plo-mun-level', 'images/logo.png'),
(12, 'PLO Provincial Level', 'Precinct Level Organization Provincial Level', 'plo-prv-level', 'images/app-logo.png'),
(15, 'Beauty Salon System', 'Beauty Salon System', 'salonsystem', 'images/salon.png'),
(7, 'School ID System', 'School ID System', 'school-idsys', 'images/div_logo.png'),
(8, 'LGU Services System', 'Local Government Services ID System', 'tabina-idsys', 'images/SEAL.png'),
(4, 'WiFi Sites Management', 'Victory Free WiFi Site Management', 'victoryfreewifi', 'assets/img/zdslogo.png'),
(16, 'Pesonnal Portfolio', 'Pesonnal Work Portfolio', 'webportfolio', 'images/favicon.png');

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  uno int NOT NULL,
  fullname varchar(100),
  username varchar(50),
  password varchar(255),
  access varchar(100),
  imgUrl varchar(100)
);

INSERT INTO users (uno, fullname, username, password, access, imgUrl) VALUES
(1, 'McJim Maata', 'McJim', 'Restricted654123', 'Admin', 'mcjim.jpg'),
(2, 'Rolly Joy Fernandez', 'rjxmyth', 'R3str1ct3d', 'Admin', '387.jpg'),
(3, 'Jelly Arcadio Impal', 'Jelly', 'Arcadio', 'User', 'employee.jpg'),
(4, 'Social Welfare', 'Social', 'Welfare', 'User', 'social.jpg');

DROP TABLE IF EXISTS validity;

CREATE TABLE validity (
  validity date DEFAULT NULL
);

INSERT INTO validity (validity) VALUES
('2030-06-20');