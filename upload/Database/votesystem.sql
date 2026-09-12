CREATE DATABASE IF NOT EXISTS votesystem;
USE votesystem;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";

--
-- Database: `votesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `created_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'admin', '$2y$10$ceE7pA/LCHBO4O52gc4.9.9fv3KEXAqKymG3bZQt5qxOAqXVAJBRW', 'McJim', 'Castillon', 'mcjim.jpg', '2018-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `platform` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `firstname`, `lastname`, `photo`, `platform`) VALUES
(18, 8, 'Cong Ress', 'Man', '', 'Project Source of Fund'),
(19, 9, 'Cont', 'Ractor', 'profile.jpg', ''),
(20, 10, 'Kerida', 'Sanchez', 'profile.jpg', 'Fund Raiser, Budget Officer'),
(21, 8, 'Go', 'Bernor', '', 'Budget Manager'),
(22, 9, 'Dep', 'Artment', '', 'Flood Control Budget Slicer'),
(23, 10, 'Kadidang', 'Paldo', '', 'Paldong-Paldo sa Gasto'),
(24, 11, 'Anak', 'Contractor', '', 'Best in many waldas'),
(25, 11, 'Anak', 'Congressman', '', 'Best in Overseas Tour');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `max_vote` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `description`, `max_vote`, `priority`) VALUES
(8, 'Policians', 2000, 1),
(9, 'Contractor', 2000, 2),
(10, 'Kerida', 1000, 3),
(11, 'Baby Girls', 500, 4);

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE IF NOT EXISTS `voters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voters_id` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `photo`) VALUES
(2, 'qDVmTUtxZw8a7RO', '$2y$10$y82jur8k7676STpNUEqMkuIoyHw.LIhhuF9wIaDS9rHqBIuC7sczC', 'Voter', 'Name', 'profile.jpg'),
(3, 'kq1t28xmyWNQlLg', '$2y$10$QfNl33pIXamsHn6aCJL08OvFh7rI3RnzhgGqg/rUKff7F0H6B9jHq', 'Akona', 'Gudni', ''),
(4, 'kqQO7oZEKjSsfuF', '$2y$10$wb9/F4ralQfgoy0mKrWcIuYyKGp7spDujQcdmsoXlLJ66qzQmr0pe', 'Ambot', 'Lang', '');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voters_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `voters_id`, `candidate_id`, `position_id`) VALUES
(81, 2, 18, 8),
(82, 2, 19, 9),
(83, 2, 20, 10),
(84, 3, 21, 8),
(85, 3, 19, 9),
(86, 3, 23, 10),
(87, 3, 25, 11);

