CREATE DATABASE IF NOT EXISTS wpenrolldb;
USE wpenrolldb;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";

--
-- Database: `wpenrolldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ay`
--

CREATE TABLE IF NOT EXISTS `ay` (
  `AY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACADYR` varchar(40) NOT NULL,
  PRIMARY KEY (`AY_ID`),
  UNIQUE KEY `acadyr` (`ACADYR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `CLASS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CLASS_CODE` varchar(30) NOT NULL,
  `ADVISER` varchar(30) NOT NULL,
  `SUBJ_ID` int(11) NOT NULL,
  `INST_ID` int(11) NOT NULL,
  `SYID` int(11) NOT NULL,
  `DAY` varchar(20) NOT NULL,
  `C_TIME` varchar(20) NOT NULL,
  `IDNO` int(11) NOT NULL,
  PRIMARY KEY (`CLASS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`CLASS_ID`, `CLASS_CODE`, `ADVISER`, `SUBJ_ID`, `INST_ID`, `SYID`, `DAY`, `C_TIME`, `IDNO`) VALUES
(3, 'GenED1', '', 1, 13, 0, 'MON', '7:00-8:00', 0),
(4, 'GenED2', '', 2, 21, 0, 'MON/THU', '9:00-10:30', 0),
(5, 'PATHFIT1', '', 10, 18, 0, 'MON', '11:00-1:00', 0),
(6, 'IT3', '', 5, 7, 0, 'TUE', '8:30-11:30', 0),
(7, 'NSTP1', '', 9, 40, 0, 'WED', '7:00-10:00', 0),
(8, 'IT4', '', 6, 42, 0, 'FRI', '7:00-11:00', 0),
(9, 'IT2', '', 4, 29, 0, 'SAT', '7:00-10:00', 0),
(10, 'ACT1', '', 8, 23, 0, 'SAT', '10:00-1:00', 0),
(11, 'IT5', '', 7, 5, 0, 'SAT', '1:00-4:00', 0),
(12, 'IT1', '', 3, 19, 0, 'SUN', '7:00-10:00', 0),
(13, 'IT9', '', 23, 17, 0, 'MON', '5:30-8:30', 0),
(14, 'IT10', '', 24, 29, 0, 'TUE', '5:30-8:30', 0),
(15, 'GenEd4', '', 22, 22, 0, 'WED', '5:30-8:30', 0),
(16, 'ACT6', '', 28, 10, 0, 'THU', '5:30-8:30', 0),
(17, 'ACT4', '', 18, 15, 0, 'FRI', '5:30-8:30', 0),
(18, 'IT11', '', 25, 7, 0, 'SAT', '5:30-8:30', 0),
(19, 'ACT7', '', 29, 6, 0, 'SUN', '5:30-8:30', 0),
(20, 'IT12', '', 26, 5, 0, 'SUN', '5:30-8:30', 0),
(21, 'PATHFIT3', '', 31, 14, 0, 'SUN', '5:30-8:30', 0),
(22, 'ACT5', '', 27, 35, 0, 'SUN', '5:30-8:30', 0),
(23, 'GEElec2', '', 38, 17, 0, 'MON', '5:30-8:30', 0),
(24, 'GEElec3', '', 39, 29, 0, 'TUE', '5:30-8:30', 0),
(25, 'GenEd6', '', 40, 23, 0, 'WED', '5:30-8:30', 0),
(26, 'IT14', '', 41, 10, 0, 'THU', '5:30-8:30', 0),
(27, 'IT15', '', 42, 15, 0, 'FRI', '5:30-8:30', 0),
(28, 'IT16', '', 43, 7, 0, 'SAT', '5:30-8:30', 0),
(29, 'IT17', '', 44, 23, 0, 'SUN', '5:30-8:30', 0),
(30, 'IT24', '', 53, 29, 0, 'MON', '5:30-8:30', 0),
(31, 'IT25', '', 54, 23, 0, 'TUE', '5:30-8:30', 0),
(32, 'IT26', '', 55, 17, 0, 'WED', '5:30-8:30', 0),
(33, 'GenED1', '', 121, 1, 0, 'MON', '7:00-8:00', 0),
(34, 'GE 2', '', 185, 8, 0, 'TUE', '5:30-8:30', 0),
(35, 'GenED4', '', 124, 42, 0, 'THU', '5:30-8:30', 0),
(36, 'GenED3', '', 12, 41, 0, 'FRI', '5:30-8:30', 0),
(37, 'GenED6', '', 126, 45, 0, 'SAT', '5:30-8:30', 0),
(38, 'GenED7', '', 127, 21, 0, 'SUN', '7:00-10:00', 0),
(39, 'WEL1', '', 128, 5, 0, 'SUN', '10:00-1:00', 0),
(40, 'NSTP1', '', 129, 2, 0, 'SUN', '10:00-1:00', 0),
(41, 'PathFit1', '', 130, 12, 0, 'SUN', '5:30-8:30', 0),
(42, 'ProfEd3', '', 141, 27, 0, 'MON', '7:00-8:00', 0),
(43, 'ProfEd4', '', 142, 32, 0, 'TUE', '9:00-10:30', 0),
(44, 'TTL1', '', 143, 23, 0, 'WED', '11:00-1:00', 0),
(45, 'ProfEd6', '', 144, 37, 0, 'THU', '8:30-11:30', 0),
(46, 'ProfEd7', '', 145, 37, 0, 'FRI', '8:30-11:30', 0),
(47, 'ProfEd8', '', 146, 11, 0, 'SAT', '10:00-1:00', 0),
(48, 'TLE1', '', 147, 41, 0, 'SUN', '7:00-10:00', 0),
(49, 'TLE2', '', 148, 28, 0, 'SUN', '10:00-1:00', 0),
(50, 'WEL3', '', 149, 25, 0, 'SUN', '7:00-11:00', 0),
(51, 'PathFit3', '', 150, 12, 0, 'SUN', '7:00-10:00', 0),
(52, 'GEElec3', '', 161, 3, 0, 'MON', '7:00-8:00', 0),
(53, 'TR1', '', 162, 33, 0, 'TUE', '9:00-10:30', 0),
(54, 'ICT2', '', 163, 24, 0, 'WED', '11:00-1:00', 0),
(55, 'WEL5', '', 164, 25, 0, 'THU', '9:00-10:30', 0),
(56, 'WEL6', '', 165, 25, 0, 'FRI', '8:30-11:30', 0),
(57, 'WEL8', '', 167, 25, 0, 'SAT', '8:30-11:30', 0),
(58, 'WEL7', '', 166, 25, 0, 'SUN', '7:00-10:00', 0),
(59, 'TLE5', '', 168, 24, 0, 'SUN', '10:00-1:00', 0),
(60, 'TLE6', '', 169, 24, 0, 'SUN', '7:00-11:00', 0),
(61, 'FS1', '', 179, 43, 0, 'MON', '5:30-8:30', 0),
(62, 'FS2', '', 180, 43, 0, 'TUE', '5:30-8:30', 0),
(63, 'OJT', '', 181, 32, 0, 'WED', '5:30-8:30', 0),
(64, 'GenED1', '', 58, 1, 0, 'MON', '5:30-8:30', 0),
(65, 'CSS1', '', 65, 5, 0, 'SUN', '10:00-1:00', 0),
(66, 'PathFit1', '', 67, 12, 0, 'SUN', '5:30-8:30', 0),
(67, 'CSS3', '', 86, 17, 0, 'SUN', '7:00-11:00', 0),
(68, 'GEElec3', '', 98, 3, 0, 'MON', '5:30-8:30', 0),
(69, 'ProfEd3', '', 78, 27, 0, 'MON', '5:30-8:30', 0),
(70, 'ProfEd4', '', 79, 32, 0, 'TUE', '5:30-8:30', 0),
(71, 'TTL1', '', 80, 23, 0, 'WED', '5:30-8:30', 0),
(72, 'ProfEd6', '', 81, 37, 0, 'THU', '5:30-8:30', 0),
(73, 'ProfEd7', '', 82, 37, 0, 'FRI', '5:30-8:30', 0),
(74, 'ProfEd8', '', 83, 11, 0, 'SAT', '5:30-8:30', 0),
(75, 'TLE1', '', 84, 41, 0, 'SUN', '5:30-8:30', 0),
(76, 'TLE2', '', 85, 28, 0, 'SUN', '10:00-1:00', 0),
(77, 'CSS4', '', 94, 17, 0, 'SUN', '3:30-5:30', 0),
(78, 'PathFit4', '', 97, 12, 0, 'SUN', '5:30-8:30', 0),
(80, 'TR1', '', 99, 33, 0, 'TUE', '5:30-8:30', 0),
(81, 'ICT2', '', 100, 24, 0, 'WED', '5:30-8:30', 0),
(82, 'CSS5', '', 101, 25, 0, 'THU', '5:30-8:30', 0),
(83, 'CSS7', '', 103, 25, 0, 'SAT', '5:30-8:30', 0),
(84, 'CSS8', '', 104, 21, 0, 'SUN', '7:00-10:00', 0),
(85, 'TLE5', '', 105, 24, 0, 'SUN', '10:00-1:00', 0),
(86, 'TLE6', '', 106, 24, 0, 'SUN', '1:00-4:00', 0),
(87, 'CSS6', '', 102, 25, 0, 'FRI', '5:30-8:30', 0),
(88, 'FS1', '', 116, 43, 0, 'MON', '5:30-8:30', 0),
(89, 'FS2', '', 117, 43, 0, 'TUE', '5:30-8:30', 0),
(90, 'OJT', '', 118, 32, 0, 'WED', '5:30-8:30', 0),
(91, 'ELS103', '', 183, 46, 0, 'MON', '5:30-8:30', 0),
(92, 'GE1', '', 184, 41, 0, 'TUE', '5:30-8:30', 0),
(93, 'GE3', '', 186, 14, 0, 'THU', '5:30-8:30', 0),
(94, 'GE4', '', 187, 12, 0, 'FRI', '5:30-8:30', 0),
(95, 'NSTP1', '', 188, 40, 0, 'SAT', '5:30-8:30', 0),
(96, 'PATHFIT1', '', 189, 12, 0, 'SUN', '7:00-10:00', 0),
(97, 'ELS136', '', 197, 46, 0, 'MON', '5:30-8:30', 0),
(98, 'ELS104', '', 198, 45, 0, 'WED', '5:30-8:30', 0),
(99, 'ELS105', '', 199, 14, 0, 'THU', '5:30-8:30', 0),
(100, 'ELS131', '', 201, 12, 0, 'FRI', '5:30-8:30', 0),
(101, 'ELS132', '', 202, 40, 0, 'SAT', '10:00- 1:00', 0),
(102, 'PATHFIT3', '', 204, 12, 0, 'SAT', '1:00-4:00', 0),
(103, 'ELS122', '', 203, 12, 0, 'SUN', '7:00-10:00', 0),
(104, 'ELS107', '', 212, 44, 0, 'MON', '5:30-8:30', 0),
(105, 'ELS108', '', 213, 44, 0, 'TUE', '5:30-8:30', 0),
(106, 'ELS111', '', 214, 9, 0, 'WED', '5:30-8:30', 0),
(107, 'ELS112', '', 215, 36, 0, 'THU', '5:30-8:30', 0),
(108, 'FL3', '', 223, 39, 0, 'SAT', '10:00-1:00', 0),
(109, 'FL2', '', 217, 28, 0, 'SAT', '10:00-1:00', 0),
(110, 'ELS200', '', 224, 46, 0, 'MON', '5:30-8:30', 0),
(111, 'ELS135', '', 225, 41, 0, 'TUE', '5:30-8:30', 0),
(112, 'ELS137', '', 226, 45, 0, 'WED', '5:30-8:30', 0),
(113, 'ELS126', '', 227, 14, 0, 'THU', '5:30-8:30', 0),
(114, 'FL4', '', 228, 12, 0, 'FRI', '5:30-8:30', 0),
(115, 'GenED8', '', 131, 27, 0, 'MON', '7:00-8:00', 0),
(116, 'GenED9', '', 132, 32, 0, 'TUE', '9:00-10:30', 0),
(117, 'GenED10', '', 133, 23, 0, 'WED', '11:00-1:00', 0),
(118, 'GE Elec1', '', 134, 37, 0, 'THU', '8:30-11:30', 0),
(119, 'GE Elec2', '', 135, 37, 0, 'FRI', '8:30-11:30', 0),
(120, 'WEL2', '', 136, 11, 0, 'SAT', '10:00-1:00', 0),
(121, 'ProfED2', '', 138, 22, 0, 'SUN', '7:00-11:00', 0),
(122, 'NSTP2', '', 139, 37, 0, 'SUN', '7:00-8:00', 0),
(123, 'ProfEd10', '', 151, 27, 0, 'MON', '7:00-8:00', 0),
(125, 'ProfEd5', '', 153, 11, 0, 'WED', '8:30-11:30', 0),
(126, 'ProfEd9', '', 155, 11, 0, 'SAT', '7:00-10:00', 0),
(127, 'ICT1', '', 156, 28, 0, 'SAT', '10:00-1:00', 0),
(128, 'WEL4', '', 157, 22, 0, 'SAT', '7:00-11:00', 0),
(129, 'TLE3', '', 158, 17, 0, 'SAT', '7:00-8:00', 0),
(130, 'PathFit4', '', 160, 12, 0, 'SUN', '9:00-10:30', 0),
(131, 'GEElec4', '', 170, 7, 0, 'MON', '5:30-8:30', 0),
(132, 'TR2', '', 171, 33, 0, 'TUE', '5:30-8:30', 0),
(133, 'WEL9', '', 172, 25, 0, 'WED', '5:30-8:30', 0),
(134, 'WEL10', '', 173, 25, 0, 'THU', '5:30-8:30', 0),
(135, 'WEL11', '', 174, 25, 0, 'FRI', '5:30-8:30', 0),
(136, 'TLE7', '', 176, 32, 0, 'SAT', '5:30-8:30', 0),
(137, 'TLE8', '', 177, 35, 0, 'SUN', '7:00-10:00', 0),
(138, 'TTL3', '', 178, 24, 0, 'SUN', '10:00-1:00', 0),
(139, 'FS3', '', 182, 43, 0, 'MON', '5:30-8:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `COURSE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `COURSE_NAME` varchar(30) NOT NULL,
  `COURSE_LEVEL` int(11) NOT NULL DEFAULT '1',
  `COURSE_MAJOR` varchar(30) NOT NULL DEFAULT '',
  `COURSE_DESC` varchar(255) NOT NULL,
  `DEPT_ID` int(11) NOT NULL,
  PRIMARY KEY (`COURSE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`COURSE_ID`, `COURSE_NAME`, `COURSE_LEVEL`, `COURSE_MAJOR`, `COURSE_DESC`, `DEPT_ID`) VALUES
(1, 'BSIT', 1, 'None', 'Bachelor of Science in Information Technology', 1),
(2, 'BSIT', 2, 'None', 'Bachelor of Science in Information Technology', 1),
(3, 'BSIT', 3, 'None', 'Bachelor of Science in Information Technology', 1),
(4, 'BSIT', 4, 'None', 'Bachelor of Science in Information Technology', 1),
(5, 'BAELS', 1, 'None', 'Bachelor of Arts in English Language Studies', 1),
(6, 'BAELS', 2, 'None', 'Bachelor of Arts in English Language Studies', 1),
(7, 'BAELS', 3, 'None', 'Bachelor of Arts in English Language Studies', 1),
(8, 'BAELS', 4, 'None', 'Bachelor of Arts in English Language Studies', 1),
(9, 'BTVTED', 1, 'CHS', 'Bachelor of Technical-Vocational Teacher Education', 1),
(10, 'BTVTED', 2, 'CHS', 'Bachelor of Technical-Vocational Teacher Education', 1),
(11, 'BTVTED', 3, 'CHS', 'Bachelor of Technical-Vocational Teacher Education', 1),
(12, 'BTVTED', 4, 'CHS', 'Bachelor of Technical-Vocational Teacher Education', 1),
(13, 'BTVTED', 1, 'WFT', 'Bachelor of Technical-Vocational Teacher Education', 1),
(14, 'BTVTED', 2, 'WFT', 'Bachelor of Technical-Vocational Teacher Education', 1),
(15, 'BTVTED', 3, 'WFT', 'Bachelor of Technical-Vocational Teacher Education', 1),
(16, 'BTVTED', 4, 'WFT', 'Bachelor of Technical-Vocational Teacher Education', 1),
(17, 'ACT', 1, 'Multimedia', 'Assiciate In Computer Technology', 1),
(18, 'ACT', 2, 'Multimedia', 'Assiciate In Computer Technology', 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `DEPT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEPARTMENT_NAME` varchar(30) NOT NULL,
  `DEPARTMENT_DESC` varchar(50) NOT NULL,
  PRIMARY KEY (`DEPT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DEPT_ID`, `DEPARTMENT_NAME`, `DEPARTMENT_DESC`) VALUES
(1, 'College', 'College Department');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `GRADE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDNO` int(11) NOT NULL,
  `SUBJ_ID` int(11) NOT NULL,
  `INST_ID` int(11) NOT NULL,
  `SYID` int(30) NOT NULL,
  `PRE` int(11) NOT NULL,
  `MID` int(11) NOT NULL,
  `FIN` int(11) NOT NULL,
  `FIN_AVE` int(11) NOT NULL,
  `REMARKS` text NOT NULL,
  PRIMARY KEY (`GRADE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE IF NOT EXISTS `instructor` (
  `INST_ID` int(30) NOT NULL AUTO_INCREMENT,
  `INST_FULLNAME` varchar(255) NOT NULL,
  `INST_ADDRESS` varchar(255) NOT NULL,
  `INST_SEX` varchar(20) NOT NULL DEFAULT 'Male',
  `INST_STATUS` varchar(20) NOT NULL DEFAULT 'Single',
  `SPECIALIZATION` text NOT NULL,
  `INST_EMAIL` varchar(255) NOT NULL,
  `EMPLOYMENT_STATUS` varchar(40) NOT NULL DEFAULT 'Probationary',
  PRIMARY KEY (`INST_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`INST_ID`, `INST_FULLNAME`, `INST_ADDRESS`, `INST_SEX`, `INST_STATUS`, `SPECIALIZATION`, `INST_EMAIL`, `EMPLOYMENT_STATUS`) VALUES
(1, 'Abacahin', '', 'M', '', '', '', ''),
(2, 'Abarquez', '', 'M', '', '', '', ''),
(3, 'Biadnes', '', 'M', '', '', '', ''),
(4, 'Binag', '', 'M', '', '', '', ''),
(5, 'Cabardo', '', 'M', '', '', '', ''),
(6, 'Calanda', '', 'M', '', '', '', ''),
(7, 'Casocot', '', 'M', '', '', '', ''),
(8, 'Corita', '', 'M', '', '', '', ''),
(9, 'Cruz ', '', 'M', '', '', '', ''),
(10, 'Dacalos', '', 'M', '', '', '', ''),
(11, 'Ellunado', '', 'M', '', '', '', ''),
(12, 'Eric', '', 'M', '', '', '', ''),
(13, 'Esio', '', 'M', '', '', '', ''),
(14, 'Francisco', '', 'M', '', '', '', ''),
(15, 'Ganding', '', 'M', '', '', '', ''),
(16, 'Generale', '', 'M', '', '', '', ''),
(17, 'Gomez', '', 'M', '', '', '', ''),
(18, 'Lacida', '', 'M', '', '', '', ''),
(19, 'Lee', '', 'M', '', '', '', ''),
(20, 'Lerazan', '', 'M', '', '', '', ''),
(21, 'Linao', '', 'M', '', '', '', ''),
(22, 'Llagas A', '', 'M', '', '', '', ''),
(23, 'Llagas J', '', 'M', '', '', '', ''),
(24, 'Madelo', '', 'M', '', '', '', ''),
(25, 'Poloyapoy', '', 'M', '', '', '', ''),
(26, 'Sebial', '', 'M', '', '', '', ''),
(27, 'Tanola', '', 'M', '', '', '', ''),
(28, 'Tario', '', 'M', '', '', '', ''),
(29, 'Watamama', '', 'M', '', '', '', ''),
(31, 'Batinggal', '', 'F', '', '', '', ''),
(32, 'Biadnes Ms', '', 'F', '', '', '', ''),
(33, 'Bincal', '', 'F', '', '', '', ''),
(34, 'Caliguid', '', 'F', '', '', '', ''),
(35, 'Canete', '', 'F', '', '', '', ''),
(36, 'Cantanio', '', 'F', '', '', '', ''),
(37, 'Dequit', '', 'M', '', '', '', ''),
(38, 'Fuentes', '', 'F', '', '', '', ''),
(39, 'Goloy', '', 'F', '', '', '', ''),
(40, 'Mustapha', '', 'F', '', '', '', ''),
(41, 'Pacilan', '', 'F', '', '', '', ''),
(42, 'Ramboy', '', 'F', '', '', '', ''),
(43, 'Rapadas', '', 'F', '', '', '', ''),
(44, 'Salomes', '', 'F', '', '', '', ''),
(45, 'Simbajon', '', 'F', '', '', '', ''),
(46, 'Batingal', '', 'F', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `YR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LEVEL` varchar(30) NOT NULL,
  `LEVEL_DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`YR_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE IF NOT EXISTS `major` (
  `MAJOR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MAJOR_NAME` varchar(30) NOT NULL,
  `MAJOR_DESC` varchar(200) NOT NULL,
  PRIMARY KEY (`MAJOR_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`MAJOR_ID`, `MAJOR_NAME`, `MAJOR_DESC`) VALUES
(1, 'IT', 'Information Technology'),
(2, 'ELS', 'English Language Studies'),
(3, 'CHS', 'Computer Hardware Servicing'),
(4, 'WFT', 'Welding and Fabrication Technology'),
(5, 'MMS', 'Multimedia');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `PHOTO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FILENAME` text NOT NULL,
  `TYPE` varchar(30) NOT NULL,
  `SIZE` int(30) NOT NULL,
  `CAPTION` varchar(255) NOT NULL,
  `IDNO` int(11) NOT NULL,
  `MAIN` varchar(20) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`PHOTO_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `ROOM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROOM_NAME` varchar(30) NOT NULL,
  PRIMARY KEY (`ROOM_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`ROOM_ID`, `ROOM_NAME`) VALUES
(1, '101'),
(2, '102'),
(3, '201'),
(4, '202'),
(5, '301'),
(6, '302'),
(7, '303'),
(8, '304'),
(9, '401'),
(10, '402'),
(11, 'B-2'),
(12, 'LIB');

-- --------------------------------------------------------

--
-- Table structure for table `schoolyr`
--

CREATE TABLE IF NOT EXISTS `schoolyr` (
  `SYID` int(11) NOT NULL AUTO_INCREMENT,
  `COURSE_ID` int(11) NOT NULL,
  `SEMESTER` varchar(20) NOT NULL,
  `AY` varchar(30) NOT NULL,
  `IDNO` int(30) NOT NULL,
  `CATEGORY` varchar(30) NOT NULL DEFAULT 'RESERVED',
  `DATE_RESERVED` datetime NOT NULL,
  `DATE_ENROLLED` datetime NOT NULL,
  `STATUS` varchar(30) NOT NULL DEFAULT 'New',
  PRIMARY KEY (`SYID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `schoolyr`
--

INSERT INTO `schoolyr` (`SYID`, `COURSE_ID`, `SEMESTER`, `AY`, `IDNO`, `CATEGORY`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`) VALUES
(1, 1, 'First', '2024-2025', 0, 'RESERVED', '2024-06-19 19:57:39', '0000-00-00 00:00:00', 'New'),
(2, 1, 'First', '2024-2025', 0, 'RESERVED', '2024-06-20 00:38:13', '0000-00-00 00:00:00', 'New'),
(3, 1, 'First', '2024-2025', 0, 'RESERVED', '2024-06-20 00:41:38', '0000-00-00 00:00:00', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE IF NOT EXISTS `semester` (
  `SEMID` int(11) NOT NULL AUTO_INCREMENT,
  `SEMESTER` varchar(40) NOT NULL,
  PRIMARY KEY (`SEMID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`SEMID`, `SEMESTER`) VALUES
(1, 'First'),
(2, 'Second'),
(3, 'Summer');

-- --------------------------------------------------------

--
-- Table structure for table `stype`
--

CREATE TABLE IF NOT EXISTS `stype` (
  `STID` int(11) NOT NULL AUTO_INCREMENT,
  `STYPE` varchar(40) NOT NULL,
  PRIMARY KEY (`STID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `stype`
--

INSERT INTO `stype` (`STID`, `STYPE`) VALUES
(1, 'New Student'),
(2, 'Old Student'),
(3, 'Returning'),
(4, 'Transferee');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `SUBJ_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUBJ_CODE` varchar(30) NOT NULL,
  `SUBJ_DESCRIPTION` varchar(255) NOT NULL,
  `UNIT` int(2) NOT NULL,
  `PRE_REQUISITE` varchar(30) NOT NULL DEFAULT 'None',
  `COURSE_ID` int(11) NOT NULL,
  `AY` varchar(30) NOT NULL,
  `SEMESTER` varchar(20) NOT NULL,
  `COURSE_LEVEL` varchar(20) NOT NULL,
  PRIMARY KEY (`SUBJ_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=268 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SUBJ_ID`, `SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`, `COURSE_ID`, `AY`, `SEMESTER`, `COURSE_LEVEL`) VALUES
(1, 'GenED1', 'Math in the Modern World', 3, '', 1, '2013-2014', 'First', ''),
(2, 'GenED2', 'Mga Babasahin Hinggil sa  Kasaysayan ng Pilipinas', 3, '', 1, '2013-2014', 'First', ''),
(3, 'IT1', 'Introduction to Computing', 3, '', 1, '2013-2014', 'First', ''),
(4, 'IT2', 'Computer Programming 1 (Fundamentals of Programming)', 3, '', 1, '2013-2014', 'First', ''),
(5, 'IT3', 'Professional Issues in Computing', 3, '', 1, '2013-2014', 'First', ''),
(6, 'IT4', 'Human Computer Interaction 1', 3, '', 1, '2013-2014', 'First', ''),
(7, 'IT5', 'Platform Technologies', 3, '', 1, '2013-2014', 'First', ''),
(8, 'ACT1', 'Freehand and Digital Drawing', 3, '', 1, '2013-2014', 'First', ''),
(9, 'NSTP1', 'Civil Welfare Training Service (CWTS) 1', 3, '', 1, '2013-2014', 'First', ''),
(10, 'PATHFIT1', 'Physical Activities Towards Health and Fitness 1', 2, '', 1, '2013-2014', 'First', ''),
(11, 'GE Elec1', 'Life, Works and Writings of Rizal ', 3, '', 1, '2013-2014', 'First', ''),
(12, 'GenED3', 'Purposive Communication', 3, '', 1, '2013-2014', 'First', ''),
(13, 'IT6', 'Computer Programming 2', 3, '', 1, '2013-2014', 'First', ''),
(14, 'IT7', 'Discrete Mathematics', 3, '', 1, '2013-2014', 'First', ''),
(15, 'IT8', 'Fundamentals of Database Systems', 3, '', 1, '2013-2014', 'First', ''),
(16, 'ACT2', 'Graphic Design', 3, '', 1, '2013-2014', 'First', ''),
(17, 'ACT3', 'Website Design', 3, '', 1, '2013-2014', 'First', ''),
(18, 'ACT4', 'Web Development 1', 3, '', 1, '2013-2014', 'First', ''),
(19, 'NSTP2', 'Civil Welfare Training Service (CWTS) 2', 3, '', 1, '2013-2014', 'First', ''),
(20, 'PE2', 'Physical Activities Towards Health and Fitness 2', 2, '', 1, '2024-2025', 'Second', ''),
(21, 'OJT1', 'Internship (160 hours minimum)', 3, '', 1, '2024-2025', 'Summer', ''),
(22, 'GenEd4', 'Pag unawa sa Sarili', 3, '', 2, '2013-2014', 'First', ''),
(23, 'IT9', 'Data Structure and Algorithms', 3, '', 2, '2024-2025', 'First', ''),
(24, 'IT10', 'Information Management 1', 3, '', 2, '2024-2025', 'First', ''),
(25, 'IT11', 'Application Development and Emerging Technologies', 3, '', 1, '2013-2014', 'First', ''),
(26, 'IT12', 'Information, Assurance and Security 1', 3, '', 2, '2024-2025', 'First', ''),
(27, 'ACT5', 'Script Writing & Story Board Design', 3, '', 2, '2024-2025', 'First', ''),
(28, 'ACT6', 'Principles of 2D Design', 3, '', 2, '2024-2025', 'First', ''),
(29, 'ACT7', 'Mobile Application Development', 3, '', 2, '2024-2025', 'First', ''),
(30, 'ACT8', 'Web Development 2', 3, '', 2, '2024-2025', 'First', ''),
(31, 'PATHFIT3', 'Physical Activities Towards Health and Fitness 3', 2, '', 2, '2024-2025', 'First', ''),
(32, 'GenED5', 'Art Appreciation', 3, '', 2, '2024-2025', 'Second', ''),
(33, 'IT13', 'Object Oriented Programming', 3, '', 2, '2024-2025', 'Second', ''),
(34, 'IT14', 'Web System and Technologies', 3, '', 2, '2024-2025', 'Second', ''),
(35, 'ACT9', 'GUI-Based Application Development (with project)', 3, '', 2, '2013-2014', 'First', ''),
(36, 'PATHFIT4', 'Physical Activities Towards Health and Fitness 4', 2, '', 2, '2024-2025', 'Second', ''),
(37, 'OJT2', 'Internship (160 hours minimum) ', 3, '', 2, '2024-2025', 'Second', ''),
(38, 'GEElec2', 'Philippine Indigenous Communities', 3, '', 3, '2024-2025', 'First', ''),
(39, 'GEElec3', 'Living in the IT Era', 3, '', 3, '2024-2025', 'First', ''),
(40, 'GenEd6', 'Science and Technology', 3, '', 3, '2024-2025', 'First', ''),
(41, 'IT14', 'Integrative Programming Technologies 1', 3, '', 3, '2024-2025', 'First', ''),
(42, 'IT15', 'Quantitative Methods Including Modelling and Simulation', 3, '', 3, '2024-2025', 'First', ''),
(43, 'IT16', 'Data Communication and Networking 1', 3, '', 3, '2024-2025', 'First', ''),
(44, 'IT17', 'System Integration and Architecture 1', 3, '', 3, '2024-2025', 'First', ''),
(45, 'GenEd7', 'Ethics', 3, '', 3, '2024-2025', 'Second', ''),
(46, 'GenEd8', 'The Contemporary World', 3, '', 3, '2024-2025', 'Second', ''),
(47, 'IT18', 'Human Computer Interaction 2', 3, '', 3, '2024-2025', 'Second', ''),
(48, 'IT19', 'Information, Assurance and Security 2', 3, '', 3, '2024-2025', 'Second', ''),
(49, 'IT20', 'Capstone Project 1 & Research 1', 3, '', 3, '2024-2025', 'Second', ''),
(50, 'IT21', 'Networking 2', 3, '', 3, '2024-2025', 'Second', ''),
(51, 'IT22', 'Methods Of Research In Computing', 3, '', 3, '2024-2025', 'Second', ''),
(52, 'IT23', 'Integrative Programming Technologies 2', 3, '', 3, '2024-2025', 'Second', ''),
(53, 'IT24', 'System Integration And Architecture 2', 3, '', 4, '2024-2025', 'First', ''),
(54, 'IT25', 'System Administration And Maintenance', 3, '', 4, '2024-2025', 'First', ''),
(55, 'IT26', 'Capstone Project 2 & Research 2', 3, '', 4, '2024-2025', 'First', ''),
(56, 'GEElec4', 'Gender and Society', 3, '', 4, '2024-2025', 'Second', ''),
(57, 'OJT', 'Practicum (486 Hours)', 6, '', 4, '2024-2025', 'Second', ''),
(58, 'GenED1', 'Pag unawa sa sarili', 3, '', 9, '2024-2025', 'First', ''),
(59, 'GenED2', 'Mga Babasahin Hinggil sa  Kasaysayan ng Pilipinas', 3, '', 9, '2024-2025', 'First', ''),
(60, 'GenED3', 'Math in the Modern World', 3, '', 9, '2024-2025', 'First', ''),
(61, 'GenED4', 'Science, Technology and Society', 3, '', 9, '2024-2025', 'First', ''),
(62, 'GenED5', 'Purposive Communication', 3, '', 9, '2024-2025', 'First', ''),
(63, 'GenED6', 'Life, Works and Writing of Rizal', 3, '', 9, '2024-2025', 'First', ''),
(64, 'GenED7', 'Peace Education', 3, '', 9, '2024-2025', 'First', ''),
(65, 'CSS1', 'Office Productivity', 3, '', 9, '2024-2025', 'First', ''),
(66, 'NSTP1', 'Civil Welfare Training Service (CWTS)', 3, '', 1, '2013-2014', 'First', ''),
(67, 'PathFit1', 'Movement Competency Training', 2, '', 9, '2024-2025', 'First', ''),
(68, 'GenED8', 'The Contemporary World', 3, '', 9, '2024-2025', 'Second', ''),
(69, 'GenED9', 'Ethics', 3, '', 9, '2024-2025', 'Second', ''),
(70, 'GenED10', 'Art Appreciation', 3, '', 9, '2024-2025', 'Second', ''),
(71, 'GE Elec1', 'Philippine Indigenous and IPâ€™s Education', 3, '', 9, '2024-2025', 'Second', ''),
(72, 'GE Elec2', 'Gender and Society', 3, '', 9, '2024-2025', 'Second', ''),
(73, 'CSS2', 'Human Computer Interaction', 3, '', 9, '2024-2025', 'Second', ''),
(74, 'ProfED1', 'The Child Adolescent Learner and Learning Principle', 3, '', 9, '2024-2025', 'Second', ''),
(75, 'ProfED2', 'The Teaching Profession', 3, '', 9, '2024-2025', 'Second', ''),
(76, 'NSTP2', 'Civil Welfare Training Service (CWTS)', 3, '', 1, '2013-2014', 'First', ''),
(77, 'PathFit2', 'Exercise - Based Fitness Activities', 2, '', 9, '2024-2025', 'Second', ''),
(78, 'ProfEd3', 'Social Dimension', 3, '', 10, '2024-2025', 'First', ''),
(79, 'ProfEd4', 'Facilitating the Learner-Centered Approaches with Emphasis on Trainerâ€™s Methodology 1', 3, '', 10, '2024-2025', 'First', ''),
(80, 'TTL1', 'Technology for Teaching and Learning 1', 3, '', 10, '2024-2025', 'First', ''),
(81, 'ProfEd6', 'Building and Enhancing New Literacies across the Curriculum with Emphasis on the 21st Century Learners', 3, '', 10, '2024-2025', 'First', ''),
(82, 'ProfEd7', 'The Andragogy of Learning Including Principles of Trainerâ€™s Methodology', 3, '', 10, '2024-2025', 'First', ''),
(83, 'ProfEd8', 'Assessment of Learning 1', 3, '', 10, '2024-2025', 'First', ''),
(84, 'TLE1', 'Entrepreneurship', 3, '', 10, '2024-2025', 'First', ''),
(85, 'TLE2', 'Introduction to Industrial Arts', 3, '', 10, '2024-2025', 'First', ''),
(86, 'CSS3', 'Computer Programming 1', 3, '', 10, '2024-2025', 'First', ''),
(87, 'PathFit3', 'Dance', 2, '', 1, '2013-2014', 'First', ''),
(88, 'ProfEd10', 'The Teacher and the Community, School Culture and Organizational Leadership with Focus on the Philippines TVET System', 3, '', 10, '2024-2025', 'Second', ''),
(89, 'TTL2', 'Technology for Teaching and Learning 2', 3, '', 10, '2024-2025', 'Second', ''),
(90, 'ProfEd5', 'Curriculum Development and Evaluation with Emphasis on Trainerâ€™s Methodology 2', 3, '', 10, '2024-2025', 'Second', ''),
(91, 'ProfEd11', 'Foundation of Special and Inclusive Education', 3, '', 10, '2024-2025', 'Second', ''),
(92, 'ProfEd9', 'Assessment of Learning 2', 3, '', 10, '2024-2025', 'Second', ''),
(93, 'ICT1', 'Teaching ICT as an Exploratory Course', 3, '', 10, '2024-2025', 'Second', ''),
(94, 'CSS4', 'Computer Programming 2', 3, '', 10, '2024-2025', 'Second', ''),
(95, 'TLE3', 'Introduction to AFA', 3, '', 10, '2024-2025', 'Second', ''),
(96, 'TLE4', 'HE Literacy', 3, '', 10, '2024-2025', 'Second', ''),
(97, 'PathFit4', 'Sports', 2, '', 10, '2024-2025', 'Second', ''),
(98, 'GEElec3', 'Philippine and Popular Culture', 3, '', 11, '2024-2025', 'First', ''),
(99, 'TR1', 'Technology Research 1', 3, '', 11, '2024-2025', 'First', ''),
(100, 'ICT2', 'ICT Standard and Competencies from Pedagogical Dimension', 3, '', 11, '2024-2025', 'First', ''),
(101, 'CSS5', 'Introduction to Multimedia', 3, '', 11, '2024-2025', 'First', ''),
(102, 'CSS6', 'Database Management System 1', 3, '', 11, '2024-2025', 'First', ''),
(103, 'CSS7', 'PC Troubleshooting Maintenance', 3, '', 11, '2024-2025', 'First', ''),
(104, 'CSS8', 'Capstone Project 1', 3, '', 11, '2024-2025', 'First', ''),
(105, 'TLE5', 'Teaching Common Competencies in IA', 3, '', 11, '2024-2025', 'First', ''),
(106, 'TLE6', 'Teaching Common Competencies in ICT', 3, '', 11, '2024-2025', 'First', ''),
(107, 'GEElec4', 'Living in the IT Era', 3, '', 11, '2024-2025', 'Second', ''),
(108, 'TR2', 'Technology Research 2', 3, '', 11, '2024-2025', 'Second', ''),
(109, 'CSS9', 'Database Management 2', 3, '', 11, '2024-2025', 'Second', ''),
(110, 'CSS10', 'Capstone Project 2', 3, '', 11, '2024-2025', 'Second', ''),
(111, 'CSS11', 'Network Admin and Maintenance', 3, '', 11, '2024-2025', 'Second', ''),
(112, 'CSS12', 'Computer System and Data Security', 3, '', 11, '2024-2025', 'Second', ''),
(113, 'TLE7', 'Teaching Common Competencies in AFA', 3, '', 11, '', 'Second', ''),
(114, 'TLE8', 'Teaching Common Competencies in HE', 3, '', 11, '2024-2025', 'Second', ''),
(115, 'TTL3', 'Work-Based Learning with Emphasis on Trainerâ€™s Methodology', 3, '', 11, '2024-2025', 'Second', ''),
(116, 'FS1', 'Field Study 1', 3, '', 12, '2024-2025', 'First', ''),
(117, 'FS2', 'Field Study 2', 3, '', 12, '2024-2025', 'First', ''),
(118, 'OJT', 'Supervised Industrial Training', 3, '', 12, '2024-2025', 'First', ''),
(119, 'FS3', 'Teaching Internship / Practice Teaching', 6, '', 12, '2024-2025', 'Second', ''),
(120, 'LETRev', 'Review In-house LET Review Course', 6, '', 12, '2024-2025', 'Second', ''),
(121, 'GenED1', 'Pag unawa sa sarili', 3, '', 13, '2024-2025', 'First', ''),
(122, 'GenED2', 'Mga Babasahin Hinggil sa  Kasaysayan ng Pilipinas', 3, '', 9, '2024-2025', 'First', ''),
(123, 'GenED3', 'Math in the Modern World', 3, '', 13, '2024-2025', 'First', ''),
(124, 'GenED4', 'Science and Technology', 3, '', 13, '2024-2025', 'First', ''),
(125, 'GenED5', 'Purposive Communication', 3, '', 13, '2024-2025', 'First', ''),
(126, 'GenED6', 'Life, Works and Writing of Rizal', 3, '', 13, '2024-2025', 'First', ''),
(127, 'GenED7', 'Peace Education', 3, '', 13, '2024-2025', 'First', ''),
(128, 'WEL1', 'Occupational Health and Safety', 3, '', 13, '2024-2025', 'First', ''),
(129, 'NSTP1', 'Civil Welfare Training Service (CWTS)', 3, '', 13, '2024-2025', 'First', ''),
(130, 'PathFit1', 'Movement Competency Training', 3, '', 13, '2024-2025', 'First', ''),
(131, 'GenED8', 'The Contemporary World', 3, '', 13, '2024-2025', 'Second', ''),
(132, 'GenED9', 'Ethics', 3, '', 13, '2024-2025', 'Second', ''),
(133, 'GenED10', 'Art Appreciation', 3, '', 13, '2024-2025', 'Second', ''),
(134, 'GE Elec1', 'Philippine Indigenous and IPâ€™s Education', 3, '', 13, '2024-2025', 'Second', ''),
(135, 'GE Elec2', 'Gender and Society', 3, '', 13, '2024-2025', 'Second', ''),
(136, 'WEL2', 'Fundamentals of Welding', 3, '', 13, '2024-2025', 'Second', ''),
(137, 'ProfED1', 'The Child Adolescent Learner and Learning Principle', 3, '', 13, '', 'Second', ''),
(138, 'ProfED2', 'The Teaching Profession', 3, '', 13, '2024-2025', 'Second', ''),
(139, 'NSTP2', 'Civil Welfare Training Service (CWTS)', 3, '', 13, '2024-2025', 'Second', ''),
(140, 'PathFit2', 'Exercise - Based Fitness Activities', 2, '', 1, '2013-2014', 'First', ''),
(141, 'ProfEd3', 'Social Dimension', 3, '', 14, '2024-2025', 'First', ''),
(142, 'ProfEd4', 'Facilitating Learner-Centered Teaching: The Learner-Centered Approaches with Emphasis on Trainerâ€™s Methodology 1', 3, '', 14, '2024-2025', 'First', ''),
(143, 'TTL1', 'Technology for Teaching and Learning 1', 3, '', 14, '2024-2025', 'First', ''),
(144, 'ProfEd6', 'Building and Enhancing New Literacies Across the Curriculum with Emphasis on the 21st Century Learners', 3, '', 14, '2024-2025', 'First', ''),
(145, 'ProfEd7', 'The Andragogy of Learning Including Principles of Trainerâ€™s Methodology', 3, '', 14, '', 'First', ''),
(146, 'ProfEd8', 'Assessment of Learning 1', 3, '', 14, '2024-2025', 'First', ''),
(147, 'TLE1', 'Entrepreneurship', 3, '', 14, '2024-2025', 'First', ''),
(148, 'TLE2', 'Introduction to Industrial Arts', 3, '', 14, '2024-2025', 'First', ''),
(149, 'WEL3', 'Shielded Metal Arc Welding 1', 3, '', 14, '2024-2025', 'First', ''),
(150, 'PathFit3', 'Dances', 2, '', 14, '2024-2025', 'First', ''),
(151, 'ProfEd10', 'The Teacher and the Community, School Culture and Organizational Leadership with Focus on the Philippines TVET System', 3, '', 14, '2024-2025', 'Second', ''),
(152, 'TTL2', 'Technology for Teaching and Learning 2', 3, '', 14, '2024-2025', 'Second', ''),
(153, 'ProfEd5', 'Curriculum Development and Evaluation with Emphasis on Trainerâ€™s Methodology 2', 3, '', 14, '2024-2025', 'Second', ''),
(154, 'ProfEd11', 'Foundation of Special and Inclusive Education', 3, '', 14, '2024-2025', 'Second', ''),
(155, 'ProfEd9', 'Assessment of Learning 2', 3, '', 14, '2024-2025', 'Second', ''),
(156, 'ICT1', 'Teaching ICT as an Exploratory Course', 3, '', 14, '2024-2025', 'Second', ''),
(157, 'WEL4', 'Gas-Metal Arc Welding 1', 3, '', 14, '2024-2025', 'Second', ''),
(158, 'TLE3', 'Introduction to AFA', 3, '', 14, '2024-2025', 'Second', ''),
(159, 'TLE4', 'HE Literacy', 3, '', 14, '2024-2025', 'Second', ''),
(160, 'PathFit4', 'Sports', 3, '', 14, '2024-2025', 'Second', ''),
(161, 'GEElec3', 'Philippine and Popular Culture', 3, '', 15, '2024-2025', 'First', ''),
(162, 'TR1', 'Technology Research 1', 3, '', 15, '2024-2025', 'First', ''),
(163, 'ICT2', 'ICT Standard and Competencies from Pedagogical Dimension', 3, '', 15, '2024-2025', 'First', ''),
(164, 'WEL5', 'Shielded Metal Arc Welding 2', 3, '', 15, '2024-2025', 'First', ''),
(165, 'WEL6', 'Flux-Cored Arc Welding 1', 3, '', 15, '2024-2025', 'First', ''),
(166, 'WEL7', 'Gas Tungsten Arc Welding 1', 3, '', 15, '2024-2025', 'First', ''),
(167, 'WEL8', 'Submerged Arc Welding 1', 3, '', 15, '2024-2025', 'First', ''),
(168, 'TLE5', 'Teaching Common Competencies in IA', 3, '', 15, '2024-2025', 'First', ''),
(169, 'TLE6', 'Teaching Common Competencies in ICT', 3, '', 15, '2024-2025', 'First', ''),
(170, 'GEElec4', 'Living in the IT Era', 3, '', 15, '2024-2025', 'Second', ''),
(171, 'TR2', 'Technology Research 2', 3, '', 15, '2024-2025', 'Second', ''),
(172, 'WEL9', 'Gas Metal Arc Welding 2', 3, '', 15, '2024-2025', 'Second', ''),
(173, 'WEL10', 'Flux-Cored Arc Welding 2', 3, '', 15, '2024-2025', 'Second', ''),
(174, 'WEL11', 'Gas Tungsten Arc Welding 2', 3, '', 15, '2024-2025', 'Second', ''),
(175, 'WEL12', 'Submerged Arc Welding 2', 3, '', 15, '2024-2025', 'Second', ''),
(176, 'TLE7', 'Teaching Common Competencies in AFA', 3, '', 15, '2024-2025', 'Second', ''),
(177, 'TLE8', 'Teaching Common Competencies in HE', 3, '', 15, '2024-2025', 'Second', ''),
(178, 'TTL3', 'Work-Based Learning with Emphasis on Trainerâ€™s Methodology', 3, '', 15, '2024-2025', 'Second', ''),
(179, 'FS1', 'Field Study 1', 3, '', 16, '2024-2025', 'First', ''),
(180, 'FS2', 'Field Study 2', 3, '', 16, '2024-2025', 'First', ''),
(181, 'OJT', 'Supervised Industrial Training', 3, '', 16, '2024-2025', 'First', ''),
(182, 'FS3', 'Teaching Internship / Practice Teaching', 6, '', 16, '2024-2025', 'Second', ''),
(183, 'ELS103', 'History of the English Language', 3, '', 5, '2024-2025', 'First', ''),
(184, 'GE1', 'Purposive Communication', 3, '', 5, '2024-2025', 'First', ''),
(185, 'GE 2', 'Readings in the Philippine History', 3, '', 5, '2024-2025', 'First', ''),
(186, 'GE3', 'Mathematics in the Modern World', 3, '', 5, '2024-2025', 'First', ''),
(187, 'GE4', 'Art Appreciation', 3, '', 5, '2024-2025', 'First', ''),
(188, 'NSTP1', 'Civil Welfare Training Service (CWTS) 1', 3, '', 5, '2024-2025', 'First', ''),
(189, 'PATHFIT1', 'Movement Competency Training', 2, '', 5, '2024-2025', 'First', ''),
(190, 'ELS100', 'Introduction to the English Language System', 3, '', 5, '2024-2025', 'Second', ''),
(191, 'ELS102', 'Theories of Language & Language Acquisition', 3, '', 5, '2024-2025', 'Second', ''),
(192, 'GE5', 'Understanding the Self', 3, '', 5, '2024-2025', 'Second', ''),
(193, 'GE6', 'Ethics', 3, '', 5, '2024-2025', 'Second', ''),
(194, 'GE7', 'The Contemporary World', 3, '', 5, '2024-2025', 'Second', ''),
(195, 'NSTP2', 'Civil Welfare Training Service (CWTS) 2', 3, '', 5, '2024-2025', 'Second', ''),
(196, 'PATHFIT2', 'Exercise - Based Fitness Activities', 3, '', 5, '2024-2025', 'Second', ''),
(197, 'ELS136', 'Foundation of English Language Teaching and Learning', 3, '', 6, '2024-2025', 'First', ''),
(198, 'ELS104', 'English Phonology & Morphology', 3, '', 6, '2024-2025', 'First', ''),
(199, 'ELS105', 'English Syntax', 3, '', 6, '2024-2025', 'First', ''),
(200, 'ELS148', 'Intercultural Communication', 3, '', 6, '2024-2025', 'First', ''),
(201, 'ELS131', 'Language Policies & Programs', 3, '', 6, '2024-2025', 'First', ''),
(202, 'ELS132', 'Multilingualism & Multiculturalism', 3, '', 6, '2024-2025', 'First', ''),
(203, 'ELS122', 'Psychology of Language', 3, '', 6, '2024-2025', 'First', ''),
(204, 'PATHFIT3', 'Dances', 2, '', 6, '2024-2025', 'First', ''),
(205, 'ELS106', 'Semantics of English', 3, '', 6, '2024-2025', 'Second', ''),
(206, 'ELS109', 'Introduction to Language, Society and Culture', 3, '', 6, '2024-2025', 'Second', ''),
(207, 'FL1', 'Foreign Language 1 (Japanese 1)', 3, '', 6, '2024-2025', 'Second', ''),
(208, 'GE8', 'Science, Technology and Society', 3, '', 6, '2024-2025', 'Second', ''),
(209, 'ELS110', 'Language of Literary Text ', 3, '', 6, '2024-2025', 'Second', ''),
(210, 'ELS121', 'Introduction to Pragmatics', 3, '', 6, '2024-2025', 'Second', ''),
(211, 'PATHFIT4', 'Sports', 2, '', 6, '2024-2025', 'Second', ''),
(212, 'ELS107', 'English Discourse', 3, '', 7, '2024-2025', 'First', ''),
(213, 'ELS108', 'Stylistics', 3, '', 7, '2024-2025', 'First', ''),
(214, 'ELS111', 'Language of Non-Literary Text', 3, '', 7, '2024-2025', 'First', ''),
(215, 'ELS112', 'Computer-Mediated Communication', 3, '', 7, '2024-2025', 'First', ''),
(216, 'ELS123', 'Multimodal Communication', 3, '', 7, '2024-2025', 'First', ''),
(217, 'FL2', 'Foreign Language 2 (Japanese 2)', 3, '', 7, '2024-2025', 'First', ''),
(218, 'ELS199', 'Language Research I: Methodology', 3, '', 7, '2024-2025', 'Second', ''),
(219, 'GeEle1', 'Philippine Popular Culture', 3, '', 7, '2024-2025', 'Second', ''),
(220, 'ELS133', 'ELT Approaches and Method', 3, '', 7, '2024-2025', 'Second', ''),
(221, 'ELS134', 'Instructional Materials Development and Evaluation', 3, '', 7, '2024-2025', 'Second', ''),
(222, 'ELS124', 'Language and Gender', 3, '', 7, '2024-2025', 'Second', ''),
(223, 'FL3', 'Foreign Language 3 (Arabic 1)', 3, '', 7, '2024-2025', 'Second', ''),
(224, 'ELS200', 'Language Research II: Thesis', 3, '', 8, '2024-2025', 'First', ''),
(225, 'ELS135', 'English Language Testing and Assessment', 3, '', 8, '2024-2025', 'First', ''),
(226, 'ELS137', 'English Language Curriculum Development', 3, '', 8, '2024-2025', 'First', ''),
(227, 'ELS126', 'Translation Studies', 3, '', 8, '2024-2025', 'First', ''),
(228, 'FL4', 'Foreign Language 4 (Arabic 2)', 3, '', 8, '2024-2025', 'First', ''),
(229, 'ELS138', 'Technical Writing in the Profession', 3, '', 8, '2024-2025', 'Second', ''),
(230, 'ELS139', 'Business Communication', 3, '', 8, '2024-2025', 'Second', ''),
(231, 'GeElec2', 'Philippine Indigenous Communication', 3, '', 8, '2024-2025', 'Second', ''),
(232, 'GeElec3', 'Environmental Science', 3, '', 8, '2024-2025', 'Second', ''),
(233, 'GE9', 'Life, Works and Writings of Rizal', 3, '', 8, '2024-2025', 'Second', ''),
(234, 'GenED1', 'Math in the Modern World', 3, '', 17, '2024-2025', 'First', ''),
(235, 'GenED2', 'Mga Babasahin Hinggil sa  Kasaysayan', 3, '', 17, '2024-2025', 'First', ''),
(236, 'IT1', 'Introduction to Computing', 3, '', 17, '2024-2025', 'First', ''),
(237, 'IT2', 'Computer Programming 1 (Fundamentals of Programming)', 3, '', 17, '2024-2025', 'First', ''),
(238, 'IT3', 'Professional Issues in Computing', 3, '', 17, '2024-2025', 'First', ''),
(239, 'IT4', 'Human Computer Interaction 1', 3, '', 17, '2024-2025', 'First', ''),
(240, 'IT5', 'Platform Technologies', 3, '', 17, '2024-2025', 'First', ''),
(241, 'ACT1', 'Freehand and Digital Drawing', 3, '', 17, '2024-2025', 'First', ''),
(242, 'NSTP1', 'Civil Welfare Training Service (CWTS) 1', 3, '', 17, '2024-2025', 'First', ''),
(243, 'PATHFIT1', 'Physical Activities Towards Health and Fitness 1', 2, '', 17, '2024-2025', 'First', ''),
(244, 'GenElec1', 'Life, Works and Writings of Rizal', 3, '', 17, '2024-2025', 'Second', ''),
(245, 'GenED3', 'Purposive Communication', 3, '', 17, '2024-2025', 'Second', ''),
(246, 'IT6', 'Computer Programming 2 (Intermediate Programming)', 3, '', 17, '2024-2025', 'Second', ''),
(247, 'IT7', 'Discrete Mathematics', 3, '', 17, '2024-2025', 'Second', ''),
(248, 'IT8', 'Fundamentals of Database Systems', 3, '', 17, '2024-2025', 'Second', ''),
(249, 'ACT2', 'Graphic Design', 3, '', 17, '2024-2025', 'Second', ''),
(250, 'ACT3', 'Website Design', 3, '', 17, '2024-2025', 'Second', ''),
(251, 'NSTP2', 'Civil Welfare Training Service (CWTS) 2', 3, '', 17, '2024-2025', 'Second', ''),
(252, 'PE2', 'Physical Activities Towards Health and Fitness 1', 2, '', 17, '2024-2025', 'Second', ''),
(253, 'OJT1', 'Internship (160 hours minimum)', 3, '', 17, '2024-2025', 'Summer', ''),
(254, 'GenEd4', 'Pag unawa sa Sarili	', 3, '', 18, '2024-2025', 'First', ''),
(255, 'IT9', 'Data Structure and Algorithms', 3, '', 18, '2024-2025', 'First', ''),
(256, 'IT10', 'Information Management 1', 3, '', 18, '2024-2025', 'First', ''),
(257, 'IT11', 'Application Development and Emerging Technologies', 3, '', 18, '2024-2025', 'First', ''),
(258, 'IT12', 'Information, Assurance and Security 1', 3, '', 18, '2024-2025', 'First', ''),
(259, 'ACT5', 'Script Writing & Story Board Design', 3, '', 18, '2024-2025', 'First', ''),
(260, 'ACT6', 'Principles of 2D Design', 3, '', 18, '2024-2025', 'First', ''),
(261, 'PATHFIT3', 'Physical Activities Towards Health and Fitness 3', 2, '', 18, '2024-2025', 'First', ''),
(262, 'GenED5', 'Art Appreciation', 3, '', 18, '2024-2025', 'Second', ''),
(263, 'IT13', 'Object Oriented Programming', 3, '', 18, '2024-2025', 'Second', ''),
(264, 'IT14', 'Web System and Technologies', 3, '', 18, '2024-2025', 'Second', ''),
(265, 'ACT9', 'GUI-Based Application Development (with project)', 3, '', 18, '2024-2025', 'Second', ''),
(266, 'PATHFIT4', 'Physical Activities Towards Health and Fitness 3', 2, '', 18, '2024-2025', 'Second', ''),
(267, 'OJT2', 'Internship (160 hours minimum)', 3, '', 18, '2024-2025', 'Second', '');

-- --------------------------------------------------------

--
-- Table structure for table `sy`
--

CREATE TABLE IF NOT EXISTS `sy` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SY` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sy`
--

INSERT INTO `sy` (`ID`, `SY`) VALUES
(1, '2024-2025'),
(2, '2025-2026'),
(3, '2026-2027'),
(4, '2026-2028'),
(5, '2028-2029'),
(6, '2029-2030'),
(7, '2030-2031');

-- --------------------------------------------------------

--
-- Table structure for table `tblrequirements`
--

CREATE TABLE IF NOT EXISTS `tblrequirements` (
  `REQ_ID` int(30) NOT NULL AUTO_INCREMENT,
  `NSO` varchar(5) NOT NULL DEFAULT 'no',
  `BAPTISMAL` varchar(5) NOT NULL DEFAULT 'no',
  `ENTRANCE_TEST_RESULT` varchar(5) NOT NULL DEFAULT 'no',
  `MARRIAGE_CONTRACT` varchar(5) NOT NULL DEFAULT 'no',
  `CERTIFICATE_OF_TRANSFER` varchar(5) NOT NULL DEFAULT 'no',
  `IDNO` int(20) NOT NULL,
  PRIMARY KEY (`REQ_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tblrequirements`
--

INSERT INTO `tblrequirements` (`REQ_ID`, `NSO`, `BAPTISMAL`, `ENTRANCE_TEST_RESULT`, `MARRIAGE_CONTRACT`, `CERTIFICATE_OF_TRANSFER`, `IDNO`) VALUES
(1, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 123456),
(2, 'No', 'No', 'No', 'Yes', 'No', 102),
(3, 'No', 'Yes', 'No', 'No', 'No', 2147483647),
(4, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1234567),
(5, 'Yes', 'Yes', 'No', 'No', 'No', 1250),
(6, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 2147483647),
(7, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 2147483647),
(8, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 2147483647),
(9, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `tblstuddetails`
--

CREATE TABLE IF NOT EXISTS `tblstuddetails` (
  `DET_ID` int(11) NOT NULL AUTO_INCREMENT,
  `STU_ID` int(11) NOT NULL,
  `FA_LNAME` varchar(255) NOT NULL,
  `FA_FNAME` varchar(255) NOT NULL,
  `FA_MNAME` varchar(255) NOT NULL,
  `FA_OCCUP` varchar(255) NOT NULL,
  `FA_EMPLOYM` varchar(255) NOT NULL,
  `FA_ADDRESS` varchar(255) NOT NULL,
  `FA_MSALARY` varchar(255) NOT NULL,
  `FA_CONTACT` varchar(255) NOT NULL,
  `FA_OINCOME` varchar(255) NOT NULL,
  `MO_LNAME` varchar(255) NOT NULL,
  `MO_FNAME` varchar(255) NOT NULL,
  `MO_MNAME` varchar(255) NOT NULL,
  `MO_OCCUP` varchar(255) NOT NULL,
  `MO_EMPLOYM` varchar(255) NOT NULL,
  `MO_ADDRESS` varchar(255) NOT NULL,
  `MO_MSALARY` varchar(255) NOT NULL,
  `MO_CONTACT` varchar(255) NOT NULL,
  `MO_OINCOME` varchar(255) NOT NULL,
  `GD_LNAME` varchar(255) NOT NULL,
  `GD_FNAME` varchar(255) NOT NULL,
  `GD_MNAME` varchar(255) NOT NULL,
  `GD_OCCUP` varchar(255) NOT NULL,
  `GD_EMPLOYM` varchar(255) NOT NULL,
  `GD_ADDRESS` varchar(255) NOT NULL,
  `GD_MSALARY` varchar(255) NOT NULL,
  `GD_CONTACT` varchar(255) NOT NULL,
  `GD_RELATED` varchar(255) NOT NULL,
  PRIMARY KEY (`DET_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tblstuddetails`
--

INSERT INTO `tblstuddetails` (`DET_ID`, `STU_ID`, `FA_LNAME`, `FA_FNAME`, `FA_MNAME`, `FA_OCCUP`, `FA_EMPLOYM`, `FA_ADDRESS`, `FA_MSALARY`, `FA_CONTACT`, `FA_OINCOME`, `MO_LNAME`, `MO_FNAME`, `MO_MNAME`, `MO_OCCUP`, `MO_EMPLOYM`, `MO_ADDRESS`, `MO_MSALARY`, `MO_CONTACT`, `MO_OINCOME`, `GD_LNAME`, `GD_FNAME`, `GD_MNAME`, `GD_OCCUP`, `GD_EMPLOYM`, `GD_ADDRESS`, `GD_MSALARY`, `GD_CONTACT`, `GD_RELATED`) VALUES
(1, 1, 'Besos', 'Jeff', 'Castillon', 'Entrepreneur', 'Amazon', 'Pagadian City', '50 Million', '9776848642', 'Crypto Trading', 'Musk', 'Angelina', 'Jolie', 'Content Creator', 'Facebook', 'Pagadian City', '40 Miliones', '9776848642', 'Modeling', 'Musk', 'Elon', 'Castillon', 'Mars Exploration', 'NASA', 'Pagadian City', '100 Million', '9776848642', 'Uncle'),
(2, 2, 'Maata', 'McJim', 'Castillon', 'Entrepreneur', 'Amazon', 'Pagadian City', '50 Million', '9776848642', 'Crypto Trading', 'Castillon', 'Pricilla', 'Sumagabg', 'Content Creator', 'Facebook', 'Pagadian City', '40 Miliones', '9776848642', 'Modeling', 'Sumiog', 'Eleuterio', 'Castillon', 'Mars Exploration', 'NASA', 'Pagadian City', '100 Million', '9776848642', 'Uncle'),
(3, 3, 'Maata', 'McJim', 'Castillon', 'Entrepreneur', 'Amazon', 'Pagadian City', '50 Million', '9776848642', 'Crypto Trading', 'Almida', 'Pricilla', 'Castillon', 'Content Creator', 'Facebook', 'Pagadian City', '40 Milion', '9776848642', 'Modeling', 'Musk', 'Elon', 'Castillon', 'Mars Exploration', 'NASA', 'Pagadian City', '100 Million', '9776848642', 'Uncle'),
(4, 4, 'sf', 'sfd', 'sg', 'sfd', 'dsf', 'sth', 'dsf', '9515772777', 'eahab', 'dfsg', 'dhfd', 'erag', 'sgdf', 'rgdf', 'adsgf', '20000', '9515772777', 'dafgf', 'sfd', 'fds', 'dsf', 'dsf', 'df', 'sdf', 'dfs', 'sadf', 'sfd'),
(5, 5, 'Suson', 'Jhonny', 'Pepito', 'fisherman', 'none', 'pagadian city', '2000', '9515772777', 'none', 'Pepito', 'Neta', 'macalitong', 'Housewife', 'none', 'pagadian city', '3000', '9515772777', 'none', 'billiones', 'jessa`', 'macalitong', 'none', 'none', 'pagadian city', '2000', '9515772777', 'Auntie'),
(6, 6, 'Suco', 'Roberto', 'T', 'fisherman', 'none', 'pagadian city', '3000', '9515772777', 'none', 'billiones', 'jessa`', 'macalitong', 'NONE', 'none', 'pagadian city', '20000', '9515772777', 'none', 'Suson', 'Janeth', 'Pepito', 'none', 'NONE', 'pagadian city', '2000', '9515772777', 'Auntie');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE IF NOT EXISTS `tblstudent` (
  `S_ID` int(11) NOT NULL AUTO_INCREMENT,
  `S_TYPE` varchar(40) NOT NULL,
  `COURSE` varchar(40) NOT NULL,
  `SEMESTER` varchar(40) NOT NULL,
  `YEAR_LEVEL` varchar(40) NOT NULL,
  `SCHOOL_YEAR` varchar(40) NOT NULL,
  `CLASS_BLOCK` varchar(40) NOT NULL,
  `LNAME` varchar(40) NOT NULL,
  `FNAME` varchar(40) NOT NULL,
  `MNAME` varchar(40) NOT NULL,
  `BDAY` date NOT NULL,
  `BPLACE` text NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `STATUS` varchar(30) NOT NULL,
  `HEIGHT` varchar(30) NOT NULL,
  `WEIGHT` varchar(30) NOT NULL,
  `RES_ADDRESS` varchar(40) NOT NULL,
  `PER_ADDRESS` varchar(255) NOT NULL,
  `CONTACT_NO` varchar(40) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `ETHNICITY` varchar(255) NOT NULL,
  `ELS_SCHOOL` varchar(255) NOT NULL,
  `ELS_GRADTD` varchar(255) NOT NULL,
  `ELS_HONORS` varchar(255) NOT NULL,
  `JUN_SCHOOL` varchar(255) NOT NULL,
  `JUN_GRADTD` varchar(255) NOT NULL,
  `JUN_HONORS` varchar(255) NOT NULL,
  `SEN_SCHOOL` varchar(255) NOT NULL,
  `SEN_GRADTD` varchar(255) NOT NULL,
  `SEN_HONORS` varchar(255) NOT NULL,
  PRIMARY KEY (`S_ID`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`S_ID`, `S_TYPE`, `COURSE`, `SEMESTER`, `YEAR_LEVEL`, `SCHOOL_YEAR`, `CLASS_BLOCK`, `LNAME`, `FNAME`, `MNAME`, `BDAY`, `BPLACE`, `GENDER`, `STATUS`, `HEIGHT`, `WEIGHT`, `RES_ADDRESS`, `PER_ADDRESS`, `CONTACT_NO`, `EMAIL`, `ETHNICITY`, `ELS_SCHOOL`, `ELS_GRADTD`, `ELS_HONORS`, `JUN_SCHOOL`, `JUN_GRADTD`, `JUN_HONORS`, `SEN_SCHOOL`, `SEN_GRADTD`, `SEN_HONORS`) VALUES
(1, 'New Student', '2', 'First', 'Second Year', '2024-2025', 'B', 'Maata', 'McJim', 'Castillon', '2001-06-18', 'Palo Alto, California', 'M', 'Single', '1.7 Meters', '75 Kgs', 'Pagadian City', 'Los Angeles, California', '9776848642', '', 'Pagadian City', 'Harvard University', '1990', 'Magna Cumlaude', 'Stanford University', '1998', 'Magna Cumlaude', 'Oxford University', '2000', 'Magna Cumlaude'),
(2, 'Old Student', '9', 'Second', 'Third Year', '2024-2025', 'B', 'Campilan', 'Rolando', 'Dumosmog', '2003-06-20', 'Palo Alto, California', 'M', 'Widower', '1.7 Meters', '75 Kgs', 'Pagadian City', 'Los Angeles, California', '9776848642', 'student@westprime.com', 'Pagadian City', 'Harvard University', '1990', 'Magna Cumlaude', 'Medina College', '1998', 'Magna Cumlaude', 'Misamis University', '2000', 'Magna Cumlaude'),
(3, 'New Student', '16', 'Second', 'Second Year', '2024-2025', 'A', 'Duterte', 'Rodrigo', 'Roa', '2000-06-20', 'Palo Alto, California', 'F', 'Single', '1.7 Meters', '75 Kgs', 'Pagadian City', 'Los Angeles, California', '9776848642', 'mictest@mictest.com', 'Pagadian City', 'San Vida University', '1991', 'Magna Carta', 'San Vida University', '1998', 'Magna Carta', 'San Vida University', '2000', 'Magna Carta'),
(4, 'New Student', '1', 'First', '', '2024-2025', 'A', 'billiones', 'jessa`', 'macalitong', '2003-02-28', 'pagadian city', 'F', 'Single', '5''2', '48', 'pagadian city', 'pagadian city', '9515772777', 'jessa@gmail.com', 'catholic', 'hahs', 'asd', 'aef', 'dsf', 'sdg', 'sgg', 'rt', 'fg', 'dg'),
(5, 'New Student', '1', 'First', '', '2024-2025', '', 'Suson', 'Janeth', 'Pepito', '2003-01-02', 'pagadian city', 'F', 'Single', '5''2', '48', 'pagadian city', 'pagadian city', '9515772777', 'janethsuson@gmail.com', 'catholic', 'West prime', '2007', 'none', 'west prime', '2013', 'With Honor', 'West prime', '2020', 'none'),
(6, 'New Student', '9', 'First', '', '2024-2025', 'A', 'Suco', 'Jv', 'Lumacang', '2001-12-19', 'pagadian city', 'F', 'Single', '5''4', '60', 'pagadian city', 'pagadian city', '9515772777', 'Jv@gmail.com', 'catholic', 'Picanan', '2019', 'none', 'Picanan', '2021', 'none', 'Deplo', '2022', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE IF NOT EXISTS `useraccounts` (
  `ACCOUNT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCOUNT_NAME` varchar(255) NOT NULL,
  `ACCOUNT_USERNAME` varchar(255) NOT NULL,
  `ACCOUNT_PASSWORD` text NOT NULL,
  `ACCOUNT_TYPE` varchar(30) NOT NULL,
  PRIMARY KEY (`ACCOUNT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`ACCOUNT_ID`, `ACCOUNT_NAME`, `ACCOUNT_USERNAME`, `ACCOUNT_PASSWORD`, `ACCOUNT_TYPE`) VALUES
(1, 'Admin Account', 'admin@westprime.com', 'admin', 'Administrator'),
(2, 'Regisrar Account', 'registrar@westprime.com', 'registrar', 'Registrar'),
(3, 'Student Account', 'student@westprime.com', 'student', 'Student'),
(4, 'Encoder Account', 'encoder@westprime.com', 'encoder', 'Encoder'),
(5, 'janeth suson', 'janethsuson@gmail.com', '12345', 'Student'),
(6, 'Ramboy, Mary lyn', 'ramboy@gmail.com', '12345', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `validity`
--

CREATE TABLE IF NOT EXISTS `validity` (
  `validity` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `validity`
--

INSERT INTO `validity` (`validity`) VALUES
('2025-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `year_level`
--

CREATE TABLE IF NOT EXISTS `year_level` (
  `YID` int(11) NOT NULL AUTO_INCREMENT,
  `LEVEL` int(11) NOT NULL,
  `LNAME` varchar(40) NOT NULL,
  PRIMARY KEY (`YID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `year_level`
--

INSERT INTO `year_level` (`YID`, `LEVEL`, `LNAME`) VALUES
(1, 1, 'First Year'),
(2, 2, 'Second Year'),
(3, 3, 'Third Year'),
(4, 4, 'Fourth Year');

