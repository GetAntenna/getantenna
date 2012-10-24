/*
	Antenna default install
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;     

DROP TABLE IF EXISTS `acls`;
CREATE TABLE `acls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `access` enum('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

BEGIN;
INSERT INTO `acls` VALUES ('1', '', '', 'dashboard', '', 'true'), ('2', '1', '', 'editions', '', 'true'), ('3', '1', '', 'events', '', 'true'), ('4', '1', '', 'weekly_events', '', 'true'), ('5', '1', '', 'editorials', '', 'true'), ('6', '', '', 'api', '', 'true'), ('7', '1', '', 'scrapbook_events', '', 'true'), ('8', '1', '', 'submitted_events', '', 'true'), ('9', '', '', 'users', 'logout', 'true'), ('10', '', '', 'users', 'profile', 'true');
COMMIT;

DROP TABLE IF EXISTS `cake_sessions`;
CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `editions`
-- ----------------------------
DROP TABLE IF EXISTS `editions`;
CREATE TABLE `editions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `stamp` int(11) NOT NULL,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `editorials`
-- ----------------------------
DROP TABLE IF EXISTS `editorials`;
CREATE TABLE `editorials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `edition_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `editorials_competitions`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_competitions`;
CREATE TABLE `editorials_competitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `title1` varchar(255) NOT NULL,
  `date1` varchar(255) NOT NULL,
  `location1` varchar(255) NOT NULL,
  `description1` longtext NOT NULL,
  `title2` varchar(255) NOT NULL,
  `date2` varchar(255) NOT NULL,
  `location2` varchar(255) NOT NULL,
  `description2` longtext NOT NULL,
  `title3` varchar(255) NOT NULL,
  `date3` varchar(255) NOT NULL,
  `location3` varchar(255) NOT NULL,
  `description3` longtext NOT NULL,
  `title4` varchar(255) NOT NULL,
  `date4` varchar(255) NOT NULL,
  `location4` varchar(255) NOT NULL,
  `description4` longtext NOT NULL,
  `title5` varchar(255) NOT NULL,
  `date5` varchar(255) NOT NULL,
  `location5` varchar(255) NOT NULL,
  `description5` longtext NOT NULL,
  `title6` varchar(255) NOT NULL,
  `date6` varchar(255) NOT NULL,
  `location6` varchar(255) NOT NULL,
  `description6` longtext NOT NULL,
  `advertisement` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `editorials_cs1s`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_cs1s`;
CREATE TABLE `editorials_cs1s` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `content` longtext,
  `advertisement` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- ----------------------------
--  Table structure for `editorials_cs2s`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_cs2s`;
CREATE TABLE `editorials_cs2s` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `content` longtext,
  `advertisement` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- ----------------------------
--  Table structure for `editorials_ec1s`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_ec1s`;
CREATE TABLE `editorials_ec1s` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `content` longtext,
  `advertisement` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `editorials_events`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_events`;
CREATE TABLE `editorials_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `intro` longtext,
  `title1` varchar(255) NOT NULL,
  `date1` varchar(255) NOT NULL,
  `location1` varchar(255) NOT NULL,
  `description1` longtext NOT NULL,
  `title2` varchar(255) NOT NULL,
  `date2` varchar(255) NOT NULL,
  `location2` varchar(255) NOT NULL,
  `description2` longtext NOT NULL,
  `title3` varchar(255) NOT NULL,
  `date3` varchar(255) NOT NULL,
  `location3` varchar(255) NOT NULL,
  `description3` longtext NOT NULL,
  `title4` varchar(255) NOT NULL,
  `date4` varchar(255) NOT NULL,
  `location4` varchar(255) NOT NULL,
  `description4` longtext NOT NULL,
  `title5` varchar(255) NOT NULL,
  `date5` varchar(255) NOT NULL,
  `location5` varchar(255) NOT NULL,
  `description5` longtext NOT NULL,
  `title6` varchar(255) NOT NULL,
  `date6` varchar(255) NOT NULL,
  `location6` varchar(255) NOT NULL,
  `description6` longtext NOT NULL,
  `advertisement` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `editorials_highlights`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_highlights`;
CREATE TABLE `editorials_highlights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `content` longtext,
  `advertisement` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `editorials_news`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_news`;
CREATE TABLE `editorials_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `title1` varchar(255) NOT NULL,
  `description1` longtext NOT NULL,
  `title2` varchar(255) NOT NULL,
  `description2` longtext NOT NULL,
  `title3` varchar(255) NOT NULL,
  `description3` longtext NOT NULL,
  `title4` varchar(255) NOT NULL,
  `description4` longtext NOT NULL,
  `title5` varchar(255) NOT NULL,
  `description5` longtext NOT NULL,
  `title6` varchar(255) NOT NULL,
  `description6` longtext NOT NULL,
  `advertisement` longtext,
  `opportunities` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `editorials_newsletters`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_newsletters`;
CREATE TABLE `editorials_newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `intro` longtext,
  `facebook_like` varchar(255) DEFAULT NULL,
  `facebook_description` longtext,
  `advertisement` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `editorials_outros`
-- ----------------------------
DROP TABLE IF EXISTS `editorials_outros`;
CREATE TABLE `editorials_outros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editorial_id` int(11) NOT NULL,
  `outro` longtext,
  `footer` longtext,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `events`
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `edition_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `start` date NOT NULL,
  `stime` time NOT NULL,
  `etime` time DEFAULT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lon` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `highlight` tinyint(1) NOT NULL DEFAULT '0',
  `weekly` tinyint(1) NOT NULL DEFAULT '0',
  `picturen` varchar(255) NOT NULL,
  `picturet` varchar(255) NOT NULL,
  `pictures` int(11) NOT NULL,
  `pictured` longblob NOT NULL,
  `draft` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


-- ----------------------------
--  Table structure for `extras`
-- ----------------------------
DROP TABLE IF EXISTS `extras`;
CREATE TABLE `extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `groups`
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `groups`
-- ----------------------------
BEGIN;
INSERT INTO `groups` VALUES ('1', 'Administrators', '2012-10-22 15:31:09', '2012-10-22 15:31:09'), ('2', 'Power Users', '2012-10-22 15:31:09', '2012-10-22 15:31:09'), ('3', 'Users', '2012-10-22 15:31:09', '2012-10-22 15:31:09');
COMMIT;

-- ----------------------------
--  Table structure for `scrapbook_events`
-- ----------------------------
DROP TABLE IF EXISTS `scrapbook_events`;
CREATE TABLE `scrapbook_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `start` date NOT NULL,
  `stime` time NOT NULL,
  `etime` time DEFAULT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lon` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `highlight` tinyint(1) NOT NULL DEFAULT '0',
  `picturen` varchar(255) NOT NULL,
  `picturet` varchar(255) NOT NULL,
  `pictures` int(11) NOT NULL,
  `pictured` longblob NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `submitted_events`
-- ----------------------------
DROP TABLE IF EXISTS `submitted_events`;
CREATE TABLE `submitted_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `start` date NOT NULL,
  `stime` time NOT NULL,
  `etime` time DEFAULT NULL,
  `summary` text NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` char(40) NOT NULL,
  `group_id` int(11) NOT NULL,
  `token` char(40) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'antenna', 'getantenna@getantenna.com', 'Antenna', 'Get Antenna', '91ba4686df7f05e2ea9ab087d67442a3405afcbb', '1', '6a4986055f6ba1c2971ffce41786c0687ff0b4b8', '0', '2012-10-22 15:31:09', '2012-10-22 16:26:50');
COMMIT;

-- ----------------------------
--  Table structure for `weekly_events`
-- ----------------------------
DROP TABLE IF EXISTS `weekly_events`;
CREATE TABLE `weekly_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `start` date NOT NULL,
  `stime` time NOT NULL,
  `etime` time DEFAULT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lon` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `pick` tinyint(1) NOT NULL DEFAULT '0',
  `picturen` varchar(255) NOT NULL,
  `picturet` varchar(255) NOT NULL,
  `pictures` int(11) NOT NULL,
  `pictured` longblob NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
