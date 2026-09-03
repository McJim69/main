DROP DATABASE IF EXISTS jayson_art;
CREATE DATABASE jayson_art;
USE jayson_art;

DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE `portfolio` (
  `portid` int(11) NOT NULL AUTO_INCREMENT,
  `portname` varchar(200) DEFAULT NULL,
  `category` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `videolink` varchar(200) DEFAULT NULL,
  `imagelink` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`portid`)
);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(200) NOT NULL,
  PRIMARY KEY (`cat_id`)
);

INSERT INTO `category` VALUES 
(1,"Graphics"),
(2,"Animation"),
(3,"Videos");

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `usrid` int(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `account` varchar(20) NOT NULL,
  `photo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usrid`),
  UNIQUE KEY `emailadd` (`email`)
);

INSERT INTO `users` VALUES 
(1,"Jayson","Polistico","xxjaypolsxx@gmail.com",09678743564,"Jayson","Derulo","Admin",0);

DROP TABLE IF EXISTS `validity`;

CREATE TABLE `validity` (
  `validity` date DEFAULT NULL
);

INSERT INTO `validity` VALUES ("2030-06-20");

DROP TABLE IF EXISTS intro;
CREATE TABLE `intro` (
  `cont_id` int(11) NOT NULL AUTO_INCREMENT,
  `intro_title` varchar(200) DEFAULT NULL,
  `intro_content` varchar(300) DEFAULT NULL,
  `intro_video` varchar(300) DEFAULT NULL,
  `intro_image` int(4)NOT NULL DEFAULT '0',  
  PRIMARY KEY (`cont_id`)
);

INSERT INTO `intro` VALUES (0,'Hey!, I''m Jayson', 'I do graphic designs, animations and video editing.','',1);

DROP TABLE IF EXISTS services;
CREATE TABLE `services` (
  `serv_id` int(11) NOT NULL AUTO_INCREMENT,
  `serv_title` varchar(100) DEFAULT NULL,
  `serv_subt1` varchar(200) DEFAULT NULL,
  `serv_subt2` varchar(300) DEFAULT NULL, 
  PRIMARY KEY (`serv_id`)
);

INSERT INTO `services` VALUES (0,'Services', 'Services range of designs in branding, thumbnails, and video editing.', 'Our offered services encompass a wide range of designs, including branding, thumbnails and video editing.');

DROP TABLE IF EXISTS branding;
CREATE TABLE `branding` (
  `brand_sids` int(11) NOT NULL AUTO_INCREMENT,
  `brand_tite` varchar(100) DEFAULT NULL,
  `brand_cont` varchar(300) DEFAULT NULL,
  `brand_more` varchar(500) DEFAULT NULL, 
  `brand_imge` int(4) NULL DEFAULT '0',
  PRIMARY KEY (`brand_sids`)
);

INSERT INTO `branding` VALUES (1,'Branding', 'Logo Branding Design and Video Promotions.', 'Our offered services encompass a wide range of designs, including branding, thumbnails and video editing.',1);

DROP TABLE IF EXISTS animation;
CREATE TABLE `animation` (
  `anim_sids` int(11) NOT NULL AUTO_INCREMENT,
  `anim_tite` varchar(100) DEFAULT NULL,
  `anim_cont` varchar(300) DEFAULT NULL,
  `anim_more` varchar(500) DEFAULT NULL, 
  `anim_imge` int(4) NULL DEFAULT '0',
  PRIMARY KEY (`anim_sids`)
);

INSERT INTO `animation` VALUES (1,'Animations', 'Animations for Web Content.', 'Our offered services encompass a wide range of designs, including branding, thumbnails and video editing.',1);

DROP TABLE IF EXISTS videdit;
CREATE TABLE `videdit` (
  `vide_sids` int(11) NOT NULL AUTO_INCREMENT,
  `vide_tite` varchar(100) DEFAULT NULL,
  `vide_cont` varchar(300) DEFAULT NULL,
  `vide_more` varchar(500) DEFAULT NULL, 
  `vide_imge` int(4) NULL DEFAULT '0',
  PRIMARY KEY (`vide_sids`)
);

INSERT INTO `videdit` VALUES (1,'Video Editing', 'Video Enhancement and Editing.', 'Our offered services encompass a wide range of designs, including branding, thumbnails and video editing.',1);
