CREATE DATABASE IF NOT EXISTS idsystem_school;
USE idsystem_school;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";

--
-- Database: `idsystem_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_room`
--

DROP TABLE IF EXISTS `chat_room`;
CREATE TABLE IF NOT EXISTS `chat_room` (
  `id` int(10) NOT NULL DEFAULT '0',
  `room` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_room`
--

INSERT INTO `chat_room` (`id`, `room`) VALUES
(1, 'Chat Room 01'),
(2, 'Chat Room 02'),
(3, 'Chat Room 03'),
(4, 'Chat Room 04'),
(5, 'Chat Room 05'),
(6, 'Chat Room 06'),
(7, 'Chat Room 07'),
(8, 'Chat Room 08'),
(9, 'Chat Room 09'),
(10, 'Chat Room 10'),
(11, 'Chat Room 11'),
(12, 'Chat Room 12'),
(13, 'Chat Room 13'),
(14, 'Chat Room 14'),
(15, 'Chat Room 15'),
(16, 'Chat Room 16'),
(17, 'Chat Room 17'),
(18, 'Chat Room 18'),
(19, 'Chat Room 19'),
(20, 'Chat Room 20');

-- --------------------------------------------------------

--
-- Table structure for table `countdown`
--

DROP TABLE IF EXISTS `countdown`;
CREATE TABLE IF NOT EXISTS `countdown` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `year` varchar(22) NOT NULL,
  `month` varchar(22) NOT NULL,
  `day` varchar(22) NOT NULL,
  `hour` varchar(22) NOT NULL,
  `min` varchar(22) NOT NULL,
  `sec` varchar(22) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countdown`
--

INSERT INTO `countdown` (`id`, `name`, `year`, `month`, `day`, `hour`, `min`, `sec`) VALUES
(1, 'Merry Christmas 2018', '2018', '12', '25', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
CREATE TABLE IF NOT EXISTS `districts` (
  `sitio` varchar(50) DEFAULT NULL,
  `bario` varchar(50) DEFAULT NULL,
  `municipal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`sitio`, `bario`, `municipal`) VALUES
('Amor', 'Abong-Abong', 'Tabina'),
('Bagong-Silang', 'Abong-Abong', 'Tabina'),
('Bual', 'Abong-Abong', 'Tabina'),
('Hagimit', 'Abong-Abong', 'Tabina'),
('Madasigon', 'Abong-Abong', 'Tabina'),
('Masanagon', 'Abong-Abong', 'Tabina'),
('Paradise', 'Abong-Abong', 'Tabina'),
('Quarry', 'Abong-Abong', 'Tabina'),
('Tinutongan', 'Abong-Abong', 'Tabina'),
('Balite', 'Baganian', 'Tabina'),
('Bangus', 'Baganian', 'Tabina'),
('Buga', 'Baganian', 'Tabina'),
('Giwanon', 'Baganian', 'Tabina'),
('Kuhol', 'Baganian', 'Tabina'),
('Mantis', 'Baganian', 'Tabina'),
('Overflow', 'Baganian', 'Tabina'),
('San Lorenzo', 'Baganian', 'Tabina'),
('Stardust', 'Baganian', 'Tabina'),
('Tubo-Tubo', 'Baganian', 'Tabina'),
('Tulingan', 'Baganian', 'Tabina'),
('Alagase', 'Baya-Baya', 'Tabina'),
('Badbad', 'Baya-Baya', 'Tabina'),
('Banaba', 'Baya-Baya', 'Tabina'),
('Nato', 'Baya-Baya', 'Tabina'),
('Palmera', 'Baya-Baya', 'Tabina'),
('Tabigue', 'Baya-Baya', 'Tabina'),
('Mercury', 'Capisan', 'Tabina'),
('Saturn', 'Capisan', 'Tabina'),
('Sidlak', 'Capisan', 'Tabina'),
('Acasia', 'Concepcion', 'Tabina'),
('Alto', 'Concepcion', 'Tabina'),
('Bajo', 'Concepcion', 'Tabina'),
('Kahayag', 'Concepcion', 'Tabina'),
('San Juan', 'Concepcion', 'Tabina'),
('Sulip', 'Concepcion', 'Tabina'),
('Tubod', 'Concepcion', 'Tabina'),
('Calubian', 'Culabay', 'Tabina'),
('Dapdap', 'Culabay', 'Tabina'),
('Lumboy', 'Culabay', 'Tabina'),
('Manggostan', 'Culabay', 'Tabina'),
('Maranding', 'Culabay', 'Tabina'),
('Pagoda', 'Culabay', 'Tabina'),
('Tandayan', 'Culabay', 'Tabina'),
('Bagacay', 'Dona Josefina', 'Tabina'),
('Bituon', 'Dona Josefina', 'Tabina'),
('Dalaman', 'Dona Josefina', 'Tabina'),
('Hindang', 'Dona Josefina', 'Tabina'),
('Cabuso', 'Lumbia', 'Tabina'),
('Kanaway', 'Lumbia', 'Tabina'),
('Timog', 'Lumbia', 'Tabina'),
('Bomba', 'Mabuhay', 'Tabina'),
('Corbada', 'Mabuhay', 'Tabina'),
('Hanagdong', 'Mabuhay', 'Tabina'),
('Malimpuno', 'Mabuhay', 'Tabina'),
('Mangga', 'Mabuhay', 'Tabina'),
('Mol-aw', 'Mabuhay', 'Tabina'),
('Sandayong', 'Mabuhay', 'Tabina'),
('Tabok', 'Mabuhay', 'Tabina'),
('Waling-Waling', 'Mabuhay', 'Tabina'),
('Arbor', 'Malim', 'Tabina'),
('Kamansi', 'Malim', 'Tabina'),
('Jakarta', 'Malim', 'Tabina'),
('Pagatpat', 'Malim', 'Tabina'),
('Pangalaran', 'Malim', 'Tabina'),
('Patag', 'Malim', 'Tabina'),
('Sta. Lucia', 'Malim', 'Tabina'),
('Tambulian', 'Malim', 'Tabina'),
('Tambunan', 'Malim', 'Tabina'),
('Tuboran', 'Malim', 'Tabina'),
('Bonbon', 'Manicaan', 'Tabina'),
('Lawis', 'Manicaan', 'Tabina'),
('Nabunturan', 'Manicaan', 'Tabina'),
('San Jose', 'Manicaan', 'Tabina'),
('Sigay', 'Manicaan', 'Tabina'),
('Tagaytay', 'Manicaan', 'Tabina'),
('Bahay', 'New Oroquieta', 'Tabina'),
('Dao', 'New Oroquieta', 'Tabina'),
('Gibo', 'New Oroquieta', 'Tabina'),
('Luyaw', 'New Oroquieta', 'Tabina'),
('Waling-Waling', 'New Oroquieta', 'Tabina'),
('Bayanihan', 'Poblacion', 'Tabina'),
('Budlong', 'Poblacion', 'Tabina'),
('Burawin', 'Poblacion', 'Tabina'),
('Daag', 'Poblacion', 'Tabina'),
('Fishing Village', 'Poblacion', 'Tabina'),
('Hibino', 'Poblacion', 'Tabina'),
('Hilltop', 'Poblacion', 'Tabina'),
('Kawasi', 'Poblacion', 'Tabina'),
('Paran', 'Poblacion', 'Tabina'),
('Saniblangis', 'Poblacion', 'Tabina'),
('Sarilikha', 'Poblacion', 'Tabina'),
('Tanducan', 'Poblacion', 'Tabina'),
('Triangle', 'Poblacion', 'Tabina'),
('Uptown', 'Poblacion', 'Tabina'),
('Mars', 'San Francisco', 'Tabina'),
('Uranus', 'San Francisco', 'Tabina'),
('Venus', 'San Francisco', 'Tabina'),
('Amihan', 'Tultolan', 'Tabina'),
('Anahaw', 'Tultolan', 'Tabina'),
('Bugo', 'Tultolan', 'Tabina'),
('Habagat', 'Tultolan', 'Tabina'),
('Lawis', 'Tultolan', 'Tabina'),
('Habagat', 'Tultolan', 'Tabina'),
('Purok-1', 'Limbayan', 'Pitogo'),
('Purok-2', 'Limbayan', 'Pitogo'),
('Purok-3', 'Limbayan', 'Pitogo'),
('Purok-4', 'Limbayan', 'Pitogo'),
('Purok-5', 'Limbayan', 'Pitogo'),
('Purok-1', 'Matin-ao', 'Pitogo'),
('Purok-2', 'Matin-ao', 'Pitogo'),
('Purok-3', 'Matin-ao', 'Pitogo'),
('Purok-4', 'Matin-ao', 'Pitogo'),
('Purok-5', 'Matin-ao', 'Pitogo'),
('Purok-1', 'Panubigan', 'Pitogo'),
('Purok-2', 'Panubigan', 'Pitogo'),
('Purok-3', 'Panubigan', 'Pitogo'),
('Purok-4', 'Panubigan', 'Pitogo'),
('Purok-5', 'Panubigan', 'Pitogo'),
('Purok-1', 'Punta Fletcha', 'Pitogo'),
('Purok-2', 'Punta Fletcha', 'Pitogo'),
('Purok-3', 'Punta Fletcha', 'Pitogo'),
('Purok-4', 'Punta Fletcha', 'Pitogo'),
('Purok-5', 'Punta Fletcha', 'Pitogo'),
('Purok-1', 'Sumpot', 'Dimataling'),
('Purok-2', 'Sumpot', 'Dimataling'),
('Purok-3', 'Sumpot', 'Dimataling'),
('Purok-4', 'Sumpot', 'Dimataling'),
('Purok-5', 'Sumpot', 'Dimataling'),
('Purok-1', 'Tingabulong', 'Dimataling'),
('Purok-2', 'Tingabulong', 'Dimataling'),
('Purok-3', 'Tingabulong', 'Dimataling'),
('Purok-4', 'Tingabulong', 'Dimataling'),
('Purok-5', 'Tingabulong', 'Dimataling'),
('Purok-1', 'Upper Campo', 'Pitogo'),
('Purok-2', 'Upper Campo', 'Pitogo'),
('Purok-3', 'Upper Campo', 'Pitogo'),
('Purok-4', 'Upper Campo', 'Pitogo'),
('Purok-5', 'Upper Campo', 'Pitogo');

-- --------------------------------------------------------

--
-- Table structure for table `emoticons`
--

DROP TABLE IF EXISTS `emoticons`;
CREATE TABLE IF NOT EXISTS `emoticons` (
  `code` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(12) NOT NULL DEFAULT '',
  `location` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emoticons`
--

INSERT INTO `emoticons` (`code`, `title`, `location`) VALUES
('Aa@', 'Smile', '<img src=\"emoticons/smile.png\"/>'),
('Bb#', 'Kiss', '<img src=\"emoticons/kissing.png\"/>'),
('Cc$', 'Angry', '<img src=\"emoticons/angry.png\"/>'),
('Dd', 'Blink', '<img src=\"emoticons/blink.png\"/>'),
('Ee*', 'Blush', '<img src=\"emoticons/blush.png\"/>'),
('Ff(', 'Cheer', '<img src=\"emoticons/cheerful.png\"/>'),
('Gg)', 'Cool', '<img src=\"emoticons/cool.png\"/>'),
('Hh+', 'Dizzy', '<img src=\"emoticons/dizzy.png\"/>'),
('Ii-', 'Ermm', '<img src=\"emoticons/ermm.png\"/>'),
('Jj:', 'Laugh', '<img src=\"emoticons/laughing.png\"/>'),
('Kk;', 'Love', '<img src=\"emoticons/love.png\"/>'),
('Ll?', 'Sad', '<img src=\"emoticons/sad.png\"/>'),
('Mm1', 'Shocked', '<img src=\"emoticons/shocked.png\"/>'),
('Nn2', 'Sick', '<img src=\"emoticons/sick.png\"/>'),
('Oo3', 'Sideways', '<img src=\"emoticons/sideways.png\"/>'),
('Pp4', 'Silly', '<img src=\"emoticons/silly.png\"/>'),
('Qq5', 'Tongue', '<img src=\"emoticons/tongue.png\"/>'),
('Rr6', 'Thumbs', '<img src=\"emoticons/thumbs.gif\"/>'),
('Ss7', 'Unsure', '<img src=\"emoticons/unsure.png\"/>'),
('Tt8', 'Woohoo', '<img src=\"emoticons/w00t.png\"/>'),
('Uu9', 'Huh', '<img src=\"emoticons/wassat.png\"/>'),
('Vv0', 'Whistle', '<img src=\"emoticons/whistling.png\"/>'),
('Ww=', 'Wink', '<img src=\"emoticons/wink.png\"/>'),
('Xx.', 'Pinch', '<img src=\"emoticons/pinch.png\"/>'),
('Yy?', 'Question', '<img src=\"emoticons/question.gif\"/>'),
('Zz!', 'Exclam', '<img src=\"emoticons/exclam.gif\"/>');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
CREATE TABLE IF NOT EXISTS `galleries` (
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `dpath` varchar(100) NOT NULL,
  `imgUrl` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`name`, `link`, `dpath`, `imgUrl`) VALUES
('Music', 'gal_music.php', 'my_music', 'images/music.png'),
('Videos', 'gal_videos.php', 'my_videos', 'images/video.png'),
('Pictures', 'gal_pictures.php', 'my_pictures', 'images/photos.png'),
('Documents', 'gal_documents.php', 'my_docs', 'images/documents.png');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `school` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL,
  `grade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`school`, `level`, `grade`) VALUES
('Abong-Abong Elementary School', 'Elementary', 'Kinder'),
('Abong-Abong Elementary School', 'Elementary', 'Grade-01'),
('Abong-Abong Elementary School', 'Elementary', 'Grade-02'),
('Abong-Abong Elementary School', 'Elementary', 'Grade-03'),
('Abong-Abong Elementary School', 'Elementary', 'Grade-04'),
('Abong-Abong Elementary School', 'Elementary', 'Grade-05'),
('Abong-Abong Elementary School', 'Elementary', 'Grade-06'),
('Baganian Elementary School', 'Elementary', 'Kinder'),
('Baganian Elementary School', 'Elementary', 'Grade-01'),
('Baganian Elementary School', 'Elementary', 'Grade-02'),
('Baganian Elementary School', 'Elementary', 'Grade-03'),
('Baganian Elementary School', 'Elementary', 'Grade-04'),
('Baganian Elementary School', 'Elementary', 'Grade-05'),
('Baganian Elementary School', 'Elementary', 'Grade-06'),
('Baganian National High School', 'Secondary', 'Grade-07'),
('Baganian National High School', 'Secondary', 'Grade-08'),
('Baganian National High School', 'Secondary', 'Grade-09'),
('Baganian National High School', 'Secondary', 'Grade-10'),
('Baganian National High School', 'Secondary', 'Grade-11'),
('Baganian National High School', 'Secondary', 'Grade-12'),
('Baya-Baya Elementary School', 'Elementary', 'Kinder'),
('Baya-Baya Elementary School', 'Elementary', 'Grade-01'),
('Baya-Baya Elementary School', 'Elementary', 'Grade-02'),
('Baya-Baya Elementary School', 'Elementary', 'Grade-03'),
('Baya-Baya Elementary School', 'Elementary', 'Grade-04'),
('Baya-Baya Elementary School', 'Elementary', 'Grade-05'),
('Baya-Baya Elementary School', 'Elementary', 'Grade-06'),
('Capisan Elementary School', 'Elementary', 'Kinder'),
('Capisan Elementary School', 'Elementary', 'Grade-01'),
('Capisan Elementary School', 'Elementary', 'Grade-02'),
('Capisan Elementary School', 'Elementary', 'Grade-03'),
('Capisan Elementary School', 'Elementary', 'Grade-04'),
('Capisan Elementary School', 'Elementary', 'Grade-05'),
('Capisan Elementary School', 'Elementary', 'Grade-06'),
('Concepcion Elementary School', 'Elementary', 'Kinder'),
('Concepcion Elementary School', 'Elementary', 'Grade-01'),
('Concepcion Elementary School', 'Elementary', 'Grade-02'),
('Concepcion Elementary School', 'Elementary', 'Grade-03'),
('Concepcion Elementary School', 'Elementary', 'Grade-04'),
('Concepcion Elementary School', 'Elementary', 'Grade-05'),
('Concepcion Elementary School', 'Elementary', 'Grade-06'),
('Concepcion National High School', 'Secondary', 'Grade-07'),
('Concepcion National High School', 'Secondary', 'Grade-08'),
('Concepcion National High School', 'Secondary', 'Grade-09'),
('Concepcion National High School', 'Secondary', 'Grade-10'),
('Concepcion National High School', 'Secondary', 'Grade-11'),
('Concepcion National High School', 'Secondary', 'Grade-12'),
('Culabay Elementary School', 'Elementary', 'Kinder'),
('Culabay Elementary School', 'Elementary', 'Grade-01'),
('Culabay Elementary School', 'Elementary', 'Grade-02'),
('Culabay Elementary School', 'Elementary', 'Grade-03'),
('Culabay Elementary School', 'Elementary', 'Grade-04'),
('Culabay Elementary School', 'Elementary', 'Grade-05'),
('Culabay Elementary School', 'Elementary', 'Grade-06'),
('Culabay National High School', 'Secondary', 'Grade-07'),
('Culabay National High School', 'Secondary', 'Grade-08'),
('Culabay National High School', 'Secondary', 'Grade-09'),
('Culabay National High School', 'Secondary', 'Grade-10'),
('Culabay National High School', 'Secondary', 'Grade-11'),
('Culabay National High School', 'Secondary', 'Grade-12'),
('Dona Josefina Elementary School', 'Elementary', 'Kinder'),
('Dona Josefina Elementary School', 'Elementary', 'Grade-01'),
('Dona Josefina Elementary School', 'Elementary', 'Grade-02'),
('Dona Josefina Elementary School', 'Elementary', 'Grade-03'),
('Dona Josefina Elementary School', 'Elementary', 'Grade-04'),
('Dona Josefina Elementary School', 'Elementary', 'Grade-05'),
('Dona Josefina Elementary School', 'Elementary', 'Grade-06'),
('Lumbia Elementary School', 'Elementary', 'Kinder'),
('Lumbia Elementary School', 'Elementary', 'Grade-01'),
('Lumbia Elementary School', 'Elementary', 'Grade-02'),
('Lumbia Elementary School', 'Elementary', 'Grade-03'),
('Lumbia Elementary School', 'Elementary', 'Grade-04'),
('Lumbia Elementary School', 'Elementary', 'Grade-05'),
('Lumbia Elementary School', 'Elementary', 'Grade-06'),
('Mabuhay Elementary School', 'Elementary', 'Kinder'),
('Mabuhay Elementary School', 'Elementary', 'Grade-01'),
('Mabuhay Elementary School', 'Elementary', 'Grade-02'),
('Mabuhay Elementary School', 'Elementary', 'Grade-03'),
('Mabuhay Elementary School', 'Elementary', 'Grade-04'),
('Mabuhay Elementary School', 'Elementary', 'Grade-05'),
('Mabuhay Elementary School', 'Elementary', 'Grade-06'),
('Malim Elementary School', 'Elementary', 'Kinder'),
('Malim Elementary School', 'Elementary', 'Grade-01'),
('Malim Elementary School', 'Elementary', 'Grade-02'),
('Malim Elementary School', 'Elementary', 'Grade-03'),
('Malim Elementary School', 'Elementary', 'Grade-04'),
('Malim Elementary School', 'Elementary', 'Grade-05'),
('Malim Elementary School', 'Elementary', 'Grade-06'),
('Malim National High School', 'Secondary', 'Grade-07'),
('Malim National High School', 'Secondary', 'Grade-08'),
('Malim National High School', 'Secondary', 'Grade-09'),
('Malim National High School', 'Secondary', 'Grade-10'),
('Malim National High School', 'Secondary', 'Grade-11'),
('Malim National High School', 'Secondary', 'Grade-12'),
('Manicaan Elementary School', 'Elementary', 'Kinder'),
('Manicaan Elementary School', 'Elementary', 'Grade-01'),
('Manicaan Elementary School', 'Elementary', 'Grade-02'),
('Manicaan Elementary School', 'Elementary', 'Grade-03'),
('Manicaan Elementary School', 'Elementary', 'Grade-04'),
('Manicaan Elementary School', 'Elementary', 'Grade-05'),
('Manicaan Elementary School', 'Elementary', 'Grade-06'),
('New Oroquieta Elementary School', 'Elementary', 'Kinder'),
('New Oroquieta Elementary School', 'Elementary', 'Grade-01'),
('New Oroquieta Elementary School', 'Elementary', 'Grade-02'),
('New Oroquieta Elementary School', 'Elementary', 'Grade-03'),
('New Oroquieta Elementary School', 'Elementary', 'Grade-04'),
('New Oroquieta Elementary School', 'Elementary', 'Grade-05'),
('New Oroquieta Elementary School', 'Elementary', 'Grade-06'),
('San Agustin Elementary School', 'Elementary', 'Kinder'),
('San Agustin Elementary School', 'Elementary', 'Grade-01'),
('San Agustin Elementary School', 'Elementary', 'Grade-02'),
('San Agustin Elementary School', 'Elementary', 'Grade-03'),
('San Agustin Elementary School', 'Elementary', 'Grade-04'),
('San Agustin Elementary School', 'Elementary', 'Grade-05'),
('San Agustin Elementary School', 'Elementary', 'Grade-06'),
('San Andres Elementary School', 'Elementary', 'Kinder'),
('San Andres Elementary School', 'Elementary', 'Grade-01'),
('San Andres Elementary School', 'Elementary', 'Grade-02'),
('San Andres Elementary School', 'Elementary', 'Grade-03'),
('San Andres Elementary School', 'Elementary', 'Grade-04'),
('San Andres Elementary School', 'Elementary', 'Grade-05'),
('San Andres Elementary School', 'Elementary', 'Grade-06'),
('San Francisco Elementary School', 'Elementary', 'Kinder'),
('San Francisco Elementary School', 'Elementary', 'Grade-01'),
('San Francisco Elementary School', 'Elementary', 'Grade-02'),
('San Francisco Elementary School', 'Elementary', 'Grade-03'),
('San Francisco Elementary School', 'Elementary', 'Grade-04'),
('San Francisco Elementary School', 'Elementary', 'Grade-05'),
('San Francisco Elementary School', 'Elementary', 'Grade-06'),
('San Roque Elementary School', 'Elementary', 'Kinder'),
('San Roque Elementary School', 'Elementary', 'Grade-01'),
('San Roque Elementary School', 'Elementary', 'Grade-02'),
('San Roque Elementary School', 'Elementary', 'Grade-03'),
('San Roque Elementary School', 'Elementary', 'Grade-04'),
('San Roque Elementary School', 'Elementary', 'Grade-05'),
('San Roque Elementary School', 'Elementary', 'Grade-06'),
('Tambulian Elementary School', 'Elementary', 'Kinder'),
('Tambulian Elementary School', 'Elementary', 'Grade-01'),
('Tambulian Elementary School', 'Elementary', 'Grade-02'),
('Tambulian Elementary School', 'Elementary', 'Grade-03'),
('Tambulian Elementary School', 'Elementary', 'Grade-04'),
('Tambulian Elementary School', 'Elementary', 'Grade-05'),
('Tambulian Elementary School', 'Elementary', 'Grade-06'),
('Tabina Central Elementary School', 'Elementary', 'Kinder'),
('Tabina Central Elementary School', 'Elementary', 'Grade-01'),
('Tabina Central Elementary School', 'Elementary', 'Grade-02'),
('Tabina Central Elementary School', 'Elementary', 'Grade-03'),
('Tabina Central Elementary School', 'Elementary', 'Grade-04'),
('Tabina Central Elementary School', 'Elementary', 'Grade-05'),
('Tabina Central Elementary School', 'Elementary', 'Grade-06'),
('Tabina National High School', 'Secondary', 'Grade-07'),
('Tabina National High School', 'Secondary', 'Grade-08'),
('Tabina National High School', 'Secondary', 'Grade-09'),
('Tabina National High School', 'Secondary', 'Grade-10'),
('Tabina National High School', 'Secondary', 'Grade-11'),
('Tabina National High School', 'Secondary', 'Grade-12'),
('Tultolan Elementary School', 'Elementary', 'Kinder'),
('Tultolan Elementary School', 'Elementary', 'Grade-01'),
('Tultolan Elementary School', 'Elementary', 'Grade-02'),
('Tultolan Elementary School', 'Elementary', 'Grade-03'),
('Tultolan Elementary School', 'Elementary', 'Grade-04'),
('Tultolan Elementary School', 'Elementary', 'Grade-05'),
('Tultolan Elementary School', 'Elementary', 'Grade-06'),
('Tultolan National High School', 'Secondary', 'Grade-07'),
('Tultolan National High School', 'Secondary', 'Grade-08'),
('Tultolan National High School', 'Secondary', 'Grade-09'),
('Tultolan National High School', 'Secondary', 'Grade-10'),
('Tultolan National High School', 'Secondary', 'Grade-11'),
('Tultolan National High School', 'Secondary', 'Grade-12'),
('Matin-ao Daycare Center', 'Daycare', 'Daycare'),
('Matin-ao Elementary School', 'Elementary', 'Kinder'),
('Matin-ao Elementary School', 'Elementary', 'Grade-01'),
('Matin-ao Elementary School', 'Elementary', 'Grade-02'),
('Matin-ao Elementary School', 'Elementary', 'Grade-03'),
('Matin-ao Elementary School', 'Elementary', 'Grade-04'),
('Matin-ao Elementary School', 'Elementary', 'Grade-05'),
('Matin-ao Elementary School', 'Elementary', 'Grade-06');

-- --------------------------------------------------------

--
-- Table structure for table `learners`
--

DROP TABLE IF EXISTS `learners`;
CREATE TABLE IF NOT EXISTS `learners` (
  `lrn` varchar(50) NOT NULL,
  `name_fam` varchar(50) DEFAULT NULL,
  `name_1st` varchar(50) DEFAULT NULL,
  `name_mid` varchar(50) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birth_month` varchar(2) DEFAULT NULL,
  `birth_day` varchar(2) DEFAULT NULL,
  `birth_year` varchar(4) DEFAULT NULL,
  `school` varchar(50) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `parents` varchar(50) DEFAULT NULL,
  `contact` varchar(11) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `city_mun` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `ispicset` int(11) DEFAULT '0',
  PRIMARY KEY (`lrn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `learners`
--

INSERT INTO `learners` (`lrn`, `name_fam`, `name_1st`, `name_mid`, `sex`, `birth_month`, `birth_day`, `birth_year`, `school`, `level`, `grade`, `section`, `parents`, `contact`, `address`, `barangay`, `city_mun`, `province`, `ispicset`) VALUES
('125095120047', 'LARIOSA', 'ERLYN JEAN', 'E', 'Female', '5', '25', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ERWIN LARIOSA', '', 'Banaba', 'Baya-Baya', 'Tabina', 'Zamboanga del Sur', 1),
('125100120152', 'MARMOJADA', 'CHRIST JAY', 'C', 'Female', '11', '19', '2004', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'EDILBERTO MARMOJADA', '', 'Luyaw', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125299120016', 'Abo', 'Remark', 'D', 'Male', '12', '13', '2005', 'Matin-ao Elementary School', 'Elementary', 'Grade-06', 'Santan', 'RICKY S. ABO', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299120017', 'CROG', 'ROGELIO JR', 'S', 'Male', '11', '12', '2006', 'Matin-ao Elementary School', 'Elementary', 'Grade-06', 'Santan', 'ROGELIO D. CROG', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299120019', 'PEPITO', 'RONALD', 'A', 'Male', '6', '28', '2007', 'Matin-ao Elementary School', 'Elementary', 'Grade-06', 'Santan', 'PERCELITO PEPITO', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299120022', 'BONGCALON', 'KIMBERLY', 'M', 'Female', '8', '24', '2007', 'Matin-ao Elementary School', 'Elementary', 'Grade-06', 'Santan', 'ANECITO P. BONGCALON', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299130011', 'SAJULGA', 'JAMES BRYLE', 'D', 'Male', '6', '6', '2008', 'Matin-ao Elementary School', 'Elementary', 'Grade-05', 'Daisy', 'JUNEFER C. SAJULGA', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299130014', 'CABASAG', 'RASHEL FAITH', 'G', 'Female', '8', '5', '2008', 'Matin-ao Elementary School', 'Elementary', 'Grade-05', 'Daisy', 'ROEL O. CABASAG', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299140008', 'GANTALAO', 'JERSON', 'B', 'Male', '9', '9', '2009', 'Matin-ao Elementary School', 'Elementary', 'Grade-04', 'Daisy', 'HOMBERT V. GANTALAO', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299140010', 'OCAMPO', 'REDEN', 'O', 'Male', '6', '28', '2009', 'Matin-ao Elementary School', 'Elementary', 'Grade-04', 'Daisy', 'EDGAR OCAMPO', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299140016', 'REGIDOR', 'JONNA-MIE', 'P', 'Female', '12', '15', '2008', 'Matin-ao Elementary School', 'Elementary', 'Grade-04', 'Daisy', 'ROGELIO POLOSAN', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299150004', 'LIPON', 'DAISY CLAIRE', 'C', 'Female', '5', '14', '2010', 'Matin-ao Elementary School', 'Elementary', 'Grade-03', 'Rose', 'PEDRO LIPON', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299150007', 'OZARAGA', 'ANISYL JHON', 'B', 'Male', '8', '15', '2010', 'Matin-ao Elementary School', 'Elementary', 'Grade-03', 'Rose', 'SYLVIO A. OZARAGA', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299150012', 'CONAG', 'IRICH GRACE', 'C', 'Female', '8', '21', '2010', 'Matin-ao Elementary School', 'Elementary', 'Grade-03', 'Rose', 'EDELITO P. CONAG', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299160004', 'QUIROGA', 'QUIZEL', 'G', 'Female', '12', '30', '2010', 'Matin-ao Elementary School', 'Elementary', 'Grade-02', 'Rose', 'BONIFACIO A. QUIROGA', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299160007', 'OZARAGA', 'GERALDINE', 'D', 'Female', '1', '21', '2011', 'Matin-ao Elementary School', 'Elementary', 'Grade-02', 'Rose', 'REYNALDO OZARAGA', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299160009', 'PEPITO', 'ANGEL MAE', 'A', 'Female', '2', '3', '2011', 'Matin-ao Elementary School', 'Elementary', 'Grade-02', 'Rose', 'PERCELITO P. PEPITO', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299170002', 'CABASAG', 'JERON', 'S', 'Male', '9', '19', '2011', 'Matin-ao Elementary School', 'Elementary', 'Grade-01', 'Lone', 'WELSON R. CABASAG', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299170004', 'DURIAS', 'JEFF IAN', 'C', 'Male', '4', '26', '2012', 'Matin-ao Elementary School', 'Elementary', 'Grade-01', 'Lone', 'JUNARD C. DURIAS', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299170008', 'ABO', 'RICA MAE', 'D', 'Female', '7', '6', '2012', 'Matin-ao Elementary School', 'Elementary', 'Grade-01', 'Lone', 'RICKY S. ABO', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299170009', 'AGNAS', 'JONNAREEN', 'O', 'Female', '3', '16', '2012', 'Matin-ao Elementary School', 'Elementary', 'Grade-01', 'Lone', 'VICTORIO B. AGNAS', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299170012', 'CABASAG', 'GRACE KEA', 'P', 'Female', '2', '22', '2012', 'Matin-ao Elementary School', 'Elementary', 'Grade-01', 'Lone', 'HARVY T. CABASAG', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180001', 'MAGLINAO', 'JAY-EM', 'C', 'Male', '11', '1', '2012', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'JESSIE M. MAGLINAO', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180002', 'OCAMPO', 'CARL JOSHUA', 'S', 'Male', '1', '7', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'RODEL S. OCAMPO', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180003', 'OCAMPO', 'RENIEL', 'O', 'Male', '3', '21', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'EDGAR S. OCAMPO', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180004', 'SUBSUBAN', 'RYAN', 'O', 'Male', '4', '8', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'REYNALDO OZARAGA', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180005', 'MONDIDO', 'RAYMOND CLARK', 'G', 'Male', '12', '3', '2012', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'QUIRINO M. MONDIDO', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180006', 'MONEVA', 'XYRAH JEAN', 'G', 'Female', '8', '29', '2012', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'JUNJIL S. MONEVA', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180007', 'RESTAURO', 'JEAN MAE', 'E', 'Female', '5', '24', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'JEREMIA M. RESTAURO', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180010', 'MAGLINAO', 'ELLIANA JANE', 'A', 'Female', '9', '8', '2012', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'JEFRY S. MAGLINAO', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180011', 'PEPITO', 'JOHN NICKY ', 'A', 'Male', '1', '24', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'NACKY D. PEPITO', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180012', 'CABASAG', 'JONAS', 'M', 'Male', '4', '12', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'JONATHAN T. CABASAG', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180013', 'QUIROGA', 'JOYZEL SHEEN', 'G', 'Female', '8', '30', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'BONIFACIO A. QUIROGA', '', 'Purok-3', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125299180014', 'SAJULGA', 'CHARIS JOY', 'B', 'Female', '8', '5', '2013', 'Matin-ao Elementary School', 'Elementary', 'Kinder', 'Lone', 'ROGER C. SAJULGA', '', 'Purok-1', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('125302100048', 'SECRETARIA', 'ROBERT JAN', 'B', 'Male', '1', '14', '2003', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ROGELIO SECRETARIA', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125302110043', 'SECRETARIA', 'JUNREL VI', 'B', 'Female', '9', '13', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ROGELIO SECRETARIA', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125399100025', 'MAGSAYO', 'LAWRENCE JOSHUA', 'J', 'Male', '9', '8', '2004', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'ELMA J. MAGSAYO', '', 'Badbad', 'Baya-Baya', 'Tabina', 'Zamboanga del Sur', 1),
('125399110008', 'LIMPAHAN', 'JESSA MAE', 'S', 'Female', '1', '6', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'HAZEL LIMPAHAN', '', 'Banaba', 'Baya-Baya', 'Tabina', 'Zamboanga del Sur', 1),
('125405100019', 'ENGALLA', 'MERRY JOY', 'P', 'Female', '4', '4', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ERWIN ENGALLA', '', 'Uranus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125405110007', 'ENGALLA', 'CRISTINE JOY', 'P', 'Female', '8', '14', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ERWIN ENGALLA', '', 'Mars', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125406180001', 'LLUVIDO', 'KRISTINE CLAIRE', 'Q', 'Female', '12', '11', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Saturnino B. Lluvido, Jr.', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180002', 'LLUVIDO', 'KRISTINE CATE', 'U', 'Female', '3', '5', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Elvito Q. Lluvido', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180003', 'DUHAYLUNGSOD', 'MA. SOFIA DEMYAEL', 'C', 'Female', '3', '26', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Rolly Joy F. Duhaylungsod', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180004', 'BULACO', 'ASHLEY JANE', 'H', 'Female', '6', '26', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Apolinario P. Bulaco', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180005', 'PERONG', 'KYLA SHANNEL', 'L', 'Female', '6', '2', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Eddie A. Perong', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180006', 'TUMALA', 'CHRISTINE', 'M', 'Female', '3', '8', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Isidro D. Tumala', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180007', 'GANUHAY', 'ZANNAH KISS', 'B', 'Female', '6', '18', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Roel M. Ganuhay', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180008', 'TABAYAG', 'MIKAELA', 'T', 'Female', '9', '1', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Dione Michael P. Tabayag', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180009', 'VARQUEZ', 'TRIXIA AYIN', 'O', 'Female', '12', '4', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Juvineel T. Varquez', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180010', 'ROYO', 'STEVE', 'V', 'Male', '10', '7', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Sheldon C. Royo', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 0),
('125406180011', 'CAHIGAS', 'JUNBERT', 'D', 'Male', '8', '17', '2011', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Melchor M. Cahigas', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180012', 'JUSAYAN', 'MARK ANTHONY', 'C', 'Male', '3', '4', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Rey H. Jusayan', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180013', 'NANO', 'JERICO', 'D', 'Male', '3', '20', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Romeo M. Nano, Jr.', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180014', 'CELO', 'JAMES RAFAEL', 'B', 'Male', '7', '18', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Michael C. Celo', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180015', 'LARAGA', 'LANCE KAIZHER', 'A', 'Male', '10', '10', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'June Paul A. Laraga', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180016', 'MAHAWAN', 'CARL JOSHUA', 'A', 'Male', '4', '9', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Rowel C. Mahawan', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180017', 'BERGADO', 'RENIEL', 'R', 'Male', '9', '15', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Reniel D. Bergado', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180018', 'ENGLATIERA', 'MARK DENNIS', 'M', 'Male', '4', '12', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Dennis C. Englatiera', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180019', 'BUGHAW', 'JOHN ANDREY', 'V', 'Male', '1', '10', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Ranty M. Bughaw', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 0),
('125406180020', 'BUGHAW', 'RAVEN', 'S', 'Male', '12', '3', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Florante M. Bughaw', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 0),
('125406180021', 'MAANO', 'KIETH DAVIAN', 'Q', 'Male', '4', '28', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Engrid M. Maano', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180022', 'PUGATE', 'FERNAN RAUL', 'C', 'Male', '5', '20', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Raul S. Pugate', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180023', 'MANGINSAY', 'NEIL DYLAN', 'S', 'Male', '1', '22', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Neil B. Manginsay', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 0),
('125406180024', 'ENIOLA', 'RAMGEN', 'B', 'Male', '6', '7', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Eric B. Eniola', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180025', 'DEL ROSARIO', 'JHAIREY', 'M', 'Male', '10', '24', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Rudy C. Del Rosario', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180026', 'BAYLOSIS', 'JOHN DAVE', 'L', 'Male', '10', '11', '2011', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Deny E. Laraga', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180027', 'MELENDRES', 'JETHER', 'D', 'Male', '11', '19', '2011', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Jeremias A. Melendres', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180028', 'PUEBLA', 'SEAN JOEL', 'E', 'Male', '9', '24', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Joel B. Puebla', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180029', 'DAYONDON', 'TRAVIS JAI', 'A', 'Male', '8', '8', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Jaipee A. Dayondon', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 0),
('125406180030', 'PACAÑA', 'JUSTINE DEMZ', 'P', 'Male', '8', '15', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Judel M. Pacaña', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180031', 'CAPALAC', 'VIAN GRACE', 'P', 'Female', '2', '23', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Reynante R. Capalac', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180032', 'UDAL', 'ARKIEN ALDREN', 'N', 'Male', '10', '31', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Albert C. Udal', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180033', 'RICAÑA', 'JANE', 'C', 'Female', '9', '30', '2012', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Joel T. Ricaña', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180034', 'ALICANTE', 'HONEY SHEIL', 'C', 'Female', '8', '6', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Larry M. Alicante', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 0),
('125406180035', 'RENDULA', 'MARIEL', 'A', 'Female', '2', '11', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Alimar C. Rendula', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125406180036', 'MONTOYA', 'RYZA MAE', 'P', 'Female', '4', '30', '2013', 'Malim Elementary School', 'Elementary', 'Kinder', 'Mabini', 'Rudemson J. Montoya', '', '', 'Malim', 'Tabina', 'Zamboanga del Sur', 1),
('125408100004', 'BRIGOLA', 'CHERICK DAVE', 'L', 'Male', '1', '2', '2003', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'RICKY BRIGOLA', '', 'Waling-Waling', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125408100009', 'CRISTOBAS', 'RHEA', 'D', 'Female', '5', '8', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'RONIE CRISTOBAS', '', 'Dao', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125408100028', 'ONGUE', 'MARJOE', 'C', 'Male', '3', '19', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ESTRELLA ONGUE', '', 'Bahay', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125408100032', 'PARAMI', 'ICY', 'C', 'Female', '8', '10', '2005', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'FELICISIMA B. PARAMI', '', 'Bahay', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125408100041', 'YABO', 'DARYL JOHN', 'S', 'Male', '5', '29', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'CECIL YABO', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125408110010', 'LIGUTOM', 'DY JIM', '', 'Male', '12', '27', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MRS. MERLY LIGUTOM', '', 'Waling-Waling', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 0),
('125408110011', 'MAMINTAS', 'MECHELLE', 'M', 'Female', '9', '23', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MANUEL MAMINTAS', '', 'Dao', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125408110012', 'MERA', 'REYLAND', 'M', 'Male', '7', '29', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'RENATO MERA', '', 'Luyaw', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125410130017', 'PASNAN', 'DANICA', 'A', 'Female', '6', '25', '2008', 'Tultolan Elementary School', 'Elementary', 'Grade-05', 'Suntan', 'Josephine A. Pasnan', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 0),
('125412100001', 'ARONG', 'BERNADETH', 'E', 'Female', '8', '13', '2004', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'BERNALDO E. ARONG', '', 'Venus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412100030', 'SORTONES', 'JUMAR JR', 'A', 'Male', '2', '27', '2003', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JUMAR SORTONES SR', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125412100036', 'TECSON', 'JENMAR', 'S', 'Male', '7', '29', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'WELMER TECSON', '', 'Uranus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412110002', 'CARATOR', 'LOUIE JAY', 'T', 'Male', '12', '10', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JUAN CARATOR', '', 'Venus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412110009', 'MONTAÃ‘EZ', 'ALTHEA', 'J', 'Female', '8', '17', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ALEJANDRO MONTAÃ‘EZ', '', 'Venus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412110012', 'PUGOY', 'KYLE', 'P', 'Male', '5', '4', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'WILMAR PUGOY', '', 'Uranus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412120028', 'CABURNAY', 'JHON PAUL', 'A', 'Male', '11', '16', '2004', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JUNIE MONTEROLA', '', 'Venus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412120032', 'TECSON', 'JANREY', 'M', 'Male', '5', '3', '2042', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'BERNALDO TECSON', '', 'Uranus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412120035', 'TUBAL', 'JENO', 'M', 'Male', '3', '16', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MARCELINO TUBAL', '', 'Mars', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125412120039', 'BRIGOLA', 'NORALIE', 'M', 'Female', '2', '7', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ANTONIO BRIGOLA', '', 'Uranus', 'San Francisco', 'Tabina', 'Zamboanga del Sur', 1),
('125415110115', 'PALURAY', 'NOVIELYN', 'C', 'Female', '11', '6', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'EMELIA PALURAY', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417060020', 'SAYSON', 'MARIE JEAN', 'G', 'Female', '6', '29', '1999', 'Tultolan National High School', 'Secondary', 'Grade-10', 'Daisy', 'Jerry Sayson', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417080008', 'CALISO', 'JERMIE', 'M', 'Male', '8', '28', '2003', 'Tultolan National High School', 'Secondary', 'Grade-10', 'Daisy', 'HERMIE O. CALISO', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417080018', 'PARAME', 'AIAN JAY', 'D', 'Male', '2', '15', '2003', 'Tultolan National High School', 'Secondary', 'Grade-10', 'Daisy', 'AMADOR R. PARAME', '', 'Bahay', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('125417080022', 'SAYSON', 'MARRY ANN', 'G', 'Female', '10', '30', '2002', 'Tultolan National High School', 'Secondary', 'Grade-10', 'Daisy', 'Jerry Sayson', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100006', 'BONGCALON', 'ENRIQUITO JR', 'C', 'Male', '9', '18', '2004', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ENRIQUITO BONGCALON SR', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100011', 'CABURNAY', 'CRISTY', 'S', 'Female', '4', '4', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ARTHURO CABURNAY', '', 'Habagat', 'Punta Fletcha', 'Pitogo', 'Zamboanga del Sur', 1),
('125417100015', 'GAPOR', 'SHANRALYN', 'J', 'Female', '9', '22', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'NOEL GAPOR', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100024', 'OLITRES', 'EDMON', 'P', 'Male', '8', '7', '2003', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ELIZER OLITRES', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100025', 'OLITRES', 'EDWARD', 'P', 'Male', '11', '6', '2004', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ELIZER OLITRES', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100026', 'OLITRES', 'MELANIE', 'F', 'Female', '2', '8', '2003', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'EDWARDO OLITRES', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100029', 'PACTOR', 'RICO', 'M', 'Male', '7', '20', '2003', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'RUTH M. PACTOR', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100030', 'Paulino', 'Myshell', 'B', 'Female', '12', '29', '2004', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'JUNITO C. PAULINO', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417100035', 'SERAFIN', 'RENIEL', 'B', 'Male', '4', '13', '2004', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ALAN SERAFIN', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110001', 'ANGHAG', 'JONADEL', 'V', 'Female', '1', '8', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MAGDALINO ANGHAG', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110002', 'ANTECRISTO', 'LORIEMAE', 'B', 'Female', '5', '11', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ALDY ANTECRISTO', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 0),
('125417110003', 'ARDENIO', 'JENUS', 'B', 'Male', '3', '10', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JULIETO ARDENIO', '', 'Habagat', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110009', 'BELLENO', 'WELMER', 'T', 'Male', '10', '4', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JOEL BELLENO', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110010', 'BITANGCOR', 'MARK KEVIN', 'D', 'Male', '2', '27', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MARVIN P. BITANGCOR', '', 'Habagat', 'Baya-Baya', 'Tabina', 'Zamboanga del Sur', 1),
('125417110012', 'CABURNAY', 'ALDE MAE', 'J', 'Female', '8', '24', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ALBERT CABURNAY', '', 'Habagat', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110019', 'MAATA', 'JOVANIE', 'S', 'Male', '10', '14', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MOISES MAATA', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110020', 'OLIVER', 'KING CYDELL', 'R', 'Male', '2', '27', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JULIUS CEASAR S. OLIVER', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110021', 'ORNOPIA', 'JASON', 'S', 'Male', '3', '29', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'DANIBOY ORNOPIA', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110022', 'PACOT', 'SHANLY EV MARIS', 'A', 'Female', '6', '26', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MARISSA ANGHAG', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110025', 'SAYSON', 'JAME WHELL', 'J', 'Male', '9', '5', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'GEORGE SAYSON', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110027', 'SORTONES', 'SHEILA', 'S', 'Female', '9', '18', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JOHNNY SORTONES', '', 'Lawis', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110028', 'VANGUARDIA', 'CHERISH ANN', 'E', 'Female', '9', '22', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'REY VANGUARDIA', '', 'Habagat', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417110029', 'VANGUARDIA', 'NELICA', 'L', 'Female', '9', '11', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'JOEL VANGUARDIA', '', 'Habagat', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417120032', 'OLITRES', 'MARK ANTHONY', 'E', 'Male', '8', '9', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MARCIAL OLITRES', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417120033', 'ANTIGA', 'CHRISTIAN', 'O', 'Male', '4', '4', '2003', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'SERGIO ANTIGA SR', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417120043', 'OLITRES', 'MARK JHON', 'E', 'Male', '1', '3', '2004', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MARCIAL OLITRES', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417120044', 'TUMAGAD', 'MANUEL JR', 'A', 'Male', '5', '17', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'MANUEL TUMAGAD SR', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('125417120046', 'COLANGGO', 'AIRA Rose', 'C', 'Female', '6', '20', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ROLLY COLANGGO SR', '', 'Tabigue', 'Baya-Baya', 'Tabina', 'Zamboanga del Sur', 1),
('126079140054', 'ESMADE', 'GODYFRED AL', 'N', 'Male', '5', '12', '2006', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'PEPITA PAHAYAHAY', '', 'Amihan', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
('126506100039', 'CORTEZ', 'REGEMIE', 'B', 'Female', '3', '15', '2005', 'Tultolan National High School', 'Secondary', 'Grade-07', 'Jasmine', 'ROGER CORTEZ', '', 'Waling-Waling', 'New Oroquieta', 'Tabina', 'Zamboanga del Sur', 1),
('129591170027', 'CABASAG', 'JOAN', 'A', 'Female', '7', '21', '2011', 'Matin-ao Elementary School', 'Elementary', 'Grade-01', 'Rose', 'JONATHAN T. CABASAG', '', 'Purok-2', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur', 0),
('209504100010', 'BUSICO', 'JOHN KEVIN', 'J', 'Male', '2', '4', '2005', 'Tultolan National High School', 'Secondary', 'Grade-08', 'Rose', 'EVELYN P. JOLO', '', 'Anahaw', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
CREATE TABLE IF NOT EXISTS `music` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `artist` varchar(50) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `file` varchar(100) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `music`
--

INSERT INTO `music` (`mid`, `artist`, `title`, `genre`, `file`) VALUES
(1, 'Adele', 'Rolling in the Deep', 'Pop', 'Adele - Rolling In The Deep.mp3'),
(2, 'Adele', 'Rumor Has It', 'Pop', 'Adele - Rumour Has It.mp3'),
(3, 'Adele', 'Set Fire to the Rain', 'Pop', 'Adele - Set Fire to the Rain.mp3'),
(4, 'Adele', 'Someone Like You', 'Pop', 'Adele - Someone Like You.mp3'),
(5, 'Styx', 'Best of Times', 'Mellow Rock', 'Styx - The Best Of Times.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `schheads`
--

DROP TABLE IF EXISTS `schheads`;
CREATE TABLE IF NOT EXISTS `schheads` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `school_id` int(50) DEFAULT NULL,
  `school` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `schhead` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `schbar` varchar(50) DEFAULT NULL,
  `schmun` varchar(50) DEFAULT NULL,
  `schprov` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schheads`
--

INSERT INTO `schheads` (`id`, `school_id`, `school`, `type`, `schhead`, `position`, `schbar`, `schmun`, `schprov`) VALUES
(1, 0, 'Tultolan Elementary School', 'Elementary', 'Lilibeth P. Catugal', 'School Head', 'Tultolan', 'Tabina', 'Zamboanga del Sur'),
(2, 314232, 'Tultolan National High School', 'Secondary', 'Dennis P. Maano', 'School Head', 'Tultolan', 'Tabina', 'Zamboanga del Sur'),
(3, 0, 'Matin-ao Elementary School', 'Elementary', 'Marjorie Ann T. Loquire', 'School Head', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur'),
(4, 0, 'Malim National High School', 'Secondary', 'Felimar B. Pastoriza', 'School Head', 'Malim', 'Tabina', 'Zamboanga del Sur'),
(5, 125406, 'Malim Elementary School', 'Elementary', 'Elueterio I. Sumi-og, Jr.', 'Principal - I', 'Malim', 'Tabina', 'Zamboanga del Sur'),
(6, 0, 'Concepcion Elementary School', 'Elementary', 'Cameron M. Diaz', 'Actress-Director', 'Concepcion', 'Tabina', 'Zamboanga del Sur'),
(7, 0, 'Tabina Central Elementary School', 'Elementary', 'Rosalie Y. Eltagon', 'School Head', 'Poblacion', 'Tabina', 'Zamboanga del Sur'),
(8, 0, 'Matin-ao Daycare Center', 'Daycare', 'Teresa H. Palmer', 'Actress-Director', 'Matin-ao', 'Pitogo', 'Zamboanga del Sur');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `user` varchar(50) DEFAULT '',
  `time` varchar(50) DEFAULT '',
  `date` varchar(50) DEFAULT '',
  `sid` varchar(50) NOT NULL DEFAULT '0',
  `ipc` varchar(50) NOT NULL DEFAULT '0',
  `guest` tinyint(4) DEFAULT '1',
  `gid` tinyint(3) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`gid`),
  UNIQUE KEY `sid` (`sid`),
  KEY `whosonline` (`guest`,`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(50) DEFAULT NULL,
  `tname` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `schbar` varchar(50) DEFAULT NULL,
  `schmun` varchar(50) DEFAULT NULL,
  `schprov` varchar(50) DEFAULT NULL,
  `ispicset` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `school`, `tname`, `position`, `schbar`, `schmun`, `schprov`, `ispicset`) VALUES
(101, 'Tultolan National High School', 'DENNIS P. MAANO, LPT', 'School Head', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(102, 'Culabay Elementary School', 'RONA G. MAANO, LPT', 'Facilitator', 'Culabay', 'Tabina', 'Zamboanga del Sur', 1),
(103, 'Tultolan National High School', 'Rico C. Lucero, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(104, 'Tultolan National High School', 'TIFFANY A. LLOREN, LPT ', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(105, 'Tultolan National High School', 'ROMELYN ISANAN TARAY, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(106, 'Tultolan National High School', 'Josephine A. Pasnan, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(107, 'Tultolan National High School', 'Remelyn B. Ubod, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(108, 'Tultolan National High School', 'MARIE GRACE T. LIMPAG, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(109, 'Tultolan National High School', 'CARMELA T. SORINO, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(110, 'Tultolan National High School', 'LJ MARK BRYAN M. BACUAJA, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(111, 'Tultolan National High School', 'Emelia C. Paluray, LPT', 'Facilitator', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1),
(112, 'Tultolan National High School', 'Johnny Anghag Sortones', 'Watchman', 'Tultolan', 'Tabina', 'Zamboanga del Sur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uno` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `imgUrl` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`uno`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uno`, `email`, `fullname`, `position`, `username`, `password`, `imgUrl`) VALUES
(1, 'mcjim@mcjim-server.com', 'McJim Maata', 'SuperAdmin', 'admin', 'admin', 'McJim.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `validity`
--

DROP TABLE IF EXISTS `validity`;
CREATE TABLE IF NOT EXISTS `validity` (
  `validity` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `validity`
--

INSERT INTO `validity` (`validity`) VALUES
('2030-03-04');
