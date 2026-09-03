CREATE DATABASE IF NOT EXISTS familytree;
USE familytree;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";

--
-- Database: `familytree`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_dashboard`
--

DROP TABLE IF EXISTS `admin_dashboard`;
CREATE TABLE IF NOT EXISTS `admin_dashboard` (
  `adid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imgl` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`adid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_dashboard`
--

INSERT INTO `admin_dashboard` (`adid`, `name`, `imgl`, `link`) VALUES
(1, 'Bakcup', 'backup.png', 'backup.php'),
(2, 'Configuration', 'configuration.png', 'config.php'),
(3, 'Facebook', 'facebook.png', 'facebook.php'),
(4, 'Gallery', 'photogallery.png', 'gallery.php'),
(5, 'Instagram', 'instagram.png', 'instagram.php'),
(6, 'Members', 'members.png', 'members.php'),
(7, 'Polls', 'polls.png', 'polls.php'),
(8, 'Scheduler', 'scheduler.png', 'scheduler.php'),
(9, 'Upgrade', 'upgrade.png', 'upgrade.php'),
(10, 'Youtube', 'youtube.png', 'youtube.php');

-- --------------------------------------------------------

--
-- Table structure for table `fcms_address`
--

DROP TABLE IF EXISTS `fcms_address`;
CREATE TABLE IF NOT EXISTS `fcms_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `country` char(2) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `home` varchar(20) DEFAULT NULL,
  `work` varchar(20) DEFAULT NULL,
  `cell` varchar(20) DEFAULT NULL,
  `created_id` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated_id` int(11) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_ind` (`user`),
  KEY `create_ind` (`created_id`),
  KEY `update_ind` (`updated_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_address`
--

INSERT INTO `fcms_address` (`id`, `user`, `country`, `address`, `city`, `state`, `zip`, `home`, `work`, `cell`, `created_id`, `created`, `updated_id`, `updated`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-09-26 21:47:43', 1, '2025-09-26 13:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `fcms_alerts`
--

DROP TABLE IF EXISTS `fcms_alerts`;
CREATE TABLE IF NOT EXISTS `fcms_alerts` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `alert` varchar(50) NOT NULL DEFAULT '0',
  `user` int(25) NOT NULL DEFAULT '0',
  `hide` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `alert_ind` (`alert`),
  KEY `user_ind` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_board_posts`
--

DROP TABLE IF EXISTS `fcms_board_posts`;
CREATE TABLE IF NOT EXISTS `fcms_board_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `thread` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  `post` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_ind` (`thread`),
  KEY `user_ind` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_board_posts`
--

INSERT INTO `fcms_board_posts` (`id`, `date`, `thread`, `user`, `post`) VALUES
(1, '2025-09-26 13:47:44', 1, 1, 'Welcome to the Family Connections Message Board.');

-- --------------------------------------------------------

--
-- Table structure for table `fcms_board_threads`
--

DROP TABLE IF EXISTS `fcms_board_threads`;
CREATE TABLE IF NOT EXISTS `fcms_board_threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL DEFAULT 'Subject',
  `started_by` int(11) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `views` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `start_ind` (`started_by`),
  KEY `up_ind` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_board_threads`
--

INSERT INTO `fcms_board_threads` (`id`, `subject`, `started_by`, `updated`, `updated_by`, `views`) VALUES
(1, 'Welcome', 1, '2025-09-26 13:47:44', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_calendar`
--

DROP TABLE IF EXISTS `fcms_calendar`;
CREATE TABLE IF NOT EXISTS `fcms_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `title` varchar(50) NOT NULL DEFAULT 'MyDate',
  `desc` text,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0',
  `repeat` varchar(20) DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `invite` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `by_ind` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_calendar`
--

INSERT INTO `fcms_calendar` (`id`, `date`, `time_start`, `time_end`, `date_added`, `title`, `desc`, `created_by`, `category`, `repeat`, `private`, `invite`) VALUES
(1, '2007-12-25', NULL, NULL, '2007-12-25 01:00:00', 'Christmas', NULL, 1, 4, 'yearly', 0, 0),
(2, '2007-02-14', NULL, NULL, '2007-02-14 01:00:00', 'Valentine\'s Day', NULL, 1, 4, 'yearly', 0, 0),
(3, '2007-01-01', NULL, NULL, '2007-01-01 01:00:00', 'New Year\'s Day', NULL, 1, 4, 'yearly', 0, 0),
(4, '2007-07-04', NULL, NULL, '2007-07-04 01:00:00', 'Independence Day', NULL, 1, 4, 'yearly', 0, 0),
(5, '2007-02-02', NULL, NULL, '2007-02-02 01:00:00', 'Groundhog Day', NULL, 1, 4, 'yearly', 0, 0),
(6, '2007-03-17', NULL, NULL, '2007-03-17 01:00:00', 'St. Patrick\'s Day', NULL, 1, 4, 'yearly', 0, 0),
(7, '2007-04-01', NULL, NULL, '2007-04-01 01:00:00', 'April Fools Day', NULL, 1, 4, 'yearly', 0, 0),
(8, '2007-10-31', NULL, NULL, '2007-10-31 01:00:00', 'Halloween', NULL, 1, 4, 'yearly', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_category`
--

DROP TABLE IF EXISTS `fcms_category`;
CREATE TABLE IF NOT EXISTS `fcms_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `user` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `color` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_ind` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_category`
--

INSERT INTO `fcms_category` (`id`, `name`, `type`, `user`, `date`, `color`, `description`) VALUES
(1, '', 'calendar', 1, '2025-09-26 13:47:43', 'none', NULL),
(2, 'Anniversary', 'calendar', 1, '2025-09-26 13:47:43', 'green', NULL),
(3, 'Birthday', 'calendar', 1, '2025-09-26 13:47:43', 'red', NULL),
(4, 'Holiday', 'calendar', 1, '2025-09-26 13:47:43', 'indigo', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_changelog`
--

DROP TABLE IF EXISTS `fcms_changelog`;
CREATE TABLE IF NOT EXISTS `fcms_changelog` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user` int(25) NOT NULL DEFAULT '0',
  `table` varchar(50) NOT NULL,
  `column` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_chat_messages`
--

DROP TABLE IF EXISTS `fcms_chat_messages`;
CREATE TABLE IF NOT EXISTS `fcms_chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `text` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_chat_online`
--

DROP TABLE IF EXISTS `fcms_chat_online`;
CREATE TABLE IF NOT EXISTS `fcms_chat_online` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_config`
--

DROP TABLE IF EXISTS `fcms_config`;
CREATE TABLE IF NOT EXISTS `fcms_config` (
  `name` varchar(50) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_config`
--

INSERT INTO `fcms_config` (`name`, `value`) VALUES
('sitename', 'D\'Maatas Connection'),
('contact', 'admin@mcjim-server.com'),
('current_version', 'Family Connections 3.8.0'),
('auto_activate', '0'),
('registration', '1'),
('full_size_photos', '0'),
('site_off', '0'),
('log_errors', '0'),
('fs_client_id', NULL),
('fs_client_secret', NULL),
('fs_callback_url', NULL),
('external_news_date', NULL),
('fb_app_id', NULL),
('fb_secret', NULL),
('youtube_key', NULL),
('running_job', '0'),
('start_week', '1'),
('debug', '0'),
('country', 'US'),
('instagram_client_id', NULL),
('instagram_client_secret', NULL),
('google_client_id', NULL),
('google_client_secret', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_documents`
--

DROP TABLE IF EXISTS `fcms_documents`;
CREATE TABLE IF NOT EXISTS `fcms_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `mime` varchar(50) NOT NULL DEFAULT 'application/download',
  `user` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fcms_documents_ibfk_1` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_gallery_category_comment`
--

DROP TABLE IF EXISTS `fcms_gallery_category_comment`;
CREATE TABLE IF NOT EXISTS `fcms_gallery_category_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_gallery_external_photo`
--

DROP TABLE IF EXISTS `fcms_gallery_external_photo`;
CREATE TABLE IF NOT EXISTS `fcms_gallery_external_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `medium` varchar(255) NOT NULL,
  `full` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_gallery_photos`
--

DROP TABLE IF EXISTS `fcms_gallery_photos`;
CREATE TABLE IF NOT EXISTS `fcms_gallery_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filename` varchar(25) NOT NULL DEFAULT 'noimage.gif',
  `external_id` int(11) DEFAULT NULL,
  `caption` text,
  `category` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  `views` smallint(6) NOT NULL DEFAULT '0',
  `votes` smallint(6) NOT NULL DEFAULT '0',
  `rating` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cat_ind` (`category`),
  KEY `user_ind` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_gallery_photos_tags`
--

DROP TABLE IF EXISTS `fcms_gallery_photos_tags`;
CREATE TABLE IF NOT EXISTS `fcms_gallery_photos_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `photo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tag_photo_ind` (`photo`),
  KEY `tag_user_ind` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_gallery_photo_comment`
--

DROP TABLE IF EXISTS `fcms_gallery_photo_comment`;
CREATE TABLE IF NOT EXISTS `fcms_gallery_photo_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `photo_ind` (`photo`),
  KEY `user_ind` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_invitation`
--

DROP TABLE IF EXISTS `fcms_invitation`;
CREATE TABLE IF NOT EXISTS `fcms_invitation` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `event_id` int(25) NOT NULL DEFAULT '0',
  `user` int(25) NOT NULL DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `attending` tinyint(1) DEFAULT NULL,
  `code` char(13) DEFAULT NULL,
  `response` text,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_navigation`
--

DROP TABLE IF EXISTS `fcms_navigation`;
CREATE TABLE IF NOT EXISTS `fcms_navigation` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `link` varchar(30) NOT NULL,
  `col` tinyint(1) NOT NULL,
  `order` tinyint(2) NOT NULL,
  `req` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_navigation`
--

INSERT INTO `fcms_navigation` (`id`, `link`, `col`, `order`, `req`) VALUES
(1, 'home', 1, 1, 1),
(2, 'profile', 2, 1, 1),
(3, 'settings', 2, 2, 1),
(4, 'pm', 2, 3, 1),
(5, 'notification', 2, 4, 1),
(6, 'messageboard', 3, 1, 1),
(7, 'photogallery', 4, 1, 1),
(8, 'videogallery', 4, 2, 1),
(9, 'addressbook', 4, 3, 1),
(10, 'calendar', 4, 4, 1),
(11, 'members', 5, 1, 1),
(12, 'contact', 5, 2, 1),
(13, 'help', 5, 3, 1),
(14, 'admin_upgrade', 6, 1, 1),
(15, 'admin_configuration', 6, 2, 1),
(16, 'admin_members', 6, 3, 1),
(17, 'admin_photogallery', 6, 4, 1),
(18, 'admin_polls', 6, 5, 1),
(19, 'admin_scheduler', 6, 6, 1),
(20, 'admin_debug', 6, 7, 1),
(21, 'admin_facebook', 6, 8, 1),
(22, 'admin_google', 6, 9, 1),
(23, 'admin_foursquare', 6, 10, 1),
(24, 'admin_instagram', 6, 11, 1),
(25, 'familynews', 3, 2, 0),
(26, 'prayers', 3, 3, 0),
(27, 'recipes', 4, 5, 0),
(28, 'tree', 4, 6, 0),
(29, 'documents', 4, 7, 0),
(30, 'whereiseveryone', 4, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_news`
--

DROP TABLE IF EXISTS `fcms_news`;
CREATE TABLE IF NOT EXISTS `fcms_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `news` text NOT NULL,
  `user` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `external_type` varchar(20) DEFAULT NULL,
  `external_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userindx` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_news_comments`
--

DROP TABLE IF EXISTS `fcms_news_comments`;
CREATE TABLE IF NOT EXISTS `fcms_news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `photo_ind` (`news`),
  KEY `user_ind` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_notification`
--

DROP TABLE IF EXISTS `fcms_notification`;
CREATE TABLE IF NOT EXISTS `fcms_notification` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user` int(25) NOT NULL DEFAULT '0',
  `created_id` int(25) NOT NULL DEFAULT '0',
  `notification` varchar(50) DEFAULT NULL,
  `data` varchar(50) NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_polls`
--

DROP TABLE IF EXISTS `fcms_polls`;
CREATE TABLE IF NOT EXISTS `fcms_polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `started` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_poll_comment`
--

DROP TABLE IF EXISTS `fcms_poll_comment`;
CREATE TABLE IF NOT EXISTS `fcms_poll_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_poll_options`
--

DROP TABLE IF EXISTS `fcms_poll_options`;
CREATE TABLE IF NOT EXISTS `fcms_poll_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL DEFAULT '0',
  `option` text NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid_ind` (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_poll_votes`
--

DROP TABLE IF EXISTS `fcms_poll_votes`;
CREATE TABLE IF NOT EXISTS `fcms_poll_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `option` int(11) NOT NULL DEFAULT '0',
  `poll_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_ind` (`user`),
  KEY `option_ind` (`option`),
  KEY `poll_id_ind` (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_prayers`
--

DROP TABLE IF EXISTS `fcms_prayers`;
CREATE TABLE IF NOT EXISTS `fcms_prayers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `for` varchar(50) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `user` int(11) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userindx` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_privatemsg`
--

DROP TABLE IF EXISTS `fcms_privatemsg`;
CREATE TABLE IF NOT EXISTS `fcms_privatemsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `title` varchar(50) NOT NULL DEFAULT 'PM Title',
  `msg` text,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to_ind` (`to`),
  KEY `from_ind` (`from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_recipes`
--

DROP TABLE IF EXISTS `fcms_recipes`;
CREATE TABLE IF NOT EXISTS `fcms_recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'My Recipe',
  `thumbnail` varchar(255) NOT NULL DEFAULT 'no_recipe.jpg',
  `category` int(11) NOT NULL,
  `ingredients` text NOT NULL,
  `directions` text NOT NULL,
  `user` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fcms_recipes_ibfk_1` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_recipe_comment`
--

DROP TABLE IF EXISTS `fcms_recipe_comment`;
CREATE TABLE IF NOT EXISTS `fcms_recipe_comment` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `recipe` int(25) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe` (`recipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_relationship`
--

DROP TABLE IF EXISTS `fcms_relationship`;
CREATE TABLE IF NOT EXISTS `fcms_relationship` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user` int(25) NOT NULL,
  `relationship` varchar(4) NOT NULL,
  `rel_user` int(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_ind` (`user`),
  KEY `rel_user` (`rel_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_schedule`
--

DROP TABLE IF EXISTS `fcms_schedule`;
CREATE TABLE IF NOT EXISTS `fcms_schedule` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL DEFAULT 'familynews',
  `repeat` varchar(50) NOT NULL DEFAULT 'hourly',
  `lastrun` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_schedule`
--

INSERT INTO `fcms_schedule` (`id`, `type`, `repeat`, `lastrun`, `status`) VALUES
(1, 'awards', 'daily', NULL, 0),
(2, 'familynews', 'hourly', NULL, 0),
(3, 'youtube', 'hourly', NULL, 0),
(4, 'instagram', 'hourly', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_status`
--

DROP TABLE IF EXISTS `fcms_status`;
CREATE TABLE IF NOT EXISTS `fcms_status` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user` int(25) NOT NULL DEFAULT '0',
  `status` text,
  `parent` int(25) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_users`
--

DROP TABLE IF EXISTS `fcms_users`;
CREATE TABLE IF NOT EXISTS `fcms_users` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `access` tinyint(1) NOT NULL DEFAULT '3',
  `activity` datetime DEFAULT NULL,
  `joindate` datetime DEFAULT NULL,
  `fname` varchar(25) NOT NULL DEFAULT 'fname',
  `mname` varchar(25) DEFAULT NULL,
  `lname` varchar(25) NOT NULL DEFAULT 'lname',
  `maiden` varchar(25) DEFAULT NULL,
  `sex` char(1) NOT NULL DEFAULT 'M',
  `email` varchar(50) NOT NULL DEFAULT 'me@mail.com',
  `dob_year` char(4) DEFAULT NULL,
  `dob_month` char(2) DEFAULT NULL,
  `dob_day` char(2) DEFAULT NULL,
  `dod_year` char(4) DEFAULT NULL,
  `dod_month` char(2) DEFAULT NULL,
  `dod_day` char(2) DEFAULT NULL,
  `username` varchar(25) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `phpass` varchar(255) NOT NULL DEFAULT '0',
  `token` varchar(255) DEFAULT NULL,
  `avatar` varchar(25) NOT NULL DEFAULT 'no_avatar.jpg',
  `gravatar` varchar(255) DEFAULT NULL,
  `bio` varchar(200) DEFAULT NULL,
  `activate_code` char(13) DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `login_attempts` tinyint(1) NOT NULL DEFAULT '0',
  `locked` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_users`
--

INSERT INTO `fcms_users` (`id`, `access`, `activity`, `joindate`, `fname`, `mname`, `lname`, `maiden`, `sex`, `email`, `dob_year`, `dob_month`, `dob_day`, `dod_year`, `dod_month`, `dod_day`, `username`, `password`, `phpass`, `token`, `avatar`, `gravatar`, `bio`, `activate_code`, `activated`, `login_attempts`, `locked`) VALUES
(1, 1, '2025-10-04 23:59:53', '2025-09-26 21:47:43', 'McJim', NULL, 'Maata', NULL, 'M', 'admin@mcjim-server.com', '1969', '06', '20', NULL, NULL, NULL, 'admin', '0', '$2a$08$BVqrwmlOCRRXranOIIEJS.s1Pd78HdFx456GiWxv5WU.Ef.MxcHSa', '68e13e2d22b9f', 'no_avatar.jpg', NULL, NULL, NULL, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_user_awards`
--

DROP TABLE IF EXISTS `fcms_user_awards`;
CREATE TABLE IF NOT EXISTS `fcms_user_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `award` varchar(100) NOT NULL,
  `month` int(6) NOT NULL,
  `date` datetime DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `count` smallint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_user_settings`
--

DROP TABLE IF EXISTS `fcms_user_settings`;
CREATE TABLE IF NOT EXISTS `fcms_user_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `theme` varchar(25) NOT NULL DEFAULT 'blue-chrome',
  `boardsort` set('ASC','DESC') NOT NULL DEFAULT 'ASC',
  `displayname` set('1','2','3') NOT NULL DEFAULT '1',
  `frontpage` set('1','2') NOT NULL DEFAULT '1',
  `timezone` set('-12 hours','-11 hours','-10 hours','-9 hours','-8 hours','-7 hours','-6 hours','-5 hours','-4 hours','-3 hours -30 minutes','-3 hours','-2 hours','-1 hours','-0 hours','+1 hours','+2 hours','+3 hours','+3 hours +30 minutes','+4 hours','+4 hours +30 minutes','+5 hours','+5 hours +30 minutes','+6 hours','+7 hours','+8 hours','+9 hours','+9 hours +30 minutes','+10 hours','+11 hours','+12 hours') NOT NULL DEFAULT '-5 hours',
  `dst` tinyint(1) NOT NULL DEFAULT '0',
  `email_updates` tinyint(1) NOT NULL DEFAULT '0',
  `uploader` set('plupload','java','basic') NOT NULL DEFAULT 'plupload',
  `advanced_tagging` tinyint(1) NOT NULL DEFAULT '1',
  `language` varchar(6) NOT NULL DEFAULT 'en_US',
  `fs_user_id` int(11) DEFAULT NULL,
  `fs_access_token` char(50) DEFAULT NULL,
  `blogger` varchar(255) DEFAULT NULL,
  `tumblr` varchar(255) DEFAULT NULL,
  `wordpress` varchar(255) DEFAULT NULL,
  `posterous` varchar(255) DEFAULT NULL,
  `fb_access_token` varchar(255) DEFAULT NULL,
  `google_session_token` varchar(255) DEFAULT NULL,
  `instagram_access_token` varchar(255) DEFAULT NULL,
  `instagram_auto_upload` tinyint(1) DEFAULT '0',
  `picasa_session_token` varchar(255) DEFAULT NULL,
  `fb_user_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_ind` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fcms_user_settings`
--

INSERT INTO `fcms_user_settings` (`id`, `user`, `theme`, `boardsort`, `displayname`, `frontpage`, `timezone`, `dst`, `email_updates`, `uploader`, `advanced_tagging`, `language`, `fs_user_id`, `fs_access_token`, `blogger`, `tumblr`, `wordpress`, `posterous`, `fb_access_token`, `google_session_token`, `instagram_access_token`, `instagram_auto_upload`, `picasa_session_token`, `fb_user_id`) VALUES
(1, 1, 'default', 'ASC', '1', '1', '-5 hours', 0, 0, 'plupload', 1, 'en_US', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fcms_video`
--

DROP TABLE IF EXISTS `fcms_video`;
CREATE TABLE IF NOT EXISTS `fcms_video` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `source_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'untitled',
  `description` varchar(255) DEFAULT NULL,
  `duration` int(25) DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `height` int(4) NOT NULL DEFAULT '420',
  `width` int(4) NOT NULL DEFAULT '780',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `created_id` int(25) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_id` int(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcms_video_comment`
--

DROP TABLE IF EXISTS `fcms_video_comment`;
CREATE TABLE IF NOT EXISTS `fcms_video_comment` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `video_id` int(25) NOT NULL,
  `comment` text NOT NULL,
  `created` datetime NOT NULL,
  `created_id` int(25) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_id` int(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `video_id` (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fcms_address`
--
ALTER TABLE `fcms_address`
  ADD CONSTRAINT `fcms_address_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_board_posts`
--
ALTER TABLE `fcms_board_posts`
  ADD CONSTRAINT `fcms_posts_ibfk_1` FOREIGN KEY (`thread`) REFERENCES `fcms_board_threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_posts_ibfk_2` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_board_threads`
--
ALTER TABLE `fcms_board_threads`
  ADD CONSTRAINT `fcms_threads_ibfk_1` FOREIGN KEY (`started_by`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_threads_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_calendar`
--
ALTER TABLE `fcms_calendar`
  ADD CONSTRAINT `fcms_calendar_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_changelog`
--
ALTER TABLE `fcms_changelog`
  ADD CONSTRAINT `fcms_changelog_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`);

--
-- Constraints for table `fcms_documents`
--
ALTER TABLE `fcms_documents`
  ADD CONSTRAINT `fcms_documents_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_gallery_photos`
--
ALTER TABLE `fcms_gallery_photos`
  ADD CONSTRAINT `fcms_gallery_photos_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_gallery_photos_ibfk_2` FOREIGN KEY (`category`) REFERENCES `fcms_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_gallery_photos_tags`
--
ALTER TABLE `fcms_gallery_photos_tags`
  ADD CONSTRAINT `fcms_gallery_photos_tags_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_gallery_photos_tags_ibfk_2` FOREIGN KEY (`photo`) REFERENCES `fcms_gallery_photos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_gallery_photo_comment`
--
ALTER TABLE `fcms_gallery_photo_comment`
  ADD CONSTRAINT `fcms_gallery_photo_comment_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_gallery_photo_comment_ibfk_2` FOREIGN KEY (`photo`) REFERENCES `fcms_gallery_photos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_news`
--
ALTER TABLE `fcms_news`
  ADD CONSTRAINT `fcms_news_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_news_comments`
--
ALTER TABLE `fcms_news_comments`
  ADD CONSTRAINT `fcms_news_comments_ibfk_1` FOREIGN KEY (`news`) REFERENCES `fcms_news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_news_comments_ibfk_2` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_notification`
--
ALTER TABLE `fcms_notification`
  ADD CONSTRAINT `fcms_notification_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`);

--
-- Constraints for table `fcms_poll_options`
--
ALTER TABLE `fcms_poll_options`
  ADD CONSTRAINT `fcms_poll_options_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `fcms_polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_poll_votes`
--
ALTER TABLE `fcms_poll_votes`
  ADD CONSTRAINT `fcms_poll_votes_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_poll_votes_ibfk_2` FOREIGN KEY (`option`) REFERENCES `fcms_poll_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_poll_votes_ibfk_3` FOREIGN KEY (`poll_id`) REFERENCES `fcms_polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_prayers`
--
ALTER TABLE `fcms_prayers`
  ADD CONSTRAINT `fcms_prayers_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_privatemsg`
--
ALTER TABLE `fcms_privatemsg`
  ADD CONSTRAINT `fcms_privatemsg_ibfk_1` FOREIGN KEY (`to`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fcms_privatemsg_ibfk_2` FOREIGN KEY (`from`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_recipes`
--
ALTER TABLE `fcms_recipes`
  ADD CONSTRAINT `fcms_recipes_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_status`
--
ALTER TABLE `fcms_status`
  ADD CONSTRAINT `fcms_status_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`);

--
-- Constraints for table `fcms_user_awards`
--
ALTER TABLE `fcms_user_awards`
  ADD CONSTRAINT `fcms_user_awards_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_user_settings`
--
ALTER TABLE `fcms_user_settings`
  ADD CONSTRAINT `fcms_user_stgs_ibfk_1` FOREIGN KEY (`user`) REFERENCES `fcms_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fcms_video_comment`
--
ALTER TABLE `fcms_video_comment`
  ADD CONSTRAINT `fcms_video_comment_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `fcms_video` (`id`);
COMMIT;

